-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2026 at 11:21 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websitequanao`
--
CREATE DATABASE IF NOT EXISTS `websitequanao` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `websitequanao`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matkhau` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `tenad`, `email`, `matkhau`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$PC7HAMIldyB1oW2NIlnpueEuHHx.40lHu8WTQAiUBXTZX/zMg41lS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

DROP TABLE IF EXISTS `chi_tiet_don_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_don_hang` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `donhangid` bigint UNSIGNED NOT NULL,
  `chitietsanphamid` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL,
  `dongia` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chi_tiet_don_hang_donhangid_foreign` (`donhangid`),
  KEY `chi_tiet_don_hang_chitietsanphamid_foreign` (`chitietsanphamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_san_pham`
--

DROP TABLE IF EXISTS `chi_tiet_san_pham`;
CREATE TABLE IF NOT EXISTS `chi_tiet_san_pham` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sanphamid` bigint UNSIGNED NOT NULL,
  `mausacid` bigint UNSIGNED NOT NULL,
  `kichcoid` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL DEFAULT '0',
  `gia` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chi_tiet_san_pham_sanphamid_mausacid_kichcoid_unique` (`sanphamid`,`mausacid`,`kichcoid`),
  KEY `chi_tiet_san_pham_mausacid_foreign` (`mausacid`),
  KEY `chi_tiet_san_pham_kichcoid_foreign` (`kichcoid`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_san_pham`
--

INSERT INTO `chi_tiet_san_pham` (`id`, `sanphamid`, `mausacid`, `kichcoid`, `soluong`, `gia`, `created_at`, `updated_at`) VALUES
(120, 12, 1, 3, 2, 150000.000, '2026-06-29 03:20:07', '2026-06-29 03:20:07'),
(121, 12, 1, 4, 2, 200000.000, '2026-06-29 03:20:07', '2026-06-29 03:20:07'),
(122, 11, 2, 4, 2, 200000.000, '2026-06-29 04:04:05', '2026-06-29 04:04:05'),
(123, 11, 2, 5, 23, 300000.000, '2026-06-29 04:04:05', '2026-06-29 04:04:05'),
(124, 10, 1, 3, 12, 150000.000, '2026-06-29 04:04:42', '2026-06-29 04:04:42'),
(125, 10, 1, 4, 101, 160000.000, '2026-06-29 04:04:42', '2026-06-29 04:04:42'),
(126, 10, 3, 3, 11, 140000.000, '2026-06-29 04:04:42', '2026-06-29 04:04:42'),
(127, 10, 3, 4, 10, 180000.000, '2026-06-29 04:04:42', '2026-06-29 04:04:42'),
(134, 13, 4, 2, 100, 123000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(135, 13, 4, 3, 110, 100000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(136, 13, 4, 4, 99, 123000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(137, 13, 1, 2, 10, 113000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(138, 13, 1, 3, 103, 103000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(139, 13, 1, 4, 100, 123000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(140, 13, 3, 2, 14, 113000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(141, 13, 3, 3, 44, 113000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28'),
(142, 13, 3, 4, 22, 113000.000, '2026-06-29 04:18:28', '2026-06-29 04:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

DROP TABLE IF EXISTS `danh_gia`;
CREATE TABLE IF NOT EXISTS `danh_gia` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sanphamid` bigint UNSIGNED NOT NULL,
  `khachhangid` bigint UNSIGNED NOT NULL,
  `sosao` tinyint NOT NULL,
  `binhluan` text COLLATE utf8mb4_unicode_ci,
  `hinhanh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngaydang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `danh_gia_sanphamid_foreign` (`sanphamid`),
  KEY `danh_gia_khachhangid_foreign` (`khachhangid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc`
--

DROP TABLE IF EXISTS `danh_muc`;
CREATE TABLE IF NOT EXISTS `danh_muc` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danh_muc`
--

INSERT INTO `danh_muc` (`id`, `ten`, `mota`, `created_at`, `updated_at`) VALUES
(1, 'Áo', NULL, '2026-06-29 01:01:25', '2026-06-29 01:01:25'),
(2, 'Quần', NULL, '2026-06-29 01:01:30', '2026-06-29 01:01:30'),
(3, 'Áo khoác', NULL, '2026-06-29 01:01:36', '2026-06-29 01:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE IF NOT EXISTS `don_hang` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `khachhangid` bigint UNSIGNED NOT NULL,
  `nhanvienid` bigint UNSIGNED DEFAULT NULL,
  `khuyenmaiid` bigint UNSIGNED DEFAULT NULL,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phuong` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thanhpho` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phigiaohang` decimal(12,3) NOT NULL DEFAULT '0.000',
  `tonggia` decimal(12,3) NOT NULL,
  `giamgia` decimal(12,3) NOT NULL DEFAULT '0.000',
  `mavandon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` enum('cho_xac_nhan','dang_xu_ly','dang_giao','hoan_thanh','da_huy') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cho_xac_nhan',
  `phuongthuc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngaydat` datetime NOT NULL,
  `ngaygiao` datetime DEFAULT NULL,
  `ngayhuy` datetime DEFAULT NULL,
  `ghichu` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `don_hang_khachhangid_foreign` (`khachhangid`),
  KEY `don_hang_nhanvienid_foreign` (`nhanvienid`),
  KEY `don_hang_khuyenmaiid_foreign` (`khuyenmaiid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
-- Table structure for table `hinh_anh_san_pham`
--

DROP TABLE IF EXISTS `hinh_anh_san_pham`;
CREATE TABLE IF NOT EXISTS `hinh_anh_san_pham` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sanphamid` bigint UNSIGNED NOT NULL,
  `mausacid` bigint UNSIGNED NOT NULL,
  `hinhanh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hinh_anh_san_pham_sanphamid_foreign` (`sanphamid`),
  KEY `hinh_anh_san_pham_mausacid_foreign` (`mausacid`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinh_anh_san_pham`
--

INSERT INTO `hinh_anh_san_pham` (`id`, `sanphamid`, `mausacid`, `hinhanh`, `public_id`, `created_at`, `updated_at`) VALUES
(37, 10, 1, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728242/dldontneoupitdmfrx2d.jpg', 'dldontneoupitdmfrx2d', '2026-06-29 03:17:23', '2026-06-29 03:17:23'),
(38, 10, 3, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728248/zo2qlr5caocu12on0vdd.jpg', 'zo2qlr5caocu12on0vdd', '2026-06-29 03:17:29', '2026-06-29 03:17:29'),
(39, 11, 2, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728305/bppw93wkaptsomvwt0cg.jpg', 'bppw93wkaptsomvwt0cg', '2026-06-29 03:18:26', '2026-06-29 03:18:26'),
(40, 12, 1, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728407/vtloahmoj6vlysb4vczh.jpg', 'vtloahmoj6vlysb4vczh', '2026-06-29 03:20:07', '2026-06-29 03:20:07'),
(41, 13, 4, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782731867/f780ahecxfialxt85k79.jpg', 'f780ahecxfialxt85k79', '2026-06-29 04:17:48', '2026-06-29 04:17:48'),
(42, 13, 1, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782731871/twv3jxyl3hatktyecuhd.jpg', 'twv3jxyl3hatktyecuhd', '2026-06-29 04:17:51', '2026-06-29 04:17:51'),
(43, 13, 3, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782731907/quhwg747a3j317yemysn.jpg', 'quhwg747a3j317yemysn', '2026-06-29 04:18:28', '2026-06-29 04:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
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
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

DROP TABLE IF EXISTS `khach_hang`;
CREATE TABLE IF NOT EXISTS `khach_hang` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tendangnhap` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matkhau` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaysinh` date DEFAULT NULL,
  `gioitinh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diachi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `khach_hang_tendangnhap_unique` (`tendangnhap`),
  UNIQUE KEY `khach_hang_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `tendangnhap`, `ten`, `email`, `sdt`, `matkhau`, `ngaysinh`, `gioitinh`, `diachi`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'khachhang', 'Áo thun', 'khachhang@gmail.com', '0912345678', '$2y$12$dFTd0OXgzrN/JzX25LB02OybN.4tPWIHpWgRCRUzmyhaIQYjuY3EG', NULL, NULL, NULL, NULL, '2026-06-29 03:14:17', '2026-06-29 03:14:17'),
(2, 'khachang11', 'Khách hànng1', 'khachhang1@gmail.com', '0912345678', '$2y$12$RboxvCbHGo/g7oEOlcN4I.dQEa.ED1lK/on2BYVikj9QC.zd8.M6W', NULL, NULL, NULL, NULL, '2026-06-29 04:08:38', '2026-06-29 04:08:38'),
(3, 'khachhang2', 'Lan Khuowng', 'khachhang2@gmail.com', '0912345678', '$2y$12$7nbDbzOS9k9EXtBdhnsAReHJEwEKh0aAVvdc.vnKGU5O6Y1rnR4wC', NULL, NULL, NULL, NULL, '2026-06-29 04:10:57', '2026-06-29 04:10:57'),
(4, 'khachhang3', 'Lan Khuowng2', 'khachhang3@gmail.com', '0912345678', '$2y$12$elF9GreHfyXqS7ImVzFVGeaVIpLgGbWL/oV69icwGWlPZddP0ptT.', NULL, NULL, NULL, NULL, '2026-06-29 04:13:27', '2026-06-29 04:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `khuyen_mai`
--

DROP TABLE IF EXISTS `khuyen_mai`;
CREATE TABLE IF NOT EXISTS `khuyen_mai` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loai_khuyen_mai` enum('phan_tram','so_tien') COLLATE utf8mb4_unicode_ci NOT NULL,
  `giatrigiam` decimal(12,3) NOT NULL,
  `giatridonhang` decimal(12,3) DEFAULT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kich_co`
--

DROP TABLE IF EXISTS `kich_co`;
CREATE TABLE IF NOT EXISTS `kich_co` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kich_co`
--

INSERT INTO `kich_co` (`id`, `ten`, `created_at`, `updated_at`) VALUES
(1, 'XS', '2026-06-29 01:03:29', '2026-06-29 01:03:29'),
(2, 'S', '2026-06-29 01:03:31', '2026-06-29 01:03:31'),
(3, 'M', '2026-06-29 01:03:34', '2026-06-29 01:03:34'),
(4, 'L', '2026-06-29 01:03:36', '2026-06-29 01:03:36'),
(5, 'XL', '2026-06-29 01:03:39', '2026-06-29 01:03:39'),
(6, 'XXL', '2026-06-29 01:03:42', '2026-06-29 01:03:42'),
(7, 'XXXL', '2026-06-29 01:03:44', '2026-06-29 01:03:44'),
(8, '36', '2026-06-29 04:15:09', '2026-06-29 04:15:09');

-- --------------------------------------------------------

--
-- Table structure for table `loai_san_pham`
--

DROP TABLE IF EXISTS `loai_san_pham`;
CREATE TABLE IF NOT EXISTS `loai_san_pham` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `danhmucid` bigint UNSIGNED NOT NULL,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text COLLATE utf8mb4_unicode_ci,
  `hinhanh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noibat` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loai_san_pham_danhmucid_foreign` (`danhmucid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai_san_pham`
--

INSERT INTO `loai_san_pham` (`id`, `danhmucid`, `ten`, `mota`, `hinhanh`, `noibat`, `created_at`, `updated_at`) VALUES
(1, 1, 'Áo thun', NULL, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782720151/ciy2txlkwvdbcujjawvd.jpg', 0, '2026-06-29 01:02:32', '2026-06-29 01:02:32'),
(2, 2, 'Quần jean', NULL, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782720167/sfttc7g16vd7xvrmlrsp.jpg', 0, '2026-06-29 01:02:48', '2026-06-29 01:02:48'),
(3, 1, 'Áo tây 2', '123', 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782731674/u4r9ngnhpuj9m7xlzmfm.jpg', 0, '2026-06-29 04:14:35', '2026-06-29 04:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `mau_sac`
--

DROP TABLE IF EXISTS `mau_sac`;
CREATE TABLE IF NOT EXISTS `mau_sac` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ma_mau` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mau_sac`
--

INSERT INTO `mau_sac` (`id`, `ma_mau`, `ten`, `created_at`, `updated_at`) VALUES
(1, '#000000', 'Đen', '2026-06-29 01:03:01', '2026-06-29 01:03:01'),
(2, '#FF0000', 'Đỏ', '2026-06-29 01:03:08', '2026-06-29 01:03:08'),
(3, '#FFF700', 'Vàng', '2026-06-29 01:03:19', '2026-06-29 01:03:19'),
(4, '#1D00F5', 'Xanh dương', '2026-06-29 04:14:59', '2026-06-29 04:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_30_141651_create_danh_muc', 1),
(5, '2026_06_17_045133_create_khuyen_mai', 1),
(6, '2026_06_17_045329_create_loai_san_pham', 1),
(7, '2026_06_17_045344_create_san_pham', 1),
(8, '2026_06_17_045405_create_khach_hang', 1),
(9, '2026_06_17_045410_create_admin', 1),
(10, '2026_06_17_045417_create_nhan_vien', 1),
(11, '2026_06_17_045436_create_don_hang', 1),
(12, '2026_06_17_045442_create_mau_sac', 1),
(13, '2026_06_17_045448_create_kich_co', 1),
(14, '2026_06_17_045500_create_chi_tiet_san_pham', 1),
(15, '2026_06_17_045513_create_chi_tiet_don_hang', 1),
(16, '2026_06_17_045539_create_thanh_toan', 1),
(17, '2026_06_17_045998_create_danh_gia', 1),
(18, '2026_06_29_035241_create_hinh_anh_san_pham', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--

DROP TABLE IF EXISTS `nhan_vien`;
CREATE TABLE IF NOT EXISTS `nhan_vien` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tennv` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matkhau` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gioitinh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diachi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chucvu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngayvaolam` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nhan_vien_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `tennv`, `email`, `sdt`, `matkhau`, `gioitinh`, `diachi`, `chucvu`, `ngayvaolam`, `created_at`, `updated_at`) VALUES
(1, 'Lan Khương', 'nhanvien@gmail.com', '0912345678', '$2y$12$WWiEj00RRDVx5JadtFk.0OF2y/kzssCZu2Bd45JI2pWKEkb8Q7geW', 'Nữ', '123 Trần Hưng Đạo', 'Soạn hàng', '2026-06-29', '2026-06-29 02:52:23', '2026-06-29 03:13:41'),
(2, 'Nhân Viên 23', 'nhanvien2@gmail.com', '0912345678', '$2y$12$9iZTKMWUS02UOpofEMt3ye1dgeml/LLPuR/756VNRKN3UdcxYLX8u', 'Nam', '123 Trần Hưng Đạo', 'Soạn hàng', '2026-06-29', '2026-06-29 04:15:53', '2026-06-29 04:15:59');

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
-- Table structure for table `san_pham`
--

DROP TABLE IF EXISTS `san_pham`;
CREATE TABLE IF NOT EXISTS `san_pham` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `danhmucid` bigint UNSIGNED DEFAULT NULL,
  `loaisanphamid` bigint UNSIGNED NOT NULL,
  `ten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `giaban` decimal(12,3) NOT NULL,
  `giagiam` decimal(12,3) DEFAULT NULL,
  `hinhanh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mota` text COLLATE utf8mb4_unicode_ci,
  `noibat` tinyint(1) NOT NULL DEFAULT '0',
  `trangthai` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `san_pham_danhmucid_foreign` (`danhmucid`),
  KEY `san_pham_loaisanphamid_foreign` (`loaisanphamid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`id`, `danhmucid`, `loaisanphamid`, `ten`, `giaban`, `giagiam`, `hinhanh`, `mota`, `noibat`, `trangthai`, `created_at`, `updated_at`) VALUES
(10, 2, 2, 'Quần jean', 200000.000, 120000.000, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728238/hyhbzw6ccraidhejwdvd.jpg', NULL, 0, 1, '2026-06-29 03:17:19', '2026-06-29 03:17:19'),
(11, 1, 1, 'Áo thun', 300000.000, NULL, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728301/ak8vekfbbf8chw0rfun6.jpg', NULL, 0, 1, '2026-06-29 03:18:22', '2026-06-29 03:18:22'),
(12, 1, 1, 'Áo nữ', 200000.000, NULL, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782728405/rjzsbilvwyhxtsvctt8w.jpg', '123', 0, 1, '2026-06-29 03:20:05', '2026-06-29 03:20:05'),
(13, 2, 2, 'Quần jeann', 123000.000, 100000.000, 'https://res.cloudinary.com/dxfsnewj8/image/upload/v1782731862/i5jo2ngqrjtimxgerdmp.jpg', '123', 0, 1, '2026-06-29 04:17:43', '2026-06-29 04:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KdyTxuG2I1Aa0ibdOMc6qHBWGWNI0EQgx9SQkD2M', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHpCcUNSd2I4Y1hIUnZWbzNabENNcEdqaVlIR3A0d01wQ2o3Qm0zVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzEzIjtzOjU6InJvdXRlIjtzOjEyOiJwcm9kdWN0LnNob3ciO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1782731933);

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

DROP TABLE IF EXISTS `thanh_toan`;
CREATE TABLE IF NOT EXISTS `thanh_toan` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `donhangid` bigint UNSIGNED NOT NULL,
  `phuongthuc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sotien` decimal(12,3) NOT NULL,
  `trangthai` enum('cho_thanh_toan','da_thanh_toan','that_bai','hoan_tien') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaythanhtoan` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thanh_toan_donhangid_foreign` (`donhangid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_chitietsanphamid_foreign` FOREIGN KEY (`chitietsanphamid`) REFERENCES `chi_tiet_san_pham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_hang_donhangid_foreign` FOREIGN KEY (`donhangid`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chi_tiet_san_pham`
--
ALTER TABLE `chi_tiet_san_pham`
  ADD CONSTRAINT `chi_tiet_san_pham_kichcoid_foreign` FOREIGN KEY (`kichcoid`) REFERENCES `kich_co` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `chi_tiet_san_pham_mausacid_foreign` FOREIGN KEY (`mausacid`) REFERENCES `mau_sac` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `chi_tiet_san_pham_sanphamid_foreign` FOREIGN KEY (`sanphamid`) REFERENCES `san_pham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_khachhangid_foreign` FOREIGN KEY (`khachhangid`) REFERENCES `khach_hang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_sanphamid_foreign` FOREIGN KEY (`sanphamid`) REFERENCES `san_pham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_khachhangid_foreign` FOREIGN KEY (`khachhangid`) REFERENCES `khach_hang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `don_hang_khuyenmaiid_foreign` FOREIGN KEY (`khuyenmaiid`) REFERENCES `khuyen_mai` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `don_hang_nhanvienid_foreign` FOREIGN KEY (`nhanvienid`) REFERENCES `nhan_vien` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hinh_anh_san_pham`
--
ALTER TABLE `hinh_anh_san_pham`
  ADD CONSTRAINT `hinh_anh_san_pham_mausacid_foreign` FOREIGN KEY (`mausacid`) REFERENCES `mau_sac` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `hinh_anh_san_pham_sanphamid_foreign` FOREIGN KEY (`sanphamid`) REFERENCES `san_pham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  ADD CONSTRAINT `loai_san_pham_danhmucid_foreign` FOREIGN KEY (`danhmucid`) REFERENCES `danh_muc` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_danhmucid_foreign` FOREIGN KEY (`danhmucid`) REFERENCES `danh_muc` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `san_pham_loaisanphamid_foreign` FOREIGN KEY (`loaisanphamid`) REFERENCES `loai_san_pham` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_donhangid_foreign` FOREIGN KEY (`donhangid`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
