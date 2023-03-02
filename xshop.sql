-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2023 at 03:23 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'nước ngọt'),
(2, 'nước khoáng'),
(3, 'đồ ăn');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_content`, `product_id`, `username`, `comment_date`) VALUES
(1, 'ngon', 4, 'tuanvanvan', '2023-03-02 08:41:55'),
(2, 'ngon quas', 8, 'tuanvanvan', '2023-03-02 08:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` double(10,2) NOT NULL DEFAULT 0.00,
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  `product_img` varchar(255) NOT NULL DEFAULT 'default_img.jpg',
  `product_description` text DEFAULT NULL,
  `product_views` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL,
  `product_date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `product_discount` int(11) DEFAULT 0,
  `product_special` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_quantity`, `product_img`, `product_description`, `product_views`, `category_id`, `product_date_added`, `product_discount`, `product_special`) VALUES
(1, 'coca', 15000.00, 3, 'default_img.jpg', 'nước ngọt có ga', 7, 1, '2022-08-16 00:00:00', 0, b'0'),
(2, 'pepsi', 15000.00, 5, 'default_img.jpg', 'nước ngọt có ga', 76, 1, '2022-08-01 05:34:23', 0, b'0'),
(3, 'cơm sườn', 50000.00, 2, 'default_img.jpg', 'cơm sườn hà nội', 3, 3, '2022-08-16 08:35:27', 0, b'0'),
(4, 'cánh gà chiên', 10000.00, 8, 'default_img.jpg', 'cánh gà chiên xù', 125, 3, '2022-08-16 08:35:58', 15, b'0'),
(5, 'nước lọc núi cao', 30000.00, 3, 'default_img.jpg', 'nước đắt tiền lọc', 1, 2, '2022-08-16 08:38:48', 20, b'0'),
(6, 'đậu rán', 55000.00, 32, 'default_img.jpg', 'đậu rán cháy', 0, 3, '2022-08-16 08:40:12', 0, b'1'),
(7, 'lạc rang 150g', 5000.00, 3, 'default_img.jpg', 'lạc rang', 0, 3, '2022-08-16 08:40:40', 0, b'0'),
(8, 'mực nướng', 200000.00, 5, 'default_img.jpg', 'mực biển nướng ', 0, 3, '2022-08-16 08:41:30', 0, b'1'),
(9, 'cá ba chỉ', 20000.00, 88, 'default_img.jpg', 'cá ba chỉ nướng', 0, 3, '2022-08-16 08:41:30', 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_nickname` varchar(50) NOT NULL,
  `user_active` bit(1) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `user_nickname`, `user_active`, `user_avatar`, `user_email`, `user_role`) VALUES
('tuanvanvan', '$2y$10$y8AI2WeRQiNmiGzVBbAd9urEXF2Cseo4kSi/RZ7sgY/8H/F4PhXNq', 'admin', b'1', '846f6a70b0466a183357.jpg', 'maohiemgia3@gmail.com', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
