<?php  
require("../app/core/Officer.php");

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
$jmlAdmin = $conn->query("SELECT COUNT(*) AS jml_admin FROM petugas WHERE level = 'admin'")->fetch_assoc()['jml_admin'];
$jmlPetugas = $conn->query("SELECT COUNT(*) AS jml_petugas FROM petugas WHERE level = 'petugas'")->fetch_assoc()['jml_petugas'];

$total = $jmlAdmin + $jmlPetugas;
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
	<title>Print data petugas</title>
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
		
	<h2 class="my-3">Data petugas</h2>

	<div class="d-flex flex-column mb-3">
		<span>Jumlah admin : <?= $jmlAdmin ?></span>
		<span>Jumlah petugas : <?= $jmlPetugas ?></span>
		<span>Total : <?= $total ?></span>
	</div>

	<div class="table-responsive">
        <table class="table">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama petugas</th>
              <th>Username</th>
              <th>Level</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1  ?>
              <?php while($row = $petugas->fetch_assoc()): ?>
                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $row['nama_petugas'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['level'] ?></td>
                  </tr> 
              <?php $no++ ?>
            <?php endwhile ?>
            <?php 
              if ($petugas->num_rows == 0) {
                echo "<tr><td colspan='5' class='text-center text-secondary'>Belum ada data untuk ditampilkan</td></tr>";
              }
             ?>
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