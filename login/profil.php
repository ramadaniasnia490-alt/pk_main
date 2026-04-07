<?php
session_start();
include "koneksi.php";

// Jika belum login, tendang ke halaman login
if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

$nia_user = $_SESSION['nia'];

// Mengambil data detail dari tabel alumni berdasarkan NIA yang sedang login
$query = mysqli_query($conn, "SELECT * FROM alumni WHERE nia='$nia_user'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - CSSMoRA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <link rel="stylesheet" href="login.css">
    
    <style>
        /* BACKGROUND HALAMAN */
        body {
            background-color: #f4f7f6;
        }

        /* WADAH PROFIL (Mengadopsi desain detail.php) */
        .profil-wrapper {
            max-width: 800px;
            margin: 50px auto 100px auto; /* Margin bottom ditambah agar tidak tertutup footer */
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 5px solid #1f5f3f;
        }

        .header-profil {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .profile-photo {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid #f8c20f; /* Aksen kuning CSSMoRA */
            margin: 0 auto 15px;
            overflow: hidden;
            background: #f0f0f0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo .placeholder {
            font-size: 60px;
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .header-profil h1 {
            color: #1f5f3f;
            margin-bottom: 5px;
            font-size: 26px;
        }

        .nia-badge {
            display: inline-block;
            background: #eef5f0;
            color: #1f5f3f;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #fcfcfc;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .info-label {
            font-size: 13px;
            color: #777;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            font-weight: 600;
        }

        .motto-section {
            background: #fff8e1;
            padding: 20px;
            border-left: 5px solid #f8c20f;
            margin: 20px 0;
            border-radius: 8px;
        }

        .motto-label {
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        .motto-text {
            font-style: italic;
            color: #333;
            font-size: 15px;
            font-weight: 500;
            line-height: 1.6;
        }

        .alert-kosong {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container nav">
        <img src="../home/cssmora.jpeg" class="logo-img" alt="Logo">
        <nav>
            <a href="../home/index.php">Home</a>
            <a href="../ALUMNI/index.php">Alumni</a>
            <a href="../INFO/index.php">Info Kegiatan</a>
            <a href="../berita/index.php">Berita</a>
            
            <?php if(isset($_SESSION['nia'])): ?>
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="dashboard/index.php">Dashboard</a>
                <?php endif; ?>

                <a href="profil.php" style="color: #d4af37;">Profil</a>
                <a href="logout.php" style="background-color: #dc3545; color: white; padding: 6px 16px; border-radius: 6px; text-decoration: none; font-weight: 500;">Logout</a>
                <a href="index.php" class="login">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="profil-wrapper">
    
    <?php if($data): ?>
        <div class="header-profil">
            <div class="profile-photo">
                <?php if(!empty($data['foto'])): ?>
                    <img src="../ALUMNI/uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Profil">                <?php else: ?>
                    <span class="placeholder">👤</span>
                <?php endif; ?>
            </div>
            <h1><?php echo htmlspecialchars($data['nama']); ?></h1>
            <div class="nia-badge">NIA: <?php echo htmlspecialchars($data['nia']); ?></div>
            <p style="color: #666; font-size: 15px; margin-top: 5px;">
                🎓 Angkatan <?php echo htmlspecialchars($data['angkatan'] ?? '-'); ?> | 
                📚 <?php echo htmlspecialchars($data['jurusan'] ?? '-'); ?>
            </p>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">📍 Tempat Lahir</div>
                <div class="info-value"><?php echo htmlspecialchars($data['tempat_lahir'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">📅 Tanggal Lahir</div>
                <div class="info-value"><?php echo htmlspecialchars($data['tanggal_lahir'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">⚧ Jenis Kelamin</div>
                <div class="info-value"><?php echo htmlspecialchars($data['jenis_kelamin'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">🏛️ Fakultas</div>
                <div class="info-value"><?php echo htmlspecialchars($data['fakultas'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">📧 Email</div>
                <div class="info-value"><?php echo htmlspecialchars($data['email'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">📱 HP</div>
                <div class="info-value"><?php echo htmlspecialchars($data['hp'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">💼 Pekerjaan</div>
                <div class="info-value"><?php echo htmlspecialchars($data['jabatan'] ?? '-'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">🏠 Alamat Domisili</div>
                <div class="info-value"><?php echo htmlspecialchars($data['alamat_domisili'] ?? '-'); ?></div>
            </div>
        </div>

        <div class="info-item" style="margin-bottom: 20px;">
            <div class="info-label">🏡 Alamat Asal</div>
            <div class="info-value"><?php echo htmlspecialchars($data['alamat_asal'] ?? '-'); ?></div>
        </div>

        <?php if(!empty($data['motto'])): ?>
        <div class="motto-section">
            <div class="motto-label">💬 Motto</div>
            <div class="motto-text">"<?php echo htmlspecialchars($data['motto']); ?>"</div>
        </div>
        <?php endif; ?>

        <?php if(!empty($data['cita_cita'])): ?>
        <div class="info-item" style="margin-bottom: 20px;">
            <div class="info-label">🌟 Cita-Cita</div>
            <div class="info-value"><?php echo htmlspecialchars($data['cita_cita']); ?></div>
        </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 40px; border-top: 1px solid #eee; padding-top: 25px;">
            <a href="edit_profil.php" style="background: #f8c20f; color: #1f5f3f; padding: 12px 30px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.1); font-size: 16px; transition: 0.3s;">
                <i class="fas fa-user-edit"></i> Edit Profil Saya
            </a>
        </div>

    <?php else: ?>
        <div class="header-profil">
            <div class="profile-photo">
                <span class="placeholder">👤</span>
            </div>
            <h1>Pengguna Baru</h1>
            <div class="nia-badge">NIA: <?php echo htmlspecialchars($_SESSION['nia']); ?></div>
        </div>
        <div class="alert-kosong">
            <h3>⚠️ Data Profil Anda Belum Tersedia</h3>
            <p style="margin-top: 10px;">Halo! Akun Anda sudah berhasil dibuat, tetapi detail data alumni Anda belum ditambahkan ke dalam sistem database kami. Silakan hubungi <strong>Admin CSSMoRA</strong> agar profil Anda segera dilengkapi.</p>
        </div>
    <?php endif; ?>

</div>

<footer class="footer" style="background: #ffffff; color: #1f5f3f; text-align: center; padding: 20px 0; font-size: 14px; font-weight: bold; position: fixed; bottom: 0; left: 0; width: 100%; box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05); z-index: 999;">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>

</body>
</html>