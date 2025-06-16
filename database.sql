-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for labels-mm
DROP DATABASE IF EXISTS `labels-mm`;
CREATE DATABASE IF NOT EXISTS `labels-mm` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `labels-mm`;

-- Dumping structure for table labels-mm.abouts
DROP TABLE IF EXISTS `abouts`;
CREATE TABLE IF NOT EXISTS `abouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tittle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.abouts: ~1 rows (approximately)
REPLACE INTO `abouts` (`id`, `tittle`, `deskripsi`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'LablesMM', 'Labels MM adalah aplikasi manajemen bisnis yang dirancang untuk menyederhanakan segala hal dari pencatatan transaksi, pengelolaan barang, hingga pelacakan stok dan laporan penjualan. Kami hadir untuk membantu UMKM, toko retail, dan pelaku usaha lainnya dalam menjalankan operasional harian secara lebih rapi, cepat, dan efisien.', 'images/abouts/1750045021_vB1ZysVpsQ.jpg', NULL, '2025-06-15 20:37:01');

-- Dumping structure for table labels-mm.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.cache: ~0 rows (approximately)

-- Dumping structure for table labels-mm.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.cache_locks: ~0 rows (approximately)

-- Dumping structure for table labels-mm.contacts
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.contacts: ~0 rows (approximately)

-- Dumping structure for table labels-mm.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table labels-mm.headers
DROP TABLE IF EXISTS `headers`;
CREATE TABLE IF NOT EXISTS `headers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tittle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.headers: ~1 rows (approximately)
REPLACE INTO `headers` (`id`, `tittle`, `image`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Butik Konveksi Berkualitas  dan Terpercaya.', 'images/headers/1750046338_5RyeeLUd3J.png', 'Melayani  pembuatan  pakaian    custom, \r\nseragam, hingga busana fashion dengan \r\nsentuhan   profesional  dan   hasil  terbaik.', NULL, '2025-06-15 20:58:58');

-- Dumping structure for table labels-mm.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.jobs: ~0 rows (approximately)

-- Dumping structure for table labels-mm.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.job_batches: ~0 rows (approximately)

-- Dumping structure for table labels-mm.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.migrations: ~14 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '0001_01_01_000000_create_users_table', 2),
	(3, '0001_01_01_000001_create_cache_table', 2),
	(4, '0001_01_01_000002_create_jobs_table', 2),
	(5, '2024_12_27_035742_product', 2),
	(7, '2024_12_27_041535_create_pemasukan_table', 2),
	(8, '2025_01_03_122356_create_headers_table', 2),
	(9, '2025_01_03_122428_create_abouts_table', 2),
	(10, '2025_01_03_122447_create_contacts_table', 2),
	(11, '2025_01_08_021000_create_pengeluaran_table', 2),
	(12, '2025_02_02_024216_create_tbl_bahans_table', 2),
	(13, '2025_02_02_030439_create_tbl_transaksis_table', 2),
	(14, '2025_02_26_025638_create_sessions_table', 2),
	(16, '2024_12_27_040844_create_pesanans_table', 3),
	(17, '2025_05_17_034954_create_resis_table', 4);

-- Dumping structure for table labels-mm.pemasukan
DROP TABLE IF EXISTS `pemasukan`;
CREATE TABLE IF NOT EXISTS `pemasukan` (
  `id_pemasukan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_referensi` int DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` decimal(20,2) NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pemasukan`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.pemasukan: ~36 rows (approximately)
REPLACE INTO `pemasukan` (`id_pemasukan`, `id_referensi`, `keterangan`, `nominal`, `created_by`, `created_at`, `updated_at`) VALUES
	(17, 11, 'Payment received for Order #11 - jahit (Qty: 1)', 4000000.00, '1', '2025-05-20 23:25:00', '2025-05-20 23:25:00'),
	(18, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 2000000.00, '1', '2025-05-20 23:27:18', '2025-05-20 23:27:18'),
	(19, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 1.00, '1', '2025-05-20 23:37:17', '2025-05-20 23:37:17'),
	(20, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 599.00, '1', '2025-05-20 23:38:07', '2025-05-20 23:38:07'),
	(21, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 1.00, '1', '2025-05-20 23:39:20', '2025-05-20 23:39:20'),
	(22, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 19.00, '1', '2025-05-20 23:39:38', '2025-05-20 23:39:38'),
	(23, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 199.00, '1', '2025-05-20 23:39:50', '2025-05-20 23:39:50'),
	(24, 12, 'Payment received for Order #12 - jahit (Qty: 1)', 1999177.00, '1', '2025-05-20 23:45:51', '2025-05-20 23:45:51'),
	(25, 13, 'Payment received for Order #13 - jahit (Qty: 1)', 1200000.00, '1', '2025-05-20 23:46:16', '2025-05-20 23:46:16'),
	(26, 13, 'Payment received for Order #13 - jahit (Qty: 1)', 2300000.00, '1', '2025-05-20 23:46:38', '2025-05-20 23:46:38'),
	(27, 13, 'Payment received for Order #13 - jahit (Qty: 1)', 500000.00, '1', '2025-05-20 23:47:06', '2025-05-20 23:47:06'),
	(51, 12, 'Payment received for Order #12 - hoodie (Qty: 1)', 130000.00, '3', '2025-05-28 20:17:33', '2025-05-28 20:17:33'),
	(52, 14, 'Payment received for Order #14 - kemeja (Qty: 1)', 75000.00, '3', '2025-05-28 20:22:23', '2025-05-28 20:22:23'),
	(54, 15, 'Payment received for Order #15 - hoodie (Qty: 1)', 130000.00, '1', '2025-05-31 04:38:25', '2025-05-31 04:38:25'),
	(55, 16, 'Payment received for Order #16 - kemeja (Qty: 1)', 112500.00, '1', '2025-05-31 04:41:23', '2025-05-31 04:41:23'),
	(56, 16, 'Payment received for Order #16 - kemeja (Qty: 1)', 28125.00, '1', '2025-05-31 04:42:56', '2025-05-31 04:42:56'),
	(57, 16, 'Payment received for Order #16 - kemeja (Qty: 1)', 7031.00, '1', '2025-05-31 04:48:48', '2025-05-31 04:48:48'),
	(58, 17, 'Payment received for Order #17 - hoodie (Qty: 1)', 65000.00, '1', '2025-05-31 04:52:27', '2025-05-31 04:52:27'),
	(59, 18, 'Payment received for Order #18 - jahit (Qty: 1)', 400.00, '1', '2025-05-31 05:00:39', '2025-05-31 05:00:39'),
	(60, 19, 'Payment received for Order #19 - hoodie (Qty: 1)', 130000.00, '1', '2025-05-31 05:05:36', '2025-05-31 05:05:36'),
	(61, 21, 'Payment received for Order #21 - jahit (Qty: 1)', 400.00, '1', '2025-05-31 05:15:50', '2025-05-31 05:15:50'),
	(62, 20, 'Payment received for Order #20 - kemeja (Qty: 1)', 75000.00, '1', '2025-05-31 05:17:01', '2025-05-31 05:17:01'),
	(63, 22, 'Payment received for Order #22 - kemeja (Qty: 1)', 75000.00, '1', '2025-05-31 05:32:37', '2025-05-31 05:32:37'),
	(65, 22, 'Payment received for Order #22 - kemeja (Qty: 1)', 37500.00, '1', '2025-05-31 05:35:40', '2025-05-31 05:35:40'),
	(66, 22, 'Payment received for Order #22 - kemeja (Qty: 1)', 37500.00, '1', '2025-05-31 05:35:53', '2025-05-31 05:35:53'),
	(67, 13, 'Payment received for Order #13 - kemeja (Qty: 1)', 75000.00, '1', '2025-05-31 06:06:41', '2025-05-31 06:06:41'),
	(68, 17, 'Payment received for Order #17 - hoodie (Qty: 1)', 32500.00, '1', '2025-05-31 06:09:12', '2025-05-31 06:09:12'),
	(69, 23, 'Payment received for Order #23 - hoodie (Qty: 1)', 130000.00, '1', '2025-05-31 06:10:12', '2025-05-31 06:10:12'),
	(70, 24, 'Payment received for Order #24 - sablon (Qty: 1)', 80000.00, '1', '2025-05-31 06:17:24', '2025-05-31 06:17:24'),
	(71, 25, 'Payment received for Order #25 - kemeja (Qty: 1)', 150000.00, '3', '2025-05-31 06:36:08', '2025-05-31 06:36:08'),
	(73, 30, 'Payment received for Order #30 - hoodie (Qty: 1)', 130000.00, '1', '2025-05-31 20:58:28', '2025-05-31 20:58:28'),
	(74, 31, 'Payment received for Order #31 - hoodie (Qty: 1)', 39000.00, '1', '2025-06-10 17:35:37', '2025-06-10 17:35:37'),
	(75, 34, 'Payment received for Order #34 - kemeja (Qty: 1)', 45000.00, '1', '2025-06-11 22:21:59', '2025-06-11 22:21:59'),
	(76, 34, 'Payment received for Order #34 - kemeja (Qty: 1)', 105000.00, '1', '2025-06-11 22:23:54', '2025-06-11 22:23:54'),
	(77, 35, 'Payment received for Order #35 - kemeja (Qty: 1)', 75000.00, '1', '2025-06-11 22:28:03', '2025-06-11 22:28:03'),
	(78, 35, 'Payment received for Order #35 - kemeja (Qty: 1)', 75000.00, '1', '2025-06-11 22:29:32', '2025-06-11 22:29:32');

-- Dumping structure for table labels-mm.pengeluaran
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id_pengeluaran` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_modal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_pengeluaran` decimal(20,2) NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.pengeluaran: ~0 rows (approximately)

-- Dumping structure for table labels-mm.pesanans
DROP TABLE IF EXISTS `pesanans`;
CREATE TABLE IF NOT EXISTS `pesanans` (
  `id_pesanan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pemesan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `no_telp_pemesan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_produk` int NOT NULL,
  `total_harga` decimal(20,2) NOT NULL,
  `jumlah_pembayaran` decimal(20,2) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int NOT NULL,
  `status_pesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lebar_muka` decimal(8,2) DEFAULT NULL,
  `lebar_pundak` decimal(8,2) DEFAULT NULL,
  `lebar_punggung` decimal(8,2) DEFAULT NULL,
  `panjang_lengan` decimal(8,2) DEFAULT NULL,
  `panjang_punggung` decimal(8,2) DEFAULT NULL,
  `panjang_baju` decimal(8,2) DEFAULT NULL,
  `lingkar_badan` decimal(8,2) DEFAULT NULL,
  `lingkar_pinggang` decimal(8,2) DEFAULT NULL,
  `lingkar_panggul` decimal(8,2) DEFAULT NULL,
  `lingkar_kerung_lengan` decimal(8,2) DEFAULT NULL,
  `lingkar_pergelangan_lengan` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.pesanans: ~34 rows (approximately)
REPLACE INTO `pesanans` (`id_pesanan`, `nama_pemesan`, `product_id`, `no_telp_pemesan`, `nama_produk`, `jumlah_produk`, `total_harga`, `jumlah_pembayaran`, `payment_method`, `created_by`, `status_pesanan`, `order_date`, `lebar_muka`, `lebar_pundak`, `lebar_punggung`, `panjang_lengan`, `panjang_punggung`, `panjang_baju`, `lingkar_badan`, `lingkar_pinggang`, `lingkar_panggul`, `lingkar_kerung_lengan`, `lingkar_pergelangan_lengan`, `created_at`, `updated_at`) VALUES
	(1, 'siapa???', 1, '08211212', 'jahit', 1, 400.00, 4000000.00, 'cash', 1, 'batal', '2025-05-21 06:57:12', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-20 23:57:12', '2025-05-31 07:28:46'),
	(2, 'siapa???', 1, '082112327021', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 06:58:44', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-20 23:58:44', '2025-05-21 19:15:16'),
	(3, 'siapa???', 1, '082112327021', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:00:12', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-21 00:00:12', '2025-05-28 19:49:21'),
	(4, 'siapa???', 1, '082112327021', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:01:38', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-21 00:01:38', '2025-05-31 07:28:52'),
	(5, 'siapa???', 1, '082112327021', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:01:38', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-21 00:01:38', '2025-05-31 07:29:51'),
	(6, 'siapa???', 1, '082112327021', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:02:09', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-21 00:02:09', '2025-05-31 07:35:11'),
	(7, 'aditiya', 1, '08211212', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:02:30', 31.00, 40.00, 40.00, 58.00, 38.00, 68.00, 90.00, 76.00, 96.00, 42.00, 18.00, '2025-05-21 00:02:30', '2025-05-31 07:35:18'),
	(8, 'siapa???', 1, '08211212', 'jahit', 1, 4000000.00, 4000000.00, NULL, 1, 'batal', '2025-05-21 07:09:31', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-21 00:09:31', '2025-05-31 07:35:29'),
	(9, 'gopal', 5, '082121', 'kaos', 1, 10.00, 8.00, NULL, 1, 'batal', '2025-05-22 01:10:32', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-21 18:10:32', '2025-05-28 19:57:33'),
	(10, 'adit', 2, '082112327021', 'hoodie', 1, 130000.00, 130000.00, NULL, 1, 'batal', '2025-05-29 02:57:56', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-28 19:57:56', '2025-05-31 07:35:41'),
	(12, 'siapa???', 2, '0821212', 'hoodie', 1, 130000.00, NULL, 'cash', 3, 'paid', '2025-05-29 03:17:33', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-28 20:17:33', '2025-05-28 20:17:33'),
	(13, 'adit', 3, '0821212', 'kemeja', 1, 150000.00, 75000.00, 'cash', 3, 'DP', '2025-05-29 03:19:50', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-05-28 20:19:50', '2025-05-31 06:06:41'),
	(14, 'adit', 3, '08212121', 'kemeja', 1, 150000.00, 75000.00, 'cash', 3, 'DP', '2025-05-29 03:21:40', 35.00, 44.00, 46.00, 61.00, 42.00, 72.00, 102.00, 86.00, 106.00, 48.00, 22.00, '2025-05-28 20:21:40', '2025-05-28 20:22:23'),
	(15, 'gopal', 2, '082112327021', 'hoodie', 1, 130000.00, 130000.00, NULL, 1, 'paid', '2025-05-31 11:27:32', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 04:27:32', '2025-05-31 04:38:25'),
	(16, 'adit', 3, '08211212', 'kemeja', 1, 150000.00, 147656.00, NULL, 1, 'DP', '2025-05-31 11:38:40', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 04:38:40', '2025-05-31 04:48:48'),
	(17, 'aditiya', 2, '082112327021', 'hoodie', 1, 130000.00, 97500.00, NULL, 1, 'DP', '2025-05-31 11:49:13', 31.00, 40.00, 40.00, 58.00, 38.00, 68.00, 90.00, 76.00, 96.00, 42.00, 18.00, '2025-05-31 04:49:13', '2025-05-31 06:09:12'),
	(18, 'siapa???', 1, '08211212', 'jahit', 1, 400.00, 400.00, NULL, 1, 'paid', '2025-05-31 11:53:22', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-31 04:53:22', '2025-05-31 05:00:39'),
	(19, 'adit', 2, '082112327021', 'hoodie', 1, 130000.00, 130000.00, NULL, 1, 'paid', '2025-05-31 12:01:27', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 05:01:27', '2025-05-31 05:05:36'),
	(20, 'gopal', 3, '082112327021', 'kemeja', 1, 150000.00, 75000.00, NULL, 1, 'DP', '2025-05-31 12:05:50', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-31 05:05:50', '2025-05-31 05:17:01'),
	(21, 'siapa???', 1, '08212121', 'jahit', 1, 400.00, 400.00, 'midtrans', 3, 'paid', '2025-05-31 12:08:08', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-31 05:08:08', '2025-05-31 05:15:50'),
	(22, 'gopal', 3, '08211212', 'kemeja', 1, 150000.00, 150000.00, NULL, 1, 'paid', '2025-05-31 12:32:08', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-31 05:32:08', '2025-05-31 05:35:53'),
	(23, 'aditiya', 2, '08211212', 'hoodie', 1, 130000.00, 130000.00, NULL, 1, 'completed', '2025-05-31 13:09:34', 41.00, 50.00, 55.00, 64.00, 48.00, 78.00, 124.00, 108.00, 128.00, 57.00, 28.00, '2025-05-31 06:09:34', '2025-05-31 20:58:37'),
	(24, 'gopal', 4, '08211212', 'sablon', 1, 160000.00, 80000.00, NULL, 1, 'DP', '2025-05-31 13:10:28', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 06:10:28', '2025-05-31 06:17:24'),
	(25, 'siapa???', 3, '082112327021', 'kemeja', 1, 150000.00, NULL, 'cash', 3, 'paid', '2025-05-31 13:36:08', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 06:36:08', '2025-05-31 06:36:08'),
	(26, 'siap', 2, '082112327021', 'hoodie', 1, 130000.00, NULL, NULL, 3, 'proses', '2025-05-31 13:42:15', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 06:42:15', '2025-05-31 06:42:15'),
	(27, 'aku', 3, '2121', 'kemeja', 1, 150000.00, 150000.00, NULL, 3, 'batal', '2025-05-31 14:03:43', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 07:03:43', '2025-05-31 07:39:22'),
	(28, 'aku', 3, '2121', 'kemeja', 1, 150000.00, NULL, NULL, 3, 'batal', '2025-05-31 14:03:43', 39.00, 48.00, 52.00, 63.00, 46.00, 76.00, 116.00, 100.00, 120.00, 54.00, 26.00, '2025-05-31 07:03:43', '2025-05-31 07:36:12'),
	(29, 'adit', 1, '082112327021', 'jahit', 1, 400.00, NULL, NULL, 1, 'proses', '2025-05-31 14:43:35', 31.00, 40.00, 40.00, 58.00, 38.00, 68.00, 90.00, 76.00, 96.00, 42.00, 18.00, '2025-05-31 07:43:35', '2025-05-31 07:43:35'),
	(30, 'adit', 2, '08263627362', 'hoodie', 1, 130000.00, 130000.00, NULL, 1, 'paid', '2025-06-01 03:57:35', 31.00, 40.00, 40.00, 58.00, 38.00, 68.00, 90.00, 76.00, 96.00, 42.00, 18.00, '2025-05-31 20:57:35', '2025-05-31 20:58:28'),
	(31, 'adit', 2, '08213218371', 'hoodie', 1, 130000.00, 39000.00, NULL, 1, 'DP', '2025-06-11 00:34:00', 31.00, 40.00, 40.00, 58.00, 38.00, 68.00, 90.00, 76.00, 96.00, 42.00, 18.00, '2025-06-10 17:34:00', '2025-06-10 17:35:36'),
	(32, 'adit', 3, '082112327021', 'kemeja', 1, 150000.00, NULL, NULL, 1, 'proses', '2025-06-12 05:16:57', 33.00, 42.00, 43.00, 60.00, 40.00, 70.00, 96.00, 80.00, 100.00, 45.00, 20.00, '2025-06-11 22:16:57', '2025-06-11 22:16:57'),
	(33, 'adit', 3, '082112327021', 'kemeja', 1, 150000.00, NULL, NULL, 1, 'proses', '2025-06-12 05:16:57', 33.00, 42.00, 43.00, 60.00, 40.00, 70.00, 96.00, 80.00, 100.00, 45.00, 20.00, '2025-06-11 22:16:57', '2025-06-11 22:16:57'),
	(34, 'adit', 3, '082112327021', 'kemeja', 1, 150000.00, 150000.00, NULL, 1, 'paid', '2025-06-12 05:19:27', 35.00, 44.00, 46.00, 61.00, 42.00, 72.00, 102.00, 86.00, 106.00, 48.00, 22.00, '2025-06-11 22:19:27', '2025-06-11 22:23:54'),
	(35, 'adit', 3, '08211212', 'kemeja', 1, 150000.00, 150000.00, NULL, 1, 'paid', '2025-06-12 05:25:15', 37.00, 46.00, 49.00, 62.00, 44.00, 74.00, 108.00, 92.00, 112.00, 51.00, 24.00, '2025-06-11 22:25:15', '2025-06-11 22:29:32');

-- Dumping structure for table labels-mm.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `harga_jual` decimal(20,2) NOT NULL,
  `stock_product` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.products: ~5 rows (approximately)
REPLACE INTO `products` (`id_product`, `nama_produk`, `description`, `harga_jual`, `stock_product`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'jahit', 'jahit baju', 400.00, 6, 'images/products/1747805760_RVkTtYFb3Y.jpg', '2025-05-20 22:36:00', '2025-05-31 07:43:35'),
	(2, 'hoodie', 'buat hoodie custome', 130000.00, 24, 'images/products/1747805799_BPaz6m0P0k.jpg', '2025-05-20 22:36:39', '2025-06-10 17:34:00'),
	(3, 'kemeja', 'buat kemeja sendiri', 150000.00, 14, 'images/products/1747805840_MMhPy1ea2a.jpg', '2025-05-20 22:37:20', '2025-06-11 22:25:15'),
	(4, 'sablon', 'sablon jersey', 160000.00, 31, 'images/products/1747805878_z4v19AxP0t.jpg', '2025-05-20 22:37:58', '2025-05-31 06:10:28'),
	(6, 'sablon', 'membuat jersey sablon custom sesuai request dengan bahan yang bagus', 453000.00, 43, 'images/products/1749083703_9YwwA696pN.jpg', '2025-06-04 17:35:03', '2025-06-04 17:35:03');

-- Dumping structure for table labels-mm.resis
DROP TABLE IF EXISTS `resis`;
CREATE TABLE IF NOT EXISTS `resis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `nomor_resi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL,
  `total_pembayaran` decimal(15,2) NOT NULL,
  `jumlah_pembayaran` decimal(15,2) DEFAULT NULL,
  `kembalian` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.resis: ~13 rows (approximately)
REPLACE INTO `resis` (`id`, `pesanan_id`, `nomor_resi`, `tanggal`, `total_pembayaran`, `jumlah_pembayaran`, `kembalian`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 22, 'RESI-20250531-22-1', '2025-05-31 05:35:40', 150000.00, 112500.00, 0.00, 1, '2025-05-31 05:35:40', '2025-05-31 05:35:40'),
	(2, 22, 'RESI-20250531-22-2', '2025-05-31 05:35:53', 150000.00, 150000.00, 0.00, 1, '2025-05-31 05:35:53', '2025-05-31 05:35:53'),
	(3, 13, 'RESI-20250531-13-1', '2025-05-31 06:06:41', 150000.00, 75000.00, 0.00, 1, '2025-05-31 06:06:41', '2025-05-31 06:06:41'),
	(4, 17, 'RESI-20250531-17-1', '2025-05-31 06:09:12', 130000.00, 97500.00, 0.00, 1, '2025-05-31 06:09:12', '2025-05-31 06:09:12'),
	(5, 23, 'RESI-20250531-23-1', '2025-05-31 06:10:12', 130000.00, 130000.00, 135000.00, 1, '2025-05-31 06:10:12', '2025-05-31 06:10:12'),
	(6, 24, 'RESI-20250531-24-1', '2025-05-31 06:17:24', 160000.00, 80000.00, 0.00, 1, '2025-05-31 06:17:24', '2025-05-31 06:17:24'),
	(7, 25, 'RESI-20250531-25-1', '2025-05-31 06:36:08', 150000.00, 150000.00, 0.00, 3, '2025-05-31 06:36:08', '2025-05-31 06:36:08'),
	(9, 30, 'RESI-20250601-30-1', '2025-05-31 20:58:28', 130000.00, 130000.00, 522000.00, 1, '2025-05-31 20:58:28', '2025-05-31 20:58:28'),
	(10, 31, 'RESI-20250611-31-1', '2025-06-10 17:35:37', 130000.00, 39000.00, 0.00, 1, '2025-06-10 17:35:37', '2025-06-10 17:35:37'),
	(11, 34, 'RESI-20250612-34-1', '2025-06-11 22:21:59', 150000.00, 45000.00, 0.00, 1, '2025-06-11 22:21:59', '2025-06-11 22:21:59'),
	(12, 34, 'RESI-20250612-34-2', '2025-06-11 22:23:54', 150000.00, 150000.00, 95000.00, 1, '2025-06-11 22:23:54', '2025-06-11 22:23:54'),
	(13, 35, 'RESI-20250612-35-1', '2025-06-11 22:28:03', 150000.00, 75000.00, 0.00, 1, '2025-06-11 22:28:03', '2025-06-11 22:28:03'),
	(14, 35, 'RESI-20250612-35-2', '2025-06-11 22:29:32', 150000.00, 150000.00, 125000.00, 1, '2025-06-11 22:29:32', '2025-06-11 22:29:32');

-- Dumping structure for table labels-mm.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.sessions: ~2 rows (approximately)
REPLACE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Lf5dn5JyGnDvxEjnY9gfiRQMJkQ0WIOA4tLkrsZw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTJkbE9Zd1NqVGp0ekFXVnNtUHJJaHYxckhpWnJ0ODBSR0IwbzJFVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovL2xhYmVscy1tbS50ZXN0Ijt9fQ==', 1750048295),
	('VyyWZH6h04mLjjbiDzluuB7fudLI1IrncYsZAs93', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOERBdU8zWER5SGhKeWsxUHNqVnRyYnhBdEZNR1JwUXQ4VHFzcFlPMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sYWJlbHMtbW0udGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750044284);

-- Dumping structure for table labels-mm.tbl_bahans
DROP TABLE IF EXISTS `tbl_bahans`;
CREATE TABLE IF NOT EXISTS `tbl_bahans` (
  `id_bhn` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_bahan` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `periode_hari` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bhn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.tbl_bahans: ~0 rows (approximately)

-- Dumping structure for table labels-mm.tbl_transaksis
DROP TABLE IF EXISTS `tbl_transaksis`;
CREATE TABLE IF NOT EXISTS `tbl_transaksis` (
  `id_transaksi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_referens` int NOT NULL,
  `pelaku_transaksi` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` decimal(20,2) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.tbl_transaksis: ~92 rows (approximately)
REPLACE INTO `tbl_transaksis` (`id_transaksi`, `id_referens`, `pelaku_transaksi`, `keterangan`, `kategori`, `nominal`, `tanggal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 22:39:43', '2025-05-20 22:39:43'),
	(2, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 22:41:51', '2025-05-20 22:41:51'),
	(3, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 22:47:48', '2025-05-20 22:47:48'),
	(4, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 0.00, '2025-05-21', '2025-05-20 23:06:22', '2025-05-20 23:06:22'),
	(5, 2, 1, 'Payment received for Order #2 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:07:05', '2025-05-20 23:07:05'),
	(6, 3, 1, 'Payment received for Order #3 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:08:10', '2025-05-20 23:08:10'),
	(7, 4, 1, 'Payment received for Order #4 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:08:35', '2025-05-20 23:08:35'),
	(8, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-21', '2025-05-20 23:12:43', '2025-05-20 23:12:43'),
	(9, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 0.00, '2025-05-21', '2025-05-20 23:12:57', '2025-05-20 23:12:57'),
	(10, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 0.00, '2025-05-21', '2025-05-20 23:13:02', '2025-05-20 23:13:02'),
	(11, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 0.00, '2025-05-21', '2025-05-20 23:14:36', '2025-05-20 23:14:36'),
	(12, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 0.00, '2025-05-21', '2025-05-20 23:14:54', '2025-05-20 23:14:54'),
	(13, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:21:22', '2025-05-20 23:21:22'),
	(14, 9, 1, 'Payment received for Order #9 - jahit (Qty: 1)', 'pemasukan', 3000000.00, '2025-05-21', '2025-05-20 23:23:16', '2025-05-20 23:23:16'),
	(15, 9, 1, 'Payment received for Order #9 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:23:22', '2025-05-20 23:23:22'),
	(16, 10, 1, 'Payment received for Order #10 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:24:32', '2025-05-20 23:24:32'),
	(17, 11, 1, 'Payment received for Order #11 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:25:00', '2025-05-20 23:25:00'),
	(18, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-21', '2025-05-20 23:27:18', '2025-05-20 23:27:18'),
	(19, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 1.00, '2025-05-21', '2025-05-20 23:37:17', '2025-05-20 23:37:17'),
	(20, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 599.00, '2025-05-21', '2025-05-20 23:38:07', '2025-05-20 23:38:07'),
	(21, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 1.00, '2025-05-21', '2025-05-20 23:39:20', '2025-05-20 23:39:20'),
	(22, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 19.00, '2025-05-21', '2025-05-20 23:39:38', '2025-05-20 23:39:38'),
	(23, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 199.00, '2025-05-21', '2025-05-20 23:39:50', '2025-05-20 23:39:50'),
	(24, 12, 1, 'Payment received for Order #12 - jahit (Qty: 1)', 'pemasukan', 1999177.00, '2025-05-21', '2025-05-20 23:45:51', '2025-05-20 23:45:51'),
	(25, 13, 1, 'Payment received for Order #13 - jahit (Qty: 1)', 'pemasukan', 1200000.00, '2025-05-21', '2025-05-20 23:46:16', '2025-05-20 23:46:16'),
	(26, 13, 1, 'Payment received for Order #13 - jahit (Qty: 1)', 'pemasukan', 2300000.00, '2025-05-21', '2025-05-20 23:46:38', '2025-05-20 23:46:38'),
	(27, 13, 1, 'Payment received for Order #13 - jahit (Qty: 1)', 'pemasukan', 500000.00, '2025-05-21', '2025-05-20 23:47:06', '2025-05-20 23:47:06'),
	(28, 5, 1, 'Payment received for Order #5 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-21', '2025-05-20 23:47:17', '2025-05-20 23:47:17'),
	(29, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 1200000.00, '2025-05-22', '2025-05-21 17:45:44', '2025-05-21 17:45:44'),
	(30, 8, 1, 'Payment received for Order #8 - jahit (Qty: 1)', 'pemasukan', 2800000.00, '2025-05-22', '2025-05-21 17:46:07', '2025-05-21 17:46:07'),
	(31, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-22', '2025-05-21 17:48:52', '2025-05-21 17:48:52'),
	(32, 1, 1, 'Payment received for Order #1 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-22', '2025-05-21 17:49:35', '2025-05-21 17:49:35'),
	(33, 2, 1, 'Payment received for Order #2 - jahit (Qty: 1)', 'pemasukan', 2500000.00, '2025-05-22', '2025-05-21 18:08:34', '2025-05-21 18:08:34'),
	(34, 9, 1, 'Payment received for Order #9 - kaos (Qty: 1)', 'pemasukan', 3.00, '2025-05-22', '2025-05-21 19:14:01', '2025-05-21 19:14:01'),
	(35, 2, 1, 'Payment received for Order #2 - jahit (Qty: 1)', 'pemasukan', 750000.00, '2025-05-22', '2025-05-21 19:14:42', '2025-05-21 19:14:42'),
	(36, 2, 1, 'Payment received for Order #2 - jahit (Qty: 1)', 'pemasukan', 750000.00, '2025-05-22', '2025-05-21 19:14:57', '2025-05-21 19:14:57'),
	(37, 2, 1, 'Pembatalan pesanan untuk Order #2 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-22', '2025-05-21 19:15:16', '2025-05-21 19:15:16'),
	(38, 9, 1, 'Payment received for Order #9 - kaos (Qty: 1)', 'pemasukan', 3.00, '2025-05-22', '2025-05-21 23:40:49', '2025-05-21 23:40:49'),
	(39, 1, 1, 'Order updated for Order #1 - jahit (Qty: 1)', 'pemasukan', 400.00, '2025-05-22', '2025-05-21 23:53:01', '2025-05-21 23:53:01'),
	(40, 7, 1, 'Payment received for Order #7 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-22', '2025-05-22 00:10:35', '2025-05-22 00:10:35'),
	(41, 6, 1, 'Payment received for Order #6 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-22', '2025-05-22 00:11:35', '2025-05-22 00:11:35'),
	(42, 3, 1, 'Payment received for Order #3 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-22', '2025-05-22 00:12:23', '2025-05-22 00:12:23'),
	(43, 3, 1, 'Payment received for Order #3 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-22', '2025-05-22 04:39:14', '2025-05-22 04:39:14'),
	(44, 9, 1, 'Payment received for Order #9 - kaos (Qty: 1)', 'pemasukan', 2.00, '2025-05-22', '2025-05-22 05:03:09', '2025-05-22 05:03:09'),
	(45, 1, 1, 'Order updated for Order #1 - jahit (Qty: 1)', 'pemasukan', 400.00, '2025-05-29', '2025-05-28 19:06:36', '2025-05-28 19:06:36'),
	(46, 4, 1, 'Payment received for Order #4 - jahit (Qty: 1)', 'pemasukan', 2000000.00, '2025-05-29', '2025-05-28 19:07:51', '2025-05-28 19:07:51'),
	(47, 4, 1, 'Payment received for Order #4 - jahit (Qty: 1)', 'pemasukan', 1200000.00, '2025-05-29', '2025-05-28 19:40:06', '2025-05-28 19:40:06'),
	(48, 4, 1, 'Payment received for Order #4 - jahit (Qty: 1)', 'pemasukan', 400000.00, '2025-05-29', '2025-05-28 19:48:01', '2025-05-28 19:48:01'),
	(49, 4, 1, 'Payment received for Order #4 - jahit (Qty: 1)', 'pemasukan', 400000.00, '2025-05-29', '2025-05-28 19:48:48', '2025-05-28 19:48:48'),
	(50, 3, 1, 'Pembatalan pesanan untuk Order #3 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-29', '2025-05-28 19:49:21', '2025-05-28 19:49:21'),
	(51, 5, 1, 'Payment received for Order #5 - jahit (Qty: 1)', 'pemasukan', 4000000.00, '2025-05-29', '2025-05-28 19:54:48', '2025-05-28 19:54:48'),
	(52, 9, 1, 'Pembatalan pesanan untuk Order #9 - kaos (Qty: 1)', 'pembatalan', 10.00, '2025-05-29', '2025-05-28 19:57:33', '2025-05-28 19:57:33'),
	(53, 10, 1, 'Payment received for Order #10 - hoodie (Qty: 1)', 'pemasukan', 39000.00, '2025-05-29', '2025-05-28 19:58:24', '2025-05-28 19:58:24'),
	(55, 12, 3, 'Order created for Order #12 - hoodie (Qty: 1)', 'pemasukan', 130000.00, '2025-05-29', '2025-05-28 20:17:33', '2025-05-28 20:17:33'),
	(56, 14, 3, 'Payment received for Order #14 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-05-29', '2025-05-28 20:22:23', '2025-05-28 20:22:23'),
	(57, 10, 3, 'Payment received for Order #10 - hoodie (Qty: 1)', 'pemasukan', 91000.00, '2025-05-29', '2025-05-28 20:27:24', '2025-05-28 20:27:24'),
	(58, 15, 1, 'Payment received for Order #15 - hoodie (Qty: 1)', 'pemasukan', 130000.00, '2025-05-31', '2025-05-31 04:38:25', '2025-05-31 04:38:25'),
	(59, 16, 1, 'Payment received for Order #16 - kemeja (Qty: 1)', 'pemasukan', 112500.00, '2025-05-31', '2025-05-31 04:41:23', '2025-05-31 04:41:23'),
	(60, 16, 1, 'Payment received for Order #16 - kemeja (Qty: 1)', 'pemasukan', 28125.00, '2025-05-31', '2025-05-31 04:42:56', '2025-05-31 04:42:56'),
	(61, 16, 1, 'Payment received for Order #16 - kemeja (Qty: 1)', 'pemasukan', 7031.00, '2025-05-31', '2025-05-31 04:48:48', '2025-05-31 04:48:48'),
	(62, 17, 1, 'Payment received for Order #17 - hoodie (Qty: 1)', 'pemasukan', 65000.00, '2025-05-31', '2025-05-31 04:52:27', '2025-05-31 04:52:27'),
	(63, 18, 1, 'Payment received for Order #18 - jahit (Qty: 1)', 'pemasukan', 400.00, '2025-05-31', '2025-05-31 05:00:39', '2025-05-31 05:00:39'),
	(64, 19, 1, 'Payment received for Order #19 - hoodie (Qty: 1)', 'pemasukan', 130000.00, '2025-05-31', '2025-05-31 05:05:36', '2025-05-31 05:05:36'),
	(65, 21, 1, 'Payment received for Order #21 - jahit (Qty: 1)', 'pemasukan', 400.00, '2025-05-31', '2025-05-31 05:15:50', '2025-05-31 05:15:50'),
	(66, 20, 1, 'Payment received for Order #20 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-05-31', '2025-05-31 05:17:01', '2025-05-31 05:17:01'),
	(67, 22, 1, 'Payment received for Order #22 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-05-31', '2025-05-31 05:32:37', '2025-05-31 05:32:37'),
	(69, 22, 1, 'Payment received for Order #22 - kemeja (Qty: 1)', 'pemasukan', 37500.00, '2025-05-31', '2025-05-31 05:35:40', '2025-05-31 05:35:40'),
	(70, 22, 1, 'Payment received for Order #22 - kemeja (Qty: 1)', 'pemasukan', 37500.00, '2025-05-31', '2025-05-31 05:35:53', '2025-05-31 05:35:53'),
	(71, 13, 1, 'Payment received for Order #13 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-05-31', '2025-05-31 06:06:41', '2025-05-31 06:06:41'),
	(72, 17, 1, 'Payment received for Order #17 - hoodie (Qty: 1)', 'pemasukan', 32500.00, '2025-05-31', '2025-05-31 06:09:12', '2025-05-31 06:09:12'),
	(73, 23, 1, 'Payment received for Order #23 - hoodie (Qty: 1)', 'pemasukan', 130000.00, '2025-05-31', '2025-05-31 06:10:12', '2025-05-31 06:10:12'),
	(74, 24, 1, 'Payment received for Order #24 - sablon (Qty: 1)', 'pemasukan', 80000.00, '2025-05-31', '2025-05-31 06:17:24', '2025-05-31 06:17:24'),
	(75, 25, 3, 'Order created for Order #25 - kemeja (Qty: 1)', 'pemasukan', 150000.00, '2025-05-31', '2025-05-31 06:36:08', '2025-05-31 06:36:08'),
	(76, 27, 3, 'Payment received for Order #27 - kemeja (Qty: 1)', 'pemasukan', 150000.00, '2025-05-31', '2025-05-31 07:05:59', '2025-05-31 07:05:59'),
	(77, 1, 1, 'Pembatalan pesanan untuk Order #1 - jahit (Qty: 1)', 'pembatalan', 400.00, '2025-05-31', '2025-05-31 07:28:46', '2025-05-31 07:28:46'),
	(78, 4, 1, 'Pembatalan pesanan untuk Order #4 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:28:52', '2025-05-31 07:28:52'),
	(79, 5, 1, 'Pembatalan pesanan untuk Order #5 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:29:51', '2025-05-31 07:29:51'),
	(80, 6, 1, 'Pembatalan pesanan untuk Order #6 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:35:11', '2025-05-31 07:35:11'),
	(81, 7, 1, 'Pembatalan pesanan untuk Order #7 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:35:18', '2025-05-31 07:35:18'),
	(82, 8, 1, 'Pembatalan pesanan untuk Order #8 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:35:29', '2025-05-31 07:35:29'),
	(83, 6, 1, 'Pembatalan pesanan untuk Order #6 - jahit (Qty: 1)', 'pembatalan', 4000000.00, '2025-05-31', '2025-05-31 07:35:36', '2025-05-31 07:35:36'),
	(84, 10, 1, 'Pembatalan pesanan untuk Order #10 - hoodie (Qty: 1)', 'pembatalan', 130000.00, '2025-05-31', '2025-05-31 07:35:41', '2025-05-31 07:35:41'),
	(85, 28, 1, 'Pembatalan pesanan untuk Order #28 - kemeja (Qty: 1)', 'pembatalan', 150000.00, '2025-05-31', '2025-05-31 07:36:12', '2025-05-31 07:36:12'),
	(86, 28, 1, 'Pembatalan pesanan untuk Order #28 - kemeja (Qty: 1)', 'pembatalan', 150000.00, '2025-05-31', '2025-05-31 07:37:17', '2025-05-31 07:37:17'),
	(87, 28, 1, 'Pembatalan pesanan untuk Order #28 - kemeja (Qty: 1)', 'pembatalan', 150000.00, '2025-05-31', '2025-05-31 07:38:07', '2025-05-31 07:38:07'),
	(88, 27, 1, 'Pembatalan pesanan untuk Order #27 - kemeja (Qty: 1)', 'pembatalan', 150000.00, '2025-05-31', '2025-05-31 07:39:22', '2025-05-31 07:39:22'),
	(89, 30, 1, 'Payment received for Order #30 - hoodie (Qty: 1)', 'pemasukan', 130000.00, '2025-06-01', '2025-05-31 20:58:28', '2025-05-31 20:58:28'),
	(90, 31, 1, 'Payment received for Order #31 - hoodie (Qty: 1)', 'pemasukan', 39000.00, '2025-06-11', '2025-06-10 17:35:36', '2025-06-10 17:35:36'),
	(91, 34, 1, 'Payment received for Order #34 - kemeja (Qty: 1)', 'pemasukan', 45000.00, '2025-06-12', '2025-06-11 22:21:59', '2025-06-11 22:21:59'),
	(92, 34, 1, 'Payment received for Order #34 - kemeja (Qty: 1)', 'pemasukan', 105000.00, '2025-06-12', '2025-06-11 22:23:54', '2025-06-11 22:23:54'),
	(93, 35, 1, 'Payment received for Order #35 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-06-12', '2025-06-11 22:28:03', '2025-06-11 22:28:03'),
	(94, 35, 1, 'Payment received for Order #35 - kemeja (Qty: 1)', 'pemasukan', 75000.00, '2025-06-12', '2025-06-11 22:29:32', '2025-06-11 22:29:32');

-- Dumping structure for table labels-mm.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table labels-mm.users: ~2 rows (approximately)
REPLACE INTO `users` (`id_users`, `nama_lengkap`, `username`, `password`, `usertype`, `no_telp`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'admin', '$2y$12$CybBLfEicG/3hnCPsvdU..ywWVrKSVU.1/2Va9yc8vky19S6wrApe', 'admin', '08123456789', NULL, '2025-05-20 22:32:57', '2025-05-20 22:32:57'),
	(3, 'karyawan', 'karyawan', '$2y$12$4snkBFoQg2El/Zq3raxT5.gmpQE2zuB70bv7GWfvRqHoL/eqDj.RS', 'karyawan', '93282`91', NULL, '2025-05-28 20:13:26', '2025-05-28 20:13:26');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
