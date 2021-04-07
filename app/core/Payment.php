<?php
require_once("App.php");

class Payment extends App{

	public function Pay($data){
	  global $conn;

	  $id_petugas = $data['id_petugas'];
	  $nisn = $conn->real_escape_string($data['nisn']);
	  $tglBayar = $data['tgl-bayar'];
	  $bulanYgDibayar = $this->getBulanYangDibayar($data);
	  $tahunDibayar = $data['tahun-spp'];
	  if ($data['total'] != 0) {
	  	$jmlBayar = $data['total'] / count($bulanYgDibayar);
	  }else{
	  	$_SESSION['status'] = 'tidak boleh 0';
	  	return false;
	  }
	  $idSpp = $this->getIdSPP($data['tahun-spp']);

	  // cek nisn
	  $getNisn = $conn->query("SELECT nisn FROM siswa WHERE nisn = '$nisn'");
	  if ($getNisn->num_rows == 0) {
	  	$_SESSION['status'] = 'nisn tidak ada';
	  	return false;
	  }

	  // cek jika bulan pembayaran belum dipilih
	  if (count($bulanYgDibayar) == 0){ 
	  	$_SESSION['status'] = 'bulan belum dipilih';
	  	return false;
	  	die;
	  }




	  // cek jika bulan yang dipilih sudah dibayar
		$bulanYgSudahDibayar = [];
		$getBulanYangSudahDibayar = $conn->query("SELECT bulan_dibayar FROM pembayaran WHERE nisn = '$nisn' AND id_spp = '$idSpp'");  

		while ($row = $getBulanYangSudahDibayar->fetch_assoc()) {
			$bulanYgSudahDibayar[] = $row['bulan_dibayar'];
		}

	  foreach ($bulanYgDibayar as $key => $value) {
	  	if (in_array($value, $bulanYgSudahDibayar)) {
	  			$_SESSION['status'] = 'bulan yg dipilih sudah dibayar';
	  			$_SESSION['message'] = "SPP {$value} tahun {$this->getTahunSpp($idSpp)} sudah dibayar";
	  			return false;
			}

	   $query =  $conn->query("INSERT INTO `pembayaran`(`id_petugas`, `nisn`, `tgl_bayar`, `bulan_dibayar`, `tahun_dibayar`, `id_spp`, `jumlah_bayar`) VALUES ('$id_petugas','$nisn','$tglBayar','$value','$tahunDibayar','$idSpp','$jmlBayar')");
	  }

	  if ($query) {
	  	$_SESSION['jml'] = count($bulanYgDibayar);
	  	$_SESSION['status'] = 'berhasil';
	  }else{
	  	$_SESSION['status'] = 'gagal';
	  	return false;
	  }

	}

	// public function deleteData($target){
	// 	global $conn;

	// 	$query = $conn->query("DELETE FROM pembayaran WHERE id_pembayaran = '$target'");

	// 	if ($query) {
	// 		$_SESSION['status'] = 'dihapus';
	// 		header("Location: history-pembayaran");
	// 	}else{
	// 		$_SESSION['status'] = 'gagal dihapus';
	// 		header("Location: history-pembayaran");
	// 		return false;
	// 	}
	// }

	public function getBulanYangDibayar($bulan){
	  $bulanYgDibayar = [];

	  foreach ($bulan as $key => $value) {

	    if (substr($key, 0,5) == 'bulan') {
	      array_push($bulanYgDibayar, $value);
	    }
	  }
	  return $bulanYgDibayar;
	}

	public function getIdSPP($tahun){
		global $conn;


		$getIdSPP = $conn->query("SELECT id_spp FROM spp WHERE tahun = '$tahun'");
		$idSpp = $getIdSPP->fetch_assoc();

		return $idSpp['id_spp'];
	}

	public function getStudentName($nisn){
		global $conn;

		$getStudentName = $conn->query("SELECT nama FROM siswa WHERE nisn = '$nisn'");

		return $getStudentName->fetch_assoc()['nama'];
	}

	public function getTahunSpp($id){
		global $conn;


		$getTahun = $conn->query("SELECT tahun FROM spp WHERE id_spp ='$id'");
		$tahun = $getTahun->fetch_assoc();

		return $tahun['tahun'];
	}
	public function getNominal($tahun){
		global $conn;


		$getTahun = $conn->query("SELECT nominal FROM spp WHERE tahun ='$tahun'");
		$tahun = $getTahun->fetch_assoc();

		return $tahun['nominal'];
	}

	public function getpetugas($id){
		global $conn;

		$getpetugas = $conn->query("SELECT username,level FROM petugas WHERE id_petugas = '$id'");
		$petugas = "{$getpetugas->fetch_assoc()['username']}";

		return $petugas;

	}

	public function getPetugasName($id){
		global $conn;

		$getNamaPetugas = $conn->query("SELECT username FROM petugas WHERE id_petugas = '$id'");

		return $getNamaPetugas->fetch_assoc()['username'];
	}

	public function getNamaSiswa($nisn){
		global $conn;

		$getNamaSiswa = $conn->query("SELECT nama FROM siswa WHERE nisn = '$nisn'");

		return $getNamaSiswa->fetch_assoc()['nama'];
	}

	public function getClassName($id){
		global $conn;


		$getNamaKelas = $conn->query("SELECT nama_kelas FROM kelas WHERE id_kelas ='$id'");
		$namaKelas = $getNamaKelas->fetch_assoc();

		return $namaKelas['nama_kelas'];
	}
	// public function updatePaymentHistory($data){
	// 	global $conn;

	// 	$idPembayaran = $data['id_pembayaran'];
	// 	$nisn = $data['nisn'];
	// 	$tglBayar = $data['tgl-bayar'];
	// 	$bulan = $data['bulan'];
	// 	$jmlBayar = $data['jml-bayar'];

	// 	// cek nisn
	// 	  $getNisn = $conn->query("SELECT nisn FROM siswa WHERE nisn = '$nisn'");
	// 	  if ($getNisn->num_rows == 0) {
	// 	  	$_SESSION['status'] = 'nisn tidak terdaftar';
	// 	  	return false;
	// 	  }

	// 	$query = $conn->query("UPDATE pembayaran SET nisn = '$nisn', tgl_bayar = '$tglBayar', bulan_dibayar = '$bulan', jumlah_bayar = '$jmlBayar' WHERE id_pembayaran = '$idPembayaran'");

	// 	if ($query) {
	// 		$_SESSION['status'] = 'diubah';
	// 		header("Location: history-pembayaran");
	// 	}else{
	// 		$_SESSION['status'] = 'gagal diubah';
	// 	}
	// }
}

$payment = new Payment();