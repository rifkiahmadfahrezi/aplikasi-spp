<?php 
require_once("App.php");

class Classes extends App{

	public function addClass($data){
		global $conn;

		$namaKelas = $conn->real_escape_string(htmlspecialchars($data['nama-kelas'],ENT_QUOTES,'UTF-8'));
		$kompKeahlian = $conn->real_escape_string(htmlspecialchars($data['komp-keahlian'],ENT_QUOTES,'UTF-8'));;

		// Cek jika value kosong
		if ($namaKelas == '' || $kompKeahlian == '') {
			return false;
		}

		// cek jika kelas sudah tersedia
		$check = $conn->query("SELECT nama_kelas FROM kelas WHERE nama_kelas = '$namaKelas'");

		if ($check->num_rows > 0) {
			$_SESSION['status'] = "tersedia";
			return false;
		}


		$stmt = $conn->prepare("INSERT INTO `kelas`(`nama_kelas`, `kompetensi_keahlian`) VALUES (?,?)");
		$stmt->bind_param("ss",$namaKelas,$kompKeahlian);
		$queryRun = $stmt->execute();

		if ($queryRun) {
			$_SESSION['status'] = "ditambah";
			header("Location: data-kelas");
		}else{
			$_SESSION['status'] = "gagal ditambah";
			header("Location: data-kelas");
			die($conn->error);
			return false;
		}

	}

	public function deleteClass($target){
		global $conn;

		$id = addslashes($target['id']);

		$query = "DELETE FROM kelas WHERE id_kelas = '$id'";
		$queryRun = $conn->query($query);

		if ($query) {
			$_SESSION['status'] = "dihapus";
			header("Location: data-kelas");
		}else{
			$_SESSION['status'] = "gagal dihapus";
			header("Location: data-kelas");
			return false;
		}
	}

	public function updateClass($data){
		global $conn;

		$id = $data['id_kelas'];
		$currentClassName = $data['currentClassName'];
		$namaKelas = $conn->real_escape_string(htmlspecialchars($data['nama-kelas'],ENT_QUOTES,'UTF-8'));
		$kompKeahlian = $conn->real_escape_string(htmlspecialchars($data['komp-keahlian'],ENT_QUOTES,'UTF-8'));;
		// cek jika kelas sudah tersedia
		// cek nisn dan nis jika sama dengan milik siswa lain
		$getClassName = $conn->query("SELECT nama_kelas FROM kelas WHERE nama_kelas != '$currentClassName'");


		while ($row = $getClassName->fetch_assoc()) {
			if ($namaKelas == $row['nama_kelas']) {
				$_SESSION['status'] = 'tersedia';
				return false;
			}

		}
		$stmt = $conn->prepare("UPDATE kelas SET nama_kelas = ?, kompetensi_keahlian = ? WHERE id_kelas = '$id'");
		$stmt->bind_param("ss",$namaKelas,$kompKeahlian);
		$queryRun = $stmt->execute();

		if ($queryRun) {
			$_SESSION['status'] = "diubah";
			header("Location: data-kelas");
		}else{
			$_SESSION['status'] = "gagal diubah";
			return false;
		}
	}
}

$class = new Classes();