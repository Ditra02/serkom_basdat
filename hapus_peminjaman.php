<?php
// Impor file konfigurasi database
include 'config.php';

// Mulai sesi untuk memastikan pengguna login
session_start();

// Periksa apakah pengguna memiliki akses sebagai admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika bukan admin, redirect ke halaman index
    echo "<script>alert('Anda tidak memiliki akses untuk menghapus data!');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Query untuk menghapus data peminjaman berdasarkan id_peminjaman
    $sql = "DELETE FROM meminjam WHERE id_peminjaman = $id_peminjaman";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data peminjaman berhasil dihapus!');</script>";
        echo "<script>window.location='peminjaman.php';</script>"; // Redirect ke halaman daftar peminjaman
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<script>alert('ID peminjaman tidak ditemukan!');</script>";
    echo "<script>window.location='peminjaman.php';</script>"; // Redirect ke halaman daftar peminjaman
    exit();
}

// Tutup koneksi database
$conn->close();
?>
