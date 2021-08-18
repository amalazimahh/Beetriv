-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2021 at 10:41 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beetriv`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `product_Id` int(255) DEFAULT NULL,
  `product_Name` varchar(255) DEFAULT NULL,
  `product_Price` int(255) DEFAULT NULL,
  `seller_Id` int(255) DEFAULT NULL,
  `product_Quantity` int(255) DEFAULT NULL,
  `total_Items` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_Id` int(255) DEFAULT NULL,
  `product_Name` varchar(255) DEFAULT NULL,
  `product_Desc` varchar(255) DEFAULT NULL,
  `product_Price` int(255) DEFAULT NULL,
  `product_Category` varchar(255) DEFAULT NULL,
  `product_Quantity` int(255) DEFAULT NULL,
  `product_Condition` varchar(255) DEFAULT NULL,
  `product_Rate` int(255) DEFAULT NULL,
  `bid_Status` varchar(255) DEFAULT NULL,
  `meetup_location` varchar(255) DEFAULT NULL,
  `bid_starting_price` int(255) DEFAULT NULL,
  `bid_maximum_price` int(255) DEFAULT NULL,
  `time_limit` time(6) DEFAULT NULL,
  `seller_Id` int(255) DEFAULT NULL,
  `user_Id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Username` varchar(255) DEFAULT NULL,
  `seller_Rate` int(255) DEFAULT NULL,
  `review_Description` varchar(255) DEFAULT NULL,
  `review_Type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_Id` int(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone_Number` int(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Ic_color` varchar(255) DEFAULT NULL,
  `Ic_no` int(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `product_Id` int(255) DEFAULT NULL,
  `Bio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Email` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Ic_no` int(8) DEFAULT NULL,
  `Ic_color` text DEFAULT NULL,
  `Phone_Number` int(7) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `vcode` text NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Firstname` text NOT NULL,
  `Lastname` text NOT NULL,
  `Bio` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `seller_id` int(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Email`, `Username`, `Ic_no`, `Ic_color`, `Phone_Number`, `Password`, `vcode`, `verified`, `date_created`, `Firstname`, `Lastname`, `Bio`, `Address`, `product_id`, `seller_id`, `user_type`) VALUES
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'Haziq', 'Zulhazmi', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'aaaa', 'aaaa', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'def', 'def', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'fiqah', 'zimah', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'fiqah', 'zimah', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '12345', '', 0, '2021-08-16 21:21:15', 'fiqah', 'zimah', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '123', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '321', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('abc@abc.com', NULL, NULL, NULL, NULL, '123456789', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', NULL, NULL, NULL, NULL, '12345678', '', 0, '2021-08-16 21:21:15', 'abc', 'abc', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziqzulhazmi', 1, 'Yellow', 7132780, '12345', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '123', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '1111111111111111111111111', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, 'abcabcabc', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, 'qwertyuiop', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '123456789', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'nY4W', 0, '2021-08-16 21:21:15', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:24:20', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'asfasfasdasd', 1, 'Yellow', 7132780, '12345678', '', 0, '2021-08-16 21:25:34', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'asfasfasdasd', 1, 'Yellow', 7132780, '12345678', '0oFR', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'jkasdhjkasd', 1, 'Yellow', 7132780, '12345678', 'LHbM', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, 'asdfghjkl', 'pm7L', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'ozGN', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', '5SER', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'gsgdkfgsjkjdgs', 1, 'Yellow', 7132780, '12345678', 'aQNv', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'qYfL', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', 'NS1r', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '87654321', 'DZ16', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'm1lW', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'haziiq', 1, 'Yellow', 7132780, '12345678', 'RAIv', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'aXB4', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL),
('haziiq@live.com', 'test', 1, 'Yellow', 7132780, '12345678', 'cCYW', 0, '0000-00-00 00:00:00', '', '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_Id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL DEFAULT '0',
  `Username` varchar(255) NOT NULL DEFAULT '0',
  `Ic_no` varchar(255) NOT NULL DEFAULT '0',
  `Ic_color` varchar(255) NOT NULL DEFAULT '0',
  `Phone_Number` int(10) NOT NULL DEFAULT 0,
  `Password` varchar(255) NOT NULL DEFAULT '0',
  `vcode` varchar(255) NOT NULL DEFAULT '0',
  `verified` varchar(255) NOT NULL DEFAULT '0',
  `Firstname` varchar(255) DEFAULT '0',
  `Lastname` varchar(255) DEFAULT '0',
  `Bio` varchar(255) DEFAULT '0',
  `Address` varchar(255) DEFAULT '0',
  `product_id` varchar(255) DEFAULT '0',
  `seller_id` varchar(255) DEFAULT '0',
  `user_type` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_Id`, `Email`, `Username`, `Ic_no`, `Ic_color`, `Phone_Number`, `Password`, `vcode`, `verified`, `Firstname`, `Lastname`, `Bio`, `Address`, `product_id`, `seller_id`, `user_type`) VALUES
(1, 'haziiq@live.com', 'haziiq', '01-106190', 'Yellow', 7132780, '12345678', 'FoW0', '', '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `product_ID` int(255) DEFAULT NULL,
  `product_Name` varchar(255) DEFAULT NULL,
  `product_Price` int(255) DEFAULT NULL,
  `seller_Id` int(255) DEFAULT NULL,
  `total_Price` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
