CREATE DATABASE IF NOT EXISTS `retail_shop`;
USE `retail_shop`;

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `role` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `password`, `role`) VALUES
	(1, 'Admin', 'admin@gmail.com', '$2y$12$kIfYygGWTnC7jgTnFSiSWOlGadrmIN/V6nJVYZIoUMSJ1An8Xnz7.', 'admin'),
	(2, 'Super Admin', 'superadmin@gmail.com', '$2y$12$kIfYygGWTnC7jgTnFSiSWOlGadrmIN/V6nJVYZIoUMSJ1An8Xnz7.', 'superadmin');

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Fashion'),
	(2, 'Lifestyle'),
	(3, 'Trends');

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `blog_posts` (`id`, `title`, `content`, `image`, `created_at`, `category_id`) VALUES
	(1, 'Leandra Medine On The Importance Of Maintaining Her Personal Style', 'The founder of Man Repeller is already thinking about outfitting you for New Year\'s Eve 2020...', 'img/blog/blog1.jpg', '2025-05-06 11:59:21', 1),
	(2, 'Olivia Anthony Thinks There Absolutely Should Be Crying In Fashion', 'Introducing Self-Made, Refinery29\'s newest column spotlighting the real stories...', 'img/blog/blog2.jpg', '2025-05-06 11:59:21', 1),
	(3, 'My Blog', 'Lorem Lupsum', 'https://cdn.pixabay.com/photo/2014/06/03/19/38/board-361516_640.jpg', '2025-05-06 12:23:12', 1);

CREATE TABLE IF NOT EXISTS `cart` (
  `products_id` int(10) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `c_id` varchar(255) NOT NULL,
  PRIMARY KEY (`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_title` (`cat_title`(768))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `category` (`cat_id`, `cat_title`, `cat_desc`) VALUES
	(2, 'Electornics', 'Get the electronices'),
	(3, 'Clothes', 'Latest and best outfits'),
	(4, 'Mobile', 'Get the best smartphone');

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
	(1, 'Bishal', 'bishal@gmail.com', 'testing', 'asdasdsadasd\r\n', '2025-05-10 07:24:38');

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_pass` longtext NOT NULL,
  `customer_address` varchar(400) NOT NULL,
  `customer_contact` text NOT NULL,
  `customer_image` text NOT NULL,
  `customer_ip` varchar(45) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `verify_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_address`, `customer_contact`, `customer_image`, `customer_ip`, `email_verified`, `verify_token`) VALUES
	(1, 'Bishal', 'bishal@gmail.com', '$2y$12$kIfYygGWTnC7jgTnFSiSWOlGadrmIN/V6nJVYZIoUMSJ1An8Xnz7.', 'United Kingdom', '98412345712', 'demo_photo.jpg', '::1', 1, NULL);

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

INSERT INTO `orders` (`order_id`, `order_qty`, `order_price`, `c_id`, `product_id`, `date`, `status`) VALUES
	(1, 1, '40', 1, 7, '2025-05-10 06:09:46', 'Processing'),
	(2, 1, '30', 1, 4, '2025-05-10 06:10:47', 'Sold');
  (2, '120', 1, 5, '2025-05-01 10:15:00', 'Sold'),
  (1, '50', 1, 1, '2025-05-03 14:30:00', 'Sold'),
  (3, '90', 1, 6, '2025-05-06 09:45:00', 'Sold'),
  (1, '75', 1, 3, '2025-05-09 17:20:00', 'Sold');


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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`products_id`, `p_cat_id`, `cat_id`, `date`, `product_title`, `product_img1`, `product_img2`, `product_price`, `product_keywords`, `product_desc`, `product_status`) VALUES
	(1, 2, 4, '2025-04-16 03:50:02', 'Smart TV 4K', 'smarttv1.jpg', 'smarttv2.jpg', 600, '4K, Smart TV, electronics', 'A 50-inch 4K Smart TV with Wi-Fi and Bluetooth support', 'Active'),
	(2, 2, 2, '2025-04-16 03:03:00', 'Bluetooth Headphones', 'headphones1.jpg', 'headphones2.jpg', 90, 'wireless, headphones, Bluetooth', 'Wireless Bluetooth headphones with noise cancellation feature', 'Active'),
	(3, 3, 3, '2025-04-16 03:03:03', 'Mens Denim Jacket', 'denim_jacket1.jpg', 'denim_jacket2.jpg', 50, 'jacket, denim, mens clothing', 'A stylish mens denim jacket with button closure and front pockets', 'Active'),
	(4, 5, 3, '2025-05-10 05:37:20', 'Womens Summer Dress', 'summer_dress1.jpg', 'summer_dress2.jpg', 30, 'dress, summer, womens fashion', 'Lightweight and breathable summer dress with floral patterns', 'Active'),
	(5, 4, 4, '2025-04-16 03:03:07', 'Samsung Galaxy S21', 'galaxy_s21_1.jpg', 'galaxy_s21_2.jpg', 800, 'smartphone, Samsung, Galaxy S21', 'Samsung Galaxy S21 with 5G support and 128GB storage', 'Active'),
	(6, 4, 4, '2025-04-16 03:03:09', 'iPhone 13 Pro', 'iphone13_1.jpg', 'iphone13_2.jpg', 1000, 'iPhone, smartphone, Apple', 'iPhone 13 Pro with A15 Bionic chip and 256GB storage', 'Active'),
	(7, 6, 3, '2025-05-10 06:00:27', 'Kids Dress', 'kids_dress_1.png', 'kids_dress_2.png', 40, 'kids, clothing, babyclothes, online', 'Celebrate cultural heritage with our traditional kids wear collection. This ensemble features intricate embroidery and vibrant colors, perfect for festivals and family gatherings.', 'Active'),
	(10, 3, 3, '2025-05-10 07:42:18', 'Leather Bomber Jacket', 'leatherbomberjacket.png', 'leatherbomberjacket.png', 149, 'Leather, Bomber Jacket, Casual, Men\'s Fashion, Outerwear', 'Crafted from high-quality leather, this bomber jacket combines classic style with modern appeal. Featuring a sleek zip-up front, ribbed cuffs, and a comfortable inner lining, it\'s perfect for adding an edge to your everyday look.', 'Active'),
	(11, 3, 3, '2025-05-10 07:44:06', 'Slim Fit Chinos', 'slim_fit_chinos.jpg', 'slim_fit_chinos.jpg', 49, 'Chinos, Slim Fit, Men\'s Pants, Casual Wear, Fashion', 'These slim-fit chinos are the ultimate blend of comfort and style. Made with soft cotton fabric, they offer a tailored fit that flatters your silhouette. Perfect for both casual and semi-formal occasions, they’ll be a wardrobe staple.', 'Active'),
	(12, 3, 3, '2025-05-10 07:45:08', 'Classic Denim Jeans', 'classic_jeans_1.png', 'classic_jeans_1.png', 59, 'Denim, Jeans, Casual, Men\'s Fashion, Classic Style', 'These classic denim jeans are a timeless addition to any wardrobe. Made with durable cotton, they feature a mid-rise fit and a versatile wash that pairs well with almost anything. Whether for work or play, they’ll keep you looking sharp.', 'Active'),
	(13, 3, 3, '2025-05-10 07:46:06', 'Premium Wool Sweater', 'wool_sweater.jpg', 'wool_sweater.jpg', 79, 'Wool, Sweater, Men\'s Clothing, Winter Fashion, Warmth', 'This premium wool sweater is the perfect winter essential. Soft, warm, and breathable, it provides comfort and warmth without sacrificing style. Whether layered over a shirt or worn on its own, this sweater is perfect for the colder months.', 'Active'),
	(14, 5, 3, '2025-05-10 07:47:31', 'Elegant Satin Evening Gown', 'ekegant_gown.jpg', 'ekegant_gown.jpg', 199, 'Evening Gown, Satin, Formal Wear, Women\'s Fashion, Party Dress', 'This elegant satin evening gown features a flattering silhouette with a graceful flow. The luxurious fabric hugs your curves while maintaining comfort, making it perfect for a sophisticated night out or formal events.', 'Active'),
	(15, 5, 3, '2025-05-10 07:48:57', 'Casual Button-Down Shirt', 'bottom_down_shirt.jpg', 'bottom_down_shirt.jpg', 39, 'Shirt, Casual, Button-Down, Women\'s Tops, Office Wear', 'Crafted from soft cotton, this casual button-down shirt is a wardrobe essential. Its classic design and versatile style make it perfect for both work and weekend wear. Pair it with jeans or a skirt for a stylish and comfortable look.', 'Active'),
	(16, 5, 3, '2025-05-10 07:50:25', 'Floral Print Maxi Dress', 'floral_print.png', 'floral_print.png', 59, 'Maxi Dress, Floral, Summer Wear, Women\'s Clothing, Boho Style', 'This beautiful floral print maxi dress offers a flowy, relaxed fit with a bohemian vibe. Made from lightweight fabric, it’s perfect for warm weather and can easily be dressed up or down with the right accessories.', 'Active');

CREATE TABLE IF NOT EXISTS `product_categories` (
  `p_cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL,
  `p_cat_type` text DEFAULT NULL,
  PRIMARY KEY (`p_cat_id`),
  KEY `p_cat_title` (`p_cat_title`(768))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_categories` (`p_cat_id`, `p_cat_title`, `p_cat_desc`, `p_cat_type`) VALUES
	(2, 'Electronics', 'Good quality custom made and casual wear jackets', NULL),
	(3, 'Clothes', 'Good and easy stuff designed Tee-Shirt ', 'Men'),
	(4, 'Mobile', 'High Quality Denim and Leather Jeans', NULL),
	(5, 'Clothes', 'Good and easy stuff designed Tee-Shirt ', 'Women'),
	(6, 'Clothes', 'Good and easy stuff designed Tee-Shirt ', 'Kids');

CREATE TABLE IF NOT EXISTS `slider` (
  `slide_id` int(10) NOT NULL AUTO_INCREMENT,
  `slide_name` varchar(255) NOT NULL,
  `slide_image` text NOT NULL,
  `slide_heading` varchar(100) NOT NULL,
  `slide_text` varchar(100) NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `slider` (`slide_id`, `slide_name`, `slide_image`, `slide_heading`, `slide_text`) VALUES
	(1, 'Slide 1', 'slide_1.jpg', 'Summer Sale', 'Walk in for the Fashion, Stay in for the Style.'),
	(2, 'Slide 2', 'slide_2.jpg', 'Black friday', 'Get the best products'),
	(3, 'slide3', 'slide_4.jpg', 'Shop Our New Collection', 'From Hight to low, classic or modern. We have you covered'),
	(4, 'slide4', 'slide_4.jpg', 'Hot Summer', 'Get the best deals and best collections from us');