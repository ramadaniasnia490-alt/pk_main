<?php
session_start();

// Cek apakah yang login benar-benar memiliki role 'admin'
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    // Beri pesan peringatan agar kita tahu kenapa dia ditendang
    echo "<script>
            alert('Akses Ditolak! Anda bukan Admin atau sesi Anda telah habis.');
            window.location.href = '../../home/index.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - CSSMoRA</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="dashboard-bg">

<div class="navbar-dashboard">
    <div class="logo-dash">
        <img src="../../home/cssmora.jpeg" alt="Logo" style="height: 40px; border-radius: 5px;">
        <span>DASHBOARD CSSMORA</span>
    </div>
    <div class="user-menu">
        <span>Halo, <strong>Admin Utama</strong></span>
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="dashboard">

    <?php if($_SESSION['role'] == "admin"){ ?>
    <div class="card">
        <h3>Kelola Alumni</h3>
        <p>Tambah, edit, dan hapus data alumni.</p>
        <a href="../../ALUMNI/index.php" class="btn-card">Kelola Data</a>
    </div>
    <?php } ?>

    <div class="card">
        <h3>Info Kegiatan</h3>
        <p>Kelola informasi kegiatan terbaru.</p>
        <a href="../../INFO/index.php" class="btn-card">Lihat Kegiatan</a>
    </div>

    <div class="card">
        <h3>Kelola Berita</h3>
        <p>Tulis dan kelola berita organisasi.</p>
        <a href="../../berita/index.php" class="btn-card">Kelola Berita</a>
    </div>

</div>

</body>
</html>