-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2021 at 08:10 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beetriv_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `PRODUCT`
--

CREATE TABLE `PRODUCT` (
  `prd_id` int(11) NOT NULL,
  `prd_name` varchar(150) DEFAULT NULL,
  `prd_price` int(11) DEFAULT NULL,
  `prd_img` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `REGISTRATION`
--

CREATE TABLE `REGISTRATION` (
  `registration_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `birthdate` date NOT NULL,
  `phone_number` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `REGISTRATION`
--

INSERT INTO `REGISTRATION` (`registration_id`, `email`, `username`, `password`, `birthdate`, `phone_number`) VALUES
(1, '19FTT1162@student.pb.edu.bn', 'fiqah', '12345', '1988-11-09', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PRODUCT`
--
ALTER TABLE `PRODUCT`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indexes for table `REGISTRATION`
--
ALTER TABLE `REGISTRATION`
  ADD PRIMARY KEY (`registration_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PRODUCT`
--
ALTER TABLE `PRODUCT`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `REGISTRATION`
--
ALTER TABLE `REGISTRATION`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
