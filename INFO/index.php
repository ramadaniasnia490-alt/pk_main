<?php
session_start();
include "../login/koneksi.php";

$cari = "";
if(isset($_GET['cari'])){
    $cari = mysqli_real_escape_string($conn, $_GET['cari']); 
    $data = mysqli_query($conn, "SELECT * FROM kegiatan WHERE judul LIKE '%$cari%' ORDER BY tanggal_kegiatan DESC");
} else {
    $data = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY tanggal_kegiatan DESC");
}

function formatTanggal($mulai, $selesai) {
    $bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $m = explode('-', $mulai);
    $tgl_mulai  = (int)$m[2];
    $bln_mulai  = (int)$m[1];
    $thn_mulai  = $m[0];
    if(empty($selesai) || $selesai == $mulai){
        return $tgl_mulai . ' ' . $bulan[$bln_mulai] . ' ' . $thn_mulai;
    }
    $s = explode('-', $selesai);
    $tgl_selesai = (int)$s[2];
    $bln_selesai = (int)$s[1];
    $thn_selesai = $s[0];
    if($bln_mulai == $bln_selesai && $thn_mulai == $thn_selesai){
        return $tgl_mulai . ' - ' . $tgl_selesai . ' ' . $bulan[$bln_mulai] . ' ' . $thn_mulai;
    }
    return $tgl_mulai . ' ' . $bulan[$bln_mulai] . ' - ' . $tgl_selesai . ' ' . $bulan[$bln_selesai] . ' ' . $thn_selesai;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Info Kegiatan CSSMoRA</title>
    <link rel="stylesheet" href="info.css?v=<?php echo time(); ?>">
</head>
<body>

<?php if(!isset($_GET['sembunyikan_nav']) || $_GET['sembunyikan_nav'] != 'ya'): ?>
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
                
                <a href="../login/index.php" class="tombol-login" style="margin-left: 15px;">Login</a>
                
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php endif; ?>

<section class="hero">
    <h1>Info Kegiatan Organisasi CSSMoRA</h1>
    <p>Event dan kegiatan terbaru untuk alumni</p>
    <form method="GET" class="search-box">
        <?php if(isset($_GET['sembunyikan_nav']) && $_GET['sembunyikan_nav'] == 'ya'): ?>
            <input type="hidden" name="sembunyikan_nav" value="ya">
        <?php endif; ?>
        <input type="text" name="cari" placeholder="Cari kegiatan..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit">Cari</button>
    </form>
</section>

<section class="container main-layout">

<div class="left-content">
    <h2>Event Mendatang</h2>
    <p class="sub">Info Kegiatan Terkini CSSMoRA</p>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="create.php<?php echo isset($_GET['sembunyikan_nav']) ? '?sembunyikan_nav=ya' : ''; ?>" class="btn-tambah">+ Tambah Kegiatan Baru</a>
    <?php endif; ?>

    <?php 
    if(mysqli_num_rows($data) > 0):
        while($row = mysqli_fetch_assoc($data)): 
            $id_keg = $row['id'];
            $q_foto = mysqli_query($conn, "SELECT nama_foto FROM galeri_kegiatan WHERE id_kegiatan='$id_keg' LIMIT 1");
            $foto_cover = mysqli_fetch_assoc($q_foto);
            $img_src = ($foto_cover) ? "uploads/" . $foto_cover['nama_foto'] : "../img/default.jpg";
            $tanggal_mulai   = $row['tanggal_kegiatan'];
            $tanggal_selesai = isset($row['tanggal_selesai']) ? $row['tanggal_selesai'] : '';
            $tampil_tanggal  = formatTanggal($tanggal_mulai, $tanggal_selesai);
    ?>
    <div class="card">
        <div class="card-img" style="position: relative;">
            <img src="<?php echo $img_src; ?>" alt="Thumbnail Kegiatan">
            <span class="kategori"><?php echo htmlspecialchars($row['kategori']); ?></span>
        </div>
        <div class="card-body">
            <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 10px;">
                📅 <?php echo $tampil_tanggal; ?> &nbsp;|&nbsp; 
                📍 <?php echo htmlspecialchars($row['lokasi']); ?> &nbsp;|&nbsp; 
                ⏰ <?php echo htmlspecialchars($row['waktu']); ?>
            </p>
            <p><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 100); ?>...</p>
            <div class="admin-controls">
                <a href="detail.php?id=<?php echo $row['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="btn" style="margin-top: 0;">Detail</a>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="edit.php?id=<?php echo $row['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="btn-edit">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; else: echo "<p>Belum ada kegiatan.</p>"; endif; ?>
</div>

<div class="dokumentasi">
    <h3 style="border-left: 4px solid #f8c20f; padding-left: 10px; color: #144d32; font-weight: bold; margin-bottom: 15px;">
        Dokumentasi Kegiatan
    </h3>
    
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
        <a href="tambah_dokumentasi.php<?php echo isset($_GET['sembunyikan_nav']) ? '?sembunyikan_nav=ya' : ''; ?>" style="background: #f8c20f; color: #144d32; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 15px; font-size: 14px;">
            + Tambah Dokumentasi
        </a>
    <?php } ?>

    <?php 
    // Kalau ada pencarian, filter dokumentasi sesuai keterangan
    if($cari != '') {
        $query_galeri = mysqli_query($conn, "SELECT * FROM galeri_kegiatan WHERE id_kegiatan = '0' AND keterangan LIKE '%$cari%' ORDER BY id DESC");
    } else {
        $query_galeri = mysqli_query($conn, "SELECT * FROM galeri_kegiatan WHERE id_kegiatan = '0' ORDER BY id DESC");
    }

    if($query_galeri && mysqli_num_rows($query_galeri) > 0) {
        while($galeri = mysqli_fetch_assoc($query_galeri)){ 
            $foto_galeri = !empty($galeri['nama_foto']) ? $galeri['nama_foto'] : 'default.jpg';
            $id_gal = $galeri['id'];
    ?>
        <div style="background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 25px; padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

            <img src="uploads/<?= htmlspecialchars($foto_galeri); ?>" 
                 class="foto-dokumentasi" alt="Dokumentasi">

            <?php if(!empty($galeri['keterangan'])): ?>
                <p class="keterangan-dokumentasi">
                    📌 <?= htmlspecialchars($galeri['keterangan']); ?>
                </p>
            <?php endif; ?>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <div style="margin-top: 15px; text-align: center; border-top: 2px dashed #eee; padding-top: 15px;">
                    <a href="edit_dokumentasi.php?id=<?= $id_gal; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" style="background: #ffc107; color: black; padding: 8px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-right: 10px; display: inline-block;">EDIT</a>
                    <a href="hapus_dokumentasi.php?id=<?= $id_gal; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" style="background: #dc3545; color: white; padding: 8px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;" onclick="return confirm('Yakin hapus foto ini?');">HAPUS</a>
                </div>
            <?php } ?>
        </div>
    <?php 
        } 
    } else {
        echo "<p style='color: #666; font-size: 14px;'>Belum ada foto dokumentasi.</p>";
    }
    ?>
</div>
</section>

<?php if(!isset($_GET['sembunyikan_nav']) || $_GET['sembunyikan_nav'] != 'ya'): ?>
<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>
<?php endif; ?>
</body>
</html>