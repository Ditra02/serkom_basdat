<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Query untuk mengambil data dari tabel 'user'
$sql = "SELECT id_user, username, email, akses FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link rel="stylesheet" href="css/list_user.css">
    <button onclick="location.href='index.php'" class="home-button">Kembali ke Home</button>
</head>
<body>
    <h1>Data User</h1>
    <table>
        <thead>
            <tr>
                <th>ID User</th>
                <th>Username</th>
                <th>Email</th>
                <th>Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <button class='btn-tambah' onclick="location.href='tambah_user.php'">Tambah user</button>
            <?php
            // Periksa apakah hasil query tidak kosong
            if ($result->num_rows > 0) {
                // Loop melalui data dan tampilkan dalam tabel
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_user'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . ucfirst($row['akses']) . "</td>";
                    echo "<td>";
                        echo "
                            <div class='action-buttons'>
                                <button class='btn-edit' onclick=\"location.href='edit_user.php?id=" . $row['id_user'] . "'\">Edit</button>
                                <button class='btn-hapus' onclick=\"if(confirm('Yakin ingin menghapus data ini?')) location.href='hapus_user.php?id=" . $row['id_user'] . "'\">Hapus</button>
                            </div>
                        ";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
