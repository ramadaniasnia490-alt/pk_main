<?php
session_start();
include "koneksi.php";
$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?php echo htmlspecialchars($data['judul']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8fafc; padding: 40px; }
        .container-detail { background: white; max-width: 800px; margin: auto; padding: 40px; border-radius: 22px; box-shadow: 0 15px 40px rgba(0,0,0,0.06); }
        h1 { color: #1b5e20; margin-top: 0; }
        .meta { color: #777; font-size: 14px; margin-bottom: 20px; border-bottom: 2px solid #c6a94b; padding-bottom: 10px; }
        .cover-img { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 25px; }
        .isi { line-height: 1.8; color: #333; font-size: 16px; margin-bottom: 30px; text-align: justify; }
        .btn-kembali { display: inline-block; padding: 10px 20px; background: #c6a94b; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container-detail">
        <h1><?php echo htmlspecialchars($data['judul']); ?></h1>
        <div class="meta">📅 <?php echo date('d F Y', strtotime($data['tanggal'])); ?></div>

        <img src="uploads/<?php echo $data['foto']; ?>" class="cover-img" alt="Cover">

        <div class="isi">
            <?php echo nl2br(htmlspecialchars($data['isi_berita'])); ?>
        </div>

        <?php if(!empty($data['sumber'])): ?>
            <p style="background: #eef3f1; padding: 15px; border-radius: 8px;">
                🔗 <strong>Sumber:</strong> <a href="<?php echo htmlspecialchars($data['sumber']); ?>" target="_blank" style="color: #1b5e20; font-weight:bold;"><?php echo htmlspecialchars($data['sumber']); ?></a>
            </p>
        <?php endif; ?>

        <a href="index.php" class="btn-kembali">&larr; Kembali ke Daftar Berita</a>
    </div>
</body>
</html>