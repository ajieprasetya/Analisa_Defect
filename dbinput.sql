-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 08:05 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbinput`
--

-- --------------------------------------------------------

--
-- Table structure for table `input_2`
--

CREATE TABLE `input_2` (
  `vin` varchar(100) NOT NULL,
  `area/part` varchar(100) NOT NULL,
  `defect` varchar(100) NOT NULL,
  `ctg` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `analisis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `input_2`
--

INSERT INTO `input_2` (`vin`, `area/part`, `defect`, `ctg`, `pic`, `model`, `suffix`, `analisis`) VALUES
('a3', 'depan', 'baret', 'sedang', 'cat', 'avan', 'ty', 'ayla.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `input_data`
--

CREATE TABLE `input_data` (
  `vin` varchar(100) DEFAULT NULL,
  `area/part` varchar(100) DEFAULT NULL,
  `defect` varchar(100) DEFAULT NULL,
  `ctg` varchar(50) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `model` varchar(4) DEFAULT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `input_data`
--

INSERT INTO `input_data` (`vin`, `area/part`, `defect`, `ctg`, `pic`, `model`, `suffix`, `status`) VALUES
('a3', 'depan', 'baret', 'sedang', 'cat', 'avan', 'ty', 0),
('a8', 'depan', 'baret', 'kecil', 'cat', 'avan', 'bn', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'aku12345', 'aku12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
