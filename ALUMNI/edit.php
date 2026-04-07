<?php
session_start();

// CEK ROLE ADMIN
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    echo "Akses ditolak!";
    exit;
}

include "koneksi.php";

// AMBIL DATA BERDASARKAN ID
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM alumni WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    if(!$data){ echo "Data tidak ditemukan!"; exit(); }
} else {
    header("Location: index.php");
    exit();
}

// PROSES UPDATE
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

    // Default pakai foto lama
    $nama_foto_simpan = $data['foto'];

    // PROSES UPLOAD FOTO
    if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_file    = $_FILES['foto']['tmp_name'];

        $ekstensi_ok = array('png','jpg','jpeg','webp');
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if(!in_array($ekstensi, $ekstensi_ok)){
            echo "<script>alert('Format foto tidak didukung!');</script>";
            exit;
        }
        if($ukuran_file > 2048000){
            echo "<script>alert('Ukuran foto terlalu besar! Maks 2MB.');</script>";
            exit;
        }

        $nama_baru     = time() . '-' . rand(100,999) . '.' . $ekstensi;
        $folder_upload = __DIR__ . '/uploads/';

        if(!is_dir($folder_upload)){
            mkdir($folder_upload, 0777, true);
        }

        // Hapus foto lama
        if(!empty($data['foto']) && file_exists($folder_upload . $data['foto'])){
            unlink($folder_upload . $data['foto']);
        }

        if(move_uploaded_file($tmp_file, $folder_upload . $nama_baru)){
            $nama_foto_simpan = $nama_baru;
        } else {
            echo "<script>alert('Gagal upload foto!');</script>";
            exit;
        }
    }

    // UPDATE SEMUA DATA
    $update = mysqli_query($conn,"UPDATE alumni SET
        nama             = '$nama',
        nia              = '$nia',
        jenis_kelamin    = '$jenis_kelamin',
        tempat_lahir     = '$tempat_lahir',
        tanggal_lahir    = '$tanggal_lahir',
        jurusan          = '$jurusan',
        fakultas         = '$fakultas',
        angkatan         = '$angkatan',
        jabatan          = '$jabatan',
        email            = '$email',
        hp               = '$hp',
        alamat_domisili  = '$alamat_domisili',
        alamat_asal      = '$alamat_asal',
        motto            = '$motto',
        cita_cita        = '$cita_cita',
        foto             = '$nama_foto_simpan'
        WHERE id='$id'
    ");

    if($update){
        echo "<script>alert('Data berhasil disimpan!'); window.location='index.php?sembunyikan_nav=ya';</script>";
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Alumni</title>
<style>
body { font-family: Arial; background: #f2f2f2; padding: 20px; }
.container { background: white; padding: 30px; border-radius: 10px; max-width: 700px; margin: auto; }
input, select, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
button { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; }
a { text-decoration: none; color: white; background: #6c757d; padding: 10px 20px; border-radius: 6px; display: inline-block; }
.foto-preview { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; margin-bottom: 8px; display: block; }
</style>
</head>
<body>
<div class="container">

<h2>Edit Data Alumni</h2>

<form method="POST" action="" enctype="multipart/form-data">

<label>Nama</label>
<input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>">

<label>NIA</label>
<input type="text" name="nia" value="<?php echo htmlspecialchars($data['nia']); ?>">

<label>Jenis Kelamin</label>
<select name="jenis_kelamin">
    <option value="Laki-laki" <?php if($data['jenis_kelamin']=="Laki-laki") echo "selected"; ?>>Laki-laki</option>
    <option value="Perempuan" <?php if($data['jenis_kelamin']=="Perempuan") echo "selected"; ?>>Perempuan</option>
</select>

<label>Tempat Lahir</label>
<input type="text" name="tempat_lahir" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>">

<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>">

<label>Jurusan</label>
<input type="text" name="jurusan" value="<?php echo htmlspecialchars($data['jurusan']); ?>">

<label>Fakultas</label>
<input type="text" name="fakultas" value="<?php echo htmlspecialchars($data['fakultas']); ?>">

<label>Angkatan</label>
<input type="number" name="angkatan" value="<?php echo htmlspecialchars($data['angkatan']); ?>">

<label>Pekerjaan</label>
<input type="text" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan']); ?>">

<label>Email</label>
<input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">

<label>No HP</label>
<input type="text" name="hp" value="<?php echo htmlspecialchars($data['hp']); ?>">

<label>Alamat Domisili</label>
<textarea name="alamat_domisili"><?php echo htmlspecialchars($data['alamat_domisili']); ?></textarea>

<label>Alamat Asal</label>
<textarea name="alamat_asal"><?php echo htmlspecialchars($data['alamat_asal']); ?></textarea>

<label>Motto</label>
<textarea name="motto"><?php echo htmlspecialchars($data['motto']); ?></textarea>

<label>Cita Cita</label>
<textarea name="cita_cita"><?php echo htmlspecialchars($data['cita_cita']); ?></textarea>

<div style="margin-bottom: 15px;">
    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Foto Profil:</label>

    <?php if(!empty($data['foto'])): ?>
        <p style="margin: 0 0 5px; font-size: 13px; color: #666;">Foto saat ini:</p>
        <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>"
             class="foto-preview"
             onerror="this.style.display='none'">
    <?php else: ?>
        <p style="font-size: 13px; color: #999; margin-bottom: 8px;">Belum ada foto.</p>
    <?php endif; ?>

    <input type="file" name="foto" accept="image/jpeg,image/png,image/webp">
    <small style="color: #dc3545; font-style: italic;">*Kosongkan jika tidak ingin ganti. Format: JPG/PNG/WEBP, Maks 2MB.</small>
</div>

<button type="submit" name="submit">Simpan Perubahan</button>
&nbsp;
<a href="index.php?sembunyikan_nav=ya">Batal</a>

</form>
</div>
</body>
</html>