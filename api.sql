-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2023 at 02:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `is_active` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nik`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `is_active`) VALUES
(1, '123', '123', 'Ikhsan M', '2004-03-04', 'Laki-Laki', 'Bandung', 1),
(2, '234', '234', 'Riezkan', '2002-03-27', 'Laki-laki', 'JlJL', 1),
(3, '456', '456', 'Sulthon Adam', '2007-03-01', 'Laki-Laki', 'JlJLJLJL', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
