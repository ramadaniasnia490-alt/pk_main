<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

if(isset($_POST['simpan'])){
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $nama_file  = $_FILES['foto']['name'];
    $lokasi_file= $_FILES['foto']['tmp_name'];
    $folder     = "uploads/"; 
    
    if(move_uploaded_file($lokasi_file, $folder.$nama_file)){
        $query = mysqli_query($conn, "INSERT INTO galeri_kegiatan (id_kegiatan, nama_foto, keterangan) VALUES ('0', '$nama_file', '$keterangan')");
        
        if($query){
            echo "<script>alert('Dokumentasi Berhasil Ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan ke database!');</script>";
        }
    } else {
        echo "<script>alert('Gagal upload foto! Pastikan ukuran foto tidak terlalu besar.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Dokumentasi - CSSMoRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f4f4; padding: 40px; }
        .kotak-form { background: white; padding: 30px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        label { font-weight: 500; font-size: 14px; display: block; margin-top: 15px; }
        input[type="text"], input[type="file"] { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        input[type="file"] { margin-bottom: 10px; }
        .btn-simpan { background: #144d32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 20px; }
        .btn-simpan:hover { background: #1f5f3f; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="kotak-form">
    <h3 style="color: #144d32; text-align: center; border-bottom: 2px solid #f8c20f; padding-bottom: 10px;">Tambah Foto Dokumentasi</h3>
    
    <form method="POST" enctype="multipart/form-data">

        <label>Keterangan Dokumentasi</label>
        <input type="text" name="keterangan" placeholder="Contoh: Dokumentasi Kegiatan KTPT 2025" required>

        <label>Pilih Foto untuk Diupload:</label>
        <input type="file" name="foto" accept="image/*" required>
        
        <button type="submit" name="simpan" class="btn-simpan">Simpan Dokumentasi</button>
        <a href="index.php" class="btn-batal">Batalkan & Kembali</a>
    </form>
</div>

</body>
</html>