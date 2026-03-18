<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Tambahkan pendeteksi halaman aktif setelah ini
$halaman_sekarang = basename($_SERVER['PHP_SELF']); 

include "koneksi.php";

// LOGIKA FILTER DAN PENCARIAN
// Mengamankan SEMUA variabel input untuk mencegah SQL Injection
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

<header>
    <div class="pembungkus nav"> 
        <img src="../home/cssmora.jpeg" class="logo-img" alt="Logo">
        <nav>
            <a href="../home/index.php">Home</a>
            <a href="../ALUMNI/index.php" class="active">Alumni</a>
            <a href="../INFO/index.php">Info Kegiatan</a> 
            <a href="../berita/index.php">Berita</a>
            
            <?php if(isset($_SESSION['nia'])): ?>
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="../login/dashboard/index.php">Dashboard</a>
                <?php endif; ?>
                <a href="../login/profil.php">Profil</a>
                <a href="../login/logout.php" class="tombol-login" style="background: #dc3545;">Logout</a>
            <?php else: ?>
                <a href="../login/index.php" class="tombol-login">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="pembungkus">
    <h2 class="judul-halaman">Data Alumni CSSMoRA</h2>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <div style="margin-bottom: 20px;"> 
        <a href="create.php" class="tombol-tambah">+ Tambah Alumni</a>
    </div>
    <?php endif; ?>
</div>

<form method="GET" class="pembungkus kotak-filter">
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
    </div>
<?php while($data = mysqli_fetch_assoc($query)): ?>

    <div class="kotak-alumni">
        <div class="bagian-foto">
            <img src="foto.webp" alt="Foto Profil">
        </div>

        <div class="bagian-info">
            <h3><?php echo htmlspecialchars($data['nama']); ?></h3>
            <p>Angkatan: <?php echo htmlspecialchars($data['angkatan']); ?></p>
            <p>Jurusan: <?php echo htmlspecialchars($data['jurusan']); ?></p>
            <p>Pekerjaan: <?php echo htmlspecialchars($data['jabatan'] ?? ''); ?></p>
        </div>

        <div class="bagian-tombol">
            <a href="detail.php?id=<?php echo $data['id']; ?>" class="tombol-profil">Profil</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="edit.php?id=<?php echo $data['id']; ?>" class="tombol-edit">Edit</a>
                <a href="delete.php?id=<?php echo $data['id']; ?>" class="tombol-hapus"
                onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            <?php endif; ?>
        </div>
    </div>

<?php endwhile; ?>
</div>

<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>

</body>
</html>