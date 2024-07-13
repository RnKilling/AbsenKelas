-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 20, 2024 at 10:03 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eabsensekipqr`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `idabsensi` int(11) NOT NULL,
  `idpengguna` int(11) NOT NULL,
  `absenmasuk` varchar(25) NOT NULL,
  `absenpulang` varchar(25) NOT NULL,
  `absenmasukstatus` varchar(50) NOT NULL,
  `absenpulangstatus` varchar(50) NOT NULL,
  `fotomasuk` text NOT NULL,
  `fotopulang` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`idabsensi`, `idpengguna`, `absenmasuk`, `absenpulang`, `absenmasukstatus`, `absenpulangstatus`, `fotomasuk`, `fotopulang`, `status`, `tanggal`) VALUES
(1, 14, '2024-06-20 14:22:44', '2024-06-20 14:22:55', 'Masuk', 'Pulang', '6673d8c40c526.jpg', '6673d8cf47649.jpg', 'Datang', '2024-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `fotoprofil` varchar(255) NOT NULL,
  `level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nip`, `nama`, `email`, `password`, `telepon`, `jabatan`, `alamat`, `fotoprofil`, `level`) VALUES
(1, '123', 'Administrator', 'admin@gmail.com', 'admin', '0812345678', 'Admin', '<p>Jl. Palembang</p>\r\n', 'Untitled.png', 'Admin'),
(14, '06173090512', 'Sugeng', 'sugeng@gmail.com', 'sugeng', '084921849124', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'produk14 (1).jfif', 'Pegawai'),
(15, 'yanto', 'Yanto', 'yanto@gmail.com', 'yanto', '08912859125', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'user.jpg', 'Pegawai'),
(16, '06173090513', 'Budi', 'budi@gmail.com', '', '08491289412', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'produk7 (1).jpg', 'Pegawai'),
(17, '999', 'Vivin', 'vivin@gmail.com', '999', '08591289512', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'Untitled.png', 'Pegawai'),
(18, '000', 'Agus', 'agus@gmail.com', '000', '08591285912', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'Untitled.png', 'Pegawai'),
(19, '0710298541', 'Udin', 'udin@gmail.com', 'udin', '08989124242', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'Untitled.png', 'Pegawai'),
(20, '071412', 'Husen', 'husen@gmail.com', 'husen', '089512895821', 'Pegawai', '<p>Jl. Palembang</p>\r\n', 'Untitled.png', 'Pegawai'),
(21, '', 'Hari Pratomo', 'hari@gmail.com', 'hari', '08951289512', 'Pegawai', '<p>Jl. Palembang</p>\r\n', '3fc2caf6-118c-457d-8a28-8868c1753fda.jpeg', 'Pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`idabsensi`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `idabsensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
