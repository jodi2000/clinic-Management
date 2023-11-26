-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2023 at 09:42 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `izon`
--
CREATE DATABASE IF NOT EXISTS `izon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `izon`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 09:13 AM
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `admins`:
--

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `phone_number`, `password`, `created_at`, `updated_at`) VALUES
(1, '0993818821', '$2y$10$1h6Mig9Q6p6/aAINI7LjgegCVd6LFrwxzCjspRSUrnyVRqOV7pS.u', '2023-02-07 07:13:20', '2023-02-07 07:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:21 PM
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `categories`:
--

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'hardware', NULL, NULL),
(3, 'software', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 07:29 PM
--

CREATE TABLE `evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `evaluations`:
--

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`id`, `title`, `value`, `created_at`, `updated_at`) VALUES
(1, 'bad', '50', NULL, NULL),
(2, 'good', '20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Creation: Feb 07, 2023 at 09:13 AM
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `failed_jobs`:
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 09:13 AM
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `migrations`:
--

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_02_01_134916_create_admins_table', 1),
(6, '2023_02_01_181829_create_statuses_table', 1),
(7, '2023_02_01_181911_create_evaluations_table', 1),
(8, '2023_02_01_182003_create_technicians_table', 1),
(9, '2023_02_01_182712_create_priorities_table', 1),
(10, '2023_02_01_185955_create_categories_table', 1),
(11, '2023_02_01_190012_create_services_table', 1),
(12, '2023_02_02_195932_create_tickets_table', 1),
(13, '2023_02_04_195224_create_ticket_technicians_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--
-- Creation: Feb 07, 2023 at 09:13 AM
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `password_resets`:
--

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:39 PM
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `personal_access_tokens`:
--

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin', 1, 'token', 'a9d6ecdec2686f5ff21050872bf481a6afb4ce788dd30df203e9c674aa5e7266', '[\"*\"]', '2023-02-07 18:39:15', '2023-02-07 07:13:20', '2023-02-07 18:39:15'),
(2, 'App\\Models\\User', 1, 'token', '08766332bdb0435e9ca451f314cd8085aebc18c6013df9ea301e4dbcedb9e739', '[\"*\"]', '2023-02-07 18:34:18', '2023-02-07 07:13:37', '2023-02-07 18:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:21 PM
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `priorities`:
--

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `title`, `value`, `created_at`, `updated_at`) VALUES
(1, 'normal', '1', NULL, NULL),
(2, 'mid', '2', NULL, NULL),
(3, 'emergency', '3', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:25 PM
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `services`:
--   `category_id`
--       `categories` -> `id`
--

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `price`, `category_id`, `created_at`, `updated_at`) VALUES
(4, 'work', 1000.00, 1, NULL, NULL),
(5, 'Adjust settings', 1000.00, 1, NULL, NULL),
(6, 'download app', 1000.00, 1, NULL, NULL),
(8, 'download app', 1000.00, 3, NULL, NULL),
(9, 'download app', 1000.00, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:20 PM
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `statuses`:
--

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'pending', '2023-02-07 07:13:56', '2023-02-07 16:53:12'),
(2, 'active', NULL, NULL),
(3, 'do', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:21 PM
--

CREATE TABLE `technicians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_cost` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `technicians`:
--

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `name`, `hour_cost`, `created_at`, `updated_at`) VALUES
(1, 'jojo', 10000.00, NULL, NULL),
(2, 'joda', 5000.00, NULL, NULL),
(3, 'jod', 5000.00, NULL, NULL),
(5, 'aya', 2000.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:39 PM
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `priority_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `evaluation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `work_hour` int(11) DEFAULT NULL,
  `work_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` double(8,2) DEFAULT NULL,
  `work_completion_date` date DEFAULT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  `discount` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `tickets`:
--   `client_id`
--       `users` -> `id`
--   `evaluation_id`
--       `evaluations` -> `id`
--   `priority_id`
--       `priorities` -> `id`
--   `service_id`
--       `services` -> `id`
--   `status_id`
--       `statuses` -> `id`
--

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `client_id`, `priority_id`, `status_id`, `service_id`, `evaluation_id`, `work_hour`, `work_report`, `notes`, `total_cost`, `work_completion_date`, `complete`, `discount`, `created_at`, `updated_at`) VALUES
(28, 1, 2, 3, 4, 2, 214, 'kkm', 'kkkk', 39040.00, '2023-02-07', 1, 20.00, '2023-02-07 17:40:12', '2023-02-07 18:05:06'),
(38, 1, 3, 2, 4, 2, 214, 'mmmmmmmmmmmmm', 'ddddddddd', 72800.00, '2023-02-07', 1, 20.00, '2023-02-07 18:32:14', '2023-02-07 18:34:18'),
(39, 1, 3, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2023-02-07 18:39:15', '2023-02-07 18:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_technicians`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 08:32 PM
--

CREATE TABLE `ticket_technicians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `technicians_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `ticket_technicians`:
--   `technicians_id`
--       `technicians` -> `id`
--   `ticket_id`
--       `tickets` -> `id`
--

--
-- Dumping data for table `ticket_technicians`
--

INSERT INTO `ticket_technicians` (`id`, `ticket_id`, `technicians_id`, `created_at`, `updated_at`) VALUES
(20, 28, 1, '2023-02-07 17:44:28', '2023-02-07 17:44:28'),
(21, 28, 2, '2023-02-07 17:44:28', '2023-02-07 17:44:28'),
(22, 38, 1, '2023-02-07 18:32:49', '2023-02-07 18:32:49'),
(23, 38, 2, '2023-02-07 18:32:49', '2023-02-07 18:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Feb 07, 2023 at 09:13 AM
-- Last update: Feb 07, 2023 at 06:49 PM
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone_number`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jojo', '0993818821', '$2y$10$MeeU6WBvYU06uXVlqNm3Au.FXd5woUDpVRIg6PXsBRCCnD5OaxZ8y', NULL, '2023-02-07 07:13:37', '2023-02-07 16:49:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_phone_number_unique` (`phone_number`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_client_id_foreign` (`client_id`),
  ADD KEY `tickets_priority_id_foreign` (`priority_id`),
  ADD KEY `tickets_status_id_foreign` (`status_id`),
  ADD KEY `tickets_service_id_foreign` (`service_id`),
  ADD KEY `tickets_evaluation_id_foreign` (`evaluation_id`);

--
-- Indexes for table `ticket_technicians`
--
ALTER TABLE `ticket_technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_technicians_ticket_id_technicians_id_unique` (`ticket_id`,`technicians_id`),
  ADD KEY `ticket_technicians_technicians_id_foreign` (`technicians_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ticket_technicians`
--
ALTER TABLE `ticket_technicians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_technicians`
--
ALTER TABLE `ticket_technicians`
  ADD CONSTRAINT `ticket_technicians_technicians_id_foreign` FOREIGN KEY (`technicians_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_technicians_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
