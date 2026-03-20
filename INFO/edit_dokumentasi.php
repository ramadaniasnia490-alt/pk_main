<?php
session_start();
include "koneksi.php";

// INI KUNCI YANG BENAR
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

// Cek apakah ada ID
if(!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM galeri_kegiatan WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(!$data) {
    echo "<script>alert('Data foto tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Proses Update Foto
if(isset($_POST['update'])){
    $nama_file = $_FILES['foto']['name'];
    $lokasi_file = $_FILES['foto']['tmp_name'];
    
    if(!empty($lokasi_file)){
        $folder = "uploads/";
        $nama_unik = time() . "_" . basename($nama_file);
        
        // Hapus file lama jika ada
        if(!empty($data['nama_foto']) && $data['nama_foto'] != "default.jpg" && file_exists($folder.$data['nama_foto'])){
            unlink($folder.$data['nama_foto']);
        }
        
        // Upload file baru
        if(move_uploaded_file($lokasi_file, $folder.$nama_unik)){
            mysqli_query($conn, "UPDATE galeri_kegiatan SET nama_foto='$nama_unik' WHERE id='$id'");
            echo "<script>alert('YES! Foto Dokumentasi berhasil diubah!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memindahkan file foto!');</script>";
        }
    } else {
        echo "<script>alert('Pilih foto baru dulu sebelum klik Simpan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Dokumentasi - CSSMoRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; margin: 0; }
        
        /* Desain disamakan dengan detail.php */
        .edit-box { background: white; max-width: 500px; margin: auto; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 5px solid #1f5f3f; }
        
        label { display: block; margin-top: 20px; font-weight: 600; color: #1f5f3f; font-size: 14px; }
        input[type="file"] { width: 100%; padding: 12px; margin-top: 8px; border: 1px dashed #1f5f3f; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif; background: #fafafa; cursor: pointer;}
        
        .img-preview { text-align: center; margin-top: 10px; padding: 10px; background: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; }
        .img-preview img { max-width: 100%; max-height: 250px; border-radius: 5px; }

        .btn-simpan { margin-top: 30px; width: 100%; padding: 15px; background: #f8c20f; color: black; border: none; border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.3s;}
        .btn-simpan:hover { background: #e0ae0d; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="edit-box">
        <h2 style="color:#1f5f3f; margin-top:0; border-bottom: 2px solid #eee; padding-bottom: 15px; text-align: center;">🖼️ Edit Foto Dokumentasi</h2>
        
        <form method="POST" enctype="multipart/form-data">
            
            <label>Foto Saat Ini:</label>
            <div class="img-preview">
                <img src="uploads/<?= $data['nama_foto']; ?>" alt="Foto Lama">
            </div>
            
            <label>Pilih Foto Pengganti:</label>
            <input type="file" name="foto" accept="image/*" required>
            <small style="color:#777; font-size: 12px; display:block; margin-top:5px;">*Foto lama akan otomatis terhapus dan diganti dengan yang baru.</small>
            
            <button type="submit" name="update" class="btn-simpan">💾 Simpan Foto Baru</button>
            <a href="index.php" class="btn-batal">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>