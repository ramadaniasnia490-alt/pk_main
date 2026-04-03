<?php
session_start();
include "koneksi.php";

// Fitur Pencarian
$cari = "";
if(isset($_GET['cari'])){
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $query_berita = mysqli_query($conn, "SELECT * FROM berita WHERE judul LIKE '%$cari%' ORDER BY tanggal DESC");
} else {
    $query_berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Alumni CSSMoRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="berita.css?v=<?php echo time(); ?>"> 
    
    <style>
        .btn-tambah { display: inline-block; background: #d4af37; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-bottom: 25px; transition: 0.3s;}
        .btn-tambah:hover { background: #b5952f; transform: translateY(-2px); }
        .admin-controls { margin-top: 15px; display: flex; gap: 10px; }
        .btn-edit { background: #f8c20f; color: black; padding: 5px 15px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-hapus { background: #dc3545; color: white; padding: 5px 15px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; }
    </style>
</head>
<body>

<header>
    <div class="pembungkus nav"> 
        <img src="../home/cssmora.jpeg" class="logo-img" alt="Logo">
     <nav>
            <?php $url_sekarang = $_SERVER['REQUEST_URI']; ?>

            <a href="../home/index.php" class="<?php echo strpos($url_sekarang, '/home/') !== false ? 'active' : ''; ?>">Home</a>
            <a href="../ALUMNI/index.php" class="<?php echo strpos($url_sekarang, '/ALUMNI/') !== false ? 'active' : ''; ?>">Alumni</a>
            <a href="../INFO/index.php" class="<?php echo strpos($url_sekarang, '/INFO/') !== false ? 'active' : ''; ?>">Info Kegiatan</a>
            <a href="../berita/index.php" class="<?php echo strpos($url_sekarang, '/berita/') !== false ? 'active' : ''; ?>">Berita</a>

            <?php if(isset($_SESSION['role'])): ?>
                
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="../login/dashboard/index.php" class="<?php echo strpos($url_sekarang, '/dashboard/') !== false ? 'active' : ''; ?>">Dashboard</a>
                <?php endif; ?>
                
                <a href="../login/logout.php" style="background: #dc3545 !important; color: white !important; padding: 8px 15px; border-radius: 5px; font-weight: bold; text-decoration: none; margin-left: 15px;">Logout</a>
            
            <?php else: ?>
                
                <a href="../login/index.php" style="background: #1f5f3f; color: white; padding: 8px 15px; border-radius: 5px; font-weight: bold; text-decoration: none; margin-left: 15px;">Login</a>
                
            <?php endif; ?>
        </nav>
    </div>
</header>

<section class="hero-berita">
    <div class="overlay-berita"></div>
    <div class="hero-content-berita">
        <h1>Berita Alumni CSSMoRA</h1>
        <p>Berita terbaru seputar kegiatan, prestasi, dan kabar penting alumni CSSMoRA.</p>
        
        <form action="" method="GET" class="search-box">
            <input type="text" name="cari" placeholder="Cari berita..." value="">
            <button type="submit">Cari</button>
        </form>
    </div>
</section>

<section class="berita-list">

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <div style="text-align: right;">
            <a href="create.php" class="btn-tambah">+ Tulis Berita Baru</a>
        </div>
    <?php endif; ?>

    <?php 
    if(mysqli_num_rows($query_berita) > 0):
        while($row = mysqli_fetch_assoc($query_berita)): 
    ?>
    
    <div class="card">
        <div class="image-box">
            <span class="kategori">Berita</span>
            <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Berita">
        </div>

        <div class="content">
            <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
            <p class="tanggal"><?php echo date('d F Y', strtotime($row['tanggal'])); ?></p>
            
            <p style="color:#555; line-height: 1.5; font-size: 14px; margin-bottom: 10px;">
                <?php echo substr(strip_tags($row['isi_berita']), 0, 150) . '...'; ?>
            </p>

            <?php if(!empty($row['sumber'])): ?>
            <p class="sumber">
                Sumber: <a href="<?php echo htmlspecialchars($row['sumber']); ?>" target="_blank">Klik di sini</a>
            </p>
            <?php endif; ?>

            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-detail">Selengkapnya &rarr;</a>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <div class="admin-controls">
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus berita ini?');">Hapus</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php 
        endwhile; 
    else:
        echo "<p style='text-align:center; color:#777; margin-top:50px;'>Berita tidak ditemukan.</p>";
    endif;
    ?>

</section>

<div class="bg-gedung"></div>

<footer class="footer">
    © 2026 UIN Alauddin Makassar. All Rights Reserved.
</footer>

</body>
</html>