<?php
// Impor konfigurasi database
include 'config.php';

// Periksa apakah ID ada
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Query untuk mendapatkan data spesifik
    $sql = "SELECT * FROM barang_it WHERE id_barang = $id_barang";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $status_barang = $_POST['status_barang'];

    $update_sql = "UPDATE barang_it SET nama_barang = '$nama_barang', jumlah_barang = $jumlah_barang, status_barang = '$status_barang' WHERE id_barang = $id_barang";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Data barang berhasil diedit!');</script>";
        echo "<script>window.location='barang_it.php';</script>";
        // header("Location: barang_it.php");
        // exit(); // Tambahkan exit() untuk memastikan redirect langsung
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang</h1>
    <form method="POST">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="<?php echo $row['nama_barang']; ?>"><br>
        <label>Jumlah Barang:</label><br>
        <input type="number" name="jumlah_barang" value="<?php echo $row['jumlah_barang']; ?>"><br>
        <label>Status Barang:</label><br>
        <select name="status_barang">
            <option value="tersedia" <?php if ($row['status_barang'] == 'tersedia') echo 'selected'; ?>>Tersedia</option>
            <option value="dipinjam" <?php if ($row['status_barang'] == 'dipinjam') echo 'selected'; ?>>Dipinjam</option>
        </select><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
