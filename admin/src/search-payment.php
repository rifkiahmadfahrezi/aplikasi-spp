<?php 
require("../../app/core/Payment.php");


$keyword = htmlspecialchars(addslashes($_GET['keyword']));

$pembayaran = $conn->query("SELECT * FROM pembayaran WHERE nisn LIKE '%{$keyword}%'");
$levelUser = $_SESSION['level'];
 ?>
 <div class="table-responsive">
        <table class="table">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>NISN</th>
              <th>Nama siswa</th>
              <th>Bulan</th>
              <th>Tahun</th>
              <th>Tahun SPP</th>
              <th>Jumlah</th>
              <th>Petugas</th>
              <th>Dibayar pada</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1 ?>
              <?php while($row = $pembayaran->fetch_assoc()): ?>
                <tr class="text-center">
                  <td><?= $no ?></td>
                  <td><?= $row['nisn'] ?></td>
                  <td><?= $payment->getStudentName($row['nisn']) ?></td>
                  <td><?= $row['bulan_dibayar'] ?></td>
                  <td><?= $row['tahun_dibayar'] ?></td>
                  <td><?= $payment->getTahunSpp($row['id_spp']) ?></td>
                  <td>Rp. <?= number_format($row['jumlah_bayar'] , 0, ',', '.'); ?></td>
                  <td><?= $payment->getPetugas($row['id_petugas']) ?></td>
                  <td><?= $row['tgl_bayar'] ?></td>
                </tr>
              <?php $no++ ?>
            <?php endwhile ?>
            <?php if ($pembayaran->num_rows == 0): ?>
                <td class="text-secondary text-center" colspan="11">Data tidak ditemukan</td>
            <?php endif ?>
          </tbody>
        </table>
      </div>