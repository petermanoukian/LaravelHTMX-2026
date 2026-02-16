-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2026 at 04:46 PM
-- Server version: 5.7.40
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `htmx2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

DROP TABLE IF EXISTS `cats`;
CREATE TABLE IF NOT EXISTS `cats` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci,
  `dess` longtext COLLATE utf8mb4_unicode_ci,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cats_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `name`, `des`, `dess`, `img`, `img2`, `filer`, `created_at`, `updated_at`) VALUES
(12, 'uytuy', 'uyuyu', NULL, NULL, NULL, NULL, '2026-02-09 13:12:24', '2026-02-09 13:12:24'),
(20, 'YTRYTY', 'TYTRYfedsf', NULL, NULL, NULL, NULL, '2026-02-09 13:50:04', '2026-02-09 13:50:04'),
(41, '456', '546546', '5645546', 'uploads/cat/img/2-1770748833_698b7ba107a80.jfif', 'uploads/cat/img/thumb/2-1770748833_698b7ba107a80.jfif', 'uploads/cat/file/456_1770748833.pdf', '2026-02-09 14:07:48', '2026-02-10 14:40:33'),
(43, '4345435', '543543', '54534', 'uploads/cat/img/2-1770742783_698b63ff5a47b.jfif', 'uploads/cat/img/thumb/2-1770742783_698b63ff5a47b.jfif', NULL, '2026-02-10 12:59:43', '2026-02-10 12:59:43'),
(46, 'retrt', 'trtr', 'trrtre', NULL, NULL, NULL, '2026-02-10 13:31:27', '2026-02-10 13:31:27'),
(47, '767667', '67666556', NULL, NULL, NULL, NULL, '2026-02-10 13:31:54', '2026-02-10 13:31:54'),
(49, 'uuyuy', NULL, NULL, NULL, NULL, NULL, '2026-02-10 13:43:31', '2026-02-10 13:43:31'),
(51, 'etrrtrtetr', NULL, NULL, NULL, NULL, NULL, '2026-02-10 13:52:13', '2026-02-10 13:52:13'),
(53, '767676765', NULL, NULL, NULL, NULL, NULL, '2026-02-10 13:53:58', '2026-02-10 13:53:58'),
(55, 'rtrtrttr', NULL, NULL, NULL, NULL, NULL, '2026-02-10 13:55:47', '2026-02-10 13:55:47'),
(56, '6565654645', NULL, NULL, NULL, NULL, NULL, '2026-02-10 13:56:55', '2026-02-10 13:56:55'),
(57, 'ytytyttyr', NULL, NULL, NULL, NULL, NULL, '2026-02-10 14:00:41', '2026-02-10 14:00:41'),
(58, '65656', '56565', '6656545', NULL, NULL, NULL, '2026-02-10 14:06:46', '2026-02-10 14:06:46'),
(59, 'hghghgfhf', NULL, NULL, NULL, NULL, NULL, '2026-02-10 14:11:59', '2026-02-10 14:11:59'),
(60, 'rtrtrt', 'rtret', 'trtrte', NULL, NULL, NULL, '2026-02-10 14:15:35', '2026-02-10 14:15:35'),
(61, 'tytytytrytrt', NULL, NULL, NULL, NULL, NULL, '2026-02-10 14:17:57', '2026-02-10 14:17:57'),
(62, '7676676677656', NULL, NULL, NULL, NULL, NULL, '2026-02-10 14:27:54', '2026-02-10 14:27:54'),
(63, 'uuyuu', 'yuyuyuyt', NULL, NULL, NULL, NULL, '2026-02-10 14:31:58', '2026-02-10 14:31:58'),
(64, 'rewrr', 'ererwer', NULL, NULL, NULL, NULL, '2026-02-10 14:32:39', '2026-02-10 14:32:39'),
(66, 'ytyy', 'yyytrt', NULL, NULL, NULL, NULL, '2026-02-10 14:34:02', '2026-02-10 14:34:02'),
(67, 'tytryt', 'ytytty', NULL, NULL, NULL, NULL, '2026-02-10 14:36:51', '2026-02-10 14:36:51'),
(68, 'yuy', 'uyuyuyuy', NULL, NULL, NULL, 'uploads/cat/file/yuy_1770829265.docx', '2026-02-10 14:37:30', '2026-02-11 13:01:05'),
(69, 'uyuyuy', 'uyuyuy', NULL, NULL, NULL, NULL, '2026-02-10 14:38:27', '2026-02-10 14:38:27'),
(70, 'updatedddd345', NULL, NULL, 'uploads/cat/img/3-1770829252_698cb5c49f542.jpg', 'uploads/cat/img/thumb/3-1770829252_698cb5c49f542.jpg', NULL, '2026-02-10 14:39:59', '2026-02-11 13:00:52'),
(71, 'jhjj', 'hjhjh', 'jhhj', 'uploads/cat/img/2-1770830803_698cbbd3b6e77.jfif', 'uploads/cat/img/thumb/2-1770830803_698cbbd3b6e77.jfif', NULL, '2026-02-11 13:26:43', '2026-02-11 13:26:43'),
(72, 'fgfg', 'fgfg', 'gfgfd', 'uploads/cat/img/2-1771076274_69907ab23963b.png', 'uploads/cat/img/thumb/2-1771076274_69907ab23963b.png', NULL, '2026-02-14 09:37:15', '2026-02-14 09:37:54'),
(73, 'Planes', 'trtr', 'ttrt', 'uploads/cat/img/1-1771076259_69907aa3af136.jpg', 'uploads/cat/img/thumb/1-1771076259_69907aa3af136.jpg', NULL, '2026-02-14 09:37:39', '2026-02-15 13:18:27'),
(74, 'Cars', 'trtyty', '<strong>Bold 2333</strong>', NULL, NULL, NULL, '2026-02-14 10:30:06', '2026-02-15 13:18:15'),
(75, 'machines', 'ttrt', '<p>Numbe e3344</p>', 'uploads/cat/img/2-1771080795_69908c5b7a5ae.png', 'uploads/cat/img/thumb/2-1771080795_69908c5b7a5ae.png', 'uploads/cat/file/Cat4_1771081922.pdf', '2026-02-14 10:53:15', '2026-02-15 13:18:40'),
(76, 'machnery', 'HGHGFH', '<p><em>HHGFH 234</em></p>', NULL, NULL, NULL, '2026-02-14 10:53:51', '2026-02-15 13:19:15'),
(77, 'Services', '76767', '<p>hjhjhj</p>', 'uploads/cat/img/1-1771158411_6991bb8b9afb4.jfif', 'uploads/cat/img/thumb/1-1771158411_6991bb8b9afb4.jfif', 'uploads/cat/file/cat-number677_1771158412.jpg', '2026-02-15 08:26:52', '2026-02-15 13:18:59'),
(78, 'newws', 'vbbvbvb', '<p>bvvcvb</p>', 'uploads/cat/img/1-1771181879_6992173783a5d.jpg', 'uploads/cat/img/thumb/1-1771181879_6992173783a5d.jpg', 'uploads/cat/file/newws_1771181879.jpg', '2026-02-15 14:57:59', '2026-02-15 14:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_07_174749_create_cats_table', 2),
(5, '2026_02_14_154433_create_subcats_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Y4JYAzf8vIky9wxV5k987faagOQlcGGWwrNfn2t6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWFpZzRUUVFidjVVV0xrNnB0eERnY0E0OGFvU3RIS1Vqelg1Mzd1WCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2NhdCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uY2F0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771182109);

-- --------------------------------------------------------

--
-- Table structure for table `subcats`
--

DROP TABLE IF EXISTS `subcats`;
CREATE TABLE IF NOT EXISTS `subcats` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `catid` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci,
  `dess` longtext COLLATE utf8mb4_unicode_ci,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcats_catid_name_unique` (`catid`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcats`
--

INSERT INTO `subcats` (`id`, `catid`, `name`, `des`, `dess`, `img`, `img2`, `filer`, `created_at`, `updated_at`) VALUES
(1, 56, 'subcategory 55555', 'yt', '<p><strong>ytytrr</strong></p>', 'uploads/subcat/img/3-1771166771_6991dc33d233e.png', 'uploads/subcat/img/thumb/3-1771166771_6991dc33d233e.png', 'uploads/subcat/file/sunbcat111_1771165714.pdf', '2026-02-15 10:28:34', '2026-02-15 10:46:25'),
(2, 58, 'sub4566', 'kjkj', '<p>jkkj</p>', 'uploads/subcat/img/1-1771166756_6991dc24b3937.jfif', 'uploads/subcat/img/thumb/1-1771166756_6991dc24b3937.jfif', 'uploads/subcat/file/sub4566_1771166377.png', '2026-02-15 10:39:37', '2026-02-15 10:45:57'),
(3, 77, 'service1', 'jhj', '<p>jhjhhjjhhj</p>', 'uploads/subcat/img/2-1771167009_6991dd215172a.png', 'uploads/subcat/img/thumb/2-1771167009_6991dd215172a.png', NULL, '2026-02-15 10:50:09', '2026-02-15 13:55:43'),
(4, 43, 'rtrte buuuuu', 'rttr', '<p>trtreer</p>', NULL, NULL, NULL, '2026-02-15 10:50:54', '2026-02-15 11:49:40'),
(10, 58, 'service2', 'hgfhg', '<p>hghff</p>', NULL, NULL, NULL, '2026-02-15 11:49:16', '2026-02-15 14:36:36'),
(11, 71, 'ttrtr', 'rtrt', '<p>trreert</p>', NULL, NULL, NULL, '2026-02-15 11:55:19', '2026-02-15 11:55:19'),
(12, 75, 'tryt', 'ytyty', NULL, NULL, NULL, NULL, '2026-02-15 11:55:49', '2026-02-15 11:55:49'),
(13, 41, 'service1', 'tyrtrt', '<p>yttytyyt trttteetter</p>', 'uploads/subcat/img/2-1771180312_69921118ae0be.jpg', 'uploads/subcat/img/thumb/2-1771180312_69921118ae0be.jpg', NULL, '2026-02-15 14:30:49', '2026-02-15 14:31:52'),
(14, 77, 'Service3', 'rtrghghg', '<p>hgfhgfhghg</p>', 'uploads/subcat/img/Quotefancy-557669-3840x2160-1771180801_69921301db61a.jpg', 'uploads/subcat/img/thumb/Quotefancy-557669-3840x2160-1771180801_69921301db61a.jpg', 'uploads/subcat/file/Service3_1771180803.jfif', '2026-02-15 14:40:03', '2026-02-15 14:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$2qHdJ3/EOrf7yCciiOSIhud7paBXztGwTWYwdX6vWyw7cm5t.zT52', 'R4O8iMCyCRLCQvncDhDndvG9z8t2THGxjBJsRbYAByv4cXPuDWGFeHsK5SDH', '2026-02-07 13:39:27', '2026-02-07 13:39:27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
