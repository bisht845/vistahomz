-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2026 at 12:49 PM
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
-- Database: `vistahomz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Vista Admin', 'admin@vistahomz.com', '$2y$12$GGyUg9ICsyNpZviOd4FPV.05AV23vzzNn0lCZbWzQ8FUhgVYMwB7K', 'superadmin', 1, '2026-10-19 13:36:50', '2026-09-21 10:10:21', '2026-10-19 13:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `session_id`, `product_id`, `product_name`, `product_code`, `image`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'iokf4v9bbjn7eoph7vbrttj09s', 3, 'King Size Bed Frame', 'BD001', 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80', 13, '2026-10-15 13:08:56', '2026-10-15 13:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `show_in_nav` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `icon`, `sort_order`, `is_active`, `show_in_nav`, `meta_title`, `meta_desc`, `created_at`, `updated_at`) VALUES
(1, 'Livings', 'living', 'Sofas, recliners, TV units and living room furniture', NULL, 'bi-house-heart', 1, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-10-15 16:23:15'),
(2, 'Dining', 'dining', 'Dining tables, chairs, bar stools and crockery units', NULL, 'bi-egg-fried', 2, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(3, 'Bedroom', 'bedroom', 'Beds, wardrobes, dressing tables and bedroom essentials', NULL, 'bi-moon-stars', 3, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(4, 'Office', 'office', 'Workstations, executive chairs, meeting tables & storage', NULL, 'bi-briefcase', 4, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(5, 'Commercial', 'commercial', 'Bulk solutions for hotels, hospitals, cafes & schools', NULL, 'bi-building', 5, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(6, 'Decor', 'decor', 'Home decor, accessories and accent pieces', NULL, 'bi-stars', 6, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `name`, `slug`, `description`, `image`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Modern Luxe', 'modern-luxe', 'Contemporary luxury for modern spaces', NULL, 1, 1, '2026-09-21 10:10:21'),
(2, 'Classic Heritage', 'classic-heritage', 'Timeless elegance with traditional craft', NULL, 2, 1, '2026-09-21 10:10:21'),
(3, 'Office Pro', 'office-pro', 'Professional workspace solutions', NULL, 3, 1, '2026-09-21 10:10:21'),
(4, 'Hospitality Plus', 'hospitality-plus', 'Commercial-grade hospitality furniture', NULL, 4, 1, '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_replied` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `is_replied`, `created_at`) VALUES
(1, 'Topnex Media', 'info@topnexmedia.com', '9878445781', 'work', 'tesing', 1, 0, '2026-10-19 13:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_banners`
--

CREATE TABLE `homepage_banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_url` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_banners`
--

INSERT INTO `homepage_banners` (`id`, `title`, `subtitle`, `label`, `image`, `btn1_text`, `btn1_url`, `btn2_text`, `btn2_url`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Premium Spaces Begin Here', 'End-to-end furniture solutions for homes, offices, hotels, schools & hospitality spaces — handcrafted with precision and delivered with care.', 'Commercial & Residential Furniture', 'https://images.openai.com/static-rsc-4/bmImH4Aw9CIPK16jkpVTUzJVjdKEo9-1FLn2AbgiyHrR6Jf1tGsCyBO1aQL9HZo8nAZMP78uEz_STSI9Bk2e1ZKR-aiwiVozgLB5Gfe99df5r7rGX0ufm8en430Fw_q2wPdZiEEAW1O1DobXBy778Wn3RXEP8TRejNoGpn792nRyqfnUpoUbXmb73BurZuQw?purpose=fullsize', 'Explore Collections', 'category.php?cat=all', 'Get Free Quote', 'contact.php', 1, 1, '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(10) NOT NULL DEFAULT '?',
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`, `icon`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Offices & Startups', '🏢', 'Ergonomic workstations, executive cabins & reception desks', 1, 1, '2026-09-21 10:10:21'),
(2, 'Hotels & Hospitality', '🏨', 'Room sets, lobby & banquet furniture at scale', 2, 1, '2026-09-21 10:10:21'),
(3, 'Cafes & Restaurants', '☕', 'Bar stools, café tables & indoor-outdoor seating', 3, 1, '2026-09-21 10:10:21'),
(4, 'Hospitals & Clinics', '🏥', 'Patient benches, waiting chairs & ward essentials', 4, 1, '2026-09-21 10:10:21'),
(5, 'Schools & Institutes', '🏫', 'Classroom desks, lab furniture & library sets', 5, 1, '2026-09-21 10:10:21'),
(6, 'Homes & Residences', '🏠', 'Living, bedroom & dining furniture for modern homes', 6, 1, '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('product','bulk','whatsapp','general') NOT NULL DEFAULT 'general',
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_replied` tinyint(1) NOT NULL DEFAULT 0,
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `type`, `product_id`, `product_name`, `product_code`, `name`, `email`, `phone`, `message`, `source`, `is_read`, `is_replied`, `admin_notes`, `created_at`) VALUES
(1, 'product', 1, 'Luxury Sofa Set', 'SF001', 'Topnex Media', 'info@topnexmedia.com', '9878445781', 'text', NULL, 1, 0, NULL, '2026-10-19 12:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `subcategory_id` int(10) UNSIGNED DEFAULT NULL,
  `collection_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short_desc` varchar(500) DEFAULT NULL,
  `material` varchar(200) DEFAULT NULL,
  `dimensions` varchar(200) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `colors` varchar(200) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_bestseller` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','out_of_stock') NOT NULL DEFAULT 'active',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `slug`, `category_id`, `subcategory_id`, `collection_id`, `description`, `short_desc`, `material`, `dimensions`, `weight`, `colors`, `is_featured`, `is_new`, `is_bestseller`, `status`, `sort_order`, `views`, `meta_title`, `meta_desc`, `created_at`, `updated_at`) VALUES
(1, 'SF001', 'Luxury Sofa Set', 'luxury-sofa-set', 1, 2, NULL, 'Premium quality Luxury Sofa Set designed for modern homes with comfort and elegance. Upholstered in high-grade fabric with solid wood frame.', 'Premium fabric sofa set for modern living', 'High-grade fabric, Solid hardwood', NULL, NULL, NULL, 1, 1, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(2, 'SF002', '3-Seater Comfort Sofa', '3-seater-comfort-sofa', 1, 1, NULL, 'Contemporary sofa featuring clean lines and premium materials. Perfect for any modern living space.', 'Contemporary sofa for modern living', 'Premium velvet, Solid wood legs', NULL, NULL, NULL, 1, 0, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(3, 'BD001', 'King Size Bed Frame', 'king-size-bed-frame', 3, 12, NULL, 'Luxurious king-size bed with upholstered headboard and solid wood base. Brings elegance to any master bedroom.', 'King size bed with upholstered headboard', 'Engineered wood, Premium fabric', NULL, NULL, NULL, 1, 1, 0, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(4, 'OF001', 'Executive Office Chair', 'executive-office-chair', 4, 17, NULL, 'Ergonomic executive chair with lumbar support, adjustable height and premium PU leather upholstery.', 'Ergonomic executive chair with lumbar support', 'PU leather, Chrome base', NULL, NULL, NULL, 1, 0, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(5, 'DT001', '6-Seater Dining Table', '6-seater-dining-table', 2, 7, NULL, 'Solid wood dining table with 6 matching chairs. Perfect for family gatherings and entertaining.', 'Solid wood dining table with chairs', 'Sheesham wood, Lacquer finish', NULL, NULL, NULL, 1, 1, 0, 'active', 0, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-10-15 16:28:26'),
(6, 'WS001', 'Premium Workstation', 'premium-workstation', 4, 18, NULL, 'Modern office workstation designed for productivity. Cable management and modular design.', 'Modern modular office workstation', 'Steel frame, MDF top', NULL, NULL, NULL, 0, 1, 0, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(7, 'D17 · DECOR', 'Wooden Bird & Double Candle Wall Sconce', 'wooden-bird-double-candle-wall-sconce', 6, NULL, NULL, 'Bring warmth and natural elegance to your interiors with this beautifully sculpted wooden bird wall sconce. Featuring a graceful flying bird, flowing organic branches, and two integrated candle holders, the design combines nature-inspired artistry with soft ambient lighting. Its rich wood finish makes it a striking addition to modern, rustic and luxury interiors.', '', '', '', NULL, '', 0, 1, 1, 'active', 0, 0, '', '', '2026-10-15 15:55:02', '2026-10-15 15:55:38'),
(8, 'HT05 · HOSPITALITY', 'Modern Round Marble Top Table with Gold Pedestal Base', 'modern-round-marble-top-table-with-gold-pedestal-base', 5, NULL, NULL, 'This modern round pedestal table is designed to combine elegance, stability, and space-efficient functionality. The table features a smooth, light-toned marble-effect round tabletop that creates a sophisticated visual appeal, complemented by a warm gold-finish metal base.\r\n\r\nThe distinctive tapered pedestal provides a strong and balanced foundation while maintaining a clean, uncluttered look. The central base also offers comfortable legroom compared with traditional multi-leg table designs.\r\n\r\nIdeal for dining areas, cafés, restaurants, hotels, lounges, offices, and contemporary homes, this table can serve as both a functional surface and a stylish statement piece.', 'The distinctive tapered pedestal provides a strong and balanced foundation while maintaining a clean, uncluttered look. The central base also offers comfortable legroom compared with traditional multi-leg table designs.', '', '', NULL, '', 0, 1, 1, 'active', 0, 0, '', '', '2026-10-15 15:57:29', '2026-10-15 15:57:29'),
(9, 'DT002', '6-Seater Dining Table', '6-seater-dining-table-1', 2, NULL, NULL, '', 'Solid wood dining table with 6 matching chairs. Perfect for family gatherings and entertaining.', '', '', NULL, '', 1, 1, 0, 'active', 0, 0, '', '', '2026-10-15 16:35:14', '2026-10-19 13:56:02'),
(11, 'OF001', 'Executive Office table', 'executive-office-table', 6, NULL, NULL, '', '', '', '', NULL, '', 1, 1, 0, 'active', 0, 0, '', '', '2026-10-19 12:32:04', '2026-10-19 12:32:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

CREATE TABLE `product_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `feature` varchar(300) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_features`
--

INSERT INTO `product_features` (`id`, `product_id`, `feature`, `sort_order`) VALUES
(1, 1, 'Premium fabric upholstery', 1),
(2, 1, 'Solid hardwood frame', 2),
(3, 1, 'High-density foam cushions', 3),
(4, 1, 'Available in custom colors', 4),
(5, 2, '3-seater configuration', 1),
(6, 2, 'Velvet fabric cover', 2),
(7, 2, 'Tapered solid wood legs', 3),
(8, 3, 'Upholstered headboard', 1),
(9, 3, 'Storage under-bed option', 2),
(10, 3, 'Solid wood slats', 3),
(11, 4, 'Lumbar support system', 1),
(12, 4, 'Height adjustable', 2),
(13, 4, '360° swivel', 3),
(14, 4, 'Premium PU leather', 4),
(15, 5, 'Seats 6 comfortably', 1),
(16, 5, 'Solid sheesham wood', 2),
(17, 5, 'Easy assembly', 3),
(18, 6, 'Modular design', 1),
(19, 6, 'Cable management tray', 2),
(20, 6, 'Adjustable storage', 3),
(88, 8, 'Modern Round Design – Clean and elegant circular tabletop.', 0),
(89, 8, 'Marble-Effect Tabletop – Premium light finish for a sophisticated appearance.', 1),
(90, 8, 'Gold-Finish Base – Adds warmth and luxury to the overall design.', 2),
(91, 8, 'Tapered Pedestal Base – Distinctive contemporary silhouette.', 3),
(92, 8, 'Stable Circular Foot – Designed for balanced support.', 4),
(93, 8, 'Space-Saving Structure – Central pedestal provides more usable legroom.', 5),
(94, 8, 'Minimalist Styling – Easily complements modern and contemporary interiors.', 6),
(95, 8, 'Versatile Application – Suitable for homes, cafés, restaurants, offices, lounges, and hotels.', 7),
(96, 8, 'Easy to Maintain – Smooth surfaces can be cleaned with a soft cloth.', 8),
(104, 7, 'Elegant bird and branch-inspired design', 0),
(105, 7, 'Rich natural wood-tone finish', 1),
(106, 7, 'Two integrated candle holders', 2),
(107, 7, 'Beautiful sculpted bird detail', 3),
(108, 7, 'Creates a warm and relaxing ambience', 4),
(109, 7, 'Vertical statement design', 5),
(110, 7, 'Combines decorative wall art with functional lighting', 6),
(115, 9, 'Seats 6 comfortably', 0),
(116, 9, 'Solid sheesham wood', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `alt_text` varchar(200) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `alt_text`, `is_primary`, `sort_order`, `created_at`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80', 'Luxury Sofa Set - Front View', 1, 1, '2026-09-21 10:10:21'),
(2, 1, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80', 'Luxury Sofa Set - Side View', 0, 2, '2026-09-21 10:10:21'),
(3, 2, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80', '3-Seater Comfort Sofa', 1, 1, '2026-09-21 10:10:21'),
(4, 3, 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80', 'King Size Bed Frame', 1, 1, '2026-09-21 10:10:21'),
(5, 4, 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80', 'Executive Office Chair', 1, 1, '2026-09-21 10:10:21'),
(6, 5, 'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=800&q=80', '6-Seater Dining Table', 1, 1, '2026-09-21 10:10:21'),
(7, 6, 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=800&q=80', 'Premium Workstation', 1, 1, '2026-09-21 10:10:21'),
(12, 8, 'uploads/products/9797f1204bb53432fe45f42418c26563.webp', NULL, 1, 1, '2026-10-19 12:29:59'),
(13, 11, 'uploads/products/a03154de384b676369ba5f663ce27074.webp', NULL, 1, 0, '2026-10-19 12:32:04'),
(14, 7, 'uploads/products/204032f170d98c4dcd6077a19604e220.jpg', NULL, 1, 0, '2026-10-19 13:54:04'),
(15, 9, 'uploads/products/0929adaad14a36398628c1151c009568.jpg', NULL, 1, 0, '2026-10-19 13:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `review` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_val` text DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_val`, `label`, `updated_at`) VALUES
(1, 'site_name', 'VISTAHOMZ', 'Site Name', '2026-10-19 11:26:13'),
(2, 'site_tagline', 'Premium Commercial Furniture', 'Site Tagline', '2026-09-21 10:10:21'),
(3, 'phone1', '+91 7982895924', 'Phone 1', '2026-09-21 10:10:21'),
(4, 'phone2', '+91 7982895924', 'Phone 2', '2026-09-21 10:10:21'),
(5, 'phone3', '+91 7982895924', 'Phone 3', '2026-09-21 10:10:21'),
(6, 'email', 'info@vistahomz.com', 'Email', '2026-09-21 10:10:21'),
(7, 'whatsapp', '917982895924', 'WhatsApp Number (with country code)', '2026-09-21 10:10:21'),
(8, 'address', ' Mahavir Enclave, New Delhi – 110045', 'Address', '2026-09-21 10:10:21'),
(9, 'instagram', '', 'Instagram URL', '2026-10-19 11:26:13'),
(10, 'facebook', '', 'Facebook URL', '2026-10-19 11:26:13'),
(11, 'youtube', '', 'YouTube URL', '2026-10-19 11:26:13'),
(12, 'meta_title', 'VISTAHOMZ— Premium Commercial Furniture & Workspace Solutions | New Delhi', 'Default Meta Title', '2026-10-19 11:26:13'),
(13, 'meta_desc', 'VISTAHOMZdelivers premium furniture solutions for offices, hotels, schools, hospitals, cafes & homes. 700+ products. Free delivery & installation across India.', 'Default Meta Description', '2026-10-19 11:26:13'),
(14, 'announcement_bar', 'Free Delivery & Professional Installation Across India', 'Announcement Bar Text', '2026-09-21 10:10:21'),
(15, 'business_hours', 'Mon–Sat, 10am–7pm', 'Business Hours', '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 1, 'Sofa', 'sofa', NULL, 1, 1, '2026-09-21 10:10:21'),
(2, 1, 'Luxury Sofa Set', 'luxury-sofa', NULL, 2, 1, '2026-09-21 10:10:21'),
(3, 1, 'Modern TV Unit', 'tv-unit', NULL, 3, 1, '2026-09-21 10:10:21'),
(4, 1, 'Designer Recliner', 'recliner', NULL, 4, 1, '2026-09-21 10:10:21'),
(5, 1, 'Lounge Chair', 'lounge-chair', NULL, 5, 1, '2026-09-21 10:10:21'),
(6, 1, 'Centre Table', 'center-table', NULL, 6, 1, '2026-09-21 10:10:21'),
(7, 2, 'Dining Table', 'dining-table', NULL, 1, 1, '2026-09-21 10:10:21'),
(8, 2, 'Dining Chair', 'dining-chair', NULL, 2, 1, '2026-09-21 10:10:21'),
(9, 2, 'Coffee Table', 'coffee-table', NULL, 3, 1, '2026-09-21 10:10:21'),
(10, 2, 'Bar Stool', 'bar-stool', NULL, 4, 1, '2026-09-21 10:10:21'),
(11, 2, 'Crockery Unit', 'crockery-unit', NULL, 5, 1, '2026-09-21 10:10:21'),
(12, 3, 'King Size Bed', 'bed', NULL, 1, 1, '2026-09-21 10:10:21'),
(13, 3, 'Queen Size Bed', 'queen-bed', NULL, 2, 1, '2026-09-21 10:10:21'),
(14, 3, 'Wardrobe', 'wardrobe', NULL, 3, 1, '2026-09-21 10:10:21'),
(15, 3, 'Side Table', 'side-table', NULL, 4, 1, '2026-09-21 10:10:21'),
(16, 3, 'Dressing Table', 'dressing-table', NULL, 5, 1, '2026-09-21 10:10:21'),
(17, 4, 'Executive Chair', 'executive-chair', NULL, 1, 1, '2026-09-21 10:10:21'),
(18, 4, 'Workstation', 'workstation', NULL, 2, 1, '2026-09-21 10:10:21'),
(19, 4, 'Meeting Table', 'meeting-table', NULL, 3, 1, '2026-09-21 10:10:21'),
(20, 4, 'Reception Desk', 'reception-desk', NULL, 4, 1, '2026-09-21 10:10:21'),
(21, 4, 'Storage Cabinet', 'storage-cabinet', NULL, 5, 1, '2026-09-21 10:10:21'),
(22, 5, 'Hotels & Hospitality', 'hotel', NULL, 1, 1, '2026-09-21 10:10:21'),
(23, 5, 'Offices & Startups', 'office-bulk', NULL, 2, 1, '2026-09-21 10:10:21'),
(24, 5, 'Cafes & Restaurants', 'cafe', NULL, 3, 1, '2026-09-21 10:10:21'),
(25, 5, 'Hospitals & Clinics', 'hospital', NULL, 4, 1, '2026-09-21 10:10:21'),
(26, 5, 'Schools & Institutes', 'school', NULL, 5, 1, '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `company` varchar(200) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `review` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `company`, `location`, `rating`, `review`, `image`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Rajesh Sharma', 'TechCorp India', 'Gurgaon', 5, 'vistahomz transformed our office space completely. The workstations are sturdy, elegant and our team loves them. Highly recommend for bulk office orders.', NULL, 1, 1, '2026-09-21 10:10:21'),
(2, 'Priya Mehta', 'Hotel Grand Palace', 'New Delhi', 5, 'We furnished 40 rooms and the lobby with vistahomz. The quality is outstanding and delivery was on time. Our guests frequently compliment the interiors.', NULL, 2, 1, '2026-09-21 10:10:21'),
(3, 'Amit Kapoor', 'Home Owner', 'Noida', 5, 'Ordered a complete bedroom set for our new flat. The quality exceeded our expectations and installation was professional and quick.', NULL, 3, 1, '2026-09-21 10:10:21'),
(4, 'Sunita Agarwal', 'Cafe Bloom', 'Faridabad', 5, 'Our cafe looks stunning with vistahomz furniture. The pieces are durable and the aesthetic is exactly what we wanted. Great value for money.', NULL, 4, 1, '2026-09-21 10:10:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_read` (`is_read`);

--
-- Indexes for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_read` (`is_read`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `idx_slug` (`slug`),
  ADD KEY `idx_code_scope` (`product_code`,`category_id`,`subcategory_id`),
  ADD KEY `idx_cat` (`category_id`),
  ADD KEY `idx_subcat` (`subcategory_id`),
  ADD KEY `idx_featured` (`is_featured`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_prod_col` (`collection_id`);

--
-- Indexes for table `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_cat` (`category_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_prod_cat` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prod_col` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prod_subcat` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_features`
--
ALTER TABLE `product_features`
  ADD CONSTRAINT `fk_pfeat_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_pimg_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `fk_subcat_cat` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
