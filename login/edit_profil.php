<?php
session_start();
include "koneksi.php";

// Pastikan hanya user yang login yang bisa masuk
if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

$nia_user = $_SESSION['nia'];
$query = mysqli_query($conn, "SELECT * FROM alumni WHERE nia='$nia_user'");
$data = mysqli_fetch_assoc($query);

// Jika data belum ada di tabel alumni, kembalikan ke profil
if(!$data) {
    echo "<script>alert('Data profil belum ada, hubungi Admin.'); window.location='profil.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - CSSMoRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
        body { background-color: #f4f7f6; } /* Sama dengan profil.php */
        
        .edit-wrapper {
            max-width: 700px;
            margin: 50px auto 100px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 5px solid #1f5f3f; /* Sama dengan profil.php */
        }

        .form-title { text-align: center; color: #1f5f3f; margin-bottom: 30px; font-size: 24px; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #777; margin-bottom: 5px; font-weight: 600;}
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-family: inherit; box-sizing: border-box;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #f8c20f; outline: none; }

        /* INPUT READONLY ABU-ABU */
        input[readonly] {
            background-color: #e9ecef !important;
            color: #6c757d;
            cursor: not-allowed;
            border: 1px solid #ced4da;
            font-weight: bold;
        }

        .btn-simpan {
            background: #1f5f3f; color: white; padding: 15px; border: none; border-radius: 8px; width: 100%; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 20px; transition: 0.3s;
        }
        .btn-simpan:hover { background: #144d32; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="edit-wrapper">
    <h2 class="form-title"><i class="fas fa-user-edit"></i> Edit Data Profil Saya</h2>
    
    <form action="proses_edit.php" method="POST">
        
        <div class="form-group">
            <label>NIA (Terkunci)</label>
            <input type="text" name="nia" value="<?php echo htmlspecialchars($data['nia']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>NIM (Terkunci)</label>
            <input type="text" name="nim" value="<?php echo htmlspecialchars($data['nim'] ?? '-'); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Lengkap (Terkunci)</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" readonly>
        </div>

        <hr style="border: 0; border-top: 1px dashed #ccc; margin: 25px 0;">

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Nomor HP / WA</label>
            <input type="text" name="hp" value="<?php echo htmlspecialchars($data['hp'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="<?php echo htmlspecialchars($data['tempat_lahir'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Pekerjaan / Jabatan Saat Ini</label>
            <input type="text" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Alamat Domisili</label>
            <textarea name="alamat_domisili" rows="3"><?php echo htmlspecialchars($data['alamat_domisili'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Motto</label>
            <input type="text" name="motto" value="<?php echo htmlspecialchars($data['motto'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Cita-Cita</label>
            <input type="text" name="cita_cita" value="<?php echo htmlspecialchars($data['cita_cita'] ?? ''); ?>">
        </div>
        
        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
        <a href="profil.php" class="btn-batal">Batalkan</a>
    </form>
</div>

</body>
</html>