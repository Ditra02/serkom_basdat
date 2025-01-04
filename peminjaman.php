<?php
session_start(); // Memulai session
// Impor file konfigurasi database
include 'config.php';

// Query untuk mengambil data dari tabel meminjam
$sql = "SELECT * FROM meminjam";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>
    <link rel="stylesheet" href="css/peminjaman.css">
</head>
<body>
    <h1>Data Peminjaman</h1>
    <button class='btn-tambah' onclick="location.href='tambah_peminjaman.php'">Tambah peminjaman</button>
    <table>
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status Pengembalian</th>
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
                    echo "<td>" . $row['id_peminjaman'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . $row['jml_barang'] . "</td>";
                    echo "<td>" . $row['tanggal_pinjam'] . "</td>";
                    echo "<td>" . $row['tanggal_kembali'] . "</td>";
                    echo "<td class='" . 
                        ($row['status_pengembalian'] === 'dikembalikan' ? 'status-dikembalikan' : 'status-belum-dikembalikan') . "'>" . 
                        ucfirst($row['status_pengembalian']) . "</td>";

                    // Tampilkan tombol hanya jika pengguna adalah admin
                    if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin') {
                        echo "<td>";
                            echo "
                                <div class='action-buttons'>
                                    <button class='btn-edit' onclick=\"location.href='edit_peminjaman.php?id=" . $row['id_peminjaman'] . "'\">Edit</button>
                                    <button class='btn-hapus' onclick=\"if(confirm('Yakin ingin menghapus data ini?')) location.href='hapus_peminjaman.php?id=" . $row['id_peminjaman'] . "'\">Hapus</button>
                                </div>
                            ";
                        echo "</td>";
                    } 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada data peminjaman</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
