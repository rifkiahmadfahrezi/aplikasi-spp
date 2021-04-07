<?php

require("../../app/core/Payment.php");

$nisn = $conn->real_escape_string($_GET['nisn']);

$query = $conn->query("SELECT * FROM pembayaran INNER JOIN siswa ON pembayaran.nisn = siswa.nisn WHERE pembayaran.nisn = '$nisn'");
$data = [];

while ($x = $query->fetch_assoc()) {
	$data[] = $x;
}

// cek nisn
$getNisn = $conn->query("SELECT nisn FROM siswa WHERE nisn = '$nisn'");

if ($getNisn->num_rows == 0) {
  echo "<p class='text-center'>NISN tidak terdaftar</p>";
  die;
}


if (count($data) == 0) {
  echo "<p class='text-center'>Data pembayaran belum ada</p>";
  die;
}



?>


<div class="fs-6 d-flex mb-3 flex-column">
  <span>Nama : <?= $payment->getNamaSiswa($data[0]['nisn']) ?></span>
  <span>Kelas : <?= $payment->getClassName($data[0]['id_kelas']) ?></span>
</div>

<div class="payment-cards">
<?php  foreach($data as $key => $value): ?>
  <div class="card shadow mb-2">
    <div class="card-header">
      <div class="text-center">
        <div class="fs-5">Bulan</div>
        <div class="fs-4"><?= $value['bulan_dibayar'] ?> <?= $value['tahun_dibayar'] ?></div>
      </div>
    </div>
    <div class="card-body">
      <p>Tgl Dibayar : <?= $value['tgl_bayar'] ?></p>
      <p>Jumlah: Rp. <?= number_format($value['jumlah_bayar'] , 0, ',', '.'); ?></p>
      <p>Petugas : <?= $payment->getPetugasName($value['id_petugas']) ?></p>
    </div>
  </div>
<?php endforeach  ?>
</div>