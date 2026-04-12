<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Tambahkan pendeteksi halaman aktif setelah ini
$halaman_sekarang = basename($_SERVER['PHP_SELF']); 

include "koneksi.php";

// LOGIKA FILTER DAN PENCARIAN
$angkatan = isset($_GET['angkatan']) ? mysqli_real_escape_string($conn, $_GET['angkatan']) : '';
$jurusan = isset($_GET['jurusan']) ? mysqli_real_escape_string($conn, $_GET['jurusan']) : '';
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

$sql = "SELECT * FROM alumni WHERE 1";

if($angkatan != ''){
    $sql .= " AND angkatan='$angkatan'";
}

if($jurusan != '' && $jurusan != 'Semua Jurusan'){
    $sql .= " AND jurusan='$jurusan'";
}

if($cari != ''){
    $sql .= " AND nama LIKE '%$cari%'"; 
}

$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Alumni CSSMoRA</title>
    <link rel="stylesheet" href="alumni.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                
                <a href="../login/index.php" style="background: #1f5f3f; color: white; padding: 8px 15px; border-radius: 5px; font-weight: bold; text-decoration: none; margin-left: 15px;">Login</a>
                
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php endif; ?>
<div class="pembungkus">
    <h2 class="judul-halaman">Data Alumni CSSMoRA</h2>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <div style="margin-bottom: 20px;"> 
        <a href="create.php<?php echo isset($_GET['sembunyikan_nav']) ? '?sembunyikan_nav=ya' : ''; ?>" class="tombol-tambah">+ Tambah Alumni</a>
    </div>
    <?php endif; ?>
</div>

<form method="GET" class="pembungkus kotak-filter">
    
    <?php if(isset($_GET['sembunyikan_nav']) && $_GET['sembunyikan_nav'] == 'ya'): ?>
        <input type="hidden" name="sembunyikan_nav" value="ya">
    <?php endif; ?>

    <div class="bagian-kiri-filter">
        <label>Angkatan:</label>
        <select name="angkatan">
            <option value="">Semua</option>
            <?php 
            for($thn = 2016; $thn <= 2026; $thn++) {
                $selected = ($angkatan == strval($thn)) ? 'selected' : '';
                echo "<option value='$thn' $selected>$thn</option>";
            }
            ?>
        </select>

        <select name="jurusan">
            <option value="">Semua Jurusan</option>
            <option value="IPA" <?php if($jurusan == 'IPA') echo 'selected'; ?>>IPA</option>
            <option value="IPS" <?php if($jurusan == 'IPS') echo 'selected'; ?>>IPS</option>
            <option value="Farmasi" <?php if($jurusan == 'Farmasi') echo 'selected'; ?>>Farmasi</option>
            <option value="Kesehatan Masyarakat" <?php if($jurusan == 'Kesehatan Masyarakat') echo 'selected'; ?>>Kesehatan Masyarakat</option>
            <option value="Teknik Informatika" <?php if($jurusan == 'Teknik Informatika') echo 'selected'; ?>>Teknik Informatika</option>
            <option value="Teknik Arsitektur" <?php if($jurusan == 'Teknik Arsitektur') echo 'selected'; ?>>Teknik Arsitektur</option>
        </select>

        <div class="pembungkus-cari">
            <i class="fas fa-search ikon-cari"></i>
            <input type="text" name="cari" class="input-cari-nama" placeholder="Cari Nama Alumni..." value="<?php echo htmlspecialchars($cari); ?>">
        </div>
    </div>
    <button type="submit" class="tombol-tampilkan">Tampilkan</button>
</form>

<div class="pembungkus">
    <h3 class="judul-angkatan">
        <?php echo ($angkatan != '') ? "Angkatan " . htmlspecialchars($angkatan) : "Semua Angkatan"; ?>
    </h3>
</div>

<div class="pembungkus halaman-alumni">
    
<?php while($data = mysqli_fetch_assoc($query)): ?>

    <div class="kotak-alumni">
        <div class="bagian-foto">
    <?php if(!empty($data['foto'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Profil" style="width:100%; height:100%; object-fit:cover;">
    <?php else: ?>
        <img src="foto.webp" alt="Foto Profil">
    <?php endif; ?>
</div>

        <div class="bagian-info">
            <h3><?php echo htmlspecialchars($data['nama']); ?></h3>
            <p>Angkatan: <?php echo htmlspecialchars($data['angkatan']); ?></p>
            <p>Jurusan: <?php echo htmlspecialchars($data['jurusan']); ?></p>
            <p>Pekerjaan: <?php echo htmlspecialchars($data['jabatan'] ?? ''); ?></p>
        </div>

        <div class="bagian-tombol">
            <a href="detail.php?id=<?php echo $data['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="tombol-profil">Profil</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="edit.php?id=<?php echo $data['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="tombol-edit">Edit</a>
                <a href="delete.php?id=<?php echo $data['id']; ?><?php echo isset($_GET['sembunyikan_nav']) ? '&sembunyikan_nav=ya' : ''; ?>" class="tombol-hapus"
                onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            <?php endif; ?>
        </div>
    </div>

<?php endwhile; ?>
</div>

<?php if(!isset($_GET['sembunyikan_nav']) || $_GET['sembunyikan_nav'] != 'ya'): ?>
<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>
<?php endif; ?>
</body>
</html>