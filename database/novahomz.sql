-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2026 at 08:39 AM
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
-- Database: `novahomz`
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

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Vista Admin', 'admin@vistahomz.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 1, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21');

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

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `icon`, `sort_order`, `is_active`, `show_in_nav`, `meta_title`, `meta_desc`, `created_at`, `updated_at`) VALUES
(1, 'Living', 'living', 'Sofas, recliners, TV units and living room furniture', NULL, 'bi-house-heart', 1, 1, 1, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
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

INSERT INTO `homepage_banners` (`id`, `title`, `subtitle`, `label`, `image`, `btn1_text`, `btn1_url`, `btn2_text`, `btn2_url`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Premium Spaces Begin Here', 'End-to-end furniture solutions for homes, offices, hotels, schools & hospitality spaces — handcrafted with precision and delivered with care.', 'Commercial & Residential Furniture', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=1200&q=80', 'Explore Collections', 'category.php?cat=all', 'Get Free Quote', 'contact.php', 1, 1, '2026-09-21 10:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(10) NOT NULL DEFAULT '🏢',
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

INSERT INTO `products` (`id`, `product_code`, `name`, `slug`, `category_id`, `subcategory_id`, `collection_id`, `description`, `short_desc`, `material`, `dimensions`, `weight`, `colors`, `is_featured`, `is_new`, `is_bestseller`, `status`, `sort_order`, `views`, `meta_title`, `meta_desc`, `created_at`, `updated_at`) VALUES
(1, 'SF001', 'Luxury Sofa Set', 'luxury-sofa-set', 1, 2, NULL, 'Premium quality Luxury Sofa Set designed for modern homes with comfort and elegance. Upholstered in high-grade fabric with solid wood frame.', 'Premium fabric sofa set for modern living', 'High-grade fabric, Solid hardwood', NULL, NULL, NULL, 1, 1, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(2, 'SF002', '3-Seater Comfort Sofa', '3-seater-comfort-sofa', 1, 1, NULL, 'Contemporary sofa featuring clean lines and premium materials. Perfect for any modern living space.', 'Contemporary sofa for modern living', 'Premium velvet, Solid wood legs', NULL, NULL, NULL, 1, 0, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(3, 'BD001', 'King Size Bed Frame', 'king-size-bed-frame', 3, 12, NULL, 'Luxurious king-size bed with upholstered headboard and solid wood base. Brings elegance to any master bedroom.', 'King size bed with upholstered headboard', 'Engineered wood, Premium fabric', NULL, NULL, NULL, 1, 1, 0, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(4, 'OF001', 'Executive Office Chair', 'executive-office-chair', 4, 17, NULL, 'Ergonomic executive chair with lumbar support, adjustable height and premium PU leather upholstery.', 'Ergonomic executive chair with lumbar support', 'PU leather, Chrome base', NULL, NULL, NULL, 1, 0, 1, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(5, 'DT001', '6-Seater Dining Table', '6-seater-dining-table', 2, 7, NULL, 'Solid wood dining table with 6 matching chairs. Perfect for family gatherings and entertaining.', 'Solid wood dining table with chairs', 'Sheesham wood, Lacquer finish', NULL, NULL, NULL, 1, 1, 0, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21'),
(6, 'WS001', 'Premium Workstation', 'premium-workstation', 4, 18, NULL, 'Modern office workstation designed for productivity. Cable management and modular design.', 'Modern modular office workstation', 'Steel frame, MDF top', NULL, NULL, NULL, 0, 1, 0, 'active', 0, 0, NULL, NULL, '2026-09-21 10:10:21', '2026-09-21 10:10:21');

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

INSERT INTO `settings` (`id`, `setting_key`, `setting_val`, `label`, `updated_at`) VALUES
(1, 'site_name', 'VISTAHOMZ', 'Site Name', '2026-10-15 10:10:21'),
(2, 'site_tagline', 'Luxury Furniture & Architectural Living', 'Site Tagline', '2026-10-15 10:10:21'),
(3, 'phone1', '+91 70427 04454', 'Phone 1', '2026-09-21 10:10:21'),
(4, 'phone2', '+91 74999 49187', 'Phone 2', '2026-09-21 10:10:21'),
(5, 'phone3', '+91 93541 09802', 'Phone 3', '2026-09-21 10:10:21'),
(6, 'email', 'info@novahomz.com', 'Email', '2026-09-21 10:10:21'),
(7, 'whatsapp', '917042704454', 'WhatsApp Number', '2026-09-21 10:10:21'),
(8, 'address', 'Rz-D1/325A, Mahavir Enclave, New Delhi – 110045', 'Address', '2026-09-21 10:10:21'),
(9, 'announcement_bar', 'Free Delivery & Professional Installation Across India', 'Announcement Bar Text', '2026-09-21 10:10:21'),
(10, 'business_hours', 'Mon–Sat, 10am–7pm', 'Business Hours', '2026-09-21 10:10:21');

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

INSERT INTO `testimonials` (`id`, `name`, `company`, `location`, `rating`, `review`, `image`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Rajesh Sharma', 'TechCorp India', 'Gurgaon', 5, 'VISTAHOMZ transformed our office space completely. The workstations are sturdy, elegant and our team loves them. Highly recommend for bulk office orders.', NULL, 1, 1, '2026-09-21 10:10:21'),
(2, 'Priya Mehta', 'Hotel Grand Palace', 'New Delhi', 5, 'We furnished 40 rooms and the lobby with VISTAHOMZ. The quality is outstanding and delivery was on time. Our guests frequently compliment the interiors.', NULL, 2, 1, '2026-09-21 10:10:21'),
(3, 'Amit Kapoor', 'Home Owner', 'Noida', 5, 'Ordered a complete bedroom set for our new flat. The quality exceeded our expectations and installation was professional and quick.', NULL, 3, 1, '2026-09-21 10:10:21'),
(4, 'Sunita Agarwal', 'Cafe Bloom', 'Faridabad', 5, 'Our cafe looks stunning with VISTAHOMZ furniture. The pieces are durable and the aesthetic is exactly what we wanted. Great value for money.', NULL, 4, 1, '2026-09-21 10:10:21');

COMMIT;
