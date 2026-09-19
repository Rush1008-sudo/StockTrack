-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2026 at 12:52 PM
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
-- Database: `stock_db`
--
CREATE DATABASE IF NOT EXISTS `stock_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `stock_db`;

-- --------------------------------------------------------

--
-- Table structure for table `stock_inventory`
--

CREATE TABLE `stock_inventory` (
  `inventory_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `avg_cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_inventory`
--

INSERT INTO `stock_inventory` (`inventory_id`, `stock_id`, `quantity`, `avg_cost`) VALUES
(10, 6, 0.48, 841.37),
(11, 7, 2.09, 431.05),
(12, 8, 15.79, 240.57),
(13, 9, 10.45, 96.01),
(18, 12, 0.80, 750.00),
(19, 3, 10.00, 1500.00),
(20, 11, 20.00, 150.37),
(21, 10, 10.00, 500.00),
(22, 13, 0.03, 7500.00),
(23, 5, 10.00, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_list`
--

CREATE TABLE `stock_list` (
  `stock_id` int(11) NOT NULL,
  `stock_code` varchar(10) NOT NULL,
  `stock_name` varchar(50) NOT NULL,
  `current_price` decimal(10,2) NOT NULL,
  `category` varchar(30) NOT NULL,
  `update_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_list`
--

INSERT INTO `stock_list` (`stock_id`, `stock_code`, `stock_name`, `current_price`, `category`, `update_time`) VALUES
(3, '2330', '台積電', 2350.22, '半導體', '2026-05-30'),
(5, 'NVDA', '輝達', 170.00, '科技', '2026-05-30'),
(6, 'COST', '好市多', 1000.32, '零售業', '2026-05-30'),
(7, 'MSFT', '微軟', 435.24, '科技', '2026-05-31'),
(8, 'TSLA', '特斯拉', 435.79, '科技', '2026-05-30'),
(9, 'VT', '先鋒全世界股票', 158.12, '指數股票型基金', '2026-05-30'),
(10, '2317', '鴻海', 289.00, '電子製造', '2026-05-30'),
(11, '0050', '元大台灣50', 105.40, '指數股票型基金', '2026-05-30'),
(12, 'QQQ', '那斯達克100指數', 738.31, '指數股票型基金', '2026-05-30'),
(13, 'S&P500', '標準普爾500指數', 7850.06, '指數股票型基金', '2026-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE `user_list` (
  `uSN` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `hashedPwd` varchar(65) NOT NULL,
  `uName` varchar(35) NOT NULL,
  `uTitle` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`uSN`, `username`, `password`, `hashedPwd`, `uName`, `uTitle`) VALUES
(1, 'nkust', '811213', '', 'Teachertest', 'testAccount'),
(2, 'jiahe', 'zxc123', '', 'test', 'HenryLin'),
(3, 'xiaoming', '123', '', '小明', 'NULL'),
(4, 'xiaomei', '123', '', '小美', 'NULL'),
(5, 'xiaowang', '123', '', '小王', 'NULL'),
(6, 'xiaoju', '123', '', '小菊', 'NULL'),
(7, 'xiaohua', '123', '', '小花', 'NULL'),
(8, 'xiaoli', '123', '', '小莉', 'NULL'),
(9, 'xiaoxi', '123', '', '小習', 'NULL'),
(10, 'xiaochuan', '123', '', '小川', 'NULL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_inventory`
--
ALTER TABLE `stock_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `stock_list`
--
ALTER TABLE `stock_list`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`uSN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_inventory`
--
ALTER TABLE `stock_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `stock_list`
--
ALTER TABLE `stock_list`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
  MODIFY `uSN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock_inventory`
--
ALTER TABLE `stock_inventory`
  ADD CONSTRAINT `stock_inventory_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stock_list` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
