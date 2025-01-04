<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Query untuk mengambil data dari tabel karyawan
$sql = "SELECT * FROM karyawan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <button onclick="location.href='index.php'" class="home-button">Kembali ke Home</button>
    <title>Daftar Karyawan</title>
    <link rel="stylesheet" href="css/list_karyawan.css">
</head>
<body>
    <h1>Daftar Karyawan</h1>
    <table>
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Pekerjaan</th>
                <th>Divisi</th>
                <th>Jenis Kelamin</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <button class='btn-tambah' onclick="location.href='tambah_karyawan.php'">Tambah Karyawan</button>
            <?php
            // Periksa apakah hasil query tidak kosong
            if ($result->num_rows > 0) {
                // Loop melalui data dan tampilkan dalam tabel
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_karyawan'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['pekerjaan'] . "</td>";
                    echo "<td>" . $row['divisi'] . "</td>";
                    echo "<td>" . ($row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan') . "</td>";
                    echo "<td>" . $row['no_telp'] . "</td>";
                    echo "<td>";
                        echo "
                            <div class='action-buttons'>
                                <button class='btn-edit' onclick=\"location.href='edit_karyawan.php?id=" . $row['id_karyawan'] . "'\">Edit</button>
                                <button class='btn-hapus' onclick=\"if(confirm('Yakin ingin menghapus data ini?')) location.href='hapus_karyawan.php?id=" . $row['id_karyawan'] . "'\">Hapus</button>
                            </div>
                        ";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data karyawan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
