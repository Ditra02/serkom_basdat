<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Query untuk menghapus user berdasarkan id_user
    $sql = "DELETE FROM user WHERE id_user = $id_user";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User berhasil dihapus!');</script>";
        echo "<script>window.location='list_user.php';</script>";
        // header("Location: list_user.php");
        // exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<script>alert('ID user tidak ditemukan!');</script>";
    echo "<script>window.location='tampilkan_user.php';</script>"; // Redirect ke halaman user
}

// Tutup koneksi database
$conn->close();
?>
