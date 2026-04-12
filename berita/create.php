<?php
session_start();
include "../login/koneksi.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

include "koneksi.php";

if(isset($_POST['simpan'])){
    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal    = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $isi_berita = mysqli_real_escape_string($conn, $_POST['isi_berita']);
    $sumber     = mysqli_real_escape_string($conn, $_POST['sumber']);

    $nama_foto = time() . "_" . $_FILES['foto']['name'];
    $tmp_foto  = $_FILES['foto']['tmp_name'];

    if(move_uploaded_file($tmp_foto, "uploads/" . $nama_foto)){
        mysqli_query($conn, "INSERT INTO berita (judul, tanggal, isi_berita, sumber, foto) VALUES ('$judul', '$tanggal', '$isi_berita', '$sumber', '$nama_foto')");
        echo "<script>alert('Berita berhasil dipublikasikan!'); window.location='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Berita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8fafc; padding: 40px; }
        .form-box { background: white; max-width: 700px; margin: auto; padding: 40px; border-radius: 22px; box-shadow: 0 15px 40px rgba(0,0,0,0.06); border-top: 5px solid #1b5e20; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #1b5e20; font-size: 14px; }
        input, textarea { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif;}
        button { margin-top: 25px; width: 100%; padding: 14px; background: linear-gradient(to right,#1b5e20,#2e7d32); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: 600;}
    </style>
</head>
<body>
    <div class="form-box">
        <h2 style="text-align:center; margin-top:0; color:#1b5e20;">Tulis Berita Baru</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Judul Berita</label>
            <input type="text" name="judul" required>

            <label>Tanggal Publikasi</label>
            <input type="date" name="tanggal" required>

            <label>Isi Berita</label>
            <textarea name="isi_berita" id="isi_berita" rows="10" required></textarea>

            <label>Link Sumber (Opsional)</label>
            <input type="text" name="sumber" placeholder="Contoh: https://cssmora.or.id...">

            <label>Foto Cover (Wajib)</label>
            <input type="file" name="foto" accept="image/*" required>

            <button type="submit" name="simpan">Publikasikan Berita</button>
            <a href="index.php" class="btn-batal">Batal & Kembali</a>
        </form>
    </div>

    <!-- ✅ Script agar paste teks bisa masuk ke textarea -->
    <script>
        document.querySelectorAll('textarea').forEach(function(el) {
            el.addEventListener('paste', function(e) {
                e.preventDefault();
                var text = (e.clipboardData || window.clipboardData).getData('text/plain');
                document.execCommand('insertText', false, text);
            });
        });
    </script>

</body>
</html>