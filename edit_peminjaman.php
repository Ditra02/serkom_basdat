<?php
// Impor file konfigurasi database
include 'config.php';

// Mulai sesi untuk memastikan pengguna login
session_start();

if (!isset($_SESSION['akses'])) {
    // Jika user belum login, redirect ke halaman index
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Query untuk mengambil data peminjaman berdasarkan id_peminjaman
    $sql = "SELECT * FROM meminjam WHERE id_peminjaman = $id_peminjaman";
    $result = $conn->query($sql);

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $peminjaman = $result->fetch_assoc(); // Ambil data peminjaman
    } else {
        echo "<script>alert('Data peminjaman tidak ditemukan!');</script>";
        echo "<script>window.location='list_peminjaman.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID peminjaman tidak ditemukan!');</script>";
    echo "<script>window.location='list_peminjaman.php';</script>";
    exit();
}

// Ambil data tambahan dari tabel user, karyawan, dan barang_it
$user_query = "SELECT username FROM user";
$user_result = $conn->query($user_query);

$karyawan_query = "SELECT nama FROM karyawan";
$karyawan_result = $conn->query($karyawan_query);

$barang_query = "SELECT nama_barang FROM barang_it";
$barang_result = $conn->query($barang_query);

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nama_barang = $_POST['nama_barang'];
    $jml_barang = $_POST['jml_barang'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status_pengembalian = $_POST['status_pengembalian'];

    // Query untuk memperbarui data peminjaman
    $sql = "UPDATE meminjam 
            SET username = '$username', nama = '$nama', nama_barang = '$nama_barang', jml_barang = $jml_barang, 
                tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali', status_pengembalian = '$status_pengembalian'
            WHERE id_peminjaman = $id_peminjaman";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Peminjaman berhasil diperbarui!');</script>";
        echo "<script>window.location='peminjaman.php';</script>";
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
    <title>Edit Peminjaman</title>
    <link rel="stylesheet" href="css/edit_peminjaman.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit Peminjaman</h1>
        <form method="POST" action="">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <select id="username" name="username" required>
                    <?php
                    if ($user_result->num_rows > 0) {
                        while ($user = $user_result->fetch_assoc()) {
                            $selected = $user['username'] === $peminjaman['username'] ? "selected" : "";
                            echo "<option value='" . $user['username'] . "' $selected>" . $user['username'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Nama -->
            <div class="form-group">
                <label for="nama">Nama</label>
                <select id="nama" name="nama" required>
                    <?php
                    if ($karyawan_result->num_rows > 0) {
                        while ($karyawan = $karyawan_result->fetch_assoc()) {
                            $selected = $karyawan['nama'] === $peminjaman['nama'] ? "selected" : "";
                            echo "<option value='" . $karyawan['nama'] . "' $selected>" . $karyawan['nama'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Nama Barang -->
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <select id="nama_barang" name="nama_barang" required>
                    <?php
                    if ($barang_result->num_rows > 0) {
                        while ($barang = $barang_result->fetch_assoc()) {
                            $selected = $barang['nama_barang'] === $peminjaman['nama_barang'] ? "selected" : "";
                            echo "<option value='" . $barang['nama_barang'] . "' $selected>" . $barang['nama_barang'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Jumlah Barang -->
            <div class="form-group">
                <label for="jml_barang">Jumlah Barang</label>
                <input type="number" id="jml_barang" name="jml_barang" value="<?php echo $peminjaman['jml_barang']; ?>" required>
            </div>
            <!-- Tanggal Pinjam -->
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                <input type="datetime-local" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo date('Y-m-d\TH:i', strtotime($peminjaman['tanggal_pinjam'])); ?>" required>
            </div>
            <!-- Tanggal Kembali -->
            <div class="form-group">
                <label for="tanggal_kembali">Tanggal Kembali</label>
                <input type="datetime-local" id="tanggal_kembali" name="tanggal_kembali" value="<?php echo date('Y-m-d\TH:i', strtotime($peminjaman['tanggal_kembali'])); ?>" required>
            </div>
            <!-- Status Pengembalian -->
            <div class="form-group">
                <label for="status_pengembalian">Status Pengembalian</label>
                <select id="status_pengembalian" name="status_pengembalian" required>
                    <option value="dikembalikan" <?php echo $peminjaman['status_pengembalian'] === 'dikembalikan' ? 'selected' : ''; ?>>Dikembalikan</option>
                    <option value="belum dikembalikan" <?php echo $peminjaman['status_pengembalian'] === 'belum dikembalikan' ? 'selected' : ''; ?>>Belum Dikembalikan</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
