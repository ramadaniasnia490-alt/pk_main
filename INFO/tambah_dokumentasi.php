<?php
session_start();
include "koneksi.php";

// INI KUNCI YANG BENAR
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

if(isset($_POST['simpan'])){
    // Proses Upload Foto
    $nama_file = $_FILES['foto']['name'];
    $lokasi_file = $_FILES['foto']['tmp_name'];
    $folder = "uploads/"; 
    
    // Pindahkan foto ke folder uploads
    if(move_uploaded_file($lokasi_file, $folder.$nama_file)){
        // KITA SESUAIKAN DENGAN DATABASEMU: Masukkan ke id_kegiatan (isi 0) dan nama_foto
        $query = mysqli_query($conn, "INSERT INTO galeri_kegiatan (id_kegiatan, nama_foto) VALUES ('0', '$nama_file')");
        
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
        input[type="file"] { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-simpan { background: #144d32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="kotak-form">
    <h3 style="color: #144d32; text-align: center; border-bottom: 2px solid #f8c20f; padding-bottom: 10px;">Tambah Foto Dokumentasi</h3>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Pilih Foto untuk Diupload:</label>
        <input type="file" name="foto" accept="image/*" required>
        
        <button type="submit" name="simpan" class="btn-simpan">Simpan Dokumentasi</button>
        <a href="index.php" class="btn-batal">Batalkan & Kembali</a>
    </form>
</div>

</body>
</html>