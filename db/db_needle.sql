-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 07:41 PM
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
-- Database: `db_needle`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_code`, `color_name`, `created_at`, `updated_at`) VALUES
(4, '00', 'BLACK', NULL, NULL),
(5, '01', 'WHITE', NULL, NULL),
(7, '666', '6666', NULL, NULL),
(8, 'dsf', 'dfdf', NULL, NULL),
(9, '6664', '55543', NULL, NULL),
(10, 'nnn', 'nnn', NULL, NULL),
(11, 'mmm', 'mmm', NULL, NULL),
(17, 'dfd', 'dfdf', NULL, NULL),
(18, 'dfg', 'dfgdfg', NULL, NULL),
(20, 'bbbbbb', 'bbbbbbbbb', NULL, NULL),
(23, 'gh', 'dzg', '2024-05-06 01:21:29', '2024-05-06 01:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `nik`, `name`, `department`, `created_at`, `updated_at`) VALUES
(2, '20230907400', 'RISMA ECA MAGHFIROH', 'PACKING', NULL, NULL),
(3, '20230907399', 'RISKI NUR SAPUTRI', 'PACKING', NULL, NULL),
(4, '20230907398', 'RINA ROHMIYATUN', 'PACKING', NULL, NULL),
(5, '20230907397', 'EVA IRA UTARI', 'PACKING', NULL, NULL),
(6, '20230907395', 'AOLIYA  NURFITRI', 'PACKING', NULL, NULL),
(7, '20201206773', 'LAILATUL MUTHOHAROH', 'PACKING', NULL, NULL),
(8, '20180205176', 'EKA AGUSTIA NUR ALFIYA', 'PACKING', NULL, NULL),
(9, '20210106808', 'DESI WIDIYA ANGGRIANI', 'PACKING', NULL, NULL),
(10, '20210106807', 'IFTACHUL FARICHAH', 'PACKING', NULL, NULL),
(11, '20150802966', 'DWI RISTININGSIH', 'PACKING', NULL, NULL),
(12, '20181205844', 'NENO FALASIFAH', 'PACKING', NULL, NULL),
(13, '20181005713', 'TRI DAWATI AVITA SARI', 'PACKING', NULL, NULL),
(14, '20181005692', 'TRI RISTA RAHMAYANI', 'PACKING', NULL, NULL),
(15, '20181005690', 'KOMARIYAH', 'PACKING', NULL, NULL),
(16, '20180905596', 'SITI FATIMAH', 'PACKING', NULL, NULL),
(17, '20180905570', 'TRI PUJI AMBARSARI', 'PACKING', NULL, NULL),
(18, '20180805561', 'MEI KURNIAWATI', 'PACKING', NULL, NULL),
(19, '20180405313', 'PUNGKAS CAHYONO', 'PACKING', NULL, NULL),
(20, '20180105067', 'PURNAWATI', 'PACKING', NULL, NULL),
(21, '20171104947', 'HENY SETYAWATI', 'PACKING', NULL, NULL),
(22, '20160804119', 'NURDIYANTI', 'PACKING', NULL, NULL),
(23, '20160703992', 'FERDIANI KURNIAWATI', 'PACKING', NULL, NULL),
(24, '20160703965', 'FITRIANA', 'PACKING', NULL, NULL),
(25, '20150903156', 'ULFA TRIYA INNAYAH', 'PACKING', NULL, NULL),
(26, '20150702894', 'FITRIANA KUSUMANING DEWI', 'PACKING', NULL, NULL),
(27, '20150602858', 'TEGUH DWI KUSWANTO', 'PACKING', NULL, NULL),
(28, '20140601983', 'ARUM TRISTIANI', 'PACKING', NULL, NULL),
(29, '20140501885', 'KRISMAWATI', 'PACKING', NULL, NULL),
(30, '20131001045', 'SULISTYAWATI', 'PACKING', NULL, NULL),
(31, '20130700631', 'TRI WAHYUDI', 'PACKING', NULL, NULL),
(32, '20181205874', 'WAHYU INDARTI', 'PACKING', NULL, NULL),
(33, '20181105823', 'SURYA SANDI MARYAM', 'PACKING', NULL, NULL),
(34, '20181005740', 'AMBAR DWI LARAS SANTI', 'PACKING', NULL, NULL),
(35, '20181005688', 'INTAN PERMATASARI', 'PACKING', NULL, NULL),
(36, '20180905643', 'MIFTA OKTAFIANI', 'PACKING', NULL, NULL),
(37, '20180905624', 'DEWI ARDILAWATI', 'PACKING', NULL, NULL),
(38, '20180905595', 'KADARWATI', 'PACKING', NULL, NULL),
(39, '20180805559', 'ARI KURNIYAWATI', 'PACKING', NULL, NULL),
(40, '20180805531', 'ELOK KHUMAERO', 'PACKING', NULL, NULL),
(41, '20171104904', 'SIYAMTI', 'PACKING', NULL, NULL),
(42, '20161004283', 'LIA WIDIYA NINGSIH', 'PACKING', NULL, NULL),
(43, '20160703980', 'MILAM CAHYA', 'PACKING', NULL, NULL),
(44, '20151003378', 'ERMA SEPTIYANI', 'PACKING', NULL, NULL),
(45, '20150802936', 'JUMIYEM', 'PACKING', NULL, NULL),
(46, '20150702895', 'PUTRI RATNA ANDANI', 'PACKING', NULL, NULL),
(47, '20150502675', 'FRETTY KRISTINA ASIH', 'PACKING', NULL, NULL),
(48, '20150502672', 'EKA PURNAMASARI', 'PACKING', NULL, NULL),
(49, '20150402564', 'SITI TASLYAH', 'PACKING', NULL, NULL),
(50, '20150102340', 'ANIK KADARWATI', 'PACKING', NULL, NULL),
(51, '20140902165', 'SUSI SUSANTI', 'PACKING', NULL, NULL),
(52, '20140301636', 'SURACIK', 'PACKING', NULL, NULL);

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_25_182237_create_property_types_table', 2),
(6, '2023_11_25_201608_create_permission_tables', 2),
(7, '2023_12_01_074203_add_soft_delete_colums_to_property_types', 3),
(8, '2023_12_05_025314_create_products_table', 4),
(9, '2024_02_13_062832_create_colors_table', 5),
(18, '2024_05_06_065219_create_employees_table', 6),
(20, '2024_05_10_144227_create_transactions_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(6, 'App\\Models\\User', 22),
(7, 'App\\Models\\User', 19),
(8, 'App\\Models\\User', 21);

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(40, 'permission.menu', 'permission', 'web', '2023-11-30 20:55:53', '2023-11-30 20:55:53'),
(42, 'all.permission', 'permission', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(43, 'add.permission', 'permission', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(44, 'edit.permission', 'permission', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(45, 'delete.permission', 'permission', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(46, 'roles.menu', 'roles', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(47, 'all.roles', 'roles', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(48, 'add.roles', 'roles', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(49, 'edit.roles', 'roles', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(50, 'delete.roles', 'roles', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(51, 'admin.menu', 'admin', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(52, 'all.admin', 'admin', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(53, 'add.admin', 'admin', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(54, 'edit.admin', 'admin', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(55, 'delete.admin', 'admin', 'web', '2023-11-30 21:12:19', '2023-11-30 21:12:19'),
(56, 'all.roles.permission', 'role permission', 'web', '2023-11-30 21:21:50', '2023-11-30 21:21:50'),
(57, 'add.roles.permission', 'role permission', 'web', '2023-11-30 21:21:50', '2023-11-30 21:21:50'),
(58, 'admin.edit.roles', 'role permission', 'web', '2023-11-30 21:21:50', '2023-11-30 21:21:50'),
(59, 'admin.delete.roles', 'role permission', 'web', '2023-11-30 21:21:50', '2023-11-30 21:21:50'),
(71, 'employee.menu', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(72, 'delete.employee', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(73, 'edit.employee', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(74, 'add.employee', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(75, 'all.employee', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(76, 'get.employee', 'employee', 'web', '2024-05-06 01:15:20', '2024-05-06 01:15:20'),
(77, 'transaction.menu', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34'),
(78, 'delete.transaction', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34'),
(79, 'edit.transaction', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34'),
(80, 'add.transaction', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34'),
(81, 'all.transaction', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34'),
(82, 'get.transaction', 'transaction', 'web', '2024-05-06 23:06:34', '2024-05-06 23:06:34');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(6, 'Super Admin', 'web', '2023-11-27 20:33:02', '2023-11-27 20:33:02'),
(7, 'Manager', 'web', '2023-11-27 20:33:08', '2023-11-27 20:33:08'),
(8, 'Production', 'web', '2023-11-27 20:33:14', '2023-11-27 20:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(40, 6),
(42, 6),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6),
(53, 6),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(59, 6),
(71, 6),
(72, 6),
(73, 6),
(74, 6),
(75, 6),
(76, 6),
(77, 6),
(78, 6),
(79, 6),
(80, 6),
(81, 6),
(82, 6);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_trx` varchar(255) NOT NULL,
  `nik` bigint(20) UNSIGNED NOT NULL,
  `type1` varchar(255) NOT NULL,
  `type2` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `no_trx`, `nik`, `type1`, `type2`, `remark`, `created_at`, `updated_at`) VALUES
(4, 'TRX-000001', 2, 'IN', 'OUT', 'OUT', '2024-05-10 08:51:24', '2024-05-10 08:51:33'),
(5, 'TRX-000005', 3, 'IN', 'OUT', 'OUT', '2024-05-10 08:51:55', '2024-05-10 08:52:06'),
(6, 'TRX-000006', 2, 'IN', 'OUT', 'OUT', '2024-05-10 08:52:11', '2024-05-10 08:52:14'),
(7, 'TRX-000007', 2, 'IN', 'OUT', 'OUT', '2024-05-10 08:52:16', '2024-05-11 12:52:26'),
(8, 'TRX-000008', 3, 'IN', '', 'IN', '2024-05-10 09:14:33', '2024-05-10 09:14:33'),
(9, 'TRX-000009', 2, 'IN', 'OUT', 'OUT', '2024-05-11 12:52:30', '2024-05-11 12:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','agent','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `address`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Agent', 'agent', 'agent@gmail.com', NULL, '$2y$12$o2e6Auxs40BXN05wGuX9MutLJUPIxputwkmm0MAOuoZgJ1O.5ekwm', NULL, NULL, NULL, 'agent', 'active', NULL, NULL, NULL),
(3, 'User', 'user', 'user@gmail.com', NULL, '$2y$12$YdHuRqssQ9pypv9YoKynIuuvgcTdupCsF261uWwsUz.5gAen55HyS', NULL, NULL, NULL, 'user', 'active', NULL, NULL, NULL),
(4, 'Dangelo Adams', NULL, 'paris81@example.com', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/0044bb?text=quo', '+1-903-233-0253', '868 Swift Island Apt. 041\nSouth Aleenland, NE 76778-0910', 'agent', 'inactive', 'HvqIGk2Erf', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(5, 'Alexandro Daniel', NULL, 'zola.gislason@example.com', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/008800?text=voluptatem', '(534) 694-1727', '24846 Shanna Parkways Suite 328\nNorth Reeseport, AR 53286-5125', 'agent', 'inactive', '4ig4qKqE86', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(6, 'Dr. Tanya Breitenberg', NULL, 'elza.block@example.com', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/002200?text=ullam', '+17795896803', '9691 Mertz Union\nNew Alice, PA 60557-2270', 'user', 'active', '9O83EIzAFN', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(7, 'Napoleon Kemmer', NULL, 'heller.irving@example.org', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/009922?text=enim', '463.481.6070', '102 Breitenberg Oval Apt. 720\nWest Gunnarville, IN 41632', 'agent', 'active', 'NwyU6Fkil6', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(8, 'Mariela Beatty V', NULL, 'baby12@example.org', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/0066ff?text=sit', '(616) 644-2764', '46100 Kaitlin Field\nPort Marionchester, MO 99012', 'agent', 'inactive', 'jrIsRxFTsr', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(12, 'Tess Nicolas', NULL, 'timothy43@example.org', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/0044ee?text=quod', '(480) 218-1270', '797 Padberg Plain\nDessiechester, PA 44895-5739', 'agent', 'active', 'Ooe4cMjST8', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(13, 'Dannie Windler', NULL, 'linnea77@example.com', '2023-11-22 01:46:07', '$2y$12$u9nVd.jne3rDYCRptBSJIefwEOOLikTTeXJ6.SeKJpvFz0K.aCmR.', 'https://via.placeholder.com/60x60.png/008877?text=itaque', '+1 (831) 405-9487', '889 Altenwerth Tunnel Suite 500\nSabrinaside, DC 97431-2511', 'agent', 'active', '0HdLSG6g11', '2023-11-22 01:46:07', '2023-11-22 01:46:07'),
(19, 'coba', 'coba', 'coba@gmail.com', NULL, '$2y$12$jtZRlq.LwazLg7Inf84tVuGJxQ5IE5C.vyUg//lJfqC/mfVTxJEvu', NULL, '123', 'semarang', 'admin', 'active', NULL, '2023-11-27 20:22:55', '2023-11-27 20:34:01'),
(21, 'production', 'production', 'production@gmail.com', NULL, '$2y$12$BMA7hvfP42iekrBYi86IROLXlAL82QLQNEDy4kB49F.LXW6zk/DYO', NULL, '123', '123', 'admin', 'active', NULL, '2023-11-27 20:35:12', '2023-11-27 20:35:12'),
(22, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$BMA7hvfP42iekrBYi86IROLXlAL82QLQNEDy4kB49F.LXW6zk/DYO', NULL, '123', '123', 'admin', 'active', NULL, '2023-11-27 20:35:12', '2023-11-27 20:35:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_nik_index` (`nik`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_nik_foreign` FOREIGN KEY (`nik`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
