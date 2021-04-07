<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- mycss -->
    <link rel="stylesheet" href="admin/assets/css/style.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Home - Aplikasi SPP</title>
  </head>
  <body>

    <nav class="navbar navbar-light nav-primary">
      <div class="container">
        <span class="navbar-brand mb-0 h1 text-white">SPP</span>

        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#modal-login">Login</button>

      </div>
    </nav>
  
    <div class="container my-5">
      <div class="card shadow">
        <div class="col-sm-12 d-flex justify-content-center">
          <div class="col-md-6">

            <div class="text-center my-3">
              <h2 class="fs-3">SMK Taruna Harapan 1 Cipatat</h2>
              <p>Cek pembayaran SPP</p>
            </div>

            <form action="" id="cek-pembayaran">
              <div class="input-group my-3">
                <input type="number" placeholder="NISN Kamu" name="nisn" class="form-control"aria-describedby="addon">
                <button type="submit" class="btn btn-primary" id="addon"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>

      <section id="payment-history" class="p-3 mt-5">
        
        </section>
      </div>
    </div>

    <?php 
      if (isset($_SESSION['error'])) {
        if ($_SESSION['error'] == 'tidak tersedia') {
          echo "<script>
                Swal.fire({
                    title: 'Username tidak terdaftar',
                    icon: 'error'
                  })
                </script>";
          unset($_SESSION['error']);
        }elseif ($_SESSION['error'] == 'password salah') {
          echo "<script>
                Swal.fire({
                    title: 'Password salah',
                    icon: 'error'
                  })
                </script>";
          unset($_SESSION['error']);
        }
      }
    ?>

    <div class="modal fade" id="modal-login" tabindex="-1" aria-labelledby="modal-loginLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-loginLabel">Login Petugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="form-login" class="form-group">
            <div class="my-2">
              <div id="error-message"></div>
              <label for="username">Username</label>
              <input type="text" autocomplete="username" class="form-control" id="username" name="username">
            </div>
              <label for="password" class="mt-3">Password</label>
            <div class="input-group mb-3">
              <input type="password" autocomplete="current-password" id="password" name="password" class="form-control"aria-describedby="addon">
              <span data-password="hide" id="password-hider" class="btn btn-primary" id="addon"><i class="fa fa-eye"></i></span>
            </div>

            <button type="submit" name="login" class="btn btn-primary mt-2 col-12 py-2">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

    <script src="src/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>