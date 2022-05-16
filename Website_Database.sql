-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2022 at 03:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Website_Database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(24) NOT NULL,
  `user_cart_id` int(24) NOT NULL,
  `item_id` int(24) NOT NULL,
  `quantity` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `user_cart_id`, `item_id`, `quantity`, `created_at`, `modified_at`) VALUES
(73, 3, 30, 1, '2022-04-22 14:50:06', '0000-00-00 00:00:00'),
(74, 3, 23, 2, '2022-04-22 21:23:53', '2022-04-22 21:01:49'),
(75, 3, 29, 1, '2022-04-22 21:23:57', '2022-04-22 21:03:42'),
(86, 7, 28, 2, '2022-05-05 11:28:21', '2022-05-05 11:28:17'),
(87, 7, 31, 2, '2022-05-05 11:28:21', '2022-05-05 11:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(24) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `name`, `created_at`, `modified_at`) VALUES
(1, 'Burgers', '2022-04-21 21:53:32', '0000-00-00 00:00:00'),
(2, 'Pizza', '2022-04-21 21:53:55', '0000-00-00 00:00:00'),
(3, 'Sides', '2022-04-21 21:54:02', '0000-00-00 00:00:00'),
(4, 'Drinks', '2022-04-21 21:36:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(24) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `SKU` varchar(255) NOT NULL,
  `category_id` int(24) NOT NULL,
  `price` decimal(24,2) NOT NULL,
  `main_image_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `SKU`, `category_id`, `price`, `main_image_link`, `created_at`, `modified_at`) VALUES
(22, 'Cheese Burger', 'Buns, beef, cheese', '', 1, '3.79', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product1.jpeg', '2022-04-21 20:54:52', '0000-00-00 00:00:00'),
(23, 'Grilled Chicken Burger', 'Buns, beef, cheese', '', 1, '5.29', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product2.jpeg', '2022-04-21 20:57:00', '0000-00-00 00:00:00'),
(24, 'Beef Burger', 'Buns, beef, cheese', '', 1, '4.45', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product3.jpeg', '2022-04-21 20:57:00', '0000-00-00 00:00:00'),
(25, 'Chicken Burger', 'Buns, beef, cheese', '', 1, '3.99', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product4.jpeg', '2022-04-21 20:57:00', '0000-00-00 00:00:00'),
(26, 'Veggie Burger', 'Buns, beef, cheese', '', 1, '5.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product5.jpeg', '2022-04-21 20:57:00', '0000-00-00 00:00:00'),
(27, 'Margherita Pizza', 'Tomato and cheese pizza', '', 2, '12.39', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product6.jpeg', '2022-04-21 21:30:24', '0000-00-00 00:00:00'),
(28, 'Pepperoni Pizza', 'Tomato and cheese pizza', '', 2, '14.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product7.jpeg', '2022-04-21 21:30:24', '0000-00-00 00:00:00'),
(29, 'BBQ Pizza', 'Tomato and cheese pizza', '', 2, '15.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product8.jpeg', '2022-04-21 21:30:24', '0000-00-00 00:00:00'),
(30, 'Veggie Pizza', 'Vegetables Pizza', '', 2, '13.50', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product9.jpeg', '2022-04-21 21:30:24', '0000-00-00 00:00:00'),
(31, 'Chips', 'Fried potatoes', '', 3, '1.75', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product10.jpeg', '2022-04-21 21:35:22', '0000-00-00 00:00:00'),
(32, 'Spicy Chips', 'Spicy fried potatoes', '', 3, '1.99', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product11.jpeg', '2022-04-21 21:35:22', '0000-00-00 00:00:00'),
(33, 'Chicken Strips', 'Fried seasoned chicken strips', '', 3, '2.67', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product12.jpeg', '2022-04-21 21:35:22', '0000-00-00 00:00:00'),
(34, 'Salad', 'Salad', '', 3, '3.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product13.jpeg', '2022-04-21 21:35:22', '0000-00-00 00:00:00'),
(35, 'Onion Rings', 'Fried Onion Rings', '', 3, '2.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product14.jpeg', '2022-04-21 21:36:18', '0000-00-00 00:00:00'),
(36, 'Pepsi', 'Pepsi soft drink', '', 4, '2.30', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product15.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00'),
(37, 'Sprite', 'Sprite soft drink', '', 4, '2.30', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product16.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00'),
(38, 'Coca Cola', 'Coca Cola soft drink', '', 4, '2.30', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product17.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00'),
(39, 'Orange Juice', 'Orange juice', '', 4, '3.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product18.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00'),
(40, 'Apple Juice', 'Apple juice', '', 4, '3.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product19.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00'),
(41, 'Water bottle', 'Still water bottle', '', 4, '1.49', 'https://onlineordersystemimages.s3.eu-west-2.amazonaws.com/product20.jpeg', '2022-04-21 21:46:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(24) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `user_id`, `first_name`, `last_name`, `email`, `address_line_1`, `address_line_2`, `country`, `city`, `postcode`, `mobile`, `total`, `payment_id`, `created_at`, `modified_at`) VALUES
(2, 5, 'asdsasadaw', 'effeewwfw', 'wefwefwef', 'ewfefwfwe', 'fweweffefew', 'wfeew', 'ewfewf', 'feseffe', '65467846541', '1111.00', NULL, '2022-04-09 22:53:15', '0000-00-00 00:00:00'),
(3, 5, 'ergergerre', 'gregregre', 'grebe', 'regret', 'ergregg', 'gregr', 'rgrgegre', 'Greg', 'regret', '111.00', NULL, '2022-04-09 22:53:40', '0000-00-00 00:00:00'),
(4, 8, 'Aya', 'Al Deri', 'ayaalderi@gmail.com', '', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '0501276280', '248.00', NULL, '2022-04-10 00:06:26', '0000-00-00 00:00:00'),
(5, 8, 'Aya', 'Al Deri', 'ayaalderi@gmail.com', '', 'jkefkjejk', 'Saudi Arabia', 'Riyadh', '54544', '451545614', '379.00', NULL, '2022-04-10 00:08:52', '0000-00-00 00:00:00'),
(6, 8, 'Aya', 'Al Deri', 'ayaalderi@gmail.com', '', 'jkefkjejk', 'Saudi Arabia', 'Riyadh', '54544', '451545614', '379.00', NULL, '2022-04-10 00:10:08', '0000-00-00 00:00:00'),
(7, 8, 'Aya', 'Al Deri', 'cfskmslmkf', '', 'felm;fml', 'Afganistan', 'mdmjk', 'fmlwk', '900435435', '729.00', NULL, '2022-04-10 00:11:41', '0000-00-00 00:00:00'),
(8, 8, 'Aya', 'Al Deri', 'ayaalderi0@gmail.com', '', 'SGFLKSENK', 'Afganistan', 'ewjkefjk', '3233', '123455', '729.00', NULL, '2022-04-10 00:12:50', '0000-00-00 00:00:00'),
(9, 8, 'Aya', 'Al Deri', 'ayaalderi0@gmail.com', '', 'rglkjmgr', 'Afganistan', 'SJKEJ', 'KJGKJD', '2324224', '729.00', NULL, '2022-04-10 00:13:47', '0000-00-00 00:00:00'),
(10, 8, 'Aya', 'Al Deri', 'ayaalderi@gmail.com', '', '248 The Quays', 'United Kingdom', 'Manchester', 'M503SH', '07931361881', '659.00', 7, '2022-04-10 00:23:59', '0000-00-00 00:00:00'),
(11, 8, 'Mohammad', 'Al Deri', 'mohamadderi@gmail.com', '', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '0503283801', '450.00', 8, '2022-04-10 00:27:09', '0000-00-00 00:00:00'),
(12, 8, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Apartment 913', '248 The Quays', 'United Kingdom', 'Manchester', 'M503SH', '07931361881', '5299.00', 9, '2022-04-10 12:35:07', '0000-00-00 00:00:00'),
(13, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Apartment 913', '248 The Quays', 'United Kingdom', 'Manchester', 'M503SH', '+447931361881', '999.00', 10, '2022-04-12 12:50:26', '0000-00-00 00:00:00'),
(14, 5, 'Mohammad', 'Al Deri', 'mohamadderi@gmail.com', '6896 Ash Shamasiya Street', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+966503283801', '4137.00', 11, '2022-04-12 14:06:58', '0000-00-00 00:00:00'),
(15, 5, 'Ahmad', 'Al Deri', 'ahmadaldiri@gmail.com', 'Al Khan Corniche Street', 'Aparment 903', 'United Arab Erimates', 'Sharjah', '12345', '+971504816860', '1958.00', 12, '2022-04-12 14:21:31', '0000-00-00 00:00:00'),
(16, 5, 'Genah', 'Al Deri', 'genaalderi@gmail.com', '6896 Ash Shamasiya', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+966501222222', '1827.00', NULL, '2022-04-12 22:20:01', '0000-00-00 00:00:00'),
(17, 5, 'Genah', 'Al Deri', 'genaalderi@gmail.com', '6896 Ash Shamasiya', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+966501222222', '1827.00', NULL, '2022-04-12 22:21:32', '0000-00-00 00:00:00'),
(18, 5, 'Genah', 'Al Deri', 'genaalderi@gmail.com', '6896 Ash Shamasiya', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+966501222222', '1827.00', NULL, '2022-04-12 22:21:46', '0000-00-00 00:00:00'),
(19, 5, 'Genah', 'Al Deri', 'genaalderi@gmail.com', '6896 Ash Shamasiya', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+966501222222', '1827.00', NULL, '2022-04-12 22:22:40', '0000-00-00 00:00:00'),
(20, 5, 'Kevin', 'DeBruyne', 'kevin@gmail.com', 'Manchester City Football Club', 'Etihad Campus', 'United Kingdom', 'Manchester', 'M156BH', '07931361881', '858.00', 13, '2022-04-13 00:12:07', '0000-00-00 00:00:00'),
(21, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmaill.com', 'Flat 3', '302 Burton ', 'United Kingdom', 'Manchester', 'M202NB', '+447931361881', '999.00', NULL, '2022-04-15 12:23:12', '0000-00-00 00:00:00'),
(22, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Flat 3', '302 Burton Road', 'United Kingdom', 'Manchester', 'M202NB', '+447931361881', '729.00', 14, '2022-04-15 12:26:15', '0000-00-00 00:00:00'),
(23, 5, 'Ahmad', 'Al Deri', 'ahmaddairy@yahoo.com', 'Al Khan Corniche Street', 'Al Shahed Tower', 'United Arab Erimates', 'Sharjah', '12345', '+971504816860', '1138.00', 15, '2022-04-15 12:38:00', '0000-00-00 00:00:00'),
(24, 5, 'Genah', 'Al Deri', 'genaalderi@gmail.com', '6896 Ash Shamasiya Street', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '+447931361881', '659.00', 16, '2022-04-16 13:39:06', '0000-00-00 00:00:00'),
(25, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Apartment 913 ', '248 The Quays', 'United Kingdom', 'Manchester', 'M202NB', '+447931361881', '9.00', 17, '2022-04-21 23:28:42', '2022-04-21 23:28:42'),
(26, 5, 'Maymona', 'AlDiery', 'maymonaalderi@gmail.com', '6896 Ash Shamasiya', 'Villa 13', 'Saudi Arabia', 'RIyadh', '12252', '0501276280', '19.00', 18, '2022-04-21 23:36:57', '2022-04-21 23:36:57'),
(27, 5, 'Johnq', 'Smotjh', 'j.smioth@gmail.cpom', '6896 Ash Shamasiya Street', 'VIlla 13', 'Saudi Arabia', 'Riyadh', '12252', '+447931361881', '145.60', 19, '2022-04-22 14:28:52', '2022-04-22 14:28:52'),
(28, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Flat 3', '302 Burton Road', 'United Kingdom', 'Manchester', 'M202NB', '+447931361881', '17.95', 20, '2022-04-23 19:42:03', '2022-04-23 19:42:03'),
(29, 11, 'Test', 'User', 'test.user2@gmail.com', '6896 Ash Shamasiya Street', 'Villa 13', 'Afganistan', 'Riyadh', '12252', '+447931361881', '60.68', 21, '2022-05-05 13:41:57', '2022-05-05 13:41:56'),
(30, 11, 'Test', 'User', 'test.user2@gmail.com', '6896 Ash Shamasiya Street', 'Villa 13', 'Afganistan', 'Riyadh', '12252', '+447931361881', '3.99', 22, '2022-05-05 13:45:33', '2022-05-05 13:45:33'),
(31, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Flat 3', '302 Burton Road', 'United Kingdom', 'Manchester', 'M503SH', '7931361881', '88.95', 23, '2022-05-06 14:41:03', '2022-05-06 14:41:03'),
(32, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', '6896 Ash Shamasiya Street', 'Villa 13', 'Saudi Arabia', 'Riyadh', '12252', '0504887251', '20.09', 24, '2022-05-06 14:50:47', '2022-05-06 14:50:47'),
(33, 5, 'Zaid', 'Al Deri', 'zaidalderi2001@gmail.com', 'Apartment 913', '248 The Quays', 'United Kingdom', 'Manchester', 'M503SH', '7931361881', '2.30', 25, '2022-05-12 13:24:01', '2022-05-12 13:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(24) NOT NULL,
  `order_id` int(24) NOT NULL,
  `item_id` int(24) NOT NULL,
  `quantity` int(24) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `created_at`, `modified_at`) VALUES
(16, 25, 36, 1, '2022-04-21 23:28:42', '2022-04-21 23:28:42'),
(17, 25, 23, 1, '2022-04-21 23:28:42', '2022-04-21 23:28:42'),
(18, 25, 31, 1, '2022-04-21 23:28:42', '2022-04-21 23:28:42'),
(19, 26, 23, 1, '2022-04-21 23:36:57', '2022-04-21 23:36:57'),
(20, 26, 27, 1, '2022-04-21 23:36:57', '2022-04-21 23:36:57'),
(21, 26, 31, 1, '2022-04-21 23:36:57', '2022-04-21 23:36:57'),
(22, 27, 29, 7, '2022-04-22 14:28:52', '2022-04-22 14:28:52'),
(23, 27, 27, 3, '2022-04-22 14:28:52', '2022-04-22 14:28:52'),
(24, 28, 34, 4, '2022-04-23 19:42:03', '2022-04-23 19:42:03'),
(25, 28, 25, 1, '2022-04-23 19:42:03', '2022-04-23 19:42:03'),
(26, 29, 39, 1, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(27, 29, 24, 1, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(28, 29, 28, 1, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(29, 29, 37, 2, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(30, 29, 36, 6, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(31, 29, 23, 1, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(32, 29, 22, 2, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(33, 29, 40, 2, '2022-05-05 13:41:56', '2022-05-05 13:41:56'),
(34, 30, 25, 1, '2022-05-05 13:45:33', '2022-05-05 13:45:33'),
(35, 31, 30, 2, '2022-05-06 14:41:03', '2022-05-06 14:41:03'),
(36, 31, 27, 5, '2022-05-06 14:41:03', '2022-05-06 14:41:03'),
(37, 32, 38, 2, '2022-05-06 14:50:47', '2022-05-06 14:50:47'),
(38, 32, 29, 1, '2022-05-06 14:50:47', '2022-05-06 14:50:47'),
(39, 33, 38, 1, '2022-05-12 13:24:01', '2022-05-12 13:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(24) NOT NULL,
  `order_id` int(24) NOT NULL,
  `amount` decimal(24,2) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `card_number` varchar(255) NOT NULL,
  `exp_month` int(11) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `cvv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `order_id`, `amount`, `provider`, `status`, `created_at`, `modified_at`, `card_number`, `exp_month`, `exp_year`, `cvv`) VALUES
(1, 4, '248.00', 'Mastercard', '', '2022-04-10 00:06:26', '0000-00-00 00:00:00', '1234567891', 11, 23, 123),
(2, 4, '379.00', 'Amex', '', '2022-04-10 00:08:52', '0000-00-00 00:00:00', '134567', 11, 22, 22),
(3, 4, '379.00', 'Amex', '', '2022-04-10 00:10:08', '0000-00-00 00:00:00', '134567', 11, 22, 22),
(4, 4, '729.00', 'Visa', '', '2022-04-10 00:11:41', '0000-00-00 00:00:00', '343466343', 111, 111, 1111),
(5, 4, '729.00', 'Mastercard', '', '2022-04-10 00:12:50', '0000-00-00 00:00:00', '43634634', 32323, 322323, 222),
(6, 4, '729.00', 'Visa', '', '2022-04-10 00:13:47', '0000-00-00 00:00:00', '765576', 555, 55, 55),
(7, 10, '659.00', 'Visa', '', '2022-04-10 00:23:59', '0000-00-00 00:00:00', '1234567891011', 8, 26, 123),
(8, 11, '450.00', 'Visa', '', '2022-04-10 00:27:09', '0000-00-00 00:00:00', '1234567896311', 10, 23, 222),
(9, 12, '5299.00', 'Mastercard', '', '2022-04-10 12:35:07', '0000-00-00 00:00:00', '465945611565001', 10, 23, 4),
(10, 13, '999.00', 'Visa', '', '2022-04-12 12:50:26', '0000-00-00 00:00:00', '4659432816186036', 10, 23, 123),
(11, 14, '4137.00', 'Mastercard', '', '2022-04-12 14:06:58', '0000-00-00 00:00:00', '4657985612367894', 11, 26, 258),
(12, 15, '1958.00', 'Amex', '', '2022-04-12 14:21:31', '2022-04-12 14:21:31', '4658999963146587', 11, 23, 123),
(13, 20, '858.00', 'Amex', '', '2022-04-13 00:12:07', '2022-04-13 00:12:07', '4789632156871234', 10, 23, 222),
(14, 22, '729.00', 'Visa', '', '2022-04-15 12:26:15', '2022-04-15 12:26:15', '4659432816186036', 10, 23, 123),
(15, 23, '1138.00', 'Mastercard', '', '2022-04-15 12:38:00', '2022-04-15 12:38:00', '************6687', 10, 23, 123),
(16, 24, '659.00', 'Mastercard', '', '2022-04-16 13:39:06', '2022-04-16 13:39:06', '************0027', 10, 23, 122),
(17, 25, '9.00', 'Visa', '', '2022-04-21 23:28:42', '2022-04-21 23:28:42', '************4567', 10, 22, 123),
(18, 26, '19.43', 'Visa', '', '2022-04-21 23:36:57', '2022-04-21 23:36:57', '************6036', 10, 22, 123),
(19, 27, '145.60', 'Visa', '', '2022-04-22 14:28:52', '2022-04-22 14:28:52', '************1234', 10, 22, 123),
(20, 28, '17.95', 'Visa', '', '2022-04-23 19:42:03', '2022-04-23 19:42:03', '************6036', 10, 23, 123),
(21, 29, '60.68', 'Visa', '', '2022-05-05 13:41:57', '2022-05-05 13:41:57', '************6036', 10, 22, 231),
(22, 30, '3.99', 'Mastercard', '', '2022-05-05 13:45:33', '2022-05-05 13:45:33', '************3122', 10, 22, 333),
(23, 31, '88.95', 'Visa', '', '2022-05-06 14:41:03', '2022-05-06 14:41:03', '************6036', 10, 22, 333),
(24, 32, '20.09', 'Visa', '', '2022-05-06 14:50:47', '2022-05-06 14:50:47', '************7899', 11, 22, 123),
(25, 33, '2.30', 'Visa', '', '2022-05-12 13:24:01', '2022-05-12 13:24:01', '************6036', 10, 22, 123);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(24) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `created_at`, `modified_at`) VALUES
(2, '', '$2y$10$MGC/3opyTMQ2jp05gpY.gONTbsD9avjomtapGUpTquaSTl5gQ59WC', 'Zaid', 'Al Deri', '2022-03-30 20:47:16', '0000-00-00 00:00:00'),
(3, 'Email can only contain letters, numbers, and underscores.', '$2y$10$5S1CPLO4cu0SDi8Rp8SWDuUttQi.YSZJKVkFyNA0ymuL3x2zaj5Hm', 'John', 'Stones', '2022-03-30 20:49:51', '0000-00-00 00:00:00'),
(4, 'j.lark@gmail.com', '$2y$10$g7fkDZCa8x3R8XsMAv5M2uNEEq2Fuoh8mIeLKiVJGpEA1y7o7o.LK', 'John', 'Lark', '2022-03-30 20:51:53', '0000-00-00 00:00:00'),
(5, 'zaidalderi2001@gmail.com', '$2y$10$maFeGr7DXeW8QoX1YLoDaOlJoCXuPwOLzN.Pvcp3a3msFxuB6UJqO', 'Zaid', 'Al Deri', '2022-04-26 15:02:58', '0000-00-00 00:00:00'),
(6, 'abdullah@gmail.com', '$2y$10$WLQ5eEIQ0N3xlru0qZGPFeNo37pXeVjydjZ4AQpuhU.VNLLeYwrMG', 'Abdullah', 'Al Deri', '2022-04-01 23:41:59', '0000-00-00 00:00:00'),
(7, 'hayaalderi@gmail.com', '$2y$10$nKMDnyG7OmLd2qemTfV9je2iVvwEr8AVrs.5hORGg58xNrUKPQns6', 'Haya', 'Al Deri', '2022-04-08 01:26:13', '0000-00-00 00:00:00'),
(8, 'ayaalderi@gmail.com', '$2y$10$9Ct4s0lsoGGm2OD6kXTHbuSX8bNFpeqMuZE8rs6lFLYh8dPLTkWv6', 'Aya', 'Al Deri', '2022-04-09 13:47:41', '0000-00-00 00:00:00'),
(9, 'maymonaalderi@gmail.com', '$2y$10$v2ASLaOcoLulgH6JcxxO6OG5V1s3b051SgJvR57EjvTwYiT7zJVcy', 'Maymona', 'Al Deri', '2022-04-09 23:29:54', '0000-00-00 00:00:00'),
(10, 'test.user1@gmail.com', '$2y$10$6.p5d.4cDfqG4tIuL9Wsee5Q57sycPNlaFIEkjRkA0kxk9ZObH38u', 'Test', 'User', '2022-05-05 11:28:01', '0000-00-00 00:00:00'),
(11, 'test.user2@gmail.com', '$2y$10$lyLztSDQXAPqNE6P6TiNk.4I6lv3mFw8ryEc/smbzwKtWYwz2/igu', 'Test', 'User', '2022-05-05 11:30:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(24) NOT NULL,
  `user_id` int(24) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `country` varchar(24) NOT NULL,
  `mobile` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address_line_1`, `address_line_2`, `city`, `postcode`, `country`, `mobile`) VALUES
(4, 6, '319', 'Timberland Gate', 'Oakville', 'L6M0Y8', 'Canada', '+1000000');

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `id` int(24) NOT NULL,
  `user_id` int(24) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_cart`
--

INSERT INTO `user_cart` (`id`, `user_id`, `total`, `created_at`, `modified_at`) VALUES
(1, 5, '0', '2022-04-08 13:17:21', '2022-04-08 15:17:01'),
(3, 7, '0', '2022-04-08 14:22:36', '2022-04-08 14:22:36'),
(4, 6, '0', '2022-04-09 01:27:59', '2022-04-09 01:27:59'),
(5, 8, '0', '2022-04-09 13:47:53', '2022-04-09 13:47:53'),
(6, 9, '0', '2022-04-09 23:30:03', '2022-04-09 23:30:03'),
(7, 10, '0', '2022-05-05 11:28:12', '2022-05-05 11:28:12'),
(8, 11, '0', '2022-05-05 11:31:08', '2022-05-05 11:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `id` int(24) NOT NULL,
  `user_id` int(24) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `security_code` int(24) NOT NULL,
  `exp_month` int(24) NOT NULL,
  `exp_year` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_payment`
--

INSERT INTO `user_payment` (`id`, `user_id`, `provider`, `card_number`, `security_code`, `exp_month`, `exp_year`) VALUES
(2, 4, 'Mastercard', '3333444455551111', 0, 12, 23),
(8, 7, 'Amex', '112531561151', 122, 10, 2022),
(11, 5, 'Visa', '************6036', 123, 10, 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`item_id`),
  ADD KEY `session_id` (`user_cart_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ibfk_1` (`category_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_ibfk_1` (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`item_id`),
  ADD KEY `order_items_ibfk_2` (`order_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_cart`
--
ALTER TABLE `user_cart`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_payment`
--
ALTER TABLE `user_payment`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`user_cart_id`) REFERENCES `user_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `item_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD CONSTRAINT `user_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD CONSTRAINT `user_payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
