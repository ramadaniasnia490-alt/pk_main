<?php
session_start(); 
include "koneksi.php";

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM alumni WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    
    if(!$data){
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Cek apakah yang melihat ini adalah Admin
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Alumni - <?php echo htmlspecialchars($data['nama']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* ================= CSS GANTENG START ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        body { 
            background-color: #ebefec; 
            padding: 40px 20px; 
            color: #333; 
        }

        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        }
        
        /* Notifikasi Admin */
        .admin-alert { 
            background: #d1e7dd; 
            color: #0f5132; 
            padding: 15px; 
            text-align: center; 
            font-size: 14px; 
            border-bottom: 2px solid #badbcc; 
            font-weight: bold; 
        }
        
        /* Header Profil Hijau CSSMoRA */
        .header-profile { 
            background: linear-gradient(135deg, #0f5132 0%, #1a744a 100%); 
            color: white; 
            padding: 50px 20px; 
            text-align: center; 
        }

        .photo-wrapper { 
            width: 140px; 
            height: 140px; 
            border-radius: 50%; 
            border: 6px solid #f8c20f; 
            margin: 0 auto 20px; 
            overflow: hidden; 
            background: white; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .photo-wrapper img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }
        
        .header-profile h1 { font-size: 28px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .header-profile .sub-header { font-size: 16px; opacity: 0.9; font-weight: 300; }

        /* Isi Konten */
        .content-body { padding: 40px; }

        .section-title { 
            font-size: 18px; 
            font-weight: bold; 
            color: #0f5132; 
            margin-bottom: 25px; 
            border-bottom: 3px solid #f8c20f; 
            display: inline-block; 
            padding-bottom: 5px; 
        }
        
        .info-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 20px; 
            margin-bottom: 35px; 
        }

        .info-card { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 12px; 
            border-left: 5px solid #0f5132; 
            transition: 0.3s ease;
        }

        .info-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        .label { 
            font-size: 11px; 
            color: #777; 
            text-transform: uppercase; 
            font-weight: bold; 
            margin-bottom: 6px; 
            display: block; 
            letter-spacing: 0.5px;
        }

        .value { font-size: 15px; color: #222; font-weight: 600; }

        /* Panel Khusus Admin (Warna Soft Gold) */
        .admin-panel { 
            background: #fffdf5; 
            border: 1px solid #f8e8a2; 
            padding: 30px; 
            border-radius: 15px; 
            margin-top: 15px; 
            box-shadow: inset 0 0 10px rgba(248, 194, 15, 0.05);
        }

        /* Tombol - Tombol */
        .action-buttons { 
            display: flex; 
            justify-content: center; 
            gap: 15px; 
            margin-top: 40px; 
        }

        .btn { 
            padding: 14px 28px; 
            border-radius: 10px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 14px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            transition: 0.3s; 
        }

        .btn-back { background: #6c757d; color: white; }
        .btn-back:hover { background: #5a6268; }

        .btn-admin { background: #0f5132; color: white; }
        .btn-admin:hover { background: #0a3d25; transform: scale(1.05); }

        @media (max-width: 600px) { 
            .info-grid { grid-template-columns: 1fr; } 
            .content-body { padding: 25px; }
        }
        /* ================= CSS GANTENG END ================= */
    </style>
</head>
<body>

<div class="container">
    <?php if($is_admin): ?>
        <div class="admin-alert">
            <i class="fas fa-user-shield"></i> MODE ADMIN: Seluruh data pribadi ditampilkan secara lengkap.
        </div>
    <?php endif; ?>

    <div class="header-profile">
        <div class="photo-wrapper">
            <img src="uploads/<?php echo !empty($data['foto']) ? htmlspecialchars($data['foto']) : 'foto.webp'; ?>" alt="Profil Alumni">
        </div>
        <h1><?php echo htmlspecialchars($data['nama']); ?></h1>
        <p class="sub-header" style="margin-top: 5px;">
            🎓 Angkatan <?php echo htmlspecialchars($data['angkatan']); ?> &nbsp;|&nbsp; 📚 <?php echo htmlspecialchars($data['jurusan']); ?>
        </p>
    </div>

    <div class="content-body">
        
        <h3 class="section-title">Informasi Profil Umum</h3>
        <div class="info-grid">
            <div class="info-card"><span class="label">Fakultas</span><div class="value">🏫 <?php echo htmlspecialchars($data['fakultas'] ?? '-'); ?></div></div>
            <div class="info-card"><span class="label">Jenis Kelamin</span><div class="value">⚧ <?php echo htmlspecialchars($data['jenis_kelamin'] ?? '-'); ?></div></div>
            <div class="info-card"><span class="label">Tempat Lahir</span><div class="value">📍 <?php echo htmlspecialchars($data['tempat_lahir'] ?? '-'); ?></div></div>
            <div class="info-card"><span class="label">Tanggal Lahir</span><div class="value">📅 <?php echo htmlspecialchars($data['tanggal_lahir'] ?? '-'); ?></div></div>
            <div class="info-card"><span class="label">Pekerjaan</span><div class="value">💼 <?php echo htmlspecialchars($data['jabatan'] ?? '-'); ?></div></div>
            <div class="info-card"><span class="label">Cita-Cita</span><div class="value">🌟 <?php echo htmlspecialchars($data['cita_cita'] ?? '-'); ?></div></div>
        </div>

        <?php if($is_admin): ?>
            <div class="admin-panel">
                <h3 class="section-title" style="color: #856404; border-color: #f8c20f;">Data Kontak & Privasi</h3>
                <div class="info-grid" style="margin-bottom: 0;">
                    <div class="info-card"><span class="label">Email Aktif</span><div class="value">📧 <?php echo htmlspecialchars($data['email'] ?? '-'); ?></div></div>
                    <div class="info-card"><span class="label">Nomor WhatsApp</span><div class="value">📱 <?php echo htmlspecialchars($data['hp'] ?? '-'); ?></div></div>
                    <div class="info-card" style="grid-column: span 2;"><span class="label">Alamat Domisili</span><div class="value">🏠 <?php echo htmlspecialchars($data['alamat_domisili'] ?? '-'); ?></div></div>
                    <div class="info-card" style="grid-column: span 2;"><span class="label">Alamat Asal</span><div class="value">🏡 <?php echo htmlspecialchars($data['alamat_asal'] ?? '-'); ?></div></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            
            <?php if($is_admin): ?>
                <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-admin">
                    <i class="fas fa-user-cog"></i> Edit Profil (Admin)
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>