<?php
// Impor konfigurasi database
include 'config.php';

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $akses = $_POST['akses'];

    // Query untuk menyimpan data ke tabel 'user'
    $sql = "INSERT INTO user (username, email, password, akses)
            VALUES ('$username', '$email', '$password', '$akses')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User berhasil didaftarkan!');</script>";
        header("Location: login.php");
        exit(); // Tambahkan exit() untuk memastikan redirect langsung
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>
