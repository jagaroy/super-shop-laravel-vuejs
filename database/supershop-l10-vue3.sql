-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 07:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supershop-l10-vue`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Raymond', 'Test', 1, '2024-09-20 07:34:46', '2024-09-20 07:34:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Luxury', 'test', 1, '2024-09-20 09:39:11', '2024-09-20 09:39:11', NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2023_10_18_153047_create_invoices_table', 9),
(17, '2023_10_18_153109_create_incomes_table', 9),
(19, '2023_10_18_160746_create_particulars_table', 9),
(20, '2023_10_18_161213_create_payment_categories_table', 10),
(21, '2023_10_27_135301_create_complain_sheets_table', 11),
(22, '2023_11_04_091236_create_expenses_table', 12),
(23, '2024_09_21_203946_create_brands_table', 0),
(24, '2024_09_21_203946_create_categories_table', 0),
(25, '2024_09_21_203946_create_failed_jobs_table', 0),
(26, '2024_09_21_203946_create_net_users_table', 0),
(27, '2024_09_21_203946_create_password_reset_tokens_table', 0),
(28, '2024_09_21_203946_create_password_resets_table', 0),
(29, '2024_09_21_203946_create_permissions_table', 0),
(30, '2024_09_21_203946_create_personal_access_tokens_table', 0),
(31, '2024_09_21_203946_create_products_table', 0),
(32, '2024_09_21_203946_create_roles_table', 0),
(33, '2024_09_21_203946_create_stocks_table', 0),
(34, '2024_09_21_203946_create_sub_categories_table', 0),
(35, '2024_09_21_203946_create_suppliers_table', 0),
(36, '2024_09_21_203946_create_users_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `net_users`
--

CREATE TABLE `net_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `net_user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `net_user_status` enum('Active','Expired','Left') NOT NULL COMMENT 'Active, Expired, Left',
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `net_user_ip` varchar(255) DEFAULT NULL,
  `net_user_expiration` date DEFAULT NULL,
  `last_extend_days` int(11) DEFAULT NULL,
  `net_user_phone` varchar(255) NOT NULL,
  `net_user_address` text NOT NULL,
  `net_user_price` double(8,2) NOT NULL,
  `net_user_registered` date NOT NULL,
  `router_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` enum('Queue','Pppoe') NOT NULL,
  `queue_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pppoe_id` bigint(20) UNSIGNED DEFAULT NULL,
  `net_user_connection_type` enum('ONU','UTP','MC') DEFAULT NULL COMMENT 'ONU, UTP, MC',
  `remarks` text DEFAULT NULL,
  `authored_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permi_id` int(11) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `permi_module` varchar(255) DEFAULT NULL,
  `permi_desc` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permi_id`, `role_id`, `permi_module`, `permi_desc`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 4, 'Api\\Package', '[\"index\",\"areaWise\",\"store\",\"edit\",\"areaPackage\",\"destroy\"]', '2024-03-22 02:45:41', '2024-03-22 02:46:40', '2024-03-22 02:46:40', NULL, NULL),
(2, 4, 'Api\\Router', '[\"index\",\"create\",\"store\",\"show\",\"edit\",\"update\",\"destroy\"]', '2024-03-22 02:46:40', '2024-04-02 19:30:59', '2024-04-02 19:30:59', NULL, NULL),
(3, 4, 'Api\\Package', '[\"index\",\"areaWise\",\"store\",\"edit\",\"areaPackage\",\"destroy\"]', '2024-03-22 02:46:40', '2024-04-02 19:30:59', '2024-04-02 19:30:59', NULL, NULL),
(4, 4, 'Api\\Router', '[\"index\",\"create\",\"store\",\"show\",\"edit\",\"update\",\"destroy\"]', '2024-04-02 19:30:59', '2024-04-02 20:41:53', '2024-04-02 20:41:53', NULL, NULL),
(5, 4, 'Api\\Package', '[\"index\",\"areaWise\",\"store\",\"edit\",\"areaPackage\",\"destroy\"]', '2024-04-02 19:30:59', '2024-04-02 20:41:53', '2024-04-02 20:41:53', NULL, NULL),
(6, 4, 'Api\\User', '[\"edit\"]', '2024-04-02 19:30:59', '2024-04-02 20:41:53', '2024-04-02 20:41:53', NULL, NULL),
(7, 4, 'Api\\Router', '[\"index\",\"create\",\"store\",\"show\",\"edit\",\"update\",\"destroy\"]', '2024-04-02 20:41:53', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL),
(8, 4, 'Api\\Package', '[\"index\",\"areaWise\",\"store\",\"edit\",\"areaPackage\",\"destroy\"]', '2024-04-02 20:41:53', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL),
(9, 4, 'Api\\User', '[\"my_profile\"]', '2024-04-02 20:41:53', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL),
(10, 4, 'Api\\Router', '[\"index\",\"create\",\"store\",\"show\",\"edit\",\"update\",\"destroy\"]', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL, NULL),
(11, 4, 'Api\\Package', '[\"index\",\"areaWise\",\"store\",\"edit\",\"areaPackage\",\"destroy\"]', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL, NULL),
(12, 4, 'Api\\User', '[\"my_profile\",\"my_profile_update\"]', '2024-04-02 20:46:32', '2024-04-02 20:46:32', NULL, NULL, NULL);

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
(1, 'App\\Models\\User', 1, 'MyApp', 'f56a99a406e9cc98d9b97df2690305574e3041ea209a3cbee6f4cbef2e2639cd', '[\"*\"]', NULL, NULL, '2024-09-21 15:00:23', '2024-09-21 15:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
  `brand_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `sub_category_id` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `unit_type` enum('Kg','Piece') NOT NULL COMMENT 'Kg,Piece',
  `purchase_price_per_unit` float DEFAULT NULL,
  `retail_price_per_unit` float NOT NULL,
  `sku` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `supplier_id`, `brand_id`, `category_id`, `sub_category_id`, `product_image`, `unit_type`, `purchase_price_per_unit`, `retail_price_per_unit`, `sku`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Shirt', '1', '1', '1', '1', '/upload/products/product_image-66ed8de182c89.jpg', 'Piece', 1200, 1500, '999', 'test', 1, '2024-09-20 14:56:23', '2024-09-20 14:59:45', NULL),
(2, 'T-Shirt', '1', '1', '1', '1', '/upload/products/product_image-66ed8e817670f.jpg', 'Piece', 1500, 1700, '688', 'test.', 1, '2024-09-20 15:02:25', '2024-09-20 15:02:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Manager', 'desc', 1, '2022-03-26 11:51:30', '2022-03-26 11:51:30', NULL),
(3, 'Supervisor.', 'supr', 1, '2022-03-26 11:52:18', '2024-03-20 07:51:17', NULL),
(4, 'demo', 'demo', 1, '2022-07-13 11:44:19', '2022-07-13 11:44:19', NULL),
(5, 'Executive.', 'Executive Officer.', 1, '2024-03-20 07:54:16', '2024-03-20 07:56:00', NULL),
(6, 'Officer', 'trs', 1, '2024-04-29 18:30:37', '2024-04-29 18:31:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` float NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2', 215, 'Test', 1, '2024-09-20 18:30:26', '2024-09-21 08:38:37', NULL),
(3, '1', 135, 'test', 1, '2024-09-20 18:35:56', '2024-09-21 08:38:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Sub Luxury', 'Test', 1, '2024-09-20 12:20:16', '2024-09-20 12:20:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `company_name`, `phone`, `email`, `address`, `website`, `remarks`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mr. Rimon', 'Rim Textile', '01111111', 'r@r.r', 'Uttara, Dhaka.', 'rimtextile.com', 'Test,', 1, '2024-09-19 17:07:19', '2024-09-19 17:20:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('user','superadmin') NOT NULL DEFAULT 'user' COMMENT 'user,superadmin',
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `phone` varchar(191) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive' COMMENT 'Inactive, Active',
  `authored_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `phone`, `image`, `status`, `authored_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'superadmin', NULL, 'Admin User', 'admin@admin.com', NULL, '$2y$10$y9SqW6ighfiatvwm8IcBmuEiQ4ykHJOEN.jGnzZ/Njn3g1Psijn92', NULL, '154455', '/upload/profiles/superadmin.jpg', 'Active', 1, '2021-10-28 01:57:36', '2024-04-19 18:35:15', NULL),
(504, 'user', 4, 'Demo User D', 'demo@demo.com', NULL, '$2y$10$Hd24zE4DWKb1Jqgk0tlSOeqT/.t1axcH4TixZGHWqJSwyODwSZowK', NULL, '0564565656', '/upload/profiles/User-1657708143.png', 'Active', 1, '2022-07-13 10:29:03', '2024-04-02 14:59:12', NULL),
(506, 'user', 3, 'Test User 1', 't@t.t', NULL, '$2y$10$bPOsIiQ16lEukdXTZW628e3Ly9CMAaMUxg14Fp4s9e/KrdE0fITGa', NULL, '01766666666', '/upload/profiles/User-1649089835.png', 'Active', 1, '2022-12-14 18:29:57', '2024-03-22 13:56:40', NULL),
(507, 'user', 5, 'Raton', 'raton@r.r', NULL, '$2y$10$nxW3mDt2MIa1Q9zEdlEGoOV9seadHNams7VK9Wt7WKhoALrLXuCTi', NULL, '01111111111', NULL, 'Active', 1, '2024-03-09 17:55:30', '2024-03-22 13:56:27', NULL),
(510, 'user', 5, 'Shimul', 'shimul@shimul.com', NULL, '$2y$10$uk5BLAmrzW8KLubhGou09eQnGxNn7ienaEE46kGrZXrwC73lThAK.', NULL, '0156', NULL, 'Active', 1, '2024-03-22 14:02:25', '2024-03-22 14:02:25', NULL),
(511, 'user', 5, 'Robin', 'robin@r.r', NULL, '$2y$10$TWA691OodbxmmIeL2m9jrO1HmlORSxGlHfW24.SKxiUNTGM2X17Ne', NULL, '01777777777', NULL, 'Active', 1, '2024-03-24 12:59:50', '2024-03-24 12:59:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `net_users`
--
ALTER TABLE `net_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `net_users_email_unique` (`email`),
  ADD KEY `net_users_router_id_foreign` (`router_id`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permi_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `net_users`
--
ALTER TABLE `net_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
