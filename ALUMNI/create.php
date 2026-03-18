<?php

// Cek apakah user sudah login
if(!isset($_SESSION['nia'])){
    header("Location: ../login/login.php");
    exit;
}

// KONEKSI DATABASE
include "koneksi.php";

if(isset($_POST['submit'])){

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nia = mysqli_real_escape_string($conn, $_POST['nia']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);
    $angkatan = mysqli_real_escape_string($conn, $_POST['angkatan']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $alamat_domisili = mysqli_real_escape_string($conn, $_POST['alamat_domisili']);
    $alamat_asal = mysqli_real_escape_string($conn, $_POST['alamat_asal']);
    $motto = mysqli_real_escape_string($conn, $_POST['motto']);
    $cita_cita = mysqli_real_escape_string($conn, $_POST['cita_cita']);

    $query = "INSERT INTO alumni 
    (nama, nia, jenis_kelamin, tempat_lahir, tanggal_lahir, jurusan, fakultas, angkatan, jabatan, email, hp, alamat_domisili, alamat_asal, motto, cita_cita) 
    VALUES 
    ('$nama','$nia','$jenis_kelamin','$tempat_lahir','$tanggal_lahir','$jurusan','$fakultas','$angkatan','$jabatan','$email','$hp','$alamat_domisili','$alamat_asal','$motto','$cita_cita')";

    if(mysqli_query($conn,$query)){
        header("Location: index.php");
        exit();
    }else{
       
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
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn { padding: 12px 25px; border-radius: 5px; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-save { background: #28a745; color: white; }
        .btn-cancel { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Tambah Alumni Baru</h1>
        <form method="POST" action="">
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
                <input type="text" name="tempat_lahir" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" required>
            </div>
            <div class="form-group">
                <label>Fakultas</label>
                <input type="text" name="fakultas" required>
            </div>
            <div class="form-group">
                <label>Angkatan</label>
                <input type="number" name="angkatan" required>
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
                <a href="index.php" class="btn btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>