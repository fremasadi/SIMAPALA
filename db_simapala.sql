-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 04:26 PM
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
-- Database: `db_simapala`
--

-- --------------------------------------------------------

--
-- Table structure for table `alats`
--

CREATE TABLE `alats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_alat` varchar(255) NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `bahan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bahan`)),
  `image` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','dipinjam','rusak','hilang') NOT NULL DEFAULT 'tersedia',
  `harga_alat` decimal(15,2) DEFAULT NULL,
  `harga_sewa` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alats`
--

INSERT INTO `alats` (`id`, `kode_alat`, `nama_alat`, `ukuran`, `bahan`, `image`, `status`, `harga_alat`, `harga_sewa`, `created_at`, `updated_at`) VALUES
(15, 'AL001', 'Carier Eiger', '45 L', '[\"Nilon\"]', 'alats/01KHSP92HW2GPMB4A23C3NYNNT.jpg', 'dipinjam', 350000.00, 10000, '2026-02-18 17:54:54', '2026-04-22 10:30:27'),
(16, 'AL002', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'hilang', 100000.00, 5000, '2026-02-18 17:58:09', '2026-04-22 10:19:41'),
(17, 'AL003', 'Tenda (Kapasitas 2 Orang)', '205x140x105 cm', '[\"Nilon\"]', 'alats/01KHSRP6Q9ZYNP666YWPRDESXP.jpg', 'dipinjam', NULL, 15000, '2026-02-18 18:37:02', '2026-04-22 10:32:11'),
(18, 'AL004', 'Carabiner', '10 cm', '[\"Baja\"]', 'alats/01KHSRV1E5EHGCV04B0BGKEJH2.jpg', 'dipinjam', 300000.00, 10000, '2026-02-18 18:39:40', '2026-04-22 10:30:27'),
(19, 'AL005', 'Kompor Portabel', '11x11x10 cm', '[\"Stainless Steel\"]', 'alats/01KHSSKN9VY49YBYRAGJ5CFRZ1.jpg', 'tersedia', 50000.00, 5000, '2026-02-18 18:53:07', '2026-04-22 06:20:13'),
(20, 'AL006', 'Tenda (Kapasitas 4 Orang)', '205x140x105 cm', '[\"Nilon\"]', 'alats/01KJ59MR73AJR1MXKXRM5WBCY4.jpg', 'tersedia', NULL, 10000, '2026-02-23 06:04:59', '2026-03-12 08:21:00'),
(21, 'AL002-copy-1', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'dipinjam', 100000.00, 5000, '2026-04-07 06:38:45', '2026-04-22 10:30:27'),
(22, 'AL002-copy-2', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'tersedia', 100000.00, 5000, '2026-04-07 06:38:45', '2026-04-07 06:38:45'),
(23, 'AL002-copy-3', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'tersedia', 100000.00, 5000, '2026-04-07 06:38:45', '2026-04-07 06:38:45'),
(24, 'AL002-copy-4', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'tersedia', 100000.00, 5000, '2026-04-07 06:38:45', '2026-04-07 06:38:45'),
(25, 'AL002-copy-5', 'Matras', '180x60 cm', '[\"Karet Sintesis\"]', 'alats/01KHSPF0XT48S205PBJCTGVZ81.jpg', 'tersedia', 100000.00, 5000, '2026-04-07 06:38:45', '2026-04-07 06:38:45'),
(26, 'AL004-copy-1', 'Carabiner', '10 cm', '[\"Baja\"]', 'alats/01KHSRV1E5EHGCV04B0BGKEJH2.jpg', 'tersedia', 300000.00, 10000, '2026-04-07 06:39:19', '2026-04-22 06:14:23'),
(27, 'AL004-copy-2', 'Carabiner', '10 cm', '[\"Baja\"]', 'alats/01KHSRV1E5EHGCV04B0BGKEJH2.jpg', 'tersedia', 300000.00, 10000, '2026-04-07 06:39:19', '2026-04-22 06:13:59'),
(28, 'AL004-copy-3', 'Carabiner', '10 cm', '[\"Baja\"]', 'alats/01KHSRV1E5EHGCV04B0BGKEJH2.jpg', 'tersedia', 300000.00, 10000, '2026-04-07 06:39:19', '2026-04-22 06:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `alat_hilang_logs`
--

CREATE TABLE `alat_hilang_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `denda` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `foto_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alat_hilang_logs`
--

INSERT INTO `alat_hilang_logs` (`id`, `alat_id`, `user_id`, `transaksi_id`, `denda`, `keterangan`, `foto_pembayaran`, `created_at`, `updated_at`) VALUES
(3, 16, 7, 87, 100000.00, 'Alat hilang saat pengembalian — Transaksi #87', NULL, '2026-04-22 10:19:41', '2026-04-22 10:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `status_keanggotaan` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotas`
--

INSERT INTO `anggotas` (`id`, `user_id`, `nim`, `status_keanggotaan`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, '123455', 'aktif', NULL, '2025-11-17 23:49:21', '2025-11-17 23:49:21'),
(4, 12, '213375847', 'aktif', NULL, '2026-02-23 05:59:36', '2026-02-23 05:59:36'),
(5, 13, '2331730115', 'aktif', NULL, '2026-03-12 08:05:40', '2026-03-12 08:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `bahans`
--

CREATE TABLE `bahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahans`
--

INSERT INTO `bahans` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Nilon', NULL, '2026-02-23 06:03:27', '2026-02-23 06:03:27'),
(2, 'Baja', NULL, '2026-04-22 06:10:56', '2026-04-22 06:10:56'),
(3, 'Stainless Steel', NULL, '2026-04-22 06:17:09', '2026-04-22 06:19:26'),
(4, 'Karet Sintesis', NULL, '2026-04-22 06:18:23', '2026-04-22 06:19:11'),
(5, 'Alumunium', NULL, '2026-04-22 06:19:43', '2026-04-22 06:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1776785434),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1776785434;', 1776785434),
('livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1776874957),
('livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1776874957;', 1776874957);

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
-- Table structure for table `dana_masuks`
--

CREATE TABLE `dana_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('penyewaan','denda_telat','denda_rusak','kas','sumbangan','dana_kampus') NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sumber_type` varchar(255) DEFAULT NULL,
  `sumber_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_masuks`
--

INSERT INTO `dana_masuks` (`id`, `jenis`, `nominal`, `keterangan`, `tanggal`, `status`, `user_id`, `sumber_type`, `sumber_id`, `created_at`, `updated_at`) VALUES
(1, 'sumbangan', 1000000.00, 'amal', '2026-03-16', 'pending', 12, NULL, NULL, '2026-03-16 07:24:35', '2026-03-16 07:24:35'),
(2, 'kas', 10000.00, 'Kas bulanan — aura', '2026-03-16', 'approved', 13, 'App\\Models\\KasPembayaran', 6, '2026-03-16 07:37:06', '2026-03-16 07:37:06'),
(5, 'sumbangan', 1000000.00, 'Dana Kampus', '2026-03-16', 'pending', 1, NULL, NULL, '2026-03-16 07:53:55', '2026-03-16 07:53:55'),
(7, 'sumbangan', 200000.00, 'beli alat', '2026-03-31', 'pending', 13, NULL, NULL, '2026-03-31 06:41:59', '2026-03-31 06:41:59'),
(16, 'penyewaan', 20000.00, 'Pembayaran sewa — Order #SEWA-87-1776878072', '2026-04-22', 'approved', 7, 'App\\Models\\TransaksiAlat', 87, '2026-04-22 10:15:22', '2026-04-22 10:15:22'),
(17, 'denda_rusak', 100000.00, 'Denda rusak alat — Transaksi #87', '2026-04-22', 'approved', 7, 'App\\Models\\TransaksiAlat', 87, '2026-04-22 10:19:41', '2026-04-22 10:19:41'),
(18, 'penyewaan', 25000.00, 'Pembayaran sewa — Order #SEWA-88-1776878998', '2026-04-22', 'approved', 7, 'App\\Models\\TransaksiAlat', 88, '2026-04-22 10:30:27', '2026-04-22 10:30:27'),
(19, 'penyewaan', 15000.00, 'Pembayaran sewa — Order #SEWA-89-1776879073', '2026-04-22', 'approved', 7, 'App\\Models\\TransaksiAlat', 89, '2026-04-22 10:32:11', '2026-04-22 10:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `kondisi_kembali` enum('baik','rusak','hilang') DEFAULT NULL,
  `denda_telat` decimal(10,2) DEFAULT 0.00,
  `denda_rusak` decimal(10,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `foto_kembali` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id`, `transaksi_id`, `alat_id`, `kondisi_kembali`, `denda_telat`, `denda_rusak`, `keterangan`, `foto_kembali`, `created_at`, `updated_at`) VALUES
(102, 87, 15, 'baik', 0.00, 0.00, NULL, NULL, '2026-04-22 10:14:32', '2026-04-22 10:19:41'),
(103, 87, 16, 'hilang', 0.00, 100000.00, NULL, NULL, '2026-04-22 10:14:32', '2026-04-22 10:19:41'),
(104, 87, 21, 'baik', 0.00, 0.00, NULL, NULL, '2026-04-22 10:14:32', '2026-04-22 10:19:41'),
(105, 88, 18, NULL, 0.00, 0.00, NULL, NULL, '2026-04-22 10:29:58', '2026-04-22 10:29:58'),
(106, 88, 15, NULL, 0.00, 0.00, NULL, NULL, '2026-04-22 10:29:58', '2026-04-22 10:29:58'),
(107, 88, 21, NULL, 0.00, 0.00, NULL, NULL, '2026-04-22 10:29:58', '2026-04-22 10:29:58'),
(108, 89, 17, NULL, 0.00, 0.00, NULL, NULL, '2026-04-22 10:31:13', '2026-04-22 10:31:13');

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
-- Table structure for table `kas_bulanans`
--

CREATE TABLE `kas_bulanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `tahun` smallint(5) UNSIGNED NOT NULL,
  `nominal` double NOT NULL DEFAULT 10000,
  `status` enum('belum_lunas','lunas') NOT NULL DEFAULT 'belum_lunas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kas_bulanans`
--

INSERT INTO `kas_bulanans` (`id`, `user_id`, `bulan`, `tahun`, `nominal`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 12, 2025, 10000, 'lunas', '2025-12-22 20:12:16', '2025-12-22 20:27:19'),
(3, 12, 2, 2026, 10000, 'belum_lunas', '2026-02-23 05:58:02', '2026-02-23 06:00:05'),
(4, 13, 3, 2026, 10000, 'lunas', '2026-03-12 08:05:40', '2026-03-12 08:19:09'),
(5, 2, 1, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(6, 12, 1, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(7, 13, 1, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(8, 2, 2, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(9, 12, 2, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(10, 13, 2, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:01', '2026-03-16 07:30:01'),
(11, 2, 3, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(12, 12, 3, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(13, 13, 3, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(14, 2, 4, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(15, 12, 4, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(16, 13, 4, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(17, 2, 5, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(18, 12, 5, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(19, 13, 5, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(20, 2, 6, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(21, 12, 6, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(22, 13, 6, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(23, 2, 7, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(24, 12, 7, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(25, 13, 7, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(26, 2, 8, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(27, 12, 8, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(28, 13, 8, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(29, 2, 9, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(30, 12, 9, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(31, 13, 9, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(32, 2, 10, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(33, 12, 10, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(34, 13, 10, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(35, 2, 11, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(36, 12, 11, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(37, 13, 11, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(38, 12, 12, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(39, 13, 12, 2025, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(40, 2, 1, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(41, 12, 1, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(42, 13, 1, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(43, 2, 2, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(44, 13, 2, 2026, 10000, 'lunas', '2026-03-16 07:30:02', '2026-03-16 07:37:06'),
(45, 2, 3, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(46, 12, 3, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(47, 2, 4, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(48, 12, 4, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(49, 13, 4, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(50, 2, 5, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(51, 12, 5, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(52, 13, 5, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(53, 2, 6, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(54, 12, 6, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(55, 13, 6, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(56, 2, 7, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(57, 12, 7, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(58, 13, 7, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(59, 2, 8, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(60, 12, 8, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(61, 13, 8, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(62, 2, 9, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(63, 12, 9, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(64, 13, 9, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(65, 2, 10, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(66, 12, 10, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(67, 13, 10, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(68, 2, 11, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(69, 12, 11, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(70, 13, 11, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(71, 2, 12, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(72, 12, 12, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02'),
(73, 13, 12, 2026, 10000, 'belum_lunas', '2026-03-16 07:30:02', '2026-03-16 07:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `kas_pembayarans`
--

CREATE TABLE `kas_pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kas_bulanan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` double NOT NULL,
  `metode` enum('dana','cash') NOT NULL DEFAULT 'dana',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak') NOT NULL DEFAULT 'menunggu',
  `tanggal_bayar` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_status` varchar(255) DEFAULT NULL,
  `fraud_status` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_url` text DEFAULT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `va_number` varchar(255) DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL,
  `settlement_time` timestamp NULL DEFAULT NULL,
  `midtrans_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`midtrans_response`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kas_pembayarans`
--

INSERT INTO `kas_pembayarans` (`id`, `kas_bulanan_id`, `user_id`, `nominal`, `metode`, `bukti_bayar`, `status`, `tanggal_bayar`, `keterangan`, `verified_by`, `verified_at`, `created_at`, `updated_at`, `order_id`, `transaction_id`, `transaction_status`, `fraud_status`, `payment_type`, `payment_url`, `snap_token`, `bank`, `va_number`, `transaction_time`, `settlement_time`, `midtrans_response`) VALUES
(1, 1, 2, 10000, 'cash', NULL, 'diterima', '2025-12-23', 'lunas', NULL, NULL, '2025-12-22 20:27:07', '2025-12-22 20:27:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 3, 12, 5000, 'dana', NULL, 'menunggu', '2026-02-23', NULL, NULL, NULL, '2026-02-23 06:01:34', '2026-02-23 06:01:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 4, 13, 10000, 'cash', NULL, 'diterima', '2026-03-12', NULL, NULL, NULL, '2026-03-12 08:17:57', '2026-03-12 08:19:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 44, 13, 10000, 'dana', 'kas/bukti/9cdvBpSYUN51WxlYBpmcX6PsIlmWh1UwiyoTLAkD.jpg', 'diterima', '2026-03-16', NULL, 1, '2026-03-16 07:37:06', '2026-03-16 07:33:01', '2026-03-16 07:37:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(4, '2025_11_18_064312_create_anggotas_table', 2),
(5, '2025_11_18_071648_create_alats_table', 3),
(9, '2025_11_18_102431_create_transaksi_alats_table', 4),
(10, '2025_11_18_102202_create_pembayarans_table', 5),
(11, '2025_12_17_072058_create_personal_access_tokens_table', 6),
(12, '2025_12_17_072130_create_personal_access_tokens_table', 7),
(14, '2025_12_23_020126_add_kondisi_denda_to_detail_transaksis_table', 8),
(15, '2025_12_23_030239_create_kas_bulanans_table', 9),
(16, '2025_12_23_030258_create_kas_pembayarans_table', 9),
(17, '2026_01_28_115652_add_ukuran_and_bahan_to_alats_table', 10),
(18, '2026_01_28_142615_add_image_to_alats_table', 11),
(19, '2026_02_23_000001_change_bahan_to_json_in_alats_table', 12),
(20, '2026_02_23_000002_create_bahans_table', 12),
(21, '2026_02_24_000001_make_kondisi_kembali_nullable_in_detail_transaksis', 13),
(22, '2026_03_13_000001_replace_denda_with_denda_telat_rusak_in_detail_transaksis', 14),
(23, '2026_03_13_153013_create_dana_masuks_table', 15),
(24, '2026_03_13_153556_add_dana_kampus_to_dana_masuks_jenis', 15),
(25, '2026_03_14_200334_add_status_to_dana_masuks_table', 15),
(26, '2026_03_16_071333_add_image_to_anggotas_table', 15),
(30, '2026_04_07_034327_add_harga_alat_to_alats_table', 16),
(31, '2026_04_15_105216_create_alat_hilang_logs_table', 16),
(32, '2026_04_21_152228_add_foto_pembayaran_to_alat_hilang_logs_table', 17),
(33, '2026_04_23_000001_add_midtrans_fields_to_kas_pembayarans_table', 18);

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
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `gross_amount` decimal(12,2) NOT NULL,
  `payment_type` enum('credit_card','bank_transfer','echannel','gopay','qris','shopeepay','other') DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `va_number` varchar(255) DEFAULT NULL,
  `transaction_status` enum('pending','settlement','capture','deny','cancel','expire','failure') NOT NULL DEFAULT 'pending',
  `fraud_status` text DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL,
  `settlement_time` timestamp NULL DEFAULT NULL,
  `payment_url` text DEFAULT NULL,
  `midtrans_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`midtrans_response`)),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `transaksi_id`, `order_id`, `transaction_id`, `gross_amount`, `payment_type`, `bank`, `va_number`, `transaction_status`, `fraud_status`, `transaction_time`, `settlement_time`, `payment_url`, `midtrans_response`, `notes`, `created_at`, `updated_at`) VALUES
(27, 87, 'SEWA-87-1776878072', 'c5bb5c31-3f3e-4ff6-9d5a-4f6daed912e8', 20000.00, 'bank_transfer', 'bri', '368453437470675056', 'settlement', 'accept', '2026-04-22 17:15:03', '2026-04-22 10:15:35', 'https://app.sandbox.midtrans.com/snap/v4/redirection/aae983c6-641e-427c-b9e3-f30547db4556', '{\"status_code\":\"200\",\"transaction_id\":\"c5bb5c31-3f3e-4ff6-9d5a-4f6daed912e8\",\"gross_amount\":\"20000.00\",\"currency\":\"IDR\",\"order_id\":\"SEWA-87-1776878072\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"0435af6979d7dfd545b3d3b24f71e3b30e986232fc22506c3c90426dd88b19bdb67600406f567c6e800c1ab4112e2b3d389c54af258cc7f9d9f8f85f50958e49\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G155536845\",\"va_numbers\":[{\"bank\":\"bri\",\"va_number\":\"368453437470675056\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-04-23 00:15:03\",\"settlement_time\":\"2026-04-23 00:15:18\",\"expiry_time\":\"2026-04-24 00:15:03\"}', NULL, '2026-04-22 10:14:34', '2026-04-22 10:15:35'),
(28, 88, 'SEWA-88-1776878998', 'b5160e25-e452-4f95-b499-deeb61d95664', 25000.00, 'bank_transfer', 'bri', '368453672769522025', 'settlement', 'accept', '2026-04-22 17:30:13', '2026-04-22 10:30:35', 'https://app.sandbox.midtrans.com/snap/v4/redirection/ae1d83ec-a61c-49be-8d6c-d6d916a5d33c', '{\"status_code\":\"200\",\"transaction_id\":\"b5160e25-e452-4f95-b499-deeb61d95664\",\"gross_amount\":\"25000.00\",\"currency\":\"IDR\",\"order_id\":\"SEWA-88-1776878998\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"e06007f52eda0fbe95434645cb4605943717ea9adea073f8d7dd2d363223584a313ccab1e7375cf353a081cbc0fb8f868a31dada5b8e427bef5dfac48ca0ff84\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G155536845\",\"va_numbers\":[{\"bank\":\"bri\",\"va_number\":\"368453672769522025\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-04-23 00:30:13\",\"settlement_time\":\"2026-04-23 00:30:21\",\"expiry_time\":\"2026-04-24 00:30:12\"}', NULL, '2026-04-22 10:30:00', '2026-04-22 10:30:35'),
(29, 89, 'SEWA-89-1776879073', 'aa0ee8d9-2c19-45c5-a240-644bf56e6aea', 15000.00, 'bank_transfer', 'bca', '36845088878883794841840', 'settlement', 'accept', '2026-04-22 17:31:31', '2026-04-22 10:32:21', 'https://app.sandbox.midtrans.com/snap/v4/redirection/997c6e5f-6199-4012-a5c0-ae7b59c0eabe', '{\"status_code\":\"200\",\"transaction_id\":\"aa0ee8d9-2c19-45c5-a240-644bf56e6aea\",\"gross_amount\":\"15000.00\",\"currency\":\"IDR\",\"order_id\":\"SEWA-89-1776879073\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"dc8e58b79c8249b80ac91053ccbbdbb5a1678ee79af140a440bb3d67f6089b5fe5f8ae2eb91c9e0be43b0741835e55d7a2010c5c7030b999850fdd3befd46dc0\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G155536845\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"36845088878883794841840\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-04-23 00:31:31\",\"settlement_time\":\"2026-04-23 00:32:06\",\"expiry_time\":\"2026-04-24 00:31:31\"}', NULL, '2026-04-22 10:31:15', '2026-04-22 10:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
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
(30, 'App\\Models\\User', 2, 'api_token', '4d4612be50131ad950ec2a283a8328e71d066cf81563da930a7765b9ef4911ce', '[\"*\"]', '2025-12-22 23:26:34', NULL, '2025-12-22 23:26:09', '2025-12-22 23:26:34'),
(35, 'App\\Models\\User', 4, 'api_token', 'a294987c00c1ba2fc0b877897361652879994787980b2ef79797963510b17b13', '[\"*\"]', '2025-12-23 01:51:00', NULL, '2025-12-23 00:32:54', '2025-12-23 01:51:00'),
(39, 'App\\Models\\User', 13, 'api_token', 'e120578f8bdec438667ad51649e63699dea033b0a5df3a3c9f307c1511535d86', '[\"*\"]', '2026-04-22 09:54:12', NULL, '2026-04-22 09:40:08', '2026-04-22 09:54:12');

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
('0BdbzdSOHOVLEr6Hfp5FG6jCXWQSfV4pYceKwQHk', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibzdRUkIwTlRkZUlNY205eVBvdjFZTW5RMXowRm5sbzdSN1RNSXlMeSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwODAvcGF5bWVudC8yOSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1776879141),
('DDGsU6PQTWjFNSJpbrsCp02saEv9KMnvV8mcmVcK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNVZBQmFMTXMwNjFKc3l0MUR1bWFaajlYN25wU0pKRFVGR2ZqTjRLMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiQxOTQvMlhDbFVRSzZGR1Y0Ylc3cHcucktZSzdiSWJjVXpMSTRvbTZ4dUMyalk5aE9jM3ZGMiI7czo2OiJ0YWJsZXMiO2E6ODp7czo0MDoiMDJmODIzZmI1ZTE3YTI5ZWI2ZjRhZDczODdiZThkMjdfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToidXNlci5uYW1lIjtzOjU6ImxhYmVsIjtzOjQ6Ik5hbWEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InVzZXIucm9sZSI7czo1OiJsYWJlbCI7czoxMzoiUGVyYW4gUGVtZXNhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6ImplbmlzX3RyYW5zYWtzaSI7czo1OiJsYWJlbCI7czo1OiJKZW5pcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6InRhbmdnYWxfYWp1YW4iO3M6NToibGFiZWwiO3M6MTM6IlRhbmdnYWwgQWp1YW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJ0YW5nZ2FsX3BpbmphbSI7czo1OiJsYWJlbCI7czoxNDoiVGFuZ2dhbCBQaW5qYW0iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJ0YW5nZ2FsX2tlbWJhbGkiO3M6NToibGFiZWwiO3M6MTU6IlRhbmdnYWwgS2VtYmFsaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjY6IlN0YXR1cyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InRvdGFsX2JpYXlhIjtzOjU6ImxhYmVsIjtzOjExOiJUb3RhbCBCaWF5YSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mjk6InBlbWJheWFyYW4udHJhbnNhY3Rpb25fc3RhdHVzIjtzOjU6ImxhYmVsIjtzOjE3OiJTdGF0dXMgUGVtYmF5YXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiYWU1ZTFkMTgzMWE1NjAyNmM4OTIxMGFlMzMxNWEzYzJfY29sdW1ucyI7YToxMDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6ImltYWdlIjtzOjU6ImxhYmVsIjtzOjY6IkdhbWJhciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToia29kZV9hbGF0IjtzOjU6ImxhYmVsIjtzOjk6IktvZGUgQWxhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToibmFtYV9hbGF0IjtzOjU6ImxhYmVsIjtzOjk6Ik5hbWEgQWxhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoidWt1cmFuIjtzOjU6ImxhYmVsIjtzOjY6IlVrdXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiYmFoYW4iO3M6NToibGFiZWwiO3M6NToiQmFoYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InN0YXR1cyI7czo1OiJsYWJlbCI7czo2OiJTdGF0dXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJoYXJnYV9hbGF0IjtzOjU6ImxhYmVsIjtzOjEwOiJIYXJnYSBBbGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiaGFyZ2Ffc2V3YSI7czo1OiJsYWJlbCI7czoxMDoiSGFyZ2EgU2V3YSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjk7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiNDE5NDlkNzQyYTBlNzMwMWEwZWNkZTIwYWUzZDg3NTJfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToidXNlci5uYW1lIjtzOjU6ImxhYmVsIjtzOjQ6Ik5hbWEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJqZW5pc190cmFuc2Frc2kiO3M6NToibGFiZWwiO3M6NToiSmVuaXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJ0YW5nZ2FsX3BpbmphbSI7czo1OiJsYWJlbCI7czoxMDoiVGdsIFBpbmphbSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6InRhbmdnYWxfa2VtYmFsaSI7czo1OiJsYWJlbCI7czoxMToiVGdsIEtlbWJhbGkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InN0YXR1cyI7czo1OiJsYWJlbCI7czo2OiJTdGF0dXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI5OiJwZW1iYXlhcmFuLnRyYW5zYWN0aW9uX3N0YXR1cyI7czo1OiJsYWJlbCI7czoxMDoiUGVtYmF5YXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InRvdGFsX2JpYXlhIjtzOjU6ImxhYmVsIjtzOjU6IlRvdGFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIwOWYzODA5NjRkZmZiZTY3M2U3ZjFmMGRlZWNkMjgzN19jb2x1bW5zIjthOjk6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czo3OiJUYW5nZ2FsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoiYWxhdC5rb2RlX2FsYXQiO3M6NToibGFiZWwiO3M6OToiS29kZSBBbGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoiYWxhdC5uYW1hX2FsYXQiO3M6NToibGFiZWwiO3M6OToiTmFtYSBBbGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJ1c2VyLm5hbWUiO3M6NToibGFiZWwiO3M6MTY6IkRpaGlsYW5na2FuIE9sZWgiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InVzZXIucm9sZSI7czo1OiJsYWJlbCI7czo1OiJQZXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6InRyYW5zYWtzaV9pZCI7czo1OiJsYWJlbCI7czoxMToiVHJhbnNha3NpICMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6ImRlbmRhIjtzOjU6ImxhYmVsIjtzOjU6IkRlbmRhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoia2V0ZXJhbmdhbiI7czo1OiJsYWJlbCI7czoxMDoiS2V0ZXJhbmdhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjA7fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNToiZm90b19wZW1iYXlhcmFuIjtzOjU6ImxhYmVsIjtzOjEwOiJGb3RvIEJ1a3RpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9fXM6NDA6IjI0ZjNkYjVjN2EzMzg3OTI2ZGRmNWIzODk1MGRlM2UzX2NvbHVtbnMiO2E6Nzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJ0YW5nZ2FsX2JheWFyIjtzOjU6ImxhYmVsIjtzOjEzOiJUYW5nZ2FsIEJheWFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJ1c2VyLm5hbWUiO3M6NToibGFiZWwiO3M6MTI6Ik5hbWEgQW5nZ290YSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Nzoibm9taW5hbCI7czo1OiJsYWJlbCI7czo3OiJOb21pbmFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJtZXRvZGUiO3M6NToibGFiZWwiO3M6NjoiTWV0b2RlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiYnVrdGlfYmF5YXIiO3M6NToibGFiZWwiO3M6MTE6IkJ1a3RpIEJheWFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToidmVyaWZpZWRfYXQiO3M6NToibGFiZWwiO3M6MTI6IkRpdmVyaWZpa2FzaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI5YzMyNjlmYmExN2QyOTY2Y2U2MDkzY2U3NDZkODhjM19jb2x1bW5zIjthOjEwOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6ODoib3JkZXJfaWQiO3M6NToibGFiZWwiO3M6ODoiT3JkZXIgaWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJncm9zc19hbW91bnQiO3M6NToibGFiZWwiO3M6MTE6IlRvdGFsIGhhcmdhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoicGF5bWVudF90eXBlIjtzOjU6ImxhYmVsIjtzOjE3OiJNZXRvZGUgUGVtYmF5YXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoiYmFuayI7czo1OiJsYWJlbCI7czo5OiJOYW1hIEJhbmsiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InZhX251bWJlciI7czo1OiJsYWJlbCI7czo5OiJWYSBOdW1iZXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE4OiJ0cmFuc2FjdGlvbl9zdGF0dXMiO3M6NToibGFiZWwiO3M6MTY6IlN0YXR1cyBUcmFuc2Frc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE2OiJ0cmFuc2FjdGlvbl90aW1lIjtzOjU6ImxhYmVsIjtzOjE1OiJXYWt0dSBUcmFuc2Frc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJzZXR0bGVtZW50X3RpbWUiO3M6NToibGFiZWwiO3M6MTM6Ildha3R1IERpYmF5YXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6OTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiYjRkNGI5MzAzYjgzYTVjOTU4MTljODUzMTMxNWYyOGRfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTQ6ImFsYXQubmFtYV9hbGF0IjtzOjU6ImxhYmVsIjtzOjQ6IkFsYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJrb25kaXNpX2tlbWJhbGkiO3M6NToibGFiZWwiO3M6NzoiS29uZGlzaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImRlbmRhX3RlbGF0IjtzOjU6ImxhYmVsIjtzOjExOiJEZW5kYSBUZWxhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImRlbmRhX3J1c2FrIjtzOjU6ImxhYmVsIjtzOjExOiJEZW5kYSBSdXNhayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InRvdGFsX2RlbmRhIjtzOjU6ImxhYmVsIjtzOjExOiJUb3RhbCBEZW5kYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImtldGVyYW5nYW4iO3M6NToibGFiZWwiO3M6MTA6IktldGVyYW5nYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJmb3RvX2tlbWJhbGkiO3M6NToibGFiZWwiO3M6NDoiRm90byI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNTNjYmE3M2IzMmM2YjA3MTA0MWE1NWY5ODdkZDM5ODFfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToidXNlci5uYW1lIjtzOjU6ImxhYmVsIjtzOjEyOiJOYW1hIEFuZ2dvdGEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6ImJ1bGFuIjtzOjU6ImxhYmVsIjtzOjg6IkJ1bGFuIGtlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJ0YWh1biI7czo1OiJsYWJlbCI7czo4OiJUYWh1biBrZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Nzoibm9taW5hbCI7czo1OiJsYWJlbCI7czo3OiJOb21pbmFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX19fQ==', 1776879318),
('IP1flpPgbC7gFtJlnhubEHVH0e2vGw4XHFfcji6b', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOTM2cVV0VU43RVdPOUxVNDMxSllxWGVSNDJqVkYxcFYwYXN4ZXRxRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1776872397);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_alats`
--

CREATE TABLE `transaksi_alats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_transaksi` enum('pinjam','sewa') NOT NULL,
  `tanggal_ajuan` date NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','dipinjam','dikembalikan','dibatalkan') NOT NULL DEFAULT 'menunggu',
  `total_biaya` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_alats`
--

INSERT INTO `transaksi_alats` (`id`, `user_id`, `jenis_transaksi`, `tanggal_ajuan`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `total_biaya`, `created_at`, `updated_at`) VALUES
(87, 7, 'sewa', '2026-04-22', '2026-04-23', '2026-04-24', 'dikembalikan', 20000, '2026-04-22 10:14:32', '2026-04-22 10:19:41'),
(88, 7, 'sewa', '2026-04-22', '2026-04-23', '2026-04-24', 'dipinjam', 25000, '2026-04-22 10:29:58', '2026-04-22 10:32:55'),
(89, 7, 'sewa', '2026-04-22', '2026-04-23', '2026-04-24', 'dipinjam', 15000, '2026-04-22 10:31:13', '2026-04-22 10:33:03');

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
  `role` enum('admin','anggota','penyewa') NOT NULL DEFAULT 'anggota',
  `no_hp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `no_hp`, `alamat`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$194/2XClUQK6FGV4bW7pw.rKYK7bIbcUzLI4om6xuC2jY9hOc3vF2', 'admin', NULL, NULL, 'IKg28DmDjRuvojxKikctsw178T9AJgfhWCIt4wa4AiACzrizywKqkPKF6KMP', '2025-11-17 23:40:42', '2025-11-17 23:40:42'),
(2, 'fremas', 'fremas@gmail.com', NULL, '$2y$12$.B00nV4rXoQdlazErle99.9jl8UpYXvkk9Sbp26kkmJGqeI9vvhai', 'anggota', NULL, NULL, NULL, '2025-11-17 23:49:21', '2025-11-17 23:49:21'),
(6, 'mark', 'mark@gmail.com', NULL, '$2y$12$SbkqKLw2Hxabn4n4m8xRHe94ojgHJC0jaR7tj.Bf4rJ/.C8XKXAzG', 'penyewa', '081233667788', 'kediri', NULL, '2026-02-09 21:27:01', '2026-02-09 21:27:01'),
(7, 'kim taehyung', 'tae@gmail.com', NULL, '$2y$12$zzTno65LI2aSN4.YKF14x.xAt1O.3ciBh/OBA7oj.4vjQWKKre7je', 'penyewa', '081999888777', 'kediri', 'LAOsRzwptxfmjWeFdH9uiOgXgWkPjaVoFTo8N0XH6aDGu6uHGzebLjqnqzlE', '2026-02-09 21:48:11', '2026-02-09 21:48:11'),
(9, 'Aura Primadita Pratama', 'rara@gmail.com', NULL, '$2y$12$i5U9CqZQWP6YEDMcg6CEhOQu3TY48jJNzaQHWCwE6iESV6wBYd80W', 'admin', '081322264965', 'Jln Sersan KKO Harun', NULL, '2026-02-17 20:10:58', '2026-02-17 20:10:58'),
(11, 'Lee Jeno', 'jeno@gmail.com', NULL, '$2y$12$ac9AMH2mc1pXmdpmbEzZM.9QM76MNps5hHfs/CBqOlo0f72ecu9z.', 'penyewa', '081344567821', 'Jln KKO Usman', NULL, '2026-02-17 20:17:28', '2026-02-17 20:17:28'),
(12, 'Lucky', 'luckywiyata@gmail.com', NULL, '$2y$12$SH5vroAF1SdYN5Ud4p6rHe/pTYDlPjQh1iOQAxlUvJ7aAAKytb2Tq', 'anggota', NULL, NULL, NULL, '2026-02-23 05:59:36', '2026-02-23 05:59:36'),
(13, 'aura', 'aura@gmail.com', NULL, '$2y$12$lvpL8mQmOufij9uI/W8wtu6hi5Cr1eH2ZqB9ti/ZJwhURfVxgxA2a', 'anggota', NULL, NULL, NULL, '2026-03-12 08:05:40', '2026-03-12 08:05:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alats`
--
ALTER TABLE `alats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alats_kode_alat_unique` (`kode_alat`);

--
-- Indexes for table `alat_hilang_logs`
--
ALTER TABLE `alat_hilang_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alat_hilang_logs_alat_id_foreign` (`alat_id`),
  ADD KEY `alat_hilang_logs_user_id_foreign` (`user_id`),
  ADD KEY `alat_hilang_logs_transaksi_id_foreign` (`transaksi_id`);

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggotas_nim_unique` (`nim`),
  ADD KEY `anggotas_user_id_foreign` (`user_id`);

--
-- Indexes for table `bahans`
--
ALTER TABLE `bahans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bahans_name_unique` (`name`);

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
-- Indexes for table `dana_masuks`
--
ALTER TABLE `dana_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dana_masuks_user_id_foreign` (`user_id`),
  ADD KEY `dana_masuks_sumber_type_sumber_id_index` (`sumber_type`,`sumber_id`);

--
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_transaksi_id_foreign` (`transaksi_id`);

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
-- Indexes for table `kas_bulanans`
--
ALTER TABLE `kas_bulanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kas_bulanans_user_id_bulan_tahun_unique` (`user_id`,`bulan`,`tahun`);

--
-- Indexes for table `kas_pembayarans`
--
ALTER TABLE `kas_pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_pembayarans_kas_bulanan_id_foreign` (`kas_bulanan_id`),
  ADD KEY `kas_pembayarans_user_id_foreign` (`user_id`),
  ADD KEY `kas_pembayarans_verified_by_foreign` (`verified_by`),
  ADD KEY `kas_pembayarans_order_id_index` (`order_id`);

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
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembayarans_order_id_unique` (`order_id`),
  ADD KEY `pembayarans_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `pembayarans_order_id_index` (`order_id`),
  ADD KEY `pembayarans_transaction_id_index` (`transaction_id`),
  ADD KEY `pembayarans_transaction_status_index` (`transaction_status`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi_alats`
--
ALTER TABLE `transaksi_alats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_alats_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `alats`
--
ALTER TABLE `alats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `alat_hilang_logs`
--
ALTER TABLE `alat_hilang_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bahans`
--
ALTER TABLE `bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dana_masuks`
--
ALTER TABLE `dana_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_bulanans`
--
ALTER TABLE `kas_bulanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `kas_pembayarans`
--
ALTER TABLE `kas_pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `transaksi_alats`
--
ALTER TABLE `transaksi_alats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat_hilang_logs`
--
ALTER TABLE `alat_hilang_logs`
  ADD CONSTRAINT `alat_hilang_logs_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alat_hilang_logs_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi_alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alat_hilang_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD CONSTRAINT `anggotas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dana_masuks`
--
ALTER TABLE `dana_masuks`
  ADD CONSTRAINT `dana_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi_alats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_bulanans`
--
ALTER TABLE `kas_bulanans`
  ADD CONSTRAINT `kas_bulanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_pembayarans`
--
ALTER TABLE `kas_pembayarans`
  ADD CONSTRAINT `kas_pembayarans_kas_bulanan_id_foreign` FOREIGN KEY (`kas_bulanan_id`) REFERENCES `kas_bulanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kas_pembayarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kas_pembayarans_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi_alats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_alats`
--
ALTER TABLE `transaksi_alats`
  ADD CONSTRAINT `transaksi_alats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
