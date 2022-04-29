-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2022 at 11:28 AM
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
-- Database: `db_bukutamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `rekap`
--

CREATE TABLE `rekap` (
  `id_tamu` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `nama` varchar(50) NOT NULL,
  `asal` varchar(50) NOT NULL,
  `keperluan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rekap`
--

INSERT INTO `rekap` (`id_tamu`, `waktu`, `nama`, `asal`, `keperluan`) VALUES
(1, '2021-11-21 00:00:00', 'asas', 'asas', 'asas'),
(2, '2021-10-21 00:00:00', 'asasa', 'assas', 'asaass'),
(5, '2022-01-22 00:00:00', 'asas', 'sasa', 'sasas'),
(6, '2022-01-22 00:00:00', 'AGIL', 'SMADA', 'Bertemu Pak JArimin'),
(7, '2022-01-22 15:26:43', 'HIDA', 'Alumni SMADA', 'LEgalisir'),
(8, '2022-01-22 00:00:00', 'saas', 'asas', 'sasa'),
(9, '2022-01-22 21:32:30', 'asas', 'saas', 'sasas'),
(10, '2022-01-22 21:56:31', 'JOKOWI', 'JAKARTA', 'BERTEMU PAK YUSUF'),
(11, '2022-01-22 22:10:03', 'HIDAYAT', 'CINDOGO', 'BERTEMU PAK AGIL'),
(12, '2022-01-23 10:26:22', 'wqwq', 'qwqwq', 'wqwqwqw'),
(13, '2022-01-23 10:26:30', 'qwqwq', 'qwqwq', 'wqwqwq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rekap`
--
ALTER TABLE `rekap`
  ADD PRIMARY KEY (`id_tamu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rekap`
--
ALTER TABLE `rekap`
  MODIFY `id_tamu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
