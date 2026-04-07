<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

$nia_user = $_SESSION['nia'];
$query = mysqli_query($conn, "SELECT * FROM alumni WHERE nia='$nia_user'");
$data = mysqli_fetch_assoc($query);

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
        body { background-color: #f4f7f6; }

        .edit-wrapper {
            max-width: 700px;
            margin: 50px auto 100px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 5px solid #1f5f3f;
        }

        .form-title { text-align: center; color: #1f5f3f; margin-bottom: 30px; font-size: 24px; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #777; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;
            font-family: inherit; box-sizing: border-box;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #f8c20f; outline: none; }

        input[readonly] {
            background-color: #e9ecef !important;
            color: #6c757d;
            cursor: not-allowed;
            border: 1px solid #ced4da;
            font-weight: bold;
        }

        /* BOX FOTO */
        .foto-box {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .foto-box img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f8c20f;
        }

        .foto-box .foto-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            border: 3px solid #ccc;
        }

        .foto-box .foto-info { flex: 1; }
        .foto-box .foto-info label { font-size: 13px; color: #777; font-weight: 600; display: block; margin-bottom: 5px; }
        .foto-box .foto-info input[type=file] {
            padding: 8px; border: 1px solid #ccc; border-radius: 8px; width: 100%; box-sizing: border-box;
        }
        .foto-box small { color: #dc3545; font-style: italic; font-size: 12px; display: block; margin-top: 5px; }

        .btn-simpan {
            background: #1f5f3f; color: white; padding: 15px; border: none;
            border-radius: 8px; width: 100%; font-weight: bold; cursor: pointer;
            font-size: 16px; margin-top: 20px; transition: 0.3s;
        }
        .btn-simpan:hover { background: #144d32; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="edit-wrapper">
    <h2 class="form-title"><i class="fas fa-user-edit"></i> Edit Data Profil Saya</h2>

    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">

        <!-- FOTO PROFIL -->
        <div class="foto-box">
            <?php if(!empty($data['foto'])): ?>
                <img src="../ALUMNI/uploads/<?php echo htmlspecialchars($data['foto']); ?>"
                     onerror="this.outerHTML='<div class=\'foto-placeholder\'>👤</div>'">
            <?php else: ?>
                <div class="foto-placeholder">👤</div>
            <?php endif; ?>
            <div class="foto-info">
                <label>Ganti Foto Profil</label>
                <input type="file" name="foto" accept="image/jpeg, image/png, image/webp">
                <small>*Biarkan kosong jika tidak ingin ganti. Format: JPG/PNG/WEBP, Maks 2MB.</small>
            </div>
        </div>

        <div class="form-group">
            <label>NIA (Terkunci)</label>
            <input type="text" value="<?php echo htmlspecialchars($data['nia']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Lengkap (Terkunci)</label>
            <input type="text" value="<?php echo htmlspecialchars($data['nama']); ?>" readonly>
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

        <button type="submit" class="btn-simpan"><i class="fas fa-save"></i> Simpan Perubahan</button>
        <a href="profil.php" class="btn-batal">Batalkan</a>
    </form>
</div>

</body>
</html>