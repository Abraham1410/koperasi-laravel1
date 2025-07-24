-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 24, 2025 at 11:41 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `kode_akun`, `nama_akun`, `tipe`, `kategori`, `status`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, '111', 'Kas', 'Debit', 'Aset', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(2, '112', 'Bank', 'Debit', 'Aset', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(3, '113', 'Piutang', 'Debit', 'Aset', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(4, '121', 'Persediaan usaha toko', 'Debit', 'Aset', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(5, '211', 'Simpanan Pokok', 'Kredit', 'Liabilitas', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(6, '212', 'Simpanan Wajib', 'Kredit', 'Ekuitas', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(7, '213', 'Simpanan Sukarela', 'Kredit', 'Ekuitas', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(8, '214', 'Simpanan Insidental', 'Kredit', 'Ekuitas', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(9, '511', 'Modal Koperasi', 'Kredit', 'Ekuitas', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(10, '311', 'Pendapatan Bunga Pinjaman', 'Kredit', 'Pendapatan', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(11, '312', 'Pendapatan Administrasi', 'Kredit', 'Pendapatan', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(12, '313', 'Pendapatan Non Operasional', 'Kredit', 'Pendapatan', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(13, '314', 'Pendapatan usaha toko', 'Kredit', 'Pendapatan', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(14, '411', 'Beban Listrik, Air, dan Telepon', 'Debit', 'Beban', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(15, '412', 'Beban Sewa Kantor', 'Debit', 'Beban', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(16, '413', 'Beban Gaji', 'Debit', 'Beban', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45'),
(17, '414', 'Beban Non Operasional', 'Debit', 'Beban', 1, NULL, '2025-07-19 18:55:45', '2025-07-19 18:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` bigint UNSIGNED NOT NULL,
  `kodeTransaksiAngsuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pinjaman` bigint UNSIGNED NOT NULL,
  `tanggal_angsuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_angsuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sisa_pinjam` int NOT NULL,
  `cicilan` int NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bunga_pinjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda` int NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id`, `kodeTransaksiAngsuran`, `id_pinjaman`, `tanggal_angsuran`, `jml_angsuran`, `sisa_pinjam`, `cicilan`, `status`, `keterangan`, `bukti_pembayaran`, `bunga_pinjaman`, `denda`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ANG-0001', 1, '2025-07-20', '50000', 50000, 1, '0', NULL, '1752976841.jpg', '1000', 0, 2, 2, '2025-07-19 19:00:41', '2025-07-19 19:00:41'),
(2, 'ANG-0002', 1, '2025-07-20', '50000', 0, 2, '1', NULL, '1752976860.jpg', '1000', 0, 2, 2, '2025-07-19 19:01:00', '2025-07-19 19:01:00'),
(3, 'ANG-0003', 2, '2025-07-24', '250000', 0, 1, '1', NULL, '1753328753.jpg', '5000', 0, 2, 2, '2025-07-23 20:45:53', '2025-07-23 20:45:53'),
(4, 'ANG-0004', 3, '2025-07-24', '125000', 0, 1, '1', NULL, '1753342468.jpeg', '1250', 0, 2, 2, '2025-07-24 00:34:28', '2025-07-24 00:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:44:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"user-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"role-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"nasabah-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"nasabah-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"nasabah-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"nasabah-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"nasabah-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:13:\"simpanan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"simpanan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"simpanan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"simpanan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"simpanan-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"penarikan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"penarikan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"penarikan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:16:\"penarikan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"pinjaman-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"pinjaman-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"pinjaman-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:15:\"pinjaman-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"pinjaman-detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"angsuran-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:13:\"angsuran-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:15:\"angsuran-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"laporan_list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:16:\"laporan_simpanan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:16:\"laporan_pinjaman\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:16:\"laporan_angsuran\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:17:\"laporan_penarikan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:17:\"approve_penarikan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:16:\"approve_pinjaman\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"tolak_penarikan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"tolak_pinjaman\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:9:\"akun-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:11:\"akun-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:9:\"akun-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:11:\"akun-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:15:\"saldo-awal-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"saldo-awal-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"saldo-awal-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:17:\"saldo-awal-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}}}', 1753414978);

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
-- Table structure for table `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`id`, `nama`, `deskripsi`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Simpanan Pokok', 'Syarat resmi jadi anggota koperasi', 2, 2, NULL, NULL),
(2, 'Simpanan Wajib', 'Simpanan wajib setiap bulan', 2, 2, NULL, NULL),
(3, 'Simpanan Sukarela', 'Simpanan Bebas kapan saja', 2, 2, NULL, NULL);

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
-- Table structure for table `jurnal_details`
--

CREATE TABLE `jurnal_details` (
  `id` bigint UNSIGNED NOT NULL,
  `jurnal_id` bigint UNSIGNED NOT NULL,
  `akun_id` bigint UNSIGNED NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `kredit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umums`
--

CREATE TABLE `jurnal_umums` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `no_jurnal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2024_04_19_085635_create_anggota_table', 1),
(5, '2024_04_19_085636_create_pinjaman_table', 1),
(6, '2024_04_19_085645_create_angsuran_table', 1),
(7, '2024_04_19_090137_create_jenis_simpanan_table', 1),
(8, '2024_04_19_090139_create_simpanan_table', 1),
(9, '2024_04_22_052436_create_penarikan_table', 1),
(10, '2024_05_03_002346_create_permission_tables', 1),
(11, '2024_07_07_082205_create_total_saldo_anggota', 1),
(12, '2024_07_30_183154_create_riwayat_pinjaman_table', 1),
(13, '2025_07_15_162222_add_nik_rt_rw_to_anggota_table', 1),
(14, '2025_07_16_005650_drop_nik_column_from_anggota_table', 1),
(15, '2025_07_16_031504_create_accounts_table', 1),
(16, '2025_07_16_134140_create_jurnal_umums_table', 1),
(17, '2025_07_16_134142_create_jurnal_details_table', 1),
(18, '2025_07_19_021304_add_role_to_users_table', 1),
(19, '2025_07_19_025343_create_saldo_awal_table', 1),
(20, '2025_07_20_130934_create_nasabah_table', 2),
(21, '2025_07_22_061954_update_role_enum_on_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_gabung` date DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `penarikan`
--

CREATE TABLE `penarikan` (
  `id` bigint UNSIGNED NOT NULL,
  `kodeTransaksiPenarikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint UNSIGNED NOT NULL,
  `tanggal_penarikan` date NOT NULL,
  `jumlah_penarikan` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penarikan`
--

INSERT INTO `penarikan` (`id`, `kodeTransaksiPenarikan`, `id_anggota`, `tanggal_penarikan`, `jumlah_penarikan`, `keterangan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PNR-0001', 1, '2025-07-20', 50000.00, 'tarik', 2, 2, '2025-07-19 19:01:33', '2025-07-19 19:01:33'),
(2, 'PNR-0002', 1, '2025-07-24', 50000.00, 'yea', 2, 2, '2025-07-23 20:46:23', '2025-07-23 20:46:23'),
(4, 'PNR-0003', 2, '2025-07-24', 50000.00, 'u', 7, 7, '2025-07-24 01:29:27', '2025-07-24 01:29:27'),
(5, 'PNR-0005', 2, '2025-07-24', 50000.00, 'ok', 7, 7, '2025-07-24 02:14:42', '2025-07-24 02:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(2, 'role-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(3, 'role-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(4, 'role-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(5, 'role-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(6, 'nasabah-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(7, 'nasabah-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(8, 'nasabah-detail', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(9, 'nasabah-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(10, 'nasabah-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(11, 'simpanan-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(12, 'simpanan-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(13, 'simpanan-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(14, 'simpanan-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(15, 'simpanan-detail', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(16, 'penarikan-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(17, 'penarikan-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(18, 'penarikan-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(19, 'penarikan-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(20, 'pinjaman-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(21, 'pinjaman-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(22, 'pinjaman-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(23, 'pinjaman-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(24, 'pinjaman-detail', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(25, 'angsuran-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(26, 'angsuran-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(27, 'angsuran-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(28, 'laporan_list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(29, 'laporan_simpanan', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(30, 'laporan_pinjaman', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(31, 'laporan_angsuran', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(32, 'laporan_penarikan', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(33, 'approve_penarikan', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(34, 'approve_pinjaman', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(35, 'tolak_penarikan', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(36, 'tolak_pinjaman', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(37, 'akun-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(38, 'akun-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(39, 'akun-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(40, 'akun-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(41, 'saldo-awal-list', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(42, 'saldo-awal-create', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(43, 'saldo-awal-edit', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(44, 'saldo-awal-delete', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `kodeTransaksiPinjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_pinjam` int NOT NULL,
  `bunga_pinjam` int NOT NULL,
  `jml_cicilan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pengajuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_ditolak_pengajuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `kodeTransaksiPinjaman`, `id_anggota`, `tanggal_pinjam`, `jatuh_tempo`, `jml_pinjam`, `bunga_pinjam`, `jml_cicilan`, `status_pengajuan`, `keterangan_ditolak_pengajuan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PNJ-0001', 1, '2025-07-20', '2025-12-20', 100000, 2, '5', '3', '', 2, 2, '2025-07-19 18:59:24', '2025-07-19 19:01:00'),
(2, 'PNJ-0002', 1, '2025-07-24', '2025-10-24', 250000, 2, '3', '3', '', 2, 2, '2025-07-23 20:44:51', '2025-07-23 20:45:53'),
(3, 'PNJ-0003', 2, '2025-07-24', '2025-10-24', 125000, 1, '3', '3', '', 7, 7, '2025-07-23 22:11:12', '2025-07-24 00:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pinjaman`
--

CREATE TABLE `riwayat_pinjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `kodeTransaksiPinjaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pinjaman` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_pinjam` int NOT NULL,
  `sisa_pinjam` int NOT NULL,
  `jml_cicilan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pengajuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_ditolak_pengajuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-07-19 18:55:44', '2025-07-19 18:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `saldo_awal`
--

CREATE TABLE `saldo_awal` (
  `id` bigint UNSIGNED NOT NULL,
  `akun_id` bigint UNSIGNED NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `jumlah` decimal(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id` bigint UNSIGNED NOT NULL,
  `kodeTransaksiSimpanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_simpanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint UNSIGNED NOT NULL,
  `id_jenis_simpanan` bigint UNSIGNED NOT NULL,
  `jml_simpanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id`, `kodeTransaksiSimpanan`, `tanggal_simpanan`, `id_anggota`, `id_jenis_simpanan`, `jml_simpanan`, `bukti_pembayaran`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SMP-0001', '2025-07-20', 1, 1, '250000', 'assets/img/1752976741_687c4d6529e4f.jpeg', 2, 2, '2025-07-19 18:59:01', '2025-07-19 18:59:01'),
(2, 'SMP-0002', '2025-07-24', 1, 3, '300000', 'assets/img/1753328662_6881ac169e24e.jpg', 2, 2, '2025-07-23 20:44:22', '2025-07-23 20:44:22'),
(3, 'SMP-0003', '2025-07-24', 2, 1, '250000', 'assets/img/1753333811_6881c033845db.jpg', 7, 7, '2025-07-23 22:10:11', '2025-07-23 22:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `total_saldo_anggota`
--

CREATE TABLE `total_saldo_anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `gradesaldo` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `total_saldo_anggota`
--

INSERT INTO `total_saldo_anggota` (`id`, `gradesaldo`, `created_at`, `updated_at`) VALUES
(1, 800000.00, NULL, '2025-07-23 22:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','anggota','pengawas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kasep', 'kasep1414@gmail.com', 'anggota', NULL, '$2y$12$cN5xbaVmzb1EaY4A5YlfTOb0q1CNdrpYy1Qqvf6cvUjyH1/4g6Ex2', NULL, NULL, NULL, NULL),
(2, 'Administrator', 'admin@gmail.com', 'admin', NULL, '$2y$12$eNF2Qaw5Yhn72.iSdRqGBe5e5blEFobPRApL99UIcWvzT0zZ4MxjG', NULL, NULL, '2025-07-19 18:55:44', '2025-07-19 18:55:44'),
(3, 'mmmmm', 'mm@gmail.com', 'anggota', NULL, '$2y$12$2v7bEq2mhBrLS.n2YHWgEOxC0Vi2zeTVKJa2OqdlZACbyfK6j5V2e', '1752976716.jpg', NULL, '2025-07-19 18:58:36', '2025-07-19 18:58:36'),
(5, 'mel', 'mel@gmail.com', 'anggota', NULL, '$2y$12$HI1LaLAqT/TEvoPO05CSXuuNEtOCQHLtSQkwRQchxg2PPFHU7Uze.', NULL, NULL, '2025-07-20 02:40:02', '2025-07-20 02:40:02'),
(7, 'mik', 'mik@gmail.com', 'anggota', NULL, '$2y$12$XO7lipjxc77uxJtoX3vcIOovUwWpMcNpVm6jhc64z.Fg.ZvYQC3i2', NULL, NULL, '2025-07-23 22:07:39', '2025-07-23 22:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `_anggota`
--

CREATE TABLE `_anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_anggota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tgl_gabung` date NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `_anggota`
--

INSERT INTO `_anggota` (`id`, `user_id`, `nip`, `name`, `telphone`, `agama`, `jenis_kelamin`, `tgl_lahir`, `pekerjaan`, `alamat`, `rt`, `rw`, `image`, `status_anggota`, `saldo`, `tgl_gabung`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, '1234567890', 'mmmmm', '1234567890', 'Kristen', 'Laki-laki', '2000-01-01', 'mmmm', 'mmmm', '01', '02', '1752976716.jpg', '1', 500000.00, '2025-07-20', 2, 2, '2025-07-19 18:58:36', '2025-07-23 20:44:22'),
(2, 7, 'AUTO-9794', 'mik', '-', 'Islam', 'Laki-laki', '2025-07-24', '-', '-', '00', '00', NULL, '1', 150000.00, '2025-07-24', 7, 7, '2025-07-23 22:07:39', '2025-07-23 22:10:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_kode_akun_unique` (`kode_akun`);

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `angsuran_id_pinjaman_foreign` (`id_pinjaman`),
  ADD KEY `angsuran_created_by_foreign` (`created_by`),
  ADD KEY `angsuran_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_simpanan_created_by_foreign` (`created_by`),
  ADD KEY `jenis_simpanan_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `jurnal_details`
--
ALTER TABLE `jurnal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurnal_details_jurnal_id_foreign` (`jurnal_id`),
  ADD KEY `jurnal_details_akun_id_foreign` (`akun_id`);

--
-- Indexes for table `jurnal_umums`
--
ALTER TABLE `jurnal_umums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurnal_umums_no_jurnal_unique` (`no_jurnal`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nasabah_no_ktp_unique` (`no_ktp`),
  ADD KEY `nasabah_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penarikan_id_anggota_foreign` (`id_anggota`),
  ADD KEY `penarikan_created_by_foreign` (`created_by`),
  ADD KEY `penarikan_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjaman_id_anggota_foreign` (`id_anggota`),
  ADD KEY `pinjaman_created_by_foreign` (`created_by`),
  ADD KEY `pinjaman_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `riwayat_pinjaman`
--
ALTER TABLE `riwayat_pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pinjaman_id_pinjaman_foreign` (`id_pinjaman`),
  ADD KEY `riwayat_pinjaman_created_by_foreign` (`created_by`),
  ADD KEY `riwayat_pinjaman_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saldo_awal_akun_id_foreign` (`akun_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `simpanan_id_anggota_foreign` (`id_anggota`),
  ADD KEY `simpanan_id_jenis_simpanan_foreign` (`id_jenis_simpanan`),
  ADD KEY `simpanan_created_by_foreign` (`created_by`),
  ADD KEY `simpanan_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `total_saldo_anggota`
--
ALTER TABLE `total_saldo_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `_anggota`
--
ALTER TABLE `_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_anggota_user_id_foreign` (`user_id`),
  ADD KEY `_anggota_created_by_foreign` (`created_by`),
  ADD KEY `_anggota_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal_details`
--
ALTER TABLE `jurnal_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal_umums`
--
ALTER TABLE `jurnal_umums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penarikan`
--
ALTER TABLE `penarikan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `riwayat_pinjaman`
--
ALTER TABLE `riwayat_pinjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simpanan`
--
ALTER TABLE `simpanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `total_saldo_anggota`
--
ALTER TABLE `total_saldo_anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `_anggota`
--
ALTER TABLE `_anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD CONSTRAINT `angsuran_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `angsuran_id_pinjaman_foreign` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `angsuran_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD CONSTRAINT `jenis_simpanan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jenis_simpanan_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnal_details`
--
ALTER TABLE `jurnal_details`
  ADD CONSTRAINT `jurnal_details_akun_id_foreign` FOREIGN KEY (`akun_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jurnal_details_jurnal_id_foreign` FOREIGN KEY (`jurnal_id`) REFERENCES `jurnal_umums` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `penarikan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penarikan_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `_anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penarikan_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinjaman_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `_anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pinjaman_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_pinjaman`
--
ALTER TABLE `riwayat_pinjaman`
  ADD CONSTRAINT `riwayat_pinjaman_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_pinjaman_id_pinjaman_foreign` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_pinjaman_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  ADD CONSTRAINT `saldo_awal_akun_id_foreign` FOREIGN KEY (`akun_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `simpanan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simpanan_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `_anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `simpanan_id_jenis_simpanan_foreign` FOREIGN KEY (`id_jenis_simpanan`) REFERENCES `jenis_simpanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `simpanan_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `_anggota`
--
ALTER TABLE `_anggota`
  ADD CONSTRAINT `_anggota_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `_anggota_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `_anggota_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
