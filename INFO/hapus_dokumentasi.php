<?php
session_start();
include "koneksi.php"; 

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query_foto = mysqli_query($conn, "SELECT nama_foto FROM galeri_kegiatan WHERE id='$id'");
    $data = mysqli_fetch_assoc($query_foto);
    
    if($data){
        $foto_lama = $data['nama_foto'];
        if(!empty($foto_lama) && $foto_lama != "default.jpg" && file_exists("uploads/".$foto_lama)){
            unlink("uploads/".$foto_lama);
        }
        
        $hapus = mysqli_query($conn, "DELETE FROM galeri_kegiatan WHERE id='$id'");
        if($hapus){
            echo "<script>alert('YES! Dokumentasi berhasil dihapus!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal hapus dari database!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Data foto tidak ditemukan!'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>