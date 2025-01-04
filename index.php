<?php
session_start(); // Memulai session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Peminjaman Barang IT</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="title">Website Peminjaman Barang IT</h1>
            <div class="right-buttons">
                <?php if (isset($_SESSION['id_user'])): ?>
                    <!-- Jika user sudah login -->
                    <span>Halo, <?php echo $_SESSION['username']; ?>!</span>
                    <span>(Akses: <?php echo ucfirst($_SESSION['akses']); ?>)</span>
                    <button onclick="location.href='logout.php'" class="nav-button logout-button">Logout</button>
                <?php else: ?>
                    <!-- Jika user belum login -->
                    <button onclick="location.href='register.php'" class="nav-button register-button">Register</button>
                    <button onclick="location.href='login.php'" class="nav-button login-button">Login</button>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div class="main-container">
        <!-- Menu kiri -->
        <nav class="sidebar">
            <button onclick="location.href='barang_it.php'" class="sidebar-button">Barang IT</button>
            
            <?php if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin'): ?>
                <button onclick="location.href='list_user.php'" class="sidebar-button">List User</button>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['akses']) && $_SESSION['akses'] === 'admin'): ?>
                <button onclick="location.href='list_karyawan.php'" class="sidebar-button">List Karyawan</button>
            <?php endif; ?>

            <button onclick="location.href='peminjaman.php'" class="sidebar-button">Peminjaman Barang IT</button>
        </nav>

        <!-- Konten utama -->
        <main class="content">
            <p>Website ini adalah website Peminjaman Barang IT yang dikelola oleh IT Support sebuah perusahaan.</p>
        </main>
    </div>
</body>
</html>