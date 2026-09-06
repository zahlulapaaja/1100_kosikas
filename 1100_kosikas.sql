-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 02:23 PM
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
-- Database: `1100_kosikas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agency_name` varchar(100) NOT NULL DEFAULT 'TRAVEL AGENCY',
  `agency_tagline` varchar(150) DEFAULT NULL,
  `pnr` varchar(20) NOT NULL,
  `issued_date` date NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'IDR',
  `total_fare` decimal(14,2) NOT NULL DEFAULT 0.00,
  `fare_note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `agency_name`, `agency_tagline`, `pnr`, `issued_date`, `currency`, `total_fare`, `fare_note`, `created_at`, `updated_at`) VALUES
(1, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'asdasd', '2026-09-02', 'IDR', 20000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-02 09:57:58', '2026-09-05 05:44:57'),
(2, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'abcdee', '2026-09-03', 'IDR', 2000000.00, 'Includes Base Fare, Taxes, Fees and Surcharges', '2026-09-03 03:43:01', '2026-09-03 03:43:01'),
(3, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'EEMPFD', '2026-09-05', 'IDR', 2092160.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-05 14:37:43', '2026-09-05 14:37:43'),
(4, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'EGY59J', '2026-09-05', 'IDR', 2092160.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-05 14:49:49', '2026-09-05 14:51:19'),
(6, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'HMFEFG', '2026-09-05', 'IDR', 2598300.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-05 15:04:57', '2026-09-05 15:04:57'),
(7, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PYMWVK', '2026-09-05', 'IDR', 2517221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-05 15:30:15', '2026-09-05 15:31:48');

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
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `maskapai_id` bigint(20) UNSIGNED NOT NULL,
  `origin_wilayah_id` bigint(20) UNSIGNED NOT NULL,
  `destination_wilayah_id` bigint(20) UNSIGNED NOT NULL,
  `flight_no` varchar(20) NOT NULL,
  `departure_date` date NOT NULL,
  `dep_time` varchar(10) NOT NULL,
  `arr_time` varchar(10) NOT NULL,
  `subclass` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `booking_id`, `maskapai_id`, `origin_wilayah_id`, `destination_wilayah_id`, `flight_no`, `departure_date`, `dep_time`, `arr_time`, `subclass`, `created_at`, `updated_at`) VALUES
(2, 2, 3, 1, 4, '998', '2026-09-04', '20:00', '21:00', 'Y', '2026-09-03 03:43:02', '2026-09-03 03:43:02'),
(3, 2, 6, 12, 2, '8989', '2026-09-04', '22:00', '23:00', 'Y', '2026-09-03 03:43:02', '2026-09-03 03:43:02'),
(4, 1, 5, 1, 2, 'IU 997', '2026-09-25', '20:00', '23:00', 'Y', '2026-09-05 05:44:57', '2026-09-05 05:44:57'),
(5, 3, 2, 1, 2, '0141', '2026-09-08', '11:05', '14:05', 'L', '2026-09-05 14:37:43', '2026-09-05 14:37:43'),
(8, 4, 2, 1, 2, '0141', '2026-09-08', '11:05', '14:05', 'L', '2026-09-05 14:51:19', '2026-09-05 14:51:19'),
(11, 6, 6, 2, 1, '6898', '2026-09-13', '15:15', '18:00', 'L', '2026-09-05 15:29:55', '2026-09-05 15:29:55'),
(14, 7, 8, 2, 1, '342', '2026-09-12', '08:35', '11:25', 'V', '2026-09-05 15:35:02', '2026-09-05 15:35:02');

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
-- Table structure for table `maskapais`
--

CREATE TABLE `maskapais` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code_iata` varchar(10) NOT NULL,
  `code_icao` varchar(10) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maskapais`
--

INSERT INTO `maskapais` (`id`, `name`, `code_iata`, `code_icao`, `group`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Super Air Jet', 'IU', 'SJV', 'Lion Air Group', 'images/airlines/IU.png', '2026-09-02 09:34:01', '2026-09-04 07:34:42'),
(2, 'Garuda Indonesia', 'GA', 'GIA', 'Garuda Indonesia Group', 'images/airlines/GA.png', '2026-09-02 09:34:01', '2026-09-04 07:29:46'),
(3, 'Citilink', 'QG', 'CTV', 'Garuda Indonesia Group', 'images/airlines/QG.png', '2026-09-02 09:34:01', '2026-09-04 07:28:55'),
(4, 'Lion Air', 'JT', 'LNI', 'Lion Air Group', 'images/airlines/JT.webp', '2026-09-02 09:34:01', '2026-09-04 07:30:31'),
(5, 'AirAsia Indonesia', 'QZ', 'AWQ', 'AirAsia Group', 'images/airlines/QZ.webp', '2026-09-02 09:34:01', '2026-09-04 07:26:46'),
(6, 'Batik Air', 'ID', 'BTK', 'Lion Air Group', 'images/airlines/ID.png', '2026-09-02 09:34:01', '2026-09-04 07:28:16'),
(7, 'Wings Air', 'IW', 'WON', 'Lion Air Group', 'images/airlines/IW.webp', '2026-09-02 09:34:02', '2026-09-04 07:37:29'),
(8, 'Pelita Air', 'IP', 'PAS', 'Pelita Air', 'images/airlines/IP.webp', '2026-09-02 09:34:02', '2026-09-04 07:32:25'),
(9, 'Sriwijaya Air', 'SJ', 'SJY', NULL, 'images/airlines/SJ.png', '2026-09-02 09:34:02', '2026-09-04 07:34:08'),
(10, 'NAM Air', 'IN', 'LKN', NULL, 'images/airlines/IN.jpg', '2026-09-02 09:34:02', '2026-09-04 07:36:10'),
(11, 'TransNusa', '8B', 'TNU', NULL, 'images/airlines/8B.png', '2026-09-02 09:34:02', '2026-09-04 07:38:37'),
(12, 'Trigana Air', 'IL', 'TGN', NULL, NULL, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(13, 'Susi Air', 'SI', 'SQS', 'Susi Air', 'images/airlines/SI.png', '2026-09-02 09:34:02', '2026-09-04 07:35:13');

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
(4, '2024_01_01_000001_create_maskapais_table', 1),
(5, '2024_01_01_000002_create_wilayahs_table', 1),
(6, '2024_01_01_000003_create_bookings_table', 1),
(7, '2024_01_01_000004_create_flights_table', 1),
(8, '2024_01_01_000005_create_passengers_table', 1),
(9, '2024_01_01_000006_create_penerbangans_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(10) NOT NULL DEFAULT 'Mr.',
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'Adult',
  `id_number` varchar(50) DEFAULT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `baggage` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `booking_id`, `title`, `name`, `type`, `id_number`, `ticket_number`, `baggage`, `created_at`, `updated_at`) VALUES
(2, 2, 'Mr.', 'Zahlul Fuadi', 'Adult', '1313', '1313', '10Kg', '2026-09-03 03:43:02', '2026-09-03 03:43:02'),
(3, 1, 'Mr.', 'Zahlul Fuadi', 'Adult', '1313', '1313', '10Kg', '2026-09-05 05:44:57', '2026-09-05 05:44:57'),
(4, 3, 'Mr.', 'Adrian Devano', 'Adult', '11', '126 2144619493', '1PC', '2026-09-05 14:37:43', '2026-09-05 14:37:43'),
(7, 4, 'Mr.', 'Darwis Abubakar', 'Adult', '11', '126 2144619494', '1PC', '2026-09-05 14:51:19', '2026-09-05 14:51:19'),
(9, 6, 'Mr.', 'Adrian Devano', 'Adult', NULL, '938 2116675243', '20Kg', '2026-09-05 15:29:55', '2026-09-05 15:29:55'),
(12, 7, 'Mr.', 'Darwis Abubakar', 'Adult', NULL, '7783008904896C1', '20Kg', '2026-09-05 15:35:03', '2026-09-05 15:35:03');

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
-- Table structure for table `penerbangans`
--

CREATE TABLE `penerbangans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wilayah_asal_id` bigint(20) UNSIGNED NOT NULL,
  `wilayah_tujuan_id` bigint(20) UNSIGNED NOT NULL,
  `maskapai_id` bigint(20) UNSIGNED NOT NULL,
  `jam_berangkat` time NOT NULL,
  `jam_sampai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penerbangans`
--

INSERT INTO `penerbangans` (`id`, `wilayah_asal_id`, `wilayah_tujuan_id`, `maskapai_id`, `jam_berangkat`, `jam_sampai`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 7, '06:45:00', '08:20:00', '2026-09-05 16:20:22', '2026-09-05 16:20:22'),
(3, 1, 2, 1, '14:05:00', '17:00:00', '2026-09-05 17:08:36', '2026-09-05 17:08:36'),
(5, 4, 1, 1, '08:55:00', '10:05:00', '2026-09-06 04:06:10', '2026-09-06 04:06:10'),
(6, 4, 1, 7, '08:50:00', '10:35:00', '2026-09-06 04:06:50', '2026-09-06 04:06:50'),
(7, 4, 1, 7, '16:05:00', '17:50:00', '2026-09-06 04:07:05', '2026-09-06 04:07:05'),
(8, 1, 4, 1, '18:50:00', '20:00:00', '2026-09-06 04:22:25', '2026-09-06 04:22:25'),
(9, 1, 2, 6, '07:00:00', '09:55:00', '2026-09-06 04:23:34', '2026-09-06 04:23:34'),
(10, 1, 2, 8, '12:10:00', '15:05:00', '2026-09-06 04:24:05', '2026-09-06 04:24:05'),
(11, 1, 2, 2, '11:05:00', '14:05:00', '2026-09-06 04:24:20', '2026-09-06 04:24:20'),
(12, 1, 2, 2, '15:40:00', '18:40:00', '2026-09-06 04:24:33', '2026-09-06 04:24:33'),
(13, 2, 1, 1, '10:40:00', '13:25:00', '2026-09-06 04:29:19', '2026-09-06 04:29:19'),
(14, 2, 1, 6, '15:15:00', '18:00:00', '2026-09-06 04:29:29', '2026-09-06 04:29:29'),
(15, 2, 1, 8, '08:35:00', '11:25:00', '2026-09-06 04:29:42', '2026-09-06 04:29:42'),
(16, 2, 1, 2, '07:30:00', '10:20:00', '2026-09-06 04:30:12', '2026-09-06 04:30:12'),
(17, 2, 1, 2, '11:55:00', '14:45:00', '2026-09-06 04:30:38', '2026-09-06 04:30:38'),
(18, 4, 2, 4, '06:00:00', '08:25:00', '2026-09-06 04:33:22', '2026-09-06 04:33:22'),
(19, 4, 2, 4, '19:00:00', '21:25:00', '2026-09-06 04:33:33', '2026-09-06 04:33:33'),
(20, 4, 2, 4, '20:05:00', '22:30:00', '2026-09-06 04:33:45', '2026-09-06 04:33:45'),
(21, 4, 2, 1, '07:00:00', '09:25:00', '2026-09-06 04:33:57', '2026-09-06 04:33:57'),
(22, 4, 2, 1, '20:40:00', '23:05:00', '2026-09-06 04:34:09', '2026-09-06 04:34:09'),
(23, 4, 2, 3, '06:10:00', '08:35:00', '2026-09-06 04:34:21', '2026-09-06 04:34:21'),
(24, 4, 2, 4, '08:00:00', '10:25:00', '2026-09-06 04:34:37', '2026-09-06 04:34:37'),
(25, 4, 2, 4, '11:00:00', '13:25:00', '2026-09-06 04:34:55', '2026-09-06 04:34:55'),
(26, 4, 2, 4, '12:00:00', '14:25:00', '2026-09-06 04:35:09', '2026-09-06 04:35:09'),
(27, 4, 2, 4, '13:00:00', '15:25:00', '2026-09-06 04:35:20', '2026-09-06 04:35:20'),
(28, 4, 2, 4, '16:10:00', '18:35:00', '2026-09-06 04:35:33', '2026-09-06 04:35:33'),
(29, 4, 2, 4, '17:00:00', '19:25:00', '2026-09-06 04:35:50', '2026-09-06 04:35:50'),
(30, 4, 2, 3, '05:00:00', '07:25:00', '2026-09-06 04:36:11', '2026-09-06 04:36:11'),
(31, 4, 2, 3, '08:20:00', '10:45:00', '2026-09-06 04:36:24', '2026-09-06 04:36:24'),
(32, 4, 2, 3, '17:30:00', '20:00:00', '2026-09-06 04:36:52', '2026-09-06 04:36:52'),
(33, 4, 2, 3, '18:55:00', '21:20:00', '2026-09-06 04:37:05', '2026-09-06 04:37:05'),
(34, 4, 2, 3, '21:30:00', '23:55:00', '2026-09-06 04:38:00', '2026-09-06 04:38:00'),
(35, 4, 2, 2, '19:50:00', '22:15:00', '2026-09-06 04:38:12', '2026-09-06 04:38:12'),
(36, 4, 2, 6, '05:30:00', '07:55:00', '2026-09-06 04:38:23', '2026-09-06 04:38:23'),
(37, 4, 2, 6, '19:30:00', '21:55:00', '2026-09-06 04:38:37', '2026-09-06 04:38:37'),
(38, 4, 2, 3, '10:50:00', '13:15:00', '2026-09-06 04:38:47', '2026-09-06 04:38:47'),
(39, 4, 2, 3, '14:10:00', '16:35:00', '2026-09-06 04:39:01', '2026-09-06 04:39:01'),
(40, 4, 2, 3, '16:30:00', '18:55:00', '2026-09-06 04:39:24', '2026-09-06 04:39:24'),
(41, 4, 2, 6, '10:00:00', '12:25:00', '2026-09-06 04:39:34', '2026-09-06 04:39:34'),
(42, 4, 2, 6, '16:00:00', '18:25:00', '2026-09-06 04:39:44', '2026-09-06 04:39:44'),
(43, 4, 2, 2, '06:00:00', '08:25:00', '2026-09-06 11:40:25', '2026-09-06 11:40:25'),
(44, 4, 2, 2, '09:15:00', '11:40:00', '2026-09-06 11:40:54', '2026-09-06 11:40:54'),
(45, 4, 2, 3, '09:20:00', '11:45:00', '2026-09-06 11:41:29', '2026-09-06 11:41:29'),
(46, 4, 2, 2, '10:25:00', '12:50:00', '2026-09-06 11:41:47', '2026-09-06 11:41:47'),
(47, 4, 2, 2, '12:50:00', '15:15:00', '2026-09-06 11:42:06', '2026-09-06 11:42:06'),
(48, 4, 2, 2, '15:05:00', '17:35:00', '2026-09-06 11:42:29', '2026-09-06 11:42:29'),
(49, 4, 2, 8, '15:35:00', '18:00:00', '2026-09-06 11:42:50', '2026-09-06 11:42:50'),
(50, 4, 2, 2, '17:00:00', '19:25:00', '2026-09-06 11:43:20', '2026-09-06 11:43:20'),
(51, 4, 2, 6, '18:00:00', '20:25:00', '2026-09-06 11:43:46', '2026-09-06 11:43:46'),
(52, 2, 4, 4, '05:00:00', '07:15:00', '2026-09-06 11:44:44', '2026-09-06 11:44:44'),
(53, 2, 4, 1, '05:25:00', '07:40:00', '2026-09-06 11:44:56', '2026-09-06 11:44:56'),
(54, 2, 4, 3, '05:30:00', '07:50:00', '2026-09-06 11:46:08', '2026-09-06 11:46:08'),
(55, 2, 4, 2, '06:10:00', '08:30:00', '2026-09-06 11:46:20', '2026-09-06 11:46:20'),
(56, 2, 4, 3, '06:15:00', '08:35:00', '2026-09-06 11:46:40', '2026-09-06 11:46:40'),
(57, 2, 4, 6, '07:00:00', '09:15:00', '2026-09-06 11:47:10', '2026-09-06 11:47:10'),
(58, 2, 4, 2, '07:05:00', '09:30:00', '2026-09-06 11:47:26', '2026-09-06 11:47:26'),
(59, 2, 4, 3, '08:00:00', '10:20:00', '2026-09-06 11:47:38', '2026-09-06 11:47:38'),
(60, 2, 4, 4, '08:05:00', '10:20:00', '2026-09-06 11:47:55', '2026-09-06 11:47:55'),
(61, 2, 4, 2, '09:30:00', '11:55:00', '2026-09-06 11:48:06', '2026-09-06 11:48:06'),
(62, 2, 4, 4, '10:05:00', '12:20:00', '2026-09-06 11:48:25', '2026-09-06 11:48:25'),
(63, 2, 4, 3, '11:20:00', '13:40:00', '2026-09-06 11:48:35', '2026-09-06 11:48:35'),
(64, 2, 4, 2, '11:35:00', '14:00:00', '2026-09-06 11:48:47', '2026-09-06 11:48:47'),
(65, 2, 4, 8, '12:25:00', '14:50:00', '2026-09-06 11:48:57', '2026-09-06 11:48:57'),
(66, 2, 4, 6, '13:05:00', '15:20:00', '2026-09-06 11:49:10', '2026-09-06 11:49:10'),
(67, 2, 4, 4, '13:15:00', '15:30:00', '2026-09-06 11:49:21', '2026-09-06 11:49:21'),
(68, 2, 4, 3, '13:25:00', '15:45:00', '2026-09-06 11:49:34', '2026-09-06 11:49:34'),
(69, 2, 4, 2, '13:35:00', '16:00:00', '2026-09-06 11:49:42', '2026-09-06 11:49:42'),
(70, 2, 4, 4, '14:05:00', '16:20:00', '2026-09-06 11:49:59', '2026-09-06 11:49:59'),
(71, 2, 4, 3, '14:20:00', '16:40:00', '2026-09-06 11:50:08', '2026-09-06 11:50:08'),
(72, 2, 4, 6, '15:00:00', '17:15:00', '2026-09-06 11:50:20', '2026-09-06 11:50:20'),
(73, 2, 4, 4, '16:05:00', '18:20:00', '2026-09-06 11:51:04', '2026-09-06 11:51:04'),
(74, 2, 4, 3, '16:05:00', '18:25:00', '2026-09-06 11:51:13', '2026-09-06 11:51:13'),
(75, 2, 4, 6, '16:30:00', '18:45:00', '2026-09-06 11:51:25', '2026-09-06 11:51:25'),
(76, 2, 4, 2, '16:35:00', '19:00:00', '2026-09-06 11:51:36', '2026-09-06 11:51:36'),
(77, 2, 4, 4, '17:05:00', '19:20:00', '2026-09-06 11:51:51', '2026-09-06 11:51:51'),
(78, 2, 4, 1, '17:40:00', '19:55:00', '2026-09-06 11:52:02', '2026-09-06 11:52:02'),
(79, 2, 4, 4, '18:10:00', '20:25:00', '2026-09-06 11:52:19', '2026-09-06 11:52:19'),
(80, 2, 4, 3, '18:30:00', '20:50:00', '2026-09-06 11:52:30', '2026-09-06 11:52:30'),
(81, 2, 4, 6, '19:00:00', '21:15:00', '2026-09-06 11:52:41', '2026-09-06 11:52:41'),
(82, 2, 4, 2, '19:15:00', '21:40:00', '2026-09-06 11:52:54', '2026-09-06 11:52:54'),
(83, 2, 4, 3, '20:00:00', '22:20:00', '2026-09-06 11:53:01', '2026-09-06 11:53:01'),
(84, 2, 4, 4, '20:05:00', '22:20:00', '2026-09-06 11:53:11', '2026-09-06 11:53:11'),
(85, 2, 4, 3, '21:30:00', '23:50:00', '2026-09-06 11:53:25', '2026-09-06 11:53:25'),
(86, 4, 9, 7, '09:50:00', '11:00:00', '2026-09-06 12:13:39', '2026-09-06 12:13:39'),
(87, 9, 4, 7, '13:15:00', '14:25:00', '2026-09-06 12:14:02', '2026-09-06 12:14:02'),
(88, 1, 9, 13, '13:25:00', '14:55:00', '2026-09-06 12:16:18', '2026-09-06 12:16:18'),
(89, 9, 1, 13, '08:05:00', '09:35:00', '2026-09-06 12:16:37', '2026-09-06 12:16:37'),
(90, 1, 14, 13, '10:05:00', '11:25:00', '2026-09-06 12:21:37', '2026-09-06 12:21:37'),
(91, 14, 1, 13, '07:45:00', '09:15:00', '2026-09-06 12:21:59', '2026-09-06 12:21:59');

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
('jg0v8DLMWlJz5S6tZLCsdtAEe5mtMjVolkndTbCb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWZRN1ZvUDB4cDVnVjhQUnk5bDhERkNYMHlVV1hKM3Q2S01uYjFEYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wZW5lcmJhbmdhbj90YW5nZ2FsPTIwMjYtMDktMDYmd2lsYXlhaF9hc2FsX2lkPTQmd2lsYXlhaF90dWp1YW5faWQ9MSI7czo1OiJyb3V0ZSI7czoyNDoidHJhdmVsLnBlbmVyYmFuZ2FuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1788697364),
('uAS0FPRNuGU3wmihPulfrbnDFsoMzs2wUgnA4bu5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzE4WEptUU9PdEFoVnRaZ0VMYkdhNHU5ZkVtY1FVZHRWbjh5VGJvYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoyMToidHJhdmVsLmJvb2tpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788692372);

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Kosikas Travel', 'admin@kosikas.test', '2026-09-02 09:34:02', '$2y$12$bp6ucCB48Q12x9pzMIvCKOzPbUQg65ovjbPatApeFKIfxd6TiDwIG', NULL, '2026-09-02 09:34:03', '2026-09-02 09:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `wilayahs`
--

CREATE TABLE `wilayahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airport_name` varchar(150) NOT NULL,
  `code_iata` varchar(3) NOT NULL,
  `code_icao` varchar(4) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `province_name` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Indonesia',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `type` enum('domestic','international') NOT NULL DEFAULT 'domestic',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wilayahs`
--

INSERT INTO `wilayahs` (`id`, `airport_name`, `code_iata`, `code_icao`, `city_name`, `province_name`, `country`, `latitude`, `longitude`, `timezone`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sultan Iskandar Muda International Airport', 'BTJ', 'WITT', 'Banda Aceh', 'Aceh', 'Indonesia', 5.5229000, 95.4200000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(2, 'Soekarno-Hatta International Airport', 'CGK', 'WIII', 'Jakarta', 'Banten', 'Indonesia', -6.1256000, 106.6559000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(3, 'Halim Perdanakusuma International Airport', 'HLP', 'WIHH', 'Jakarta', 'DKI Jakarta', 'Indonesia', -6.2666000, 106.8900000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(4, 'Kualanamu International Airport', 'KNO', 'WIMM', 'Medan', 'Sumatera Utara', 'Indonesia', 3.6422000, 98.8853000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(5, 'Juanda International Airport', 'SUB', 'WARR', 'Surabaya', 'Jawa Timur', 'Indonesia', -7.3798000, 112.7870000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(6, 'I Gusti Ngurah Rai International Airport', 'DPS', 'WADD', 'Denpasar', 'Bali', 'Indonesia', -8.7482000, 115.1672000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(7, 'Yogyakarta International Airport', 'YIA', 'WAHI', 'Yogyakarta', 'DI Yogyakarta', 'Indonesia', -7.9053000, 110.0570000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(8, 'Sultan Hasanuddin International Airport', 'UPG', 'WAAA', 'Makassar', 'Sulawesi Selatan', 'Indonesia', -5.0616000, 119.5540000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(9, 'Lasikin Airport', 'LKI', 'WITG', 'Simeulue', 'Aceh', 'Indonesia', 2.4100000, 96.3250000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(10, 'Cut Nyak Dhien Airport', 'MEQ', 'WITC', 'Meulaboh', 'Aceh', 'Indonesia', 4.0407000, 96.2576000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(11, 'Malikussaleh Airport', 'LSW', 'WITM', 'Lhokseumawe', 'Aceh', 'Indonesia', 5.2267000, 96.9503000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(12, 'Maimun Saleh Airport', 'SBG', 'WITB', 'Sabang', 'Aceh', 'Indonesia', 5.8740000, 95.3397000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(13, 'Rembele Airport', 'TXE', 'WITK', 'Takengon', 'Aceh', 'Indonesia', 4.7213000, 96.8512000, NULL, 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(14, 'Bandar Udara Alas Leuser', 'LSR', 'WIMU', 'Kutacane', 'Aceh', 'Indonesia', 3.4270000, 97.6990000, 'Asia/Jakarta', 'domestic', 1, '2026-09-06 12:20:48', '2026-09-06 12:20:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flights_booking_id_foreign` (`booking_id`),
  ADD KEY `flights_maskapai_id_foreign` (`maskapai_id`),
  ADD KEY `flights_origin_wilayah_id_foreign` (`origin_wilayah_id`),
  ADD KEY `flights_destination_wilayah_id_foreign` (`destination_wilayah_id`);

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
-- Indexes for table `maskapais`
--
ALTER TABLE `maskapais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maskapais_code_iata_unique` (`code_iata`),
  ADD UNIQUE KEY `maskapais_code_icao_unique` (`code_icao`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passengers_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penerbangans`
--
ALTER TABLE `penerbangans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerbangans_wilayah_asal_id_foreign` (`wilayah_asal_id`),
  ADD KEY `penerbangans_wilayah_tujuan_id_foreign` (`wilayah_tujuan_id`),
  ADD KEY `penerbangans_maskapai_id_foreign` (`maskapai_id`);

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
-- Indexes for table `wilayahs`
--
ALTER TABLE `wilayahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wilayahs_code_iata_unique` (`code_iata`),
  ADD UNIQUE KEY `wilayahs_code_icao_unique` (`code_icao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maskapais`
--
ALTER TABLE `maskapais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penerbangans`
--
ALTER TABLE `penerbangans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wilayahs`
--
ALTER TABLE `wilayahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_destination_wilayah_id_foreign` FOREIGN KEY (`destination_wilayah_id`) REFERENCES `wilayahs` (`id`),
  ADD CONSTRAINT `flights_maskapai_id_foreign` FOREIGN KEY (`maskapai_id`) REFERENCES `maskapais` (`id`),
  ADD CONSTRAINT `flights_origin_wilayah_id_foreign` FOREIGN KEY (`origin_wilayah_id`) REFERENCES `wilayahs` (`id`);

--
-- Constraints for table `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penerbangans`
--
ALTER TABLE `penerbangans`
  ADD CONSTRAINT `penerbangans_maskapai_id_foreign` FOREIGN KEY (`maskapai_id`) REFERENCES `maskapais` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penerbangans_wilayah_asal_id_foreign` FOREIGN KEY (`wilayah_asal_id`) REFERENCES `wilayahs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penerbangans_wilayah_tujuan_id_foreign` FOREIGN KEY (`wilayah_tujuan_id`) REFERENCES `wilayahs` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
