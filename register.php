<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Karyawan</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="form-container">
        <h1>Form Registrasi Karyawan</h1>
        <form action="proses_register_karyawan.php" method="POST">
            <!-- Nama -->
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <!-- Pekerjaan -->
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Masukkan pekerjaan" required>
            </div>
            
            <!-- Divisi -->
            <div class="form-group">
                <label for="divisi">Divisi</label>
                <input type="text" name="divisi" id="divisi" placeholder="Masukkan divisi" required>
            </div>
            
            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            
            <!-- No Telepon -->
            <div class="form-group">
                <label for="no_telp">Nomor Telepon</label>
                <input type="text" name="no_telp" id="no_telp" placeholder="Masukkan nomor telepon" required>
            </div>
            
            <!-- Submit Button -->
            <button type="submit">Daftar</button>
        </form>
        <br>
        <button onclick="location.href='index.php'" class="home-button">Kembali ke Home</button>
    </div>
</body>
</html>
