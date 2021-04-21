<?php 

require("../../app/core/Officer.php");

$keyword = $conn->real_escape_string(addslashes($_GET['keyword']));



$officerData = $app->getOfficerInfo($_SESSION['username']);

$petugas = $conn->query("SELECT * FROM petugas WHERE 
			nama_petugas LIKE '%$keyword%' OR
			username LIKE '%$keyword%' OR
			level LIKE '%$keyword%'");

 ?>
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
                echo "<tr><td colspan='5' class='text-center text-secondary'>Data tidak ditemukan</td></tr>";
              }
             ?>
          </tbody>
        </table>
      </div>