<?php
session_start();

// Menghapus semua data session (mengeluarkan admin)
session_unset();
session_destroy();

// Mengarahkan langsung ke halaman Home
header("Location: ../home/index.php");
exit;
?>