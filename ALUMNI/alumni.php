<?php
session_start();

if(!isset($_SESSION['nia'])){
    header("Location: login.php");
    exit;
}

include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Data Alumni CSSMORA</title>

<style>

body{
font-family:Arial;
background:#eee;
}

.container{
width:80%;
margin:auto;
}

.card{
background:white;
padding:20px;
margin:20px;
border-radius:10px;
display:flex;
justify-content:space-between;
align-items:center;
}

button{
background:orange;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
}

</style>

</head>
<body>

<div class="container">

<h2>Data Alumni CSSMORA</h2>

<?php

$query = mysqli_query($conn,"SELECT * FROM alumni");

while($data = mysqli_fetch_array($query)){

?>

<div class="card">

<div>

<h3><?php echo $data['nama']; ?></h3>

<p>Angkatan : <?php echo $data['angkatan']; ?></p>

<p>Jurusan : <?php echo $data['program_studi']; ?></p>

<p>Pekerjaan : <?php echo $data['pekerjaan']; ?></p>

</div>

<a href="detail.php?id=<?php echo $data['id']; ?>">
<button>Lihat Profil</button>
</a>

</div>

<?php } ?>

</div>

</body>
</html>