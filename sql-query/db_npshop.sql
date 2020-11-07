-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2020 at 04:07 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_npshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cart`
--

CREATE TABLE `tb_cart` (
  `Cart_id` int(11) NOT NULL,
  `Cart_amount` int(4) NOT NULL,
  `Product_id` int(11) NOT NULL,
  `Member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `Member_id` int(11) NOT NULL,
  `Member_username` varchar(20) NOT NULL,
  `Member_password` varchar(255) NOT NULL,
  `Member_fullname` varchar(50) NOT NULL,
  `Member_email` varchar(30) NOT NULL,
  `Member_gender` varchar(4) DEFAULT NULL,
  `Member_idcard` varchar(13) DEFAULT NULL,
  `Member_address` varchar(100) DEFAULT NULL,
  `Member_phone` varchar(20) DEFAULT NULL,
  `Member_age` int(2) DEFAULT NULL,
  `Member_role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`Member_id`, `Member_username`, `Member_password`, `Member_fullname`, `Member_email`, `Member_gender`, `Member_idcard`, `Member_address`, `Member_phone`, `Member_age`, `Member_role`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Administrator', 'admin@npshop.com', NULL, NULL, NULL, NULL, NULL, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `Order_id` int(11) NOT NULL,
  `Order_date` datetime DEFAULT current_timestamp(),
  `Order_address` varchar(100) NOT NULL,
  `Order_phone` varchar(30) DEFAULT NULL,
  `Order_price` int(7) DEFAULT NULL,
  `Order_status` varchar(10) DEFAULT NULL,
  `Order_products` longtext DEFAULT NULL,
  `Member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_picture`
--

CREATE TABLE `tb_picture` (
  `Picture_id` int(11) NOT NULL,
  `Picture_name` varchar(50) NOT NULL,
  `Product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `Product_id` int(11) NOT NULL,
  `Product_name` varchar(50) NOT NULL,
  `Product_description` varchar(100) DEFAULT NULL,
  `Product_price` int(7) NOT NULL,
  `Product_amount` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`Cart_id`),
  ADD KEY `FK_Cart_Product` (`Product_id`),
  ADD KEY `FK_Cart_Member` (`Member_id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`Member_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`Order_id`),
  ADD KEY `FK_Order_Member` (`Member_id`);

--
-- Indexes for table `tb_picture`
--
ALTER TABLE `tb_picture`
  ADD PRIMARY KEY (`Picture_id`),
  ADD KEY `FK_Picture_Product` (`Product_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`Product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `Cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `Member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_picture`
--
ALTER TABLE `tb_picture`
  MODIFY `Picture_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD CONSTRAINT `FK_Cart_Member` FOREIGN KEY (`Member_id`) REFERENCES `tb_member` (`Member_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Cart_Product` FOREIGN KEY (`Product_id`) REFERENCES `tb_product` (`Product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `FK_Order_Member` FOREIGN KEY (`Member_id`) REFERENCES `tb_member` (`Member_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_picture`
--
ALTER TABLE `tb_picture`
  ADD CONSTRAINT `FK_Picture_Product` FOREIGN KEY (`Product_id`) REFERENCES `tb_product` (`Product_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
