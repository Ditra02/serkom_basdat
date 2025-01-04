<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi User</title>
    <link rel="stylesheet" href="css/register_user.css">
</head>
<body>
    <div class="form-container">
        <h1>Form Registrasi User</h1>
        <form action="proses_register_user.php" method="POST">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required>
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email" required>
            </div>
            
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>
            
            <!-- Akses -->
            <div class="form-group">
                <label for="akses">Akses</label>
                <select name="akses" id="akses" required>
                    <option value="">Pilih akses</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <!-- Submit Button -->
            <button type="submit">Daftar</button>
        </form>
    </div>
</body>
</html>
