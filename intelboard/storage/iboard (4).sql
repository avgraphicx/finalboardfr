-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2025 at 01:57 AM
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
-- Database: `iboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `brokers`
--

CREATE TABLE `brokers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_tier` enum('bronze','silver','gold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bronze',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subscription_type_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brokers`
--

INSERT INTO `brokers` (`id`, `user_id`, `company_name`, `logo`, `subscription_tier`, `created_at`, `updated_at`, `subscription_type_id`) VALUES
(1, 7, 'IntelDelivery', 'company_logos/PjLIHtuxN6eeeWrgBrxZXNNsFSrJO5ecDCnbrtyD.png', 'bronze', '2025-09-14 03:31:59', '2025-09-14 03:31:59', 1),
(2, 8, '9004-QUEBEC INC', NULL, 'bronze', '2025-09-14 05:58:40', '2025-09-14 05:58:40', 1),
(3, 10, 'Intelbaord', NULL, 'bronze', '2025-09-25 05:06:18', '2025-09-25 05:06:18', 1),
(4, 1, 'IB', NULL, 'gold', NULL, NULL, 1);

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
-- Table structure for table `calculations`
--

CREATE TABLE `calculations` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `week_number` int NOT NULL,
  `total_invoice` decimal(10,2) DEFAULT NULL,
  `parcel_rows_count` int DEFAULT NULL,
  `vehicule_rental_price` decimal(10,2) DEFAULT NULL,
  `broker_percentage` decimal(5,2) NOT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  `cash_advance` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calculation_logs`
--

CREATE TABLE `calculation_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `calculation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `total_invoice` decimal(10,2) DEFAULT NULL,
  `parcel_rows_count` int DEFAULT NULL,
  `vehicule_rental_price` decimal(10,2) DEFAULT NULL,
  `broker_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) DEFAULT NULL,
  `cash_advance` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'update',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_percentage` decimal(5,2) DEFAULT NULL,
  `default_rental_price` decimal(10,2) DEFAULT NULL,
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `full_name`, `phone_number`, `driver_id`, `license_number`, `ssn`, `default_percentage`, `default_rental_price`, `added_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Ismail Merdjaoui', '5144490082', 'U9622', 'MERDXXXXXXXXX', '123456781', 25.00, 60.00, 1, 1, '2025-08-02 21:39:36', '2025-10-21 20:04:08'),
(28, 'Elody Mitchell', '5142813155', 'V3521', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(29, 'Melisa Larkin', '5143672782', 'V4270', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(30, 'Demond Macejkovic', '5142670703', 'Y1966', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(31, 'Darryl Labadie', '5144208821', 'U4855', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(32, 'Tressie Bednar', '5144113606', 'X4181', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(33, 'Dennis Blanda', '5147923269', 'Z7119', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(34, 'Chelsea Hirthe', '5149573716', 'Y6614', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(35, 'Cindy Schroeder', '5146775435', 'X9620', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(36, 'Jude Veum', '5145031241', 'U8573', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(37, 'Margaretta Lynch', '5145142436', 'Z4250', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(38, 'Virgie Heathcote', '5144054009', 'X6888', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(39, 'Hardy Beatty', '5141595358', 'Z5742', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(40, 'Billy Spinka', '5142123075', 'V8393', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(41, 'Marquise Fahey', '5148668133', 'X8399', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(42, 'Brook Cormier', '5146588344', 'V5827', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(43, 'Delores Kunde', '5145538133', 'Y7590', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(44, 'Emily Powlowski', '5145993345', 'X3552', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(46, 'Gracie Rowe', '5145388474', 'W5360', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(47, 'Felix Kuhlman', '5142552813', 'X1345', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(48, 'Anastasia Christiansen', '5144021990', 'V7586', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(49, 'Nick Tromp', '5147517837', 'Y6543', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(50, 'Luigi Labadie', '5144399486', 'V1004', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(51, 'Estell Metz', '5145325917', 'U1011', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(52, 'Ramiro Skiles', '5142393319', 'W6787', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(53, 'Cielo O\'Conner', '5144193672', 'Z2046', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(54, 'Cooper Douglas', '5145521038', 'Z9940', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(55, 'Margarette Ryan', '5147159854', 'X5831', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(56, 'Demond Kuphal', '5149929721', 'W1833', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(57, 'Pamela McCullough', '5145590915', 'Z9387', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(58, 'Gust Streich', '5148014732', 'W9261', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(59, 'Gregory Muller', '5147425993', 'U7187', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(60, 'Sonya Turner', '5143536166', 'Y3374', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(61, 'Jennyfer Jakubowski', '5146383869', 'W7780', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(62, 'Elenor Hahn', '5146593934', 'Z5989', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(63, 'Vickie Mayer', '5146547995', 'U8367', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(64, 'Ron Hettinger', '5147633965', 'W3195', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(65, 'Monroe Block', '5145745031', 'V6545', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(66, 'Filomena Torp', '5143312719', 'Y1491', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(67, 'Imani Bernhard', '5149452835', 'V4210', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(68, 'Cruz Pagac', '5146362412', 'W9776', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(69, 'Barbara Swift', '5146955991', 'Z3765', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(70, 'Nat Bergnaum', '5146830975', 'X4464', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(71, 'Ashleigh Wiegand', '5141169297', 'Z6685', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(72, 'Palma Dibbert', '5142589030', 'W4669', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(73, 'Westley Koss', '5143941442', 'Z5792', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(74, 'Veronica Kautzer', '5142328777', 'Z6434', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(75, 'Jarred Nicolas', '5148283820', 'Z4672', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(76, 'Kamille Schimmel', '5149145947', 'Z3578', NULL, NULL, 25.00, 60.00, NULL, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(77, 'Roselyn Jaskolski', '5141419607', 'V8197', NULL, NULL, 25.00, 60.00, 1, 1, '2025-10-14 01:24:05', '2025-10-14 01:24:05'),
(78, 'Youcef Mehidi', '5144496016', 'U9700', 'MERDXXXXXXXX5', '423675981', 20.00, 30.00, 1, 1, '2025-10-15 00:51:36', '2025-10-15 00:51:36'),
(79, 'Sofiane Rekia', '5144497070', 'U9566', 'MERDXXXXXXXX5', '354189610', 20.00, 30.00, 1, 1, '2025-10-15 00:52:02', '2025-10-15 00:52:02'),
(82, 'Sophie Belanger', '4381239835', 'V4434', 'H70891986101868', '797743211', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(83, 'Alex Belanger', '4381236271', 'V0923', 'E82401983101898', '856000377', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(84, 'Julie Gauthier', '4381233058', 'V4000', 'F55851986101882', '186146696', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(85, 'Emma Lavoie', '4381237510', 'V7797', 'B82651984101837', '657198404', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(86, 'Lucas Gauthier', '4381239198', 'W0316', 'X27802005101865', '452968375', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(87, 'Liam Bouchard', '4381230168', 'W2203', 'Y70562002101899', '901125711', 25.00, 60.00, 1, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(88, 'Julie Tremblay', '4381233503', 'W3313', 'Z74361996101878', '792426274', 25.00, 60.00, 6, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(89, 'Lucas Morin', '4381231955', 'W3450', 'C67782003101812', '610428846', 25.00, 60.00, 6, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28'),
(90, 'Noah Bouchard', '4381237074', 'V8155', 'A24472001101834', '200318446', 25.00, 60.00, 6, 1, '2025-10-18 15:24:28', '2025-10-18 15:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `week` int NOT NULL,
  `for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `broker_id` bigint UNSIGNED NOT NULL,
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
-- Table structure for table `file_usage`
--

CREATE TABLE `file_usage` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_usage`
--

INSERT INTO `file_usage` (`id`, `filename`, `used`, `last_used_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'app/Providers/AppServiceProvider.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(2, 'app/Models/User.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(3, 'app/Models/Driver.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(4, 'app/Http/Middleware/CheckUserRole.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(5, 'app/Http/Middleware/SetLocale.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(6, 'app/Http/Controllers/AuthController.php', 0, NULL, '2025-10-15 05:34:59', '2025-10-15 05:34:59', NULL),
(7, 'app/Http/Controllers/Controller.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL),
(8, 'app/Http/Controllers/DriverController.php', 1, '2025-10-15 06:02:45', '2025-10-15 05:34:59', '2025-10-15 06:02:45', NULL);

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
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(7, '2023_08_02_213218_create_drivers_table', 2),
(11, '2025_08_30_003713_add_week_column_to_calculations_table', 4),
(12, '2025_08_30_003825_add_week_column_to_calculations_table', 4),
(13, '2025_08_29_233040_create_calculations_table', 5),
(14, '2025_08_29_233147_create_calculation_logs_table', 6),
(15, '2025_08_31_020918_alter_drivers_nullable_using_sql', 7),
(16, '2025_09_02_013452_add_google_id_to_users_table', 8),
(17, '2025_09_08_030857_create_brokers_table', 9),
(18, '2025_09_08_030857_create_subscriptions_table', 9),
(19, '2025_09_11_085847_add_default_fields_to_drivers_table', 10),
(20, '2025_09_14_032736_add_users_broker_id_foreign_key', 11),
(21, '2025_09_14_040716_add_social_auth_columns_to_users_table', 12),
(22, '2025_05_20_000000_create_file_usage_table', 13),
(23, '2025_10_17_034349_create_payments_table', 14),
(24, '2025_10_18_083815_add_total_parcels_to_payments_table', 15),
(25, '2025_10_18_091121_add_broker_cuts_to_payments_table', 16),
(26, '2025_10_18_120000_add_paid_to_payments_table', 17),
(27, '2025_10_18_135109_create_subscription_type_table', 18),
(28, '2025_10_18_135314_add_columns_to_subscription_type_table', 19),
(29, '2025_10_18_143034_add_subscription_type_id_to_brokers_table', 20),
(30, '2025_10_18_143630_populate_subscription_type_id_in_brokers_table', 21),
(31, '2025_10_20_000000_create_weeks_table', 22),
(32, '2025_10_20_000001_add_year_to_payments_table', 23),
(33, '2025_10_20_000002_modify_week_number_and_drop_year', 24),
(34, '2025_10_20_000003_update_weeks_table_add_week_days', 25),
(35, '2025_10_20_000001_add_warehouse_to_payments_table', 26),
(36, '2025_10_20_000002_add_warehouse_id_to_payments_table', 27),
(37, '2025_10_23_000000_create_expenses_table', 28);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `week_number` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` bigint UNSIGNED DEFAULT NULL,
  `total_invoice` decimal(10,2) NOT NULL,
  `parcel_rows_count` int NOT NULL DEFAULT '0',
  `total_parcels` int DEFAULT NULL,
  `vehicule_rental_price` decimal(10,2) DEFAULT NULL,
  `broker_percentage` decimal(10,2) DEFAULT NULL,
  `broker_van_cut` decimal(10,2) DEFAULT NULL,
  `broker_pay_cut` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_advance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `final_amount` decimal(10,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `paid_at` timestamp NULL DEFAULT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `driver_id`, `week_number`, `warehouse`, `warehouse_id`, `total_invoice`, `parcel_rows_count`, `total_parcels`, `vehicule_rental_price`, `broker_percentage`, `broker_van_cut`, `broker_pay_cut`, `bonus`, `cash_advance`, `final_amount`, `paid`, `paid_at`, `pdf_path`, `created_at`, `updated_at`) VALUES
(287, 82, '2025-36', 'MONT', NULL, 962.66, 2, 507, 60.00, 25.00, 120.00, 240.67, 0.00, 0.00, 602.00, 0, NULL, 'payments/V4434_2025-36_MONT-xZdpAQ.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(288, 85, '2025-37', 'MONT', NULL, 443.65, 2, 243, 60.00, 25.00, 120.00, 110.91, 0.00, 0.00, 212.74, 0, NULL, 'payments/V7797_2025-37_MONT-aaQTxz.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(289, 79, '2025-37', 'MONT', NULL, 1310.46, 5, 757, 30.00, 20.00, 150.00, 262.09, 0.00, 0.00, 898.37, 0, NULL, 'payments/U9566_2025-37_MONT-446LgB.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(290, 87, '2025-37', 'MONT', NULL, 1525.46, 5, 830, 60.00, 25.00, 300.00, 381.37, 0.00, 0.00, 844.10, 0, NULL, 'payments/W2203_2025-37_MONT-7YSmPG.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(291, 82, '2025-37', 'MONT', NULL, 494.53, 1, 254, 60.00, 25.00, 60.00, 123.63, 0.00, 0.00, 310.90, 0, NULL, 'payments/V4434_2025-37_MONT-e5ZLFy.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(292, 83, '2025-37', 'JOLI', NULL, 586.72, 2, 314, 60.00, 25.00, 120.00, 146.68, 0.00, 0.00, 320.04, 0, NULL, 'payments/V0923_2025-37_JOLI-1McpJ7.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(293, 78, '2025-37', 'MONT', NULL, 2174.12, 5, 1185, 30.00, 20.00, 150.00, 434.82, 0.00, 0.00, 1589.30, 0, NULL, 'payments/U9700_2025-37_MONT-9EV25m.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(294, 88, '2025-37', 'MONT', NULL, 402.51, 3, 272, 60.00, 25.00, 180.00, 100.63, 0.00, 0.00, 121.88, 0, NULL, 'payments/W3313_2025-37_MONT-WKE4Lj.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(295, 89, '2025-37', 'MONT', NULL, 1471.11, 4, 816, 60.00, 25.00, 240.00, 367.78, 0.00, 0.00, 863.33, 0, NULL, 'payments/W3450_2025-37_MONT-Kqvw1W.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(296, 86, '2025-37', 'JOLI', NULL, 382.66, 1, 198, 60.00, 25.00, 60.00, 95.67, 0.00, 0.00, 227.00, 0, NULL, 'payments/W0316_2025-37_JOLI-10Dfho.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(297, 88, '2025-38', 'MONT', NULL, 1308.89, 5, 761, 60.00, 25.00, 300.00, 327.22, 0.00, 0.00, 681.67, 0, NULL, 'payments/W3313_2025-38_MONT-tDLzng.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(298, 78, '2025-39', 'RIDP', NULL, 44.85, 1, 27, 30.00, 20.00, 30.00, 8.97, 0.00, 0.00, 5.88, 0, NULL, 'payments/U9700_2025-39_RIDP-1syzw6.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(299, 84, '2025-39', 'MONT', NULL, 1607.39, 4, 830, 60.00, 25.00, 240.00, 401.85, 0.00, 0.00, 965.54, 0, NULL, 'payments/V4000_2025-39_MONT-cv3zes.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(300, 84, '2025-38', 'MONT', NULL, 2681.80, 6, 1493, 60.00, 25.00, 360.00, 670.45, 0.00, 0.00, 1651.35, 0, NULL, 'payments/V4000_2025-38_MONT-chBQyJ.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(301, 89, '2025-38', 'MONT', NULL, 1907.09, 6, 1129, 60.00, 25.00, 360.00, 476.77, 0.00, 0.00, 1070.32, 0, NULL, 'payments/W3450_2025-38_MONT-YwWXgF.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(302, 78, '2025-38', 'MONT', NULL, 2243.01, 5, 1244, 30.00, 20.00, 150.00, 448.60, 0.00, 0.00, 1644.41, 0, NULL, 'payments/U9700_2025-38_MONT-E2FFtj.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(303, 86, '2025-38', 'JOLI', NULL, 1051.11, 3, 529, 60.00, 25.00, 180.00, 262.78, 0.00, 0.00, 608.33, 0, NULL, 'payments/W0316_2025-38_JOLI-shmaWq.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(304, 87, '2025-38', 'RIDP', NULL, 93.93, 1, 53, 60.00, 25.00, 60.00, 23.48, 0.00, 0.00, 10.45, 0, NULL, 'payments/W2203_2025-38_RIDP-rD7GOG.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(305, 87, '2025-38', 'MONT', NULL, 781.78, 3, 474, 60.00, 25.00, 180.00, 195.45, 0.00, 0.00, 406.34, 0, NULL, 'payments/W2203_2025-38_MONT-BerTbq.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(306, 79, '2025-39', 'MONT', NULL, 1232.18, 3, 704, 30.00, 20.00, 90.00, 246.44, 0.00, 0.00, 895.74, 0, NULL, 'payments/U9566_2025-39_MONT-CjzXl9.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(307, 84, '2025-39', 'RIDP', NULL, 76.30, 1, 45, 60.00, 25.00, 60.00, 19.08, 0.00, 0.00, -2.78, 0, NULL, 'payments/V4000_2025-39_RIDP-3iTMOw.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(308, 84, '2025-40', 'MONT', NULL, 2195.77, 5, 1222, 60.00, 25.00, 300.00, 548.94, 0.00, 0.00, 1346.83, 0, NULL, 'payments/V4000_2025-40_MONT-Dl4RnX.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(309, 89, '2025-40', 'MONT', NULL, 2724.40, 6, 1674, 60.00, 25.00, 360.00, 681.10, 0.00, 0.00, 1683.30, 0, NULL, 'payments/W3450_2025-40_MONT-Rj7b7m.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(310, 79, '2025-40', 'MONT', NULL, 1472.69, 4, 822, 30.00, 20.00, 120.00, 294.54, 0.00, 0.00, 1058.15, 0, NULL, 'payments/U9566_2025-40_MONT-FQ8J2Z.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(311, 78, '2025-40', 'MONT', NULL, 2070.69, 5, 1166, 30.00, 20.00, 150.00, 414.14, 0.00, 0.00, 1506.55, 0, NULL, 'payments/U9700_2025-40_MONT-LAy2NM.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(312, 90, '2025-40', 'MONT', NULL, 345.95, 1, 180, 60.00, 25.00, 60.00, 86.49, 0.00, 0.00, 199.46, 0, NULL, 'payments/V8155_2025-40_MONT-k57D2t.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(313, 88, '2025-40', 'MONT', NULL, 1863.43, 5, 1019, 60.00, 25.00, 300.00, 465.86, 0.00, 0.00, 1097.57, 0, NULL, 'payments/W3313_2025-40_MONT-Z8k1gg.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(314, 82, '2025-35', 'MONT', NULL, 463.10, 1, 239, 60.00, 25.00, 60.00, 115.78, 0.00, 0.00, 287.33, 0, NULL, 'payments/V4434_2025-35_MONT-ZokKW4.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(315, 85, '2025-35', 'MONT', NULL, 98.04, 1, 55, 60.00, 25.00, 60.00, 24.51, 0.00, 0.00, 13.53, 0, NULL, 'payments/V7797_2025-35_MONT-joyz4B.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(316, 78, '2025-35', 'MONT', NULL, 2958.00, 6, 1640, 30.00, 20.00, 180.00, 591.60, 0.00, 0.00, 2186.40, 0, NULL, 'payments/U9700_2025-35_MONT-yjtI0e.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(317, 86, '2025-35', 'MONT', NULL, 1047.04, 3, 638, 60.00, 25.00, 180.00, 261.76, 0.00, 0.00, 605.28, 0, NULL, 'payments/W0316_2025-35_MONT-j84E9W.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(318, 87, '2025-35', 'RIDP', NULL, 38.20, 1, 22, 60.00, 25.00, 60.00, 9.55, 0.00, 0.00, -31.35, 0, NULL, 'payments/W2203_2025-35_RIDP-sIwhjF.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(319, 79, '2025-35', 'MONT', NULL, 2567.71, 6, 1460, 30.00, 20.00, 180.00, 513.54, 0.00, 0.00, 1874.17, 0, NULL, 'payments/U9566_2025-35_MONT-jRvugx.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(320, 87, '2025-35', 'MONT', NULL, 1025.20, 5, 584, 60.00, 25.00, 300.00, 256.30, 0.00, 0.00, 468.90, 0, NULL, 'payments/W2203_2025-35_MONT-wThbPi.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(321, 78, '2025-32', 'MONT', NULL, 1707.39, 5, 1084, 30.00, 20.00, 150.00, 341.48, 0.00, 0.00, 1215.91, 0, NULL, 'payments/U9700_2025-32_MONT-Kb1gOU.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(322, 85, '2025-32', 'MONT', NULL, 136.40, 1, 70, 60.00, 25.00, 60.00, 34.10, 0.00, 0.00, 42.30, 0, NULL, 'payments/V7797_2025-32_MONT-8UOJVf.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(323, 86, '2025-32', 'JOLI', NULL, 966.92, 3, 484, 60.00, 25.00, 180.00, 241.73, 0.00, 0.00, 545.19, 0, NULL, 'payments/W0316_2025-32_JOLI-zNPKor.pdf', '2025-10-21 15:41:47', '2025-10-21 15:41:47'),
(324, 1, '2025-32', 'MONT', NULL, 2120.07, 5, 1147, 60.00, 25.00, 300.00, 530.02, 0.00, 0.00, 1290.05, 1, '2025-10-23 16:09:15', 'payments/U9622_2025-32_MONT-cAVQmI.pdf', '2025-10-21 15:42:20', '2025-10-23 16:09:15');

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
('0Kicx9XqUMPtYCt88MFLvoGwlQeHRMNxfLCJpv3V', NULL, '45.153.34.54', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkxuQ0JKdHQwMTFtYVFMZXRpRUx1NGR2ZXl4SzUxN0tRZUNZaHlZNSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761232213),
('1Q7pHt7xtyffNU2jPhu5CGaeYpj5U614SozNAP0U', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaERBTjY5YkExMFY1ZzV2V3hwOUdwcnJoc0tzSVZoZmhvS0E4R2VwdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761259573),
('1TA6M7CE2gA7BrkSCcbI4LHoZpOnakP7ExtUdVy4', NULL, '45.156.128.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHRjYWw5emtmS1BhQmNsSlpCcDltT1RWa0tKWk4wSlNjZ3c3amFmYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761239049),
('1yxNBfdNW50DLIUYXv88ljt3J4fLGoTDGfe9iiJg', NULL, '167.71.133.68', 'Mozilla/5.0 zgrab/0.x', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHVjdVc2V2M4ZG1PRjFmdThvWUl6TUx0R0JQNUdYTGxIWUY3eXJFdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761253159),
('2CnIaaRBaR74gquDF59OAMmvQyKcBBV8UNjFmQB3', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSG56S0RWWUJGNUpobE9tbWVsNXNqbGtxVnBuMUJBYUVTVTVUNk9tUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761266611),
('2iptIpw3PzhQTLO9xnOnFr38sv1rL4WmjSoWZJ8N', NULL, '147.185.132.222', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMG5YNE96a2pFdWRjeVRYSFNrOVZ4WE5waUJtU040REZQZDg3aGJJNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761241922),
('2jgTZByFZhFZEqVAnXdbtVwg15xeK2qkXPWJM1vA', NULL, '47.53.185.217', 'libredtail-http', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQVlteGtQbDBuTXJtbWk1U0EySG5MdUgwY1dUOFBNcUxLbnl3ZHJlUCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOTg6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwPyUyRiUzQyUzRmVjaG8lMjhtZDUlMjglMjJoaSUyMiUyOSUyOSUzQiUzRiUzRSUyMCUyRnRtcCUyRmluZGV4MS5waHA9JmNvbmZpZy1jcmVhdGUlMjAlMkY9Jmxhbmc9Li4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRnVzciUyRmxvY2FsJTJGbGliJTJGcGhwJTJGcGVhcmNtZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5ODoiaHR0cDovLzUxLjc5Ljg2LjI0Mi9pbmRleC5waHA/JTJGJTNDJTNGZWNobyUyOG1kNSUyOCUyMmhpJTIyJTI5JTI5JTNCJTNGJTNFJTIwJTJGdG1wJTJGaW5kZXgxLnBocD0mY29uZmlnLWNyZWF0ZSUyMCUyRj0mbGFuZz0uLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGdXNyJTJGbG9jYWwlMkZsaWIlMkZwaHAlMkZwZWFyY21kIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761240226),
('3RpZ7tuYTDbDWiN7lYkteQHEPFHHNa3Gb4nwXB0J', 1, '69.156.139.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUzBvMXJ5aUJiUEFYOTFJRkxxUDVscFVuMEViY242TUE3SEpUMDhxNSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhL3BheW1lbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761260038),
('4fs9LhPcF4Pbky2npV7O7zauh4zSXBCHzLDpgWej', 1, '69.156.139.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUGdBM3VtTHZXWEJUUFQ1S1dGWVBCTnVkRzNteFAxbjg1cFFadFZLRiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhL3BheW1lbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZnIiO30=', 1761238135),
('85fKnWYO5CkwTFV0Xy6OUhkxsFNPNpyG0C3D6vyc', NULL, '223.15.245.170', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieE90S2JBWDFZNjNxSm9xd081QzhTUDhCU29PQWFEYWgyempVVEFNVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250244),
('9rkJWyOJajmBzlrVC7ovohG0sEzVKfR3dbnpX6mq', NULL, '46.226.162.162', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1UydkEzUTJRUmR4V1FMVXd2ZzlHc1Y0ZUlJWHBEcUFkeUVDakE4TiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761245184),
('9vgDWtkQBrcMhJNv61XrB6tLKRvQF9FynLEfC4c2', NULL, '2620:96:e000::10c', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVhiMnQ4aXF5cGlGUTRJZ2k2V3RwU2pkaUZEVm94NEZYQ3I2YUFtNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761242597),
('Ah2F8z8f188NnJgWXbd10VkYd7W4J0x01CoQgrcO', NULL, '54.244.40.200', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVlJveWJJazZPR2oxRUUxaWV4N1BTcTVMdERVWVpoWGs2Uzc1dXU3diI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250979),
('bcKE1hkvlSjeoGWttmJ8je9EQ1qOoOp3TY79c4Lj', NULL, '168.76.20.229', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36 QIHU 360SE', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidnhaSVU5ZWtDQVNNdnpGS0lvZDhWd1ZWc200RTJ2RkR2WmM1UGZXdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761259036),
('c2dU6gNE2GFgqMabp2Yk10cisUkBlTLP4IsU8Ppw', NULL, '185.242.226.98', 'Python/3.7 aiohttp/3.8.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaURYemxxaVRNbU9DRHk3elo3Tmg3V2NCQm9CRVY3Z2RkYWtpYkZHTyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761233679),
('d5JlMtPhh2zSEth17xGPcWedIfq0fBt6PqVOhupu', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWTk4WVVrTnVTUzhHN0pIR0tQRmtMWmFFZXBGbnBsN2pUTkw5SDJVMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761255685),
('dRmQ4GD3nZCKs5doU8VMCOCcSJBIZ9n1pXLHqdVa', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDQxb1JPYzJQaGlrQlhGcFpLRUdCdFl0VW0zTUFQZ1RzbHZoVXFZeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761246679),
('du6DqPqILoApVtNjhDR8rYmGKGY6aMPSdQnDzioK', NULL, '47.53.185.217', 'libredtail-http', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUF2V1ZGVUZXdnlaVjEyTnY0eVRQcmZzREptVmE3MWtxdHE2MjJsTyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxNDU6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwP2Z1bmN0aW9uPWNhbGxfdXNlcl9mdW5jX2FycmF5JnM9JTJGaW5kZXglMkYlNUN0aGluayU1Q2FwcCUyRmludm9rZWZ1bmN0aW9uJnZhcnMlNUIwJTVEPW1kNSZ2YXJzJTVCMSU1RCU1QjAlNUQ9SGVsbG8iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxNDU6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwP2Z1bmN0aW9uPWNhbGxfdXNlcl9mdW5jX2FycmF5JnM9JTJGaW5kZXglMkYlNUN0aGluayU1Q2FwcCUyRmludm9rZWZ1bmN0aW9uJnZhcnMlNUIwJTVEPW1kNSZ2YXJzJTVCMSU1RCU1QjAlNUQ9SGVsbG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761240226),
('EfASC8P7bNGRkSr3JNkxyrUmH3hzgcghgo18ayxu', NULL, '223.15.245.170', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS21WYTlHYWZOZ2lpbDBFZDk5bWhJdmlJaElQRjl1YXdzUk4xWEhMaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250241),
('EIHNQhnL2hfoZSFnOzZcJc43hwyFpTA798CPzcxr', NULL, '79.124.40.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFhPUkhrY3d5bFVIOXFUeGpLbmpCU2FHcUppWWt6T1RldFgyOVdUciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761256281),
('F20ytqgPRquUGasbzISE1UIs7nHbm9IMBsVjFwOt', NULL, '45.156.128.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTGk5UUJBZm9aZzZ6VVhuMXJqUmRxRVoxcjFYWTRibE5ISEJBcWN5cCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761239867),
('FSEfXUpviZpwEJEoogEdprO9xZKIl30QWHVKnUSd', NULL, '147.185.132.222', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY05HRXM4TlB5UDFZVzNjSkEyVktWa0ZjR3hQaVprSXlsSHB5bmNwaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761241922),
('GbmrCkzhxBH5eEOU80tci6vCLYxw8bPakBItQYrc', 1, '2605:8d80:7503:4fc6:dd2:15f9:c18d:e0c8', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Brave/1 Version/26.0.1 Safari/605.1.15', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWkFodE1qRGFMVnY5TE0zZnMyU21MenNidzVxOTh6YmVjQm56UHhxdSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwczovL2ludGVsYm9hcmQuY2EvcHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761236455),
('GGg3xE2iE6UCHtkNa2NmNg8JfGWQXIYerrchNIyz', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUnpOdmJUbmhocFNpYllsOWVQa3FsVXZpZTVqM2RTTUo5ZGZYeHZNNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761237332),
('hTYt0un4IBGYjiT4xBSpqsf3slS9hoRwC0QuKqmC', NULL, '54.244.40.200', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXN6ZTBvZGJmZ2tQS0VOYXo2OHVxTUdHdE1QM043aGVrWHk5SEZkSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250978),
('HxI28UV2Wb5A2TOUEwGtaHhRETwbpbojukDGiIBl', 1, '69.156.139.54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUnVCa1lLeWRjaU9HM1QwZlQybVJvMXR3b050NkdJcHJXd2RKZTVvVCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhL2RyaXZlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761269054),
('IaPwD66CpjpeUBuwSdncQeIrsbb0AmMEKIm2rZuV', NULL, '176.32.195.85', 'Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmhGcnBaaTEzV0MxM25KV25NdjVXdXJWN3RuYldpbWdvMzM4b0ZSVCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761236580),
('INmJrXSv0dRBjdYMVUdi0L94dPWBILH0T24maXH5', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSEhGYkRKTk5uR3drYWN2V3NIdER5Um0zWXZERHI5M3NOR05sWm9XZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761252853),
('IQZfJq9IoygwCaz51Z4GXC5IartFaFanUmJoIeto', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXpMU0ozcEI1TXhDZllNOGxObzFWMVZoeVdkYmhSRVNoaDFUWktXNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761262153),
('iuxhpr5ByltFWDXwmEVY5lL4wHS90AHj6HBsho1D', NULL, '202.170.91.69', 'Mozilla/5.0 (Windows NT 10.0; WOW64; iPhone) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.4904.125 Safari/537.36 HuaweiCrawler', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFh5cmlwd0pNUDF6eFF6Y2FUVmtNUU5kV0lnNFF3YTIxVEk2a0pkNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761232373),
('JG5cV088ZgDUzQ2B3tq07fVkT2P6aPc1hDv47oDQ', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU3ZrdGdEamlQbjRQdlNzQUlUZHZVSG9OQmVQWkw5bVNvaXViOHBWbSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761236952),
('kNkcvCJIClwbjhYcniS7ekz42ERrEnDvGscMsv3I', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVmJ0dTNvVzM0UlhaYk5MeDMycXltS1NjYzBJWk1hN1loY1BYWXQ5cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761264406),
('KQU9kKXzbApENft0kwkfuWbJwTamlbFtKbmjLnHo', NULL, '2620:96:e000::10c', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUVucEhHbHlac090QXZrYUZQbGZvMmlyNWpQdlJMcVdKbkhiTGR3cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761242622),
('kR41pQZ8Ow6mMtWkAsso9KG9mgsIPHKzROvWpUzF', NULL, '185.247.137.115', 'Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTUZlNE5zQ0E5amdRMnE3NnpNTk4yUkFPUTJyRDhTRzMwdTgyTDFRVCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761262524),
('KyrWGfwrY52TbF24RKix5cekkpPMajEWF8aj3lQP', NULL, '34.79.94.233', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWk3MEQ0Q1RGWUlKNTFrOVdCVXdsUG0xWFRwNGNIY3h1SHRlZEV2OCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250606),
('lnZE8DiD5k3r5J4SNMW1l3R0D8AFmTjp6iA41Z6d', NULL, '54.156.67.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidGY0SHk3ZWVRMkM1ckNnb1FNNUNwUkdJOGxKb25tczNmWVRkSUE4RCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761232390),
('LqQWkrFLG0SGceVAekJgOUQXi0XIlOu194UZIOqQ', NULL, '2602:80d:1006::22', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTFSMGdmaldBUkR4N2pjRWxuQ0RBZlNSY3d0eDVsTlZXY3dXSHNyNyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761263469),
('lRAwHRE4tWeVS2eZMQbRVYlLBSCT73DSkazL54yH', NULL, '3.83.134.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoialliWHpVamltY3M2SUFMTGtYWGhwNzdDeHJMcVNpODZIVURJVkxUaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761237820),
('mfDnZ3CC7FLq6A5DI4zyOsM0HglK77ZWWDOwfnHV', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia3dLVmpnSmQxbzNHS3FIN2I5ZnYzaHdqTVBiS0hUaVZQNHUwa282bCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761261190),
('mPdojJXjmeet97PQF8dP2oWVavT7uCSg1HejlzPn', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGZkZ21OMlJGOWZoaHNlUkRCNkk2SkxGMDI5OE91M1U4eXRXZDRnUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761268700),
('N8fNRITr8U4oxn7SZBD3n1z6lNJXXo16IIhvCHuB', NULL, '185.247.137.115', 'Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2lzUDhLM1hqRnZrS1Zycm00Q016UnVWRkx5Q01RV1NZVWRWWmJ0TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761262525),
('NaGuFLnhF1eIAwfLM7sPlUtawn1hllZM46KDdGI3', NULL, '54.244.40.200', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoienM2Vmc3c3NYdndjMERRMTM4QVl1cWU3clJPMEFXdHEyYU9oMEtDbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250978),
('nBkeqXKeI1IMmdlNeV5Q6QgfrWFH77DjZaHCrw8C', NULL, '47.53.185.217', 'libredtail-http', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOHJUc3VuNDE2U0poNjdsUW1qd21hSjVYMUM1bFlUZUFIM0FjcjVRSyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxNDU6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwP2Z1bmN0aW9uPWNhbGxfdXNlcl9mdW5jX2FycmF5JnM9JTJGaW5kZXglMkYlNUN0aGluayU1Q2FwcCUyRmludm9rZWZ1bmN0aW9uJnZhcnMlNUIwJTVEPW1kNSZ2YXJzJTVCMSU1RCU1QjAlNUQ9SGVsbG8iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxNDU6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwP2Z1bmN0aW9uPWNhbGxfdXNlcl9mdW5jX2FycmF5JnM9JTJGaW5kZXglMkYlNUN0aGluayU1Q2FwcCUyRmludm9rZWZ1bmN0aW9uJnZhcnMlNUIwJTVEPW1kNSZ2YXJzJTVCMSU1RCU1QjAlNUQ9SGVsbG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761240222),
('om241THE1AoHDg4ktanEffpHF0XfuCchSZOpt5Z8', NULL, '202.170.91.69', 'Mozilla/5.0 (Windows NT 10.0; WOW64; iPhone) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.4904.125 Safari/537.36 HuaweiCrawler', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0hXU1NaSzVkMktqZTdha3lHeDhVSnFSb1hGZFdVMXNHTVBxMktXbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761232373),
('ONToZbbIhIkq7WPszPV0YMdVYEPOUZt5tyJ4hKgz', NULL, '47.53.185.217', 'libredtail-http', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGNoM1ljQXZ0ZHJrSGlQQjFVZHFVVXRjS0tjZWdXa3hKUTdpdlY5SCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4NzoiaHR0cDovLzUxLjc5Ljg2LjI0Mi9pbmRleC5waHA/bGFuZz0uLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGdG1wJTJGaW5kZXgxIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODc6Imh0dHA6Ly81MS43OS44Ni4yNDIvaW5kZXgucGhwP2xhbmc9Li4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRnRtcCUyRmluZGV4MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761240226),
('osm5iAh09gGkZHA5CFvTgDZIXQpXSaX7w5BcXVDR', NULL, '79.124.40.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmJ4MkdxSWNwUzlIb0hGWFVRVkVJYWdvTjF0R2doeWl4MlJtV1dDRCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MjoiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhLz9YREVCVUdfU0VTU0lPTl9TVEFSVD1waHBzdG9ybSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUyOiJodHRwczovL2ludGVsYm9hcmQuY2EvP1hERUJVR19TRVNTSU9OX1NUQVJUPXBocHN0b3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761256274),
('psQwPwJvV1kUkYcuwjpLrK6m8TmxuxI1wBqSd5yY', NULL, '135.237.125.195', 'Mozilla/5.0 zgrab/0.x', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQUllMkwzMmNtZ0FRNVE1ZkpwN0ZjOHQ0WHU3UHZXRjQzTUVLdU9hayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761256094),
('Q9GJaTGnnuBzW9H4Td9qjYWrqoa3DnXc5f8UsT2m', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUHpmSUlQMnNQRHdGNFlBYXhkeFpjV0lYeTE2aGxsM09TenJGY2FxeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761244206),
('qKBAmSe6qBQaDGrBCopEEJTq6SaPtH8Gvfacg0Bm', NULL, '54.244.40.200', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0k5MU9tQ0NmZnVnZ2JpcXFlaVRSRGNpSUlIcGQ0eXdpczVlbDVVcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761250979),
('qUjzUjkkiMy2eGbFZmBTGV1RV930mj9zUZEq8xrK', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2xXbHZHREk2WjlwZUVPS2d1UjB3akZWV09ybVF2QXp2WUdFck1IOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761232119),
('Qvo7lgxODE90UX97Icd56LO2bYSqd5BLVerJtDjt', NULL, '202.170.91.69', 'Java/1.8.0_322', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieG83am1MVjdOejZuaUNVc1Rxb3BvTmJhTndxcTlXdmlBWDNkSEhjUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761232372),
('RMjzgQqAdSQ5G6wafjtAkZkFiuPJj1jFrqwYPOwu', NULL, '2602:80d:1006::22', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2pMNWdiTTNFMExVMFlQVHZsNkVCTUpwVjRuYlJid1BjSnFPaUt1NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vaW50ZWxib2FyZC5jYS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761263504),
('TtnDZYVYYOGjZDtz1C8nYkwQVgK2xzeN7m9vyjLa', NULL, '45.156.128.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVlqRHRFMHVPYVBDN1l1WVo5OFR6UjJBM2xrdEpzWGFoa0pKZFlWTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vaW50ZWxib2FyZC5jYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761239048),
('U8PFgCORSERB1JRMO5kWW92ZNM5XuPp76OU9duIm', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZzZjanFVYWNLN2N1bFJYb0xmU0FOUjRXSmlWWkJEeU42NE9aZ2c4MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761241778),
('ulJAecpfE2OqvliedmzzTra7Xfga0JIm8h21LiQR', NULL, '178.134.42.162', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/601.7.7 (KHTML, like Gecko) Version/9.1.2 Safari/601.7.7', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSDRBTFo5dk1tZVEwUnE0UTNLVGw4OVQyYU5zaFZscVFEWjF2ZUVUWCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761247422),
('VSKgODQq2hCPck9zWb7dIkSsMmSHbBPvgUhwflvt', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibW1heExnM0l1TXBEaXk1RHkwWFAzN0ZWZ1Z6WWptVGVZMFRJRWpWSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761248408),
('W5tJ1SUymiX73yWRCXbksGTXvjpNlLLJOYlZPAzI', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkV2QTZ6Nmh4MTNxbGNvdXZYWW1aZFpwWVJCVUdDYW1xRFltcGdWMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761241663),
('xaA9yRHKJcllbiJM48DOQ2SdQQO28QSV6DVf61Fg', NULL, '198.235.24.126', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYWZET2VOUExjM2tlc0p6WXRpZ3ZMRDdNeHliTWVUbjBOemJlMjE3OSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4OiJodHRwOi8vXyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjg6Imh0dHA6Ly9fIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761258557),
('XB2QluIV8tDp4pTWq62zIJvTXW5oizkVJaf0MqVF', NULL, '49.0.237.195', 'Java/1.8.0_322', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXBuYmRHQzYxQ2VBWWFiYTVKZWlRcG5UVUc1U015WFB3T3NQOHRaRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cHM6Ly9pbnRlbGJvYXJkLmNhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761232371),
('yALucLQI4DzMk1jB93DibanG0Yl9H5t7Qknj5sJp', NULL, '87.121.84.17', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVRSU3pwRzYwTjYwdml2NEtXanJCZm1YeGxxaXo1cTVNeWNFQVIxMyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761234755),
('yoeKsjtAwmMoxekF6OgjQw0IblSsCHN247gr79dS', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVnViVlNJY3VrSHRIYmk4RUxwbEFPeXVTb0hIWUo5enJNR29jSnNpQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761252028),
('YYZ9uOQuRg1t4jhGqmWMa3KkWgbS1icdZ1qy2dIt', NULL, '168.76.20.229', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.2623.112 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkJabEtyN0ZKNnIxTTVFNmNkRzBmeWpUcEltbTAwQWJjRTNCUGtuayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cDovLzUxLjc5Ljg2LjI0MiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE5OiJodHRwOi8vNTEuNzkuODYuMjQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761259035);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `broker_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `broker_id`, `name`, `stripe_id`, `stripe_status`, `stripe_plan`, `subscription_id`, `total_price`, `trial_ends_at`, `created_at`, `updated_at`, `ends_at`) VALUES
(1, 4, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-31 15:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_type`
--

CREATE TABLE `subscription_type` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_files` int NOT NULL DEFAULT '10',
  `add_supervisor` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_drivers` int NOT NULL DEFAULT '10',
  `custom_invoice` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_type`
--

INSERT INTO `subscription_type` (`id`, `name`, `max_files`, `add_supervisor`, `created_at`, `updated_at`, `max_drivers`, `custom_invoice`) VALUES
(1, 'Bronze', 1, 0, NULL, NULL, 10, 0),
(2, 'Gold', 10, 0, NULL, NULL, 50, 1),
(5, 'Diamond', 99999, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 99999, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','broker','supervisor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'broker',
  `broker_id` bigint UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined_date` date NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `reset_password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expiry` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `full_name`, `email`, `phone_number`, `role`, `broker_id`, `password`, `joined_date`, `status`, `last_login_at`, `email_verified_at`, `reset_password_token`, `reset_token_expiry`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '114634045411504954961', 'Ismail Merdjaoui', 'imerdjaouicad@gmail.com', '5144490082', 'admin', NULL, '$2y$12$J10Jv6l9cPm2bBhC7TkmLuPs1k7Gb7dNaSbHddOM5DxV6uo/XJqW.', '2025-01-01', 'active', '2025-10-20 05:30:24', '2025-09-15 20:55:49', NULL, NULL, 'HOZIoPJmGIlgbUhfPJitOYJoclN6a0Z4HIE1NmmWEEVeUpDAErxa13PW7jI2', '2025-07-31 23:57:35', '2025-10-20 05:30:24'),
(6, '109234560409604613623', 'Smash', '4smash4smash4@gmail.com', '1111111111', 'broker', NULL, '$2y$12$jWXMpk9ZUp0nsMc7fVbFfuKAPXwlH1brdNR/0ofGlzZLdOSczay3u', '2025-09-12', 'active', '2025-09-14 05:26:41', '2025-09-14 04:28:15', NULL, NULL, 'XijxjIXKVv6hbElJJjn3mdjQNLWW75ZxiTy6UfbONObnOTDyZkYmFiY4ghbw', '2025-09-12 01:09:24', '2025-09-14 05:26:41'),
(7, '101557308229015615231', 'Ismail', '4dash4dash4@gmail.com', '5144490082', 'broker', NULL, '$2y$12$.zIdEw5hy8T3bAoBQZF2eOaz4xfx.CvnSl.EMK79ecJBVzFoyXlEi', '2025-09-14', 'active', '2025-09-25 05:05:43', '2025-09-14 04:34:23', NULL, NULL, 'XI9FN78bM9PybL4vCK3KGKkMrrJTpWTTpGLcHYcqx275YHvp1env4FFRZXGw', '2025-09-14 03:09:33', '2025-09-25 05:05:43'),
(8, '100920902517758655832', 'Johnny Bux', 'buxjohnny@gmail.com', '5144496016', 'broker', NULL, '$2y$12$GAFd6zWS.95LF3IFYbeg.eT87dk5wpeZxvtP7NP6B5WX4pjRKrxqG', '2025-09-14', 'active', '2025-09-14 05:35:17', '2025-09-14 05:35:17', NULL, NULL, 'bv1k76IVgV9XY48FQFgtBSounsOP5OaQyFcyoZcoI5EXnusUM6CvBjIWydew', '2025-09-14 05:35:17', '2025-09-14 05:35:17'),
(9, NULL, 'BuxBunny', 'ytmbux@gmail.com', '5144490082', 'broker', NULL, '$2y$12$NnY5IIhecVscQa/HTzgj4ug4CxUGQDakjHtZxOWSujK5UmZ27QWP.', '2025-09-14', 'active', '2025-09-14 06:00:05', NULL, NULL, NULL, NULL, '2025-09-14 06:00:05', '2025-09-14 06:00:05'),
(10, '108961666098500871789', 'Ismail', '4gitpilotyo@gmail.com', '5144433434', 'broker', NULL, '$2y$12$h6ZNHpzGsFUJiRw18kJpk.Dbm6N0VEnEjVj/Lf0kfWWkJ.I9GCgOm', '2025-09-25', 'active', '2025-09-25 22:18:02', '2025-09-25 05:06:06', NULL, NULL, 'eg3Otxv4jpiI6qg59jl7CW848F1HFDZDAm6GtaUoGn3BLlScJBvtnu4UQHBr', '2025-09-25 05:06:06', '2025-09-25 22:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `weeks`
--

CREATE TABLE `weeks` (
  `id` bigint UNSIGNED NOT NULL,
  `week` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monday` date DEFAULT NULL,
  `tuesday` date DEFAULT NULL,
  `wednesday` date DEFAULT NULL,
  `thursday` date DEFAULT NULL,
  `friday` date DEFAULT NULL,
  `saturday` date DEFAULT NULL,
  `sunday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weeks`
--

INSERT INTO `weeks` (`id`, `week`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(1, '2025-01', '2024-12-30', '2024-12-31', '2025-01-01', '2025-01-02', '2025-01-03', '2025-01-04', '2025-01-05'),
(2, '2025-02', '2025-01-06', '2025-01-07', '2025-01-08', '2025-01-09', '2025-01-10', '2025-01-11', '2025-01-12'),
(3, '2025-03', '2025-01-13', '2025-01-14', '2025-01-15', '2025-01-16', '2025-01-17', '2025-01-18', '2025-01-19'),
(4, '2025-04', '2025-01-20', '2025-01-21', '2025-01-22', '2025-01-23', '2025-01-24', '2025-01-25', '2025-01-26'),
(5, '2025-05', '2025-01-27', '2025-01-28', '2025-01-29', '2025-01-30', '2025-01-31', '2025-02-01', '2025-02-02'),
(6, '2025-06', '2025-02-03', '2025-02-04', '2025-02-05', '2025-02-06', '2025-02-07', '2025-02-08', '2025-02-09'),
(7, '2025-07', '2025-02-10', '2025-02-11', '2025-02-12', '2025-02-13', '2025-02-14', '2025-02-15', '2025-02-16'),
(8, '2025-08', '2025-02-17', '2025-02-18', '2025-02-19', '2025-02-20', '2025-02-21', '2025-02-22', '2025-02-23'),
(9, '2025-09', '2025-02-24', '2025-02-25', '2025-02-26', '2025-02-27', '2025-02-28', '2025-03-01', '2025-03-02'),
(10, '2025-10', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06', '2025-03-07', '2025-03-08', '2025-03-09'),
(11, '2025-11', '2025-03-10', '2025-03-11', '2025-03-12', '2025-03-13', '2025-03-14', '2025-03-15', '2025-03-16'),
(12, '2025-12', '2025-03-17', '2025-03-18', '2025-03-19', '2025-03-20', '2025-03-21', '2025-03-22', '2025-03-23'),
(13, '2025-13', '2025-03-24', '2025-03-25', '2025-03-26', '2025-03-27', '2025-03-28', '2025-03-29', '2025-03-30'),
(14, '2025-14', '2025-03-31', '2025-04-01', '2025-04-02', '2025-04-03', '2025-04-04', '2025-04-05', '2025-04-06'),
(15, '2025-15', '2025-04-07', '2025-04-08', '2025-04-09', '2025-04-10', '2025-04-11', '2025-04-12', '2025-04-13'),
(16, '2025-16', '2025-04-14', '2025-04-15', '2025-04-16', '2025-04-17', '2025-04-18', '2025-04-19', '2025-04-20'),
(17, '2025-17', '2025-04-21', '2025-04-22', '2025-04-23', '2025-04-24', '2025-04-25', '2025-04-26', '2025-04-27'),
(18, '2025-18', '2025-04-28', '2025-04-29', '2025-04-30', '2025-05-01', '2025-05-02', '2025-05-03', '2025-05-04'),
(19, '2025-19', '2025-05-05', '2025-05-06', '2025-05-07', '2025-05-08', '2025-05-09', '2025-05-10', '2025-05-11'),
(20, '2025-20', '2025-05-12', '2025-05-13', '2025-05-14', '2025-05-15', '2025-05-16', '2025-05-17', '2025-05-18'),
(21, '2025-21', '2025-05-19', '2025-05-20', '2025-05-21', '2025-05-22', '2025-05-23', '2025-05-24', '2025-05-25'),
(22, '2025-22', '2025-05-26', '2025-05-27', '2025-05-28', '2025-05-29', '2025-05-30', '2025-05-31', '2025-06-01'),
(23, '2025-23', '2025-06-02', '2025-06-03', '2025-06-04', '2025-06-05', '2025-06-06', '2025-06-07', '2025-06-08'),
(24, '2025-24', '2025-06-09', '2025-06-10', '2025-06-11', '2025-06-12', '2025-06-13', '2025-06-14', '2025-06-15'),
(25, '2025-25', '2025-06-16', '2025-06-17', '2025-06-18', '2025-06-19', '2025-06-20', '2025-06-21', '2025-06-22'),
(26, '2025-26', '2025-06-23', '2025-06-24', '2025-06-25', '2025-06-26', '2025-06-27', '2025-06-28', '2025-06-29'),
(27, '2025-27', '2025-06-30', '2025-07-01', '2025-07-02', '2025-07-03', '2025-07-04', '2025-07-05', '2025-07-06'),
(28, '2025-28', '2025-07-07', '2025-07-08', '2025-07-09', '2025-07-10', '2025-07-11', '2025-07-12', '2025-07-13'),
(29, '2025-29', '2025-07-14', '2025-07-15', '2025-07-16', '2025-07-17', '2025-07-18', '2025-07-19', '2025-07-20'),
(30, '2025-30', '2025-07-21', '2025-07-22', '2025-07-23', '2025-07-24', '2025-07-25', '2025-07-26', '2025-07-27'),
(31, '2025-31', '2025-07-28', '2025-07-29', '2025-07-30', '2025-07-31', '2025-08-01', '2025-08-02', '2025-08-03'),
(32, '2025-32', '2025-08-04', '2025-08-05', '2025-08-06', '2025-08-07', '2025-08-08', '2025-08-09', '2025-08-10'),
(33, '2025-33', '2025-08-11', '2025-08-12', '2025-08-13', '2025-08-14', '2025-08-15', '2025-08-16', '2025-08-17'),
(34, '2025-34', '2025-08-18', '2025-08-19', '2025-08-20', '2025-08-21', '2025-08-22', '2025-08-23', '2025-08-24'),
(35, '2025-35', '2025-08-25', '2025-08-26', '2025-08-27', '2025-08-28', '2025-08-29', '2025-08-30', '2025-08-31'),
(36, '2025-36', '2025-09-01', '2025-09-02', '2025-09-03', '2025-09-04', '2025-09-05', '2025-09-06', '2025-09-07'),
(37, '2025-37', '2025-09-08', '2025-09-09', '2025-09-10', '2025-09-11', '2025-09-12', '2025-09-13', '2025-09-14'),
(38, '2025-38', '2025-09-15', '2025-09-16', '2025-09-17', '2025-09-18', '2025-09-19', '2025-09-20', '2025-09-21'),
(39, '2025-39', '2025-09-22', '2025-09-23', '2025-09-24', '2025-09-25', '2025-09-26', '2025-09-27', '2025-09-28'),
(40, '2025-40', '2025-09-29', '2025-09-30', '2025-10-01', '2025-10-02', '2025-10-03', '2025-10-04', '2025-10-05'),
(41, '2025-41', '2025-10-06', '2025-10-07', '2025-10-08', '2025-10-09', '2025-10-10', '2025-10-11', '2025-10-12'),
(42, '2025-42', '2025-10-13', '2025-10-14', '2025-10-15', '2025-10-16', '2025-10-17', '2025-10-18', '2025-10-19'),
(43, '2025-43', '2025-10-20', '2025-10-21', '2025-10-22', '2025-10-23', '2025-10-24', '2025-10-25', '2025-10-26'),
(44, '2025-44', '2025-10-27', '2025-10-28', '2025-10-29', '2025-10-30', '2025-10-31', '2025-11-01', '2025-11-02'),
(45, '2025-45', '2025-11-03', '2025-11-04', '2025-11-05', '2025-11-06', '2025-11-07', '2025-11-08', '2025-11-09'),
(46, '2025-46', '2025-11-10', '2025-11-11', '2025-11-12', '2025-11-13', '2025-11-14', '2025-11-15', '2025-11-16'),
(47, '2025-47', '2025-11-17', '2025-11-18', '2025-11-19', '2025-11-20', '2025-11-21', '2025-11-22', '2025-11-23'),
(48, '2025-48', '2025-11-24', '2025-11-25', '2025-11-26', '2025-11-27', '2025-11-28', '2025-11-29', '2025-11-30'),
(49, '2025-49', '2025-12-01', '2025-12-02', '2025-12-03', '2025-12-04', '2025-12-05', '2025-12-06', '2025-12-07'),
(50, '2025-50', '2025-12-08', '2025-12-09', '2025-12-10', '2025-12-11', '2025-12-12', '2025-12-13', '2025-12-14'),
(51, '2025-51', '2025-12-15', '2025-12-16', '2025-12-17', '2025-12-18', '2025-12-19', '2025-12-20', '2025-12-21'),
(52, '2025-52', '2025-12-22', '2025-12-23', '2025-12-24', '2025-12-25', '2025-12-26', '2025-12-27', '2025-12-28'),
(53, '2026-01', '2025-12-29', '2025-12-30', '2025-12-31', '2026-01-01', '2026-01-02', '2026-01-03', '2026-01-04'),
(54, '2026-02', '2026-01-05', '2026-01-06', '2026-01-07', '2026-01-08', '2026-01-09', '2026-01-10', '2026-01-11'),
(55, '2026-03', '2026-01-12', '2026-01-13', '2026-01-14', '2026-01-15', '2026-01-16', '2026-01-17', '2026-01-18'),
(56, '2026-04', '2026-01-19', '2026-01-20', '2026-01-21', '2026-01-22', '2026-01-23', '2026-01-24', '2026-01-25'),
(57, '2026-05', '2026-01-26', '2026-01-27', '2026-01-28', '2026-01-29', '2026-01-30', '2026-01-31', '2026-02-01'),
(58, '2026-06', '2026-02-02', '2026-02-03', '2026-02-04', '2026-02-05', '2026-02-06', '2026-02-07', '2026-02-08'),
(59, '2026-07', '2026-02-09', '2026-02-10', '2026-02-11', '2026-02-12', '2026-02-13', '2026-02-14', '2026-02-15'),
(60, '2026-08', '2026-02-16', '2026-02-17', '2026-02-18', '2026-02-19', '2026-02-20', '2026-02-21', '2026-02-22'),
(61, '2026-09', '2026-02-23', '2026-02-24', '2026-02-25', '2026-02-26', '2026-02-27', '2026-02-28', '2026-03-01'),
(62, '2026-10', '2026-03-02', '2026-03-03', '2026-03-04', '2026-03-05', '2026-03-06', '2026-03-07', '2026-03-08'),
(63, '2026-11', '2026-03-09', '2026-03-10', '2026-03-11', '2026-03-12', '2026-03-13', '2026-03-14', '2026-03-15'),
(64, '2026-12', '2026-03-16', '2026-03-17', '2026-03-18', '2026-03-19', '2026-03-20', '2026-03-21', '2026-03-22'),
(65, '2026-13', '2026-03-23', '2026-03-24', '2026-03-25', '2026-03-26', '2026-03-27', '2026-03-28', '2026-03-29'),
(66, '2026-14', '2026-03-30', '2026-03-31', '2026-04-01', '2026-04-02', '2026-04-03', '2026-04-04', '2026-04-05'),
(67, '2026-15', '2026-04-06', '2026-04-07', '2026-04-08', '2026-04-09', '2026-04-10', '2026-04-11', '2026-04-12'),
(68, '2026-16', '2026-04-13', '2026-04-14', '2026-04-15', '2026-04-16', '2026-04-17', '2026-04-18', '2026-04-19'),
(69, '2026-17', '2026-04-20', '2026-04-21', '2026-04-22', '2026-04-23', '2026-04-24', '2026-04-25', '2026-04-26'),
(70, '2026-18', '2026-04-27', '2026-04-28', '2026-04-29', '2026-04-30', '2026-05-01', '2026-05-02', '2026-05-03'),
(71, '2026-19', '2026-05-04', '2026-05-05', '2026-05-06', '2026-05-07', '2026-05-08', '2026-05-09', '2026-05-10'),
(72, '2026-20', '2026-05-11', '2026-05-12', '2026-05-13', '2026-05-14', '2026-05-15', '2026-05-16', '2026-05-17'),
(73, '2026-21', '2026-05-18', '2026-05-19', '2026-05-20', '2026-05-21', '2026-05-22', '2026-05-23', '2026-05-24'),
(74, '2026-22', '2026-05-25', '2026-05-26', '2026-05-27', '2026-05-28', '2026-05-29', '2026-05-30', '2026-05-31'),
(75, '2026-23', '2026-06-01', '2026-06-02', '2026-06-03', '2026-06-04', '2026-06-05', '2026-06-06', '2026-06-07'),
(76, '2026-24', '2026-06-08', '2026-06-09', '2026-06-10', '2026-06-11', '2026-06-12', '2026-06-13', '2026-06-14'),
(77, '2026-25', '2026-06-15', '2026-06-16', '2026-06-17', '2026-06-18', '2026-06-19', '2026-06-20', '2026-06-21'),
(78, '2026-26', '2026-06-22', '2026-06-23', '2026-06-24', '2026-06-25', '2026-06-26', '2026-06-27', '2026-06-28'),
(79, '2026-27', '2026-06-29', '2026-06-30', '2026-07-01', '2026-07-02', '2026-07-03', '2026-07-04', '2026-07-05'),
(80, '2026-28', '2026-07-06', '2026-07-07', '2026-07-08', '2026-07-09', '2026-07-10', '2026-07-11', '2026-07-12'),
(81, '2026-29', '2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16', '2026-07-17', '2026-07-18', '2026-07-19'),
(82, '2026-30', '2026-07-20', '2026-07-21', '2026-07-22', '2026-07-23', '2026-07-24', '2026-07-25', '2026-07-26'),
(83, '2026-31', '2026-07-27', '2026-07-28', '2026-07-29', '2026-07-30', '2026-07-31', '2026-08-01', '2026-08-02'),
(84, '2026-32', '2026-08-03', '2026-08-04', '2026-08-05', '2026-08-06', '2026-08-07', '2026-08-08', '2026-08-09'),
(85, '2026-33', '2026-08-10', '2026-08-11', '2026-08-12', '2026-08-13', '2026-08-14', '2026-08-15', '2026-08-16'),
(86, '2026-34', '2026-08-17', '2026-08-18', '2026-08-19', '2026-08-20', '2026-08-21', '2026-08-22', '2026-08-23'),
(87, '2026-35', '2026-08-24', '2026-08-25', '2026-08-26', '2026-08-27', '2026-08-28', '2026-08-29', '2026-08-30'),
(88, '2026-36', '2026-08-31', '2026-09-01', '2026-09-02', '2026-09-03', '2026-09-04', '2026-09-05', '2026-09-06'),
(89, '2026-37', '2026-09-07', '2026-09-08', '2026-09-09', '2026-09-10', '2026-09-11', '2026-09-12', '2026-09-13'),
(90, '2026-38', '2026-09-14', '2026-09-15', '2026-09-16', '2026-09-17', '2026-09-18', '2026-09-19', '2026-09-20'),
(91, '2026-39', '2026-09-21', '2026-09-22', '2026-09-23', '2026-09-24', '2026-09-25', '2026-09-26', '2026-09-27'),
(92, '2026-40', '2026-09-28', '2026-09-29', '2026-09-30', '2026-10-01', '2026-10-02', '2026-10-03', '2026-10-04'),
(93, '2026-41', '2026-10-05', '2026-10-06', '2026-10-07', '2026-10-08', '2026-10-09', '2026-10-10', '2026-10-11'),
(94, '2026-42', '2026-10-12', '2026-10-13', '2026-10-14', '2026-10-15', '2026-10-16', '2026-10-17', '2026-10-18'),
(95, '2026-43', '2026-10-19', '2026-10-20', '2026-10-21', '2026-10-22', '2026-10-23', '2026-10-24', '2026-10-25'),
(96, '2026-44', '2026-10-26', '2026-10-27', '2026-10-28', '2026-10-29', '2026-10-30', '2026-10-31', '2026-11-01'),
(97, '2026-45', '2026-11-02', '2026-11-03', '2026-11-04', '2026-11-05', '2026-11-06', '2026-11-07', '2026-11-08'),
(98, '2026-46', '2026-11-09', '2026-11-10', '2026-11-11', '2026-11-12', '2026-11-13', '2026-11-14', '2026-11-15'),
(99, '2026-47', '2026-11-16', '2026-11-17', '2026-11-18', '2026-11-19', '2026-11-20', '2026-11-21', '2026-11-22'),
(100, '2026-48', '2026-11-23', '2026-11-24', '2026-11-25', '2026-11-26', '2026-11-27', '2026-11-28', '2026-11-29'),
(101, '2026-49', '2026-11-30', '2026-12-01', '2026-12-02', '2026-12-03', '2026-12-04', '2026-12-05', '2026-12-06'),
(102, '2026-50', '2026-12-07', '2026-12-08', '2026-12-09', '2026-12-10', '2026-12-11', '2026-12-12', '2026-12-13'),
(103, '2026-51', '2026-12-14', '2026-12-15', '2026-12-16', '2026-12-17', '2026-12-18', '2026-12-19', '2026-12-20'),
(104, '2026-52', '2026-12-21', '2026-12-22', '2026-12-23', '2026-12-24', '2026-12-25', '2026-12-26', '2026-12-27'),
(105, '2026-53', '2026-12-28', '2026-12-29', '2026-12-30', '2026-12-31', '2027-01-01', '2027-01-02', '2027-01-03'),
(106, '2027-01', '2027-01-04', '2027-01-05', '2027-01-06', '2027-01-07', '2027-01-08', '2027-01-09', '2027-01-10'),
(107, '2027-02', '2027-01-11', '2027-01-12', '2027-01-13', '2027-01-14', '2027-01-15', '2027-01-16', '2027-01-17'),
(108, '2027-03', '2027-01-18', '2027-01-19', '2027-01-20', '2027-01-21', '2027-01-22', '2027-01-23', '2027-01-24'),
(109, '2027-04', '2027-01-25', '2027-01-26', '2027-01-27', '2027-01-28', '2027-01-29', '2027-01-30', '2027-01-31'),
(110, '2027-05', '2027-02-01', '2027-02-02', '2027-02-03', '2027-02-04', '2027-02-05', '2027-02-06', '2027-02-07'),
(111, '2027-06', '2027-02-08', '2027-02-09', '2027-02-10', '2027-02-11', '2027-02-12', '2027-02-13', '2027-02-14'),
(112, '2027-07', '2027-02-15', '2027-02-16', '2027-02-17', '2027-02-18', '2027-02-19', '2027-02-20', '2027-02-21'),
(113, '2027-08', '2027-02-22', '2027-02-23', '2027-02-24', '2027-02-25', '2027-02-26', '2027-02-27', '2027-02-28'),
(114, '2027-09', '2027-03-01', '2027-03-02', '2027-03-03', '2027-03-04', '2027-03-05', '2027-03-06', '2027-03-07'),
(115, '2027-10', '2027-03-08', '2027-03-09', '2027-03-10', '2027-03-11', '2027-03-12', '2027-03-13', '2027-03-14'),
(116, '2027-11', '2027-03-15', '2027-03-16', '2027-03-17', '2027-03-18', '2027-03-19', '2027-03-20', '2027-03-21'),
(117, '2027-12', '2027-03-22', '2027-03-23', '2027-03-24', '2027-03-25', '2027-03-26', '2027-03-27', '2027-03-28'),
(118, '2027-13', '2027-03-29', '2027-03-30', '2027-03-31', '2027-04-01', '2027-04-02', '2027-04-03', '2027-04-04'),
(119, '2027-14', '2027-04-05', '2027-04-06', '2027-04-07', '2027-04-08', '2027-04-09', '2027-04-10', '2027-04-11'),
(120, '2027-15', '2027-04-12', '2027-04-13', '2027-04-14', '2027-04-15', '2027-04-16', '2027-04-17', '2027-04-18'),
(121, '2027-16', '2027-04-19', '2027-04-20', '2027-04-21', '2027-04-22', '2027-04-23', '2027-04-24', '2027-04-25'),
(122, '2027-17', '2027-04-26', '2027-04-27', '2027-04-28', '2027-04-29', '2027-04-30', '2027-05-01', '2027-05-02'),
(123, '2027-18', '2027-05-03', '2027-05-04', '2027-05-05', '2027-05-06', '2027-05-07', '2027-05-08', '2027-05-09'),
(124, '2027-19', '2027-05-10', '2027-05-11', '2027-05-12', '2027-05-13', '2027-05-14', '2027-05-15', '2027-05-16'),
(125, '2027-20', '2027-05-17', '2027-05-18', '2027-05-19', '2027-05-20', '2027-05-21', '2027-05-22', '2027-05-23'),
(126, '2027-21', '2027-05-24', '2027-05-25', '2027-05-26', '2027-05-27', '2027-05-28', '2027-05-29', '2027-05-30'),
(127, '2027-22', '2027-05-31', '2027-06-01', '2027-06-02', '2027-06-03', '2027-06-04', '2027-06-05', '2027-06-06'),
(128, '2027-23', '2027-06-07', '2027-06-08', '2027-06-09', '2027-06-10', '2027-06-11', '2027-06-12', '2027-06-13'),
(129, '2027-24', '2027-06-14', '2027-06-15', '2027-06-16', '2027-06-17', '2027-06-18', '2027-06-19', '2027-06-20'),
(130, '2027-25', '2027-06-21', '2027-06-22', '2027-06-23', '2027-06-24', '2027-06-25', '2027-06-26', '2027-06-27'),
(131, '2027-26', '2027-06-28', '2027-06-29', '2027-06-30', '2027-07-01', '2027-07-02', '2027-07-03', '2027-07-04'),
(132, '2027-27', '2027-07-05', '2027-07-06', '2027-07-07', '2027-07-08', '2027-07-09', '2027-07-10', '2027-07-11'),
(133, '2027-28', '2027-07-12', '2027-07-13', '2027-07-14', '2027-07-15', '2027-07-16', '2027-07-17', '2027-07-18'),
(134, '2027-29', '2027-07-19', '2027-07-20', '2027-07-21', '2027-07-22', '2027-07-23', '2027-07-24', '2027-07-25'),
(135, '2027-30', '2027-07-26', '2027-07-27', '2027-07-28', '2027-07-29', '2027-07-30', '2027-07-31', '2027-08-01'),
(136, '2027-31', '2027-08-02', '2027-08-03', '2027-08-04', '2027-08-05', '2027-08-06', '2027-08-07', '2027-08-08'),
(137, '2027-32', '2027-08-09', '2027-08-10', '2027-08-11', '2027-08-12', '2027-08-13', '2027-08-14', '2027-08-15'),
(138, '2027-33', '2027-08-16', '2027-08-17', '2027-08-18', '2027-08-19', '2027-08-20', '2027-08-21', '2027-08-22'),
(139, '2027-34', '2027-08-23', '2027-08-24', '2027-08-25', '2027-08-26', '2027-08-27', '2027-08-28', '2027-08-29'),
(140, '2027-35', '2027-08-30', '2027-08-31', '2027-09-01', '2027-09-02', '2027-09-03', '2027-09-04', '2027-09-05'),
(141, '2027-36', '2027-09-06', '2027-09-07', '2027-09-08', '2027-09-09', '2027-09-10', '2027-09-11', '2027-09-12'),
(142, '2027-37', '2027-09-13', '2027-09-14', '2027-09-15', '2027-09-16', '2027-09-17', '2027-09-18', '2027-09-19'),
(143, '2027-38', '2027-09-20', '2027-09-21', '2027-09-22', '2027-09-23', '2027-09-24', '2027-09-25', '2027-09-26'),
(144, '2027-39', '2027-09-27', '2027-09-28', '2027-09-29', '2027-09-30', '2027-10-01', '2027-10-02', '2027-10-03'),
(145, '2027-40', '2027-10-04', '2027-10-05', '2027-10-06', '2027-10-07', '2027-10-08', '2027-10-09', '2027-10-10'),
(146, '2027-41', '2027-10-11', '2027-10-12', '2027-10-13', '2027-10-14', '2027-10-15', '2027-10-16', '2027-10-17'),
(147, '2027-42', '2027-10-18', '2027-10-19', '2027-10-20', '2027-10-21', '2027-10-22', '2027-10-23', '2027-10-24'),
(148, '2027-43', '2027-10-25', '2027-10-26', '2027-10-27', '2027-10-28', '2027-10-29', '2027-10-30', '2027-10-31'),
(149, '2027-44', '2027-11-01', '2027-11-02', '2027-11-03', '2027-11-04', '2027-11-05', '2027-11-06', '2027-11-07'),
(150, '2027-45', '2027-11-08', '2027-11-09', '2027-11-10', '2027-11-11', '2027-11-12', '2027-11-13', '2027-11-14'),
(151, '2027-46', '2027-11-15', '2027-11-16', '2027-11-17', '2027-11-18', '2027-11-19', '2027-11-20', '2027-11-21'),
(152, '2027-47', '2027-11-22', '2027-11-23', '2027-11-24', '2027-11-25', '2027-11-26', '2027-11-27', '2027-11-28'),
(153, '2027-48', '2027-11-29', '2027-11-30', '2027-12-01', '2027-12-02', '2027-12-03', '2027-12-04', '2027-12-05'),
(154, '2027-49', '2027-12-06', '2027-12-07', '2027-12-08', '2027-12-09', '2027-12-10', '2027-12-11', '2027-12-12'),
(155, '2027-50', '2027-12-13', '2027-12-14', '2027-12-15', '2027-12-16', '2027-12-17', '2027-12-18', '2027-12-19'),
(156, '2027-51', '2027-12-20', '2027-12-21', '2027-12-22', '2027-12-23', '2027-12-24', '2027-12-25', '2027-12-26'),
(157, '2027-52', '2027-12-27', '2027-12-28', '2027-12-29', '2027-12-30', '2027-12-31', '2028-01-01', '2028-01-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brokers`
--
ALTER TABLE `brokers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brokers_user_id_unique` (`user_id`),
  ADD KEY `brokers_subscription_type_id_foreign` (`subscription_type_id`);

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
-- Indexes for table `calculations`
--
ALTER TABLE `calculations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `calculations_driver_week_unique` (`driver_id`,`week_number`);

--
-- Indexes for table `calculation_logs`
--
ALTER TABLE `calculation_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calculation_logs_calculation_id_index` (`calculation_id`),
  ADD KEY `calculation_logs_user_id_index` (`user_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_driver_id_unique` (`driver_id`),
  ADD KEY `drivers_added_by_foreign` (`added_by`);

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
-- Indexes for table `file_usage`
--
ALTER TABLE `file_usage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_usage_filename_unique` (`filename`),
  ADD KEY `file_usage_used_index` (`used`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_driver_id_foreign` (`driver_id`),
  ADD KEY `payments_driver_id_week_number_warehouse_index` (`driver_id`,`week_number`,`warehouse`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_broker_id_foreign` (`broker_id`);

--
-- Indexes for table `subscription_type`
--
ALTER TABLE `subscription_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_type_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_broker_id_foreign` (`broker_id`);

--
-- Indexes for table `weeks`
--
ALTER TABLE `weeks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weeks_week_unique` (`week`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `calculations`
--
ALTER TABLE `calculations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calculation_logs`
--
ALTER TABLE `calculation_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `file_usage`
--
ALTER TABLE `file_usage`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_type`
--
ALTER TABLE `subscription_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `weeks`
--
ALTER TABLE `weeks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brokers`
--
ALTER TABLE `brokers`
  ADD CONSTRAINT `brokers_subscription_type_id_foreign` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_type` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `brokers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `calculations`
--
ALTER TABLE `calculations`
  ADD CONSTRAINT `calculations_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `calculation_logs`
--
ALTER TABLE `calculation_logs`
  ADD CONSTRAINT `calculation_logs_calculation_id_foreign` FOREIGN KEY (`calculation_id`) REFERENCES `calculations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `calculation_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `brokers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `brokers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_broker_id_foreign` FOREIGN KEY (`broker_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
