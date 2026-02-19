<?php
session_start();
session_destroy(); // Menghapus semua sesi login
header("Location: login.php"); // Mengarahkan kembali ke halaman login
exit;
?>
