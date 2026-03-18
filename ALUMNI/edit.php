<?php
session_start();

// CEK LOGIN
if(!isset($_SESSION['nia'])){
    header("Location: ../login/login.php");
    exit;
}

// CEK ROLE ADMIN
if($_SESSION['role'] != "admin"){
    echo "Akses ditolak!";
    exit;
}

include "koneksi.php";

// AMBIL DATA BERDASARKAN ID
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM alumni WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);

    if(!$data){
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// PROSES UPDATE
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

    $update = mysqli_query($conn,"UPDATE alumni SET
        nama='$nama',
        nia='$nia',
        jenis_kelamin='$jenis_kelamin',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir='$tanggal_lahir',
        jurusan='$jurusan',
        fakultas='$fakultas',
        angkatan='$angkatan',
        jabatan='$jabatan',
        email='$email',
        hp='$hp',
        alamat_domisili='$alamat_domisili',
        alamat_asal='$alamat_asal',
        motto='$motto',
        cita_cita='$cita_cita'
        WHERE id='$id'
    ");

    if($update){
        header("Location: index.php");
        exit;
    }else{
        echo "Gagal update data";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Alumni</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
padding:20px;
}

.container{
background:white;
padding:30px;
border-radius:10px;
max-width:700px;
margin:auto;
}

input,select,textarea{
width:100%;
padding:10px;
margin-bottom:10px;
border:1px solid #ccc;
border-radius:5px;
}

button{
background:#28a745;
color:white;
border:none;
padding:10px 20px;
border-radius:6px;
cursor:pointer;
}

a{
text-decoration:none;
color:white;
background:#6c757d;
padding:10px 20px;
border-radius:6px;
}

</style>

</head>

<body>

<div class="container">

<h2>Edit Data Alumni</h2>

<form method="POST">

<label>Nama</label>
<input type="text" name="nama" value="<?php echo $data['nama']; ?>">

<label>NIA</label>
<input type="text" name="nia" value="<?php echo $data['nia']; ?>">

<label>Jenis Kelamin</label>
<select name="jenis_kelamin">
<option value="Laki-laki" <?php if($data['jenis_kelamin']=="Laki-laki") echo "selected"; ?>>Laki-laki</option>
<option value="Perempuan" <?php if($data['jenis_kelamin']=="Perempuan") echo "selected"; ?>>Perempuan</option>
</select>

<label>Tempat Lahir</label>
<input type="text" name="tempat_lahir" value="<?php echo $data['tempat_lahir']; ?>">

<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir']; ?>">

<label>Jurusan</label>
<input type="text" name="jurusan" value="<?php echo $data['jurusan']; ?>">

<label>Fakultas</label>
<input type="text" name="fakultas" value="<?php echo $data['fakultas']; ?>">

<label>Angkatan</label>
<input type="number" name="angkatan" value="<?php echo $data['angkatan']; ?>">

<label>Pekerjaan</label>
<input type="text" name="jabatan" value="<?php echo $data['jabatan']; ?>">

<label>Email</label>
<input type="email" name="email" value="<?php echo $data['email']; ?>">

<label>No HP</label>
<input type="text" name="hp" value="<?php echo $data['hp']; ?>">

<label>Alamat Domisili</label>
<textarea name="alamat_domisili"><?php echo $data['alamat_domisili']; ?></textarea>

<label>Alamat Asal</label>
<textarea name="alamat_asal"><?php echo $data['alamat_asal']; ?></textarea>

<label>Motto</label>
<textarea name="motto"><?php echo $data['motto']; ?></textarea>

<label>Cita Cita</label>
<textarea name="cita_cita"><?php echo $data['cita_cita']; ?></textarea>

<br>

<button type="submit" name="submit">Simpan Perubahan</button>
<a href="alumni.php">Batal</a>

</form>

</div>

</body>
</html>