<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSSMORA Alumni</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<!-- NAVBAR -->
<header>
    <div class="container nav">
        <img src="../home/cssmora.jpeg" class="logo-img">

        <nav>
            <a href="../home/index.php" class="<?php echo strpos($url_sekarang, '/home/') !== false ? 'active' : ''; ?>">Home</a>
            <a href="../ALUMNI/index.php">Alumni</a>
            <a href="../INFO/index.php">Info Kegiatan</a>
            <a href="../berita/index.php">Berita</a>

            <?php 
            // Cek apakah user sudah login (menggunakan session 'nia')
            if(isset($_SESSION['nia'])){ 
            ?>
                <a href="../login/dashboard/index.php">Dashboard</a>
                <a href="../login/logout.php" class="login">Logout</a>
            <?php } else { ?>
                <a href="../login/index.php" class="login active">Login</a>
            <?php } ?>
        </nav>
    </div>
</header>
<!-- HERO SECTION -->
<div class="hero">
    <h1>Selamat Datang di Website Alumni CSSMORA</h1>
    <p>Sistem Informasi Alumni Modern</p>

    <?php if(!isset($_SESSION['nia'])){ ?>
        <a href="login.php" class="btn-hero">LOGIN SEKARANG</a>
    <?php } ?>
</div>
<!-- FOOTER -->
<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>
</body>
</html>