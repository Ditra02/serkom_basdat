<?php
session_start(); // Memulai session
include 'config.php'; // Impor konfigurasi database

// Periksa apakah user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Periksa apakah parameter `id` ada di URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Query untuk mengambil data user berdasarkan id_user
    $sql = "SELECT * FROM user WHERE id_user = $id_user";
    $result = $conn->query($sql);

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Ambil data user
    } else {
        echo "<script>alert('User tidak ditemukan!');</script>";
        echo "<script>window.location='list_user.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID user tidak ditemukan!');</script>";
    echo "<script>window.location='list_user.php';</script>";
    exit();
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $akses = $_POST['akses'];

    // Query untuk memperbarui username, email, dan akses
    $sql = "UPDATE user SET username = '$username', email = '$email', akses = '$akses' WHERE id_user = $id_user";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data user berhasil diedit!');</script>";
        echo "<script>window.location='list_user.php';</script>";
        // header("Location: list_user.php");
        // exit();
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
    <title>Edit User</title>
    <link rel="stylesheet" href="css/edit_user.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit User</h1>
        <form method="POST" action="">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <!-- Akses -->
            <div class="form-group">
                <label for="akses">Hak Akses</label>
                <select id="akses" name="akses" required>
                    <option value="admin" <?php if ($user['akses'] === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($user['akses'] === 'user') echo 'selected'; ?>>User</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
