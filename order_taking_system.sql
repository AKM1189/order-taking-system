-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 09:58 PM
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
-- Database: `order_taking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoryname` varchar(255) NOT NULL,
  `itemquantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryname`, `itemquantity`, `created_at`, `updated_at`) VALUES
(1, 'Beverage', -1, '2024-04-11 10:22:00', '2024-04-29 20:33:02'),
(2, 'Curry', 0, '2024-04-11 10:22:05', '2024-04-11 10:22:05'),
(3, 'Breakfast', 2, '2024-04-11 10:22:14', '2024-04-29 20:54:56'),
(4, 'Sweets', 0, '2024-04-11 10:22:35', '2024-04-11 10:22:35'),
(5, 'Noodle', 0, '2024-04-11 10:22:45', '2024-04-11 10:22:45'),
(6, 'Rice', 2, '2024-04-11 10:22:51', '2024-04-22 18:45:43'),
(7, 'Dessert', 0, '2024-04-21 19:27:55', '2024-04-21 19:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menuname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(10) NOT NULL,
  `cost` decimal(5,2) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `menu_type` varchar(255) NOT NULL,
  `menuimage` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menuname`, `description`, `quantity`, `cost`, `price`, `status`, `menu_type`, `menuimage`, `created_at`, `updated_at`, `category_id`) VALUES
(2, 'Dosa', 'Dosa', 11, 6.00, 8.00, 'Low stock', 'cook', 'Dosai_1712840180.png', '2024-04-11 13:55:58', '2024-04-29 20:43:35', 3),
(3, 'Poori', 'Poori', 4, 5.30, 7.00, 'Low stock', 'cook', 'poori_1712929286.jpg', '2024-04-12 14:41:26', '2024-04-26 09:50:38', 3),
(4, 'Chapati', 'Chapati', 4, 5.30, 7.00, 'Low stock', 'cook', 'chapati_1712929332.jpg', '2024-04-12 14:42:13', '2024-04-26 09:50:39', 3),
(5, 'Naan Roti', 'Naan Roti', 6, 5.40, 7.00, 'Low stock', 'cook', 'tandoori roti_1712929407.jpg', '2024-04-12 14:43:27', '2024-04-27 20:11:32', 3),
(6, 'Sprite', 'Sprite', 7, 0.00, 28.00, 'Low stock', 'purchase', 'sprite_1712929603.jpg', '2024-04-12 14:46:43', '2024-04-28 09:23:44', 1),
(7, 'Pepsi', 'Pepsi', 4, 0.00, 20.00, 'Low stock', 'purchase', 'pepsi_1712929624.jpg', '2024-04-12 14:47:04', '2024-04-27 11:26:59', 1),
(9, 'Chicken Fried Rice', 'Fried Rice with Chicken', 3, 7.80, 12.00, 'low stock', 'cook', 'menu.jpg', '2024-04-22 18:36:19', '2024-04-26 07:41:15', 6),
(10, 'Chicken Biryani', 'Biryani with Chicken', 0, 11.90, 15.00, 'stock out', 'cook', 'menu.jpg', '2024-04-22 18:45:43', '2024-04-22 18:45:43', 6),
(11, 'Idli', 'Idli', 0, 5.20, 8.00, 'stock out', 'cook', 'download_1714420381.jpg', '2024-04-29 20:53:03', '2024-04-29 20:55:38', 3),
(12, 'Vada', 'Vada', 0, 5.10, 8.00, 'stock out', 'cook', 'download (1)_1714420496.jpg', '2024-04-29 20:54:56', '2024-04-29 20:54:56', 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu_details`
--

CREATE TABLE `menu_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `quantity` decimal(5,1) NOT NULL,
  `subtotal` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_details`
--

INSERT INTO `menu_details` (`id`, `purchase_id`, `menu_id`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(2, 2, 6, 8.00, 25.0, 200.00, NULL, NULL),
(4, 2, 7, 8.00, 10.0, 80.00, NULL, NULL),
(5, 7, 6, 8.00, 10.0, 80.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_10_040420_create_roles_table', 1),
(6, '2024_02_15_042907_create_tables_table', 1),
(7, '2024_02_15_161447_create_category_table', 1),
(8, '2024_02_18_014817_create_menus_table', 1),
(9, '2024_02_20_150054_create_order_types_table', 1),
(10, '2024_03_02_073647_create_raw_materials_table', 1),
(11, '2024_03_02_150824_create_raw_material_details_table', 1),
(12, '2024_03_04_102233_create_suppliers_table', 1),
(13, '2024_03_04_114032_create_purchases_table', 1),
(14, '2024_03_07_083807_create_menu_details_table', 1),
(15, '2024_03_08_074900_create_purchase_details_table', 1),
(16, '2024_4_8_000000_create_users_table', 2),
(18, '2024_04_9_150608_create_order_table', 3),
(19, '2024_04_10_073449_create_order_details_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `orderdate` date NOT NULL,
  `ordertime` time NOT NULL,
  `subtotal` decimal(5,2) NOT NULL,
  `grandtotal` decimal(5,2) NOT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(5,2) NOT NULL DEFAULT 2.00,
  `ordernote` varchar(255) DEFAULT NULL,
  `orderstatus` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `paid_amount` decimal(8,2) DEFAULT NULL,
  `change` decimal(8,2) DEFAULT NULL,
  `order_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `table_id`, `staff_id`, `type_id`, `orderdate`, `ordertime`, `subtotal`, `grandtotal`, `discount`, `tax`, `ordernote`, `orderstatus`, `payment_type`, `paid_amount`, `change`, `order_token`, `created_at`, `updated_at`) VALUES
(8, 2, 1, 1, '2024-04-30', '02:27:26', 21.00, 21.42, 0.00, 2.00, NULL, 'Cooking', NULL, NULL, NULL, NULL, '2024-04-29 20:57:26', '2024-04-29 20:57:26'),
(9, 7, 1, 1, '2024-04-30', '02:27:40', 75.00, 76.50, 0.00, 2.00, NULL, 'Cooking', NULL, NULL, NULL, NULL, '2024-04-29 20:57:40', '2024-04-29 20:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orderid` bigint(20) UNSIGNED NOT NULL,
  `menuid` bigint(20) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `unit_quantity` int(11) NOT NULL,
  `subtotal` decimal(5,2) NOT NULL,
  `menu_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `orderid`, `menuid`, `note`, `unit_quantity`, `subtotal`, `menu_status`, `created_at`, `updated_at`) VALUES
(35, 8, 3, NULL, 2, 14.00, 'Cooking', NULL, NULL),
(36, 8, 4, NULL, 1, 7.00, 'Cooking', NULL, NULL),
(37, 9, 7, NULL, 2, 40.00, 'Cooking', NULL, NULL),
(38, 9, 5, NULL, 1, 7.00, 'Cooking', NULL, NULL),
(39, 9, 6, NULL, 1, 28.00, 'Cooking', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_types`
--

CREATE TABLE `order_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `typename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_types`
--

INSERT INTO `order_types` (`id`, `typename`, `created_at`, `updated_at`) VALUES
(1, 'Dining Order', '2024-04-11 10:14:45', '2024-04-11 10:14:45'),
(2, 'Pickup Order', '2024-04-27 06:42:17', '2024-04-27 06:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` date NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `purchase_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `paid_amount` decimal(5,2) DEFAULT NULL,
  `balance` decimal(5,2) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `purchase_date`, `invoice_no`, `purchase_type`, `description`, `total`, `paid_amount`, `balance`, `payment_type`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, '2024-04-24', 'Pur-001', 'Menu Purchase', 'Purchase Coca Cola', 100.00, 100.00, 0.00, 'Cash Payment', 1, '2024-04-11 14:24:33', '2024-04-24 18:08:45'),
(2, '2024-04-24', 'Pur-002', 'Menu Purchase', 'Purchase Beverage', 280.00, 200.00, 80.00, 'Cash Payment', 1, '2024-04-13 03:06:29', '2024-04-13 03:06:53'),
(3, '2024-04-24', 'Pur-003', 'Raw Material Purchase', 'Ingredient Purchase', 170.00, 170.00, 0.00, 'Cash Payment', 1, '2024-04-13 03:18:16', '2024-04-13 03:18:16'),
(4, '2024-04-24', 'Pur-005', 'Raw Material Purchase', 'Purchase Wheat and Sugar', 114.00, 114.00, 0.00, 'Cash Payment', 1, '2024-04-13 07:34:02', '2024-04-13 07:34:02'),
(5, '2024-04-24', 'Pur-006', 'Raw Material Purchase', 'Purchase Egg', 50.00, 50.00, 0.00, 'Cash Payment', 1, '2024-04-13 07:43:58', '2024-04-13 07:43:58'),
(6, '2024-04-24', 'Pur-007', 'Raw Material Purchase', 'Sugar', 20.00, 20.00, 0.00, 'Cash Payment', 3, '2024-04-22 10:50:43', '2024-04-22 10:50:43'),
(7, '2024-04-24', 'Pur-008', 'Menu Purchase', 'Sprite', 80.00, 80.00, 0.00, 'Cash Payment', 1, '2024-04-23 10:36:09', '2024-04-23 10:36:09'),
(8, '2024-04-24', 'Pur-009', 'Raw Material Purchase', 'Purchase Chicken and Oil', 200.00, 150.00, 50.00, 'Cash Payment', 3, '2024-04-24 06:18:30', '2024-04-24 06:18:30'),
(9, '2024-04-24', 'Pur-010', 'Raw Material Purchase', 'Purchase Egg', 150.00, 150.00, 0.00, 'Cash Payment', 1, '2024-04-24 17:47:13', '2024-04-24 17:47:13'),
(10, '2024-04-28', 'Pur-013', 'Raw Material Purchase', 'Oil', 80.00, 80.00, 0.00, 'Cash Payment', 1, '2024-04-27 21:38:20', '2024-04-27 21:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `quantity` decimal(5,1) NOT NULL,
  `subtotal` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `material_id`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 5.00, 20.0, 100.00, NULL, NULL),
(2, 3, 7, 7.00, 10.0, 70.00, NULL, NULL),
(3, 4, 8, 10.00, 10.0, 100.00, NULL, NULL),
(4, 4, 5, 7.00, 2.0, 14.00, NULL, NULL),
(5, 5, 4, 5.00, 10.0, 50.00, NULL, NULL),
(6, 6, 5, 4.00, 5.0, 20.00, NULL, NULL),
(7, 8, 1, 8.00, 10.0, 80.00, NULL, NULL),
(8, 8, 2, 12.00, 10.0, 120.00, NULL, NULL),
(9, 9, 4, 3.00, 50.0, 150.00, NULL, NULL),
(10, 10, 1, 8.00, 10.0, 80.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `quantity` decimal(5,1) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `itemname`, `price`, `quantity`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'Oil', 8.00, 29.0, 'Litre', '2024-04-11 10:27:55', '2024-04-27 21:38:20'),
(2, 'Chicken', 12.00, 8.5, 'kg', '2024-04-11 10:28:03', '2024-04-26 07:41:15'),
(3, 'Milk', 5.00, 0.0, 'litre', '2024-04-11 10:28:16', '2024-04-11 10:28:16'),
(4, 'Egg', 3.00, 50.0, 'piece', '2024-04-11 10:28:31', '2024-04-24 17:47:13'),
(5, 'Sugar', 4.00, 2.3, 'kg', '2024-04-11 10:28:45', '2024-04-26 07:37:21'),
(6, 'Bread', 6.00, 0.0, 'kg', '2024-04-11 13:50:40', '2024-04-11 13:50:40'),
(7, 'Rice', 7.00, 0.3, 'kg', '2024-04-11 13:52:34', '2024-04-26 07:41:15'),
(8, 'Wheat', 10.00, 2.1, 'kg', '2024-04-12 14:15:56', '2024-04-26 07:37:21'),
(9, 'Salt', 4.00, 0.0, 'kg', '2024-04-21 19:04:13', '2024-04-21 19:04:13'),
(10, 'Lentils', 5.00, 0.0, 'kg', '2024-04-29 20:44:54', '2024-04-29 20:44:54'),
(11, 'Coconut', 6.00, 0.0, 'piece', '2024-04-29 20:45:20', '2024-04-29 20:45:20'),
(12, 'Tamarind', 5.00, 0.0, 'kg', '2024-04-29 20:45:34', '2024-04-29 20:45:34'),
(13, 'Mustart seeds', 5.00, 0.0, 'kg', '2024-04-29 20:46:46', '2024-04-29 20:46:46'),
(14, 'Curry leaves', 3.00, 0.0, 'kg', '2024-04-29 20:47:05', '2024-04-29 20:47:05'),
(15, 'Turmeric', 7.00, 0.0, 'kg', '2024-04-29 20:47:21', '2024-04-29 20:47:21'),
(16, 'Cumin seeds', 6.00, 0.0, 'kg', '2024-04-29 20:47:36', '2024-04-29 20:47:36'),
(17, 'Coriander seeds', 6.00, 0.0, 'kg', '2024-04-29 20:47:51', '2024-04-29 20:47:51'),
(18, 'Black pepper', 7.00, 0.0, 'kg', '2024-04-29 20:48:04', '2024-04-29 20:48:04'),
(19, 'Red chilies', 7.00, 0.0, 'kg', '2024-04-29 20:48:19', '2024-04-29 20:48:19'),
(20, 'Green chilies', 7.00, 0.0, 'kg', '2024-04-29 20:48:31', '2024-04-29 20:48:31'),
(21, 'Ginger', 5.00, 0.0, 'kg', '2024-04-29 20:49:04', '2024-04-29 20:49:04'),
(22, 'Garlic', 7.00, 0.0, 'kg', '2024-04-29 20:49:18', '2024-04-29 20:49:18'),
(23, 'Onions', 7.00, 0.0, 'kg', '2024-04-29 20:49:32', '2024-04-29 20:49:32'),
(24, 'Tomatoes', 5.00, 0.0, 'kg', '2024-04-29 20:49:44', '2024-04-29 20:49:44'),
(25, 'Potatoes', 8.00, 0.0, 'kg', '2024-04-29 20:49:59', '2024-04-29 20:49:59'),
(26, 'Carrots', 5.00, 0.0, 'kg', '2024-04-29 20:50:14', '2024-04-29 20:50:14'),
(27, 'Green beans', 6.00, 0.0, 'kg', '2024-04-29 20:50:28', '2024-04-29 20:50:28'),
(28, 'Drumsticks', 5.00, 0.0, 'kg', '2024-04-29 20:50:45', '2024-04-29 20:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_details`
--

CREATE TABLE `raw_material_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menuid` bigint(20) UNSIGNED NOT NULL,
  `itemid` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(5,1) NOT NULL,
  `subtotal` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_material_details`
--

INSERT INTO `raw_material_details` (`id`, `menuid`, `itemid`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0.2, 1.00, NULL, NULL),
(2, 2, 7, 0.5, 5.00, NULL, NULL),
(3, 3, 1, 0.3, 1.50, NULL, NULL),
(4, 3, 5, 0.2, 1.40, NULL, NULL),
(5, 3, 8, 0.2, 2.40, NULL, NULL),
(6, 4, 1, 0.2, 1.00, NULL, NULL),
(7, 4, 8, 0.3, 3.60, NULL, NULL),
(8, 4, 5, 0.1, 0.70, NULL, NULL),
(9, 5, 8, 0.2, 2.40, NULL, NULL),
(10, 5, 4, 1.0, 3.00, NULL, NULL),
(14, 9, 2, 0.5, 5.00, NULL, NULL),
(15, 9, 7, 0.4, 2.80, NULL, NULL),
(16, 10, 2, 0.3, 3.00, NULL, NULL),
(17, 10, 1, 0.2, 1.00, NULL, NULL),
(18, 10, 4, 1.0, 5.00, NULL, NULL),
(19, 10, 7, 0.3, 2.10, NULL, NULL),
(20, 10, 9, 0.2, 0.80, NULL, NULL),
(21, 11, 10, 0.8, 4.00, NULL, NULL),
(22, 11, 9, 0.3, 1.20, NULL, NULL),
(23, 12, 10, 0.5, 2.50, NULL, NULL),
(24, 12, 18, 0.2, 1.40, NULL, NULL),
(25, 12, 16, 0.1, 0.60, NULL, NULL),
(26, 12, 14, 0.2, 0.60, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rolename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `rolename`, `created_at`, `updated_at`) VALUES
(1, 'Manager', NULL, NULL),
(2, 'Waiter', NULL, NULL),
(5, 'Kitchen Staff', '2024-04-18 17:36:10', '2024-04-18 17:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'AKM', '095346435658', 'akm@gmail.com', 'Tamwe', '2024-04-11 10:05:30', '2024-04-11 10:08:15'),
(2, 'Michael', '094356346434', 'michael@gmail.com', 'Myawaddy', '2024-04-11 10:07:21', '2024-04-11 10:07:21'),
(3, 'GKK', '097856454545', 'gkk512@gmail.com', 'Myawaddy', '2024-04-21 18:51:15', '2024-04-21 18:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tablenumber` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('Available','Occupied','Reserved') NOT NULL DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `tablenumber`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tb-1', 6, 'Available', '2024-04-11 09:57:06', '2024-04-29 20:56:29'),
(2, 'Tb-2', 6, 'Occupied', '2024-04-11 09:57:33', '2024-04-29 20:57:26'),
(3, 'Tb-3', 8, 'Available', '2024-04-11 09:57:40', '2024-04-29 20:56:40'),
(4, 'Tb-4', 4, 'Available', '2024-04-11 09:57:49', '2024-04-27 16:37:24'),
(5, 'Tb-5', 6, 'Available', '2024-04-26 05:32:35', '2024-04-27 16:37:31'),
(6, 'Tb-6', 4, 'Available', '2024-04-26 05:32:44', '2024-04-27 16:37:40'),
(7, 'Tb-7', 6, 'Occupied', '2024-04-26 05:32:55', '2024-04-29 20:57:40'),
(8, 'Tb-8', 6, 'Available', '2024-04-26 05:33:09', '2024-04-29 20:56:59'),
(9, 'Tb-9', 6, 'Available', '2024-04-26 05:33:24', '2024-04-26 05:33:24'),
(10, 'Tb-10', 6, 'Available', '2024-04-26 05:33:36', '2024-04-26 05:33:36'),
(11, 'Tb-11', 6, 'Available', '2024-04-26 18:07:23', '2024-04-26 18:07:23'),
(12, 'Tb-12', 6, 'Available', '2024-04-26 18:07:51', '2024-04-29 20:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Aung Kaung Myat', 'akm@gmail.com', NULL, '$2y$12$g0jCihlnek3FXbwYl9oECuXmzA.uxIBaMbAp17munBZ3IHvaYkHzS', '9QAluf3Bew8cS4abpKD3asStKecpJ7JQ31X2xqmORVyedyuUUrgoYbjhG1Vz', NULL, '2024-04-27 10:27:24', 1),
(2, 'Jack', 'jack@gmail.com', NULL, '$2y$12$7C4T4lpN8Bj/hA2rsa87Kufzzw5khC8qQJx.xR.hsgxI5ignsyW1C', NULL, '2024-04-11 09:48:21', '2024-04-11 09:48:21', 2),
(4, 'Aung Min Myat', 'amm@gmail.com', NULL, '$2y$12$livgPc9R/ctGjXuIGQ0IbOgI8/5nwYBTiSxo6Yfn/9GulGv/LZlX6', NULL, '2024-04-16 18:04:17', '2024-04-27 10:36:24', 5),
(6, 'Aung Kaung Myat', 'kk@gmail.com', NULL, '$2y$12$WZdMeZX9HWPWgoeosygOiu3y2IKaV4Ad9ZyjbqTnznbF2VFT0/OAS', NULL, '2024-04-19 18:34:48', '2024-04-19 18:34:48', 1),
(7, 'John', 'john@gmail.com', NULL, '$2y$12$ShGldNf3/W8fhuQVMAV25ux5ZjffOoLrPejM0ChBogRpJsfe3IEIG', NULL, '2024-04-19 19:02:53', '2024-04-19 19:02:53', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indexes for table `menu_details`
--
ALTER TABLE `menu_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `menu_details_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_table_id_foreign` (`table_id`),
  ADD KEY `order_staff_id_foreign` (`staff_id`),
  ADD KEY `order_type_id_foreign` (`type_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_orderid_foreign` (`orderid`),
  ADD KEY `order_details_menuid_foreign` (`menuid`);

--
-- Indexes for table `order_types`
--
ALTER TABLE `order_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_material_id_foreign` (`material_id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_material_details`
--
ALTER TABLE `raw_material_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_material_details_menuid_foreign` (`menuid`),
  ADD KEY `raw_material_details_itemid_foreign` (`itemid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `menu_details`
--
ALTER TABLE `menu_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `order_types`
--
ALTER TABLE `order_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `raw_material_details`
--
ALTER TABLE `raw_material_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `menu_details`
--
ALTER TABLE `menu_details`
  ADD CONSTRAINT `menu_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
  ADD CONSTRAINT `order_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `order_types` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_menuid_foreign` FOREIGN KEY (`menuid`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_orderid_foreign` FOREIGN KEY (`orderid`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_material_details`
--
ALTER TABLE `raw_material_details`
  ADD CONSTRAINT `raw_material_details_itemid_foreign` FOREIGN KEY (`itemid`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `raw_material_details_menuid_foreign` FOREIGN KEY (`menuid`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
