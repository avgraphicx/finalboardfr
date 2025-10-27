-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2025 at 09:02 AM
-- Server version: 8.0.43-0ubuntu0.24.04.2
-- PHP Version: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iboardnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` bigint DEFAULT NULL,
  `old_data` json DEFAULT NULL,
  `new_data` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `logo`, `company_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'storage/logos/pwzDvZUcCTiANAdlir6umS16BJAFOV9tcjH9dMY9.png', 'IB', '2025-10-24 15:05:50', '2025-10-25 15:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `default_rental_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `driver_id`, `full_name`, `phone_number`, `ssn`, `license_number`, `default_percentage`, `default_rental_price`, `active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'U9622', 'Ismail Merdjaoui', '5144490082', '123456781', 'MERDXXXXXXXXX', 25.00, 60.00, 1, 1, '2025-08-02 21:39:36', '2025-10-21 20:04:08'),
(28, 'V3521', 'Elody Mitchell', '5142813155', NULL, NULL, 25.00, 60.00, 1, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(29, 'V4270', 'Melisa Larkin', '5143672782', NULL, NULL, 25.00, 60.00, 1, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(30, 'Y1966', 'Demond Macejkovic', '5142670703', NULL, NULL, 25.00, 60.00, 1, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(31, 'U4855', 'Darryl Labadie', '5144208821', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(32, 'X4181', 'Tressie Bednar', '5144113606', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(33, 'Z7119', 'Dennis Blanda', '5147923269', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(34, 'Y6614', 'Chelsea Hirthe', '5149573716', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(35, 'X9620', 'Cindy Schroeder', '5146775435', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(36, 'U8573', 'Jude Veum', '5145031241', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(37, 'Z4250', 'Margaretta Lynch', '5145142436', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(38, 'X6888', 'Virgie Heathcote', '5144054009', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(39, 'Z5742', 'Hardy Beatty', '5141595358', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(40, 'V8393', 'Billy Spinka', '5142123075', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(41, 'X8399', 'Marquise Fahey', '5148668133', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(42, 'V5827', 'Brook Cormier', '5146588344', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(43, 'Y7590', 'Delores Kunde', '5145538133', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(44, 'X3552', 'Emily Powlowski', '5145993345', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(46, 'W5360', 'Gracie Rowe', '5145388474', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(47, 'X1345', 'Felix Kuhlman', '5142552813', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(48, 'V7586', 'Anastasia Christiansen', '5144021990', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(49, 'Y6543', 'Nick Tromp', '5147517837', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(50, 'V1004', 'Luigi Labadie', '5144399486', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(51, 'U1011', 'Estell Metz', '5145325917', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(52, 'W6787', 'Ramiro Skiles', '5142393319', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(53, 'Z2046', 'Cielo O\'Conner', '5144193672', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(54, 'Z9940', 'Cooper Douglas', '5145521038', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(55, 'X5831', 'Margarette Ryan', '5147159854', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(56, 'W1833', 'Demond Kuphal', '5149929721', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(57, 'Z9387', 'Pamela McCullough', '5145590915', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(58, 'W9261', 'Gust Streich', '5148014732', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(59, 'U7187', 'Gregory Muller', '5147425993', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(60, 'Y3374', 'Sonya Turner', '5143536166', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(61, 'W7780', 'Jennyfer Jakubowski', '5146383869', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(62, 'Z5989', 'Elenor Hahn', '5146593934', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(63, 'U8367', 'Vickie Mayer', '5146547995', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(64, 'W3195', 'Ron Hettinger', '5147633965', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(65, 'V6545', 'Monroe Block', '5145745031', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(66, 'Y1491', 'Filomena Torp', '5143312719', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(67, 'V4210', 'Imani Bernhard', '5149452835', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(68, 'W9776', 'Cruz Pagac', '5146362412', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(69, 'Z3765', 'Barbara Swift', '5146955991', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(70, 'X4464', 'Nat Bergnaum', '5146830975', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(71, 'Z6685', 'Ashleigh Wiegand', '5141169297', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(72, 'W4669', 'Palma Dibbert', '5142589030', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(73, 'Z5792', 'Westley Koss', '5143941442', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(74, 'Z6434', 'Veronica Kautzer', '5142328777', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(75, 'Z4672', 'Jarred Nicolas', '5148283820', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(76, 'Z3578', 'Kamille Schimmel', '5149145947', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(77, 'V8197', 'Roselyn Jaskolski', '5141419607', NULL, NULL, 25.00, 60.00, 1, 6, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(78, 'U9700', 'Youcef Mehidi', '5144496016', '423675981', 'MERDXXXXXXXX5', 20.00, 30.00, 1, 1, '2025-10-15 00:51:36', '2025-10-15 00:51:36'),
(79, 'U9566', 'Sofiane Rekia', '5144497070', '354189610', 'MERDXXXXXXXX5', 20.00, 30.00, 1, 1, '2025-10-15 00:52:02', '2025-10-15 00:52:02'),
(82, 'V4434', 'Sophie Belanger', '4381239835', '797743211', 'H70891986101868', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(84, 'V4000', 'Julie Gauthier', '4381233058', '186146696', 'F55851986101882', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(85, 'V7797', 'Emma Lavoie', '4381237510', '657198404', 'B82651984101837', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(86, 'W0316', 'Lucas Gauthier', '4381239198', '452968375', 'X27802005101865', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(87, 'W2203', 'Liam Bouchard', '4381230168', '901125711', 'Y70562002101899', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(88, 'W3313', 'Julie Tremblay', '4381233503', '792426274', 'Z74361996101878', 25.00, 60.00, 1, 6, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(89, 'W3450', 'Lucas Morin', '4381231955', '610428846', 'C67782003101812', 25.00, 60.00, 1, 6, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(90, 'V8155', 'Noah Bouchard', '4381237074', '200318446', 'A24472001101834', 25.00, 60.00, 1, 6, '2025-10-18 15:24:28', '2025-10-18 15:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `broker_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date DEFAULT NULL,
  `week` int DEFAULT NULL,
  `for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `broker_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `week_number` int NOT NULL,
  `warehouse_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `days_worked` int NOT NULL DEFAULT '0',
  `total_parcels` int NOT NULL DEFAULT '0',
  `vehicle_rental_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `driver_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_advance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `penalty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount_to_pay_driver` decimal(10,2) DEFAULT NULL COMMENT 'computed',
  `broker_share` decimal(10,2) DEFAULT NULL COMMENT 'computed',
  `enterprise_net` decimal(10,2) DEFAULT NULL COMMENT 'computed',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `broker_id`, `driver_id`, `week_number`, `warehouse_name`, `invoice_total`, `days_worked`, `total_parcels`, `vehicle_rental_price`, `driver_percentage`, `bonus`, `cash_advance`, `penalty`, `amount_to_pay_driver`, `broker_share`, `enterprise_net`, `is_paid`, `pdf_path`, `paid_at`, `created_at`, `updated_at`) VALUES
(287, 0, 82, 36, 'MONT', 962.66, 2, 507, 60.00, 25.00, 0.00, 0.00, 0.00, 602.00, 360.67, NULL, 0, 'payments/V4434_2025-36_MONT-xZdpAQ.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(288, 0, 85, 37, 'MONT', 443.65, 2, 243, 60.00, 25.00, 0.00, 0.00, 0.00, 212.74, 230.91, NULL, 0, 'payments/V7797_2025-37_MONT-aaQTxz.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(289, 0, 79, 37, 'MONT', 1310.46, 5, 757, 30.00, 20.00, 0.00, 0.00, 0.00, 898.37, 412.09, NULL, 0, 'payments/U9566_2025-37_MONT-446LgB.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(290, 0, 87, 37, 'MONT', 1525.46, 5, 830, 60.00, 25.00, 0.00, 0.00, 0.00, 844.10, 681.37, NULL, 0, 'payments/W2203_2025-37_MONT-7YSmPG.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(291, 0, 82, 37, 'MONT', 494.53, 1, 254, 60.00, 25.00, 0.00, 0.00, 0.00, 310.90, 183.63, NULL, 0, 'payments/V4434_2025-37_MONT-e5ZLFy.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(293, 0, 78, 37, 'MONT', 2174.12, 5, 1185, 30.00, 20.00, 0.00, 0.00, 0.00, 1589.30, 584.82, NULL, 0, 'payments/U9700_2025-37_MONT-9EV25m.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(294, 0, 88, 37, 'MONT', 402.51, 3, 272, 60.00, 25.00, 0.00, 0.00, 0.00, 121.88, 280.63, NULL, 0, 'payments/W3313_2025-37_MONT-WKE4Lj.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(295, 0, 89, 37, 'MONT', 1471.11, 4, 816, 60.00, 25.00, 0.00, 0.00, 0.00, 863.33, 607.78, NULL, 0, 'payments/W3450_2025-37_MONT-Kqvw1W.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(296, 0, 86, 37, 'JOLI', 382.66, 1, 198, 60.00, 25.00, 0.00, 0.00, 0.00, 227.00, 155.67, NULL, 0, 'payments/W0316_2025-37_JOLI-10Dfho.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(297, 0, 88, 38, 'MONT', 1308.89, 5, 761, 60.00, 25.00, 0.00, 0.00, 0.00, 681.67, 627.22, NULL, 0, 'payments/W3313_2025-38_MONT-tDLzng.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(298, 0, 78, 39, 'RIDP', 44.85, 1, 27, 30.00, 20.00, 0.00, 0.00, 0.00, 5.88, 38.97, NULL, 0, 'payments/U9700_2025-39_RIDP-1syzw6.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(299, 0, 84, 39, 'MONT', 1607.39, 4, 830, 60.00, 25.00, 0.00, 0.00, 0.00, 965.54, 641.85, NULL, 0, 'payments/V4000_2025-39_MONT-cv3zes.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(300, 0, 84, 38, 'MONT', 2681.80, 6, 1493, 60.00, 25.00, 0.00, 0.00, 0.00, 1651.35, 1030.45, NULL, 0, 'payments/V4000_2025-38_MONT-chBQyJ.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(301, 0, 89, 38, 'MONT', 1907.09, 6, 1129, 60.00, 25.00, 0.00, 0.00, 0.00, 1070.32, 836.77, NULL, 0, 'payments/W3450_2025-38_MONT-YwWXgF.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(302, 0, 78, 38, 'MONT', 2243.01, 5, 1244, 30.00, 20.00, 0.00, 0.00, 0.00, 1644.41, 598.60, NULL, 0, 'payments/U9700_2025-38_MONT-E2FFtj.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(303, 0, 86, 38, 'JOLI', 1051.11, 3, 529, 60.00, 25.00, 0.00, 0.00, 0.00, 608.33, 442.78, NULL, 0, 'payments/W0316_2025-38_JOLI-shmaWq.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(304, 0, 87, 38, 'RIDP', 93.93, 1, 53, 60.00, 25.00, 0.00, 0.00, 0.00, 10.45, 83.48, NULL, 0, 'payments/W2203_2025-38_RIDP-rD7GOG.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(305, 0, 87, 38, 'MONT', 781.78, 3, 474, 60.00, 25.00, 0.00, 0.00, 0.00, 406.34, 375.45, NULL, 0, 'payments/W2203_2025-38_MONT-BerTbq.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(306, 0, 79, 39, 'MONT', 1232.18, 3, 704, 30.00, 20.00, 0.00, 0.00, 0.00, 895.74, 336.44, NULL, 0, 'payments/U9566_2025-39_MONT-CjzXl9.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(307, 0, 84, 39, 'RIDP', 76.30, 1, 45, 60.00, 25.00, 0.00, 0.00, 0.00, -2.78, 79.08, NULL, 0, 'payments/V4000_2025-39_RIDP-3iTMOw.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(308, 0, 84, 40, 'MONT', 2195.77, 5, 1222, 60.00, 25.00, 0.00, 0.00, 0.00, 1346.83, 848.94, NULL, 0, 'payments/V4000_2025-40_MONT-Dl4RnX.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(309, 0, 89, 40, 'MONT', 2724.40, 6, 1674, 60.00, 25.00, 0.00, 0.00, 0.00, 1683.30, 1041.10, NULL, 0, 'payments/W3450_2025-40_MONT-Rj7b7m.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(310, 0, 79, 40, 'MONT', 1472.69, 4, 822, 30.00, 20.00, 0.00, 0.00, 0.00, 1058.15, 414.54, NULL, 0, 'payments/U9566_2025-40_MONT-FQ8J2Z.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(311, 0, 78, 40, 'MONT', 2070.69, 5, 1166, 30.00, 20.00, 0.00, 0.00, 0.00, 1506.55, 564.14, NULL, 0, 'payments/U9700_2025-40_MONT-LAy2NM.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(312, 0, 90, 40, 'MONT', 345.95, 1, 180, 60.00, 25.00, 0.00, 0.00, 0.00, 199.46, 146.49, NULL, 0, 'payments/V8155_2025-40_MONT-k57D2t.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(313, 0, 88, 40, 'MONT', 1863.43, 5, 1019, 60.00, 25.00, 0.00, 0.00, 0.00, 1097.57, 765.86, NULL, 0, 'payments/W3313_2025-40_MONT-Z8k1gg.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(314, 0, 82, 35, 'MONT', 463.10, 1, 239, 60.00, 25.00, 0.00, 0.00, 0.00, 287.33, 175.78, NULL, 0, 'payments/V4434_2025-35_MONT-ZokKW4.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(315, 0, 85, 35, 'MONT', 98.04, 1, 55, 60.00, 25.00, 0.00, 0.00, 0.00, 13.53, 84.51, NULL, 0, 'payments/V7797_2025-35_MONT-joyz4B.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(316, 0, 78, 35, 'MONT', 2958.00, 6, 1640, 30.00, 20.00, 0.00, 0.00, 0.00, 2186.40, 771.60, NULL, 0, 'payments/U9700_2025-35_MONT-yjtI0e.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(317, 0, 86, 35, 'MONT', 1047.04, 3, 638, 60.00, 25.00, 0.00, 0.00, 0.00, 605.28, 441.76, NULL, 0, 'payments/W0316_2025-35_MONT-j84E9W.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(318, 0, 87, 35, 'RIDP', 38.20, 1, 22, 60.00, 25.00, 0.00, 0.00, 0.00, -31.35, 69.55, NULL, 0, 'payments/W2203_2025-35_RIDP-sIwhjF.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(319, 0, 79, 35, 'MONT', 2567.71, 6, 1460, 30.00, 20.00, 0.00, 0.00, 0.00, 1874.17, 693.54, NULL, 0, 'payments/U9566_2025-35_MONT-jRvugx.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(320, 0, 87, 35, 'MONT', 1025.20, 5, 584, 60.00, 25.00, 0.00, 0.00, 0.00, 468.90, 556.30, NULL, 0, 'payments/W2203_2025-35_MONT-wThbPi.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(321, 0, 78, 32, 'MONT', 1707.39, 5, 1084, 30.00, 20.00, 0.00, 0.00, 0.00, 1215.91, 491.48, NULL, 0, 'payments/U9700_2025-32_MONT-Kb1gOU.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(322, 0, 85, 32, 'MONT', 136.40, 1, 70, 60.00, 25.00, 0.00, 0.00, 0.00, 42.30, 94.10, NULL, 0, 'payments/V7797_2025-32_MONT-8UOJVf.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(323, 0, 86, 32, 'JOLI', 966.92, 3, 484, 60.00, 25.00, 0.00, 0.00, 0.00, 545.19, 421.73, NULL, 0, 'payments/W0316_2025-32_JOLI-zNPKor.pdf', NULL, '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(325, 1, 1, 32, 'MONT', 2120.00, 5, 1147, 60.00, 22.00, 30.00, 50.00, 80.00, 1493.60, NULL, NULL, 0, 'payments/U9622_2025-32_MONT-inl5fL.pdf', NULL, '2025-10-24 05:03:36', '2025-10-24 05:04:19'),
(326, 1, 86, 32, 'JOLI', 966.92, 3, 484, 60.00, 25.00, 0.00, 0.00, 0.00, 665.19, NULL, NULL, 0, 'payments/W0316_2025-32_JOLI-mhD5g0.pdf', NULL, '2025-10-25 16:52:52', '2025-10-25 16:52:52');

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
(4, '2025_10_24_000001_create_user_activity_table', 1),
(5, '2025_10_24_000002_create_user_preferences_table', 1),
(6, '2025_10_24_000003_create_subscription_types_table', 1),
(7, '2025_10_24_000004_create_subscriptions_table', 1),
(8, '2025_10_24_000005_create_drivers_table', 1),
(9, '2025_10_24_000006_create_invoices_table', 1),
(10, '2025_10_24_000007_create_audit_logs_table', 1),
(11, '2025_10_24_000008_create_stats_cache_table', 1),
(12, '2025_10_24_000009_add_phone_number_to_drivers_table', 2),
(13, '2025_10_24_064610_create_companies_table', 3),
(14, '2025_10_26_create_expenses_table', 4),
(15, '2025_10_27_000001_create_subscription_leads_table', 5);

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
('33WB1GWJDrWIP5yupdYyrnxzImxevLL773UvHFC7', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (X11; Linux x86_64; rv:120.0) Gecko/20100101 Firefox/120.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaHJaeUtMZnFDU0hqNjdvalhCVkxXYWNuYk9RR0lxMGFVek4zY1U5bSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761552464),
('3aGQMNEyoASCx18pe8VjfZfKL3gh0bUeRrlxUXsj', NULL, '164.90.166.254', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiODU5M1YzVERQNUNXU2RaNEh4R0xxUWVFT1ZHNjk0N0lKdnRHUEt4eiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761549461),
('3uWK4CWoS09dXVox14EQkRK1B0PIMO1UbaJiDTo5', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidVpxeVBkVjB6aktrd1BzRU5Nb2JlOTBuckFWc1FpME9EcXBoTWMyTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761554488),
('4ExPc8I6Cjors0HmnYvhkhBlFHYsBjvlXOQYB73q', NULL, '106.75.129.228', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDBwSUdJNGlOZlVlRmJrMWIxelgyRFExOFg3Z2ZJdkNDV0JHVUNHbCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552469),
('5KYYtSTr1lJlHzvtUZEhL9pOq7Lp8pr7TZU00hwN', NULL, '164.90.166.254', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibU5TTUs2SFNxUkNLMWRqNkw2RHpRSnNQWDFsVUFtcHRDWG54RHRsSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761549461),
('Ari7E4FhfZjvybZvm81IdslwhLqV92sp6m42T1i1', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXFidDNnTGFybzVYWFpMZ3FuODRld0dwZUJ6VlVycnRuN0NNQVdnMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552465),
('B87ivDjoA2YIdPF7OmTaiM0MWte12TqPO6i1bFmD', NULL, '182.44.9.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVB6RnhCd0lZR3l3WkVBOW1iZ05vS1lqcGM5SFVqa1V6OGNkZUxuVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761551881),
('bi2FE2Fl57PsKoFW94YtGK3nigqBhmv7RcXQueop', NULL, '106.75.129.228', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzN5cUVIRHFvejRHTXBTSElvTlVBckR2a0VkblNEaTFNdnhYMDZOeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552471),
('DqSrVrO8APt9ChdJqrDu2RloSpxGPaPeCRYMma5R', NULL, '104.164.173.181', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlRTamRzQmQ2em1mOWVYWWtJS3NKdGhlcElhWnFBSWp5aEtGV2VvZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552465),
('E5cv94KfWsXX59Ue0yFdQWq9ykF3nmN0xM1xvK8f', NULL, '124.236.100.56', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVM3RUtFaTUydldOS3dpeUkyWTZvZGJDZFRqS3NwR05mbFhhVEw2dSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761555274),
('fK7fP9zdfeXsqJTLFHAgbgW58sxTz9UMqbgOlcOe', NULL, '206.189.2.13', 'Mozilla/5.0 (Linux; Android 6.0; HTC One M9 Build/MRA41052) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.8608.98 Mobile Safari/537.3', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEcwUHFFblVJaXAxZzJtMmxoYlM3dFE3Y1hYUjBxcnRNbWcxTzZKNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552466),
('G2ahL8t1YAKjo1DjHGjyq6gPGZHc4RMWbmOokgdS', NULL, '43.157.181.189', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid3RPRVN5anpmVFVheDZ3NlRiQVpxWDhpSk1BazFoWGd5UUYyc2lyVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761551887),
('gURaY2OX9pR0WHjnYu7mBlv41zYOvZq7Ua8LU1hu', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUko1eE81TjFKS2lieEk0RkZidHpJeXhTYTc0R0t2VTN3RTFpSEJZNSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761547542),
('hflGzMGYneow6aQu1mmcjsicUS3lKQQhWc0j7Yjq', NULL, '104.164.126.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia0RpYW1Ec0VsTkZONGJGaGtXQ0Z6WVJ6OXI2VUw3ZGswbkc5QlZvWCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552467),
('iFyNwVIpcEZLcNgBOwV7bzZqJtn9JqlqRb3yvRID', NULL, '43.157.181.189', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic2I2Wk9sYTFqZGF4OERjYmJLTU1IQVExN0padmc4RXIzZHE3aElDNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761551885),
('LcFUcJ8IT4FtbRuzw5vGPpxxmBnkcm6d8Gokknaj', NULL, '2a03:b0c0:1:d0::d83:3001', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWZYd2hQaEhtbE5jOWRHcWhMeFJUSUN2YXVoQjRwNmFXWGszbXRuWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552463),
('LlRwklQH5Es8XZQxsIaSSVzZ5BqJc1fJg8oBqh1y', NULL, '139.59.211.157', 'Mozilla/5.0 (compatible; Odin; https://docs.getodin.com/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickVaWlQxTzV3bk5XZlVHV054UzdzWVozdjkybm9BeVFKUXVnOEdmeSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761549461),
('Mhq892vXKMPIPyYitYpATBT74RZX5SCuLxaneE6j', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ0JaSzRaekpxM2F5WUFEVlcxY1cxU3RGbkRUcm9nSVZhZ2xEMnRFdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761554313),
('njqHjYocUqEU7Qw45BiQve0KlmqjbGs8iD7lcGIc', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMGtMU25GbnZHdUx1QWZnUlBtVjBRbTdldTZOa2RCcVRNdlA2eXBRNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761551811),
('OLqo2eapR6XEcsfVXEHSaHuoaaZZmNdjvNQfbdXo', NULL, '106.75.129.228', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWNHdER5WThLM1piMzVSYTBPNDdLV1Iwc1Q4WjlLbWZsSExFT25IMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552472),
('pJt7ie1D4MnLYJcqDfiWBJlafIH85Y8AqFHsLcVD', NULL, '182.44.9.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWdlS3lHdWdoSEtBTGVFVTdjem03c1B2YzV1Y0owWmxTaE5MZWhpMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761551873),
('plKtvkPFIxWcOMP44hopRSTL09scpicOt0j2nEBi', NULL, '104.164.173.181', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2ZLRkpvZnlwNkVTWE9VODVycU43dmFtRVJUR0VXTE1UYk1GQlFoaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552474),
('qpfyIatPimFpyZeZwwykFzipKF0fWyBZ9tC4zjoj', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (X11; Linux x86_64; rv:120.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTTRaTzJZY1hkenRBcHdpUko3dzE5cW5OcG5PdDA2UDFqRmlqNmx6NSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMDoiaHR0cDovL2ludGVsYm9hcmQuY2EiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761552463),
('Qs111sDawAt8zyMK7TaBvRhkxZ5O6ew3nX0V819x', NULL, '206.189.2.13', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM2JJdGdEZnBTWVZ1SUhiek5jZXl0WlZ6RXNYVk93VVUwWHFTWGxYNSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552465),
('rBFQmTDauh08wYAR7oGncDDQBrNbNFBeKRIho4ES', NULL, '2a05:9403::5f9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3dqUTJYYzNPU25mb2JnbW1jSUg4SndWM2dTZWRzSGhjYjVPVjlYRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552465),
('Rxff2RP27Ji5blJ3ddc2AaCLD0FKrXO2727U0UEd', NULL, '206.189.2.13', 'Go-http-client/1.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiampySVZDUThGazY2eUEyNGtIVnRjTGJkZERQdkNORkg1MElOVzZyaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhLz9yZXN0X3JvdXRlPSUyRndwJTJGdjIlMkZ1c2VycyUyRiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU1OiJodHRwczovL2ludGVsYm9hcmQuY2EvP3Jlc3Rfcm91dGU9JTJGd3AlMkZ2MiUyRnVzZXJzJTJGIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761552475),
('SEOoNX9GmkQMXNrllIvQvu6RihwJIpjJF9xXyVK1', NULL, '2a03:b0c0:1:d0::d83:3001', 'Mozilla/5.0 (Linux; Android 6.0; HTC One M9 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.3', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTI4RU1qRjlsdDZzc0Vpb3pQMkZpQ2xqS1VPU0Z4RTJrSHprYWxNbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552463),
('Ts7ixbHoKd4MK1XM6rJ17sIgiTnnLfQ2mBgQRRFC', NULL, '106.75.129.228', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczZGUmRVVE9JZ0N6UU5oTzVSSDQxazlTbTlZYllNd05sVEh1WjdkbCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761552470),
('uDZLxoufMeLADoqHSWkii8dSKpbKCGIuXodh9ShZ', NULL, '164.90.166.254', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYUhXQ2pMczlFeVZ6UVdWTFEzaXNzZ0hDeVMzb3dxaU5oM3V1YmVPUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761549460),
('ufpeax9IycU0Iqa7GMFCmLz1f66aPr0H5rxZPMiG', NULL, '165.227.152.100', 'Go-http-client/1.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYndBS2pQalo5eURJalo0N3F5V0hJemdZU1dnWkg1bnJGTVN5TFMyWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761552865),
('uqOJioQmXza0RcpY8BOPa4H8lGbetvyrDrqyBHBU', NULL, '124.236.100.56', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOUpGN2xWbjd0OEp1WmVIcDVmOFVwRWUyYU5Ua0FySnZnNDRzRENVViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761555273),
('uZky52TWJKuUKNg0ty7MvCGGv3nbkNeIhXzCG3iz', NULL, '203.55.131.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibTFnMUhRS3JwdjlOMm1aMEIwdjhvYlNKZUZ0VnJPaWpCUThHd1VuRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761554609),
('WW8rhyMQJzSN2LBEcssBwUmxbprF8TrcpjXnZ3nu', NULL, '164.90.166.254', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUWdEWnpCemR0ZzhxOUtIZUY4U2N2WWhVSHJBSmJTNHZKalpyeDM2NiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761549461),
('xDnkZFoBwEu23RIFjmRdo9IGyRs3lAIvTyjs5HAL', NULL, '93.174.93.12', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWlBQRkFBclByTjdDRUZCOWtCRDAwUzY1UVljakx3NFdOb2JsZTY0RSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761554806),
('XjtCArU5agEDkVSdiNCuNoNkDjEey0ZqmEux3yzh', 1, '69.156.139.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHM3SGVkSU9WcXo4aEloYkJuRkpTQWdkZlN3Zm9PQXhQMU5CbnloMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9kcml2ZXJzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1761554579);

-- --------------------------------------------------------

--
-- Table structure for table `stats_cache`
--

CREATE TABLE `stats_cache` (
  `id` bigint UNSIGNED NOT NULL,
  `broker_id` bigint UNSIGNED NOT NULL,
  `week_number` int NOT NULL,
  `year` int NOT NULL,
  `total_invoices` int NOT NULL DEFAULT '0',
  `total_parcels` int NOT NULL DEFAULT '0',
  `total_income` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_paid_invoices` int NOT NULL DEFAULT '0',
  `total_unpaid_invoices` int NOT NULL DEFAULT '0',
  `top_driver_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stats_cache`
--

INSERT INTO `stats_cache` (`id`, `broker_id`, `week_number`, `year`, `total_invoices`, `total_parcels`, `total_income`, `total_paid_invoices`, `total_unpaid_invoices`, `top_driver_id`, `created_at`, `updated_at`) VALUES
(1, 1, 43, 2025, 0, 0, 0.00, 0, 0, NULL, '2025-10-24 02:41:50', '2025-10-24 02:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `broker_id` bigint UNSIGNED NOT NULL,
  `subscription_type_id` bigint UNSIGNED NOT NULL,
  `stripe_subscription_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `started_at` date NOT NULL,
  `ends_at` date NOT NULL,
  `price_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `broker_id`, `subscription_type_id`, `stripe_subscription_id`, `stripe_status`, `started_at`, `ends_at`, `price_paid`, `auto_renew`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '', '', '2025-10-24', '2025-10-31', 0.00, 1, NULL, NULL),
(2, 6, 5, NULL, 'active', '2025-01-01', '2026-01-01', 0.00, 1, '2025-10-27 01:51:42', '2025-10-27 01:51:42'),
(3, 7, 5, NULL, 'active', '2025-01-01', '2026-01-01', 0.00, 1, '2025-10-27 01:51:42', '2025-10-27 01:51:42'),
(4, 8, 5, NULL, 'active', '2025-01-01', '2026-01-01', 0.00, 1, '2025-10-27 01:51:42', '2025-10-27 01:51:42'),
(5, 9, 5, NULL, 'active', '2025-01-01', '2026-01-01', 0.00, 1, '2025-10-27 01:51:42', '2025-10-27 01:51:42'),
(6, 10, 5, NULL, 'active', '2025-01-01', '2026-01-01', 0.00, 1, '2025-10-27 01:51:42', '2025-10-27 01:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_leads`
--

CREATE TABLE `subscription_leads` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_type_id` bigint UNSIGNED DEFAULT NULL,
  `plan_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `plan_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_types`
--

CREATE TABLE `subscription_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_drivers` int NOT NULL DEFAULT '0',
  `add_supervisor` tinyint(1) NOT NULL DEFAULT '0',
  `custom_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stripe_plan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_types`
--

INSERT INTO `subscription_types` (`id`, `name`, `max_drivers`, `add_supervisor`, `custom_invoice`, `price`, `stripe_plan_id`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 10, 0, 0, 0.00, NULL, NULL, NULL),
(2, 'Gold', 50, 0, 1, 0.00, NULL, NULL, NULL),
(5, 'Diamond', 99999, 1, 1, 0.00, NULL, '2025-10-24 02:37:22', '2025-10-24 02:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '3',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_tier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `name`, `full_name`, `email`, `password`, `phone_number`, `role`, `created_by`, `joining_date`, `active`, `company_name`, `logo`, `subscription_tier`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '114634045411504954961', 'Ismail Merdjaoui', 'Ismail Merdjaoui', 'imerdjaouicad@gmail.com', '$2y$12$J10Jv6l9cPm2bBhC7TkmLuPs1k7Gb7dNaSbHddOM5DxV6uo/XJqW.', '5144490082', 1, NULL, '2025-01-01', 1, 'IB', 'storage/logos/pwzDvZUcCTiANAdlir6umS16BJAFOV9tcjH9dMY9.png', NULL, 'RKzAWkk67YrjjDQfAaLoVOAassJATjqRAZ9DP6oboymbp4t52KAMRdo1aGcf', '2025-07-31 23:57:35', '2025-10-25 15:56:42'),
(6, '109234560409604613623', 'Smash', 'Smash', '4smash4smash4@gmail.com', '$2y$12$jWXMpk9ZUp0nsMc7fVbFfuKAPXwlH1brdNR/0ofGlzZLdOSczay3u', '1111111111', 2, NULL, '2025-09-12', 1, NULL, NULL, NULL, 'XijxjIXKVv6hbElJJjn3mdjQNLWW75ZxiTy6UfbONObnOTDyZkYmFiY4ghbw', '2025-09-12 01:09:24', '2025-09-14 05:26:41'),
(7, '101557308229015615231', 'Ismail', 'Ismail', '4dash4dash4@gmail.com', '$2y$12$.zIdEw5hy8T3bAoBQZF2eOaz4xfx.CvnSl.EMK79ecJBVzFoyXlEi', '5144490082', 2, NULL, '2025-09-14', 1, 'IntelDelivery', NULL, NULL, 'XI9FN78bM9PybL4vCK3KGKkMrrJTpWTTpGLcHYcqx275YHvp1env4FFRZXGw', '2025-09-14 03:09:33', '2025-09-25 05:05:43'),
(8, '100920902517758655832', 'Johnny Bux', 'Johnny Bux', 'buxjohnny@gmail.com', '$2y$12$GAFd6zWS.95LF3IFYbeg.eT87dk5wpeZxvtP7NP6B5WX4pjRKrxqG', '5144496016', 2, NULL, '2025-09-14', 1, '9004-QUEBEC INC', NULL, NULL, 'bv1k76IVgV9XY48FQFgtBSounsOP5OaQyFcyoZcoI5EXnusUM6CvBjIWydew', '2025-09-14 05:35:17', '2025-09-14 05:35:17'),
(9, NULL, 'BuxBunny', 'BuxBunny', 'ytmbux@gmail.com', '$2y$12$NnY5IIhecVscQa/HTzgj4ug4CxUGQDakjHtZxOWSujK5UmZ27QWP.', '5144490082', 2, NULL, '2025-09-14', 1, NULL, NULL, NULL, NULL, '2025-09-14 06:00:05', '2025-09-14 06:00:05'),
(10, '108961666098500871789', 'Ismail', 'Ismail', '4gitpilotyo@gmail.com', '$2y$12$h6ZNHpzGsFUJiRw18kJpk.Dbm6N0VEnEjVj/Lf0kfWWkJ.I9GCgOm', '5144433434', 2, NULL, '2025-09-25', 1, 'Intelbaord', NULL, NULL, 'eg3Otxv4jpiI6qg59jl7CW848F1HFDZDAm6GtaUoGn3BLlScJBvtnu4UQHBr', '2025-09-25 05:06:06', '2025-09-25 22:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `login_at` timestamp NOT NULL,
  `browser` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `login_at`, `browser`, `ip_address`, `device`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-10-24 04:26:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '69.156.139.54', 'desktop', NULL, '2025-10-24 04:26:02', '2025-10-24 04:26:02'),
(2, 1, '2025-10-24 04:30:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '69.156.139.54', 'desktop', NULL, '2025-10-24 04:30:44', '2025-10-24 04:30:44'),
(3, 1, '2025-10-27 04:50:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '69.156.139.54', 'desktop', NULL, '2025-10-27 04:50:10', '2025-10-27 04:50:10'),
(4, 1, '2025-10-27 05:59:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '69.156.139.54', 'desktop', NULL, '2025-10-27 05:59:51', '2025-10-27 05:59:51'),
(5, 1, '2025-10-27 08:17:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '69.156.139.54', 'desktop', NULL, '2025-10-27 08:17:53', '2025-10-27 08:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `language` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EN',
  `theme` enum('light','dark') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'light',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_preferences`
--

INSERT INTO `user_preferences` (`id`, `user_id`, `language`, `theme`, `created_at`, `updated_at`) VALUES
(1, 1, 'en', 'dark', '2025-10-24 04:24:10', '2025-10-25 15:46:02'),
(2, 6, 'en', 'light', '2025-10-24 06:00:02', '2025-10-24 06:00:02'),
(3, 7, 'en', 'light', '2025-10-24 06:00:02', '2025-10-24 06:00:02'),
(4, 8, 'en', 'light', '2025-10-24 06:00:03', '2025-10-24 06:00:03'),
(5, 9, 'en', 'light', '2025-10-24 06:00:03', '2025-10-24 06:00:03'),
(6, 10, 'en', 'light', '2025-10-24 06:00:03', '2025-10-24 06:00:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_driver_id_unique` (`driver_id`),
  ADD KEY `drivers_created_by_foreign` (`created_by`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_broker_id_foreign` (`broker_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_broker_id_week_number_index` (`broker_id`,`week_number`),
  ADD KEY `invoices_driver_id_index` (`driver_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stats_cache`
--
ALTER TABLE `stats_cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stats_cache_top_driver_id_foreign` (`top_driver_id`),
  ADD KEY `stats_cache_broker_id_week_number_year_index` (`broker_id`,`week_number`,`year`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_broker_id_foreign` (`broker_id`),
  ADD KEY `subscriptions_subscription_type_id_foreign` (`subscription_type_id`);

--
-- Indexes for table `subscription_leads`
--
ALTER TABLE `subscription_leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_leads_subscription_type_id_foreign` (`subscription_type_id`);

--
-- Indexes for table `subscription_types`
--
ALTER TABLE `subscription_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activity_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_preferences_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stats_cache`
--
ALTER TABLE `stats_cache`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscription_leads`
--
ALTER TABLE `subscription_leads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_types`
--
ALTER TABLE `subscription_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stats_cache`
--
ALTER TABLE `stats_cache`
  ADD CONSTRAINT `stats_cache_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stats_cache_top_driver_id_foreign` FOREIGN KEY (`top_driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_subscription_type_id_foreign` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscription_leads`
--
ALTER TABLE `subscription_leads`
  ADD CONSTRAINT `subscription_leads_subscription_type_id_foreign` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
