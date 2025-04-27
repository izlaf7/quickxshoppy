-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 03:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quick`
--

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `whatsappno` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `name`, `whatsappno`) VALUES
(4, 'izlaf', '123456789'),
(5, 'izlaf', '123456789'),
(7, 'silmiya', '0706126252'),
(8, 'king', '+947014961');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `delivery_days` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `owner_id`, `category`, `delivery_days`) VALUES
(5, 'izlaf', 12.00, 'qwsxd', 'uploads/logo.jpg', 4, 'dress', 3),
(6, 'izlaf', 12.00, 'izlaff', 'uploads/logo.jpg', 4, 'dress', 1),
(7, 'oooppp', 122.00, 'isksksksk', 'uploads/logo.jpg,uploads/1b52cae0-4e0c-4bd2-a17e-e29ea5a45a10.jpg', 5, 'land', 23),
(8, 'Wireless Bluetooth Headphones', 122.00, 'isisisisisisisisiiis', 'uploads/WhatsApp Image 2025-01-16 at 18.15.33_c4f23df3.jpg', 4, 'food', 11),
(9, 'ifaf', 1222.00, 'iaiaiai', 'uploads/dfd08142-f50a-4845-bf15-28cd5a540a06.jpg', 7, 'dress', 12),
(10, 'izlaf king', 1222.00, 'ik,', 'uploads/izlaf_page-0001 (2).jpg', 7, 'summa', 12),
(11, 'Izlaf ahmad', 988.00, 'oooo', 'uploads/df5c58e4-d6c7-4c7b-a722-80298a5f0460.jpg', 4, 'food', 1),
(12, 'ooaoa', 900.00, 'qqkqkkqkq', 'uploads/7e2d07be-ae2f-4a38-b7d7-1d88b1bfb9c5.jpg', 4, 'food', 122);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
