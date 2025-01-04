<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']); // Escape input untuk keamanan
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna berdasarkan email
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Cek apakah password di-hash
        // if (password_verify($password, $user['password'])) {

        if ($password === $user['password']) {
            // Simpan informasi user ke session
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['akses'] = $user['akses'];

            // Redirect ke halaman index.php
            header("Location: index.php");
            exit();
        } else {
            // Password salah
            $_SESSION['login_error'] = "Password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Email tidak ditemukan
        $_SESSION['login_error'] = "Email tidak ditemukan!";
        header("Location: login.php");
        exit();
    }
} else {
    // Jika metode tidak POST, redirect ke form login
    header("Location: login.php");
    exit();
}
?>
