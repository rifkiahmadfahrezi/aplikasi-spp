<?php 
require("../app/core/App.php");

// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}



$username = addslashes($_GET['user']);

if ($_SESSION['username'] != $username) {
  die("Bukan akun anda");
}

$getDataUser = $conn->query("SELECT * FROM petugas WHERE username = '$username'");

$dataUser = $getDataUser->fetch_assoc();

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
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Profile <?= $dataUser['username'] ?> - Aplikasi SPP</title>
  </head>
  <body>
  	 <nav class="navbar navbar-light nav-primary">
      <div class="container">
        <span class="navbar-brand mb-0 h1 text-white">SPP</span>

        <span class="text-white" ><?= $dataUser['username'] ?></span>

      </div>
    </nav>

    <?php if (isset($_SESSION['status'])): ?>
        <?php 
          if ($_SESSION['status'] == 'berhasil'){
            echo "<script>
                    Swal.fire({
                      title: 'Berhasil',
                      text: 'Password berhasil diubah',
                      icon: 'success',
                      confirmButtonColor :'#2b2f78'
                  })
                  </script>";  
              unset($_SESSION['status']);
          }

         ?>
    <?php endif ?>

    <div class="container my-5">
    	<div class="card shadow">
    		<div class="card-body">
    			<div class="d-flex flex-column">
		    		<span class="mb-1">Nama : <?= $dataUser['nama_petugas'] ?></span>
		    		<span class="mb-1">Username : <?= $dataUser['username'] ?></span>
		    		<span class="mb-1">Level : <?= $dataUser['level'] ?></span>
		    	</div>
    		</div>
	    	<div class="card-footer d-flex justify-content-between">
	    		<a href="dashboard" class="btn btn-secondary">Kembali</a>
	    		<a class="btn btn-primary" href="ubah-password.php?user=<?= $dataUser['username'] ?>">Ubah Password</a>
	    	</div>
    	</div>
    </div>

    <script defer src="src/payment.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>