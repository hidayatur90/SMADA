-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2022 at 02:17 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pembayaran_seragam`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_seragam`
--

CREATE TABLE `detail_seragam` (
  `id_siswa` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `no_pendaftaran` varchar(50) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `asal_sekolah` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `jilbab` enum('Ya','Tidak') NOT NULL,
  `total_bayar` bigint(20) NOT NULL,
  `penerima` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_seragam`
--

INSERT INTO `detail_seragam` (`id_siswa`, `tanggal`, `no_pendaftaran`, `nama_siswa`, `asal_sekolah`, `jenis_kelamin`, `jilbab`, `total_bayar`, `penerima`) VALUES
(1, '2022-05-06', '202410101001', 'Joko Ahmadi', 'SMP 2 Tenggarang', 'Pria', 'Tidak', 150000, 'Muhammad Hidayatur'),
(2, '2022-05-06', '202410101002', 'Rifat Wahyu', 'SMP 2 Tenggarang', 'Pria', 'Tidak', 150000, 'Muhammad Hidayatur'),
(3, '2022-05-06', '202410101003', 'Amalia', 'SMP 2 Tenggarang', 'Wanita', 'Tidak', 150000, 'Muhammad Hidayatur'),
(4, '2022-05-06', '202410101004', 'Regita', 'SMP 1 Bondowoso', 'Wanita', 'Ya', 200000, ''),
(5, '2022-05-06', '202410101005', 'Putra Ahmad', 'SMP 1 Bondowoso', 'Pria', 'Tidak', 150000, ''),
(6, '2022-06-06', '202410101006', 'Hidayatur', 'SMP 1 Bondowoso', 'Pria', 'Tidak', 150000, ''),
(7, '2022-06-06', '202410101007', 'Jaya Kukun', 'SMP 1 Bondowoso', 'Pria', 'Tidak', 150000, 'Wahyu Agil'),
(8, '2022-06-06', '202410101008', 'Doni Angga', 'SMP 1 Bondowoso', 'Pria', 'Tidak', 150000, 'Wahyu Agil'),  
(9, '2022-06-06', '202410101009', 'Putri Saptaning', 'MTS At-Taqwa', 'Wanita', 'Ya', 200000, 'Wahyu Agil'),
(10, '2022-06-06', '202410101010', 'Eka Setya', 'MTS At-Taqwa', 'Wanita', 'Ya', 200000, 'Wahyu Agil'),
(11, NULL, '202410101011', 'Ayu Laili', 'MTS At-Taqwa', 'Wanita', 'Tidak', 150000, ''),
(12, NULL, '202410101012', 'Rindi Anjani', 'MTS At-Taqwa', 'Wanita', 'Ya', 200000, ''),
(13, NULL, '202410101013', 'Anggita Rizky', 'MTS At-Taqwa', 'Wanita', 'Ya', 200000, ''),
(14, NULL, '202410101014', 'Ririn Tristanti', 'MTS At-Taqwa', 'Wanita', 'Ya', 200000, 'Wahyu Agil'),
(15, NULL, '202410101015', 'Mohammad Zaini', 'SMP 1 Tapen', 'Pria', 'Tidak', 150000, 'Wahyu Agil');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_seragam`
--
ALTER TABLE `detail_seragam`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `user_id` (`penerima`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_seragam`
--
ALTER TABLE `detail_seragam`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
