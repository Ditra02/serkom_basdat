<?php
session_start(); // Memulai session
session_destroy(); // Menghancurkan semua session
header("Location: index.php"); // Redirect ke halaman login
exit();
?>
