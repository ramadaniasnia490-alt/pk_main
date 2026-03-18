<?php
session_start();
include "koneksi.php";

if(isset($_POST['login'])){

    $nia = mysqli_real_escape_string($conn, $_POST['nia']); 
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE nia='$nia'");
    $data = mysqli_fetch_assoc($query);

    if($data){
        // Cek apakah password cocok
        if(password_verify($password, $data['password'])){
            
            // Simpan data login ke session
            $_SESSION['nia'] = $data['nia'];
            $_SESSION['role'] = $data['role'];

            // LOGIKA PENGALIHAN (REDIRECT) BERDASARKAN ROLE
            if($_SESSION['role'] == 'admin'){
                // Jika Admin, masuk ke ruang kendali Dashboard
                header("Location: dashboard/index.php"); 
            } else {
                // Jika User biasa, masuk ke halaman Profil
                header("Location: ../home/index.php"); 
            }
            exit;

        }else{
            // Error jika password salah
            echo "<script>alert('Gagal Login: Password yang Anda masukkan salah!'); window.location='login.php';</script>";
        }

    }else{
        // Error jika NIA tidak ada di database
        echo "<script>alert('Gagal Login: NIA tersebut belum terdaftar!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Akun - CSSMoRA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login-background">

<div class="login-container">
    <div class="login-header">
        LOGIN AKUN
    </div>

    <form method="POST" action="">

        <label>NIA</label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="nia" placeholder="Masukkan NIA" required>
        </div>

        <label>Password</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>

        <button type="submit" class="btn-login" name="login">MASUK</button>

        <p class="register-text">
            Belum punya akun? <a href="register.php">Daftar</a>
            <br><br>
            <a href="../home/index.php" style="color: #666; font-size: 13px; font-weight: normal; text-decoration: underline;">&larr; Kembali ke Halaman Utama</a>
        </p>

    </form>
</div>
    <a href="https://wa.me/6285705701024?text=Halo%20Admin%20CSSMoRA,%20saya%20butuh%20bantuan%20terkait%20login%20web%20alumni." class="float-wa" target="_blank" title="Hubungi Admin">
    <i class="fab fa-whatsapp"></i>
</a>
</body>
</html>