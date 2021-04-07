<?php 
require("Connection.php");

class App{


	public function login($data){
		global $conn;

		$username = $conn->real_escape_string(htmlspecialchars($data['username'],ENT_QUOTES,'UTF-8'));
		$password = $conn->real_escape_string(htmlspecialchars(strtolower($data['password']),ENT_QUOTES,'UTF-8'));

		// cek apakah username tersedia
		$stmt = $conn->prepare("SELECT username FROM petugas WHERE username = ?");
		$stmt->bind_param("s",$username);
		$result = $stmt->execute();
		$uname = $stmt->get_result();

		if ($uname->num_rows == 0) {
			echo "Username tidak terdaftar";
			return false;
		}

		// cek password
		$state = $conn->prepare("SELECT password FROM petugas WHERE username = ?");
		$state->bind_param("s",$username);
		$state->execute();
		$pw = $state->get_result();
		$hashedPassword = $pw->fetch_assoc()['password'];
		// verify password


		$verifyPassword = password_verify($password, $hashedPassword);

		if (!$verifyPassword) {
			echo "Password salah";
			return false;
		}else{


			$statement = $conn->prepare("SELECT level FROM petugas WHERE username = ?");
			$statement->bind_param("s",$username);
			$statement->execute();
			$lvl = $statement->get_result();

			$levelUser = $lvl->fetch_assoc()['level'];

			$_SESSION['login'] = true;
			$_SESSION['level'] = $levelUser;
			$_SESSION['username'] = $uname->fetch_assoc()['username'];
			echo "sukses";
		}
	}

	public function getOfficerInfo($username){
		global $conn;
		
		$getOfficerData = $conn->query("SELECT * FROM petugas WHERE username = '{$_SESSION['username']}'");
		$officerData  = $getOfficerData->fetch_assoc();
		return $officerData;
	}

	public function changePassword($pw){
		global $conn;

		$id = $pw['id'];
		$username = $pw['username'];


		$currentPassword = $conn->real_escape_string(strtolower(htmlspecialchars($pw['current-pw'],ENT_QUOTES,'UTF-8')));

		$newPassword = $conn->real_escape_string(htmlspecialchars(strtolower($pw['pw-new']),ENT_QUOTES,'UTF-8'));

		// verifikasi password
		$getPassword = $conn->query("SELECT password FROM petugas WHERE username = '$username'");
		$password = $getPassword->fetch_assoc()['password'];

		// cek password yg diinput dengan yg didatabase
		if (!password_verify($currentPassword, $password)) {
			$_SESSION['status'] = 'password salah';
			return false;
		}


		$state = $conn->prepare("UPDATE petugas SET password = ? WHERE id_petugas = ? AND username = ?");
		$state->bind_param("sis",password_hash($newPassword, PASSWORD_DEFAULT),$id,$username);
		$run = $state->execute();


		if ($run) {
			$_SESSION['status'] = 'berhasil';
			header("Location: profile.php?user={$username}");
		}else{
			$_SESSION['status'] = 'gagal';
			return false;
		}


	}

	public function greeting(){
		date_default_timezone_set('Asia/Jakarta');
		$jam = date("H:i");

		if ($jam > '05:00' && $jam < '10:00') {
			echo "Selamat pagi";
		}elseif ($jam > '10:00' && $jam < '15:00') {
			echo "Selamat siang";
		}elseif ($jam > '15:00' && $jam < '18:00') {
			echo "Selamat sore";
		}else{
			echo "Selamat malam";
		}
	}
}

$app = new App();