<?php 

require("../../app/core/Student.php");

$keyword = $conn->real_escape_string(addslashes($_GET['keyword']));




$dataSiswa = $conn->query("SELECT * FROM siswa WHERE 
			nisn LIKE '%{$keyword}%' OR
			nis LIKE '%{$keyword}%' OR
			nama LIKE '%{$keyword}%'");

 ?>
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>NISN</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>Nomor Telp</th>
        <th>Opsi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1 ?>
        <?php while($row = $dataSiswa->fetch_assoc()): ?>
          <tr>
            <td><?= $no ?></td>
            <td><?= $row['nisn'] ?></td>
            <td><?= $row['nis'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $student->getClassName($row['id_kelas']) ?></td>
            <td><?= $student->isEmpty($row['alamat']) ?></td>
            <td><?= $student->isEmpty($row['no_telp']) ?></td>
            <td>
              <a id="delete-btn" title="hapus" class="btn btn-danger" href="hapus-siswa.php?nisn=<?= $row['nisn'] ?>"><i class="fa fa-trash"></i></a>
              <a title="Ubah" class="btn btn-success" href="update-siswa.php?nisn=<?= $row['nisn'] ?>"><i class="fa fa-pencil-alt"></i></a>
            </td>
          </tr>
        <?php $no++ ?>
      <?php endwhile ?>
      <?php 
        if ($dataSiswa->num_rows == 0) {
          echo "<tr><td colspan='8' class='text-center text-secondary'>Data tidak ditemukan</td></tr>";
        }
       ?>
    </tbody>
  </table>
</div>