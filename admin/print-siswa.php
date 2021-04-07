<?php  
require("../app/core/Student.php");


// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}

$petugas = $conn->query("SELECT * FROM petugas");
// ambil level user
$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
if ($officerData['level'] == 'petugas') {
  include '../error/403.html';
  die;
}

$siswa = $conn->query("SELECT * FROM siswa");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- mycss -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap" rel="stylesheet">
	<title>Print data siswa</title>
</head>
<body>
<style>
	@media print{
		body{
			-webkit-print-color-adjust: exact;
		}
		table {
			  margin: 10px 0;
			  color: #2b2f78;
			}
			table tr {
			  padding: 4px 8px;
			}
			table tr:nth-child(even) {
			  background-color: #e1e2f4;
			}
			table thead {
			  background-color: #2b2f78;
			  color: white;
			}

	}
</style>		
<div class="container">

	<h2 class="my-3 mb-2">Daftar siswa</h2>

	<div class="d-flex flex-column mb-3">
		<span>Total siswa : <?= $siswa->num_rows ?></span>
	</div>

	<div class="table-responsive">
		<table class="table">
		  <thead>
		    <tr class="text-center">
		      <th>No</th>
		      <th>NISN</th>
		      <th>NIS</th>
		      <th>Nama</th>
		      <th>Kelas</th>
		      <th>Alamat</th>
		      <th>Nomor Telp</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php $no = 1 ?>
		      <?php while($row = $siswa->fetch_assoc()): ?>
		        <tr class="text-center">
		          <td><?= $no ?></td>
		          <td><?= $row['nisn'] ?></td>
		          <td><?= $row['nis'] ?></td>
		          <td><?= $row['nama'] ?></td>
		          <td><?= $student->getClassName($row['id_kelas']) ?></td>
		          <td><?= $student->isEmpty($row['alamat']) ?></td>
		          <td><?= $student->isEmpty($row['no_telp']) ?></td>
		        </tr>
		      <?php $no++ ?>
		    <?php endwhile ?>
		  </tbody>
		</table>
	</div>
 </div>
 <script>
 	window.addEventListener('load', () => {
 		window.print()
 	})
 </script>
</body>
</html>