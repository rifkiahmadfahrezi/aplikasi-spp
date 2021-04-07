<?php 
require_once("App.php");

class SPP extends App{

	public function addData($data){
		global $conn;

		$tahun = $conn->real_escape_string(htmlspecialchars($data['tahun'],ENT_QUOTES,'UTF-8'));
		$nominal = $conn->real_escape_string(htmlspecialchars($data['nominal'],ENT_QUOTES,'UTF-8'));


		// cek jika tahun yg diinput sudah tersedia
		$check = $conn->query("SELECT tahun FROM spp WHERE tahun = '$tahun'");

		if ($check->num_rows > 0) {
			$_SESSION['status'] = "tersedia";
			return false;
		}



		$stmt = $conn->prepare("INSERT INTO `spp`(`tahun`, `nominal`) VALUES (?,?)");
		$stmt->bind_param("ss",$tahun,$nominal);
		$query = $stmt->execute();

		if ($query) {
			$_SESSION['status'] = "ditambah";
		}else{
			$_SESSION['status'] = "gagal ditambah";
			return false;
		}
	}

	public function deleteData($target){
		global $conn;

		$id = $target['id'];

		$stmt = $conn->prepare("DELETE FROM spp WHERE id_spp = ?");
		$stmt->bind_param("s",$id);

		$query = $stmt->execute();

		if ($query) {
			$_SESSION['status'] = "dihapus";
			header("Location: data-spp");
		}else{
			$_SESSION['status'] = "gagal dihapus";
			header("Location: data-spp");
			return false;
		}
	}

	public function updateSpp($data){
		global $conn;

		$id = $data['id'];
		$currentTahun = $data['currentTahun'];
		$tahun = $conn->real_escape_string(htmlspecialchars($data['tahun'],ENT_QUOTES,'UTF-8'));
		$nominal = $conn->real_escape_string(htmlspecialchars($data['nominal'],ENT_QUOTES,'UTF-8'));

		// cek jika tahun yg diinput sudah tersedia
		$check = $conn->query("SELECT tahun FROM spp WHERE tahun != '$currentTahun'");
		while ($row = $check->fetch_assoc()) {
			if ($tahun == $row['tahun']) {
				$_SESSION['status'] = 'tersedia';
				return false;
			}

		}

		$stmt = $conn->prepare("UPDATE spp SET tahun = ?, nominal = ? WHERE id_spp = ?");
		$stmt->bind_param("sss",$tahun,$nominal,$id);

		$query = $stmt->execute();

		
		if ($query) {
			$_SESSION['status'] = "diubah";
			header("Location: data-spp");
		}else{
			$_SESSION['status'] = "gagal diubah";
			header("Location: data-spp");
			return false;
		}

	}
}

$spp = new SPP();