-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.5-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for retail_shop
CREATE DATABASE IF NOT EXISTS `retail_shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `retail_shop`;

-- Dumping structure for table retail_shop.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.admin: ~1 rows (approximately)
INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `password`) VALUES
	(1, 'Super Admin', 'admin@gmail.com', '$2y$12$7Ptn.0/alRdnriiJnFA5I.A/bf0OowY.Dy1c38df45yyt6c/oZs4i');

-- Dumping structure for table retail_shop.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `products_id` int(10) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `c_id` varchar(255) NOT NULL,
  PRIMARY KEY (`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.cart: ~0 rows (approximately)

-- Dumping structure for table retail_shop.category
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.category: ~3 rows (approximately)
INSERT INTO `category` (`cat_id`, `cat_title`, `cat_desc`) VALUES
	(2, 'Electornics', 'Get the electronices'),
	(3, 'Clothes', 'Latest and best outfits'),
	(4, 'Mobile', 'Get the best smartphone');

-- Dumping structure for table retail_shop.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_pass` longtext NOT NULL,
  `customer_address` varchar(400) NOT NULL,
  `customer_contact` text NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(45) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.customer: ~2 rows (approximately)
INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_address`, `customer_contact`, `customer_image`, `customer_ip`) VALUES
	(1, 'John Doe', 'john@gmail.com', '$2y$12$XBwl1ONn3FeaQU1Qnk9JfubvbIpjUtp4dcZQyALe9M4PoraxK5v26', 'India', '98123453123', 'demo_photo.jpg', '::1'),
	(2, 'Dhiraj', 'dh@gmail.com', '$2y$12$M9bYfnjQGKXMtpYOsh/d.O0CnEaSxW9TohrPGIFexg7CpOdnuou0K', 'Nepal', '91234574321', 'demo_photo.jpg', '::1');

-- Dumping structure for table retail_shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_qty` int(10) NOT NULL,
  `order_price` varchar(50) NOT NULL DEFAULT '',
  `c_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Processing',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.orders: ~2 rows (approximately)
INSERT INTO `orders` (`order_id`, `order_qty`, `order_price`, `c_id`, `product_id`, `date`, `status`) VALUES
	(1, 1, '1000', 2, 6, '2025-05-05 16:43:27', 'Processing'),
	(2, 1, '30', 1, 4, '2025-05-05 16:47:31', 'Processing');

-- Dumping structure for table retail_shop.products
CREATE TABLE IF NOT EXISTS `products` (
  `products_id` int(10) NOT NULL AUTO_INCREMENT,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_keywords` text NOT NULL,
  `product_desc` text NOT NULL,
  `product_status` varchar(50) DEFAULT 'Live',
  PRIMARY KEY (`products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.products: ~6 rows (approximately)
INSERT INTO `products` (`products_id`, `p_cat_id`, `cat_id`, `date`, `product_title`, `product_img1`, `product_img2`, `product_price`, `product_keywords`, `product_desc`, `product_status`) VALUES
	(1, 2, 4, '2025-04-16 09:35:02', 'Smart TV 4K', 'smarttv1.jpg', 'smarttv2.jpg', 600, '4K, Smart TV, electronics', 'A 50-inch 4K Smart TV with Wi-Fi and Bluetooth support', 'Active'),
	(2, 2, 2, '2025-04-16 08:48:00', 'Bluetooth Headphones', 'headphones1.jpg', 'headphones2.jpg', 90, 'wireless, headphones, Bluetooth', 'Wireless Bluetooth headphones with noise cancellation feature', 'Active'),
	(3, 3, 3, '2025-04-16 08:48:03', 'Mens Denim Jacket', 'denim_jacket1.jpg', 'denim_jacket2.jpg', 50, 'jacket, denim, mens clothing', 'A stylish mens denim jacket with button closure and front pockets', 'Active'),
	(4, 3, 3, '2025-04-16 08:48:05', 'Womens Summer Dress', 'summer_dress1.jpg', 'summer_dress2.jpg', 30, 'dress, summer, womens fashion', 'Lightweight and breathable summer dress with floral patterns', 'Active'),
	(5, 4, 4, '2025-04-16 08:48:07', 'Samsung Galaxy S21', 'galaxy_s21_1.jpg', 'galaxy_s21_2.jpg', 800, 'smartphone, Samsung, Galaxy S21', 'Samsung Galaxy S21 with 5G support and 128GB storage', 'Active'),
	(6, 4, 4, '2025-04-16 08:48:09', 'iPhone 13 Pro', 'iphone13_1.jpg', 'iphone13_2.jpg', 1000, 'iPhone, smartphone, Apple', 'iPhone 13 Pro with A15 Bionic chip and 256GB storage', 'Active');

-- Dumping structure for table retail_shop.product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `p_cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL,
  PRIMARY KEY (`p_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.product_categories: ~3 rows (approximately)
INSERT INTO `product_categories` (`p_cat_id`, `p_cat_title`, `p_cat_desc`) VALUES
	(2, 'TV', 'Good quality custom made and casual wear jackets'),
	(3, 'Clothes', 'Good and easy stuff designed Tee-Shirt '),
	(4, 'Mobile Phone', 'High Quality Denim and Leather Jeans');

-- Dumping structure for table retail_shop.slider
CREATE TABLE IF NOT EXISTS `slider` (
  `slide_id` int(10) NOT NULL AUTO_INCREMENT,
  `slide_name` varchar(255) NOT NULL,
  `slide_image` text NOT NULL,
  `slide_heading` varchar(100) NOT NULL,
  `slide_text` varchar(100) NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail_shop.slider: ~4 rows (approximately)
INSERT INTO `slider` (`slide_id`, `slide_name`, `slide_image`, `slide_heading`, `slide_text`) VALUES
	(1, 'Slide 1', 'slide_1.jpg', 'Summer Sale', 'Walk in for the Fashion, Stay in for the Style.'),
	(2, 'Slide 2', 'slide_2.jpg', 'Black friday', 'Get the best products'),
	(3, 'slide3', 'slide_4.jpg', 'Shop Our New Collection', 'From Hight to low, classic or modern. We have you covered'),
	(4, 'slide4', 'slide_4.jpg', 'Hot Summer', 'Get the best deals and best collections from us');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
