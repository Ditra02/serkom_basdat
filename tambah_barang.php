<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $status_barang = $_POST['status_barang'];
    $tanggal_input = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini

    // Query untuk menambahkan data ke tabel barang_it
    $sql = "INSERT INTO barang_it (nama_barang, jumlah_barang, status_barang, tanggal_input) 
            VALUES ('$nama_barang', $jumlah_barang, '$status_barang', '$tanggal_input')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Barang berhasil ditambahkan!');</script>";
        echo "<script>window.location='barang_it.php';</script>";
        // header("Location: barang_it.php");
        // exit();
    } else {
        echo "Error: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="css/tambah_barang.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah Barang</h1>
        <form method="POST" action="">
            <!-- Nama Barang -->
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
            </div>
            <!-- Jumlah Barang -->
            <div class="form-group">
                <label for="jumlah_barang">Jumlah Barang</label>
                <input type="number" id="jumlah_barang" name="jumlah_barang" placeholder="Masukkan jumlah barang" required>
            </div>
            <!-- Status Barang -->
            <div class="form-group">
                <label for="status_barang">Status Barang</label>
                <select id="status_barang" name="status_barang" required>
                    <option value="">Pilih status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Tambah Barang</button>
        </form>
    </div>
</body>
</html>
