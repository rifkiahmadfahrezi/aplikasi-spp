<?php 
require("../app/core/Payment.php");
// cek status login
if (!$_SESSION['login']) {
  header("Location: ../");
}
if (isset($_POST['submit-payment'])) {
  $payment->pay($_POST);
}
$levelUser = $_SESSION['level'];
// ambil data petugas yg login
$officerData = $app->getOfficerInfo($_SESSION['username']);


// ambil data tahun
$daftarTahunSpp = $conn->query("SELECT tahun FROM spp");
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
    <title>Pembayaran - Aplikasi SPP</title>
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
    <a class="nav-link active" href="pembayaran"><span><i class="fa fa-money-check-alt me-2"></i>Pembayaran</span> </a>
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



   <section id="payment" class="mx-3">
     
    <h2 class="my-3">Pembayaran</h2>

     <?php 
        if (isset($_SESSION['status'])) {
          if ($_SESSION['status'] == 'berhasil') {
            echo "<script>
                Swal.fire({
                  title: 'Berhasil',
                  text: '{$_SESSION['jml']} pembayaran berhasil',
                  icon: 'success',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
            unset($_SESSION['jml']);
            unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'gagal') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'Pembayaran gagal',
                  icon: 'error',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";;
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'nisn tidak ada') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'NISN tidak tersedia',
                  icon: 'warning',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";;
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'bulan belum dipilih') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'Pilih bulan pembayaran',
                  icon: 'warning',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'tidak boleh 0') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: 'total pembayaran tidak boleh 0',
                  icon: 'warning',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";;
              unset($_SESSION['status']);
          }elseif ($_SESSION['status'] == 'bulan yg dipilih sudah dibayar') {
            echo "<script>
                Swal.fire({
                  title: 'Gagal',
                  text: '{$_SESSION['message']}',
                  icon: 'warning',
                  confirmButtonColor :'#2b2f78'
                  })
                </script>";;
              unset($_SESSION['status']);
              unset($_SESSION['message']);
          }
        }
       ?>

    <form action="" id="payment-form" method="post" class="my-3">
      
    <input type="hidden" name="id_petugas" value="<?= $officerData['id_petugas'] ?>">
     <label for="tahun-spp" class="mb-2">Tahun SPP</label>
     <select name="tahun-spp" id="tahun-spp" required class="form-select mb-3">
        <option value="">-- Pilih salah satu --</option>
        <?php while($dataTahun = $daftarTahunSpp->fetch_assoc()): ?>
          <option value="<?= $dataTahun['tahun'] ?>"><?= $dataTahun['tahun'] ?></option>
        <?php endwhile ?>
      </select>

      <label for="harga">Harga SPP perbulan</label>
      <input type="number" id="harga" readonly required class="form-control mb-3 mt-1">

      <div class="input-wrapper">
        <label for="nisn">NISN</label>
      <div class="dropdown">
        <input type="number" autocomplete="off" id="cari-nisn" class="form-control dropdown-toggle mb-3"id="dropdownMenuButton1" data-bs-toggle="dropdown" name="nisn" aria-expanded="false">
        <ul class="dropdown-menu list-nisn"  style="width: 100%;" aria-labelledby="dropdownMenuButton1">
          <li class="dropdown-item nisn-item" data-value="">Ketik NISN</li>
        </ul>
      </div>

      </div>

      <label for="tgl-bayar">Tanggal pembayaran</label>
      <input type="date" name="tgl-bayar" id="tgl-bayar" class="form-control mb-3 mt-1">

      <p class="mb-2">Pilih bulan</p>
      <div class="moths mb-3">

        <label for="januari" class="month">Januari
          <input type="radio" id="januari"  name="bulan1" class="mb-2 mth" value="januari"> 
        </label>


        <label for="februari" class="month">Februari
          <input type="radio" id="februari"  name="bulan2" class="mb-2 mth" value="februari"> 
        </label>


        <label for="maret" class="month">Maret
          <input type="radio" id="maret"  name="bulan3" class="mb-2 mth" value="maret"> 
        </label>


      <label for="april" class="month">April
        <input type="radio" id="april"  name="bulan4" class="mb-2 mth" value="april"> 
      </label>


      <label for="mei" class="month">Mei
        <input type="radio" id="mei"  name="bulan5" class="mb-2 mth" value="Mei"> 
      </label>

        <label for="juni" class="month">Juni
          <input type="radio" id="juni" name="bulan6" class="mb-2 mth" value="juni">
        </label>

        <label for="juli" class="month">Juli
           <input type="radio" id="juli"  name="bulan7" class="mb-2 mth" value="juli"> 
        </label>

        <label for="agustus" class="month">Agustus
          <input type="radio" id="agustus"  name="bulan8" class="mb-2 mth" value="agustus"> 
        </label>


       <label for="september" class="month">September
          <input type="radio" id="september"  name="bulan9" class="mb-2 mth" value="september">
       </label> 


       <label for="oktober" class="month">Oktober
          <input type="radio" id="oktober"  name="bulan10" class="mb-2 mth" value="oktober"> 
       </label>


      <label for="november" class="month">November
        <input type="radio" id="november"  name="bulan11" class="mb-2 mth" value="november">
      </label>

      <label for="desember" class="month">Desember
        <input type="radio" id="desember"  name="bulan12" class="mb-2 mth" value="desember">
      </label>

      </div>


      <label for="total">Total Pembayaran</label>
      <input type="number" readonly name="total" id="total" value="0" class="form-control mb-3 mt-1">

      <button type="submit" name="submit-payment" class="btn konfirmasi btn-primary">Submit</button>

    </form>
    

   </section>


  </main>


    <script src="assets/js/main.js"></script>
    <script defer src="src/payment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>