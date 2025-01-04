-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 03:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_barang_it`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDataKaryawan` (IN `nama_lengkap` VARCHAR(255))   BEGIN
SELECT * FROM karyawan WHERE nama = nama_lengkap;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStatusBarangByNamaBarang` (IN `nama_brg` VARCHAR(100))   BEGIN
SELECT nama_barang, status_barang FROM barang_it WHERE nama_barang = nama_brg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUerByAccess` (IN `access_right` VARCHAR(10))   BEGIN
SELECT * from user WHERE akses = access_right;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserByAccess` (IN `access_right` VARCHAR(10))   BEGIN
SELECT * from user WHERE akses = access_right;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GetPhoneByName` (`nama_lengkap` VARCHAR(100)) RETURNS VARCHAR(15) CHARSET utf8mb4  BEGIN
DECLARE phone VARCHAR(15);
SELECT no_telp INTO phone FROM karyawan WHERE nama = nama_lengkap;
RETURN phone;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetSpecificBarangCount` (`nama_brg` VARCHAR(100)) RETURNS INT(11)  BEGIN
DECLARE jml_barang INT;
SELECT jumlah_barang INTO jml_barang FROM barang_it WHERE nama_barang = nama_brg;
RETURN jml_barang;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetStatusBarang` (`nama_brg` VARCHAR(100)) RETURNS ENUM('dikembalikan','belum dikembalikan') CHARSET utf8mb4  BEGIN
DECLARE status ENUM('dikembalikan', 'belum dikembalikan');
SELECT status_pengembalian INTO status FROM meminjam WHERE nama_barang = nama_brg;
RETURN status;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetUserAkses` (`username_parameter` VARCHAR(50)) RETURNS ENUM('admin','user') CHARSET utf8mb4  BEGIN
DECLARE akses_pengguna ENUM('admin', 'user');
SELECT akses INTO akses_pengguna FROM user WHERE username = username_parameter;
RETURN akses_pengguna;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_it`
--

CREATE TABLE `barang_it` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah_barang` int(40) NOT NULL,
  `status_barang` enum('tersedia','dipinjam') NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_it`
--

INSERT INTO `barang_it` (`id_barang`, `nama_barang`, `jumlah_barang`, `status_barang`, `tanggal_input`) VALUES
(1, 'proyektor', 5, 'tersedia', '2024-12-03 15:00:00'),
(2, 'monitor', 2, 'tersedia', '2024-12-04 15:00:00'),
(9, 'keyboard', 7, 'tersedia', '2024-12-05 15:00:00'),
(10, 'kabel HDMI', 7, 'dipinjam', '2024-12-06 15:00:00');

--
-- Triggers `barang_it`
--
DELIMITER $$
CREATE TRIGGER `CheckCountGreaterThanZero` BEFORE INSERT ON `barang_it` FOR EACH ROW BEGIN
IF NEW.jumlah_barang < 0 THEN
SIGNAL SQLSTATE '42000'
SET MESSAGE_TEXT = 'Jumlah barang it tidak boleh < 0';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `divisi` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `pekerjaan`, `divisi`, `jenis_kelamin`, `no_telp`) VALUES
(1, 'Asyafa arthur', 'pengelola barang it', 'it support', 'L', '081227227910'),
(2, 'Ditra james', 'asisten manajer', 'manajemen', 'P', '081227227911'),
(3, 'Al Hauna john', 'sekertaris', 'marketing', 'L', '081227227912'),
(4, 'Jamal Udin', 'asisten manajer', 'advisor', 'L', '081227227913'),
(5, 'gusdur al majid', 'cleaning service', 'kebersihan', 'L', '098765432109'),
(6, 'naruto', 'direktur', 'IT', 'P', '172648364857'),
(7, 'salsa', 'sekertaris', 'manajemen', 'P', '08174649474'),
(8, 'jamaludin', 'manajer', 'IT', 'L', '08174578937'),
(9, 'aji barang', 'chef', 'dapur', 'L', '08837474144'),
(10, 'gafasa', 'angkat barang', 'logistik', 'L', '08127823843'),
(12, 'asbun', 'cleaning service', 'kebersihan', 'L', '09384945885');

--
-- Triggers `karyawan`
--
DELIMITER $$
CREATE TRIGGER `CheckGenderBeforeInsert` BEFORE INSERT ON `karyawan` FOR EACH ROW BEGIN
IF NEW.jenis_kelamin NOT IN ('P', 'L') THEN
SIGNAL SQLSTATE '42000'
SET MESSAGE_TEXT = 'Jenis kelamin hanya boleh bernilai "P" atau "L".';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `meminjam`
--

CREATE TABLE `meminjam` (
  `id_peminjaman` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jml_barang` int(10) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime NOT NULL,
  `status_pengembalian` enum('dikembalikan','belum dikembalikan') NOT NULL DEFAULT 'belum dikembalikan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meminjam`
--

INSERT INTO `meminjam` (`id_peminjaman`, `username`, `nama`, `nama_barang`, `jml_barang`, `tanggal_pinjam`, `tanggal_kembali`, `status_pengembalian`) VALUES
(1, 'ditra', 'Ditra James', 'proyektor', 1, '2024-12-07 14:00:00', '2024-12-08 14:00:00', 'belum dikembalikan'),
(2, 'jamal', 'Jamal Udin', 'monitor', 1, '2024-12-08 14:00:00', '2024-12-09 14:00:00', 'belum dikembalikan');

--
-- Triggers `meminjam`
--
DELIMITER $$
CREATE TRIGGER `CheckBeforeMeminjam` BEFORE INSERT ON `meminjam` FOR EACH ROW BEGIN
IF NEW.tanggal_kembali < NEW.tanggal_pinjam THEN
SIGNAL SQLSTATE '42000'
SET MESSAGE_TEXT = 'Tanggal pengembalian barang tidak bisa lebih awal dari tanggal pinjam.';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `akses` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `akses`) VALUES
(1, 'asyafa', 'asyafa@company.com', 'asyafa123', 'admin'),
(2, 'ditra', 'ditra@company.com', 'ditra123', 'user'),
(3, 'al_hauna', 'al_hauna@company.com', 'al_hauna123', 'admin'),
(4, 'jamal', 'jamal@company.com', 'jamal123', 'user'),
(6, 'salsa', 'salsa@company.com', '$2y$10$At1LUiq3zrmeLP1gQl2CsuHmep36PZ1MRNQu5cGK4f0', 'user'),
(8, 'aji', 'aji@company.com', '$2y$10$js1SeB6HORBK3cHilW3ZnOirGXSJJhUH0xhqLpP.gja', 'admin'),
(13, 'gafasa', 'gafasa@company.com', 'gafasa123', 'user');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `CheckAccessBeforeInsert` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
IF NEW.akses NOT IN ('admin', 'user') THEN
SIGNAL SQLSTATE '22000'
SET MESSAGE_TEXT = 'Hak akses yang dimasukkan tidak valid. Hak akses hanya dapat berisi "admin" atau "user".';
END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_it`
--
ALTER TABLE `barang_it`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `idx_nama_barang` (`nama_barang`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `idx_nama` (`nama`);

--
-- Indexes for table `meminjam`
--
ALTER TABLE `meminjam`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `FK_meminjam_barang_it` (`nama_barang`),
  ADD KEY `FK_meminjam_user` (`username`),
  ADD KEY `FK_meminjam_karyawan` (`nama`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_it`
--
ALTER TABLE `barang_it`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `meminjam`
--
ALTER TABLE `meminjam`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meminjam`
--
ALTER TABLE `meminjam`
  ADD CONSTRAINT `FK_meminjam_barang_it` FOREIGN KEY (`nama_barang`) REFERENCES `barang_it` (`nama_barang`),
  ADD CONSTRAINT `FK_meminjam_karyawan` FOREIGN KEY (`nama`) REFERENCES `karyawan` (`nama`),
  ADD CONSTRAINT `FK_meminjam_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
