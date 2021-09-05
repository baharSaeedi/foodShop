-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 20, 2021 at 10:29 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodshop`
--
CREATE DATABASE IF NOT EXISTS `foodshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `foodshop`;

-- --------------------------------------------------------

--
-- Table structure for table `cartcounter`
--

DROP TABLE IF EXISTS `cartcounter`;
CREATE TABLE IF NOT EXISTS `cartcounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(256) NOT NULL,
  `ord` smallint(6) NOT NULL,
  `sub_cat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `ord`, `sub_cat`) VALUES
(1, 'فست فود', 0, 1),
(2, 'غذای ایرانی', 0, 1),
(3, 'دسر', 0, 0),
(4, 'پیش غذا', 0, 0),
(5, 'نوشیدنی', 0, 0),
(6, 'پیتزا', 1, 0),
(32, 'ساندویچ', 1, 0),
(55, 'کباب ها', 2, 0),
(57, 'غذاهای خورشتی', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
CREATE TABLE IF NOT EXISTS `foods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `subCat_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `cat_id`, `subCat_id`, `title`, `image_path`, `price`, `create_date`) VALUES
(10, 6, 1, 'پیتزا پپرونی', 'images/product_images/peproni.jpg', '50000', '2021-08-18 17:59:27'),
(11, 6, 1, 'پیتزا مارگاریتا', 'images/product_images/margarita.jpg', '45000', '2021-08-18 18:38:37'),
(12, 6, 1, 'پیتزا مخصوص', 'images/product_images/special.jpg', '35000', '2021-08-18 18:41:32'),
(13, 6, 1, 'کیک پیتزا', 'images/product_images/cakePizza.jpg', '89000', '2021-08-18 18:43:57'),
(14, 32, 1, 'هات داگ', 'images/product_images/hotdog.jpg', '35000', '2021-08-18 18:46:17'),
(15, 32, 1, 'همبرگر', 'images/product_images/hamberger.jpg', '40000', '2021-08-18 18:46:42'),
(16, 32, 1, 'چیزبرگر', 'images/product_images/cheezberger.jpg', '50000', '2021-08-18 18:47:04'),
(17, 55, 2, 'جوجه کباب', 'images/product_images/jojeKebab.jpg', '55000', '2021-08-18 18:50:36'),
(18, 55, 2, 'چلوکباب', 'images/product_images/kebab.jpg', '50000', '2021-08-18 18:51:04'),
(19, 55, 2, 'چلوکباب برگ', 'images/product_images/kebabBarg.jpg', '70000', '2021-08-18 18:51:26'),
(20, 55, 2, 'چلوکباب سلطانی', 'images/product_images/kebabsoltani.jpg', '60000', '2021-08-18 18:51:48'),
(21, 57, 2, 'خورشت انار', 'images/product_images/anar.jpg', '45000', '2021-08-18 19:08:24'),
(22, 57, 2, 'خورشت قیمه', 'images/product_images/gheymeh.jpg', '45000', '2021-08-18 19:08:53'),
(23, 57, 2, 'خورشت قرمه سبزی', 'images/product_images/ghormeh.jpg', '45000', '2021-08-18 19:09:17'),
(24, 57, 2, 'خورشت قیمه بادمجان', 'images/product_images/gheymehBademjan.jpg', '50000', '2021-08-18 19:09:42'),
(25, 57, 2, 'خورشت کرفس', 'images/product_images/karafs.jpg', '45000', '2021-08-18 19:10:03'),
(26, 57, 2, 'خورشت بامیه', 'images/product_images/bamiyeh.jpg', '45000', '2021-08-18 19:10:22'),
(27, 5, 0, 'نوشابه خانواده کوکاکولا', 'images/product_images/bigcoca.jpg', '20000', '2021-08-18 19:33:06'),
(28, 5, 0, 'نوشابه خانواده پپسی', 'images/product_images/bigPeosi.jpg', '20000', '2021-08-18 19:33:27'),
(29, 5, 0, 'نوشابه قوطی کوکاکولا', 'images/product_images/coca.jpg', '12000', '2021-08-18 19:33:52'),
(30, 5, 0, 'نوشابه قوطی پپسی', 'images/product_images/pepsi.jpg', '12000', '2021-08-18 19:34:15'),
(31, 5, 0, 'نوشابه قوطی سون آپ', 'images/product_images/seven.jpg', '12000', '2021-08-18 19:35:01'),
(32, 3, 0, 'چیزکیک آلبالویی', 'images/product_images/albaloCheezCake.jpg', '30000', '2021-08-18 19:35:34'),
(33, 3, 0, 'چیزکیک کلاسیک', 'images/product_images/classicCheezCake.jpg', '30000', '2021-08-18 19:35:57'),
(34, 3, 0, 'کنافه', 'images/product_images/kanafe.jpg', '30000', '2021-08-18 19:38:53'),
(35, 3, 0, 'دسر عربی', 'images/product_images/arabic.jpg', '30000', '2021-08-18 19:39:09'),
(36, 3, 0, 'ژله بستنی', 'images/product_images/jelebastani.jpg', '30000', '2021-08-18 19:39:29'),
(37, 4, 0, 'سالاد سزار', 'images/product_images/sezar.jpg', '45000', '2021-08-18 19:41:34'),
(38, 4, 0, 'رولت پنیری مکزیکی', 'images/product_images/cheezRole.jpg', '45000', '2021-08-18 19:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:pending/2:cancel/3:compelete',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `count`, `price`, `create_date`, `status`) VALUES
(54, 91, 2, 50400, '2021-05-07 21:48:51', 3),
(56, 91, 4, 54500, '2021-05-07 21:50:56', 3),
(58, 91, 3, 64300, '2021-05-15 14:35:22', 3),
(67, 91, 2, 54000, '2021-05-30 08:50:20', 3),
(73, 109, 1, 14000, '2021-08-18 12:17:50', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pass_reset_requests`
--

DROP TABLE IF EXISTS `pass_reset_requests`;
CREATE TABLE IF NOT EXISTS `pass_reset_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `hash_new_pass` varchar(256) NOT NULL,
  `req_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pass_reset_requests`
--

INSERT INTO `pass_reset_requests` (`id`, `uid`, `hash_new_pass`, `req_date`) VALUES
(56, 91, '601f1889667efaebb33b8c12572835da3f027f78', '2021-04-21 00:20:59'),
(57, 91, '7c4a8d09ca3762af61e59520943dc26494f8941b', '2021-04-21 00:22:26'),
(58, 91, '601f1889667efaebb33b8c12572835da3f027f78', '2021-04-21 00:23:51'),
(59, 105, '601f1889667efaebb33b8c12572835da3f027f78', '2021-05-07 22:44:15'),
(60, 91, '601f1889667efaebb33b8c12572835da3f027f78', '2021-05-30 07:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL DEFAULT '2' COMMENT '1:admin/2:user',
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activationKey` varchar(256) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:inactive/1:active',
  `resetPassKey` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `email`, `password`, `mobile`, `create_date`, `activationKey`, `status`, `resetPassKey`) VALUES
(91, 1, 'حانیه', 'پیوندی', 'hpeyvandi0@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09109028344', '2021-04-15 18:36:24', NULL, 1, NULL),
(92, 2, 'مریم', 'فدوی', 'maryam_f@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09123328833', '2021-04-15 19:29:12', 'cba20dde1852f9610a7eaf443a29fb46', 0, NULL),
(94, 2, 'هدی', 'پیوندی', 'peyvandi_h1378@yahoo.com', '601f1889667efaebb33b8c12572835da3f027f78', '09109028322', '2021-04-26 15:25:47', NULL, 1, NULL),
(101, 1, 'حسام', 'پیوندی', 'hesam.peyvandi.83@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09109028322', '2021-04-30 21:21:08', NULL, 1, NULL),
(102, 2, 'علی', 'علوی فرد', 'ali@yahoo.com', '601f1889667efaebb33b8c12572835da3f027f78', '09109028342', '2021-05-01 08:58:53', 'e60387914b092fec9630626acc3d2642', 0, NULL),
(105, 2, 'هانیه', 'پیوندی', 'haniyeh.peyvandi@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09123328833', '2021-05-07 22:41:39', NULL, 1, NULL),
(106, 2, 'فاطمه', 'سعیدی', 'fatemeh@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09109028322', '2021-05-15 08:27:19', '0d790728d8699df872282e985f39d38c', 0, NULL),
(108, 2, 'قلی', 'قلی زاده', 'gholi@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '09123328531', '2021-05-30 07:30:50', '719fe9b7b02bb61f92b939273065dc77', 0, NULL),
(109, 2, 'بهار', 'سعیدی', 'saeedi.b99@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '09121231212', '2021-08-18 08:45:50', NULL, 1, '31982a31986e2905f310491d9f9b26d6');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pass_reset_requests`
--
ALTER TABLE `pass_reset_requests`
  ADD CONSTRAINT `pass_reset_requests_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
