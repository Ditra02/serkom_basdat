<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

if (!isset($_SESSION['akses'])) {
    // Jika user belum login, redirect ke halaman index
    header("Location: login.php");
    exit();
}

// Ambil data username dari tabel user
$user_query = "SELECT username FROM user";
$user_result = $conn->query($user_query);

// Ambil data nama dari tabel karyawan
$karyawan_query = "SELECT nama FROM karyawan";
$karyawan_result = $conn->query($karyawan_query);

// Ambil data nama barang dari tabel barang_it
$barang_query = "SELECT nama_barang FROM barang_it";
$barang_result = $conn->query($barang_query);

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nama_barang = $_POST['nama_barang'];
    $jml_barang = $_POST['jml_barang'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status_pengembalian = $_POST['status_pengembalian'];

    // Query untuk menambahkan data ke tabel meminjam
    $sql = "INSERT INTO meminjam (username, nama, nama_barang, jml_barang, tanggal_pinjam, tanggal_kembali, status_pengembalian) 
            VALUES ('$username', '$nama', '$nama_barang', $jml_barang, '$tanggal_pinjam', '$tanggal_kembali', '$status_pengembalian')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Peminjaman berhasil ditambahkan!');</script>";
        echo "<script>window.location='peminjaman.php';</script>"; // Redirect ke halaman daftar peminjaman
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
    <title>Tambah Peminjaman</title>
    <link rel="stylesheet" href="css/tambah_peminjaman.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah Peminjaman</h1>
        <form method="POST" action="">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <select id="username" name="username" required>
                    <option value="">Pilih Username</option>
                    <?php
                    // Loop untuk menampilkan semua username dalam dropdown
                    if ($user_result->num_rows > 0) {
                        while ($user = $user_result->fetch_assoc()) {
                            echo "<option value='" . $user['username'] . "'>" . $user['username'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data user</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Nama -->
            <div class="form-group">
                <label for="nama">Nama</label>
                <select id="nama" name="nama" required>
                    <option value="">Pilih Nama</option>
                    <?php
                    // Loop untuk menampilkan semua nama karyawan dalam dropdown
                    if ($karyawan_result->num_rows > 0) {
                        while ($karyawan = $karyawan_result->fetch_assoc()) {
                            echo "<option value='" . $karyawan['nama'] . "'>" . $karyawan['nama'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data karyawan</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Nama Barang -->
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <select id="nama_barang" name="nama_barang" required>
                    <option value="">Pilih Barang</option>
                    <?php
                    // Loop untuk menampilkan semua nama barang dalam dropdown
                    if ($barang_result->num_rows > 0) {
                        while ($barang = $barang_result->fetch_assoc()) {
                            echo "<option value='" . $barang['nama_barang'] . "'>" . $barang['nama_barang'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data barang</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Jumlah Barang -->
            <div class="form-group">
                <label for="jml_barang">Jumlah Barang</label>
                <input type="number" id="jml_barang" name="jml_barang" placeholder="Masukkan jumlah barang" required>
            </div>
            <!-- Tanggal Pinjam -->
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                <input type="datetime-local" id="tanggal_pinjam" name="tanggal_pinjam" required>
            </div>
            <!-- Tanggal Kembali -->
            <div class="form-group">
                <label for="tanggal_kembali">Tanggal Kembali</label>
                <input type="datetime-local" id="tanggal_kembali" name="tanggal_kembali" required>
            </div>
            <!-- Status Pengembalian -->
            <div class="form-group">
                <label for="status_pengembalian">Status Pengembalian</label>
                <select id="status_pengembalian" name="status_pengembalian" required>
                    <option value="">Pilih Status</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="belum dikembalikan">Belum Dikembalikan</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Tambah Peminjaman</button>
        </form>
    </div>
</body>
</html>
