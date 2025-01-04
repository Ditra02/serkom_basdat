<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah ID ada
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM barang_it WHERE id_barang = $id_barang";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Barang berhasil dihapus!');</script>";
        echo "<script>window.location='barang_it.php';</script>";

        // header("Location: barang_it.php");
        // exit(); // Tambahkan exit() untuk memastikan redirect langsung
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
