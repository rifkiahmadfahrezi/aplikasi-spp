<?php 
require("../app/core/Officer.php");

$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);
if ($officerData['level'] == 'petugas') {
  include '../error/403.html';
  die;
}

// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}

if (isset($_POST['update'])) {
  $officer->updateOfficer($_POST);
}
$id = $_GET['id'];
$getPetugas = $conn->query("SELECT * FROM petugas WHERE id_petugas = '$id'");
$petugas = $getPetugas->fetch_assoc();

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
    <title>Update data petugas - Aplikasi SPP</title>
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
      <a class="nav-link" href="data-petugas"><span class="d-flex align-items-center active"><i class="fa fa-user me-2"></i> Data petugas</span></a>
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

   <section id="add-officer" class="mx-3">
     
    <h2 class="my-3">Update data petugas</h2>

    <?php 
      if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == 'tersedia') {
            echo "<script>
                Swal.fire({
                  title: 'Username sudah digunakan',
                  text: 'username {$_POST['username']} sudah digunakan',
                  icon: 'warning',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'gagal diubah') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'Data gagal diubah',
                  icon: 'error',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
              unset($_SESSION['status']);
          }
      }
     ?>

    <form action="" method="post" class="my-3">
      <input type="hidden" value="<?= $petugas['id_petugas']  ?>" name="id">

    	<label for="nama" class="mb-2">Nama petugas</label>
    	<input type="text" value="<?= $petugas['nama_petugas'] ?>" autocomplete="off" name="nama" id="nama" class="form-control mb-3" required>

    	<label for="username" class="mb-2">Username</label>
    	<input type="text" value="<?= $petugas['username'] ?>" autocomplete="off" name="username" id="username" class="form-control mb-3" required>

    	<label for="Level" class="mb-2">Level</label>
    	<select name="level" id="level" required class="form-select mb-3">
        <option value="<?= $petugas['level'] ?>"selected><?= $petugas['level'] ?></option>
    		<option value="petugas">Petugas</option>
    		<option value="admin">Admin</option>
    	</select>

    	<a href="data-petugas" class="btn btn-secondary">Kembali</a>
    	<button name="update" type="submit" class="btn me-3 btn-primary">Update</a>
    </form>
    
   </section>


  </main>


    <script src="assets/js/main.js"></script>
    <script defer src="src/officer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>