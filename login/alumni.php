<?php
session_start();
include "config.php";

if($_SESSION['role'] != "admin"){
    header("Location: dashboard.php");
    exit; // Menghentikan eksekusi kode di bawahnya secara paksa
}

if(isset($_POST['tambah'])){
    mysqli_query($conn,"INSERT INTO alumni (nama,angkatan,jurusan)
    VALUES ('$_POST[nama]','$_POST[angkatan]','$_POST[jurusan]')");
}

$data = mysqli_query($conn,"SELECT * FROM alumni");
?>

<h2>Data Alumni</h2>

<form method="POST">
<input name="nama" placeholder="Nama">
<input name="angkatan" placeholder="Angkatan">
<input name="jurusan" placeholder="Jurusan">
<button name="tambah">Tambah</button>
</form>

<table border="1">
<tr>
<th>Nama</th><th>Angkatan</th><th>Jurusan</th>
</tr>
<?php while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?php echo $row['nama']; ?></td>
<td><?php echo $row['angkatan']; ?></td>
<td><?php echo $row['jurusan']; ?></td>
</tr>
<?php } ?>
</table>