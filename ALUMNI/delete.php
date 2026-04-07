<?php
session_start();


// CEK APAKAH DIA ADMIN
if($_SESSION['role'] != "admin"){
    echo "Akses ditolak! Halaman ini hanya untuk admin.";
    exit;
}

// KONEKSI DATABASE
include "koneksi.php";

// PROSES HAPUS DATA
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM alumni WHERE id='$id'";

    if(mysqli_query($conn, $query)){
        header("Location: index.php");
        exit();
    } else {
        echo "Error menghapus data: " . mysqli_error($conn);
    }
}else{
    header("Location: index.php");
    exit();
}
?>

<?php
$conn = mysqli_connect("localhost","root","","db_alumni");
if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "DELETE FROM alumni WHERE id='$id'";
    
    if(mysqli_query($conn, $query)){
        header("Location: index.php");
        exit();
    } else {
        echo "Error menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>