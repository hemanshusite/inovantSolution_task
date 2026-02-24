-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 24, 2026 at 03:42 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_head` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `phone_code`, `phone`, `email`, `password`, `is_head`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '91', '1234567890', 'admin@admin.com', '27728826631953ea8218f3bf8cafe1f3', 1, 1, 1, 1, '2026-02-24 01:46:58', '2026-02-24 01:46:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `subtotal` decimal(8,2) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `total_discount` decimal(8,2) DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `subtotal`, `discount`, `total_discount`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 180000.00, 2500.00, 5000.00, 175000.00, '2026-02-24 10:08:53', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(2, 1, 2, 1, 1200.00, 50.00, 50.00, 1150.00, '2026-02-24 10:09:04', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(3, 1, 4, 2, 700.00, 12.00, 24.00, 676.00, '2026-02-24 10:09:10', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(4, 1, 5, 1, 1050.00, 25.00, 25.00, 1025.00, '2026-02-24 10:09:18', '2026-02-24 10:10:14', '2026-02-24 10:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_22_171119_create_products_table', 1),
(5, '2026_02_22_171137_create_carts_table', 1),
(7, '2026_02_23_051205_create_admins_table', 1),
(8, '2026_02_23_051707_migration_to_run_default_admin_seeder', 1),
(9, '2026_02_22_171152_create_orders_table', 2),
(10, '2026_02_24_111502_create_order_details_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `order_unique_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `subtotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_items` int NOT NULL DEFAULT '0',
  `order_status` enum('pending','processing','completed','cancelled','refunded','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_unique_id`, `order_number`, `user_id`, `subtotal`, `discount`, `total_discount`, `total_amount`, `total_items`, `order_status`, `payment_status`, `payment_method`, `notes`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ORD-699DC65E9DD11-1771947614', 'ORD202602240001', 1, 182950.00, 2587.00, 5099.00, 177851.00, 6, 'completed', 'paid', NULL, NULL, 1, 1, '2026-02-24 10:10:14', '2026-02-24 10:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `cart_id` int UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci,
  `product_sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_discount_price` decimal(8,2) DEFAULT NULL,
  `product_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(8,2) NOT NULL,
  `product_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `cart_id`, `product_name`, `product_description`, `product_sku`, `product_price`, `product_discount_price`, `product_image_url`, `quantity`, `subtotal`, `discount`, `total_discount`, `total_price`, `product_details`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Iphone 15', 'iphone 15, 256 GB Storage', NULL, 90000.00, 2500.00, '[\"product\\/1\\/1771929955_699d816330b14.jpg\",\"product\\/1\\/1771929957_699d816503e5d.jpg\"]', 2, 180000.00, 2500.00, 5000.00, 175000.00, '{\"id\": 1, \"name\": \"Iphone 15\", \"price\": \"90000.00\", \"status\": \"1\", \"image_url\": \"[\\\"product\\\\/1\\\\/1771929955_699d816330b14.jpg\\\",\\\"product\\\\/1\\\\/1771929957_699d816503e5d.jpg\\\"]\", \"description\": \"iphone 15, 256 GB Storage\", \"total_price\": \"87500.00\", \"discount_price\": \"2500.00\"}', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(2, 1, 2, 2, 'Shoe', 'Shoe, leather cloth', NULL, 1200.00, 50.00, '[\"product\\/2\\/1771930234_699d827a8ea27.jpg\"]', 1, 1200.00, 50.00, 50.00, 1150.00, '{\"id\": 2, \"name\": \"Shoe\", \"price\": \"1200.00\", \"status\": \"1\", \"image_url\": \"[\\\"product\\\\/2\\\\/1771930234_699d827a8ea27.jpg\\\"]\", \"description\": \"Shoe, leather cloth\", \"total_price\": \"1150.00\", \"discount_price\": \"50.00\"}', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(3, 1, 4, 3, 'Slipper', 'comfortable slipper', NULL, 350.00, 12.00, '[\"product\\/4\\/1771930538_699d83aab965c.webp\"]', 2, 700.00, 12.00, 24.00, 676.00, '{\"id\": 4, \"name\": \"Slipper\", \"price\": \"350.00\", \"status\": \"1\", \"image_url\": \"[\\\"product\\\\/4\\\\/1771930538_699d83aab965c.webp\\\"]\", \"description\": \"comfortable slipper\", \"total_price\": \"338.00\", \"discount_price\": \"12.00\"}', '2026-02-24 10:10:14', '2026-02-24 10:10:14'),
(4, 1, 5, 4, 'Water Bottle', 'Water bottle for 500mL', NULL, 1050.00, 25.00, '[\"product\\/5\\/1771947217_699dc4d1acad1.webp\",\"product\\/5\\/1771947220_699dc4d4bde33.jpg\"]', 1, 1050.00, 25.00, 25.00, 1025.00, '{\"id\": 5, \"name\": \"Water Bottle\", \"price\": \"1050.00\", \"status\": \"1\", \"image_url\": \"[\\\"product\\\\/5\\\\/1771947217_699dc4d1acad1.webp\\\",\\\"product\\\\/5\\\\/1771947220_699dc4d4bde33.jpg\\\"]\", \"description\": \"Water bottle for 500mL\", \"total_price\": \"1025.00\", \"discount_price\": \"25.00\"}', '2026-02-24 10:10:14', '2026-02-24 10:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount_price`, `total_price`, `image_url`, `stock_quantity`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Iphone 15', 'iphone 15, 256 GB Storage', 90000.00, 2500.00, 87500.00, '\"[\\\"product\\\\\\/1\\\\\\/1771929955_699d816330b14.jpg\\\",\\\"product\\\\\\/1\\\\\\/1771929957_699d816503e5d.jpg\\\"]\"', 994, '1', 1, NULL, '2026-02-24 05:15:55', '2026-02-24 10:10:14'),
(2, 'Shoe', 'Shoe, leather cloth', 1200.00, 50.00, 1150.00, '\"[\\\"product\\\\\\/2\\\\\\/1771930234_699d827a8ea27.jpg\\\"]\"', 97, '1', 1, NULL, '2026-02-24 05:20:34', '2026-02-24 10:10:14'),
(3, 'Watch', 'hand watch make your look professional', 4000.00, 0.00, 4000.00, '\"[\\\"product\\\\\\/3\\\\\\/1771930471_699d836709dab.jpg\\\"]\"', 96, '1', 1, NULL, '2026-02-24 05:24:31', '2026-02-24 06:38:11'),
(4, 'Slipper', 'comfortable slipper', 350.00, 12.00, 338.00, '\"[\\\"product\\\\\\/4\\\\\\/1771930538_699d83aab965c.webp\\\"]\"', 1198, '1', 1, NULL, '2026-02-24 05:25:38', '2026-02-24 10:10:14'),
(5, 'Water Bottle', 'Water bottle for 500mL', 1050.00, 25.00, 1025.00, '\"[\\\"product\\\\\\/5\\\\\\/1771947217_699dc4d1acad1.webp\\\",\\\"product\\\\\\/5\\\\\\/1771947220_699dc4d4bde33.jpg\\\"]\"', 1199, '1', 1, NULL, '2026-02-24 10:03:37', '2026-02-24 10:10:14'),
(6, 'LCD TV', 'LCD Tv, full HD and colorful view like a theatre', 24000.00, 120.00, 23880.00, '\"[\\\"product\\\\\\/6\\\\\\/1771947300_699dc524700dc.jpg\\\",\\\"product\\\\\\/6\\\\\\/1771947300_699dc524771b3.webp\\\"]\"', 1200, '1', 1, NULL, '2026-02-24 10:05:00', '2026-02-24 10:05:00'),
(7, 'Refrigerator', 'Refrigerator, make your food unwaste', 54600.00, 1200.00, 53400.00, '\"[\\\"product\\\\\\/7\\\\\\/1771947397_699dc585796dd.jpg\\\",\\\"product\\\\\\/7\\\\\\/1771947397_699dc58581530.jpg\\\"]\"', 100, '1', 1, NULL, '2026-02-24 10:06:37', '2026-02-24 10:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jEob0gBSPdywXiK7GpszpHuHU9WgBdr2QiIcog27', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielJRZGtKd2o4OGozZVBEdFNVS2Z2dUdPcjNZS2g2a3VhNVFZYjNSaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwNC93ZWJhZG1pbi9vcmRlcnMiO3M6NToicm91dGUiO3M6Njoib3JkZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJkYXRhIjthOjU6e3M6ODoiYWRtaW5faWQiO2k6MTtzOjQ6Im5hbWUiO3M6NToiQWRtaW4iO3M6NToiZW1haWwiO3M6MTU6ImFkbWluQGFkbWluLmNvbSI7czo3OiJpc19oZWFkIjtpOjE7czo2OiJzdGF0dXMiO2k6MTt9fQ==', 1771947634);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'User', 'user@user.com', 'a8b4d6bd2417b8ec04cabc71242b3052', '2026-02-24 01:46:58', '2026-02-24 01:46:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_id_index` (`id`),
  ADD KEY `admins_status_index` (`status`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_product_id_index` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_unique_id_unique` (`order_unique_id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_index` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_index` (`order_id`),
  ADD KEY `order_details_product_id_index` (`product_id`),
  ADD KEY `order_details_cart_id_index` (`cart_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
