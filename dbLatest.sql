-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `verification_code`, `verified`, `createdat`, `updatedat`) VALUES
(1, 'Mobation', 'hosam@mobation.com', '$2y$10$SEU.2CquO1RmWGXGND3x/u3U3N5BE.txhcsSCjHpuVkG5WzBnmYAu', '123456', 1, '2024-03-20 23:13:58', '2024-03-31 14:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `accid` int(11) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `location`, `accid`, `createdat`, `updatedat`) VALUES
(1, 'test', 'abcd', 'test', 1, '2024-03-23 14:31:21', '2024-04-06 06:48:31'),
(7, 'zasd', '', '', 1, '2024-03-23 15:08:10', NULL),
(9, 'saasdsad', '+96176090294', '', 1, '2024-03-23 15:10:22', NULL),
(11, 'test', 'test', 'test', 1, '2024-03-23 15:13:55', '2024-03-24 14:52:17'),
(12, 'testing', '124', '', 1, '2024-03-23 15:17:13', '2024-03-24 19:45:53'),
(20, 'test2223', '', '', 1, '2024-03-24 21:03:06', NULL),
(22, 'tyujgf', '', '', 1, '2024-03-24 21:03:15', NULL),
(23, 'q123d', '', '', 1, '2024-03-24 21:03:18', NULL),
(24, 'asdsad', '', '', 1, '2024-03-24 21:03:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token_key` varchar(255) NOT NULL,
  `accid` int(11) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `password`, `token_key`, `accid`, `createdat`, `updatedat`) VALUES
(3, 'employee x', 'Admin123!', '79d23f2a991da0f9b1cb5fc36611ce2bc06f22e83b3d27292466f3c1ab5a06e0', 1, '2024-04-07 06:16:58', '2024-04-07 06:26:29'),
(9, 'Employee xy', 'Admin123!', '370a6748a6f169d529172827f01d860756352b9c56d7247fd4c7e154c5dd2705', 1, '2024-04-07 06:24:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `accid` int(11) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `accid`, `createdat`, `updatedat`) VALUES
(3, 'product x', 1, '2024-03-31 15:12:33', NULL),
(4, 'product y', 1, '2024-04-14 16:57:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_batch`
--

CREATE TABLE `products_batch` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `count` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `prodid` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_batch`
--

INSERT INTO `products_batch` (`id`, `name`, `count`, `expiry_date`, `prodid`, `price`, `createdat`, `updatedat`) VALUES
(1, 'batch-1002', 1, '2024-05-04', 3, 0.5, '2024-04-06 14:03:17', '2024-04-07 13:49:14'),
(2, 'batch-1003', 25, '2024-04-06', 3, 0, '2024-04-06 16:50:47', '2024-04-06 16:55:29'),
(3, 'b-10033', 252, '2024-04-17', 3, 41, '2024-04-07 13:44:25', '2024-04-07 13:44:40'),
(4, 'batch 10001', 45, '2024-05-02', 4, 12, '2024-04-14 16:57:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `amount_paid` double NOT NULL,
  `total_amount` double NOT NULL,
  `discount_amount` float NOT NULL,
  `amount_after_discount` double NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `clientid`, `employeeid`, `amount_paid`, `total_amount`, `discount_amount`, `amount_after_discount`, `createdat`, `updatedat`) VALUES
(5, 7, NULL, 12, 0, 14, 0, '2024-04-14 17:21:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `id` int(11) NOT NULL,
  `saleid` int(11) NOT NULL,
  `batchid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedat` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`id`, `saleid`, `batchid`, `count`, `createdat`, `updatedat`) VALUES
(1, 5, 4, 0, '2024-04-14 17:21:44', NULL),
(2, 5, 1, 0, '2024-04-14 17:21:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accid` (`accid`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_key` (`token_key`),
  ADD UNIQUE KEY `name` (`name`,`accid`),
  ADD KEY `accid` (`accid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accid` (`accid`);

--
-- Indexes for table `products_batch`
--
ALTER TABLE `products_batch`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`prodid`),
  ADD KEY `prodid` (`prodid`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `employeeid` (`employeeid`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleid` (`saleid`),
  ADD KEY `batchid` (`batchid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products_batch`
--
ALTER TABLE `products_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`accid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`accid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`accid`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products_batch`
--
ALTER TABLE `products_batch`
  ADD CONSTRAINT `products_batch_ibfk_1` FOREIGN KEY (`prodid`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`employeeid`) REFERENCES `employees` (`id`);

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`saleid`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`batchid`) REFERENCES `products_batch` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
