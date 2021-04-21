<?php  
require("../app/core/App.php");

if (!$_SESSION['login']) {
  header("Location: ../");
}

$petugas = $conn->query("SELECT * FROM petugas");
// cek status login
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
    <title>Data Petugas - Aplikasi SPP</title>
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
      <a class="nav-link active" href="data-petugas"><span class="d-flex align-items-center"><i class="fa fa-user me-2"></i> Data petugas</span></a>
      <a class="nav-link" href="data-siswa"><span class="d-flex align-items-center"><i class="fa fa-users me-2"></i> Data siswa</span></a>
      <a class="nav-link" href="data-kelas"><span class="d-flex align-items-center"><i class="fa fa-school me-2"></i> Data kelas</span></a>
      <a class="nav-link" href="data-spp"><span class="d-flex align-items-center"><i class="fa fa-university me-2"></i> Data SPP</span></a>
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
     
   <div class="my-3 mb-5 d-flex align-items-center justify-content-between">
        <h2>Daftar petugas</h2>
       <a href="print-petugas" target="_blank" class="btn-primary btn btn-sm"><i class="fa fa-print"></i> Print</a>
   </div>

    <?php 
        if (isset($_SESSION['status'])) {
          if ($_SESSION['status'] == 'dihapus') {
            echo "<script>
                Swal.fire({
                  title: 'Berhasil',
                  text: 'Data berhasil dihapus',
                  icon: 'success',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
            unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'gagal dihapus') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'Data gagal dihapus',
                  icon: 'error',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'diubah') {
            echo "<script>
                Swal.fire({
                  title: 'Berhasil',
                  text: 'Data berhasil diubah',
                  icon: 'success',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
            unset($_SESSION['status']);
          }
        }
       ?>

    <div class="row">
      <div class="col">
        <a href="tambah-petugas" class="btn btn-primary =">Tambah</a>
      </div>
      <div class="col">
       <div class="input-group">
        <input type="search" id="cari-petugas" class="form-control" placeholder="Cari data petugas..." aria-describedby="basic-addon2">
        <button type="button" class="btn btn-primary input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
      </div>
      </div>
    </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama petugas</th>
              <th>Username</th>
              <th>Level</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1  ?>
              <?php while($row = $petugas->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $row['nama_petugas'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['level'] ?></td>
                    <td>
                      <?php if ($row['username'] != $officerData['username'] ): ?>
                        <a id="delete-btn" title="Hapus" class="btn btn-danger" href="hapus-petugas.php?id=<?= $row['id_petugas'] ?>"><i class="fa fa-trash"></i></a>
                      <?php endif ?>
                      <a title="Edit" class="btn btn-success" href="update-petugas.php?id=<?= $row['id_petugas'] ?>"><i class="fa fa-pencil-alt"></i></a>
                    </td>
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

   </section>


  </main>


    <script src="assets/js/main.js"></script>
    <script src="src/search-officer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>