-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2026 at 04:29 PM
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
(7, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PYMWVK', '2026-09-05', 'IDR', 2517221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-05 15:30:15', '2026-09-05 15:31:48'),
(8, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'D5H3D3', '2026-09-08', 'IDR', 2710460.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-09 23:20:21', '2026-09-09 23:20:21'),
(9, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'UQPQYM', '2026-09-08', 'IDR', 2447221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-09 23:24:23', '2026-09-09 23:24:23'),
(10, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PYMWVK', '2026-09-08', 'IDR', 2517221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-09 23:26:31', '2026-09-09 23:26:31'),
(11, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'LHBUKK', '2026-09-10', 'IDR', 8835000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-10 14:29:22', '2026-09-10 14:29:22'),
(12, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'HMFEFG', '2026-09-11', 'IDR', 2598300.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-12 10:00:08', '2026-09-12 10:00:56'),
(13, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'A1IRNV', '2026-09-12', 'IDR', 782190.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-12 10:15:18', '2026-09-12 10:15:18'),
(14, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PLVOTV', '2026-09-12', 'IDR', 1203700.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-12 10:45:16', '2026-09-12 10:45:16'),
(15, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PQHIEL', '2026-09-12', 'IDR', 2462900.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-12 11:26:37', '2026-09-12 11:26:37'),
(16, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'PLWKHH', '2026-09-12', 'IDR', 2462900.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-12 11:28:22', '2026-09-12 11:28:22'),
(17, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'CLHIEZ', '2026-09-15', 'IDR', 6145600.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-16 11:18:17', '2026-09-16 11:42:05'),
(18, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'GJECAO', '2026-09-19', 'IDR', 2475000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-19 02:16:24', '2026-09-19 02:16:24'),
(19, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'DNWNUL', '2026-09-19', 'IDR', 2475000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-19 02:17:35', '2026-09-19 02:17:35'),
(20, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'FESFNC', '2026-09-19', 'IDR', 2586160.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-19 02:19:34', '2026-09-19 02:19:34'),
(21, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'GZWLES', '2026-09-20', 'IDR', 2475000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-20 00:13:59', '2026-09-20 00:13:59'),
(22, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'TESWVI', '2026-09-22', 'IDR', 2337221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-22 12:35:49', '2026-09-22 12:35:49'),
(23, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'DXAY7P', '2026-09-22', 'IDR', 2092160.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-22 12:37:28', '2026-09-22 12:37:28'),
(24, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'ZMHSTL', '2026-09-29', 'IDR', 2277221.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-29 11:38:56', '2026-09-29 11:38:56'),
(25, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'LSRBTJ', '2026-09-30', 'IDR', 2757720.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-29 22:05:12', '2026-09-29 22:05:12'),
(26, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'GAWTBS', '2026-09-30', 'IDR', 7139040.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-30 13:42:56', '2026-09-30 13:45:21'),
(27, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'DHMDQC', '2026-09-30', 'IDR', 4194442.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-09-30 13:59:37', '2026-09-30 13:59:37'),
(29, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'JEOTKJ', '2026-10-01', 'IDR', 2226400.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-01 12:36:14', '2026-10-01 12:36:14'),
(30, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'FFM4XT', '2026-10-03', 'IDR', 860739.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 01:58:25', '2026-10-03 02:23:26'),
(31, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'FFM4XT', '2026-10-03', 'IDR', 2582217.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 02:12:06', '2026-10-03 02:22:50'),
(32, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', '9MYM62', '2026-10-03', 'IDR', 5198300.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 07:22:39', '2026-10-03 07:25:38'),
(33, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', '9MYM62', '2026-10-03', 'IDR', 15594900.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 07:26:38', '2026-10-04 11:10:03'),
(34, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'YPOISR', '2026-10-03', 'IDR', 2226400.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 10:23:12', '2026-10-03 10:23:12'),
(35, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'D7TEBA', '2026-10-03', 'IDR', 2572720.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-03 13:31:11', '2026-10-03 13:31:11'),
(36, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', '5LG87A', '2026-10-04', 'IDR', 2784760.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-04 01:06:22', '2026-10-04 01:06:22'),
(37, 'KOSIKAS TRAVEL', 'Teman Setia Perjalanan Anda', 'CWXTSB', '2026-10-04', 'IDR', 2475000.00, 'Sudah termasuk tarif dasar, pajak, biaya, dan biaya tambahan.', '2026-10-04 10:51:02', '2026-10-04 10:51:02');

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
(14, 7, 8, 2, 1, '342', '2026-09-12', '08:35', '11:25', 'V', '2026-09-05 15:35:02', '2026-09-05 15:35:02'),
(15, 8, 2, 1, 2, '0141', '2026-09-10', '11:05', '14:05', 'S', '2026-09-09 23:20:21', '2026-09-09 23:20:21'),
(16, 9, 8, 1, 2, '343', '2026-09-10', '12:10', '15:05', 'V', '2026-09-09 23:24:23', '2026-09-09 23:24:23'),
(18, 10, 8, 2, 1, '342', '2026-09-14', '08:35', '11:25', 'V', '2026-09-10 10:44:34', '2026-09-10 10:44:34'),
(21, 11, 1, 1, 2, '995', '2026-09-13', '14:05', '17:00', 'L', '2026-09-10 14:35:12', '2026-09-10 14:35:12'),
(23, 12, 6, 2, 1, '6898', '2026-09-14', '15:15', '18:00', 'L', '2026-09-12 10:00:56', '2026-09-12 10:00:56'),
(24, 13, 13, 1, 14, '7192', '2026-09-26', '13:30', '14:40', NULL, '2026-09-12 10:15:18', '2026-09-12 10:15:18'),
(26, 14, 1, 4, 1, '996', '2026-09-24', '08:55', '10:05', 'G', '2026-09-12 10:45:46', '2026-09-12 10:45:46'),
(28, 15, 6, 1, 2, '6899', '2026-09-19', '07:00', '09:55', 'M', '2026-09-12 11:27:02', '2026-09-12 11:27:02'),
(31, 16, 6, 1, 2, '6899', '2026-09-19', '07:00', '09:55', 'M', '2026-09-14 12:19:14', '2026-09-14 12:19:14'),
(34, 17, 4, 2, 4, '210', '2026-09-18', '13:15', '15:30', 'Q', '2026-09-16 11:42:05', '2026-09-16 11:42:05'),
(37, 18, 6, 2, 1, '6898', '2026-09-27', '15:15', '18:00', 'M', '2026-09-19 02:17:43', '2026-09-19 02:17:43'),
(38, 19, 6, 2, 1, '6898', '2026-09-27', '15:15', '18:00', 'M', '2026-09-19 02:18:10', '2026-09-19 02:18:10'),
(39, 20, 2, 1, 2, '0141', '2026-09-21', '11:05', '14:05', 'H', '2026-09-19 02:19:34', '2026-09-19 02:19:34'),
(41, 21, 6, 2, 1, '6898', '2026-09-27', '15:15', '18:00', 'M', '2026-09-20 00:14:20', '2026-09-20 00:14:20'),
(44, 23, 2, 1, 2, '147', '2026-09-27', '15:40', '18:40', 'L', '2026-09-22 12:37:41', '2026-09-22 12:37:41'),
(45, 22, 8, 2, 1, '342', '2026-09-23', '08:35', '11:25', 'S', '2026-09-22 12:37:47', '2026-09-22 12:37:47'),
(46, 24, 8, 1, 2, '343', '2026-09-29', '12:10', '15:05', 'S', '2026-09-29 11:38:56', '2026-09-29 11:38:56'),
(51, 26, 7, 1, 4, '1213', '2026-10-08', '06:45', '08:20', 'L', '2026-09-30 13:45:48', '2026-09-30 13:45:48'),
(52, 27, 8, 2, 1, '342', '2026-12-30', '08:35', '11:25', 'M', '2026-09-30 13:59:37', '2026-09-30 13:59:37'),
(54, 25, 13, 14, 1, '7192', '2026-10-06', '11:30', '12:55', 'Y', '2026-09-30 13:59:59', '2026-09-30 13:59:59'),
(56, 29, 1, 2, 1, '994', '2026-10-18', '10:40', '13:25', 'L', '2026-10-01 12:37:56', '2026-10-01 12:37:56'),
(61, 30, 14, 1, 16, '422', '2026-10-22', '08:25', '11:00', NULL, '2026-10-03 02:23:26', '2026-10-03 02:23:26'),
(62, 31, 14, 1, 16, '422', '2026-10-22', '08:25', '11:00', NULL, '2026-10-03 02:23:31', '2026-10-03 02:23:31'),
(73, 34, 1, 2, 1, '994', '2026-10-04', '10:40', '13:25', 'L', '2026-10-03 10:23:32', '2026-10-03 10:23:32'),
(75, 36, 2, 1, 2, '141', '2026-10-12', '11:05', '14:05', 'V', '2026-10-04 01:06:22', '2026-10-04 01:06:22'),
(76, 35, 2, 2, 1, '146', '2026-10-16', '11:55', '14:45', NULL, '2026-10-04 01:06:31', '2026-10-04 01:06:31'),
(81, 32, 15, 16, 17, '853', '2026-10-22', '19:20', '21:40', NULL, '2026-10-04 10:43:03', '2026-10-04 10:43:03'),
(82, 32, 15, 17, 18, '119', '2026-10-23', '02:45', '08:00', NULL, '2026-10-04 10:43:03', '2026-10-04 10:43:03'),
(85, 37, 6, 2, 1, '6898', '2026-10-18', '15:15', '18:00', NULL, '2026-10-04 10:51:02', '2026-10-04 10:51:02'),
(86, 33, 15, 16, 17, '853', '2026-10-22', '19:20', '21:40', NULL, '2026-10-04 11:10:03', '2026-10-04 11:10:03'),
(87, 33, 15, 17, 18, '119', '2026-10-22', '02:45', '08:00', NULL, '2026-10-04 11:10:03', '2026-10-04 11:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_code` varchar(255) DEFAULT NULL,
  `issued_date` date NOT NULL,
  `orderer_name` varchar(255) DEFAULT NULL,
  `orderer_address` varchar(255) DEFAULT NULL,
  `orderer_phone` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `bank_account_holder` varchar(255) DEFAULT NULL,
  `signer_name` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_code`, `issued_date`, `orderer_name`, `orderer_address`, `orderer_phone`, `bank_name`, `bank_account_number`, `bank_account_holder`, `signer_name`, `notes`, `created_at`, `updated_at`) VALUES
(5, 'P20260911DA', '2026-09-11', 'Darwis Abubakar', 'Kota Banda Aceh', '0823-2005-9200', NULL, NULL, NULL, NULL, NULL, '2026-09-10 21:39:07', '2026-09-10 21:39:59'),
(6, 'P20260912AD', '2026-09-12', 'Adrian Devano', 'Kota Banda Aceh', '0822-8599-3357', NULL, NULL, NULL, NULL, NULL, '2026-09-12 10:01:18', '2026-09-12 10:04:32'),
(7, 'P20260912MR', '2026-09-12', 'Muhammad Ridha', 'Kabupaten Aceh Tenggara', '0822-7262-3336', NULL, NULL, NULL, NULL, NULL, '2026-09-12 11:45:07', '2026-09-12 11:45:42'),
(8, 'H20260915WJ', '2026-09-15', 'Wira Junardi', 'Kota Banda Aceh', '0813-1153-5783', NULL, NULL, NULL, NULL, NULL, '2026-09-14 17:08:28', '2026-09-14 17:17:19'),
(9, 'P20260916WJ', '2026-09-16', 'Wira Junardi', 'Kota Banda Aceh', '0813-1153-5783', NULL, NULL, NULL, NULL, NULL, '2026-09-16 11:24:03', '2026-09-16 11:24:22'),
(13, 'P20260916WJ', '2026-09-16', 'Wira Junardi', 'Kota Banda Aceh', '0813-1153-5783', NULL, NULL, NULL, NULL, NULL, '2026-09-16 11:42:10', '2026-09-16 11:42:23'),
(14, 'P20260919CA', '2026-09-19', 'Clarissa Azarine', 'Kota Banda Aceh', '0822-2337-6589', NULL, NULL, NULL, NULL, NULL, '2026-09-19 02:21:07', '2026-09-19 02:21:25'),
(15, 'P20260919RF', '2026-09-19', 'Riska Fazilla', 'Kota Banda Aceh', '0822-1755-2217', NULL, NULL, NULL, NULL, NULL, '2026-09-19 02:21:43', '2026-09-19 02:21:58'),
(16, 'P20260920NH', '2026-09-20', 'Nur Hasanah', 'Kota Banda Aceh', '0821-1422-4478', NULL, NULL, NULL, NULL, NULL, '2026-09-20 00:14:50', '2026-09-20 00:15:18'),
(17, 'P20260922DA', '2026-09-22', 'Denita Dwi Andiany', 'Kota Jakarta', '0838-2088-8402', NULL, NULL, NULL, NULL, NULL, '2026-09-22 12:38:02', '2026-09-22 12:41:38'),
(18, 'P20260930TT', '2026-09-30', 'Titianingrum', 'Kutacane, Aceh Tenggara', '0813-1019-1373', NULL, NULL, NULL, NULL, NULL, '2026-09-30 14:13:41', '2026-09-30 14:14:59'),
(19, 'H20261003AA', '2026-10-03', 'Alif Muhammad Arrasyid', 'Takengon, Aceh Tengah', '0812-9362-8867', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:36:48', '2026-10-03 10:46:01'),
(20, 'H20261003MR', '2026-10-03', 'Muhammad Ridha', 'Kutacane, Aceh Tenggara', '0822-7262-3336', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:48:39', '2026-10-03 10:52:57'),
(21, 'H20261003JJ', '2026-10-03', 'Juliana', 'Kota Banda Aceh', '0811-9211-510', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:53:32', '2026-10-03 10:54:55'),
(22, 'P20261003MB', '2026-10-03', 'Muhammad Abka Banadti', 'Kota Banda Aceh', '0815-3402-0185', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:55:47', '2026-10-03 10:56:09'),
(26, 'P20261003WJ', '2026-10-03', 'Wira Junardi', 'Kota Banda Aceh', '0813-1153-5783', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:58:16', '2026-10-04 11:02:52'),
(27, 'P20261003WJ', '2026-10-03', 'Wira Junardi', 'Kota Banda Aceh', '0813-1153-5783', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:58:41', '2026-10-04 11:06:28'),
(28, 'P20261003AH', '2026-10-03', 'Andi Hardiyanto', 'Takengon, Aceh Tengah', '0812-6979-076', NULL, NULL, NULL, NULL, NULL, '2026-10-03 10:58:58', '2026-10-03 10:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('flight','extra','hotel') NOT NULL DEFAULT 'flight',
  `passenger_name` varchar(255) DEFAULT NULL,
  `maskapai_name` varchar(255) DEFAULT NULL,
  `route_text` varchar(255) DEFAULT NULL,
  `hotel_name` varchar(255) DEFAULT NULL,
  `hotel_location` varchar(255) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `flight_date_text` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `booking_id`, `type`, `passenger_name`, `maskapai_name`, `route_text`, `hotel_name`, `hotel_location`, `checkin_date`, `checkout_date`, `flight_date_text`, `label`, `amount`, `sort_order`, `created_at`, `updated_at`) VALUES
(12, 5, 10, 'flight', 'Darwis Abubakar', 'Pelita Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '14 Sep 2026', NULL, 2517221.00, 0, '2026-09-10 21:39:07', '2026-09-10 21:39:07'),
(13, 5, 9, 'flight', 'Darwis Abubakar', 'Pelita Air', 'BTJ-CGK', NULL, NULL, NULL, NULL, '10 Sep 2026', NULL, 2447221.00, 1, '2026-09-10 21:39:07', '2026-09-10 21:39:07'),
(14, 5, NULL, 'extra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Biaya Reschedule', 396852.00, 2, '2026-09-10 21:39:59', '2026-09-10 21:39:59'),
(15, 6, 12, 'flight', 'Adrian Devano', 'Batik Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '14 Sep 2026', NULL, 2598300.00, 0, '2026-09-12 10:01:18', '2026-09-12 10:01:18'),
(16, 6, 8, 'flight', 'Adrian Devano', 'Garuda Indonesia', 'BTJ-CGK', NULL, NULL, NULL, NULL, '10 Sep 2026', NULL, 2710460.00, 1, '2026-09-12 10:01:19', '2026-09-12 10:01:19'),
(18, 6, NULL, 'extra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Biaya Reschedule', 2206444.00, 2, '2026-09-12 10:04:32', '2026-09-12 10:04:32'),
(19, 7, 14, 'flight', 'Muhammad Ridha', 'Super Air Jet', 'KNO-BTJ', NULL, NULL, NULL, NULL, '24 Sep 2026', NULL, 1203700.00, 0, '2026-09-12 11:45:07', '2026-09-12 11:45:07'),
(20, 7, 13, 'flight', 'Muhammad Ridha', 'Susi Air', 'BTJ-LSR', NULL, NULL, NULL, NULL, '26 Sep 2026', NULL, 782190.00, 1, '2026-09-12 11:45:07', '2026-09-12 11:45:07'),
(21, 8, NULL, 'hotel', 'Wira Junardi', NULL, NULL, 'Apartment Bassura City by Travelibu', 'Kota Jakarta Timur', '2026-09-13', '2026-09-18', NULL, NULL, 1117600.00, 0, '2026-09-14 17:17:19', '2026-09-14 17:17:19'),
(22, 9, 11, 'flight', 'Wira Junardi +3 lainnya', 'Super Air Jet', 'BTJ-CGK', NULL, NULL, NULL, NULL, '13 Sep 2026', NULL, 8835000.00, 0, '2026-09-16 11:24:03', '2026-09-16 11:24:03'),
(25, 13, 17, 'flight', 'Wira Junardi +3 lainnya', 'Lion Air', 'CGK-KNO', NULL, NULL, NULL, NULL, '18 Sep 2026', NULL, 6145600.00, 0, '2026-09-16 11:42:10', '2026-09-16 11:42:10'),
(26, 14, 18, 'flight', 'Clarissa Azarine', 'Batik Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '27 Sep 2026', NULL, 2475000.00, 0, '2026-09-19 02:21:08', '2026-09-19 02:21:08'),
(27, 14, 15, 'flight', 'Clarissa Azarine', 'Batik Air', 'BTJ-CGK', NULL, NULL, NULL, NULL, '19 Sep 2026', NULL, 2462900.00, 1, '2026-09-19 02:21:08', '2026-09-19 02:21:08'),
(28, 15, 19, 'flight', 'Riska Fazilla', 'Batik Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '27 Sep 2026', NULL, 2475000.00, 0, '2026-09-19 02:21:43', '2026-09-19 02:21:43'),
(29, 15, 16, 'flight', 'Riska Fazilla', 'Batik Air', 'BTJ-CGK', NULL, NULL, NULL, NULL, '19 Sep 2026', NULL, 2462900.00, 1, '2026-09-19 02:21:43', '2026-09-19 02:21:43'),
(30, 16, 21, 'flight', 'Nur Hasanah', 'Batik Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '27 Sep 2026', NULL, 2475000.00, 0, '2026-09-20 00:14:50', '2026-09-20 00:14:50'),
(31, 16, 20, 'flight', 'Nur Hasanah', 'Garuda Indonesia', 'BTJ-CGK', NULL, NULL, NULL, NULL, '21 Sep 2026', NULL, 2586160.00, 1, '2026-09-20 00:14:50', '2026-09-20 00:14:50'),
(32, 17, 23, 'flight', 'Denita Dwi Andiany', 'Garuda Indonesia', 'BTJ-CGK', NULL, NULL, NULL, NULL, '27 Sep 2026', NULL, 2092160.00, 0, '2026-09-22 12:38:03', '2026-09-22 12:38:03'),
(33, 17, 22, 'flight', 'Denita Dwi Andiany', 'Pelita Air', 'CGK-BTJ', NULL, NULL, NULL, NULL, '23 Sep 2026', NULL, 2337221.00, 1, '2026-09-22 12:38:03', '2026-09-22 12:38:03'),
(34, 17, NULL, 'hotel', 'Denita Dwi Andiany', NULL, NULL, 'Hotel Diana Banda Aceh', 'Kota Banda Aceh', '2026-09-23', '2026-09-25', NULL, NULL, 1410000.00, 2, '2026-09-27 11:30:45', '2026-09-27 11:30:45'),
(35, 18, 26, 'flight', 'Titianingrum +3 lainnya', 'Wings Air', 'BTJ-KNO', NULL, NULL, NULL, NULL, '08 Oct 2026', NULL, 7139040.00, 0, '2026-09-30 14:13:41', '2026-09-30 14:13:41'),
(36, 18, 25, 'flight', 'Titianingrum +3 lainnya', 'Susi Air', 'LSR-BTJ', NULL, NULL, NULL, NULL, '06 Oct 2026', NULL, 2757720.00, 1, '2026-09-30 14:13:41', '2026-09-30 14:13:41'),
(47, 19, NULL, 'hotel', 'Andi Hardiyanto', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-09', NULL, NULL, 3535000.00, 0, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(48, 19, NULL, 'hotel', 'Nuelda Amalia', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-09', NULL, NULL, 3535000.00, 1, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(49, 19, NULL, 'hotel', 'Adi Fadli Rajab / Muhammad Saleh', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-09', NULL, NULL, 3535000.00, 2, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(50, 19, NULL, 'hotel', 'Firdaus / Satya Indra Kusworo', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-09', NULL, NULL, 3535000.00, 3, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(51, 19, NULL, 'hotel', 'Nafis Bahrain / Winsyah', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-05', '2026-10-09', NULL, NULL, 3535000.00, 4, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(52, 19, NULL, 'hotel', 'Agus Irawan / Hendra Saputra', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-07', '2026-10-09', NULL, NULL, 2360000.00, 5, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(53, 19, NULL, 'hotel', 'Hendri Syahputra / Sabarudin', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-07', '2026-10-09', NULL, NULL, 2360000.00, 6, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(54, 19, NULL, 'hotel', 'Salsabila Shafa Putri Rahadian / Anggia Sari Siregar', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-07', '2026-10-09', NULL, NULL, 2360000.00, 7, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(55, 19, NULL, 'hotel', 'Alif Muhammad Arrasyid / Dadi Rusmansyah', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-07', '2026-10-09', NULL, NULL, 2360000.00, 8, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(56, 19, NULL, 'hotel', 'Effendy', NULL, NULL, 'Hermes Palace Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-07', '2026-10-09', NULL, NULL, 2360000.00, 9, '2026-10-03 10:46:26', '2026-10-03 10:46:26'),
(57, 20, NULL, 'hotel', 'Titianingrum / Fika Fuza Syahdana', NULL, NULL, 'Ayani Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-08', NULL, NULL, 2010000.00, 0, '2026-10-03 10:52:57', '2026-10-03 10:52:57'),
(58, 20, NULL, 'hotel', 'Santi Maudila Putri / Alifah Suhaila', NULL, NULL, 'Ayani Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-08', NULL, NULL, 2010000.00, 1, '2026-10-03 10:52:57', '2026-10-03 10:52:57'),
(59, 20, NULL, 'hotel', 'Tri Widiantoro / Muhammad Ridha', NULL, NULL, 'Ayani Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-08', NULL, NULL, 2010000.00, 2, '2026-10-03 10:52:57', '2026-10-03 10:52:57'),
(60, 20, NULL, 'hotel', 'Abdul Rajak / Mustapa Kamal', NULL, NULL, 'Ayani Hotel Banda Aceh', 'Kota Banda Aceh', '2026-10-06', '2026-10-08', NULL, NULL, 2010000.00, 3, '2026-10-03 10:52:57', '2026-10-03 10:52:57'),
(61, 21, NULL, 'hotel', 'Juliana / Ismaturrahmi Suhaimi', NULL, NULL, 'Hotel Alia Boutique Pasar Baru', 'Kota Jakarta Pusat', '2026-10-12', '2026-10-16', NULL, NULL, 1938653.00, 0, '2026-10-03 10:54:55', '2026-10-03 10:54:55'),
(62, 22, 29, 'flight', 'Muhammad Abka Banadti', 'Super Air Jet', 'CGK-BTJ', NULL, NULL, NULL, NULL, '18 Oct 2026', NULL, 2226400.00, 0, '2026-10-03 10:55:47', '2026-10-03 10:55:47'),
(74, 26, 31, 'flight', 'Yanna Ria Maulika +2 lainnya', 'AirAsia Berhad (Malaysia)', 'BTJ-KUL', NULL, NULL, NULL, NULL, '22 Oct 2026', NULL, 2582217.00, 0, '2026-10-03 10:58:16', '2026-10-03 10:58:16'),
(75, 26, 30, 'flight', 'Wira Junardi', 'AirAsia Berhad (Malaysia)', 'BTJ-KUL', NULL, NULL, NULL, NULL, '22 Oct 2026', NULL, 860739.00, 1, '2026-10-03 10:58:16', '2026-10-03 10:58:16'),
(76, 27, 33, 'flight', 'Yanna Ria Maulika +2 lainnya', 'Qatar Airways', 'KUL-DOH / DOH-LHR', NULL, NULL, NULL, NULL, '22 Oct 2026', NULL, 15594900.00, 0, '2026-10-03 10:58:41', '2026-10-03 10:58:41'),
(77, 27, 32, 'flight', 'Wira Junardi', 'Qatar Airways', 'KUL-DOH / DOH-LHR', NULL, NULL, NULL, NULL, '22 Oct 2026', NULL, 5198300.00, 1, '2026-10-03 10:58:41', '2026-10-03 10:58:41'),
(78, 28, 34, 'flight', 'Andi Hardiyanto', 'Super Air Jet', 'CGK-BTJ', NULL, NULL, NULL, NULL, '04 Oct 2026', NULL, 2226400.00, 0, '2026-10-03 10:58:58', '2026-10-03 10:58:58'),
(79, 28, 24, 'flight', 'Andi Hardiyanto', 'Pelita Air', 'BTJ-CGK', NULL, NULL, NULL, NULL, '29 Sep 2026', NULL, 2277221.00, 1, '2026-10-03 10:58:58', '2026-10-03 10:58:58'),
(80, 27, NULL, 'extra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Diskon', -150000.00, 2, '2026-10-04 11:09:24', '2026-10-04 11:09:24');

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
(13, 'Susi Air', 'SI', 'SQS', 'Susi Air', 'images/airlines/SI.png', '2026-09-02 09:34:02', '2026-09-04 07:35:13'),
(14, 'AirAsia Berhad (Malaysia)', 'AK', 'AXM', NULL, 'images/airlines/AK.webp', '2026-10-02 14:50:53', '2026-10-02 14:50:53'),
(15, 'Qatar Airways', 'QR', 'QTR', NULL, 'images/airlines/QR.png', '2026-10-02 14:52:57', '2026-10-02 14:52:57');

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
(9, '2024_01_01_000006_create_penerbangans_table', 2),
(10, '2026_09_10_171424_create_invoices_tables', 3),
(11, '2026_09_15_000054_add_hotel_columns_in_invoices_table', 4);

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
(12, 7, 'Mr.', 'Darwis Abubakar', 'Adult', NULL, '7783008904896C1', '20Kg', '2026-09-05 15:35:03', '2026-09-05 15:35:03'),
(13, 8, 'Mr.', 'Adrian Devano', 'Adult', NULL, '126 2144619495', '1PC', '2026-09-09 23:20:21', '2026-09-09 23:20:21'),
(14, 9, 'Mr.', 'Darwis Abubakar', 'Adult', NULL, '3008915992', '20Kg', '2026-09-09 23:24:23', '2026-09-09 23:24:23'),
(16, 10, 'Mr.', 'Darwis Abubakar', 'Adult', NULL, '3008904896', '20Kg', '2026-09-10 10:44:34', '2026-09-10 10:44:34'),
(20, 11, 'Mr.', 'Wira Junardi', 'Adult', NULL, '9382116733057', '10Kg', '2026-09-10 14:35:12', '2026-09-10 14:35:12'),
(21, 11, 'Mrs.', 'Yanna Ria Maulika', 'Adult', NULL, '9382116733058', '10Kg', '2026-09-10 14:35:12', '2026-09-10 14:35:12'),
(22, 11, 'Mr.', 'Keenan Raffasya Arka', 'Child', NULL, '9382116733059', '10Kg', '2026-09-10 14:35:12', '2026-09-10 14:35:12'),
(23, 11, 'Mr.', 'Lathif Athaya Arsya', 'Child', NULL, '9382116733060', '10Kg', '2026-09-10 14:35:12', '2026-09-10 14:35:12'),
(25, 12, 'Mr.', 'Adrian Devano', 'Adult', NULL, '9382116753023', '20Kg', '2026-09-12 10:00:56', '2026-09-12 10:00:56'),
(26, 13, 'Mr.', 'Muhammad Ridha', 'Adult', NULL, '1512103426491', '10Kg', '2026-09-12 10:15:18', '2026-09-12 10:15:18'),
(28, 14, 'Mr.', 'Muhammad Ridha', 'Adult', NULL, '9382116764171', '10Kg', '2026-09-12 10:45:46', '2026-09-12 10:45:46'),
(30, 15, 'Ms.', 'Clarissa Azarine', 'Adult', NULL, '9382116764439', '20Kg', '2026-09-12 11:27:02', '2026-09-12 11:27:02'),
(33, 16, 'Ms.', 'Riska Fazilla', 'Adult', NULL, '9382116764648', '20Kg', '2026-09-14 12:19:14', '2026-09-14 12:19:14'),
(42, 17, 'Mr.', 'Wira Junardi', 'Adult', NULL, '9382116798062', '10Kg', '2026-09-16 11:42:05', '2026-09-16 11:42:05'),
(43, 17, 'Mrs.', 'Yanna Ria Maulika', 'Adult', NULL, '9382116798063', '10Kg', '2026-09-16 11:42:05', '2026-09-16 11:42:05'),
(44, 17, 'Mr.', 'Keenan Raffasya Arka', 'Child', NULL, '9382116798064', '10Kg', '2026-09-16 11:42:05', '2026-09-16 11:42:05'),
(45, 17, 'Mr.', 'Lathif Athaya Arsya', 'Child', NULL, '9382116798065', '10Kg', '2026-09-16 11:42:05', '2026-09-16 11:42:05'),
(48, 18, 'Ms.', 'Clarissa Azarine', 'Adult', NULL, '9902149908220', '20Kg', '2026-09-19 02:17:44', '2026-09-19 02:17:44'),
(49, 19, 'Ms.', 'Riska Fazilla', 'Adult', NULL, '9902149913325', '20Kg', '2026-09-19 02:18:10', '2026-09-19 02:18:10'),
(50, 20, 'Mrs.', 'Nur Hasanah', 'Adult', NULL, '1262144619496', '1PC', '2026-09-19 02:19:34', '2026-09-19 02:19:34'),
(52, 21, 'Mrs.', 'Nur Hasanah', 'Adult', NULL, '9902149966846', '20Kg', '2026-09-20 00:14:20', '2026-09-20 00:14:20'),
(55, 23, 'Mrs.', 'Denita Dwi Andiany', 'Adult', NULL, '1262144619497', '1PC', '2026-09-22 12:37:41', '2026-09-22 12:37:41'),
(56, 22, 'Mrs.', 'Denita Dwi Andiany', 'Adult', NULL, '7783009012290C1', '20Kg', '2026-09-22 12:37:47', '2026-09-22 12:37:47'),
(57, 24, 'Mr.', 'Andi Hardiyanto', 'Adult', NULL, '3009055611', '20Kg', '2026-09-29 11:38:56', '2026-09-29 11:38:56'),
(74, 26, 'Ms.', 'Titianingrum', 'Adult', NULL, '9382116993571', '0Kg', '2026-09-30 13:45:48', '2026-09-30 13:45:48'),
(75, 26, 'Ms.', 'Fika Fuza Syahdana', 'Adult', NULL, '9382116993572', '0Kg', '2026-09-30 13:45:48', '2026-09-30 13:45:48'),
(76, 26, 'Ms.', 'Alifah Suhaila', 'Adult', NULL, '9382116993574', '0Kg', '2026-09-30 13:45:48', '2026-09-30 13:45:48'),
(77, 26, 'Ms.', 'Santi Maudila Putri', 'Adult', NULL, '9382116993573', '0Kg', '2026-09-30 13:45:48', '2026-09-30 13:45:48'),
(78, 27, 'Mr.', 'Darwis Abubakar', 'Adult', NULL, '3009066128', '20Kg', '2026-09-30 13:59:37', '2026-09-30 13:59:37'),
(79, 27, 'Mr.', 'M Syauqi', 'Adult', NULL, '3009066129', '20Kg', '2026-09-30 13:59:37', '2026-09-30 13:59:37'),
(82, 25, 'Ms.', 'Titianingrum', 'Adult', NULL, '374490', '10Kg', '2026-09-30 13:59:59', '2026-09-30 13:59:59'),
(83, 25, 'Ms.', 'Fika Fuza Syahdana', 'Adult', NULL, '374491', '10Kg', '2026-09-30 13:59:59', '2026-09-30 13:59:59'),
(84, 25, 'Ms.', 'Alifah Suhaila', 'Adult', NULL, '374492', '10Kg', '2026-09-30 13:59:59', '2026-09-30 13:59:59'),
(85, 25, 'Ms.', 'Santi Maudila Putri', 'Adult', NULL, '374493', '10Kg', '2026-09-30 13:59:59', '2026-09-30 13:59:59'),
(87, 29, 'Mr.', 'Muhammad Abka Banadti', 'Adult', NULL, '9902150852238', '10Kg', '2026-10-01 12:37:56', '2026-10-01 12:37:56'),
(100, 30, 'Mr.', 'Wira Junardi', 'Adult', NULL, '1453535623', '20Kg', '2026-10-03 02:23:26', '2026-10-03 02:23:26'),
(101, 31, 'Mrs.', 'Yanna Ria Maulika', 'Adult', NULL, '1453535622', '20Kg', '2026-10-03 02:23:31', '2026-10-03 02:23:31'),
(102, 31, 'Mr.', 'Keenan Raffasya Arka', 'Child', NULL, '1453535625', '20Kg', '2026-10-03 02:23:31', '2026-10-03 02:23:31'),
(103, 31, 'Mr.', 'Lathif Athaya Arsya', 'Child', NULL, '1453535624', '20Kg', '2026-10-03 02:23:31', '2026-10-03 02:23:31'),
(112, 34, 'Mr.', 'Andi Hardiyanto', 'Adult', NULL, '9382117037771', '10Kg', '2026-10-03 10:23:32', '2026-10-03 10:23:32'),
(114, 36, 'Mrs.', 'Juliana Juliana', 'Adult', NULL, '1262144619499', '1PC', '2026-10-04 01:06:22', '2026-10-04 01:06:22'),
(115, 35, 'Mrs.', 'Juliana Juliana', 'Adult', NULL, '1262144619498', NULL, '2026-10-04 01:06:31', '2026-10-04 01:06:31'),
(120, 32, 'Mr.', 'Wira Junardi', 'Adult', NULL, '0', '25Kg', '2026-10-04 10:43:03', '2026-10-04 10:43:03'),
(124, 37, 'Mrs.', 'Ismaturrahmi Suhaimi', 'Adult', NULL, '9382117047382', '20Kg', '2026-10-04 10:51:02', '2026-10-04 10:51:02'),
(125, 33, 'Mrs.', 'Yanna Ria Maulika', 'Adult', NULL, '0', '25Kg', '2026-10-04 11:10:03', '2026-10-04 11:10:03'),
(126, 33, 'Mr.', 'Keenan Raffasya Arka', 'Child', NULL, '0', '25Kg', '2026-10-04 11:10:03', '2026-10-04 11:10:03'),
(127, 33, 'Mr.', 'Lathif Athaya Arsya', 'Child', NULL, '0', '25Kg', '2026-10-04 11:10:03', '2026-10-04 11:10:03');

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
(91, 14, 1, 13, '07:45:00', '09:15:00', '2026-09-06 12:21:59', '2026-09-06 12:21:59'),
(92, 4, 15, 3, '06:30:00', '09:10:00', '2026-09-14 16:41:34', '2026-09-14 16:41:34'),
(93, 4, 15, 1, '06:05:00', '08:30:00', '2026-09-14 16:41:48', '2026-09-14 16:41:48'),
(94, 15, 4, 1, '19:10:00', '21:40:00', '2026-09-14 16:42:10', '2026-09-14 16:42:10'),
(95, 15, 4, 3, '19:00:00', '21:30:00', '2026-09-14 16:42:25', '2026-09-14 16:42:25'),
(96, 1, 4, 7, '11:45:00', '13:20:00', '2026-09-29 12:44:31', '2026-09-29 12:44:31');

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
('8ka58GOymcZj70cIJwRs8hMvWWtsFagIvATRGVzB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidjRudjVrUmVvWDJBOTJUa0Y0MUlTWHdkVXBjQkhRSFhVWk9PeHlsUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoyMToidHJhdmVsLmJvb2tpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791123585),
('8N1EFaEU4reHFSOngsNfr5f2q6D2woRGjJiICFw9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU0xqS013bm13SDhWOEVVVmJXSVFXa1J4UHpmbTZEUEFHbXplM01xcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wZW5lcmJhbmdhbiI7czo1OiJyb3V0ZSI7czoyNDoidHJhdmVsLnBlbmVyYmFuZ2FuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1791123925),
('bLQJ3OCYeznDVns79HE6VYfvuMpyznCRvLM0nvkU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG9DN2s4VXE0bkRRT2w5MVc5emVXRnRSN0F5Nmp0N3JRaHFCQ2Y2eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoyMToidHJhdmVsLmJvb2tpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791123584);

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
(1, 'Sultan Iskandar Muda International Airport', 'BTJ', 'WITT', 'Banda Aceh', 'Aceh', 'Indonesia', 5.5229000, 95.4200000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(2, 'Soekarno-Hatta International Airport', 'CGK', 'WIII', 'Jakarta', 'Banten', 'Indonesia', -6.1256000, 106.6559000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(3, 'Halim Perdanakusuma International Airport', 'HLP', 'WIHH', 'Jakarta', 'DKI Jakarta', 'Indonesia', -6.2666000, 106.8900000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(4, 'Kualanamu International Airport', 'KNO', 'WIMM', 'Medan', 'Sumatera Utara', 'Indonesia', 3.6422000, 98.8853000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(5, 'Juanda International Airport', 'SUB', 'WARR', 'Surabaya', 'Jawa Timur', 'Indonesia', -7.3798000, 112.7870000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(6, 'I Gusti Ngurah Rai International Airport', 'DPS', 'WADD', 'Denpasar', 'Bali', 'Indonesia', -8.7482000, 115.1672000, 'Asia/Makassar', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(7, 'Yogyakarta International Airport', 'YIA', 'WAHI', 'Yogyakarta', 'DI Yogyakarta', 'Indonesia', -7.9053000, 110.0570000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(8, 'Sultan Hasanuddin International Airport', 'UPG', 'WAAA', 'Makassar', 'Sulawesi Selatan', 'Indonesia', -5.0616000, 119.5540000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(9, 'Lasikin Airport', 'LKI', 'WITG', 'Simeulue', 'Aceh', 'Indonesia', 2.4100000, 96.3250000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(10, 'Cut Nyak Dhien Airport', 'MEQ', 'WITC', 'Meulaboh', 'Aceh', 'Indonesia', 4.0407000, 96.2576000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(11, 'Malikussaleh Airport', 'LSW', 'WITM', 'Lhokseumawe', 'Aceh', 'Indonesia', 5.2267000, 96.9503000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(12, 'Maimun Saleh Airport', 'SBG', 'WITB', 'Sabang', 'Aceh', 'Indonesia', 5.8740000, 95.3397000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(13, 'Rembele Airport', 'TXE', 'WITK', 'Takengon', 'Aceh', 'Indonesia', 4.7213000, 96.8512000, 'Asia/Jakarta', 'domestic', 1, '2026-09-02 09:34:02', '2026-09-02 09:34:02'),
(14, 'Bandar Udara Alas Leuser', 'LSR', 'WIMU', 'Kutacane', 'Aceh', 'Indonesia', 3.4270000, 97.6990000, 'Asia/Jakarta', 'domestic', 1, '2026-09-06 12:20:48', '2026-09-06 12:20:48'),
(15, 'Bandar Udara Husein Sastranegara', 'BDO', 'WICC', 'Bandung', 'Jawa Barat', 'Indonesia', -6.9006000, 107.5764000, 'Asia/Jakarta', 'domestic', 1, '2026-09-14 16:40:41', '2026-09-14 16:40:41'),
(16, 'Kuala Lumpur International Airport', 'KUL', 'WMKK', 'Kuala Lumpur', 'Selangor', 'Malaysia', 2.7455800, 101.7100000, 'Asia/Kuala_Lumpur', 'international', 1, '2026-10-02 14:57:20', '2026-10-02 14:57:20'),
(17, 'Hamad International Airport', 'DOH', 'OTHH', 'Doha', 'Doha', 'Qatar', 25.2730560, 51.6080560, 'Asia/Qatar', 'international', 1, '2026-10-02 14:58:52', '2026-10-02 14:58:52'),
(18, 'London Heathrow Airport', 'LHR', 'EGLL', 'London', 'Greater London', 'United Kingdom', 51.4700000, -0.4543000, 'Europe/London', 'international', 1, '2026-10-02 14:59:40', '2026-10-02 14:59:40');

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
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_booking_id_foreign` (`booking_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maskapais`
--
ALTER TABLE `maskapais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `penerbangans`
--
ALTER TABLE `penerbangans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wilayahs`
--
ALTER TABLE `wilayahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

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
