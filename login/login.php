<?php
session_start();
include "koneksi.php";

if(isset($_POST['login'])){
    $input_user = mysqli_real_escape_string($conn, $_POST['nia']); 
    $password = $_POST['password'];

    // CEK ADMIN DULU
    $query_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$input_user'");
    $data_admin = mysqli_fetch_assoc($query_admin);

    if($data_admin){
        if(password_verify($password, $data_admin['password'])){
            $_SESSION['role'] = 'admin';
            $_SESSION['nama'] = $data_admin['nama'];
            header("Location: dashboard/index.php");
            exit;
        }
    }

    // KALAU BUKAN ADMIN, BARU CEK USER
    $query_user = mysqli_query($conn, "SELECT * FROM users WHERE nia='$input_user'");
    $data_user = mysqli_fetch_assoc($query_user);

    if($data_user){
        if(password_verify($password, $data_user['password'])){
            $_SESSION['nia'] = $data_user['nia'];
            $_SESSION['role'] = 'user';
            header("Location: profil.php");
            exit;
        }
    }
    
    echo "<script>alert('ID atau Password Salah!'); window.location='login.php';</script>";
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
    <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 15px; top: 11px; color: #777;"></i>
</div>

        <button type="submit" class="btn-login" name="login">MASUK</button>

       <p class="register-text">
    Belum punya akun? <a href="register.php">Daftar</a>
    <br><br>
    
   
    
    <a href="../home/index.php" class="kembali-home">
        <i class="fa fa-arrow-left"></i> Kembali ke Halaman Utama
    </a>
</p>

    </form>
</div>
    <a href="https://wa.me/6285705701024?text=Halo%20Admin%20CSSMoRA,%20saya%20butuh%20bantuan%20terkait%20login%20web%20alumni." class="float-wa" target="_blank" title="Hubungi Admin">
    <i class="fab fa-whatsapp"></i>
</a>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // Berpindah tipe antara password dan text
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Berganti ikon antara mata terbuka dan mata tertutup
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>