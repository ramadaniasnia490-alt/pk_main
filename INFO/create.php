<?php
session_start();
if(!isset($_SESSION['nia']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak: Hanya Admin!'); window.location='index.php';</script>";
    exit;
}

include "koneksi.php";

if(isset($_POST['simpan'])){
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']); // Ini variabelnya
    $waktu     = mysqli_real_escape_string($conn, $_POST['waktu']);
    $lokasi    = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // PERBAIKAN: Gunakan nama kolom 'tanggal_kegiatan' dan variabel '$tanggal'
    $query_kegiatan = mysqli_query($conn, "INSERT INTO kegiatan (judul, kategori, tanggal_kegiatan, waktu, lokasi, deskripsi) 
                                           VALUES ('$judul', '$kategori', '$tanggal', '$waktu', '$lokasi', '$deskripsi')");
    
    if($query_kegiatan){
        $id_kegiatan = mysqli_insert_id($conn);
        $jumlah_foto = count($_FILES['foto']['name']);
        
        for($i = 0; $i < $jumlah_foto; $i++){
            $nama_file = $_FILES['foto']['name'][$i];
            $tmp_file  = $_FILES['foto']['tmp_name'][$i];
            
            if($nama_file != ""){
                $nama_unik = time() . "_" . rand(100,999) . "_" . $nama_file;
                $tujuan = "uploads/" . $nama_unik;

                if(move_uploaded_file($tmp_file, $tujuan)){
                    mysqli_query($conn, "INSERT INTO galeri_kegiatan (id_kegiatan, nama_foto) VALUES ('$id_kegiatan', '$nama_unik')");
                }
            }
        }
        echo "<script>alert('Kegiatan dan foto berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        // Tips: Tambahkan mysqli_error agar tahu persis salahnya di mana jika gagal
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Kegiatan Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .form-box { background: white; max-width: 600px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 5px solid #1f5f3f; }
        label { display: block; margin-top: 15px; font-weight: 500; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: 'Poppins', sans-serif;}
        button { margin-top: 20px; width: 100%; padding: 12px; background: #1f5f3f; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        button:hover { background: #144d32; }
        .btn-batal { display: block; text-align: center; margin-top: 10px; color: #dc3545; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2 style="text-align:center; color:#1f5f3f; margin-top:0;">Tambah Kegiatan</h2>
        <form method="POST" enctype="multipart/form-data">
            
            <label>Judul Kegiatan</label>
            <input type="text" name="judul" required>

            <label>Kategori</label>
            <input type="text" name="kategori" placeholder="Contoh: Seminar, Reuni, dll" required>

            <div style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" required>
                </div>
                <div style="flex:1;">
                    <label>Waktu</label>
                    <input type="time" name="waktu" required>
                </div>
            </div>

            <label>Lokasi</label>
            <input type="text" name="lokasi" required>

            <label>Deskripsi Lengkap</label>
            <textarea name="deskripsi" rows="6" required></textarea>

            <label>Upload Foto (Bisa pilih lebih dari satu file sekaligus)</label>
            <input type="file" name="foto[]" multiple accept="image/*" required>

            <button type="submit" name="simpan">Simpan Kegiatan</button>
            <a href="index.php" class="btn-batal">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>