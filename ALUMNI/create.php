<?php
include "koneksi.php";

if(isset($_POST['submit'])){

    $nama            = mysqli_real_escape_string($conn, $_POST['nama']);
    $nia             = mysqli_real_escape_string($conn, $_POST['nia']);
    $jenis_kelamin   = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $tempat_lahir    = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir   = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $jurusan         = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $fakultas        = mysqli_real_escape_string($conn, $_POST['fakultas']);
    $angkatan        = mysqli_real_escape_string($conn, $_POST['angkatan']);
    $jabatan         = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $hp              = mysqli_real_escape_string($conn, $_POST['hp']);
    $alamat_domisili = mysqli_real_escape_string($conn, $_POST['alamat_domisili']);
    $alamat_asal     = mysqli_real_escape_string($conn, $_POST['alamat_asal']);
    $motto           = mysqli_real_escape_string($conn, $_POST['motto']);
    $cita_cita       = mysqli_real_escape_string($conn, $_POST['cita_cita']);

    // PROSES UPLOAD FOTO
    $nama_foto = '';

    if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_file    = $_FILES['foto']['tmp_name'];

        $ekstensi_ok = array('png','jpg','jpeg','webp');
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if(!in_array($ekstensi, $ekstensi_ok)){
            echo "<script>alert('Format foto tidak didukung! Gunakan JPG/PNG/WEBP.'); window.history.back();</script>";
            exit;
        }
        if($ukuran_file > 2048000){
            echo "<script>alert('Ukuran foto terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
            exit;
        }

        $nama_foto     = time() . '-' . rand(100,999) . '.' . $ekstensi;
        $folder_upload = __DIR__ . '/uploads/';

        if(!is_dir($folder_upload)){
            mkdir($folder_upload, 0777, true);
        }

        if(!move_uploaded_file($tmp_file, $folder_upload . $nama_foto)){
            echo "<script>alert('Gagal upload foto!'); window.history.back();</script>";
            exit;
        }
    }

    $query = "INSERT INTO alumni 
    (nama, nia, jenis_kelamin, tempat_lahir, tanggal_lahir, jurusan, fakultas, angkatan, jabatan, email, hp, alamat_domisili, alamat_asal, motto, cita_cita, foto) 
    VALUES 
    ('$nama','$nia','$jenis_kelamin','$tempat_lahir','$tanggal_lahir','$jurusan','$fakultas','$angkatan','$jabatan','$email','$hp','$alamat_domisili','$alamat_asal','$motto','$cita_cita','$nama_foto')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data alumni berhasil ditambahkan!'); window.location='index.php?sembunyikan_nav=ya';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alumni</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; color: #0f5132; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        .btn { padding: 12px 25px; border-radius: 5px; text-decoration: none; display: inline-block; margin-right: 10px; border: none; cursor: pointer; font-size: 15px; }
        .btn-save { background: #28a745; color: white; }
        .btn-save:hover { background: #218838; }
        .btn-cancel { background: #6c757d; color: white; }

        /* BOX FOTO */
        .foto-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .foto-box label { font-weight: bold; margin-bottom: 8px; display: block; }
        .foto-box input[type=file] { padding: 8px; }
        .foto-box small { color: #dc3545; font-style: italic; font-size: 12px; display: block; margin-top: 5px; }

        /* PREVIEW FOTO SEBELUM UPLOAD */
        #preview-foto {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0f5132;
            margin-bottom: 10px;
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>➕ Tambah Alumni Baru</h1>
    <form method="POST" action="" enctype="multipart/form-data">

        <!-- FOTO -->
        <div class="foto-box">
            <label>📷 Foto Profil</label>
            <img id="preview-foto" src="" alt="Preview Foto">
            <input type="file" name="foto" accept="image/jpeg,image/png,image/webp"
                   onchange="previewFoto(this)">
            <small>*Opsional. Format: JPG/PNG/WEBP, Maks 2MB.</small>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>
        <div class="form-group">
            <label>NIA</label>
            <input type="text" name="nia" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir">
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir">
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <input type="text" name="jurusan">
        </div>
        <div class="form-group">
            <label>Fakultas</label>
            <input type="text" name="fakultas">
        </div>
        <div class="form-group">
            <label>Angkatan</label>
            <input type="number" name="angkatan">
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" name="jabatan">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>
        <div class="form-group">
            <label>HP</label>
            <input type="text" name="hp">
        </div>
        <div class="form-group">
            <label>Alamat Domisili</label>
            <textarea name="alamat_domisili" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Alamat Asal</label>
            <textarea name="alamat_asal" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Motto</label>
            <textarea name="motto" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Cita-Cita</label>
            <textarea name="cita_cita" rows="2"></textarea>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" name="submit" class="btn btn-save">💾 Simpan</button>
            <a href="index.php?sembunyikan_nav=ya" class="btn btn-cancel">❌ Batal</a>
        </div>
    </form>
</div>

<script>
function previewFoto(input) {
    var preview = document.getElementById('preview-foto');
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>