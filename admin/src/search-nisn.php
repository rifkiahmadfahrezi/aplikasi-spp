<?php
require_once("../../app/core/Connection.php");

$nisn = $conn->real_escape_string(htmlspecialchars($_GET['nisn']));

$getNisn = $conn->query("SELECT nisn FROM siswa WHERE nisn LIKE '%$nisn%'");

?>
<?php while($row  = $getNisn->fetch_assoc()): ?>
	<?php if ($getNisn->num_rows == 0): ?>
		<li class="dropdown-item nisn-item">NISN Tidak terdaftar</li>
	<?php endif ?>
	<li class="dropdown-item nisn-item" onclick="getNisn('<?= $row['nisn'] ?>')"><?= $row['nisn'] ?></li>
<?php endwhile ?>