<?php
// 1. Tambahkan session_start() agar halaman ini tahu pengunjung sudah login atau belum
session_start();
include "koneksi.php";

$current_page = basename($_SERVER['PHP_SELF']);

$cari = "";
if(isset($_GET['cari'])){
    // Membersihkan input pencarian kegiatan dari karakter berbahaya (SQL Injection)
    $cari = mysqli_real_escape_string($conn, $_GET['cari']); 
    $data = mysqli_query($conn, "SELECT * FROM kegiatan 
                                 WHERE judul LIKE '%$cari%' 
                                 ORDER BY tanggal_kegiatan DESC");
} else {
    $data = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal_kegiatan DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Info Kegiatan CSSMoRA</title>
    <link rel="stylesheet" href="info.css">
</head>
<body>

<header>
    <div class="pembungkus nav"> 
        <img src="../home/cssmora.jpeg" class="logo-img" alt="Logo">
        <nav>
    <?php 
    // Mendeteksi URL yang sedang dibuka saat ini
    $url_sekarang = $_SERVER['REQUEST_URI']; 
    ?>
    
    <a href="../home/index.php" class="<?php echo strpos($url_sekarang, '/home/') !== false ? 'active' : ''; ?>">Home</a>
    
    <a href="../ALUMNI/index.php" class="<?php echo strpos($url_sekarang, '/ALUMNI/') !== false ? 'active' : ''; ?>">Alumni</a>
    
    <a href="../INFO/index.php" class="<?php echo strpos($url_sekarang, '/INFO/') !== false ? 'active' : ''; ?>">Info Kegiatan</a>
    
    <a href="../berita/index.php" class="<?php echo strpos($url_sekarang, '/berita/') !== false ? 'active' : ''; ?>">Berita</a>

    <?php if(isset($_SESSION['nia'])): ?>
        <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="../login/dashboard/index.php">Dashboard</a>
        <?php endif; ?>
        <a href="../login/profil.php">Profil</a>
        <a href="../login/logout.php" class="tombol-login" style="background: #dc3545;">Logout</a>
    <?php else: ?>
        <a href="../login/index.php" class="tombol-login <?php echo strpos($url_sekarang, '/login/') !== false ? 'active' : ''; ?>">Login</a>
    <?php endif; ?>
</nav>
    </div>
</header>

<section class="hero">
    <h1>Info Kegiatan Organisasi CSSMoRA</h1>
    <p>Event dan kegiatan terbaru untuk alumni</p>

    <form method="GET" class="search-box">
        <input type="text" name="cari" placeholder="Cari kegiatan..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit">Cari</button>
    </form>
</section>

<section class="container main-layout">

<div class="left-content">
    <h2>Event Mendatang</h2>
    <p class="sub">Info Kegiatan Terkini CSSMoRA</p>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="create.php" class="btn-tambah">+ Tambah Kegiatan Baru</a>
    <?php endif; ?>

    <?php 
    if(mysqli_num_rows($data) > 0):
        while($row = mysqli_fetch_assoc($data)): 
            
            // LOGIKA PENGAMBILAN FOTO COVER
            $id_keg = $row['id'];
            $q_foto = mysqli_query($conn, "SELECT nama_foto FROM galeri_kegiatan WHERE id_kegiatan='$id_keg' LIMIT 1");
            $foto_cover = mysqli_fetch_assoc($q_foto);
            // Jika ada foto, pakai foto itu. Jika tidak, pakai gambar default
            $img_src = ($foto_cover) ? "uploads/" . $foto_cover['nama_foto'] : "../img/default.jpg";
    ?>
    
    <div class="card">
        <div class="card-img" style="position: relative;">
            <img src="<?php echo $img_src; ?>" alt="Thumbnail Kegiatan">
            <span class="kategori"><?php echo htmlspecialchars($row['kategori']); ?></span>
        </div>

        <div class="card-body">
            <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 10px;">
                📅 <?php echo htmlspecialchars($row['tanggal_kegiatan']); ?> &nbsp;|&nbsp; 
                📍 <?php echo htmlspecialchars($row['lokasi']); ?> &nbsp;|&nbsp; 
                ⏰ <?php echo htmlspecialchars($row['waktu']); ?>
            </p>
            <p><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 100); ?>...</p>
            
            <div class="admin-controls">
                <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn" style="margin-top: 0;">Detail</a>
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus kegiatan ini?');">Hapus</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
    
    <?php 
        endwhile; 
    else:
        echo "<p style='color: #777; font-style: italic;'>Belum ada kegiatan yang ditemukan.</p>";
    endif;
    ?>
</div>

<div class="dokumentasi">
    <h3>Dokumentasi Kegiatan</h3>

    <?php 
    $mini = mysqli_query($conn,"SELECT * FROM kegiatan ORDER BY tanggal_kegiatan DESC LIMIT 3");
    while($m = mysqli_fetch_assoc($mini)): 
        // Mengambil foto untuk sidebar
        $id_m = $m['id'];
        $q_foto_m = mysqli_query($conn, "SELECT nama_foto FROM galeri_kegiatan WHERE id_kegiatan='$id_m' LIMIT 1");
        $foto_m = mysqli_fetch_assoc($q_foto_m);
        $img_m = ($foto_m) ? "uploads/" . $foto_m['nama_foto'] : "../img/default.jpg";
    ?>
        <div class="mini-card">
            <img src="<?php echo $img_m; ?>" alt="Dokumentasi">
            <p style="font-weight: bold; color: #1f4d2e; text-align: center;"><?php echo htmlspecialchars($m['judul']); ?></p>
        </div>
    <?php endwhile; ?>

</div>

</section>
<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>
</body>
</html>