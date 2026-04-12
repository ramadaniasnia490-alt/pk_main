<?php
session_start();
include "../login/koneksi.php";
include "koneksi.php"; // ← WAJIB ADA

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "SELECT * FROM kegiatan WHERE id='$id'");
$data  = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $waktu     = mysqli_real_escape_string($conn, $_POST['waktu']);
    $lokasi    = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    mysqli_query($conn, "UPDATE kegiatan SET judul='$judul', kategori='$kategori', tanggal_kegiatan='$tanggal', waktu='$waktu', lokasi='$lokasi', deskripsi='$deskripsi' WHERE id='$id'");
    
    if(isset($_FILES['foto']['name'][0]) && $_FILES['foto']['name'][0] != ""){
        $jumlah_foto = count($_FILES['foto']['name']);
        for($i = 0; $i < $jumlah_foto; $i++){
            $nama_file = $_FILES['foto']['name'][$i];
            $tmp_file  = $_FILES['foto']['tmp_name'][$i];
            $nama_unik = time() . "_" . rand(100,999) . "_" . $nama_file;
            if(move_uploaded_file($tmp_file, "uploads/" . $nama_unik)){
                mysqli_query($conn, "INSERT INTO galeri_kegiatan (id_kegiatan, nama_foto) VALUES ('$id', '$nama_unik')");
            }
        }
    }
    echo "<script>alert('Data kegiatan berhasil diperbarui!'); window.location='index.php';</script>";
}

// Cek apakah data ditemukan
if(!$data){
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Kegiatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .form-box { background: white; max-width: 600px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 5px solid #f8c20f; }
        label { display: block; margin-top: 15px; font-weight: 500; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: 'Poppins', sans-serif; font-size: 14px; }
        textarea { resize: vertical; }
        button { margin-top: 20px; width: 100%; padding: 12px; background: #f8c20f; color: black; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        button:hover { background: #e0ad0d; }
        .btn-batal { display: block; text-align: center; margin-top: 10px; color: #dc3545; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
<div class="form-box">
    <h2 style="text-align:center; margin-top:0;">Edit Kegiatan</h2>
    <form method="POST" enctype="multipart/form-data">

        <label>Judul Kegiatan</label>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required>

        <label>Kategori</label>
        <input type="text" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required>

        <div style="display:flex; gap:10px;">
            <div style="flex:1;">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?php echo $data['tanggal_kegiatan']; ?>" required>
            </div>
            <div style="flex:1;">
                <label>Waktu</label>
                <input type="time" name="waktu" value="<?php echo $data['waktu']; ?>" required>
            </div>
        </div>

        <label>Lokasi</label>
        <input type="text" name="lokasi" value="<?php echo htmlspecialchars($data['lokasi']); ?>" required>

        <label>Deskripsi Lengkap</label>
        <!-- ✅ Nilai deskripsi lama ditampilkan di sini -->
        <textarea name="deskripsi" id="deskripsi" rows="6"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>

        <label>Tambahkan Foto Baru (Opsional)</label>
        <input type="file" name="foto[]" multiple accept="image/*">
        <small style="color:#777;">*Biarkan kosong jika tidak ingin menambah foto.</small>

        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="index.php" class="btn-batal">Batal & Kembali</a>
    </form>
</div>

<script>
    const ta = document.getElementById('deskripsi');

    // Paksa textarea selalu bisa diedit
    ta.removeAttribute('readonly');
    ta.removeAttribute('disabled');

    // Handle paste - metode paling kompatibel
    ta.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        const start  = this.selectionStart;
        const end    = this.selectionEnd;
        this.value   = this.value.substring(0, start) + text + this.value.substring(end);
        this.selectionStart = this.selectionEnd = start + text.length;
    });
</script>
</body>
</html>