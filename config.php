<?php
// Konfigurasi database
$host = 'localhost'; // Host database
$user = 'root';      // Username database
$password = '';      // Password database (kosong jika default XAMPP)
$database = 'peminjaman_barang_it'; // Nama database

// Koneksi ke database menggunakan mysqli
$conn = new mysqli($host, $user, $password, $database);
if (!$conn){
    echo "database tidak terkoneksi";
}else {
    echo "database terkoneksi";
}

?>
