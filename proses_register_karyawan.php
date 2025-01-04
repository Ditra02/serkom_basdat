<?php
// Impor konfigurasi database
include 'config.php';

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $divisi = $_POST['divisi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];

    // Query untuk menyimpan data ke tabel 'karyawan'
    $sql = "INSERT INTO karyawan (nama, pekerjaan, divisi, jenis_kelamin, no_telp)
            VALUES ('$nama', '$pekerjaan', '$divisi', '$jenis_kelamin', '$no_telp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
        header("Location: register_user.php");
        exit(); // Tambahkan exit() untuk memastikan redirect langsung
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>
