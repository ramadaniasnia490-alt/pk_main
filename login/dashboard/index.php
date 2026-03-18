<?php
session_start();
// Jika belum login ATAU rolenya BUKAN admin, tendang keluar!
if(!isset($_SESSION['nia']) || $_SESSION['role'] != 'admin'){
    header("Location: ../../home/index.php");
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
        <span>Halo, <strong><?php echo $_SESSION['nia']; ?></strong></span>
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="dashboard">

    <div class="card">
        <h3>Profil Saya</h3>
        <p>Lihat dan atur data diri Anda.</p>
        <a href="../profil.php" class="btn-card">Buka Profil</a>
    </div>

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

</div>

</body>
</html>