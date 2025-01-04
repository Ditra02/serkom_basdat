<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    // Jika user belum login atau bukan admin, redirect ke halaman lain
    header("Location: index.php");
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Query untuk mengambil data karyawan berdasarkan id_karyawan
    $sql = "SELECT * FROM karyawan WHERE id_karyawan = $id_karyawan";
    $result = $conn->query($sql);

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $karyawan = $result->fetch_assoc(); // Ambil data karyawan
    } else {
        echo "<script>alert('Karyawan tidak ditemukan!');</script>";
        echo "<script>window.location='list_karyawan.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID karyawan tidak ditemukan!');</script>";
    echo "<script>window.location='list_karyawan.php';</script>";
    exit();
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $divisi = $_POST['divisi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];

    // Query untuk memperbarui data karyawan
    $sql = "UPDATE karyawan SET nama = '$nama', pekerjaan = '$pekerjaan', divisi = '$divisi', jenis_kelamin = '$jenis_kelamin', no_telp = '$no_telp' WHERE id_karyawan = $id_karyawan";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Karyawan berhasil diperbarui!');</script>";
        echo "<script>window.location='list_karyawan.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <link rel="stylesheet" href="css/edit_karyawan.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit Karyawan</h1>
        <form method="POST" action="">
            <!-- Nama -->
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?php echo $karyawan['nama']; ?>" required>
            </div>
            <!-- Pekerjaan -->
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo $karyawan['pekerjaan']; ?>" required>
            </div>
            <!-- Divisi -->
            <div class="form-group">
                <label for="divisi">Divisi</label>
                <input type="text" id="divisi" name="divisi" value="<?php echo $karyawan['divisi']; ?>" required>
            </div>
            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" <?php if ($karyawan['jenis_kelamin'] === 'L') echo 'selected'; ?>>Laki-laki</option>
                    <option value="P" <?php if ($karyawan['jenis_kelamin'] === 'P') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            <!-- No Telepon -->
            <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" id="no_telp" name="no_telp" value="<?php echo $karyawan['no_telp']; ?>" required>
            </div>
            <!-- Submit Button -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
