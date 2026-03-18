<?php
session_start();
if(!isset($_SESSION['nia']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}
include "koneksi.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT foto FROM berita WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(file_exists("uploads/".$data['foto'])) unlink("uploads/".$data['foto']);
mysqli_query($conn, "DELETE FROM berita WHERE id='$id'");

echo "<script>alert('Berita dihapus!'); window.location='index.php';</script>";
?>