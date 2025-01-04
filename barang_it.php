<?php
session_start(); // Memulai session
// Impor file konfigurasi database
include 'config.php';

// Query untuk mengambil data dari tabel 'barang_it'
$sql = "SELECT * FROM barang_it";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang IT</title>
    <link rel="stylesheet" href="css/barang_it.css">
    <button onclick="location.href='index.php'" class="nav-button">Kembali ke Home</button>
</head>
<body>
    <h1>Data Barang IT</h1>
    <?php if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin'): ?>
        <button class='btn-tambah' onclick="location.href='tambah_barang.php'">Tambah barang</button>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Status Barang</th>
                <th>Tanggal Input</th>
                <?php if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin'): ?>
                    <th>Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Periksa apakah hasil query tidak kosong
            if ($result->num_rows > 0) {
                // Loop melalui data dan tampilkan dalam tabel
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_barang'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . $row['jumlah_barang'] . "</td>";
                    echo "<td>" . ucfirst($row['status_barang']) . "</td>";
                    echo "<td>" . $row['tanggal_input'] . "</td>";
                    
                    // Tampilkan tombol hanya jika pengguna adalah admin
                    if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin') {
                        echo "<td>";
                        echo "
                            <div class='action-buttons'>
                                <button class='btn-edit' onclick=\"location.href='edit_barang.php?id=" . $row['id_barang'] . "'\">Edit</button>
                                <button class='btn-hapus' onclick=\"if(confirm('Yakin ingin menghapus data ini?')) location.href='hapus_barang.php?id=" . $row['id_barang'] . "'\">Hapus</button>
                            </div>
                        ";
                        echo "</td>";
                    } 

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
