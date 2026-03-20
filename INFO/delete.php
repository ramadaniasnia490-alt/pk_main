<?php
session_start();
include "../login/koneksi.php";

// INI KUNCI YANG BENAR
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

include "koneksi.php";
$id = mysqli_real_escape_string($conn, $_GET['id']);

// 1. Cari semua foto dari kegiatan ini
$query_foto = mysqli_query($conn, "SELECT nama_foto FROM galeri_kegiatan WHERE id_kegiatan='$id'");

// 2. Hapus file fisik satu per satu dari folder uploads
while($foto = mysqli_fetch_assoc($query_foto)){
    $path_file = "uploads/" . $foto['nama_foto'];
    if(file_exists($path_file)){
        unlink($path_file); // Menghapus file fisik
    }
}

// 3. Hapus data kegiatan dari database (Data di galeri otomatis terhapus karena CASCADE)
$hapus = mysqli_query($conn, "DELETE FROM kegiatan WHERE id='$id'");

if($hapus){
    echo "<script>alert('Kegiatan beserta seluruh fotonya berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data.'); window.location='index.php';</script>";
}
?>