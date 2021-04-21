<?php  
require("../app/core/SPP.php");


// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}
$dataSpp = $conn->query("SELECT * FROM spp");

$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
if ($officerData['level'] == 'petugas') {
  include '../error/403.html';
  die;
}
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
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Data SPP - Aplikasi SPP</title>
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


    <a class="nav-link" href="dashboard"><i class="fa fa-qrcode me-2"></i>Dashboard</a>
    <a class="nav-link" href="pembayaran"><span><i class="fa fa-money-check-alt me-2"></i>Pembayaran</span> </a>
    <?php if ($levelUser == 'admin'): ?>
      <a class="nav-link" href="data-petugas"><span class="d-flex align-items-center"><i class="fa fa-user me-2"></i> Data petugas</span></a>
      <a class="nav-link" href="data-siswa"><span class="d-flex align-items-center"><i class="fa fa-users me-2"></i> Data siswa</span></a>
      <a class="nav-link" href="data-kelas"><span class="d-flex align-items-center"><i class="fa fa-school me-2"></i> Data kelas</span></a>
      <a class="nav-link active" href="data-spp"><span class="d-flex align-items-center"><i class="fa fa-university me-2"></i> Data SPP</span></a>
    <?php endif ?>
    <a class="nav-link" href="history-pembayaran"><span class="d-flex align-items-center"><i class="fa fa-history me-2"></i> History pembayaran</span></a>
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

   <section id="officer-list" class="mx-3">
     
    <div class="my-3 mb-5">
        <h2>Daftar SPP</h2>
   </div>

     <?php 
        if (isset($_SESSION['status'])) {
          if ($_SESSION['status'] == 'dihapus') {
            echo "<script>
            		Swal.fire({
            			title: 'Berhasil',
            			text: 'Data SPP berhasil dihapus',
            			icon: 'success'
            			})
            	  </script>";
            unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'gagal dihapus') {
            echo "<script>
            		Swal.fire({
            			title: 'Gagal',
            			text: 'Data SPP gagal dihapus',
            			icon: 'error'
            			})
            	  </script>";;
              unset($_SESSION['status']);
          }
        }
       ?>
       <?php 
        if (isset($_SESSION['status'])) {
          if ($_SESSION['status'] == 'diubah') {
            echo "<script>
            		Swal.fire({
            			title: 'Berhasil',
            			text: 'Data SPP berhasil diubah',
            			icon: 'success',
            			confirmButtonColor :'#2b2f78'
            			})
            	  </script>";
            unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'gagal diubah') {
            echo "<script>
            		Swal.fire({
            			title: 'Gagal',
            			text: 'Data SPP gagal diubah',
            			icon: 'error',
            			confirmButtonColor :'#2b2f78'
            			})
            	  </script>";
              unset($_SESSION['status']);
          }
        }
       ?>

    <div class="row">
      <div class="col">
        <a href="tambah-spp" class="btn btn-primary =">Tambah</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Tahun</th>
            <th>Nominal</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1  ?>
            <?php while($row = $dataSpp->fetch_assoc()): ?>
              <tr class="text-center">
                <td><?= $no ?></td>
                <td><?= $row['tahun'] ?></td>
                <td>Rp. <?= number_format($row['nominal'] , 0, ',', '.'); ?></td>
                <td>
          <a id="delete-btn" title="Hapus" href="hapus-spp.php?id=<?= $row['id_spp'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
        
          <a title="Ubah" href="update-spp.php?id=<?= $row['id_spp'] ?>" class="btn btn-success"><i class="fa fa-pencil-alt"></i></a>
                </td>
              </tr>
            <?php $no++  ?>
          <?php endwhile ?>
        </tbody>
      </table>
    </div>

   </section>


  </main>


    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>