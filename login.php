<?php
session_start(); // Memulai session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="form-container">
        <h1>Login</h1>
        <?php
        if (isset($_SESSION['login_error'])) {
            echo "<p class='error-message'>" . $_SESSION['login_error'] . "</p>";
            unset($_SESSION['login_error']); // Hapus pesan error setelah ditampilkan
        }
        ?>
        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <br>
        <button onclick="location.href='index.php'" class="home-button">Kembali ke Home</button>
    </div>
</body>
</html>
