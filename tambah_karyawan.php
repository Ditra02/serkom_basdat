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
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $divisi = $_POST['divisi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];

    // Query untuk menambahkan data ke tabel karyawan
    $sql = "INSERT INTO karyawan (nama, pekerjaan, divisi, jenis_kelamin, no_telp) 
            VALUES ('$nama', '$pekerjaan', '$divisi', '$jenis_kelamin', '$no_telp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Karyawan berhasil ditambahkan!');</script>";
        echo "<script>window.location='list_karyawan.php';</script>"; // Redirect ke halaman daftar karyawan
        // header("Location: barang_it.php");
        // exit();
    } else {
        echo "Error: " . $conn->error;
    }

    // Tutup koneksi database
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link rel="stylesheet" href="css/tambah_karyawan.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah Karyawan</h1>
        <form method="POST" action="">
            <!-- Nama -->
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama karyawan" required>
            </div>
            <!-- Pekerjaan -->
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" placeholder="Masukkan pekerjaan karyawan" required>
            </div>
            <!-- Divisi -->
            <div class="form-group">
                <label for="divisi">Divisi</label>
                <input type="text" id="divisi" name="divisi" placeholder="Masukkan divisi karyawan" required>
            </div>
            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <!-- No Telepon -->
            <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" id="no_telp" name="no_telp" placeholder="Masukkan no telepon karyawan" required>
            </div>
            <!-- Submit Button -->
            <button type="submit">Tambah Karyawan</button>
        </form>
    </div>
</body>
</html>
