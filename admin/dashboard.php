<?php 
require("../app/core/App.php");

// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}



$jmlAdmin = $conn->query("SELECT COUNT(*) AS jml_admin FROM petugas WHERE level = 'admin'");
$jmlPetugas = $conn->query("SELECT COUNT(*) AS jml_petugas FROM petugas WHERE level = 'petugas'");
$jmlSiswa = $conn->query("SELECT COUNT(*) AS jml_siswa FROM siswa");
$jmlKelas = $conn->query("SELECT COUNT(*) AS jml_kelas FROM kelas");

$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- mycss -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Dashboard - Aplikasi SPP</title>
  </head>
  <body>


  <div class="preloader">
     <div class="spinner-container">
       <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
       </div>
     </div>
  </div>

  <aside class="nav flex-column">

    <div class="header-sidebar text-center">
      <div class="title">
         <h2>Aplikasi SPP</h2>
        <h4>Tarpan One</h4>
      </div>
    </div>


    <a class="nav-link active" href="dashboard"><i class="fa fa-qrcode me-2"></i>Dashboard</a>
    <a class="nav-link" href="pembayaran"><span><i class="fa fa-money-check-alt me-2"></i>Pembayaran</span> </a>
    <?php if ($levelUser == 'admin'): ?>
      <a class="nav-link" href="data-petugas"><span class="d-flex align-items-center"><i class="fa fa-user me-2"></i> Data petugas</span></a>
      <a class="nav-link" href="data-siswa"><span class="d-flex align-items-center"><i class="fa fa-users me-2"></i> Data siswa</span></a>
      <a class="nav-link" href="data-kelas"><span class="d-flex align-items-center"><i class="fa fa-school me-2"></i> Data kelas</span></a>
      <a class="nav-link" href="data-spp"><span class="d-flex align-items-center"><i class="fa fa-university me-2"></i> Data SPP</span></a>
    <?php endif ?>
      <a class="nav-link" href="history-pembayaran"><span class="d-flex align-items-center"><i class="fa fa-history me-2"></i>History pembayaran</span></a>
  </aside>

  <main>

   <nav class="navbar shadow-sm">
     <span id="navbar-toggler" class="ms-2">
       <span class="fa fa-bars"></span>
     </span>

     <div class="dropdown me-2">
        <span class="dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
         <?= $officerData['username'] ?>
        </span>

        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="profile.php?user=<?= $officerData['username'] ?>">Profile</a></li>
          <li><a class="dropdown-item" href="logout">Logout</a></li>
        </ul>
      </div>
   </nav>

    <h2 class="mx-3 mt-3 mb-5"><?= $app->greeting() .' '. $officerData['username'] .' :)' ?></h2>

   <section id="cards" class="mx-3 my-2 mt-3">
        
        <div class="card shadow-sm card-body">
          <h2><?= $jmlAdmin->fetch_assoc()['jml_admin'] ?></h2>
          <p>Jumlah admin</p>
        </div>

        <div class="card shadow-sm card-body">
          <h2><?= $jmlPetugas->fetch_assoc()['jml_petugas'] ?></h2>
          <p>Jumlah petugas</p>
        </div>

        <div class="card shadow-sm card-body">
          <h2><?= $jmlSiswa->fetch_assoc()['jml_siswa'] ?></h2>
          <p>Jumlah Siswa</p>
        </div>

        <div class="card shadow-sm card-body">
          <h2><?= $jmlKelas->fetch_assoc()['jml_kelas'] ?></h2>
          <p>Jumlah kelas</p>
        </div>

   </section>


  </main>


    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>