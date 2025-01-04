<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Query untuk menghapus data karyawan berdasarkan id_karyawan
    $sql = "DELETE FROM karyawan WHERE id_karyawan = $id_karyawan";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Karyawan berhasil dihapus!');</script>";
        echo "<script>window.location='list_karyawan.php';</script>"; // Redirect ke halaman daftar karyawan
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<script>alert('ID karyawan tidak ditemukan!');</script>";
    echo "<script>window.location='list_karyawan.php';</script>"; // Redirect ke halaman daftar karyawan
}

// Tutup koneksi database
$conn->close();
?>
