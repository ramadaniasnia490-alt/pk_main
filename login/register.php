<?php
include "koneksi.php";

if(isset($_POST['register'])){

    $nia = mysqli_real_escape_string($conn, $_POST['nia']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // PERBAIKAN KEAMANAN: Role otomatis dikunci sebagai 'user'
    // Pengunjung tidak lagi bisa memilih role mereka sendiri.
    $role = 'user';

    // 1. CEK APAKAH NIA ADA DI TABEL ALUMNI (Validasi Data Asli)
    $cek_alumni = mysqli_query($conn, "SELECT * FROM alumni WHERE nia='$nia'");
    
    if(mysqli_num_rows($cek_alumni) == 0){
        // Jika NIA tidak ditemukan di database alumni
        echo "<script>alert('Pendaftaran Gagal: NIA Anda belum terdaftar di sistem. Silakan melapor ke Admin lewat tombol WhatsApp!'); window.location='register.php';</script>";
    } else {
        // 2. JIKA NIA ADA, CEK APAKAH DIA SUDAH PUNYA AKUN DI TABEL USERS
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE nia='$nia'");
        
        if(mysqli_num_rows($cek_user) > 0){
            // Jika akun sudah pernah dibuat
            echo "<script>alert('Pendaftaran Gagal: Akun dengan NIA ini sudah pernah dibuat! Silakan langsung Login.'); window.location='login.php';</script>";
        } else {
            // 3. JIKA LOLOS SEMUA PENGECEKAN, BUAT AKUN BARU DENGAN ROLE 'USER'
            $query = mysqli_query($conn,"INSERT INTO users (nia,password,role) VALUES ('$nia','$password','$role')");

            if($query){
                echo "<script>alert('Akun berhasil dibuat! Silakan Login menggunakan NIA dan Password Anda.'); window.location='login.php';</script>";
            }else{
                echo "<script>alert('Terjadi kesalahan pada sistem database.'); window.location='register.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - CSSMoRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login-background">

<div class="login-container">
    <div class="login-header">
        DAFTAR AKUN
    </div>

    <form method="POST" action="">
        <label>NIA</label>
        <div class="input-icon">
            <i class="fa fa-id-card"></i>
            <input type="text" name="nia" placeholder="Masukkan NIA valid Anda" required>
        </div>

        <label>Password</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Buat Password" required>
        </div>

        <button type="submit" name="register" class="btn-login" style="margin-top: 10px;">DAFTAR</button>

        <p class="register-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
            <br><br>
            <a href="../home/index.php" style="color: #666; font-size: 13px; font-weight: normal; text-decoration: underline;">&larr; Kembali ke Halaman Utama</a>
        </p>
    </form>
</div>

<a href="https://wa.me/6285705701024?text=Halo%20Admin%20CSSMoRA,%20saya%20ingin%20melapor%20terkait%20pembuatan%20akun%20alumni." class="float-wa" target="_blank" title="Hubungi Admin">
    <i class="fab fa-whatsapp"></i>
</a>

</body>
</html>