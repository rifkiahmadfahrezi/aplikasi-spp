<?php
require_once("App.php");

class Student extends App{

	public function addStudent($data){
		global $conn;

		$nisn = $conn->real_escape_string(htmlspecialchars($data['nisn'],ENT_QUOTES,'UTF-8'));
		$nis = $conn->real_escape_string(htmlspecialchars($data['nis'],ENT_QUOTES,'UTF-8'));
		$nama = $conn->real_escape_string(htmlspecialchars($data['nama'],ENT_QUOTES,'UTF-8'));
		$kelas = $conn->real_escape_string(htmlspecialchars($data['kelas'],ENT_QUOTES,'UTF-8'));
		$tahunSpp = $conn->real_escape_string(htmlspecialchars($data['tahun-spp'],ENT_QUOTES,'UTF-8'));
		$alamat = $conn->real_escape_string(htmlspecialchars($data['alamat'],ENT_QUOTES,'UTF-8'));
		$nomorTelp = $conn->real_escape_string(htmlspecialchars($data['no-telp'],ENT_QUOTES,'UTF-8'));
		// cek jika nis atau nisn sudah ada
		$getNisn = $conn->query("SELECT nisn,nis FROM siswa WHERE nisn = '$nisn' OR nis = '$nis'");
		if($getNisn->num_rows > 0){
			$_SESSION['status'] = 'tersedia';
			return false;
		}


		// ambil id kelas berdasarkan nama kelas yg dipilih
		$getIdKelas = $conn->query("SELECT id_kelas FROM kelas WHERE nama_kelas = '$kelas'");
		$idKelas = $getIdKelas->fetch_assoc();
		$idKelas = $idKelas['id_kelas'];
		// ambil id spp berdasarkan tahun yg dipilih
		$getIdSpp = $conn->query("SELECT id_spp FROM spp WHERE tahun = '$tahunSpp'");
		$idSpp = $getIdSpp->fetch_assoc();
		$idSpp = $idSpp['id_spp'];
		
		$stmt = $conn->prepare("INSERT INTO `siswa`(`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`,`id_spp`) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssss",$nisn,$nis,$nama,$idKelas,$alamat,$noTelp,$idSpp);
		$queryRun = $stmt->execute();

		if ($queryRun) {
			$_SESSION['status'] = 'ditambah';
		}else{
			$_SESSION['status'] = 'gagal ditambah';
			var_dump($conn->error);
			die;
			return false;
		}

	}	


	public function deleteStudent($target){
		global $conn;

		$nisn = $target['nisn'];
		$query = "DELETE FROM siswa WHERE nisn = '$nisn'";
		$queryRun = $conn->query($query);

		if ($queryRun) {
			$_SESSION['status'] = 'dihapus';
			header("Location: data-siswa");
		}else{
			$_SESSION['status'] = 'gagal dihapus';
			header("Location: data-siswa");
			die;
		}
	}

	public function getClassName($id){
		global $conn;


		$getNamaKelas = $conn->query("SELECT nama_kelas FROM kelas WHERE id_kelas ='$id'");
		$namaKelas = $getNamaKelas->fetch_assoc();

		return $namaKelas['nama_kelas'];
	}

	public function getClassId($namaKelas){
		global $conn;


		$getIdKelas = $conn->query("SELECT id_kelas FROM kelas WHERE nama_kelas LIKE '%$namaKelas%'");
		$idKelas = $getIdKelas->fetch_assoc();

		return $idKelas['id_kelas'];
	}

	public function getTahunSpp($id){
		global $conn;


		$getTahun = $conn->query("SELECT tahun FROM spp WHERE id_spp ='$id'");
		$tahun = $getTahun->fetch_assoc();

		return $tahun['tahun'];
	}

	public function isEmpty($str){
		if ($str == '') {
			return "<span class='text-secondary'>Kosong</span>";
		}else{
			return $str;
		}
	}

	public function updateStudent($data){
		global $conn;

		$currentNisn = $conn->real_escape_string($data['currentNisn']);
		$currentNis = $conn->real_escape_string($data['currentNis']);

		$id = $data['nisn'];
		$nisn = $conn->real_escape_string(htmlspecialchars($data['nisn'],ENT_QUOTES,'UTF-8'));
		$nis = $conn->real_escape_string(htmlspecialchars($data['nis'],ENT_QUOTES,'UTF-8'));
		$nama = $conn->real_escape_string(htmlspecialchars($data['nama'],ENT_QUOTES,'UTF-8'));
		$kelas = $conn->real_escape_string(htmlspecialchars($data['kelas'],ENT_QUOTES,'UTF-8'));
		$tahunSpp = $conn->real_escape_string(htmlspecialchars($data['tahun-spp'],ENT_QUOTES,'UTF-8'));
		$alamat = $conn->real_escape_string(htmlspecialchars($data['alamat'],ENT_QUOTES,'UTF-8'));
		$nomorTelp = $conn->real_escape_string(htmlspecialchars($data['no-telp'],ENT_QUOTES,'UTF-8'));
		


		// cek nisn dan nis jika sama dengan milik siswa lain
		$getNis = $conn->query("SELECT nisn,nis FROM siswa WHERE nisn != '$currentNisn' OR nis != '$currentNis'");


		while ($row = $getNis->fetch_assoc()) {
			if ($nisn == $row['nisn'] || $nis == $row['nis']) {
				$_SESSION['status'] = 'digunakan';
				return false;
			}

		}

		// ambil id kelas berdasarkan nama kelas yg dipilih
		$getIdKelas = $conn->query("SELECT id_kelas FROM kelas WHERE nama_kelas = '$kelas'");
		$idKelas = $getIdKelas->fetch_assoc();
		$idKelas = $idKelas['id_kelas'];
		// ambil id spp berdasarkan tahun yg dipilih
		$getIdSpp = $conn->query("SELECT id_spp FROM spp WHERE tahun = '$tahunSpp'");
		$idSpp = $getIdSpp->fetch_assoc();
		$idSpp = $idSpp['id_spp'];
		
		

		$stmt = $conn->prepare("UPDATE `siswa` SET nisn = ?,nis = ?,nama = ?,id_kelas = ?,alamat = ?,no_telp = ?,id_spp = ? WHERE nisn = '$id'");
		$stmt->bind_param("sssssss",$nisn,$nis,$nama,$idKelas,$alamat,$noTelp,$idSpp);
		$queryRun = $stmt->execute();

		if ($queryRun) {
			$_SESSION['status'] = 'diubah';
			header("Location: data-siswa");
		}else{
			$_SESSION['status'] = 'gagal diubah';
			return false;
		}

	}
}

$student = new Student();