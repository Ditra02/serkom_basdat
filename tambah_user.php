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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $akses = $_POST['akses'];

    // Query untuk menambahkan data ke tabel user
    $sql = "INSERT INTO user (username, email, password, akses) 
            VALUES ('$username', '$email', '$password', '$akses')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User berhasil ditambahkan!');</script>";
        echo "<script>window.location='list_user.php';</script>";
        
        // header("Location: list_user.php");
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
    <title>Tambah User</title>
    <link rel="stylesheet" href="css/tambah_user.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah User</h1>
        <form method="POST" action="">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <!-- Akses -->
            <div class="form-group">
                <label for="akses">Hak Akses</label>
                <select id="akses" name="akses" required>
                    <option value="">Pilih Hak Akses</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Tambah User</button>
        </form>
    </div>
</body>
</html>
