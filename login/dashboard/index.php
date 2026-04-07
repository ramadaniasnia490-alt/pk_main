<?php
session_start();
// Pastikan hanya admin yang bisa masuk
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo "<script>alert('Anda harus login sebagai admin!'); window.location='../login/index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CSSMoRA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
        
        body { background-color: #ebefec; display: flex; overflow: hidden; height: 100vh; }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px; height: 100vh; background-color: #0f5132; color: white;
            position: fixed; top: 0; left: 0; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 100; display: flex; flex-direction: column;
        }

        .sidebar-header { padding: 20px; background-color: #0a3d25; text-align: center; border-bottom: 4px solid #f8c20f; }
        .sidebar-header h2 { font-size: 22px; letter-spacing: 1px; }

        .sidebar-menu { list-style: none; margin-top: 20px; flex-grow: 1; }
        .sidebar-menu li { width: 100%; }
        
        .sidebar-menu li a {
            display: flex; align-items: center; padding: 15px 25px; color: white; 
            text-decoration: none; font-size: 16px; transition: 0.3s; cursor: pointer;
        }
        .sidebar-menu li a i { margin-right: 15px; font-size: 18px; width: 20px; text-align: center; }

        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: #f8c20f; color: #000000; font-weight: bold; border-left: 5px solid #ffffff;
        }

        .logout { margin-top: 20px; background-color: #dc3545; }
        .logout:hover { background-color: #c82333 !important; color: white !important; border-left: none !important; }

        /* ================= MAIN CONTENT ================= */
        .main-content { margin-left: 260px; width: calc(100% - 260px); height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            background-color: #ffffff; padding: 15px 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: flex; justify-content: space-between; align-items: center; z-index: 10; height: 65px;
        }
        
        /* Gaya Teks Welcome dan Logo */
        .topbar .welcome { font-size: 18px; font-weight: bold; color: #333; display: flex; align-items: center; }
        .topbar .welcome img { height: 30px; width: auto; margin-right: 12px; border-radius: 4px; }

        /* ================= KOTAK JENDELA (IFRAME) ================= */
        .iframe-container { flex-grow: 1; width: 100%; background-color: #ebefec; }
        iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-user-shield"></i> ADMIN PANEL</h2>
        </div>
        
        <ul class="sidebar-menu">
            <li><a onclick="loadDefault()" class="menu-link active"><i class="fas fa-home"></i> Dashboard</a></li>
            
            <li><a href="../../ALUMNI/index.php?sembunyikan_nav=ya" target="area_konten" class="menu-link"><i class="fas fa-users"></i> Data Alumni</a></li>
            <li><a href="../../ALUMNI/create.php?sembunyikan_nav=ya" target="area_konten" class="menu-link"><i class="fas fa-user-plus"></i> Tambah Alumni</a></li>
            <li><a href="../../INFO/index.php?sembunyikan_nav=ya" target="area_konten" class="menu-link"><i class="fas fa-bullhorn"></i> INFO Kegiatan</a></li>
            <li><a href="../../berita/index.php?sembunyikan_nav=ya" target="area_konten" class="menu-link"><i class="fas fa-newspaper"></i> Berita</a></li>
        </ul>
        
        <ul class="sidebar-menu" style="flex-grow: 0;">
            <li><a href="../logout.php" target="_top" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header class="topbar">
            <div class="welcome">
                <img src="../../ALUMNI/cssmora.jpeg" alt="Logo">
                Selamat Datang, <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin'; ?>!
            </div>
            <div><i class="fas fa-user-circle" style="font-size: 30px; color: #0f5132;"></i></div>
        </header>

        <div class="iframe-container">
            <iframe name="area_konten" id="area_konten" srcdoc="
                <html>
                <head><style>
                    body { font-family: Arial; padding: 30px; background: #ebefec; margin: 0;} 
                    .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid #0f5132; } 
                    h3 { color: #0f5132; margin-bottom: 10px; }
                </style></head>
                <body>
                    <div class='card'>
                        <h3>Pusat Kendali Alumni CSSMoRA</h3>
                        <p>Silakan klik menu di sebelah kiri. Data Alumni, Tambah Alumni, Info, dan Berita akan langsung muncul di kotak ini tanpa perlu memuat ulang halaman.</p>
                    </div>
                </body>
                </html>
            "></iframe>
        </div>
    </div>

    <script>
        const menuLinks = document.querySelectorAll('.menu-link');
        
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        function loadDefault() {
            const iframe = document.getElementById('area_konten');
            iframe.removeAttribute('src'); 
            iframe.srcdoc = `
                <html>
                <head><style>
                    body { font-family: Arial; padding: 30px; background: #ebefec; margin: 0;} 
                    .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid #0f5132; } 
                    h3 { color: #0f5132; margin-bottom: 10px; }
                </style></head>
                <body>
                    <div class='card'>
                        <h3>Pusat Kendali Alumni CSSMoRA</h3>
                        <p>Silakan klik menu di sebelah kiri. Data Alumni, Tambah Alumni, Info, dan Berita akan langsung muncul di kotak ini tanpa perlu memuat ulang halaman.</p>
                    </div>
                </body>
                </html>
            `;
        }
    </script>
</body>
</html>