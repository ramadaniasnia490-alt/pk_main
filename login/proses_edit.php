<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include "koneksi.php";

if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nia_user = $_SESSION['nia'];

    $ambil = mysqli_query($conn, "SELECT foto FROM alumni WHERE nia='$nia_user'");
    $data_lama = mysqli_fetch_assoc($ambil);

    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $hp              = mysqli_real_escape_string($conn, $_POST['hp']);
    $tempat_lahir    = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $jabatan         = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $alamat_domisili = mysqli_real_escape_string($conn, $_POST['alamat_domisili']);
    $motto           = mysqli_real_escape_string($conn, $_POST['motto']);
    $cita_cita       = mysqli_real_escape_string($conn, $_POST['cita_cita']);

    // Default pakai foto lama
    $nama_foto_simpan = $data_lama['foto'];

    // ==========================================
    // PROSES UPLOAD FOTO
    // ==========================================
    if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {

        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_file    = $_FILES['foto']['tmp_name'];

        $ekstensi_ok = array('png','jpg','jpeg','webp');
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if(!in_array($ekstensi, $ekstensi_ok)){
            echo "<script>alert('Format foto tidak didukung! Gunakan JPG/PNG/WEBP.'); window.history.back();</script>";
            exit;
        }
        if($ukuran_file > 2048000){
            echo "<script>alert('Ukuran foto terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
            exit;
        }

        $nama_baru = time() . '-' . rand(100,999) . '.' . $ekstensi;

        // proses_edit.php ada di folder login/
        // uploads ada di folder ALUMNI/ (satu level di atas login/)
        $folder_upload = __DIR__ . '/../ALUMNI/uploads/';

        // Buat folder jika belum ada
        if(!is_dir($folder_upload)){
            mkdir($folder_upload, 0777, true);
        }

        // Hapus foto lama
        if(!empty($data_lama['foto']) && file_exists($folder_upload . $data_lama['foto'])){
            unlink($folder_upload . $data_lama['foto']);
        }

        if(move_uploaded_file($tmp_file, $folder_upload . $nama_baru)){
            $nama_foto_simpan = $nama_baru;
        } else {
            echo "<script>alert('Gagal upload foto!'); window.history.back();</script>";
            exit;
        }
    }
    // ==========================================

    $query = "UPDATE alumni SET
                email            = '$email',
                hp               = '$hp',
                tempat_lahir     = '$tempat_lahir',
                jabatan          = '$jabatan',
                alamat_domisili  = '$alamat_domisili',
                motto            = '$motto',
                cita_cita        = '$cita_cita',
                foto             = '$nama_foto_simpan'
              WHERE nia = '$nia_user'";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>