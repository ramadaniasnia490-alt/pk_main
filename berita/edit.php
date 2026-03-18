<?php
session_start();
if(!isset($_SESSION['nia']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}
include "koneksi.php";
$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal    = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $isi_berita = mysqli_real_escape_string($conn, $_POST['isi_berita']);
    $sumber     = mysqli_real_escape_string($conn, $_POST['sumber']);

    if($_FILES['foto']['name'] != ""){
        if(file_exists("uploads/".$data['foto'])) unlink("uploads/".$data['foto']);
        
        $nama_foto = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $nama_foto);
        mysqli_query($conn, "UPDATE berita SET judul='$judul', tanggal='$tanggal', isi_berita='$isi_berita', sumber='$sumber', foto='$nama_foto' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE berita SET judul='$judul', tanggal='$tanggal', isi_berita='$isi_berita', sumber='$sumber' WHERE id='$id'");
    }
    echo "<script>alert('Berita berhasil diperbarui!'); window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Berita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8fafc; padding: 40px; }
        .form-box { background: white; max-width: 700px; margin: auto; padding: 40px; border-radius: 22px; box-shadow: 0 15px 40px rgba(0,0,0,0.06); border-top: 5px solid #c6a94b; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #1b5e20; font-size: 14px; }
        input, textarea { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Poppins', sans-serif;}
        button { margin-top: 25px; width: 100%; padding: 14px; background: #c6a94b; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn-batal { display: block; text-align: center; margin-top: 15px; color: #dc3545; text-decoration: none; font-weight: 600;}
    </style>
</head>
<body>
    <div class="form-box">
        <h2 style="text-align:center; margin-top:0; color:#1b5e20;">Edit Berita</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Judul Berita</label>
            <input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required>

            <label>Tanggal Publikasi</label>
            <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>

            <label>Isi Berita</label>
            <textarea name="isi_berita" rows="10" required><?php echo htmlspecialchars($data['isi_berita']); ?></textarea>

            <label>Link Sumber</label>
            <input type="text" name="sumber" value="<?php echo htmlspecialchars($data['sumber']); ?>">

            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="foto" accept="image/*">

            <button type="submit" name="update">Simpan Perubahan</button>
            <a href="index.php" class="btn-batal">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>