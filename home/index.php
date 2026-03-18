<?php
// 1. Tambahkan session_start() agar PHP bisa mengecek status login
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CSSMORA Alumni</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<header>
    <div class="pembungkus nav"> 
        <img src="../home/cssmora.jpeg" class="logo-img" alt="Logo">
       <nav>
    <a href="../home/index.php" class="active">Home</a>
    
    <a href="../ALUMNI/index.php">Alumni</a>
    
    <a href="../INFO/index.php">Info Kegiatan</a> 
    <a href="../berita/index.php">Berita</a>
    
    <?php if(isset($_SESSION['nia'])): ?>
        <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="../login/dashboard/index.php">Dashboard</a>
        <?php endif; ?>
        <a href="../login/profil.php">Profil</a>
        <a href="../login/logout.php" class="tombol-login" style="background: #dc3545;">Logout</a>
    <?php else: ?>
        <a href="../login/index.php" class="tombol-login">Login</a>
    <?php endif; ?>
</nav>
    </div>
</header>


<section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        
        <h1>Digitalisasi Alumni CSSMORA</h1>
        <p>Canal alumni untuk mengelola data alumni, <br>mempererat komunikasi </p>
        
        <form action="../ALUMNI/index.php" method="GET" class="form-hero-kuning">
            <input type="text" name="cari" placeholder="Cari Alumni..." class="input-cari-kuning">
            <button type="submit" style="display:none;"></button>
        </form>
    </div>
</section>

<section class="fitur container">
    <div class="card">
        <img src="orang2.png" alt="Data Alumni" class="card-icon">
        <h3>Data Alumni</h3>
        <hr>
        <p>Kelola dan akses data alumni secara terpusat dan rapi.</p>
    </div>
    <div class="card">
        <img src="cari.png" alt="Cari Alumni" class="card-icon">
        <h3>Cari Alumni</h3>
        <hr>
        <p>Temukan teman lama berdasarkan nama, angkatan, atau pekerjaan.</p>
    </div>
    <div class="card">
        <img src="info2.png" alt="Info Kegiatan" class="card-icon">
        <h3>Info Kegiatan</h3>
        <hr>
        <p>Lihat event reuni, seminar, dan kegiatan alumni terbaru.</p>
    </div>
</section>

<section class="statistik">
    <div class="stat-box">

        <div class="stat-title">
            <div class="garis"></div>
            <h2>Statistik Alumni</h2>
            <div class="garis"></div>
        </div>

        <div class="stat-content">

            <div class="stat-item">
                <div class="stat-icon hijau">
                    <img src="alumni.png" alt="Icon Alumni">
                </div>
                <div>
                    <h3>12,500</h3>
                    <p>Alumni</p>
                </div>

                <div class="social-media">
                    <h4>Follow Us</h4>

                    <div class="social-icons">
                        <a href="https://www.facebook.com/cssmora.nasional" target="_blank" class="icon-link">
                            <div class="icon-box">
                                <img src="../img/fb.png" alt="Facebook">
                                <span>Facebook</span>
                            </div>
                        </a>

                        <a href="https://l.instagram.com/?u=https%3A%2F%2Flinktr.ee%2Fcssmorauinam8" target="_blank" class="icon-link">
                            <div class="icon-box">
                                <img src="../img/ig.png" alt="Instagram">
                                <span>Instagram</span>
                            </div>
                        </a>

                        <a href="http://www.youtube.com/@cssmorauinam" target="_blank" class="icon-link">
                            <div class="icon-box">
                                <img src="../img/yt.png" alt="YouTube">
                                <span>YouTube</span>
                            </div>
                        </a>

                        <a href="https://www.tiktok.com/@cssmorauinam" target="_blank" class="icon-link">
                            <div class="icon-box">
                                <img src="../img/tt.png" alt="TikTok">
                                <span>TikTok</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-icon emas">
                    <img src="topi.png" alt="Icon Topi">
                </div>
                <div>
                    <h3>250</h3>
                    <p>Angkatan</p>
                </div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-icon hijau">
                    <img src="palu.png" alt="Icon Palu">
                </div>
                <div>
                    <h3>85</h3>
                    <p>Pengurus</p>
                </div>
            </div>

        </div>

    </div>
</section>

<footer class="footer">
    © 2019 UIN Alauddin Makassar. All Rights Reserved.
</footer>
</body>
</html>