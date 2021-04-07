<?php
require_once("App.php");

class Officer extends App{
	public function addOfficer($data){
		global $conn;

		$nama = $conn->real_escape_string(htmlspecialchars($data['nama'],ENT_QUOTES,'UTF-8'));
		$username = $conn->real_escape_string(htmlspecialchars($data['username'],ENT_QUOTES,'UTF-8'));
		$password = $conn->real_escape_string(htmlspecialchars(strtolower($data['password']) ,ENT_QUOTES,'UTF-8'));
		$level = $conn->real_escape_string(htmlspecialchars($data['level'],ENT_QUOTES,'UTF-8'));

		$password = password_hash($password, PASSWORD_DEFAULT);

		// cek apakah username sudah digunakan atau belum
		$getExistusername = $conn->query("SELECT username FROM petugas");


		while ($row = $getExistusername->fetch_assoc()) {
			if ($username == $row['username'] ) {
				$_SESSION['status'] = 'tersedia';
				return false;
			}

		}

		$stmt = $conn->prepare("INSERT INTO `petugas`(`username`, `password`, `nama_petugas`, `level`) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss",$username,$password,$nama,$level);
		$queryRun = $stmt->execute();

		if($queryRun){
			$_SESSION['status'] = 'ditambah';
		}else{
			$_SESSION['status'] = 'gagal ditambah';
			return false;
		}
	}

	public function deleteOfficer($target){
		global $conn;

		$id = $target['id'];

		$query = "DELETE FROM petugas WHERE id_petugas = '$id'";
		$queryRun = $conn->query($query);

		if ($queryRun) {
			$_SESSION['status'] = 'dihapus';
			header("Location: data-petugas");
		}else{
			$_SESSION['status'] = 'gagal dihapus';
			header("Location: data-petugas");
			return false;
		}
	}

	public function updateOfficer($data){
		global $conn;

		$id = $data['id'];
		$nama = $conn->real_escape_string(htmlspecialchars($data['nama'],ENT_QUOTES,'UTF-8'));
		$username = $conn->real_escape_string(htmlspecialchars($data['username'],ENT_QUOTES,'UTF-8'));
		$level = $conn->real_escape_string(htmlspecialchars($data['level'],ENT_QUOTES,'UTF-8'));

		// cek apakah username sudah digunakan atau belum
		$getUsername = $conn->query("SELECT username FROM petugas WHERE username = '$username' AND id_petugas != '$id'");

		if ($getUsername->num_rows > 0) {
			$_SESSION['status'] = 'tersedia';
			return false;
		}

		$stmt = $conn->prepare("UPDATE `petugas` SET `nama_petugas` = ?, `username` = ?, `level` = ? WHERE id_petugas = '$id'");
		$stmt->bind_param("sss",$nama,$username,$level);
		$queryRun = $stmt->execute();

		if ($queryRun) {
			$_SESSION['status'] = 'diubah';
			header("Location: data-petugas");
		}else{
			$_SESSION['status'] = 'gagal diubah';
			return false;
		}

	}

}

$officer = new Officer();