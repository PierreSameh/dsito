-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 06:37 PM
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
-- Database: `dsito`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_notifications`
--

CREATE TABLE `app_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `delivery` tinyint(1) NOT NULL DEFAULT 0,
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `delivery_rate` double NOT NULL DEFAULT 0,
  `customer_rate` double NOT NULL DEFAULT 0,
  `fcm_token` varchar(255) DEFAULT NULL,
  `delivery_status` enum('undefined','waiting','approved','hold','block') NOT NULL DEFAULT 'undefined',
  `picture` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `id_front` varchar(255) DEFAULT NULL,
  `id_back` varchar(255) DEFAULT NULL,
  `selfie` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `last_otp` varchar(255) DEFAULT NULL,
  `last_otp_expire` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `username`, `phone`, `full_name`, `email`, `delivery`, `lng`, `lat`, `delivery_rate`, `customer_rate`, `fcm_token`, `delivery_status`, `picture`, `national_id`, `id_front`, `id_back`, `selfie`, `password`, `pin`, `verified`, `last_otp`, `last_otp_expire`, `created_at`, `updated_at`) VALUES
(1, 'Peter', 'Helmy', 'pierre.sameh', '01273450570', 'Pierre Sameh Helmy Gad', 'pierresameh144@gmail.com', 1, '-122.4194', '37.7749', 0, 5, 'fzv7iJFyRI-2QmAPfQ4Bht:APA91bHBv_WRHowo3HDWX3i4elGh-i863E82iHYCLq1Yye1WzBFTyagAzH7NolDtp3WNUYI42hk1EVAlNHCChIO2X17O_cCth-LCocPA2IMPT2okN7GcC6o', 'approved', 'storage/profile/Bm9nizi6UqOMtckGu02lncKOnzod9fWfOFaLNTyK.jpg', '12345678985412', 'storage/docs/xOlwfAKvTklEblS3a2UMeiGJSRuoi0RSJb9oka7U.jpg', 'storage/docs/qKWc7XD80FmHIWDDWzCxcCrvHtgb2yNOWINgiseJ.jpg', 'storage/docs/Suqc7BcEjg6IVx5WnA6sYNr5g6rlkXtQ9MDu1yHP.jpg', '$2y$12$hJ/REXZsRK0lR5Fe37cRnOBaU8vbEjrOT/yxRNgcpykaIGLpOKnXy', '0', 0, '$2y$12$IWtlbhGW0kmw4/Tp6Uz11efpAiIfcI33NcDL7CcbqvcgNdgvF9ASy', '2024-11-17 00:19:40', '2024-11-16 20:09:39', '2024-11-19 13:45:27'),
(2, 'Pierre', 'Louka', 'pierre.sameh1', '01224442343', 'Pierre Sameh Helmy Gad', 'pierresameh144@gmail.com', 1, '-122.4194', '37.7929', 4, 0, 'fzv7iJFyRI-2QmAPfQ4Bht:APA91bHBv_WRHowo3HDWX3i4elGh-i863E82iHYCLq1Yye1WzBFTyagAzH7NolDtp3WNUYI42hk1EVAlNHCChIO2X17O_cCth-LCocPA2IMPT2okN7GcC6o', 'approved', 'storage/profile/TtCzV0sCuf81XFLq1USl1dPusxYgF8yGXGKQEeOy.jpg', '12345678945621', 'storage/docs/KruYg8lCkB0hgd056jqHOu3GJiyzGSJNcVa2W9RI.jpg', 'storage/docs/Ov2hE9cHLBjwGtdkWIu42jF0TADOtqnidvGZJEM0.jpg', 'storage/docs/8zIAMEIB7odTX1pYxEoJQxPqqtghjqKK0hkI82y1.jpg', '$2y$12$90hJZfYu7T/ukhK2Dgh4qOkprVcXN6A9VOdxBjd0TiTAtzfwhYJkK', '$2y$12$wSk2rglwumTcxXGCrCwXXeLpmZiKnPyF1cTgE0SPzJ0FPiYpGtktm', 0, '$2y$12$KJN7tcysrzlZ.icvaW9LBeiA5CiYh7.cSMdhY5YiZFvn842lpY40m', '2024-11-24 16:00:00', '2024-11-16 20:26:53', '2024-11-24 11:50:00');

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
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `customer_id`, `name`, `address`, `lng`, `lat`, `created_at`, `updated_at`) VALUES
(1, 1, 'البيت', 'المهندسين', '-122.4194', '37.7749', '2024-11-17 09:10:55', '2024-11-17 09:10:55'),
(2, 1, 'الشغل', 'العجوزة', '-122.4194', '37.7929', '2024-11-17 09:11:36', '2024-11-17 09:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('customer','delivery') NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `order_id`, `sender_type`, `sender_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 10, 'customer', 1, 'hi', '2024-11-24 13:15:26', '2024-11-24 13:15:26'),
(2, 10, 'customer', 1, 'كيفك', '2024-11-24 13:15:56', '2024-11-24 13:15:56'),
(3, 10, 'delivery', 2, 'good', '2024-11-24 14:27:55', '2024-11-24 14:27:55');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_18_113815_create_personal_access_tokens_table', 1),
(5, '2024_10_25_213431_create_customers_table', 1),
(6, '2024_10_25_215254_edit_last_otp_expire_on_customers_table', 1),
(7, '2024_11_03_210044_create_place_orders_table', 1),
(8, '2024_11_06_201452_create_favorites_table', 1),
(9, '2024_11_06_215118_create_wallets_table', 1),
(10, '2024_11_09_162137_create_orders_table', 1),
(11, '2024_11_09_164746_add_lng_and_lat_to_customers_table', 1),
(12, '2024_11_09_181331_create_order_negotiations_table', 1),
(13, '2024_11_09_185239_add_customer_and_delivery_id_to_order_negotiations_table', 1),
(14, '2024_11_14_141434_create_order_cancels_table', 1),
(15, '2024_11_15_201130_add_columns_to_customers_table', 1),
(16, '2024_11_15_203112_edit_rating_on_orders_table', 1),
(17, '2024_11_17_000252_add_picture_to_customers_table', 2),
(18, '2024_11_17_124057_create_wallet_recharges_table', 3),
(19, '2024_11_17_135030_create_transactions_table', 4),
(20, '2024_11_18_130032_create_misc_pages_table', 5),
(21, '2024_11_19_131844_add_delivery_status_to_customers_table', 6),
(22, '2024_11_19_194446_add_pin_to_customers_table', 7),
(23, '2024_11_19_203701_create_settings_table', 8),
(24, '2024_11_22_173552_create_app_notifications_table', 9),
(25, '2024_11_23_084136_create_popular_places_table', 10),
(26, '2024_11_23_111028_add_cost_per_km_to_settings_table', 11),
(27, '2024_11_24_144229_create_messages_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `misc_pages`
--

CREATE TABLE `misc_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `about` mediumtext DEFAULT NULL,
  `privacy_terms` mediumtext DEFAULT NULL,
  `faq` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`faq`)),
  `contact_us` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `misc_pages`
--

INSERT INTO `misc_pages` (`id`, `about`, `privacy_terms`, `faq`, `contact_us`, `created_at`, `updated_at`) VALUES
(2, 'about page', 'privacy and terms', '{\"question\":\"answer\"}', 'put your number or a link', '2024-11-19 11:01:16', '2024-11-19 11:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_order_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `rate_delivery` double DEFAULT NULL,
  `rate_customer` double DEFAULT NULL,
  `status` enum('waiting','first_point','received','sec_point','completed','cancelled_user','cancelled_delivery') NOT NULL DEFAULT 'waiting',
  `delivery_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `place_order_id`, `delivery_id`, `price`, `rate_delivery`, `rate_customer`, `status`, `delivery_time`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 28.00, 4, 5, 'completed', '2024-11-16 22:54:19', '2024-11-16 20:35:28', '2024-11-16 21:26:40'),
(2, 2, 2, 30.00, NULL, NULL, 'cancelled_delivery', NULL, '2024-11-17 09:48:13', '2024-11-17 09:49:15'),
(3, 3, 2, 30.00, NULL, NULL, 'completed', '2024-11-17 12:14:58', '2024-11-17 10:14:45', '2024-11-17 10:14:58'),
(4, 4, 2, 30.00, NULL, NULL, 'completed', '2024-11-17 17:28:20', '2024-11-17 15:26:16', '2024-11-17 15:28:20'),
(5, 5, 2, 15.00, NULL, NULL, 'completed', '2024-11-17 18:35:20', '2024-11-17 16:34:45', '2024-11-17 16:35:20'),
(6, 6, 2, 10.00, NULL, NULL, 'cancelled_delivery', NULL, '2024-11-17 16:41:51', '2024-11-17 16:42:48'),
(7, 7, 2, 10.00, NULL, NULL, 'cancelled_user', NULL, '2024-11-17 19:34:41', '2024-11-17 19:36:42'),
(8, 8, 2, 10.00, NULL, NULL, 'completed', '2024-11-22 18:39:38', '2024-11-19 13:47:07', '2024-11-22 16:39:38'),
(9, 10, 1, 10.00, NULL, NULL, 'completed', '2024-11-19 20:48:42', '2024-11-19 18:48:22', '2024-11-19 18:48:42'),
(10, 12, 2, 10.00, NULL, NULL, 'completed', '2024-11-24 16:29:46', '2024-11-24 13:14:26', '2024-11-24 14:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancels`
--

CREATE TABLE `order_cancels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_cancels`
--

INSERT INTO `order_cancels` (`id`, `order_id`, `delivery_id`, `customer_id`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, 'reason', 'accepted', '2024-11-17 09:48:40', '2024-11-17 09:49:15'),
(2, 6, 2, NULL, 'reason', 'accepted', '2024-11-17 16:42:19', '2024-11-17 16:42:48'),
(3, 7, NULL, 1, 'لا احتاج الشحنة بعد الان', 'accepted', '2024-11-17 19:35:15', '2024-11-17 19:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_negotiations`
--

CREATE TABLE `order_negotiations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proposed_price` decimal(8,2) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_negotiations`
--

INSERT INTO `order_negotiations` (`id`, `place_order_id`, `customer_id`, `delivery_id`, `proposed_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 30.00, 'pending', '2024-11-16 20:29:16', '2024-11-16 20:29:16'),
(2, 1, 1, 2, 28.00, 'accepted', '2024-11-16 20:33:06', '2024-11-16 20:35:28'),
(3, 5, NULL, 2, 15.00, 'accepted', '2024-11-17 16:34:12', '2024-11-17 16:34:45'),
(19, 7, NULL, 1, 35.00, 'pending', '2024-11-23 10:48:35', '2024-11-23 10:48:35');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Customer', 1, 'token', 'e281082af5eda9453b919a1d079ac111e564d7688d9155b402b9dd16f166b136', '[\"*\"]', '2024-11-16 22:48:59', NULL, '2024-11-16 20:09:43', '2024-11-16 22:48:59'),
(2, 'App\\Models\\Customer', 2, 'token', '578a530f2eec910b0525f1f11498030503b689956ec5931d0671c2f7c4d820e4', '[\"*\"]', '2024-11-16 21:37:15', NULL, '2024-11-16 20:26:56', '2024-11-16 21:37:15'),
(3, 'App\\Models\\Customer', 2, 'token', '13d7bc882e0909a5e512e8f12e2cad1154b8f037daa4935c0fa8e247c9779384', '[\"*\"]', '2024-11-17 09:07:22', NULL, '2024-11-16 22:51:10', '2024-11-17 09:07:22'),
(4, 'App\\Models\\Customer', 1, 'token', 'ed3cdd8490e294ffad7b6b07a8bb6c49f79e0891d1cf924ada1398343075cabd', '[\"*\"]', '2024-11-22 17:05:51', NULL, '2024-11-17 09:09:17', '2024-11-22 17:05:51'),
(5, 'App\\Models\\Customer', 2, 'token', '2a84c3cc0dafbadb14b769a7ac28a51c495d70f4ccca389b9b1cca88c7b13ad5', '[\"*\"]', '2024-11-24 11:52:28', NULL, '2024-11-17 09:47:35', '2024-11-24 11:52:28'),
(6, 'App\\Models\\Customer', 2, 'token', '9d8162f02173503445ddd2b704a6d41f9b884d0e70dbd2740eb66e29bac39040', '[\"*\"]', '2024-11-23 09:42:37', NULL, '2024-11-22 16:28:47', '2024-11-23 09:42:37'),
(7, 'App\\Models\\Customer', 1, 'token', 'dc0bad821e898b70f776b3698d284d8015711dc64893eb2fdcec30ea12b77510', '[\"*\"]', '2024-11-23 10:48:35', NULL, '2024-11-23 09:48:55', '2024-11-23 10:48:35'),
(8, 'App\\Models\\Customer', 1, 'token', '5f00fc16f3341a6d5b0e69f0a6acd6a001af924992578bccf96c63dd79070f41', '[\"*\"]', '2024-11-24 13:16:51', NULL, '2024-11-24 13:12:35', '2024-11-24 13:16:51'),
(9, 'App\\Models\\Customer', 2, 'token', '616c184c2ab853f22a146021341ba0d4757466a8e78bf6a6dda0c3c4ebee5e02', '[\"*\"]', '2024-11-24 14:32:36', NULL, '2024-11-24 13:13:47', '2024-11-24 14:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `place_orders`
--

CREATE TABLE `place_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `address_from` varchar(255) NOT NULL,
  `lng_from` varchar(255) NOT NULL,
  `lat_from` varchar(255) NOT NULL,
  `address_to` varchar(255) NOT NULL,
  `lng_to` varchar(255) NOT NULL,
  `lat_to` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `details` text NOT NULL,
  `payment_method` enum('cash','wallet') NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place_orders`
--

INSERT INTO `place_orders` (`id`, `customer_id`, `address_from`, `lng_from`, `lat_from`, `address_to`, `lng_to`, `lat_to`, `price`, `details`, `payment_method`, `paid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 25.00, 'وصل لي عيش', 'cash', 0, 'accepted', '2024-11-16 20:25:45', '2024-11-16 20:35:28'),
(2, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 30.00, 'نسيت الشنطة في البيت', 'cash', 0, 'accepted', '2024-11-17 09:12:52', '2024-11-17 09:48:13'),
(3, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 30.00, 'نسيت الشنطة في البيت', 'cash', 0, 'accepted', '2024-11-17 10:14:23', '2024-11-17 10:14:45'),
(4, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 30.00, 'نسيت الشنطة في البيت', 'wallet', 1, 'accepted', '2024-11-17 15:22:50', '2024-11-17 15:26:16'),
(5, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'wallet', 0, 'accepted', '2024-11-17 16:33:32', '2024-11-17 16:34:45'),
(6, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'wallet', 1, 'accepted', '2024-11-17 16:41:30', '2024-11-17 16:41:51'),
(7, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'wallet', 1, 'accepted', '2024-11-17 19:34:01', '2024-11-17 19:34:41'),
(8, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'wallet', 1, 'accepted', '2024-11-19 13:44:30', '2024-11-19 13:47:07'),
(9, 2, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'cash', 0, 'cancelled', '2024-11-19 18:24:08', '2024-11-19 18:24:42'),
(10, 2, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'wallet', 1, 'accepted', '2024-11-19 18:25:15', '2024-11-19 18:48:22'),
(11, 2, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'cash', 0, 'pending', '2024-11-23 09:48:12', '2024-11-23 09:48:12'),
(12, 1, 'المهندسين', '-122.4194', '37.7749', 'العجوزة', '-122.4194', '37.7929', 10.00, 'نسيت الشنطة في البيت', 'cash', 0, 'accepted', '2024-11-24 13:13:29', '2024-11-24 13:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `popular_places`
--

CREATE TABLE `popular_places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `address` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popular_places`
--

INSERT INTO `popular_places` (`id`, `title`, `description`, `images`, `address`, `lng`, `lat`, `created_at`, `updated_at`) VALUES
(1, 'first', 'some description', NULL, 'فيصل الهرم', '-122.4194', '37.7746', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('25FhCWpym10nEkjsczeizF5kcWIlCipha4FDi2kc', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic21zcVFuVllQdlh2T2lSNFc5RVQ0RXVSR0o1ZEJGa09XRlRtY0xNUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1731868437),
('73P036Qbr0pxISiseddRnNRr2rLcLfgmj9kaLApL', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGxBRGNJTVQyNXZObHVaZHVJMHFXdzJDRWhMTVJrVFJCS0I4bVduMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1731705405),
('ISP7Y6XpqlBALWKVGvobjP0TBUkiy3M6AQqcDcrh', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1dxbzBZS0QyMTd6OGZpeUZHcE91OG9qQVhNYTlrdDdHenIwREY3OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1731804914),
('upTGX8PeV52tujkg0TwP3NmbpAUSR2OPDj8v4EXG', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnBiVm1PS1FjbnlxV1pvc1lScm5NMUtvSTRjN1ZsNkFwV3JuaXA1YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1731879391),
('XHcUvsNSEDwFnTsillU5FQcSVNZgu048imhrP6Tr', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibllDMXhmNXJsbEVSZTFHWXpmWVVkNEh6T0J0NjlPN1ozRklDN2d4VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1732031143),
('Y8CiSWMfucG74ETAyc5ptrimCrQdi8Btlod8Z8pm', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnloMGMxdmxQTUNzUGJYbkVmZHk5V2N5d2tZTlB0c2lQMUdLdjNxVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91bmF1dGhvcml6ZWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1731848249);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_coverage` int(11) NOT NULL,
  `company_share` int(11) NOT NULL,
  `cost_per_km` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `delivery_coverage`, `company_share`, `cost_per_km`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 0.00, '2024-11-19 18:42:40', '2024-11-19 18:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender` bigint(20) UNSIGNED NOT NULL,
  `receiver` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `type` enum('pay','transfer') NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `sender`, `receiver`, `amount`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 50, 'transfer', 'completed', '2024-11-17 12:15:48', '2024-11-17 12:15:48'),
(2, 2, 1, 10, 'transfer', 'completed', '2024-11-17 12:16:40', '2024-11-17 12:16:40'),
(3, 1, 2, 30, 'pay', 'completed', '2024-11-17 15:26:16', '2024-11-17 15:28:20'),
(4, 1, 2, 15, 'pay', 'completed', '2024-11-17 16:34:45', '2024-11-17 16:35:20'),
(5, 1, 2, 10, 'pay', 'failed', '2024-11-17 16:41:51', '2024-11-17 16:42:48'),
(6, 1, 2, 10, 'pay', 'failed', '2024-11-17 19:34:41', '2024-11-17 19:36:42'),
(7, 1, 2, 10, 'pay', 'completed', '2024-11-19 13:47:07', '2024-11-22 16:32:28'),
(8, 2, 1, 10, 'transfer', 'completed', '2024-11-19 18:35:11', '2024-11-19 18:35:11'),
(9, 2, 1, 10, 'pay', 'completed', '2024-11-19 18:48:22', '2024-11-19 18:48:42');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `customer_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, 24.00, '2024-11-16 20:09:39', '2024-11-19 18:48:42'),
(2, 2, 81.00, '2024-11-16 20:26:53', '2024-11-24 14:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_recharges`
--

CREATE TABLE `wallet_recharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_recharges`
--

INSERT INTO `wallet_recharges` (`id`, `wallet_id`, `photo`, `phone_number`, `status`, `reject_reason`, `created_at`, `updated_at`) VALUES
(1, 2, 'storage/recharges/YgnpX7TfHtN8rgjVykTiGXReuSwCsIP9VrouZO0h.jpg', '01024442343', 'pending', NULL, '2024-11-17 10:58:41', '2024-11-17 10:58:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_notifications`
--
ALTER TABLE `app_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_notifications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_username_unique` (`username`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_order_id_foreign` (`order_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `misc_pages`
--
ALTER TABLE `misc_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_place_order_id_foreign` (`place_order_id`),
  ADD KEY `orders_delivery_id_foreign` (`delivery_id`);

--
-- Indexes for table `order_cancels`
--
ALTER TABLE `order_cancels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_cancels_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_negotiations`
--
ALTER TABLE `order_negotiations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_negotiations_place_order_id_foreign` (`place_order_id`);

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
-- Indexes for table `place_orders`
--
ALTER TABLE `place_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popular_places`
--
ALTER TABLE `popular_places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_recharges_wallet_id_foreign` (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_notifications`
--
ALTER TABLE `app_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `misc_pages`
--
ALTER TABLE `misc_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_cancels`
--
ALTER TABLE `order_cancels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_negotiations`
--
ALTER TABLE `order_negotiations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `place_orders`
--
ALTER TABLE `place_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `popular_places`
--
ALTER TABLE `popular_places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_notifications`
--
ALTER TABLE `app_notifications`
  ADD CONSTRAINT `app_notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_place_order_id_foreign` FOREIGN KEY (`place_order_id`) REFERENCES `place_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_cancels`
--
ALTER TABLE `order_cancels`
  ADD CONSTRAINT `order_cancels_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_negotiations`
--
ALTER TABLE `order_negotiations`
  ADD CONSTRAINT `order_negotiations_place_order_id_foreign` FOREIGN KEY (`place_order_id`) REFERENCES `place_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  ADD CONSTRAINT `wallet_recharges_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
