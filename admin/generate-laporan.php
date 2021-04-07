<?php  
require("../app/core/Payment.php");

// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}

$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
if ($officerData['level'] == 'petugas') {
  include '../error/403.html';
  die;
}


$getDataPembayaran = $conn->query("SELECT * FROM pembayaran");

$pendapatan= "";



$totalPendapatan = $conn->query("SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
$total = $totalPendapatan->fetch_assoc()['total'];
  
$sql = $conn->query("SELECT tahun_dibayar,SUM(jumlah_bayar) AS jml FROM pembayaran GROUP BY tahun_dibayar");


$getpendapatan = $conn->query("SELECT SUM(jumlah_bayar) AS total FROM pembayaran GROUP BY tahun_dibayar");

$getTahun = $conn->query("SELECT tahun_dibayar FROM pembayaran GROUP BY tahun_dibayar");


while($row = $getpendapatan->fetch_assoc()){
  $pendapatan = $pendapatan .'"'. $row['total'].'",';
}

$tahun = "";

while($row = $getTahun->fetch_assoc()){
  $tahun = $tahun .'"'. $row['tahun_dibayar'].'",';
}

$pendapatan = trim($pendapatan,",");
$tahun = trim($tahun,",");

$groupPendapatan = $conn->query("SELECT tahun_dibayar, SUM(jumlah_bayar) AS jml FROM pembayaran GROUP BY tahun_dibayar");



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
    <!-- chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<title>Laporan pembayaran</title>
</head>
<body>
  <style>
  @media print{
    body{
      -webkit-print-color-adjust: exact;
    }

  }
</style>
	<div class="container">
		
	<h2 class="my-3">Laporan pembayaran</h2>

  <div class="d-flex flex-column mb-5">
    <?php while($row = $groupPendapatan->fetch_assoc()): ?>
      <span><?= $row['tahun_dibayar'] ?> : Rp. <?= number_format($row['jml'],0,',','.') ?></span>
    <?php endwhile ?>

    <span class="mt-2">Total pendapatan : Rp. <?= number_format($total, 0, ',', '.') ?></span>
  </div>

  <canvas id="chart"></canvas>

</div>
<script>
const ctx = document.getElementById('chart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $tahun ?>],
        datasets: [{
            label: 'Pemasukkan',
            data: [<?php echo $pendapatan ?>],
            backgroundColor: ['#6468a1'
            ],
            borderColor: ['#2b2f78'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
	window.addEventListener('load', () => {
		window.print()
	})
</script>
</body>
</html>