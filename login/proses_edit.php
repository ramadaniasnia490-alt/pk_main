<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // AMBIL NIA DARI SESSION, BUKAN DARI FORM. Ini sangat aman!
    $nia_user = $_SESSION['nia'];

    // Ambil data yang boleh diedit
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $alamat_domisili = mysqli_real_escape_string($conn, $_POST['alamat_domisili']);
    $motto = mysqli_real_escape_string($conn, $_POST['motto']);
    $cita_cita = mysqli_real_escape_string($conn, $_POST['cita_cita']);

    // Proses Update ke tabel alumni (NIA, NIM, Nama sengaja tidak di-update)
    $query = "UPDATE alumni SET 
                email = '$email',
                hp = '$hp',
                tempat_lahir = '$tempat_lahir',
                jabatan = '$jabatan',
                alamat_domisili = '$alamat_domisili',
                motto = '$motto',
                cita_cita = '$cita_cita'
              WHERE nia = '$nia_user'";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Mantap! Profil berhasil diperbarui.'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data.'); window.history.back();</script>";
    }
}
?>