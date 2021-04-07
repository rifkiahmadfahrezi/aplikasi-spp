<?php  
require("../app/core/Class.php");

// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}

// ambil level user
$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
if ($officerData['level'] == 'petugas') {
  include '../error/403.html';
  die;
}


$kelas = $conn->query("SELECT * FROM kelas");

$groupKelas = $conn->query("SELECT kompetensi_keahlian,COUNT(kompetensi_keahlian) AS kelas FROM kelas GROUP BY kompetensi_keahlian");



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
	<title>Print data kelas</title>
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
		
	<h2 class="my-3">Data kelas</h2>

	<div class="d-flex flex-column mb-3">
    <?php while($row = $groupKelas->fetch_assoc()): ?>
        <span><?= $row['kompetensi_keahlian'] ?> : <?= $row['kelas'] ?></span>
    <?php endwhile ?>
    <span class="mt-3">Total jumlah kelas : <?= $kelas->num_rows ?></span>
	</div>

	<div class="table-responsive">
        <table class="table">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama kelas</th>
              <th>Kempetensi keahlian</th>
              <th>Jumlah siswa</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1  ?>
              <?php while($row = $kelas->fetch_assoc()): ?>
                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $row['nama_kelas'] ?></td>
                    <td><?= $row['kompetensi_keahlian'] ?></td>
                    <?php 
                    $getJmlSiswa = $conn->query("SELECT COUNT(*) AS jml_siswa FROM siswa WHERE id_kelas = '{$row['id_kelas']}'");
                     ?>
                     <td><?= $getJmlSiswa->fetch_assoc()['jml_siswa'] ?></td>
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