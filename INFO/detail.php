<?php
session_start();
include "koneksi.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM kegiatan WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Kegiatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .detail-box { background: white; max-width: 800px; margin: auto; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 5px solid #1f5f3f; }
        .meta { color: #666; font-size: 14px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .deskripsi { line-height: 1.8; color: #333; margin-bottom: 30px; }
        .galeri { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }
        .galeri img { width: 100%; max-width: 230px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        .btn-kembali { display: inline-block; padding: 10px 20px; background: #f8c20f; color: black; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="detail-box">
        <h1 style="color:#1f5f3f; margin-top:0;"><?php echo htmlspecialchars($data['judul']); ?></h1>
        <div class="meta">
            📅 <?php echo $data['tanggal_kegiatan']; ?> &nbsp; | &nbsp; 
            ⏰ <?php echo $data['waktu']; ?> &nbsp; | &nbsp; 
            📍 <?php echo htmlspecialchars($data['lokasi']); ?> &nbsp; | &nbsp; 
            🏷️ <?php echo htmlspecialchars($data['kategori']); ?>
        </div>
        
        <div class="deskripsi">
            <?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?>
        </div>

        <h3 style="border-bottom: 2px solid #f8c20f; display: inline-block;">Galeri Kegiatan</h3>
        <div class="galeri">
            <?php
            // Memanggil foto-foto dari database galeri
            $query_galeri = mysqli_query($conn, "SELECT * FROM galeri_kegiatan WHERE id_kegiatan='$id'");
            if(mysqli_num_rows($query_galeri) > 0){
                while($foto = mysqli_fetch_assoc($query_galeri)){
                    echo "<img src='uploads/" . $foto['nama_foto'] . "' alt='Dokumentasi'>";
                }
            } else {
                echo "<p style='color:#777; font-style:italic;'>Belum ada foto yang diunggah.</p>";
            }
            ?>
        </div>

        <br><br>
        <a href="index.php" class="btn-kembali">&larr; Kembali</a>
    </div>
</body>
</html>