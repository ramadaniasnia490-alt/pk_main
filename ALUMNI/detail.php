<?php
include "koneksi.php";

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM alumni WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    
    if(!$data){
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak ditemukan!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Alumni - <?php echo $data['nama']; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #ddd;
            margin: 0 auto 15px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo .placeholder {
            font-size: 50px;
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        h1 {
            color: #333;
            margin-bottom: 5px;
        }

        .nia {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f9f9f9;
            padding: 12px 15px;
            border-radius: 5px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .motto-section {
            background: #fff8e1;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
            border-radius: 5px;
        }

        .motto-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .motto-text {
            font-style: italic;
            color: #333;
        }

        .back-btn {
            display: inline-block;
            background: #0f5132;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background: #0c3d27;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- HEADER -->
    <div class="header">
        <div class="profile-photo">
            <?php if(!empty($data['foto'])): ?>
                <img src="<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>">
            <?php else: ?>
                <span class="placeholder">👤</span>
            <?php endif; ?>
        </div>
        <h1><?php echo htmlspecialchars($data['nama']); ?></h1>
        <p class="nia">NIA: <?php echo htmlspecialchars($data['nia'] ?? '-'); ?></p>
        <p style="color: #666; font-size: 14px;">
            🎓 Angkatan <?php echo htmlspecialchars($data['angkatan'] ?? '-'); ?> | 
            📚 <?php echo htmlspecialchars($data['jurusan'] ?? '-'); ?>
        </p>
    </div>

    <!-- INFO GRID -->
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
        <div class="info-item">
            <div class="info-label">🏡 Alamat Asal</div>
            <div class="info-value"><?php echo htmlspecialchars($data['alamat_asal'] ?? '-'); ?></div>
        </div>
    </div>

    <!-- MOTTO -->
    <?php if(!empty($data['motto'])): ?>
    <div class="motto-section">
        <div class="motto-label">💬 Motto</div>
        <div class="motto-text"><?php echo htmlspecialchars($data['motto']); ?></div>
    </div>
    <?php endif; ?>

    <!-- CITA-CITA -->
    <?php if(!empty($data['cita_cita'])): ?>
    <div class="info-item">
        <div class="info-label">🌟 Cita-Cita</div>
        <div class="info-value"><?php echo htmlspecialchars($data['cita_cita']); ?></div>
    </div>
    <?php endif; ?>

    <!-- BACK BUTTON -->
    <div style="text-align: center;">
        <a href="index.php" class="back-btn">← Kembali</a>
    </div>
</div>

</body>
</html>