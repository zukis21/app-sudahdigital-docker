-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2022 at 05:42 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b2b_sudahonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `b2b_client`
--

CREATE TABLE `b2b_client` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_whatsapp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inst_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ytb_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twt_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('CLIENT','OWNER') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `b2b_client`
--

INSERT INTO `b2b_client` (`id`, `client_name`, `client_image`, `client_slug`, `company_name`, `email`, `phone_whatsapp`, `phone`, `client_address`, `fb_url`, `inst_url`, `ytb_url`, `twt_url`, `status`, `created_at`, `updated_at`, `type`) VALUES
(1, 'Mega Cool', '/client_image/LOGO MEGACOOLS_DEFAULT.png', 'mega-cool', 'CV. Mega Cool', 'megacool@gmail.com', '82113464465', '‭021777000', 'Jakarta Barat', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-16 03:48:50', '2021-08-23 06:21:00', 'CLIENT'),
(2, 'Mega Pro', '/client_image/1623867795_mega_pro.jpg', 'mega-pro', 'CV. Mega Pro', 'megapro@gmail.com', '81288111666', '‭021333444', 'Jakarta Barat', 'https://facebook.com', NULL, NULL, NULL, 'ACTIVE', '2021-06-16 03:48:50', '2021-06-16 18:26:58', 'CLIENT'),
(3, 'Owner', '/client_image/Logo_SudahOnline.png', 'owner', 'Sudahonline.com', 'admin@sudahonline.com', '919191919191', '‭02100000', 'Jakarta', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-17 03:59:38', '2021-06-17 03:59:38', 'OWNER'),
(7, 'New Name', '', 'new-name', 'Toko New', 'new@new.com', '09876354233', '2342342342', 'Jakarta', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-17 18:15:03', '2021-06-17 18:15:03', 'CLIENT'),
(8, 'New Toko', '', 'new-toko', 'Toko New', 'news@new.com', '81190873211', '234235435', 'Jakarta', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-17 18:17:00', '2021-06-17 18:17:00', 'CLIENT'),
(9, 'Ojol new', '', 'ojol-new', 'Toko Ojo', 'ojo@new.com', '0987654321', '982736364', 'Jakarta', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-17 18:18:37', '2021-06-17 18:18:37', 'CLIENT'),
(10, 'Asli', '', 'asli', 'Asli', 'asli@email.com', '80000000000', '08000000000000', 'Jakarta', NULL, NULL, NULL, NULL, 'ACTIVE', '2021-06-17 18:22:30', '2021-06-17 19:31:29', 'CLIENT'),
(12, 'New Test', '', 'new-test', 'New Test', 'newtest@test.com', '821134644123', '9292383376123123', 'Test', NULL, NULL, NULL, NULL, 'ACTIVE', '2022-01-25 06:48:27', '2022-01-25 06:48:27', 'CLIENT');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Berisi nama file image tanpa path',
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `delete_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `name`, `image`, `client_id`, `position`, `create_by`, `update_by`, `delete_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Example banner -1', 'banner_images/RBztNOKDbs1GdokB8N4WSLrpPA0tdnuEnaGTv7Ty.jpg', 1, 2, 1, 1, NULL, NULL, '2021-03-03 03:26:26', '2021-08-25 06:16:57'),
(2, 'Example Banner -2', 'banner_images/E87QJnpuuD3mnA7GgLh2SzOWdJnRnSjoJYvk2zDt.jpg', 1, 1, 1, 1, NULL, NULL, '2021-03-03 03:28:10', '2021-08-25 06:16:57'),
(3, 'Example banner -3', 'banner_images/pLwCnEIVWHBa5MGbw3vT8S4DqNsbfwjegppSBewa.jpg', 1, 1, 1, 1, NULL, NULL, '2021-03-03 03:28:32', '2021-08-04 10:24:28'),
(11, 'test2', 'banner_images/XsonOZgm4hBmv4MOgkDaDxqlFXmvTLE9QyiDNiiS.png', 10, 2, 37, NULL, NULL, NULL, '2021-06-20 08:36:50', '2021-06-20 08:47:54'),
(5, 'Test tnt1', 'banner_images/7XD7J3KsK18bX5ZUjTZS00nxoEC7h8YAMsfOCOHX.jpg', 2, 1, 24, NULL, NULL, NULL, '2021-06-08 06:42:56', '2021-06-08 06:50:55'),
(6, 'tes ttnt2', 'banner_images/ihs7LdMmA8TqQFmtnMIvr45GfilTW8xUe2dQC93s.jpg', 2, 2, 24, 24, NULL, NULL, '2021-06-08 06:43:12', '2021-06-08 06:50:55'),
(10, 'test', 'banner_images/nVVQf9KVXJvtMhD5UPznXd6rLyUf29eU1sGfGeqH.png', 10, 1, 37, NULL, NULL, NULL, '2021-06-20 08:22:45', '2021-06-20 08:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `catalogs`
--

CREATE TABLE `catalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Berisi nama file image tanpa path',
  `parent_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `delete_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image_category`, `parent_id`, `client_id`, `create_by`, `update_by`, `delete_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(9, 'Parendfgdf dsfgdfg sdfgsdgsggt 2', 'parent-2', '', NULL, 1, 29, NULL, NULL, NULL, '2021-07-26 10:23:14', '2021-07-26 10:23:14'),
(10, 'test p2 asdkasdk asdasd ccccv asdasdas asdaDASD ASDSDSA zxczc', 'test-p2', '', 9, 1, 29, NULL, NULL, NULL, '2021-07-26 10:23:42', '2021-07-26 10:23:42'),
(4, 'Category2', 'category2', '', NULL, 1, 29, NULL, NULL, NULL, '2021-07-02 02:38:54', '2021-07-02 02:38:54'),
(11, 'cat c 1', 'cat-c-1', '', 4, 1, 29, NULL, NULL, NULL, '2021-07-26 10:26:53', '2021-07-26 10:26:53'),
(7, 'parent test', 'parent-test', '', 4, 1, 29, 29, NULL, NULL, '2021-07-20 08:38:28', '2021-07-21 09:31:12'),
(8, 'oke', 'oke', '', 6, 1, 29, NULL, NULL, NULL, '2021-07-20 08:39:05', '2021-07-20 08:39:05'),
(12, 'Parent 3', 'parent-3', '', NULL, 1, 29, NULL, NULL, NULL, '2021-07-28 08:07:45', '2021-07-28 08:07:45'),
(13, 'p1.1', 'p11', '', 10, 1, 29, NULL, NULL, NULL, '2021-07-28 08:08:05', '2021-07-28 08:08:05'),
(22, 'baut1', 'parendfgdf-dsfgdfg-sdfgsdgsggt-2-baut1', '', 9, 1, 29, NULL, NULL, NULL, '2021-09-09 03:12:22', '2021-09-09 03:12:22'),
(16, 'Baut', 'baut', '', NULL, 1, 29, NULL, NULL, NULL, '2021-07-30 07:58:30', '2021-08-26 06:19:06'),
(17, 'baut1', 'baut1', '', 16, 1, 29, NULL, NULL, NULL, '2021-07-31 15:40:03', '2021-07-31 15:40:03'),
(21, '123344', '123344', '', 13, 1, 29, NULL, NULL, NULL, '2021-09-01 18:30:35', '2021-09-01 18:30:35'),
(19, 'baut 2', 'baut-2', '', 16, 1, 29, NULL, NULL, NULL, '2021-08-04 07:08:23', '2021-08-04 07:08:23'),
(20, 'baut 2x3 1', 'baut-2x3-1', '', NULL, 1, 29, NULL, NULL, NULL, '2021-08-04 07:20:27', '2021-08-26 06:19:23'),
(23, 'test', 'test', '', NULL, 1, 29, NULL, NULL, NULL, '2021-10-14 02:36:30', '2021-10-14 02:36:30'),
(24, 'test2', '23-test-test2', '', 23, 1, 29, NULL, NULL, NULL, '2021-10-14 02:39:56', '2021-10-14 02:39:56'),
(25, 'tttttttest', 'tttttttest-24', '', NULL, 1, 29, NULL, NULL, NULL, '2021-10-14 03:09:19', '2021-10-14 03:09:19'),
(26, 'txtxtxtxtxt', 'txtxtxtxtxt-26', '', NULL, 1, 29, NULL, NULL, NULL, '2021-10-14 03:09:55', '2021-10-14 03:09:55'),
(27, 'txtxtxtxtxt', 'txtxtxtxtxt-27', '', NULL, 1, 29, NULL, NULL, NULL, '2021-10-14 03:27:31', '2021-10-14 03:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(2, NULL, 4, NULL, NULL),
(11, 32, 1, NULL, NULL),
(10, 31, 1, NULL, NULL),
(12, 33, 1, NULL, NULL),
(57, 40, 1, NULL, NULL),
(74, 45, 266, NULL, NULL),
(73, 2, 17, NULL, NULL),
(22, 5, 2, NULL, NULL),
(23, 6, 1, NULL, NULL),
(24, 7, 2, NULL, NULL),
(25, 8, 2, NULL, NULL),
(26, 9, 2, NULL, NULL),
(27, 10, 1, NULL, NULL),
(71, 11, 17, NULL, NULL),
(63, 13, 1, NULL, NULL),
(64, 14, 4, NULL, NULL),
(32, 15, 3, NULL, NULL),
(34, 17, 3, NULL, NULL),
(36, 19, 3, NULL, NULL),
(37, 20, 2, NULL, NULL),
(38, 21, 3, NULL, NULL),
(39, 22, 3, NULL, NULL),
(40, 23, 2, NULL, NULL),
(41, 24, 3, NULL, NULL),
(42, 25, 3, NULL, NULL),
(43, 26, 3, NULL, NULL),
(44, 27, 3, NULL, NULL),
(45, 28, 1, NULL, NULL),
(66, 29, 1, NULL, NULL),
(48, 31, 1, NULL, NULL),
(49, 32, 1, NULL, NULL),
(50, 33, 1, NULL, NULL),
(51, 34, 2, NULL, NULL),
(52, 35, 2, NULL, NULL),
(53, 36, 2, NULL, NULL),
(54, 37, 3, NULL, NULL),
(55, 38, 3, NULL, NULL),
(59, 41, 1, NULL, NULL),
(75, 46, 266, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cat_pareto`
--

CREATE TABLE `cat_pareto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pareto_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cat_pareto`
--

INSERT INTO `cat_pareto` (`id`, `pareto_code`, `name`, `client_id`, `position`, `status`, `created_at`, `updated_at`) VALUES
(4, 'P.80', '', 1, 1, 'ACTIVE', '2021-08-05 02:54:20', '2021-08-07 12:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `city_name`, `type`, `postal_code`, `display_order`) VALUES
(1, 21, 'Aceh Barat', 'Kabupaten', '23681', 12),
(2, 21, 'Aceh Barat Daya', 'Kabupaten', '23764', 12),
(3, 21, 'Aceh Besar', 'Kabupaten', '23951', 12),
(4, 21, 'Aceh Jaya', 'Kabupaten', '23654', 12),
(5, 21, 'Aceh Selatan', 'Kabupaten', '23719', 12),
(6, 21, 'Aceh Singkil', 'Kabupaten', '24785', 12),
(7, 21, 'Aceh Tamiang', 'Kabupaten', '24476', 12),
(8, 21, 'Aceh Tengah', 'Kabupaten', '24511', 12),
(9, 21, 'Aceh Tenggara', 'Kabupaten', '24611', 12),
(10, 21, 'Aceh Timur', 'Kabupaten', '24454', 12),
(11, 21, 'Aceh Utara', 'Kabupaten', '24382', 12),
(12, 32, 'Agam', 'Kabupaten', '26411', 12),
(13, 23, 'Alor', 'Kabupaten', '85811', 12),
(14, 19, 'Ambon', 'Kota', '97222', 12),
(15, 34, 'Asahan', 'Kabupaten', '21214', 12),
(16, 24, 'Asmat', 'Kabupaten', '99777', 12),
(17, 1, 'Badung', 'Kabupaten', '80351', 12),
(18, 13, 'Balangan', 'Kabupaten', '71611', 12),
(19, 15, 'Balikpapan', 'Kota', '76111', 12),
(20, 21, 'Banda Aceh', 'Kota', '23238', 12),
(21, 18, 'Bandar Lampung', 'Kota', '35139', 12),
(22, 9, 'Bandung', 'Kabupaten', '40311', 12),
(23, 9, 'Bandung', 'Kota', '40111', 9),
(24, 9, 'Bandung Barat', 'Kabupaten', '40721', 12),
(25, 29, 'Banggai', 'Kabupaten', '94711', 12),
(26, 29, 'Banggai Kepulauan', 'Kabupaten', '94881', 12),
(27, 2, 'Bangka', 'Kabupaten', '33212', 12),
(28, 2, 'Bangka Barat', 'Kabupaten', '33315', 12),
(29, 2, 'Bangka Selatan', 'Kabupaten', '33719', 12),
(30, 2, 'Bangka Tengah', 'Kabupaten', '33613', 12),
(31, 11, 'Bangkalan', 'Kabupaten', '69118', 12),
(32, 1, 'Bangli', 'Kabupaten', '80619', 12),
(33, 13, 'Banjar', 'Kabupaten', '70619', 12),
(34, 9, 'Banjar', 'Kota', '46311', 12),
(35, 13, 'Banjarbaru', 'Kota', '70712', 12),
(36, 13, 'Banjarmasin', 'Kota', '70117', 12),
(37, 10, 'Banjarnegara', 'Kabupaten', '53419', 12),
(38, 28, 'Bantaeng', 'Kabupaten', '92411', 12),
(39, 5, 'Bantul', 'Kabupaten', '55715', 12),
(40, 33, 'Banyuasin', 'Kabupaten', '30911', 12),
(41, 10, 'Banyumas', 'Kabupaten', '53114', 12),
(42, 11, 'Banyuwangi', 'Kabupaten', '68416', 12),
(43, 13, 'Barito Kuala', 'Kabupaten', '70511', 12),
(44, 14, 'Barito Selatan', 'Kabupaten', '73711', 12),
(45, 14, 'Barito Timur', 'Kabupaten', '73671', 12),
(46, 14, 'Barito Utara', 'Kabupaten', '73881', 12),
(47, 28, 'Barru', 'Kabupaten', '90719', 12),
(48, 17, 'Batam', 'Kota', '29413', 12),
(49, 10, 'Batang', 'Kabupaten', '51211', 12),
(50, 8, 'Batang Hari', 'Kabupaten', '36613', 12),
(51, 11, 'Batu', 'Kota', '65311', 12),
(52, 34, 'Batu Bara', 'Kabupaten', '21655', 12),
(53, 30, 'Bau-Bau', 'Kota', '93719', 12),
(54, 9, 'Bekasi', 'Kabupaten', '17837', 12),
(55, 9, 'Bekasi', 'Kota', '17121', 4),
(56, 2, 'Belitung', 'Kabupaten', '33419', 12),
(57, 2, 'Belitung Timur', 'Kabupaten', '33519', 12),
(58, 23, 'Belu', 'Kabupaten', '85711', 12),
(59, 21, 'Bener Meriah', 'Kabupaten', '24581', 12),
(60, 26, 'Bengkalis', 'Kabupaten', '28719', 12),
(61, 12, 'Bengkayang', 'Kabupaten', '79213', 12),
(62, 4, 'Bengkulu', 'Kota', '38229', 12),
(63, 4, 'Bengkulu Selatan', 'Kabupaten', '38519', 12),
(64, 4, 'Bengkulu Tengah', 'Kabupaten', '38319', 12),
(65, 4, 'Bengkulu Utara', 'Kabupaten', '38619', 12),
(66, 15, 'Berau', 'Kabupaten', '77311', 12),
(67, 24, 'Biak Numfor', 'Kabupaten', '98119', 12),
(68, 22, 'Bima', 'Kabupaten', '84171', 12),
(69, 22, 'Bima', 'Kota', '84139', 12),
(70, 34, 'Binjai', 'Kota', '20712', 12),
(71, 17, 'Bintan', 'Kabupaten', '29135', 12),
(72, 21, 'Bireuen', 'Kabupaten', '24219', 12),
(73, 31, 'Bitung', 'Kota', '95512', 12),
(74, 11, 'Blitar', 'Kabupaten', '66171', 12),
(75, 11, 'Blitar', 'Kota', '66124', 12),
(76, 10, 'Blora', 'Kabupaten', '58219', 12),
(77, 7, 'Boalemo', 'Kabupaten', '96319', 12),
(78, 9, 'Bogor', 'Kabupaten', '16911', 12),
(79, 9, 'Bogor', 'Kota', '16119', 7),
(80, 11, 'Bojonegoro', 'Kabupaten', '62119', 12),
(81, 31, 'Bolaang Mongondow (Bolmong)', 'Kabupaten', '95755', 12),
(82, 31, 'Bolaang Mongondow Selatan', 'Kabupaten', '95774', 12),
(83, 31, 'Bolaang Mongondow Timur', 'Kabupaten', '95783', 12),
(84, 31, 'Bolaang Mongondow Utara', 'Kabupaten', '95765', 12),
(85, 30, 'Bombana', 'Kabupaten', '93771', 12),
(86, 11, 'Bondowoso', 'Kabupaten', '68219', 12),
(87, 28, 'Bone', 'Kabupaten', '92713', 12),
(88, 7, 'Bone Bolango', 'Kabupaten', '96511', 12),
(89, 15, 'Bontang', 'Kota', '75313', 12),
(90, 24, 'Boven Digoel', 'Kabupaten', '99662', 12),
(91, 10, 'Boyolali', 'Kabupaten', '57312', 12),
(92, 10, 'Brebes', 'Kabupaten', '52212', 12),
(93, 32, 'Bukittinggi', 'Kota', '26115', 12),
(94, 1, 'Buleleng', 'Kabupaten', '81111', 12),
(95, 28, 'Bulukumba', 'Kabupaten', '92511', 12),
(96, 16, 'Bulungan (Bulongan)', 'Kabupaten', '77211', 12),
(97, 8, 'Bungo', 'Kabupaten', '37216', 12),
(98, 29, 'Buol', 'Kabupaten', '94564', 12),
(99, 19, 'Buru', 'Kabupaten', '97371', 12),
(100, 19, 'Buru Selatan', 'Kabupaten', '97351', 12),
(101, 30, 'Buton', 'Kabupaten', '93754', 12),
(102, 30, 'Buton Utara', 'Kabupaten', '93745', 12),
(103, 9, 'Ciamis', 'Kabupaten', '46211', 12),
(104, 9, 'Cianjur', 'Kabupaten', '43217', 12),
(105, 10, 'Cilacap', 'Kabupaten', '53211', 12),
(106, 3, 'Cilegon', 'Kota', '42417', 12),
(107, 9, 'Cimahi', 'Kota', '40512', 12),
(108, 9, 'Cirebon', 'Kabupaten', '45611', 12),
(109, 9, 'Cirebon', 'Kota', '45116', 12),
(110, 34, 'Dairi', 'Kabupaten', '22211', 12),
(111, 24, 'Deiyai (Deliyai)', 'Kabupaten', '98784', 12),
(112, 34, 'Deli Serdang', 'Kabupaten', '20511', 12),
(113, 10, 'Demak', 'Kabupaten', '59519', 12),
(114, 1, 'Denpasar', 'Kota', '80227', 12),
(115, 9, 'Depok', 'Kota', '16416', 5),
(116, 32, 'Dharmasraya', 'Kabupaten', '27612', 12),
(117, 24, 'Dogiyai', 'Kabupaten', '98866', 12),
(118, 22, 'Dompu', 'Kabupaten', '84217', 12),
(119, 29, 'Donggala', 'Kabupaten', '94341', 12),
(120, 26, 'Dumai', 'Kota', '28811', 12),
(121, 33, 'Empat Lawang', 'Kabupaten', '31811', 12),
(122, 23, 'Ende', 'Kabupaten', '86351', 12),
(123, 28, 'Enrekang', 'Kabupaten', '91719', 12),
(124, 25, 'Fakfak', 'Kabupaten', '98651', 12),
(125, 23, 'Flores Timur', 'Kabupaten', '86213', 12),
(126, 9, 'Garut', 'Kabupaten', '44126', 12),
(127, 21, 'Gayo Lues', 'Kabupaten', '24653', 12),
(128, 1, 'Gianyar', 'Kabupaten', '80519', 12),
(129, 7, 'Gorontalo', 'Kabupaten', '96218', 12),
(130, 7, 'Gorontalo', 'Kota', '96115', 12),
(131, 7, 'Gorontalo Utara', 'Kabupaten', '96611', 12),
(132, 28, 'Gowa', 'Kabupaten', '92111', 12),
(133, 11, 'Gresik', 'Kabupaten', '61115', 12),
(134, 10, 'Grobogan', 'Kabupaten', '58111', 12),
(135, 5, 'Gunung Kidul', 'Kabupaten', '55812', 12),
(136, 14, 'Gunung Mas', 'Kabupaten', '74511', 12),
(137, 34, 'Gunungsitoli', 'Kota', '22813', 12),
(138, 20, 'Halmahera Barat', 'Kabupaten', '97757', 12),
(139, 20, 'Halmahera Selatan', 'Kabupaten', '97911', 12),
(140, 20, 'Halmahera Tengah', 'Kabupaten', '97853', 12),
(141, 20, 'Halmahera Timur', 'Kabupaten', '97862', 12),
(142, 20, 'Halmahera Utara', 'Kabupaten', '97762', 12),
(143, 13, 'Hulu Sungai Selatan', 'Kabupaten', '71212', 12),
(144, 13, 'Hulu Sungai Tengah', 'Kabupaten', '71313', 12),
(145, 13, 'Hulu Sungai Utara', 'Kabupaten', '71419', 12),
(146, 34, 'Humbang Hasundutan', 'Kabupaten', '22457', 12),
(147, 26, 'Indragiri Hilir', 'Kabupaten', '29212', 12),
(148, 26, 'Indragiri Hulu', 'Kabupaten', '29319', 12),
(149, 9, 'Indramayu', 'Kabupaten', '45214', 12),
(150, 24, 'Intan Jaya', 'Kabupaten', '98771', 12),
(151, 6, 'Jakarta Barat', 'Kota', '11220', 1),
(152, 6, 'Jakarta Pusat', 'Kota', '10540', 1),
(153, 6, 'Jakarta Selatan', 'Kota', '12230', 1),
(154, 6, 'Jakarta Timur', 'Kota', '13330', 1),
(155, 6, 'Jakarta Utara', 'Kota', '14140', 1),
(156, 8, 'Jambi', 'Kota', '36111', 12),
(157, 24, 'Jayapura', 'Kabupaten', '99352', 12),
(158, 24, 'Jayapura', 'Kota', '99114', 12),
(159, 24, 'Jayawijaya', 'Kabupaten', '99511', 12),
(160, 11, 'Jember', 'Kabupaten', '68113', 12),
(161, 1, 'Jembrana', 'Kabupaten', '82251', 12),
(162, 28, 'Jeneponto', 'Kabupaten', '92319', 12),
(163, 10, 'Jepara', 'Kabupaten', '59419', 12),
(164, 11, 'Jombang', 'Kabupaten', '61415', 12),
(165, 25, 'Kaimana', 'Kabupaten', '98671', 12),
(166, 26, 'Kampar', 'Kabupaten', '28411', 12),
(167, 14, 'Kapuas', 'Kabupaten', '73583', 12),
(168, 12, 'Kapuas Hulu', 'Kabupaten', '78719', 12),
(169, 10, 'Karanganyar', 'Kabupaten', '57718', 12),
(170, 1, 'Karangasem', 'Kabupaten', '80819', 12),
(171, 9, 'Karawang', 'Kabupaten', '41311', 12),
(172, 17, 'Karimun', 'Kabupaten', '29611', 12),
(173, 34, 'Karo', 'Kabupaten', '22119', 12),
(174, 14, 'Katingan', 'Kabupaten', '74411', 12),
(175, 4, 'Kaur', 'Kabupaten', '38911', 12),
(176, 12, 'Kayong Utara', 'Kabupaten', '78852', 12),
(177, 10, 'Kebumen', 'Kabupaten', '54319', 12),
(178, 11, 'Kediri', 'Kabupaten', '64184', 12),
(179, 11, 'Kediri', 'Kota', '64125', 12),
(180, 24, 'Keerom', 'Kabupaten', '99461', 12),
(181, 10, 'Kendal', 'Kabupaten', '51314', 12),
(182, 30, 'Kendari', 'Kota', '93126', 12),
(183, 4, 'Kepahiang', 'Kabupaten', '39319', 12),
(184, 17, 'Kepulauan Anambas', 'Kabupaten', '29991', 12),
(185, 19, 'Kepulauan Aru', 'Kabupaten', '97681', 12),
(186, 32, 'Kepulauan Mentawai', 'Kabupaten', '25771', 12),
(187, 26, 'Kepulauan Meranti', 'Kabupaten', '28791', 12),
(188, 31, 'Kepulauan Sangihe', 'Kabupaten', '95819', 12),
(189, 6, 'Kepulauan Seribu', 'Kabupaten', '14550', 12),
(190, 31, 'Kepulauan Siau Tagulandang Biaro (Sitaro)', 'Kabupaten', '95862', 12),
(191, 20, 'Kepulauan Sula', 'Kabupaten', '97995', 12),
(192, 31, 'Kepulauan Talaud', 'Kabupaten', '95885', 12),
(193, 24, 'Kepulauan Yapen (Yapen Waropen)', 'Kabupaten', '98211', 12),
(194, 8, 'Kerinci', 'Kabupaten', '37167', 12),
(195, 12, 'Ketapang', 'Kabupaten', '78874', 12),
(196, 10, 'Klaten', 'Kabupaten', '57411', 12),
(197, 1, 'Klungkung', 'Kabupaten', '80719', 12),
(198, 30, 'Kolaka', 'Kabupaten', '93511', 12),
(199, 30, 'Kolaka Utara', 'Kabupaten', '93911', 12),
(200, 30, 'Konawe', 'Kabupaten', '93411', 12),
(201, 30, 'Konawe Selatan', 'Kabupaten', '93811', 12),
(202, 30, 'Konawe Utara', 'Kabupaten', '93311', 12),
(203, 13, 'Kotabaru', 'Kabupaten', '72119', 12),
(204, 31, 'Kotamobagu', 'Kota', '95711', 12),
(205, 14, 'Kotawaringin Barat', 'Kabupaten', '74119', 12),
(206, 14, 'Kotawaringin Timur', 'Kabupaten', '74364', 12),
(207, 26, 'Kuantan Singingi', 'Kabupaten', '29519', 12),
(208, 12, 'Kubu Raya', 'Kabupaten', '78311', 12),
(209, 10, 'Kudus', 'Kabupaten', '59311', 12),
(210, 5, 'Kulon Progo', 'Kabupaten', '55611', 12),
(211, 9, 'Kuningan', 'Kabupaten', '45511', 12),
(212, 23, 'Kupang', 'Kabupaten', '85362', 12),
(213, 23, 'Kupang', 'Kota', '85119', 12),
(214, 15, 'Kutai Barat', 'Kabupaten', '75711', 12),
(215, 15, 'Kutai Kartanegara', 'Kabupaten', '75511', 12),
(216, 15, 'Kutai Timur', 'Kabupaten', '75611', 12),
(217, 34, 'Labuhan Batu', 'Kabupaten', '21412', 12),
(218, 34, 'Labuhan Batu Selatan', 'Kabupaten', '21511', 12),
(219, 34, 'Labuhan Batu Utara', 'Kabupaten', '21711', 12),
(220, 33, 'Lahat', 'Kabupaten', '31419', 12),
(221, 14, 'Lamandau', 'Kabupaten', '74611', 12),
(222, 11, 'Lamongan', 'Kabupaten', '64125', 12),
(223, 18, 'Lampung Barat', 'Kabupaten', '34814', 12),
(224, 18, 'Lampung Selatan', 'Kabupaten', '35511', 12),
(225, 18, 'Lampung Tengah', 'Kabupaten', '34212', 12),
(226, 18, 'Lampung Timur', 'Kabupaten', '34319', 12),
(227, 18, 'Lampung Utara', 'Kabupaten', '34516', 12),
(228, 12, 'Landak', 'Kabupaten', '78319', 12),
(229, 34, 'Langkat', 'Kabupaten', '20811', 12),
(230, 21, 'Langsa', 'Kota', '24412', 12),
(231, 24, 'Lanny Jaya', 'Kabupaten', '99531', 12),
(232, 3, 'Lebak', 'Kabupaten', '42319', 12),
(233, 4, 'Lebong', 'Kabupaten', '39264', 12),
(234, 23, 'Lembata', 'Kabupaten', '86611', 12),
(235, 21, 'Lhokseumawe', 'Kota', '24352', 12),
(236, 32, 'Lima Puluh Koto/Kota', 'Kabupaten', '26671', 12),
(237, 17, 'Lingga', 'Kabupaten', '29811', 12),
(238, 22, 'Lombok Barat', 'Kabupaten', '83311', 12),
(239, 22, 'Lombok Tengah', 'Kabupaten', '83511', 12),
(240, 22, 'Lombok Timur', 'Kabupaten', '83612', 12),
(241, 22, 'Lombok Utara', 'Kabupaten', '83711', 12),
(242, 33, 'Lubuk Linggau', 'Kota', '31614', 12),
(243, 11, 'Lumajang', 'Kabupaten', '67319', 12),
(244, 28, 'Luwu', 'Kabupaten', '91994', 12),
(245, 28, 'Luwu Timur', 'Kabupaten', '92981', 12),
(246, 28, 'Luwu Utara', 'Kabupaten', '92911', 12),
(247, 11, 'Madiun', 'Kabupaten', '63153', 12),
(248, 11, 'Madiun', 'Kota', '63122', 12),
(249, 10, 'Magelang', 'Kabupaten', '56519', 12),
(250, 10, 'Magelang', 'Kota', '56133', 12),
(251, 11, 'Magetan', 'Kabupaten', '63314', 12),
(252, 9, 'Majalengka', 'Kabupaten', '45412', 12),
(253, 27, 'Majene', 'Kabupaten', '91411', 12),
(254, 28, 'Makassar', 'Kota', '90111', 10),
(255, 11, 'Malang', 'Kabupaten', '65163', 12),
(256, 11, 'Malang', 'Kota', '65112', 12),
(257, 16, 'Malinau', 'Kabupaten', '77511', 12),
(258, 19, 'Maluku Barat Daya', 'Kabupaten', '97451', 12),
(259, 19, 'Maluku Tengah', 'Kabupaten', '97513', 12),
(260, 19, 'Maluku Tenggara', 'Kabupaten', '97651', 12),
(261, 19, 'Maluku Tenggara Barat', 'Kabupaten', '97465', 12),
(262, 27, 'Mamasa', 'Kabupaten', '91362', 12),
(263, 24, 'Mamberamo Raya', 'Kabupaten', '99381', 12),
(264, 24, 'Mamberamo Tengah', 'Kabupaten', '99553', 12),
(265, 27, 'Mamuju', 'Kabupaten', '91519', 12),
(266, 27, 'Mamuju Utara', 'Kabupaten', '91571', 12),
(267, 31, 'Manado', 'Kota', '95247', 12),
(268, 34, 'Mandailing Natal', 'Kabupaten', '22916', 12),
(269, 23, 'Manggarai', 'Kabupaten', '86551', 12),
(270, 23, 'Manggarai Barat', 'Kabupaten', '86711', 12),
(271, 23, 'Manggarai Timur', 'Kabupaten', '86811', 12),
(272, 25, 'Manokwari', 'Kabupaten', '98311', 12),
(273, 25, 'Manokwari Selatan', 'Kabupaten', '98355', 12),
(274, 24, 'Mappi', 'Kabupaten', '99853', 12),
(275, 28, 'Maros', 'Kabupaten', '90511', 12),
(276, 22, 'Mataram', 'Kota', '83131', 12),
(277, 25, 'Maybrat', 'Kabupaten', '98051', 12),
(278, 34, 'Medan', 'Kota', '20228', 3),
(279, 12, 'Melawi', 'Kabupaten', '78619', 12),
(280, 8, 'Merangin', 'Kabupaten', '37319', 12),
(281, 24, 'Merauke', 'Kabupaten', '99613', 12),
(282, 18, 'Mesuji', 'Kabupaten', '34911', 12),
(283, 18, 'Metro', 'Kota', '34111', 12),
(284, 24, 'Mimika', 'Kabupaten', '99962', 12),
(285, 31, 'Minahasa', 'Kabupaten', '95614', 12),
(286, 31, 'Minahasa Selatan', 'Kabupaten', '95914', 12),
(287, 31, 'Minahasa Tenggara', 'Kabupaten', '95995', 12),
(288, 31, 'Minahasa Utara', 'Kabupaten', '95316', 12),
(289, 11, 'Mojokerto', 'Kabupaten', '61382', 12),
(290, 11, 'Mojokerto', 'Kota', '61316', 12),
(291, 29, 'Morowali', 'Kabupaten', '94911', 12),
(292, 33, 'Muara Enim', 'Kabupaten', '31315', 12),
(293, 8, 'Muaro Jambi', 'Kabupaten', '36311', 12),
(294, 4, 'Muko Muko', 'Kabupaten', '38715', 12),
(295, 30, 'Muna', 'Kabupaten', '93611', 12),
(296, 14, 'Murung Raya', 'Kabupaten', '73911', 12),
(297, 33, 'Musi Banyuasin', 'Kabupaten', '30719', 12),
(298, 33, 'Musi Rawas', 'Kabupaten', '31661', 12),
(299, 24, 'Nabire', 'Kabupaten', '98816', 12),
(300, 21, 'Nagan Raya', 'Kabupaten', '23674', 12),
(301, 23, 'Nagekeo', 'Kabupaten', '86911', 12),
(302, 17, 'Natuna', 'Kabupaten', '29711', 12),
(303, 24, 'Nduga', 'Kabupaten', '99541', 12),
(304, 23, 'Ngada', 'Kabupaten', '86413', 12),
(305, 11, 'Nganjuk', 'Kabupaten', '64414', 12),
(306, 11, 'Ngawi', 'Kabupaten', '63219', 12),
(307, 34, 'Nias', 'Kabupaten', '22876', 12),
(308, 34, 'Nias Barat', 'Kabupaten', '22895', 12),
(309, 34, 'Nias Selatan', 'Kabupaten', '22865', 12),
(310, 34, 'Nias Utara', 'Kabupaten', '22856', 12),
(311, 16, 'Nunukan', 'Kabupaten', '77421', 12),
(312, 33, 'Ogan Ilir', 'Kabupaten', '30811', 12),
(313, 33, 'Ogan Komering Ilir', 'Kabupaten', '30618', 12),
(314, 33, 'Ogan Komering Ulu', 'Kabupaten', '32112', 12),
(315, 33, 'Ogan Komering Ulu Selatan', 'Kabupaten', '32211', 12),
(316, 33, 'Ogan Komering Ulu Timur', 'Kabupaten', '32312', 12),
(317, 11, 'Pacitan', 'Kabupaten', '63512', 12),
(318, 32, 'Padang', 'Kota', '25112', 12),
(319, 34, 'Padang Lawas', 'Kabupaten', '22763', 12),
(320, 34, 'Padang Lawas Utara', 'Kabupaten', '22753', 12),
(321, 32, 'Padang Panjang', 'Kota', '27122', 12),
(322, 32, 'Padang Pariaman', 'Kabupaten', '25583', 12),
(323, 34, 'Padang Sidempuan', 'Kota', '22727', 12),
(324, 33, 'Pagar Alam', 'Kota', '31512', 12),
(325, 34, 'Pakpak Bharat', 'Kabupaten', '22272', 12),
(326, 14, 'Palangka Raya', 'Kota', '73112', 12),
(327, 33, 'Palembang', 'Kota', '30111', 12),
(328, 28, 'Palopo', 'Kota', '91911', 12),
(329, 29, 'Palu', 'Kota', '94111', 12),
(330, 11, 'Pamekasan', 'Kabupaten', '69319', 12),
(331, 3, 'Pandeglang', 'Kabupaten', '42212', 12),
(332, 9, 'Pangandaran', 'Kabupaten', '46511', 12),
(333, 28, 'Pangkajene Kepulauan', 'Kabupaten', '90611', 12),
(334, 2, 'Pangkal Pinang', 'Kota', '33115', 12),
(335, 24, 'Paniai', 'Kabupaten', '98765', 12),
(336, 28, 'Parepare', 'Kota', '91123', 12),
(337, 32, 'Pariaman', 'Kota', '25511', 12),
(338, 29, 'Parigi Moutong', 'Kabupaten', '94411', 12),
(339, 32, 'Pasaman', 'Kabupaten', '26318', 12),
(340, 32, 'Pasaman Barat', 'Kabupaten', '26511', 12),
(341, 15, 'Paser', 'Kabupaten', '76211', 12),
(342, 11, 'Pasuruan', 'Kabupaten', '67153', 12),
(343, 11, 'Pasuruan', 'Kota', '67118', 12),
(344, 10, 'Pati', 'Kabupaten', '59114', 12),
(345, 32, 'Payakumbuh', 'Kota', '26213', 12),
(346, 25, 'Pegunungan Arfak', 'Kabupaten', '98354', 12),
(347, 24, 'Pegunungan Bintang', 'Kabupaten', '99573', 12),
(348, 10, 'Pekalongan', 'Kabupaten', '51161', 12),
(349, 10, 'Pekalongan', 'Kota', '51122', 12),
(350, 26, 'Pekanbaru', 'Kota', '28112', 12),
(351, 26, 'Pelalawan', 'Kabupaten', '28311', 12),
(352, 10, 'Pemalang', 'Kabupaten', '52319', 12),
(353, 34, 'Pematang Siantar', 'Kota', '21126', 12),
(354, 15, 'Penajam Paser Utara', 'Kabupaten', '76311', 12),
(355, 18, 'Pesawaran', 'Kabupaten', '35312', 12),
(356, 18, 'Pesisir Barat', 'Kabupaten', '35974', 12),
(357, 32, 'Pesisir Selatan', 'Kabupaten', '25611', 12),
(358, 21, 'Pidie', 'Kabupaten', '24116', 12),
(359, 21, 'Pidie Jaya', 'Kabupaten', '24186', 12),
(360, 28, 'Pinrang', 'Kabupaten', '91251', 12),
(361, 7, 'Pohuwato', 'Kabupaten', '96419', 12),
(362, 27, 'Polewali Mandar', 'Kabupaten', '91311', 12),
(363, 11, 'Ponorogo', 'Kabupaten', '63411', 12),
(364, 12, 'Pontianak', 'Kabupaten', '78971', 12),
(365, 12, 'Pontianak', 'Kota', '78112', 12),
(366, 29, 'Poso', 'Kabupaten', '94615', 12),
(367, 33, 'Prabumulih', 'Kota', '31121', 12),
(368, 18, 'Pringsewu', 'Kabupaten', '35719', 12),
(369, 11, 'Probolinggo', 'Kabupaten', '67282', 12),
(370, 11, 'Probolinggo', 'Kota', '67215', 12),
(371, 14, 'Pulang Pisau', 'Kabupaten', '74811', 12),
(372, 20, 'Pulau Morotai', 'Kabupaten', '97771', 12),
(373, 24, 'Puncak', 'Kabupaten', '98981', 12),
(374, 24, 'Puncak Jaya', 'Kabupaten', '98979', 12),
(375, 10, 'Purbalingga', 'Kabupaten', '53312', 12),
(376, 9, 'Purwakarta', 'Kabupaten', '41119', 12),
(377, 10, 'Purworejo', 'Kabupaten', '54111', 12),
(378, 25, 'Raja Ampat', 'Kabupaten', '98489', 12),
(379, 4, 'Rejang Lebong', 'Kabupaten', '39112', 12),
(380, 10, 'Rembang', 'Kabupaten', '59219', 12),
(381, 26, 'Rokan Hilir', 'Kabupaten', '28992', 12),
(382, 26, 'Rokan Hulu', 'Kabupaten', '28511', 12),
(383, 23, 'Rote Ndao', 'Kabupaten', '85982', 12),
(384, 21, 'Sabang', 'Kota', '23512', 12),
(385, 23, 'Sabu Raijua', 'Kabupaten', '85391', 12),
(386, 10, 'Salatiga', 'Kota', '50711', 12),
(387, 15, 'Samarinda', 'Kota', '75133', 12),
(388, 12, 'Sambas', 'Kabupaten', '79453', 12),
(389, 34, 'Samosir', 'Kabupaten', '22392', 12),
(390, 11, 'Sampang', 'Kabupaten', '69219', 12),
(391, 12, 'Sanggau', 'Kabupaten', '78557', 12),
(392, 24, 'Sarmi', 'Kabupaten', '99373', 12),
(393, 8, 'Sarolangun', 'Kabupaten', '37419', 12),
(394, 32, 'Sawah Lunto', 'Kota', '27416', 12),
(395, 12, 'Sekadau', 'Kabupaten', '79583', 12),
(396, 28, 'Selayar (Kepulauan Selayar)', 'Kabupaten', '92812', 12),
(397, 4, 'Seluma', 'Kabupaten', '38811', 12),
(398, 10, 'Semarang', 'Kabupaten', '50511', 12),
(399, 10, 'Semarang', 'Kota', '50135', 8),
(400, 19, 'Seram Bagian Barat', 'Kabupaten', '97561', 12),
(401, 19, 'Seram Bagian Timur', 'Kabupaten', '97581', 12),
(402, 3, 'Serang', 'Kabupaten', '42182', 12),
(403, 3, 'Serang', 'Kota', '42111', 12),
(404, 34, 'Serdang Bedagai', 'Kabupaten', '20915', 12),
(405, 14, 'Seruyan', 'Kabupaten', '74211', 12),
(406, 26, 'Siak', 'Kabupaten', '28623', 12),
(407, 34, 'Sibolga', 'Kota', '22522', 12),
(408, 28, 'Sidenreng Rappang/Rapang', 'Kabupaten', '91613', 12),
(409, 11, 'Sidoarjo', 'Kabupaten', '61219', 12),
(410, 29, 'Sigi', 'Kabupaten', '94364', 12),
(411, 32, 'Sijunjung (Sawah Lunto Sijunjung)', 'Kabupaten', '27511', 12),
(412, 23, 'Sikka', 'Kabupaten', '86121', 12),
(413, 34, 'Simalungun', 'Kabupaten', '21162', 12),
(414, 21, 'Simeulue', 'Kabupaten', '23891', 12),
(415, 12, 'Singkawang', 'Kota', '79117', 12),
(416, 28, 'Sinjai', 'Kabupaten', '92615', 12),
(417, 12, 'Sintang', 'Kabupaten', '78619', 12),
(418, 11, 'Situbondo', 'Kabupaten', '68316', 12),
(419, 5, 'Sleman', 'Kabupaten', '55513', 12),
(420, 32, 'Solok', 'Kabupaten', '27365', 12),
(421, 32, 'Solok', 'Kota', '27315', 12),
(422, 32, 'Solok Selatan', 'Kabupaten', '27779', 12),
(423, 28, 'Soppeng', 'Kabupaten', '90812', 12),
(424, 25, 'Sorong', 'Kabupaten', '98431', 12),
(425, 25, 'Sorong', 'Kota', '98411', 12),
(426, 25, 'Sorong Selatan', 'Kabupaten', '98454', 12),
(427, 10, 'Sragen', 'Kabupaten', '57211', 12),
(428, 9, 'Subang', 'Kabupaten', '41215', 12),
(429, 21, 'Subulussalam', 'Kota', '24882', 12),
(430, 9, 'Sukabumi', 'Kabupaten', '43311', 12),
(431, 9, 'Sukabumi', 'Kota', '43114', 12),
(432, 14, 'Sukamara', 'Kabupaten', '74712', 12),
(433, 10, 'Sukoharjo', 'Kabupaten', '57514', 12),
(434, 23, 'Sumba Barat', 'Kabupaten', '87219', 12),
(435, 23, 'Sumba Barat Daya', 'Kabupaten', '87453', 12),
(436, 23, 'Sumba Tengah', 'Kabupaten', '87358', 12),
(437, 23, 'Sumba Timur', 'Kabupaten', '87112', 12),
(438, 22, 'Sumbawa', 'Kabupaten', '84315', 12),
(439, 22, 'Sumbawa Barat', 'Kabupaten', '84419', 12),
(440, 9, 'Sumedang', 'Kabupaten', '45326', 12),
(441, 11, 'Sumenep', 'Kabupaten', '69413', 12),
(442, 8, 'Sungaipenuh', 'Kota', '37113', 12),
(443, 24, 'Supiori', 'Kabupaten', '98164', 12),
(444, 11, 'Surabaya', 'Kota', '60119', 2),
(445, 10, 'Surakarta (Solo)', 'Kota', '57113', 12),
(446, 13, 'Tabalong', 'Kabupaten', '71513', 12),
(447, 1, 'Tabanan', 'Kabupaten', '82119', 12),
(448, 28, 'Takalar', 'Kabupaten', '92212', 12),
(449, 25, 'Tambrauw', 'Kabupaten', '98475', 12),
(450, 16, 'Tana Tidung', 'Kabupaten', '77611', 12),
(451, 28, 'Tana Toraja', 'Kabupaten', '91819', 12),
(452, 13, 'Tanah Bumbu', 'Kabupaten', '72211', 12),
(453, 32, 'Tanah Datar', 'Kabupaten', '27211', 12),
(454, 13, 'Tanah Laut', 'Kabupaten', '70811', 12),
(455, 3, 'Tangerang', 'Kabupaten', '15914', 12),
(456, 3, 'Tangerang', 'Kota', '15111', 6),
(457, 3, 'Tangerang Selatan', 'Kota', '15332', 6),
(458, 18, 'Tanggamus', 'Kabupaten', '35619', 12),
(459, 34, 'Tanjung Balai', 'Kota', '21321', 12),
(460, 8, 'Tanjung Jabung Barat', 'Kabupaten', '36513', 12),
(461, 8, 'Tanjung Jabung Timur', 'Kabupaten', '36719', 12),
(462, 17, 'Tanjung Pinang', 'Kota', '29111', 12),
(463, 34, 'Tapanuli Selatan', 'Kabupaten', '22742', 12),
(464, 34, 'Tapanuli Tengah', 'Kabupaten', '22611', 12),
(465, 34, 'Tapanuli Utara', 'Kabupaten', '22414', 12),
(466, 13, 'Tapin', 'Kabupaten', '71119', 12),
(467, 16, 'Tarakan', 'Kota', '77114', 12),
(468, 9, 'Tasikmalaya', 'Kabupaten', '46411', 12),
(469, 9, 'Tasikmalaya', 'Kota', '46116', 12),
(470, 34, 'Tebing Tinggi', 'Kota', '20632', 12),
(471, 8, 'Tebo', 'Kabupaten', '37519', 12),
(472, 10, 'Tegal', 'Kabupaten', '52419', 12),
(473, 10, 'Tegal', 'Kota', '52114', 12),
(474, 25, 'Teluk Bintuni', 'Kabupaten', '98551', 12),
(475, 25, 'Teluk Wondama', 'Kabupaten', '98591', 12),
(476, 10, 'Temanggung', 'Kabupaten', '56212', 12),
(477, 20, 'Ternate', 'Kota', '97714', 12),
(478, 20, 'Tidore Kepulauan', 'Kota', '97815', 12),
(479, 23, 'Timor Tengah Selatan', 'Kabupaten', '85562', 12),
(480, 23, 'Timor Tengah Utara', 'Kabupaten', '85612', 12),
(481, 34, 'Toba Samosir', 'Kabupaten', '22316', 12),
(482, 29, 'Tojo Una-Una', 'Kabupaten', '94683', 12),
(483, 29, 'Toli-Toli', 'Kabupaten', '94542', 12),
(484, 24, 'Tolikara', 'Kabupaten', '99411', 12),
(485, 31, 'Tomohon', 'Kota', '95416', 12),
(486, 28, 'Toraja Utara', 'Kabupaten', '91831', 12),
(487, 11, 'Trenggalek', 'Kabupaten', '66312', 12),
(488, 19, 'Tual', 'Kota', '97612', 12),
(489, 11, 'Tuban', 'Kabupaten', '62319', 12),
(490, 18, 'Tulang Bawang', 'Kabupaten', '34613', 12),
(491, 18, 'Tulang Bawang Barat', 'Kabupaten', '34419', 12),
(492, 11, 'Tulungagung', 'Kabupaten', '66212', 12),
(493, 28, 'Wajo', 'Kabupaten', '90911', 12),
(494, 30, 'Wakatobi', 'Kabupaten', '93791', 12),
(495, 24, 'Waropen', 'Kabupaten', '98269', 12),
(496, 18, 'Way Kanan', 'Kabupaten', '34711', 12),
(497, 10, 'Wonogiri', 'Kabupaten', '57619', 12),
(498, 10, 'Wonosobo', 'Kabupaten', '56311', 12),
(499, 24, 'Yahukimo', 'Kabupaten', '99041', 12),
(500, 24, 'Yalimo', 'Kabupaten', '99481', 12),
(501, 5, 'Yogyakarta', 'Kota', '55111', 12);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cust_type` int(11) DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_owner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_store` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','NONACTIVE','NEW') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_point` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `payment_term` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pareto_id` int(11) DEFAULT NULL,
  `lat` decimal(17,15) DEFAULT NULL,
  `lng` decimal(17,14) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `store_code`, `name`, `email`, `store_name`, `cust_type`, `city_id`, `address`, `phone`, `phone_owner`, `phone_store`, `status`, `reg_point`, `payment_term`, `user_id`, `client_id`, `created_at`, `updated_at`, `pareto_id`, `lat`, `lng`) VALUES
(2, 'R.S.046', 'A LIANG', NULL, '3 SAUDARA MOTOR  - SAHARJO', NULL, 153, 'JL DR SAHARJO JAKSEL', '081384619193', NULL, NULL, 'ACTIVE', 'N', '30 Days', 5, 1, '2021-02-25 02:57:26', '2022-01-06 03:17:30', 4, NULL, NULL),
(3, 'R.A.054', 'UKI', NULL, 'ANTASENA MOTOR', NULL, 153, 'JL RAYA POLTANGAN PASAR MINGGU', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(4, 'R.A.047', 'ANTO', NULL, 'ANTO MOTOR', NULL, 153, 'JL BUNGUR II KEBAYORAN LAMA', '0853 2899 6032', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(5, 'R.A.035', 'ARIF', NULL, 'ARIF MOTOR', NULL, 153, 'JL.JOE JAGAKARSA', '08119216721', NULL, NULL, 'ACTIVE', 'N', '20', 7, 1, '2021-02-25 02:57:26', '2021-06-24 07:35:01', NULL, NULL, NULL),
(6, 'R.A.044', 'ARI', NULL, 'ARI MOTOR', NULL, 115, 'JL RAYA GANDUL DEPOK', '0822 2654 4776', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(7, 'R.A.037', 'IYAN', NULL, 'ARITHA MOTOR', NULL, 153, 'JL PANCORAN BARAT VII DUREN 3', '0813 1148 6022', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(8, 'R.A.043', 'PIYUS', NULL, 'ARITHA MOTOR 2', NULL, 154, 'JL.BUDAYA CONDET', '0812 8027 4768', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(9, 'R.A.046', 'BP', NULL, 'ARYA MOTOR', NULL, 153, 'JL KAHFI 1 CIGANJUR', '021 786 8438', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 05:12:44', NULL, NULL, NULL),
(10, 'R.A.038', 'AWANG', 'cst@cst.com', 'A W K  MOTOR', 2, 153, 'JL ASEM BARIS RAYA NO.14', '082112038632', NULL, NULL, 'ACTIVE', 'N', '7 Days', 31, 1, '2021-02-25 02:57:26', '2021-06-25 06:23:26', NULL, NULL, NULL),
(11, 'R.B.010', 'BP', 'cust@mail.com', '168 BORNEO', 5, 55, 'JL RAYA KASUARI NO.15', '08121986 8985', NULL, NULL, 'ACTIVE', 'N', '7 Days', 8, 1, '2021-02-25 02:57:26', '2021-06-28 21:25:55', NULL, NULL, NULL),
(12, 'R.A.003', 'AGUNG', NULL, 'AGUNG MOTOR', NULL, 153, 'JL.GATOT SUBROTO NO.119', '085104503018', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(13, 'R.A.058', 'BP', NULL, 'ALEX MOTOR', NULL, 55, 'JL TAMAN ASTER JAKA SETIA', '0812 8779 8685', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(14, 'R.A.039', NULL, NULL, 'ALI MOTOR', NULL, 55, 'JL RAYA MEKARSARI TAMBUN', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(15, 'R.A.007', 'KO.KEVIN', NULL, 'ALI MOTOR - TAMBUN', NULL, 55, 'JL.RAYA MANGUN JAYA TAMBUN', '0813 9856 3695', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(16, 'R.A.028', 'BP', NULL, 'ALKAY SEJAHTERA', NULL, 55, 'JL RAYA MEKAR SARI BEKASI', '0812 8081 2120', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(17, 'R.A.040', 'BP', NULL, 'ANEKA JAYA -  BEKASI', NULL, 55, 'JL RAYA PONDOK TIMUR INDAH', '0819 0320 3612', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(18, 'R.A.013', 'BP', NULL, 'ANEKA JAYA MOTOR - CIKARANG', NULL, 55, 'JL SERANG CIBARUSA KAMPUNG BABAKAN', '0853 1161 1760', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:51:33', NULL, NULL, NULL),
(19, 'R.A.057', 'BP', NULL, 'ANEKA MOTOR - CIKARANG', NULL, 153, 'JL RAYA SUKATANI CIKARANG', '0838 1590 8456', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(20, 'R.A.001', 'BP', NULL, 'ANEKA UTAMA', NULL, 153, 'JL.RAYA PASAR BABELAN BEKASI', '0856 9451 9009', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(21, 'R.A.022', 'JACK', NULL, 'ABADI MOTOR - BOGOR', NULL, 153, 'JL RAYA TAJUR BOGOR', '0895 0420 0200', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(22, 'R.A.016', 'DEDEN', NULL, 'ABM  MOTOR - DEPOK', NULL, 153, 'LEUWINANGGUNG TAPOS  DEPOK', '0812 8341 1814', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(23, 'R.A.042', 'AJITIANTO', NULL, 'AJITA MOTOR', NULL, 153, 'JL RAYA BOGOR CIKARAT', '0895 3320 60779', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(24, 'R.A.048', 'ALFIAN', NULL, 'ALFA JAYA SERVICE', NULL, 153, 'JL RAYA AKSES UI DEPOK', '0813 1589 1544', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(25, 'R.A.045', 'ALIE', NULL, 'ALI MOTOR - TAPOS DEPOK', NULL, 153, 'JL RAYA LIWINANGGUNG', '0812 5832 6436', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(26, 'R.A.029', 'GIRI', NULL, 'ANEKA BAUT MOTOR ( A B M )', NULL, 153, 'JL RAYA BOGOR CILUAR NO.359', '0813 8090 5305', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(27, 'R.A.014', 'DEDEN', NULL, 'ANEKA JAYA MOTOR - DEPOK', NULL, 153, 'LEUWINANGGUNG TAPOS DEPOK/JALAN BARU', '0812 8341 1814', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(28, 'R.A.021', 'AYUNG', NULL, 'ANEKA MOTOR - BOGOR', NULL, 153, 'JL RAYA VETERAN BOGOR', '0811 1106 034', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(29, 'R.A.019', 'APUNG', NULL, 'APUNG MOTOR - CINERE', NULL, 153, 'JL RAYA MARUYUNG  LIMO CINERE  DEPOK', '0821 2578 6128', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(30, 'R.A.032', 'HENDRA', NULL, 'ASIA MOTOR - DEPOK', NULL, 153, 'JL RAYA BOGOR KM.36.6 NO.11', '0811 183 031', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(31, 'R.A.027', 'BP', NULL, 'AKUR MOTOR / DAMAI MOTOR RAJIMAN', NULL, 153, 'JL RAJIMAN NO.126', '0815 9509 228', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(32, 'R.A.010', 'BP', NULL, 'ALIF MOTOR - PULO GADUNG', NULL, 153, 'JL RAYA BEKASI NO.6 RT.03/01 JATINEGARA KAUM', '0812 1343 3096', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(33, 'R.A.018', 'BP', NULL, 'ALMA MOTOR - CIPINANG', NULL, 153, 'JL CIPINANG BARU RAYA NO.38', '0822 0842 6575', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(34, 'R.A.034', 'EDI', NULL, 'ANEKA MOBIL', NULL, 153, 'JL RAYA PONDOK GEDE NO.24', '0817 136 951', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(35, 'R.A.015', 'BP', NULL, 'ANTIQ  MOTOR', NULL, 153, 'JL RAYA CIRACAS ( SAMPING ALFA)', '021 8705 909', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(36, 'R.A.023', 'YADI', NULL, 'ANUGERAH JAYA OTISTA', NULL, 153, 'JL RAYA OTISTA NO.42', '0818 0808 6168', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(37, 'R.A.030', 'DARMA', NULL, 'ARINOS CAKRA ADIDAYA', NULL, 153, 'RUKO PASAR PAGI BINTARA', '0812 8662 4060', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(38, 'R.A.033', 'BP', NULL, 'ASTRO MOTOR', NULL, 153, 'JL.KRANGGAN RT.02/RW.12', '0852 8422 7998', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(39, 'R.A.017', 'BP', NULL, 'AULIA - PULO GEBANG', NULL, 153, 'JL RAYA PULO GEBANG NO.7 CAKUNG', '0877 7610 4100', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(40, 'R.A.049', 'BP', NULL, 'AUTO PIT SEJAHTERA - PT', NULL, 153, 'JL RAYA KALIMALANG', '0896 0248 0191', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(41, 'R.A.024', 'BP', NULL, 'AAN MOTOR', NULL, 153, 'JL.IR JUANDA NO.151', '0812 9934 3551', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(42, 'R.A.031', 'HARI', NULL, 'ABM MOTOR - BEKASI', NULL, 153, 'JL TAWED RAYA NO.2', '0812 9198 2504', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(43, 'R.A.004', 'ADI', NULL, 'ADI MOTOR', NULL, 153, 'JL MUSTIKA SARI NO.35 C -D', '0818 0777 1930', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(44, 'R.A.005', 'AGUS', NULL, 'AGUS MOTOR', NULL, 153, 'RUKO KALI MALANG GRAND CENTER NO.1', '021 8644265', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(45, 'R.A.051', NULL, NULL, 'ANEKA TEHNIK - CV', NULL, 153, 'JL CUT MUTIA BLOK A NO.12', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(46, 'R.A.020', 'HERI', NULL, 'ANEKA TEKNIK - BEKASI', NULL, 153, 'JL CUT MUTIA', '0878 8207 477', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(47, 'R.A.026', 'ANGEL', NULL, 'ANGEL MOTOR', NULL, 153, 'JL TAWES NO.04 KAYURINGIN', '0812 8234 5755', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(48, 'R.A.056', 'ALDO', NULL, 'ANUGERAH  MOTOR - BEKASI', NULL, 153, 'JL.IR JUANDA 151 , RUKO MITRA BEKASI, BEKASI ,  Jawa Barat', '0819 3418 4478', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(49, 'R.A.008', 'BP', NULL, 'AULIA MOTOR - ALEXINDO', NULL, 153, 'JL.RAYA BEKASI KM.28,5 MEDAN SATRIA', '0812 1990 649', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(50, 'R.A.041', 'BP', NULL, 'AULIA MOTOR -  BEKASI', NULL, 153, 'JL.SULTAN AGUNG NO.18', '0812 1990 649', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-02-25 02:57:26', '2021-05-24 07:29:52', NULL, NULL, NULL),
(51, NULL, 'Baru', 'baru@days.com', NULL, NULL, 153, NULL, '09876534212', '81211111000', '81212123123', 'NEW', 'N', '45 Days', 8, 1, '2021-02-28 10:20:53', '2021-08-05 05:09:46', NULL, NULL, NULL),
(52, NULL, 'xzc', NULL, 'szc', NULL, NULL, 'dfgvfxgb', '213423', '243234', '242342', 'NEW', 'N', NULL, 3, 1, '2021-03-05 02:58:24', '2021-03-05 02:58:24', NULL, NULL, NULL),
(53, NULL, 'pak abcd', NULL, 'abcd', NULL, NULL, '765ghjfgjh', '887686', '6575', '67576575', 'NEW', 'N', NULL, 3, 1, '2021-03-05 07:20:28', '2021-03-05 07:20:28', NULL, NULL, NULL),
(54, NULL, '123', NULL, '123', NULL, NULL, '123', '123', '123', '123', 'NEW', 'N', NULL, 7, 1, '2021-03-07 08:40:13', '2021-03-07 08:40:13', NULL, NULL, NULL),
(55, 'R.M.044test', 'IBU', NULL, '33 MOTOR CERVICE', 4, 153, 'JL BANGKA RAYA MAMPANG , JAKARTA SELATAN, JAKARTA ,  DKI Jakarta', '081227798783', NULL, NULL, 'ACTIVE', 'N', '30 Days', 3, 1, '2021-03-24 17:44:48', '2021-09-08 16:51:46', 4, '-6.289215896700362', '106.41750189405957'),
(59, 'R.M.044test1', 'IBU yes', NULL, '33 MOTOR CERVICE', 5, 153, 'JL BANGKA RAYA MAMPANG , JAKARTA SELATAN, JAKARTA ,  DKI Jakarta', '081227798783', NULL, NULL, 'ACTIVE', 'N', '30 Days', 3, 1, '2021-03-24 18:09:59', '2021-09-08 16:47:41', 4, '-6.246705404363641', '106.81518648184098'),
(60, 'ASD', 'afsf', 'asd@m', 'ada', NULL, 20, 'eee', '5645645645645', '2342354235235', '23523523523', 'ACTIVE', 'N', '7 Days', 7, 1, '2021-05-21 18:09:56', '2021-05-22 02:35:53', NULL, NULL, NULL),
(61, 'R.S.027', 'ROBERT', NULL, 'SINAR TIMUR', NULL, 79, 'JL RAYA ALTERNATIF CILENGSI', '021 8249 0755', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:51:33', NULL, NULL, NULL),
(62, 'R.W.007', 'ELI', NULL, 'PT. WIFA MANDIRI PERKASA', NULL, 155, 'JL INDOKARYA 1 BLOK E.NO.1', '021 651 5151 / 0816 1921 204', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:51:33', NULL, NULL, NULL),
(63, 'R.S.049', 'KO.AKIN', NULL, 'SUMBER JAYA MOTOR', NULL, 55, 'JL SULTAN HASANUDIN NO 5', '0812 8509 293', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:51:33', NULL, NULL, NULL),
(64, 'R.B.005', 'HAJI YONO', NULL, 'BERKAT SERVICE', NULL, 115, 'JL RAYA AKSES UI DEPOK NO.4', '0815 1866 615', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:51:33', NULL, NULL, NULL),
(65, 'R.D.008', 'CI LENI', NULL, 'DUNIA MOTOR - TENDEAN', NULL, 153, 'JL RAYA TENDEAN', '0858 1317 7895', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(66, 'R.T.008', 'BP', NULL, 'TUNAS JAYA MOTOR - CIPINANG', NULL, 153, 'JL BEKASI TIMUR RAYA NO.198 CIPINANG', '0858 8268 5167', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(67, 'R.B.013', 'RIRIN', NULL, 'BERKAH JAYA MOTOR - CIPETE', NULL, 153, 'JL.ABDUL MAJID  CIPETE', '0838 6727 4117', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(68, 'R.D.011', 'HARTONO', NULL, 'DAMAI MOTOR', NULL, 153, 'JL.KRT RADJIMAN NO.126 JATINEGARA', '0812 1006 6812', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(69, 'R.M.023', 'BP', NULL, 'MUSTIKA JAYA MOTOR', NULL, 153, 'JL MUSTIKA JAYA NO.158', '0882 9212 9552', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(70, 'R.H.007', 'H.THAMRIN', NULL, 'PT HUBAS SEDAYU PUTRA', NULL, 153, 'JL ARIEF  RAHMAN HAKIM NO.85', '0812 9702 8797', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(71, 'R.M.005', 'BP', NULL, 'MULTI VARIASI', NULL, 153, 'JL RAYA PASAR SETU NO.64', '0812 6766 1333', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(72, 'R.S.070', 'BP', NULL, 'SUMBER MAS MOTOR', NULL, 153, 'JL.IR.JUANDA RUKO MITRA BEKASI BLOK E NO.34', '0855 1188 579', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(73, 'R.G.005', 'BP', NULL, 'GIOK  MOTOR', NULL, 153, 'JL RA KARTINI BEKASI TIMUR', '0813 1403 5588', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(74, 'R.M.0467', 'IBU', NULL, 'gentong motor', NULL, 153, 'JL BANGKA RAYA MAMPANG , JAKARTA SELATAN, JAKARTA ,  DKI Jakarta', '0812 2779 8783', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(75, 'R.S.0468', 'A LIANG', NULL, 'claris motor', NULL, 153, 'JL DR SAHARJO JAKSEL, JAKARTA ,  DKI Jakarta', '0813 8461 9193', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 05:12:44', '2021-05-24 07:29:52', NULL, NULL, NULL),
(76, 'R.S.012', 'BP', NULL, 'SURYA MOTOR CIBITUNG', NULL, 153, 'JL.RAYA TEUKU UMAR NO.12 CIBITUNG', '0821 1062 5222', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(77, 'R.S.007', 'HARIANTO', NULL, 'SINAR ALAM MOTOR', NULL, 153, 'JL RAYA MARGONDA NO.380', '08161342540', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(78, 'R.H.001', 'BP', NULL, 'HOTAMA MOTOR', NULL, 153, 'JL.RAYA SUKAMTO NO.2 MALAKA IV', '021 7079 8691', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(79, 'R.G.001', 'BP', NULL, 'GENESIS', NULL, 153, 'JL.RUKO TAMAN HARAPAN BARU BLOK B1 NO.20', '082298425417', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(80, 'R.H.002', NULL, NULL, 'HUBAS SEDAYU PUTRA', NULL, 153, 'JL.ARIF RAHMAN HAKIM NO.85', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(81, 'R.L.001', 'BP', NULL, 'LAVANA MOTOR', NULL, 153, 'JL.TAMAN WISMA ASRI  RUKO L NO.9', '081298888979', NULL, NULL, 'ACTIVE', 'N', '60 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(82, 'R.S.002', 'BP', NULL, 'SEMPURNA MOTOR CAKUNG', NULL, 153, 'JL RAYA BEKASI DPN PT NAPOLI CAKUNG', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(83, 'R.C.001', 'JHONI', NULL, 'CHANDRA MOTOR - CIKARANG', NULL, 153, 'JL.CIKARANG PLAZA B 22', '0822 5656 5599', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(84, 'R.S.003', 'BP', NULL, 'SUMBER USAHA', NULL, 153, 'JL RAYA BOGOR KM 27 NO.12A', '0816 666 059', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(85, 'R.B.001', NULL, NULL, 'BERKAH MOTOR - CV', NULL, 153, 'JL.MAMPANG PRAPATAN RAYA NO.22', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(86, 'R.T.001', 'KO.CLIF', NULL, 'THEMIES MOTOR', NULL, 153, 'JL PERJUANGAN NO.28 BEKASI', '0818 0777 0222', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(87, 'R.M.001', 'BP', NULL, 'MAJU JAYA MOTOR 888', NULL, 153, 'JL PEJUANG RUKO SEGI TIGA BLOK B2', '0812 9188 8787', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(88, 'R.W.001', 'NETI', NULL, 'W.D.K MOTOR', NULL, 153, 'JL.IR JUANDA NO.187 B TAMBUN', '021 882 6067', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(89, 'R.B.002', NULL, NULL, 'BEKASI MOTOR JUANDA', NULL, 153, 'JL.IR JUANDA NO.32 BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(90, 'R.S.004', NULL, NULL, 'SEN MOTOR - CONDET', NULL, 153, 'JL.BATU AMPAR III NO.188 CONDET', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(91, 'R.C.002', NULL, NULL, 'CAWANG BARU  MOTOR - JATIMAKMUR', NULL, 153, 'JL.JATI MAKMUR NO.115 BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(92, 'R.M.002', NULL, NULL, 'MAJU BERSAMA MOTOR', NULL, 153, 'KOMPLEKS METLAND BLOK J 4 NO.3', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(93, 'R.M.003', 'ALUN', NULL, 'MAJU JAYA MOTOR - DEPOK', NULL, 153, 'JL.BOJONG SARI NO.36 SAWANGAN', '085386257563', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(94, 'R.K.001', NULL, NULL, 'KENZIE MOTOR', NULL, 153, 'JL.TAMAN HARAPAN BARU BLOK P.2/NO.10', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(95, 'R.C.003', 'BP', NULL, 'CAHAYA LAUT MANDIRI', NULL, 153, 'JL.BATU AMPAR III RT.01/04 NO.11', '0816 1468 707', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(96, 'R.N.001', 'BP', NULL, 'NUSANTARA MOTOR CIJANTUNG', NULL, 153, 'JL.RAYA GONGSENG NO.18 CIJANTUNG', '0851 0052 3899', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(97, 'R.S.006', NULL, NULL, 'SENTRA KENCANA MOTORINDO - PT ( BERLIAN MOTOR)', NULL, 153, 'JL.RAYA BEKASI KM 22  CAKUNG', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(98, 'R.J.001', NULL, NULL, 'JAYA TERUS - CIBITUNG', NULL, 153, 'JL RAYA TEUKU UMAR NO.44 CIBITUNG', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(99, 'R.M.004', 'BP', NULL, 'MUTIARA MOTOR  - OTISTA', NULL, 153, 'JL.RAYA OTISTA NO.37B JAKARTA', '0813 8249 8658', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(100, 'R.J.002', 'BP', NULL, 'JAYA ABADI MOTOR - MENTENG ATAS', NULL, 153, 'JL MENTENG ATAS NO.7 SAHARJO', '0812 8939 3299', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(101, 'R.B.003', NULL, NULL, 'BENGKEL MOBIL BLUE', NULL, 153, 'JL.RAYA JATI ASIH NO.32 BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(102, 'R.J.003', 'ANTON', NULL, 'JAYA CHANDRA WIJAYA - CV', NULL, 153, 'JL.DIPONEGORO KP.BARU NO.19A RT.001.RW.018', '081295888899', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(103, 'R.I.001', 'ALING', NULL, 'ISTANA AGUNG MOTOR', NULL, 153, 'RUKO PUTRA NO.5', '0817 0839 77', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(104, 'R.N.002', 'KO. APEN', NULL, 'NEW SAKURA MOTOR', NULL, 153, 'JLN YOS SUDARSO NO.20 CIKARANG', '0812 1060 609', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(105, 'R.F.001', 'KO.YOHANES', NULL, 'FAJAR ABADI I', NULL, 153, 'JL.GATOT SUBROTO NO.18 CIKARANG', '0878 8008 3754', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(106, 'R.J.004', 'VINCENT SUTANTO', NULL, 'JAYA TEHNIK', NULL, 153, 'JL.CUT MUTIA RUKO BEKASI', '0812 9598 2929', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(107, 'R.G.002', 'RUDY', NULL, 'GEMILANG MOTOR- PD GEDE', NULL, 153, 'RUKO PESONA TAMAN MINI BLOK I NO.12', '0821 1133 1112', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(108, 'R.S.005', 'BP', NULL, 'SEMPURNA MOTOR - TAMBUN', NULL, 153, 'JL MEKAR SARI RAYA TAMBUN', '0812 8983 8118', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(109, 'R.A.002', 'BP', NULL, 'AUTO JAYA', NULL, 153, 'JL.PAHLAWAN NO.75 BULAK KAPAL BEKASI TIMUR', '08787811688', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(110, 'R.L.002', NULL, NULL, 'LANCAR MOTOR - TEBET', NULL, 153, 'JL BERKAH I NO.2/10 TEBET', NULL, NULL, NULL, 'ACTIVE', 'N', '60 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(111, 'R.U.001', 'BP', NULL, 'UTAMA MOTOR BINTARA', NULL, 153, 'JL.BINTARA JAYA NO.9', '085252077739', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(112, 'R.C.004', 'BP.', NULL, 'CAHAYA MAKMUR', NULL, 153, 'JL HARAPAN INDAH BLOK EF 12', '083813921577', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(113, 'R.S.008', 'BP', NULL, 'SIDO MUKTI JAYA', NULL, 153, 'JL INSPEKSI SALURAN KALI MALANG', '081369585257', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(114, 'R.Y.001', 'YAMA', NULL, 'YAMA MOTOR', NULL, 153, 'JL GATOT SUBROTO NO.38B', '085691399112', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(115, 'R.P.001', NULL, NULL, 'PUTRA JAYA MOTOR CILENGSI', NULL, 153, 'JL.RAYA NAROGONG', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(116, 'R.D.001', 'BP', NULL, 'DENSO MOTOR - KRANJI', NULL, 153, 'RUKO KRANJI MAS', '0859 2196 3831', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(117, 'R.J.005', 'BP.', NULL, 'JONGKI MOTOR', NULL, 153, 'JL RAYA PENGGILINGAN NO.9A', '081319355599', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(118, 'R.E.001', 'BP', NULL, 'EKA JAYA - OTISTA', NULL, 153, 'JL.OTISTA RAYA NO.89', '021 8575433', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(119, 'R.T.003', 'BP', NULL, 'TRIJAYA - OTISTA', NULL, 153, 'JL OTISTA RAYA NO.133', '0812 9923856', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(120, 'R.T.002', 'BP', NULL, 'TOPIK MOTOR', NULL, 153, 'DUREN SAWIT', '081294674730', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(121, 'R.I.002', 'EDI', NULL, 'INDOTEK', NULL, 153, 'JL.DEPNAKER NO.27 KEL MAKASAR', '0817124242', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(122, 'R.M.006', 'BP', NULL, 'MULYA JAYA MOTOR', NULL, 153, 'JL RAYA KARANG SATRIA TAMBUN UTARA', '082246143865', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(123, 'R.K.003', 'BP', NULL, 'KARTIKA MOTOR', NULL, 153, 'JL.SULTAN AGUNG NO.423 PONDOK UNGU', '0896 1376 9628', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(124, 'R.T.004', 'BP', NULL, 'TUNAS JAYA MOTOR', NULL, 153, 'JL.PAHLAWAN REVOLUSI KLENDER', '021 861 0337', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(125, 'R.M.007', 'ANDI', NULL, 'MANDIRI JAYA MOTOR - DEPOK', NULL, 153, 'JL LUWINANGGUNG PEREMPATAN', '0812 8737 0692', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(126, 'R.F.002', 'KO FERDY', NULL, 'FERDY MOTOR', NULL, 153, 'JL.RAYA STASIUN CITAYAM NO.45', '0806 3574 8471', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(127, 'R.C.005', 'CRISAN', NULL, 'CRISAN MAS MOTOR', NULL, 153, 'JL.JATI MEKAR NO.5 PONDOK GEDE', '0811 1752 752', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(128, 'R.W.002', 'YUNI', NULL, 'WIJAYA JAYA MOTOR', NULL, 153, 'JL PONDOK TIMUR NO 8K', '0859 2122 5454', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(129, 'R.K.004', 'MUNTE', NULL, 'KARMILA JAYA MOTOR', NULL, 153, 'JL RAYA SETU DESA TELAJUNG SAMPING SD 02 TELAJUNG', '0852 1088 5945', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(130, 'R.M.009', 'KO ALUNG', NULL, 'MULTI JAYA  MOTOR -SETU', NULL, 153, 'JL RAYA SETU MEKAR WANGI BEKASI', '0812 8826 6637', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(131, 'R.W.003', 'CI ANG', NULL, 'WAHANA MOTOR', NULL, 153, 'JL KRT RADJIMAN NO.9 RAWA BADUNG', '0852 1691 1025', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(132, 'R.J.006', 'ISHAK', NULL, 'JADI JAYA MOTOR - CILANGKAP', NULL, 153, 'JL RAYA CILANGKAP NO.82 JAKARTA TIMUR', '0851 0062 1320', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(133, 'R.J.008', 'PURYANI', NULL, 'JAWA MOTOR  - BEKASI', NULL, 153, 'JL PAHLAWAN NO.123 BEKASI', '0812 1296 3430', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(134, 'R.I.003', 'BP', NULL, 'IN JAYA MOTOR', NULL, 153, 'JL JATIWARINGIN NO.127 PONDOK GEDE', '021 849 02107', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(135, 'R.L.003', 'MULYONO', NULL, 'LANCAR  MAJU BAHAGIA - CV', NULL, 153, 'LANCAR MOTOR', '0818 0821 7689', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(136, 'R.T.005', 'BP', NULL, 'TASIA  MOTOR', NULL, 153, 'JL PERJUANAGAN KM.8 KEBALEN UTARA', '0878 8205 3004', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(137, 'R.M.010', 'KO AMIN', NULL, 'MULTI  MOTOR', NULL, 153, 'JL RAYA SETU  BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(138, 'R.T.006', 'BP', NULL, 'TERANG JAYA - BINTARA', NULL, 153, 'JL BINTARA RAYA 14 NO 7C BEKASI BARAT', '0856 9495 6591', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(139, 'R.A.006', 'BP', NULL, 'APUNG  MOTOR V ( F8 MOTOR)', NULL, 153, 'JL.RAYA MOCH.KAHFI NO.60E CIGANJUR', '0895 7027 17922', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(140, 'R.M.011', 'BP', NULL, 'MAKMUR JAYA MOTOR - PSR MINGGU', NULL, 153, 'JL RAYA PASAR MINGGU NO.75 A', '0812 9029 6147', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(141, 'R.S.009', 'AKUANG', NULL, 'SEMESTA MOTOR', NULL, 153, 'JL.RAYA BOGOR KM.40 NO.6B CILANGKAP', '0813 4560 3411', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(142, 'R.R.002', 'RIDHO', NULL, 'RIDHO  MOTOR', NULL, 153, 'JL.RAYA BOGOR KM.43 NO.160 CIBINONG', '0813 1951 9535', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(143, 'R.O.001', 'BP', NULL, 'OMEGA   MOTOR', NULL, 153, 'JL.RAYA PATRIOT KRANJI', '0896 4244 9676', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(144, 'R.R.003', 'HENDRIK RISKY', NULL, 'RISKY  MOTOR', NULL, 153, 'JL.RAYA CIBINONG - BOGOR KM 43 NO.158', '0813 1444 988', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(145, 'R.S.010', 'KO.ANDI', NULL, 'SAUDARA MOTOR  - DEPOK', NULL, 153, 'JL.ARIF RAHMAN HAKIM DEPOK', '0812 8818 1838', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(146, 'R.S.011', 'HERI', NULL, 'SURYA MANDIRI  MOTOR', NULL, 153, 'JL.IR.H.JUANDA NO.151', '0822 1012 4741', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(147, 'R.S.001', 'ADI WIJAYA', NULL, 'SINAR MUSTIKA WIJAYA  - CV', NULL, 153, 'JL.DIPONEGORO  KP.BARU NO.19C', '0813 1069 9989', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(148, 'R.C.006', 'ROBBY', NULL, 'CAHAYA MULTI - CIBITUNG', NULL, 153, 'JL.RAYA BOSIH CIBITUNG', '0821 4917 5291', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(149, 'R.M.012', 'BP', NULL, 'MERPATI SEJAHTERA', NULL, 153, 'JL.MANGUN JAYA I NO.37 TAMBUN', '0812 8906 2861', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(150, 'R.T.007', 'BP', NULL, 'TUNAS MITRA - KALIABANG', NULL, 153, 'JL.KALIABANG NO.18 BEKASI', '0813 1026 5040', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(151, 'R.C.007', 'CEPOT', NULL, 'CEPOT HUMORIS', NULL, 153, 'JL.WR SUPRATMAN RT.01/07  CIMUNING', '0895 0706 0539', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(152, 'R.J.007', 'YANGKI', NULL, 'JAYA MOTOR -BANTAR GEBANG', NULL, 153, 'JL MUSTIKA SARI NO.154 BANTAR GEBANG', '0812 9122 2948', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(153, 'R.M.013', 'BP', NULL, 'MULTI DENSO', NULL, 153, 'TAMAN HARAPAN BARU BLOK B1 NO.14A', '0812 8649 5762', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(154, 'R.M.014', 'ANA', NULL, 'MEGA MOTOR - HARAPAN  BARU', NULL, 153, 'TAMAN HARAPAN BARU JAYA BI/12', '0821 1079 1027', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(155, 'R.S.013', 'BP', NULL, 'SURYA MOTOR - KALI ABANG', NULL, 153, 'JL KALIABANG TENGAH NO.1 BEKASI UTARA', '0812 8168 8107', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(156, 'R.P.002', 'BP.', NULL, 'PERMATA MOTOR - KALI ABANG', NULL, 153, 'JL.KALI ABANG RAYA NO 8 BEKASI UTARA', '0812 8089 773', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(157, 'R.S.014', 'SAFRI', NULL, 'SURYA MOTOR - BEKASI', NULL, 153, 'JL NUSANTARA PERUMNAS III', '0813 1050 531', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(158, 'R.A.009', 'BP', NULL, 'AREN JAYA MOTOR - BEKASI', NULL, 153, 'JL NUSANTARA RAYA NO.16 BLOK BI PERUMNAS III', '0811 1335 460', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(159, 'R.S.015', 'DAVID STEVEN', NULL, 'SINAR HARAPAN MOTOR', NULL, 153, 'JL PAHLAWAN KAMPUNG CEREWET', '0878 7894 5858', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(160, 'R.L.004', 'BP', NULL, 'LAURENS MOTOR SERVICE - DUREN SAWIT', NULL, 153, 'JL PAHLAWAN REVOLUSI  NO.6A DUREN SAWIT', '0812 9675 5257', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(161, 'R.D.002', 'GIMIN', NULL, 'DUNIA SEPEDA MOTOR', NULL, 153, 'JL.RAYA PASAR MINGGU NO.1', '0812 1356 6040', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(162, 'R.N.003', 'BP', NULL, 'NEW ADC  (EX POLONIA)', NULL, 153, 'JL RAYA BOGOR DEPAN PUSDIKES', '0812 08287 117', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(163, 'R.A.011', 'BP', NULL, 'ANUGRAH JAYA MOTOR  - RADIO DALAM', NULL, 153, 'JL RAYA RADIO DALAM BLOK H4C', '0817 0072 886', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(164, 'R.K.005', 'BP', NULL, 'KARYA MANDIRI MOTOR', NULL, 153, 'JL KALIBARU TIMUR NO.32 RAWA BAMBU', '081290202985', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(165, 'R.E.002', 'DAVIT', NULL, 'EKA JAYA MOTOR - BEKASI', NULL, 153, 'BEKASI GRAND CENTER BLOK A CUT MUTIAH', '0817 8374 8766', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(166, 'R.R.004', 'DONI', NULL, 'RON RON MOTOR', NULL, 153, 'JL.BAMBU KUNING RAYA SEPANJANG JAYA', '0856 9733 787', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(167, 'R.C.008', 'AYONG', NULL, 'CHAMPION JAYA MOTOR', NULL, 153, 'JL TRI SATRIA NO.26 RAWA LUMBU', '0852 6102 2129', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(168, 'R.S.016', 'JONATHAN', NULL, 'SURYA JAYA  MOTOR - BEKASI', NULL, 153, 'JL,JUANDA NO.157 RUKO MITRA BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(169, 'R.G.003', 'BERNAD', NULL, 'GRESS  MOTOR', NULL, 153, 'JL MUSTIKA SARI NO.119 BEKASI', '0813 1082 2077', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(170, 'R.M.015', 'AGUS SETIAWAN', NULL, 'MITRA JAYA MOTOR  - BANTAR GEBANG', NULL, 153, 'JL MUSTIKA SARI NO.2 BANTAR GEBANG', '0812 9938 2688', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(171, 'R.C.009', 'NONI YULIANA', NULL, 'CINDY SERVICE STATION', NULL, 153, 'JL RAYA MUSTIKA SARI BEKASI', '0812 9938 2688', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(172, 'R.T.009', 'LEO', NULL, 'TUSIAS 2 MOTOR', NULL, 153, 'JL.PENGASINAN  (PERTIGAAN  PENGASINAN)', '0878 8168 2538', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(173, 'R.K.002', 'AHONG', NULL, 'KING MOTOR SPORT 2', NULL, 153, 'JL.PENGASINAN  RAYA NO.61D', '0812 1333 2906', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(174, 'R.U.002', 'BP', NULL, 'UTAMA JAYA SUKAMTO', NULL, 153, 'JL. JEND RS SUKAMTO NO.128', '0813 1076 8879', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(175, 'R.I.004', 'BP', NULL, 'INDONESIA INDAH MOTOR', NULL, 153, 'JL.BINTARA RAYA  NO.66', '0812 1941 8773', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(176, 'R.S.017', 'BP', NULL, 'SINAR TERANG', NULL, 153, 'JL.RAYA KALIMALANG NO 88 CAMAN', '021 8644251', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(177, 'R.N.004', 'HENDRY', NULL, 'NAGA MAS MOTOR', NULL, 153, 'JL KALI MALANG NO.88 BEKASI', '021 864 4228', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(178, 'R.K.006', 'BP', NULL, 'KRANGGAN JAYA  MOTOR', NULL, 153, 'RUKO PERMAI KRANGGAN BLOK I/10  NO.6', '0852 5268 0388', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(179, 'R.D.003', 'BP', NULL, 'DIRA  MOTOR', NULL, 153, 'JL RAYA HANKAM NO.21 PONDOK GEDE', '0812 1210 6242', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(180, 'R.B.004', 'BP', NULL, 'BOLA DUNIA MOTOR 2', NULL, 153, 'JL.RAYA HANKAM NO.12  SUMIR PONDOK GEDE', '0817 911 7569', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(181, 'R.P.003', 'BP', NULL, 'PRESIDEN MOTOR', NULL, 153, 'JL,RAYA ALTERNATIF CILENGSI NO.69', '021 8230289', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(182, 'R.M.016', 'BP', NULL, 'MARGANDA MOTOR', NULL, 153, 'JL RAYA NAROGONG KM.16,5', '0896 2434 2777', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(183, 'R.M.017', 'HARI', NULL, 'MANDIRI MOTOR - PEKAYON', NULL, 153, 'JL PEKAYON NO.3 BEKASI', '0812 1107 0791', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(184, 'R.A.012', 'YATI', NULL, 'AUTOMOTIVE TEKNIK BERLIAN  - CV', NULL, 153, 'JL.RAYA PEKAYON NO.1 BEKASI  SELATAN', '0856 7191 6583', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(185, 'R.T.010', 'TANTRI', NULL, 'TANTRI MOTOR', NULL, 153, 'JL.RAYA PEKAYON NO.7 BEKASI SELATAN', '0812 8359 2570', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(186, 'R.T.011', 'TESY', NULL, 'TUSIAS MOTOR', NULL, 153, 'JL NAROGONG PANGKALAN I', '0822 9988 9933', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(187, 'R.V.001', 'ELIZABETH', NULL, 'VANETH MOTOR', NULL, 153, 'JL PONDOK UNGU PERMAI SEKTOR V BLOK A 18 NO.7', '0811 1945 591', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(188, 'R.C.010', 'BP', NULL, 'CAHAYA MOTOR  3', NULL, 153, 'JL.SAPARUA RAYA RAWA KALONG PERUMNAS 3 BEKASI', '0812 1203 9922', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(189, 'R.J.009', 'ASSAN', NULL, 'JOINT  MOTOR', NULL, 153, 'JL. CUT MUTIAH NO.1 RAWA PANJANG', '0878 8375 0950', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(190, 'R.C.011', 'BUN', NULL, 'CAHAYA MOTOR  - BEKASI', NULL, 153, 'JL INSINYUR JUANDA NO.151', '0822 1041 4041', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(191, 'R.P.004', 'PIN KONG', NULL, 'PADA SUKA MOTOR  - BEKASI', NULL, 153, 'JL.MEKAR SARI NO.1', '0812 1116 0030', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(192, 'R.I.005', 'BP', NULL, 'ISTANA MOTOR CIKARANG', NULL, 153, 'JL RAYA INDUSTRI NO.52 TEGAL GEDE', '0813 1761 8189', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(193, 'R.S.018', 'WILLY', NULL, 'SINAR MAS - CIKARANG', NULL, 153, 'JL.KI HAJAR DEWANTARA NO.19 CIKARANG', '0817 9809 655', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(194, 'R.H.003', 'APU', NULL, 'HIDUP MOTOR', NULL, 153, 'JL RAYA KEJAYAAN NO.304 DEPOK TIMUR', '0815 7465 6593', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(195, 'R.B.006', 'BP', NULL, 'BARBAT JAYA MOTOR', NULL, 153, 'JL BAHAGIA RAYA DEPOK II', '0812 9894 5808', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(196, 'R.M.018', 'ANI', NULL, 'MAJU JAYA MOTOR - PONDOK RAJEG', NULL, 153, 'JL KAMPUNG SAWAH PONDOK RAJEG II', '0812 8844 2475', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(197, 'R.C.012', 'PAK HAJI', NULL, 'CERIA BERSAUDARA MOTOR', NULL, 153, 'JL RAYA BOGOR KM 39,5', '0818 936 312', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(198, 'R.S.019', 'UNI', NULL, 'STANZA MOBIL', NULL, 153, 'JL RAYA MAYOR OKING NO.158 RUKO AREMA CIBINONG (PLN)', '0813 1961 9618', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(199, 'R.R.005', 'RIDHO', NULL, 'RIDHO MOTOR', NULL, 153, 'JL RAYA BOBOR CIBINONG', '0813 1951 9535', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(200, 'R.B.007', 'TEH UTI', NULL, 'BAROKAH MOTOR - BOGOR', NULL, 153, 'JL RAYA KADUNG HALANG BOGOR', '0857 1573 3727', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(201, 'R.F.003', 'FAJAR', NULL, 'FAJAR MOTOR - DEPOK', NULL, 153, 'JL KEMAKMURAN RAYA NO.53 DEPOK II  TENGAH', '021 7713 165', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(202, 'R.U.003', 'BP', NULL, 'UTAMA MOTOR PENGGILINGAN', NULL, 153, 'JL PENGGILINGAN RAYA NO.2', '0812 8923 3331', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(203, 'R.P.005', 'BP', NULL, 'PRIMA JAYA MOTOR - CIBITUNG', NULL, 153, 'JL IMAM BONJOL NO.6 CIBITUNG', '0877 8114 4542', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:52', NULL, NULL, NULL),
(204, 'R.M.019', 'JUNAEDI', NULL, 'MITRA PERKAKAS', NULL, 153, 'JL RAYA BOSIH KAMPUNG SELANG TENGAH', '0812 1280 8056', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(205, 'R.S.020', 'BP', NULL, 'SURYA  MOTOR - SETU', NULL, 153, 'JL MT HARYONO  RUKO RAJAWALI NO.15 SETU', '0813 9328 8452', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(206, 'R.L.005', 'BP', NULL, 'LIE MOTOR ( MALAKA MOTOR)', NULL, 153, 'JL PONDOK KOPI RAYA BLOK A1 NO.2', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(207, 'R.D.005', 'BP', NULL, 'DUNIA  MOTOR -CIRACAS', NULL, 153, 'JL RAYA CIRACAS NO.8', '0813 8968 8359', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(208, 'R.K.007', 'APING', NULL, 'KENCANA   MOTOR', NULL, 153, 'JL RAYA PASAR CIPETE BLOK AKS NO.49', '021 722 1765', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(209, 'R.Y.002', 'BP', NULL, 'YONO KARBURATOR', NULL, 153, 'JL RAYA HANKAM', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(210, 'R.B.008', 'BP', NULL, 'BIMA OLI RAWAMANGUN', NULL, 153, 'JL.PEGAMBIRAN NO.9C RAWAMANGUN', '0812 9175 8895', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(211, 'R.S.021', 'JEFRI', NULL, 'SURYA  JAYA MOTOR - TEBET', NULL, 153, 'JL.SAHARJO NO.184 TEBET', '0812 1916 0722', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(212, 'R.B.009', 'YANTO', NULL, 'BERKAH JAYA MOTOR - DEPOK', NULL, 153, 'JL RAYA MAMPANG PRAMUKA', '0813 1593 1590', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(213, 'R.C.013', 'ANDI', NULL, 'CAHAYA MOTOR -CINANGKA', NULL, 153, 'JL RAYA CINANGKA NO.4 SAWANGAN', '0858 8222 0246', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(214, 'R.M.020', 'SIMPSON', NULL, 'MASKUN MOTOR DEPOK', NULL, 153, 'JL MUKTAR NO.15', '0813 8545 5709', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(215, 'R.G.004', 'SARAGIH', NULL, 'GIGIH JAYA  MOTOR', NULL, 153, 'JL.MUHTAR SAWANGAN', '0895 3330 55699', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(216, 'R.D.006', 'GITA', NULL, 'DEDE GITA MOTOR', NULL, 153, 'JL RAYA JONGGOL NO.30', '0812 1927 7788', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(217, 'R.M.021', 'BP', NULL, 'MELLY TOKO', NULL, 153, 'JL.RAYA SEROJA NO.28 RT.03/28', '0857 1700 6740', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(218, 'R.D.004', 'BP', NULL, 'DARMA  MOTOR', NULL, 153, 'JL TEUKU UMAR NO.9 RT.06/06', '0877 8114 4542', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(219, 'R.M.022', 'BP', NULL, 'MALAKA MOTOR', NULL, 153, 'JL PONDOK KOPI RAYA', '021 864 9466', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(220, 'R.C.014', 'BP', NULL, 'CHAMPION   MOTOR (SUKAMTO)', NULL, 153, 'JL.RAYA SUKAMTO NO.336 C', '0812 8626 878', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(221, 'R.J.010', 'ISMAIL', NULL, 'JAYA IMPIAN ABADI - PT', NULL, 153, 'CV. CITRA PERKASA', '0821 2276 5465', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(222, 'R.H.004', 'KO KLIFF', NULL, 'HANA  MOTOR', NULL, 153, 'JL PERJUANGAN  BEKASI', '0818 0777 0222', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(223, 'R.S.022', 'SUKRI', NULL, 'SAUDARA KARYA MOTOR', NULL, 153, 'JL RAYA NAROGONG KM 68', '0822 1117 2930', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(224, 'R.P.006', 'BP', NULL, 'PRIMA BAN', NULL, 153, 'JL.SULTAN AGUNG KM 28 NO 20', '0812 9934 3551', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(225, 'R.L.006', 'ASEP', NULL, 'LOGAM MOTOR', NULL, 153, 'JL RAYA KEBAYORAN LAMA NO.242 A', '0819 1122 9969', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(226, 'R.C.015', 'BP', NULL, 'CAHAYA ERLANGGA', NULL, 153, 'JL LAPANGAN TEMBAK  NO.20', '0817 9817 207', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(227, 'R.S.023', 'BP', NULL, 'SAUDARA MOTOR 3 CIBUBUR', NULL, 153, 'JL LAPANGAN TEMBAK NO.10', '0858 8038 1127', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(228, 'R.K.008', 'HANDI', NULL, 'KURNIA JAYA MOTOR', NULL, 153, 'JL RAYA KARTINI  NO.36', '021 777 5408', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL);
INSERT INTO `customers` (`id`, `store_code`, `name`, `email`, `store_name`, `cust_type`, `city_id`, `address`, `phone`, `phone_owner`, `phone_store`, `status`, `reg_point`, `payment_term`, `user_id`, `client_id`, `created_at`, `updated_at`, `pareto_id`, `lat`, `lng`) VALUES
(229, 'R.T.012', 'BP', NULL, 'TRIGUNA SEKAWAN MOTOR', NULL, 153, 'JL DERMAGA KAV.C NO 8', '0896  4324 8022', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(230, 'R.M.024', 'BP', NULL, 'MULTI BAN', NULL, 153, 'RUKO SYMPHONY BLOK HX', '0821 1240 1838', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(231, 'R.A.025', 'ABAY', NULL, 'ANUGRAH JAYA MOTOR - TAMBUN', NULL, 153, 'JL KH MAS\'UD', '0821 2506 7879', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(232, 'R.S.024', 'HERI', NULL, 'SULTAN MOTOR', NULL, 153, 'JL.IR JUANDA NO.151', '0812 1901 2672', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(233, 'R.S.025', 'BUDI SANTOSO', NULL, 'SURYA JAYA - DEPOK', NULL, 153, 'JL TOLE ISKANDAR DEPOK', '021 771 5365', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(234, 'R.S.026', 'BP', NULL, 'SINAR MOTOR - KRANGGAN', NULL, 153, 'RUKO KRANGGAN PERMAI', '0812 9052 7398', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(235, 'R.C.016', 'LINA', NULL, 'CAHAYA INDAH MOTOR', NULL, 153, 'JL RAYA TAMAN MARGASATWA NO.92B', '0821 1118 3985', NULL, NULL, 'ACTIVE', 'N', NULL, NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(236, 'R.K.009', 'JONATHAN LASMAN', NULL, 'KAWAN MOTOR', NULL, 153, 'JL.RAYA BOGOR  CIBINONG KM 41.4', '0877 7089 1252', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(237, 'R.G.006', 'HANJAYA', NULL, 'GIAN  MOTOR', NULL, 153, 'JL RAYA KERANGGAN NO.81 PUSPASARI', '0812 1888 0369', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(238, 'R.D.007', 'YANTO', NULL, 'DJAYA MOTOR', NULL, 153, 'JL TOLE ISKANDAR NO 6 DEPOK TIMUR', '0817 6510 811', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(239, 'R.H.005', 'BP', NULL, 'HRC PRIMA SEJAHTERA -  PT', NULL, 153, 'JL RAYA BEKASI TIMUR KM 17', '0813 8099 2949', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(240, 'R.W.004', 'BP', NULL, 'WINTA MOTOR', NULL, 153, 'JL AHMAD YANI NO.19-20', '0813 1144 5847', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:12', '2021-05-24 07:29:53', NULL, NULL, NULL),
(241, 'R.K.010', 'BP', NULL, 'KARYA JAYA - KRAMAT JATI', NULL, 153, 'JL RAYA BOGOR KM 22 NO.3', '021 840 1957', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(242, 'R.J.011', 'NELSEN', NULL, 'JAYA SUTRA OTO PARTS', NULL, 153, 'JL RAYA CIBARUSAH LIPPO CIKARANG', '0821 1212 0535', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(243, 'R.S.028', 'HJ TITO', NULL, 'SUMBER BERKAH', NULL, 153, 'JL PERUMAHAN GRAHA CIANTRA INDAH', '0813 2473 5858', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(244, 'R.C.017', 'BP', NULL, 'CIBARUSAH BAN', NULL, 153, 'JL RAYA SERANG CIBARUSAH KM 11', '0858 1050 3139', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(245, 'R.S.029', 'ASMA', NULL, 'SARJANA SPARE PART', NULL, 153, 'JL SILIWANGI NO.1 BEKASI', '0811 1977 795', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(246, 'R.S.030', 'BP', NULL, 'SAFIRA MOTOR', NULL, 153, 'RUKO COMPARK BLOK D KOTA WISATA', '0812 9270 2023', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(247, 'R.F.004', 'SIAHOLOHO', NULL, 'FRIEND\'S OIL MOTOR', NULL, 153, 'JL JANGKI NO.14 HALIM', '0813 1723 9940', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(248, 'R.J.012', 'RUSLAN', NULL, 'JAYA MOTOR - KALIMALANG', NULL, 153, 'JL KALIMALANG NO.1', '0812 8297 130', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(249, 'R.O.002', 'HAJI BAMBANG', NULL, 'OLIMART', NULL, 153, 'PERUMAHAN TAMAN GALAXY', '0856 1070 176', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(250, 'R.S.031', 'BP', NULL, 'SURYA KENCANA', NULL, 153, 'JL.WR SUPRATMAN MUSTIKA JAYA', '0821 1026 5564', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(251, 'R.B.011', 'BP', NULL, 'BINTANG MAS', NULL, 153, 'JL FATAHILAH (SEBELAH HIBA MOTOR)', '0812 9911 6383', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(252, 'R.C.018', 'BP', NULL, 'CAHAYA MOTOR - PINANG RANTI', NULL, 153, 'JL RAYA PONDOK GEDE', '0813 8046 1220', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(253, 'R.C.019', 'BP', NULL, 'CHAMPION  - RAYA BOGOR', NULL, 153, 'JL RAYA BOGOR NO.19', '0821 2258 9474', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(254, 'R.G.007', 'BP', NULL, 'GEMBIRA JAYA MOTOR', NULL, 153, 'JL RAYA BOGOR NO.22', '021 8088 0460', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(255, 'R.F.005', 'BP', NULL, 'F 8 MOTOR', NULL, 153, 'JL KAHFI 2 JAGAKARSA', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(256, 'R.B.012', 'ADRIAL', NULL, 'BERKAT ILAHI MOTOR', NULL, 153, 'JL BAKTI AURI DEPOK', '0815 7456 7107', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(257, 'R.G.008', 'PAK JUN', NULL, 'GEMILANG JAYA MOTOR', NULL, 153, 'JL PROKLAMASI DEPOK TIMUR', '0858 1791 5462', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(258, 'R.I.006', 'GLORI', NULL, 'ISTANA MOTOR  - DEPOK', NULL, 153, 'JL PROKLAMASI NO.1 BLOK E', '0822 2038 4434', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(259, 'R.M.025', 'MITHA', NULL, 'MITHA MOTOR', NULL, 153, 'JL RAYA CITAYAM BOJONG GADA', '0852 1130 0190', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(260, 'R.P.007', 'RIANTO', NULL, 'PAL JAYA MOTOR', NULL, 153, 'JL RAYA BOGOR KM.30', '0852 1130 0190', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(261, 'R.S.032', 'LINA', NULL, 'SINAR ABADI MOTOR - CILANGKAP', NULL, 153, 'JL RAYA BOGOR CILANGKAP', '0821 2402 9994', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(262, 'R.S.033', 'SANDI', NULL, 'SAHABAT MOTOR -  CIBINONG', NULL, 153, 'JL RAYA BOGOR KM.46 CIBINONG', '0821 2405 5008', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(263, 'R.P.008', 'YADI', NULL, 'POINT MOTOR', NULL, 153, 'JL RAYA BOGOR CILUAR KM.51.8', '0813 8791 1788', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(264, 'R.S.034', 'EDDY', NULL, 'SINAR VARIASI MOTOR', NULL, 153, 'JL RAYA BOGOR KM 52 CILUAR', '0813 1917 3300', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(265, 'R.C.020', 'ADI', NULL, 'CENTRAL MOTOR', NULL, 153, 'JL RAYA BOGOR KM 51 CILUAR', '0813 8199 0190', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(266, 'R.S.035', 'SOID', NULL, 'SOID MOTOR', NULL, 153, 'JL PANGERAN ANTASARI', '0858 1317 7895', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(267, 'R.D.009', 'BP', NULL, 'DUNIA MOTOR - PASAR MINGGU', NULL, 153, 'JL RAYA PS MINGGU', '0856 9080 836', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(268, 'R.K.011', 'KO AWANG', NULL, 'KHARISMA MOTOR', NULL, 153, 'JL DR SAHARJO NO.73', '0815 8813 294', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(269, 'R.M.026', 'BP', NULL, 'MATAHARI MOTOR - TENDEAN', NULL, 153, 'JL RAYA TENDEAN', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(270, 'R.G.009', NULL, NULL, 'PT. GENESIS SURYA MOTOR', NULL, 153, 'TAMAN HARAPAN BARU BLOK B1 NO.19', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(271, 'R.V.002', 'HERMANTO', NULL, 'PT.VISTHA SARANA UTAMA', NULL, 153, 'JL.JEND SUDIRMAN KM.32 NO.28', '0815 8284 204', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(272, 'R.H.006', 'HENDRI H', NULL, 'HENDRI HERDIANTO', NULL, 153, 'PERUM PRATAMA  INDAH BLOK L NO.15', '0812 9811 0290', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(273, 'R.M.027', 'STEVEN', NULL, 'MAKMUR JAYA MOTOR - BEKASI', NULL, 153, 'JL.IR JUANDA NO.157', '0838 7381 1415', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(274, 'R.K.012', 'MARINI', NULL, 'KING JAYA MOTOR', NULL, 153, 'JL.PROF M YAMIN NO.46', '0812 8400 935', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(275, 'R.S.036', 'BP', NULL, 'SINAR ABADI MOTOR - PONDOK TIMUR', NULL, 153, 'JL.RAYA PENGASINAN PONDOK TIMUR', '0813 1680 1670', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(276, 'R.M.028', 'A.PRAYITNO', NULL, 'MAJU JAYA', NULL, 153, 'JL RAYA PADURENAN KELAPA DUA', '0813 0365 5223', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(277, 'R.M.029', 'AKHIN', NULL, 'MATAHARI MOTOR - CIBINONG', NULL, 153, 'JL MAYOR OKING NO.128', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(278, 'R.B.014', 'SANDI', NULL, 'BERLIAN  MOTOR', NULL, 153, 'JL RAYA ABDUL GANI CILODONG', '0813 8111 6118', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(279, 'R.C.021', 'ASEN', NULL, 'CAHAYA MOTOR - DEPOK TIMUR', NULL, 153, 'JL KH YUSUF DEPOK TIMUR', '0852 1651 0238', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(280, 'R.S.038', 'KHODRUN', NULL, 'SIAGA BERKAH MOTOR (S B M)', NULL, 153, 'JL AKSES UI NO.44 DEPOK', '0813 8558 5228', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(281, 'R.J.013', 'RUDIANTO', NULL, 'JAWA MOTOR - DEPOK', NULL, 153, 'STUDIO ALAM DEPOK', '0815 9844 894', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(282, 'R.R.006', 'ANTO', NULL, 'REZKI BANGKIT MOTOR', NULL, 153, 'JL RAYA BOGOR KM.37.5', '0856 9708 9679', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(283, 'R.D.010', 'DANANTO', NULL, 'DANA MOTOR', NULL, 153, 'JL RAYA CILODONG DEPOK', '0896 8685 6849', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(284, 'R.M.032', 'ADIN', NULL, 'MAJU JAYA MOTOR 2', NULL, 153, 'JL PALMERAH BARAT NO.12', '0813 1061 3688', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(285, 'R.I.007', 'ABDUL SOMAD', NULL, 'PT IDOLA CAHAYA SEMESTA', NULL, 153, 'JL RAYA PASARKEMIS KM.7', '021 296 808 38 /39/40', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(286, 'R.M.030', 'BP', NULL, 'MOTORLAND', NULL, 153, 'CHAMPION PENGGILINGAN', '0878 8802 2742', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(287, 'R.M.031', 'BP', NULL, 'MANSALAY', NULL, 153, 'JL RAYA CIBUCIL JONGGOL', '0812 6621 963', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(288, 'R.S.037', 'AMING', NULL, 'SUJABAR MOTOR', NULL, 153, 'JL ARIEF RAHMAN HAKIM', '0813 1037 4158', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(289, 'R.R.007', 'BP', NULL, 'ROMA MOTOR', NULL, 153, 'JL RAYA HANKAM NO.68', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(290, 'R.S.039', 'BP', NULL, 'SUMBER MOTOR', NULL, 153, 'JL RAYA HANKAM NO.63', '0813 1886 5265', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(291, 'R.S.040', 'BP', NULL, 'SERBA MOTOR', NULL, 153, 'JL RAYA HANKAM JATI SAMPURNA', '0821 02377 9673', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(292, 'R.S.041', 'BP', NULL, 'SINAR MOTOR - RAWAMANGUN', NULL, 153, 'JL TENGGIRI NO.1C', '0813 1032 3998', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(293, 'R.M.033', 'MEI MEI', NULL, 'MAESTRO DINAMIC', NULL, 153, 'PS CIPETE BLOK C/8 FATMAWATI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(294, 'R.F.008', 'SYARIF', NULL, 'FAJAR BARU MOTOR', NULL, 153, 'PS CIPETE BLOCK  B/2 FATMAWATI', '0812 8112 813', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(295, 'R.C.022', NULL, NULL, 'CAHAYA PASAR MINGGU', NULL, 153, 'JL RAYA PASAR MINGGU', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(296, 'R.J.014', 'JOY', NULL, 'JOY SPARE PARTS', NULL, 153, 'JL CASA BLANCA NO.1A', '0812 9337 5140', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(297, 'R.B.015', 'IBU HAJI', NULL, 'BERKAH JAYA MOTOR - KEBAYORAN', NULL, 153, 'JL RAYA CIDODOL KEBAYORAN LAMA', '0819 3232 7458', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(298, 'R.E.003', 'YANSIH', NULL, 'EFFENDI MOTOR', NULL, 153, 'JL RAYA LENTENG  AGUNG', '0813 8871 5329', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(299, 'R.M.034', 'BP', NULL, 'MULTI TEHNIK ANUGRAH - PT', NULL, 153, 'JL NAROGONG NO.180', '021 8743 2157', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(300, 'R.S.042', 'BP', NULL, 'SUMBER JAYA MOBIL', NULL, 153, 'JL RAYA INDUSRI CIKARANG BARAT', '0812 8223 398', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(301, 'R.A.036', 'BP', NULL, 'ASIA MOTOR -  TAMBUN', NULL, 153, 'JL RAYA MEKAR SARI TAMBUN', '0813 9852 8752', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(302, 'R.R.008', 'BP', NULL, 'REGENCY MOTOR', NULL, 153, 'JL RAYA PADURENAN DEKET ZAMRUD', '0812 8300 7779', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(303, 'R.S.043', 'DENNIS', NULL, 'SAMPLAK JAYA MOTOR', NULL, 153, 'JL RAYA SAMPLAK', '0812 1215 2643', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(304, 'R.B.016', 'LANI', NULL, 'BINTANG MOTOR - DEPOK', NULL, 153, 'JL ARIF RAHMAN HAKIM', '0816 1407 568', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(305, 'R.S.044', 'YONATHAN', NULL, 'SURYA MOTOR - DEPOK', NULL, 153, 'JL RADAR AURI DEPOK', '0853 3608 8988', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(306, 'R.I.008', 'DANIEL', NULL, 'ISTANA MOTOR  - PONDOK GEDE', NULL, 153, 'JL PONDOK GEDE NO 25', '0812 8774 7888', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(307, 'R.S.045', 'A PIN', NULL, 'SAHABAT MOTOR - SAHARJO', NULL, 153, 'JL DR. SAHARJO', '0815 8658 7024', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(308, 'R.T.013', 'BP', NULL, 'TARUNA MOTOR - PONDOK GEDE', NULL, 153, 'JL RAYA PONDOK GEDE  NO.11', '0812 8728 0559', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(309, 'R.G.010', 'ADRIAN', NULL, 'GEMILANG  MOTOR - DEPOK', NULL, 153, 'JL RAYA CINERE LIMO DEPOK', '021 753 7066', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(310, 'R.R.009', 'BP', NULL, 'ROSA RINA', NULL, 153, 'JL RAYA HANKAM NO.1D', '0859 7271 4614', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(311, 'R.W.005', 'BP', NULL, 'TOKO WIJAYA  - OTISTA', NULL, 153, 'JL RAYA OTISTA NO.57B', '021 8591 2173', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(312, 'R.S.047', 'FIMIN', NULL, 'SEN MOTOR - DEPOK', NULL, 153, 'JL KARTINI  DEPOK', '0812 9041 6718', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(313, 'R.G.011', 'FAHMI', NULL, 'GANGSAL PANDAWA', NULL, 153, 'JL BANGKA IX MAMPANG', '0856 5505 4993', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(314, 'R.P.009', 'BP', NULL, 'PADA SUKA  MOTOR - JONGGOL', NULL, 153, 'JL RAYA JONGGOL RAWALUTUNG', '0813 8170 9933', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(315, 'R.L.007', 'HAIDIR', NULL, 'LAND MOTOR', NULL, 153, 'JL JATI ASIH  BEKASI', '0852 1344 1771', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(316, 'R.B.017', 'HERMAN', NULL, 'BERKAT BARU MOTOR', NULL, 153, 'JL RAYA SAWANGAN NO.6', '0812 8434 6890', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(317, 'R.S.048', 'CI SUMI', NULL, 'TOKO SEPEDA AMIN', NULL, 153, 'JL PANCORAN BARAT VII NO.50', '0897 4351 026', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(318, 'R.B.018', 'EDI', NULL, 'BERKAH RISKY MOTOR', NULL, 153, 'JL TEGAL PARANG SELATAN 1', '0856 9263 5102', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(319, 'R.P.010', 'HARDI', NULL, 'POLARIS  MOTOR', NULL, 153, 'JL RAYA CIPAYUNG NO.2 RT.04/05', '0812 8727 478', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(320, 'R.C.023', 'PURBA', NULL, 'CAHAYA MOTOR - JAGAKARSA', NULL, 153, 'JL RAYA SRENGSENG SAWAH', '0813 1668 0173', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(321, 'R.G.012', 'RUDY', NULL, 'GEMILANG MOTOR - JATI MAKMUR', NULL, 153, 'JL JATI MAKMUR BEKASI', '021 8477767/0821 1133 1117', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(322, 'R.K.013', 'ASAN', NULL, 'KING MOTOR SPORT I', NULL, 153, 'JL JATI MULYA BEKASI', '0812 8979 3833', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(323, 'R.S.050', 'BP', NULL, 'SAMUDRA TEHNIK', NULL, 153, 'JL RAYA BOGOR KM.25 CIRACAS', '0812 8058 1678', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(324, 'R.S.051', 'AJI', NULL, 'SUMBER REZEKI MOTOR', NULL, 153, 'JL RAYA GAS ALAM NO.35 DEPOK', '0858 1945 5283', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(325, 'R.L.008', 'LINA', NULL, 'LINA  MOBIL', NULL, 153, 'JL RAYA PEKAPURAN NO.9', '021 8774 4672', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(326, 'R.B.019', 'LAMIDI', NULL, 'BAROKAH MOTOR - LEBAK BULUS', NULL, 153, 'JL LEBAK BULUS 3', '0877 8051 1629', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(327, 'R.M.035', 'ANTO', NULL, 'MUARA MOTOR', NULL, 153, 'JL KARANG TENGAH LEBAK BULUS', '0852 8290 9029', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(328, 'R.S.052', 'BP', NULL, 'SPLENDID', NULL, 153, 'JL ALU ALU NO.7 JATI', '021 489 4026', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(329, 'R.S.053', 'PURBA', NULL, 'SINAR BAUT MOTOR', NULL, 153, 'JL RAYA CI RENDEU', '0813 8011 1142', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(330, 'R.M.008', 'WIDODO', NULL, 'MULYO ABADI MOTOR', NULL, 153, 'JL.RA KARTINI NO.9 BEKASI TIMUR', '0851 0571 2526', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(331, 'R.T.014', 'ANJIT', NULL, 'TERUS JAYA MOTOR', NULL, 153, 'JL CIMANUK RAYA I', '0857 7040 4849', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(332, 'R.R.010', 'RANJES', NULL, 'RANJES MOTOR', NULL, 153, 'JL SURYA KENCANA PAMULANG', '0813 1700 6880', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(333, 'R.R.011', 'ARIF', NULL, 'RUDI JAYA MOTOR', NULL, 153, 'JL DEWI SARTIKA CIPUTAT', '0821 1243 7715', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(334, 'R.I.009', 'IREN', NULL, 'IREN MOTOR', NULL, 153, 'JL RAYA KALIMULYA NO.44 DEPOK', '0813 8195 7846', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(335, 'R.V.003', 'BP', NULL, 'VONG JAYA MOTOR', NULL, 153, 'JL RAYA MUSTIKA JAYA', '0852 1899 1818', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(336, 'R.M.036', 'BP', NULL, 'M S N TOKO', NULL, 153, 'JL MESJID ABIDIN NO.29', '0878 2551 0595', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(337, 'R.G.013', 'MARYWATI', NULL, 'GAYA MOTOR - BOGOR', NULL, 153, 'JL RAYA CIOMAS NO.6', '0813 9474 4093', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(338, 'R.R.012', 'JUCIUS', NULL, 'RAYA MAKMUR MOTOR', NULL, 153, 'JL RAYA VETERAN NO.10', '08960 2973 8960', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(339, 'R.L.009', 'BP', NULL, 'LANCAR MOTOR - CIKARANG', NULL, 153, 'JL INDUSTRI JABABEKA TEGALGEDE', '0819 3290 0260', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(340, 'R.P.011', 'UCI', NULL, 'PUTRA  MOTOR  -  DEPOK', NULL, 153, 'JL KAPITAN NO.21 GAS ALAM', '0896 5229 9804', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(341, 'R.I.010', 'ANA', NULL, 'IWAN MOTOR', NULL, 153, 'JL MENTENG ATAS SETIABUDI', '0812 8422 2444', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(342, 'R.K.014', 'BP', NULL, 'KAWASAKI  - PULOGEBANG', NULL, 153, 'JL PULO GEBANG RT.17/RW 13', '0858 8814 2225', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(343, 'R.C.024', 'BP', NULL, 'CHANDRA MOTOR - UTAN KAYU', NULL, 153, 'JL UTAN KAYU RAYA NO.88', '0895 3320 60779', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(344, 'R.M.037', 'KO ALING', NULL, 'MUTIARA  - KO ALING', NULL, 153, 'JL OTISTA RAYA NO.95', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(345, 'R.C.025', 'CITRARIANI', NULL, 'CITRA MANDIRI', NULL, 153, 'JL RAYA KRANGGAN CITEUREP', '0812 1823 0818', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(346, 'R.S.054', 'ANJAS', NULL, 'STANDAR MOTOR', NULL, 153, 'JL KELAPA IJO JAGAKARSA', '0813 1049 3615', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(347, 'R.S.055', 'ONGKY', NULL, 'S S K - BEKASI', NULL, 153, 'JL PEKAYON NO.132 BEKASI', '0857 7070 3553', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(348, 'R.P.012', 'BP', NULL, 'PIT LINE', NULL, 153, 'JL KOLONEL SUGIONO NO.7', '0852 1903 8334', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(349, 'R.S.056', 'INGGI', NULL, 'SETIA KAWAN DUA MOTOR', NULL, 153, 'JL RAYA MERCEDES BENZ', '0877 7090 9125', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(350, 'R.S.057', 'RANNI', NULL, 'SINAR ABADI MOTOR -  CILENGSI', NULL, 153, 'JL ALTERNATIF NO.36', '021 8249 6870', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(351, 'R.C.026', 'BP', NULL, 'CIPTA PRIMA', NULL, 153, 'JL RAYA BOSIH CIBITUNG', '0821 1252 6055', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(352, 'R.S.058', 'RULLY', NULL, 'SINAR JAYA MOTOR - DEPOK', NULL, 153, 'JL RAYA PEKAPURAN', '0858 6637 7176', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(353, 'R.S.059', 'BP', NULL, 'SEJAHTERA MOTOR -  CIPUTAT', NULL, 153, 'JL H.MUCHTAR CIPUTAT', '0882 9212 9552', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(354, 'R.R.013', 'KOWO', NULL, 'RAFFI MOTOR', NULL, 153, 'JL DAMAI CIPETE', '0821 1117 1360', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(355, 'R.B.020', 'RANTIE', NULL, 'BERKAH JAYA MOTOR - CILANGKAP', NULL, 153, 'JL RAYA BOGOR CILANGKAP', '0838 1980 3689', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(356, 'R.B.021', 'LUCY', NULL, 'BERKAT JAYA MOTOR - DEPOK', NULL, 153, 'JL.RAYA KEBAHAGIAN DEPOK', '0812 9894 5808', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(357, 'R.M.038', 'HENDRA', NULL, 'MAJU MOTOR - CILANDAK', NULL, 153, 'JL CILANDAK KKO', '0857 1767 1291', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(358, 'R.B.022', 'DILLER', NULL, 'BIMA SAKTI  MOTOR', NULL, 153, 'JL BATU AMPAR 3 CONDET', '0812 8695 9543', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(359, 'R.S.060', 'BP', NULL, 'SUMBER REZEKI - CONDET', NULL, 153, 'JL BATU AMPAR I CONDET', '021 800 2762', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(360, 'R.S.061', 'BP', NULL, 'SINAR MULTI', NULL, 153, 'JL RAYA SETU PASIR ANGIN', '0852 8966 4007', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(361, 'R.T.015', 'BP', NULL, 'TUNAS BARU - BEKASI', NULL, 153, 'JL RAYA PADURENAN', '0877 8829 1168', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(362, 'R.V.004', 'FAIRUL', NULL, 'VETRA MOTOR', NULL, 153, 'JL LEBAK BULUS I FATMAWATI', '0813 9993 9860', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(363, 'R.U.004', 'SUJANA', NULL, 'UTAMA MOTOR - LIMO DEPOK', NULL, 153, 'JL MARUYUNG RAYA LIMO DEPOK', '0896 9454 5592', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(364, 'R.B.023', 'BERLIANA', NULL, 'BERLIAN MOTOR 2', NULL, 153, 'JL RAYA TAPOS NO.73 RT.01/06', '0812 1953 6547', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(365, 'R.S.062', 'MULYO', NULL, 'SUN SUN MOTOR', NULL, 153, 'JL CUT MUTIAH NO.5', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(366, 'R.N.005', 'JONSON SINAGA', NULL, 'NAGA MAKMUR', NULL, 153, 'JL RAYA SAWANGAN DEPOK', '0812 1032 3742', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(367, 'R.B.024', 'UPIN', NULL, 'BAGINDA MOTOR', NULL, 153, 'JL RAYA FATMAWATI  PS CIPETE', '0812 9615 1188', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(368, 'R.M.039', 'BP', NULL, 'MAKMUR JAYA - CIKARANG', NULL, 153, 'JL YOS SUDARSO CIKARANG', '0812 9318 2567', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(369, 'R.C.027', 'RESTU ANDRI', NULL, 'CAHAYA RESTU MOTOR', NULL, 153, 'JL RAYA BOGOR PEMDA CIBINONG', '0818 0690 5858', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(370, 'R.J.015', 'MARNO', NULL, 'JAVA MOTOR SPORT', NULL, 153, 'JL.KAHFI I CIPEDAK JAGAKARSA', '0877 7635 5567', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(371, 'R.S.063', 'AGUS', NULL, 'SATRIA MOTOR RAJIMAN', NULL, 153, 'JL RAJIMAN RT.13/04', '0812 9822 2219', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(372, 'R.S.064', 'JOHAN', NULL, 'SETIA JAYA MOTOR - JAGAKARSA', NULL, 153, 'JL KAHFI JAGAKARSA', '0895 3162 0804', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(373, 'R.M.040', 'BP', NULL, 'MITRA MOTOR - BEKASI', NULL, 153, 'JL IR JUANDA NO.151', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(374, 'R.M.041', 'BP', NULL, 'MULTI JAYA 2', NULL, 153, 'JL RAYA SETU RAWA BANTING', '0812 85553 5735', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(375, 'R.T.016', 'BP', NULL, 'TORANG MOTOR', NULL, 153, 'JL RAWAMANGUN  SELATAN NO 5 - 6', '0813 1863 3357', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(376, 'R.K.015', 'BP', NULL, 'KENCANA MOTOR', NULL, 153, 'JL RAYA CILEDUG - CIPULIR', '021 7243 101', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(377, 'R.B.025', 'BEJO', NULL, 'BEJO MOTOR', NULL, 153, 'JL RAYA GANDUL DEPOK', '0812 1945 2490', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(378, 'R.B.026', 'H.SARMAN', NULL, 'BAROKAH MOTOR II', NULL, 153, 'JL RAYA SENTUL BABAKAN MADANG', '0812 8116 4749', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(379, 'R.B.027', 'BP', NULL, 'BINTANG JAYA VARIASI', NULL, 153, 'JL SULTAN HASANUDIN', '0878 0909 0983', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(380, 'R.F.009', 'BP', NULL, 'FAJAR ABADI I', NULL, 153, 'JL INDUSTRI CIKARANG', '0817 666 1615', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(381, 'R.C.028', NULL, NULL, 'CHANDRA - GATSU CIKARANG', NULL, 153, 'JL GATOT SUBROTO CIKARANG', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(382, 'R.G.014', 'GANDA ', NULL, 'GANDA MOTOR', NULL, 153, 'JL.RAYA AMPERA , CILANDAK', '0812 2226 3633', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(383, 'R.L.010', 'ALEX', NULL, 'LUCKY JAYA MOTOR', NULL, 153, 'JL.KEMANG SWATAMA STUDIO ALAM', '0813 8421 779', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(384, 'R.C.029', NULL, NULL, 'CIBUBUR BERKAT MOTOR', NULL, 153, 'JL ALTERNATIF CIBUBUR', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(385, 'R.S.065', 'BP', NULL, 'SAMUDRA SPARE PART', NULL, 153, 'JL KALISARI RAYA RT.02/03', '0878 8717 8880', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(386, 'R.W.006', 'BP', NULL, 'WARINO MOTOR', NULL, 153, 'JL PERUMAHAN PONDOK UNGU PERMAI', '0878 8853 8230', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(387, 'R.K.016', 'BP', NULL, 'KARUNIA MOTOR - CIBARUSAH', NULL, 153, 'JL RAYA CIBARUSAH', '0812 9318 363', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(388, 'R.U.005', 'ARIF', NULL, 'U P S MOTOR', NULL, 153, 'JL PENGASINAN RAYA NO.19', '0878 7768 7792', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(389, 'R.S.066', 'NUR', NULL, 'SUKSES MANDIRI', NULL, 153, 'JL RAYA FATMAWATI PASAR CIPETE', '0857 1598 4227', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(390, 'R.E.004', 'H.EDDY', NULL, 'EDDI MOTOR', NULL, 153, 'JL RAYA GAS ALAM , PORTAL KARET', '0895 3310 13789', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(391, 'R.S.067', NULL, NULL, 'STAR JAYA MOTOR', NULL, 153, 'JL RAYA PENGGILINGAN NO.56', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(392, 'R.C.030', 'BP', NULL, 'CAHAYA ERLANGGA RADAR AURI', NULL, 153, 'JL RADAR AURI NO.76 DEPOK', '0812 9327 3159', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(393, 'R.R.014', 'TONI', NULL, 'RIAN MOTOR', NULL, 153, 'JL.KAHFI 1 CIGANJUR', '0857 7778 7693', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(394, 'R.A.050', 'BP', NULL, 'ARIE PUTRA MOTOR ( A P M)', NULL, 153, 'JL RAYA MEKARSARI TAMBUN', '0812 3311 223', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(395, 'R.D.012', 'YANTO', NULL, 'DUNIA MOTOR', NULL, 153, 'JL MAYOR OKING CIBINONG', '0877 8116 6756', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(396, 'R.B.028', 'KIRUN', NULL, 'BEJO KIRUN MOTOR', NULL, 153, 'JL KAYU MANIS CONDET', '0813 1112 2701', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(397, 'R.S.068', 'BP', NULL, 'SUMBER HIDUP MOTOR', NULL, 153, 'JL KALIMALANG RAYA NO.42', '021 8600 943', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(398, 'R.P.013', 'TOTO', NULL, 'PRANOWO MOTOR', NULL, 153, 'JL ASTER BLOK M NO.10', '021 8273 4221', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(399, 'R.S.069', 'DION', NULL, 'SUBUR MOTOR', NULL, 153, 'JL RAYA SUDIRMAN', '0817 6577 479', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(400, 'R.B.029', 'HADI', NULL, 'BOROBUDUR MOTOR', NULL, 153, 'JL RAYA BOGOR KM 55 NO.223', '0818 0702 5850', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(401, 'R.B.030', 'SRI', NULL, 'BERKAH JAYA MOTOR - KEBON BARU', NULL, 153, 'JL. RAYA ASEM BARIS KEBON BARU', '0821 1330 7468', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(402, 'R.V.005', 'VALENTINO', NULL, 'VALEN MOTOR', NULL, 153, 'JL RAYA BOGOR CIBINONG', '0852 8966 3888', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(403, 'R.S.071', 'BP', NULL, 'SILIWANGI SAKTI MOTOR', NULL, 153, 'JL PERUMAHAN NAROGONG INDAH A19 NO.10', '0856 9145 1779', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(404, 'R.M.042', 'BP', NULL, 'MAKMUR JAYA', NULL, 153, 'JL.RAYA RAJIMAN', '021 460 327', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(405, 'R.S.072', 'SURATMIN', NULL, 'SAERAH MOTOR', NULL, 153, 'JL.RAYA RADIO DALAM', '0812 8073 194', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(406, 'R.M.043', 'BP', NULL, 'MALAKA HONDA MOTOR', NULL, 153, 'JL.PONDOK KOPI RAYA', '0813 1628 5506', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(407, 'R.S.073', 'Meyland ', NULL, 'SINAR AGUNG MOTOR', NULL, 153, 'JL.RAYA CITAYAM', '0878 0962 1788', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(408, 'R.C.031', 'BP', NULL, 'CEPAT TEPAT MOTOR', NULL, 153, 'KOMPLEK AUTOMOTIVE EX HIBITION CENTER', '0821 2368 3945', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(409, 'R.R.017', 'BP', NULL, 'RICKY MOTOR', NULL, 153, 'JL MAYOR OKING CIBINONG', '0817 6063 778', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(410, 'R.P.014', 'ULUM', NULL, 'PERAPATAN MOTOR', NULL, 153, 'JL BATU AMPAR 2 CONDET', '0838 0716 6136', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(411, 'R.S.076', 'BP', NULL, 'SERVICE POINT', NULL, 153, 'JL JATI MEKAR BEKASI', '0878 8432 3768', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(412, 'R.B.032', 'SRI', NULL, 'BERKAH JAYA MOTOR - JAGAKARSA', NULL, 153, 'JL KAHFI 2 JAGAKARSA', '0896 3673 7568', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(413, 'R.S.077', 'BP', NULL, 'SAUDARA MOTOR - PS MINGGU', NULL, 153, 'JL RAYA PASAR MINGGU', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(414, 'R.S.078', 'AMRIZAL', NULL, 'STANDAR OTO MOTOR', NULL, 153, 'JL.JAGA KARSA RAYA', '0812 9877 1672', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(415, 'R.R.018', 'BP', NULL, 'RAHMAT ANDRIYANTO - TOKO', NULL, 153, 'KOMPLEK PEMDA DKI BLOK B 13/4', '0815 9804 805', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(416, 'R.S.079', 'BP', NULL, 'SPORTISI RAWAMANGUN', NULL, 153, 'JL TENGGIRI NO.4A RAWAMANGUN', '0821 1404 6688', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(417, 'R.C.032', 'BP', NULL, 'CAHAYA ABADI', NULL, 153, 'JL TARUNA NO.7 RW.03', '0812 8225 2235', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:53', NULL, NULL, NULL),
(418, 'R.L.011', 'BP', NULL, 'LISA  MOTOR', NULL, 153, 'JL RAYA JONGGOL CIBUCIL SUKAMA', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(419, 'R.B.033', 'BP', NULL, 'BONDAN MOTOR', NULL, 153, 'JL RAYA BABELAN', '0856 9598 4863', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(420, 'R.L.012', 'KO HERMAN', NULL, 'LANCAR  MOTOR', NULL, 153, 'JL BARKAH BUKIT DURI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(421, 'R.B.034', 'BURHAN', NULL, 'BMT', NULL, 153, 'SUNRISE GARDEN BUKIT PUTRA BLOK A2 NO.8', '085290789999', NULL, NULL, 'ACTIVE', 'N', '30 Days', 5, 1, '2021-05-24 06:46:13', '2021-10-14 10:19:29', 4, '-6.427606734423185', '107.03773475144216'),
(422, 'R.M.046', 'RANDI', NULL, 'MAJU MOTOR -  CILENGSI', NULL, 153, 'JL RAYA CILENGSI', '0812 9503 4224', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(423, 'R.I.011', 'LINA', NULL, 'INDAH JAYA MOTOR', NULL, 153, 'JL MARGASATWA RAGUNAN', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(424, 'R.C.033', NULL, NULL, 'CAHAYA INDAH MOTOR', NULL, 153, 'JL MARGAWATWA RAGUNAN', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(425, 'R.T.020', 'BP', NULL, 'TIMUR JAYA', NULL, 153, 'JL RAYA BOGOR NO.2', '021 8011461', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(426, 'R.P.015', 'BP', NULL, 'PRIMA MOTOR', NULL, 153, 'JL KEMANG RAYA JATI MAKMUR', '0812 8219 0678', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(427, 'R.M.047', 'MEGA', NULL, 'MEGAH MOTOR', NULL, 153, 'JL.RAYA WARUNG JATI BARAT NO.10', '0812 9864 1690', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(428, 'R.E.005', 'UMAR SIDIK', NULL, 'ELECTRONUSA MECHANICAL ENGINEERING - CV', NULL, 153, 'JL.SWASEMBADA BARAT XII/4 012/013 KEBON BAWANG', '0812 4042 5307', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(429, 'R.E.006', 'ENDANG', NULL, 'EKA JAYA MOTOR', NULL, 153, 'JL RAYA CIKAMPEK KM.14', '0813 1011 7069', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(430, 'R.J.017', 'ESRA TONDOK', NULL, 'JOJERIN MULTIKARYA INDONESIA - PT', NULL, 153, 'JL TELUK BONE B1/21 KAV AL', '0816 106 565', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(431, 'R.C.034', 'MADE', NULL, 'CAWANG MAKMUR UD / THIO SUGIANTO', NULL, 153, 'JL DEWI SARTIKA NO.214 CAWANG', '0812 8143 5443', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(432, 'R.H.009', NULL, NULL, 'HARAPAN MOTOR - KRANJI', NULL, 153, 'JL.PATRIOT NO.7 KRANJI BEKASI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(433, 'R.B.035', 'BP', NULL, 'BINTANG ABADI', NULL, 153, 'JL RAYA OTISTA NO 45', '021 819 0557', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(434, 'R.R.001', ' BP.AMIN', NULL, 'RAJA MOTOR', NULL, 153, 'JL RAYA INDUSTRI NO.53', '081319503159', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(435, 'R.B.036', 'HJ.MARNI', NULL, 'BERKAH JAYA MOTOR  - BUNGUR DEPOK', NULL, 153, 'JL.RAYA BUNGUR TANAH BARU BEJI DEPOK', '0811 1081 015', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(436, 'R.B.037', 'TRISNO', NULL, 'BERKAH JAYA MOTOR - GANDARIA', NULL, 153, 'JL.JATAYU, GANDARIA', '0899 8370 434', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(437, 'R.F.010', 'BP', NULL, 'FRIENDS MOTOR CIRACAS', NULL, 153, 'JL RAYA CIRACAS RT 04 RW 03 NO.654', '0812 8308 281', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(438, 'R.J.018', 'A BUN', NULL, 'JAYA SAKTI MOTOR', NULL, 153, 'JL WARUNG JATI BARAT NO.8', '0856 9038 080', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(439, 'R.Y.003', 'BP', NULL, 'YAMAHA LIWINANGGUNG', NULL, 153, 'JL RAYA LIWINANGGUNG TAPOS', '0812 1881 0403', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(440, 'R.F.011', 'BP', NULL, 'FAVORIT MOTOR', NULL, 153, 'JL.INDUSTRI NO.30 CIKARANG UTARA', '0859 2134 9000', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(441, 'R.S.080', NULL, NULL, 'SURYA OLI', NULL, 153, 'JL RAYA BOGOR NO.12E KRAMAT JATI', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(442, 'R.T.021', 'BP', NULL, 'TEKUN  JAYA MOTOR', NULL, 153, 'JL RAYA PEKAYON NO.36', '0813 8134 4509', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(443, 'R.N.006', 'KAMAL', NULL, 'N S MOTOR', NULL, 153, 'JL RATNA NO.27 BEKASI', '087 777 572 227', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(444, 'R.S.081', NULL, NULL, 'SUMBER BUMI', NULL, 153, 'JL RAYA FATMAWATI PS CIPETE', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(445, 'R.U.006', 'BP', NULL, 'UTAMA SAKTI', NULL, 153, 'JL.INDUSTRI, CIKARANG', '0878 8764 2966', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(446, 'R.S.082', 'BP', NULL, 'SAHABAT JAYA MOTOR', NULL, 153, 'JL RAYA PEDURENAN', '0852 8382 8494', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(447, 'R.C.035', 'BP', NULL, 'CR MOTOR CIANGSAWA', NULL, 153, 'JL RAYA BOJONG KULUR', '0858 9954 0115', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(448, 'R.J.019', 'BP', NULL, 'JATIRANGGON MOTOR', NULL, 153, 'JL RAYA UJUNG ASPAL NO.5C', '0817 6907 424', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(449, 'R.K.018', 'EDI', NULL, 'KHARISMA MOTOR CIBUBUR', NULL, 153, 'JL ALTERNATIF CIBUBUR', '0811 128 228', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(450, 'R.M.048', 'BP', NULL, 'MURAH ABADI MOTOR', NULL, 153, 'JL KAPTEN JONGGOL, DEKAT PASAR JONGGOL', '0878 7473 3593', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(451, 'R.B.038', 'FEDERICK', NULL, 'BAGUS BARU', NULL, 153, 'JL IR JUANDA 151, RUKO MITRA BEKASI', '(021) 8813550', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(452, 'R.C.036', 'KRISTINA', NULL, 'C B MOTOR', NULL, 153, 'JL RAYA PARUNG BOGOR', '0812 9742 5210', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(453, 'R.T.022', 'BP', NULL, 'TUNAS BARU MOTOR', NULL, 153, 'JL MAYOR OKING CIBINONG', '0812 9967 865', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(454, 'R.P.016', NULL, NULL, 'PURNAMA MOTOR', NULL, 153, 'JL.KALIABANG TENGAH', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(455, 'R.G.016', 'BP', NULL, 'GALASERA MOTOSHOP', NULL, 153, 'JL RAYA CIKARANG CIBARUSAH', '0877 7913 0007', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(456, 'R.Y.004', NULL, NULL, 'YESS MOTOR  PENGGILINGAN', NULL, 153, 'JL RAYA PENGGILINGAN NO 11A', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL);
INSERT INTO `customers` (`id`, `store_code`, `name`, `email`, `store_name`, `cust_type`, `city_id`, `address`, `phone`, `phone_owner`, `phone_store`, `status`, `reg_point`, `payment_term`, `user_id`, `client_id`, `created_at`, `updated_at`, `pareto_id`, `lat`, `lng`) VALUES
(457, 'R.L.013', 'SHOLEH', NULL, 'LINA JAYA MOTOR', NULL, 153, 'JL RAYA CILODONG, DEPOK', '0896 2273 7908', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(458, 'R.T.017', 'BP', NULL, 'TIRTA AGUNG MOTOR', NULL, 153, 'JL RAYA PS MINGGU', '0852 8757 0556', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(459, 'R.T.023', NULL, NULL, 'TIRTA AGUNG BAN .CV', NULL, 153, 'JL RAYA PASAR MINGGU NO.16', NULL, NULL, NULL, 'ACTIVE', 'N', '45 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(460, 'R.B.039', NULL, NULL, 'BUDGET RETAIL', NULL, 153, 'JL TIPAR CAKUNG NO.36', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(461, 'R.M.049', 'Ayung', NULL, 'METEOR MOTOR', NULL, 153, 'JL.MAYOR OKING CIBINONG CITEUREUP', '0815 2312 330', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(462, 'R.A.059', 'BP', NULL, 'AUDI MOTOR', NULL, 153, 'JL.RAYA SRENGSENG SAWAH,DEPOK', '0897 9538 405', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(463, 'R.J.020', 'DODDY', NULL, 'JAMPANG MOTOR', NULL, 153, 'JAMPANG PARUNG NO.155', '0819 0522 4926', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(464, 'R.P.017', 'PABY RIANTO', NULL, 'PEBY MOTOR', NULL, 153, 'JL GANG BHAKTI AKSES UI', '0815 4080 8203', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(465, 'R.A.060', 'IDA', NULL, 'ANUGERAH CAHAYA MULIA .CV', NULL, 153, 'JL KRAMAT RAYA NO.3 S', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(466, 'R.S.083', 'BP', NULL, 'SEMANGAT JAYA MOTOR - TELAJUNG', NULL, 153, 'JL RAYA SETU TELAJUNG', '0853 9377 7993', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(467, 'R.A.061', 'ARIFIN', NULL, 'ARTINDO PRATAMA SEJAHTERA', NULL, 153, 'RUKAN TEUKU UMAR NO.C8', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(468, 'R.S.084', 'BP', NULL, 'SINAR 68 MOTOR - PULO GEBANG', NULL, 153, 'JL RAYA PULO GEBANG', '0812 8040 6600', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(469, 'R.T.024', 'BP', NULL, 'TIARA  ARAFAH', NULL, 153, 'JL RAYA NUSANTARA', '0877 7734 4980', NULL, NULL, 'ACTIVE', 'N', '45 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(470, 'R.C.037', 'BP', NULL, 'CROM MOTOR', NULL, 153, 'VILLA NUSA INDAH II NO.20', '0821 1431 4161', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(471, 'R.R.019', 'BP', NULL, 'REZEKI MOTOR', NULL, 153, 'JL RAYA NAROGONG KM 11', '021 825 3343', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(472, 'R.W.008', 'RUDI', NULL, 'WIJAYA  MOTOR - CITEUREP', NULL, 153, 'JL RAYA KAMURANG CITEUREP', '0813 8370 3481', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(473, 'R.U.007', NULL, NULL, 'ULTRA SAKTI . PT', NULL, 153, 'JL BUKIT GADING RAYA', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(474, 'R.K.019', NULL, NULL, 'KUSUMA MOTOR - BEKASI', NULL, 153, 'JL.IR JUANDA', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(475, 'R.K.020', 'Febby', NULL, 'KARYA INDAH MULTIGUNA PT', NULL, 153, 'JL.RAYA NAROGONG KM.12,5 CIKIWUL', '8265 0877', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(476, 'R.E.007', 'EDDY LIM', NULL, 'EDDY LIM', NULL, 153, 'KELAPA GADING NIRWANA', '0852 8822 2777', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(477, 'R.W.009', NULL, NULL, 'WIYOGO - BAPAK', NULL, 153, 'KAWASAN INDUSTRI BONEN KAV.33A', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(478, 'R.B.040', 'ROY ROBERTH', NULL, 'BERSINAR SEJAHTERA GEMILANG - PT', NULL, 153, 'JL PERUMAHAN PURI CIKARANG HIJAU', '0812 1163 0726', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(479, 'R.P.018', 'ERVIN', NULL, 'POS PELAYANAN', NULL, 153, 'JL RAYA PAHLAWAN SENJA', '0812 9355 766', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(480, 'R.M.050', 'KARMO', NULL, 'MOMO BAUT', NULL, 153, 'AUTOPART PASAR SEGAR', '0857 8131 6010', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(481, 'R.H.010', 'HANDY', NULL, 'HANDY MOTOR', NULL, 153, 'JL RAYA CITEUREP BOGOR', '0878 7000 0710', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(482, 'R.A.062', 'ANDRIYANI', NULL, 'ABADI  MOTOR - BOGOR', NULL, 153, 'JL KH SHOLEH ISKANDAR NO. 15', '08179003998', NULL, NULL, 'ACTIVE', 'N', '30 Days', 5, 1, '2021-05-24 06:46:13', '2021-10-21 05:13:42', 4, '-6.428790147936486', '107.03620052798499'),
(483, 'R.A.063', 'BP', NULL, 'ASEAN  MOTOR - BOGOR', NULL, 153, 'JLRAYA SURYA KENCANA  208', '0896 5484 958', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(484, 'R.A.064', 'BP', NULL, 'ANEKA MAKMUR - BEKASI', NULL, 153, 'JL IR.JUANDA 151', '0815 1960 0195', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(485, 'R.T.025', 'UDA', NULL, 'TONY JAYA MANDIRI', NULL, 153, 'JATI BENING KOTA BEKASI', '0812 1297 5758', NULL, NULL, 'ACTIVE', 'N', '45 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(486, 'R.J.021', 'BP', NULL, 'JAWA MOTOR -  TAMBUN', NULL, 153, 'JL SETIA DARMA 2', '0812 8955 7793', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(487, 'R.A.065', 'TRISNO', NULL, 'AIDO MOTOR', NULL, 153, 'JL.RAYA CINERE LIMO DEPOK', '0882 1264 9646', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(488, 'R.L.014', 'NINA', NULL, 'LARIS JAYA MOTOR', NULL, 153, 'JL NAROGONG KM 23', '0811  1185 707', NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 06:46:13', '2021-05-24 07:29:54', NULL, NULL, NULL),
(489, 'R.C.038', NULL, NULL, 'CAWANG MAKMUR - BUDI SUGIANTO', NULL, 153, 'JL DEWI SARTIKA NO.214', NULL, NULL, NULL, 'ACTIVE', 'N', '30 Days', NULL, 1, '2021-05-24 07:03:29', '2021-05-24 07:29:54', NULL, NULL, NULL),
(490, 'abc01', NULL, NULL, 'cincai 8', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '31 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(491, 'RS8888', NULL, NULL, 'cincai motor', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '32 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(492, 'RS8899', NULL, NULL, 'hao hao motor', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '33 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(493, 'abc012', NULL, NULL, 'cincai 8', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '34 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(494, 'abc013', NULL, NULL, 'cincai 9', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '35 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(495, 'abc014', NULL, NULL, 'cincai 10', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '36 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(496, 'abc015', NULL, NULL, 'cincai 11', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '37 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(497, 'abc016', NULL, NULL, 'cincai 12', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '38 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(498, 'abc017', NULL, NULL, 'cincai 13', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '39 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(499, 'abc018', NULL, NULL, 'cincai 14', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '40 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(500, 'abc019', NULL, NULL, 'cincai 15', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '41 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(501, 'dce01', NULL, NULL, 'cincai 89a', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '42 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(502, 'dce02', NULL, NULL, 'cincai 99a', NULL, NULL, NULL, NULL, NULL, NULL, 'ACTIVE', 'N', '43 Days', NULL, 1, '2021-05-24 07:05:49', '2021-05-24 07:53:40', NULL, NULL, NULL),
(503, 'R.M.044.TNT', 'TNT Test edit imp', 'cvwarung@tnt.com', 'Cv. Warung Edit', NULL, 155, 'Jakarta Utara', '9877663563535', NULL, NULL, 'ACTIVE', 'N', 'Cash', 9, 1, '2021-06-10 04:39:52', '2021-10-21 05:13:20', 4, '-6.287705404277849', '106.42448276224658'),
(505, NULL, 'xyz', NULL, 'xyz', NULL, NULL, 'sB -', '1234567890', '1234567890', '1234567890', 'NEW', 'N', NULL, 31, 1, '2021-06-11 20:50:59', '2021-06-11 20:50:59', NULL, NULL, NULL),
(506, NULL, '1234567890', NULL, 'xyz', NULL, NULL, 'cx -', '1234567890', '1234567890', '1234567890', 'NEW', 'N', NULL, 31, 1, '2021-06-11 20:53:30', '2021-06-11 20:53:30', NULL, NULL, NULL),
(507, NULL, 'x y z', NULL, 'xyz', NULL, NULL, 'xy -', '1234567890', '1234567890', '1234567890', 'NEW', 'N', NULL, 31, 1, '2021-06-11 20:57:13', '2021-06-11 20:57:13', NULL, NULL, NULL),
(508, NULL, 'baru', NULL, 'baru', NULL, NULL, 'baru di buat', '123', '123', '123', 'NEW', 'N', NULL, 31, 1, '2021-06-12 04:29:31', '2021-06-12 04:29:31', NULL, NULL, NULL),
(509, NULL, 'rrr', NULL, 'rrr', NULL, NULL, 'rrr rrr', '1234', '1234', '1234', 'NEW', 'N', NULL, 31, 1, '2021-06-12 04:31:36', '2021-06-12 04:31:36', NULL, NULL, NULL),
(510, NULL, 'fdg', NULL, 'fdg', NULL, NULL, 'asd', '12', '12', '12', 'NEW', 'N', NULL, 31, 1, '2021-06-12 04:32:17', '2021-06-12 04:32:17', NULL, NULL, NULL),
(511, NULL, 't 1', NULL, 't1', NULL, NULL, 't 1 r', '12', '12', '21', 'NEW', 'N', NULL, 31, 1, '2021-06-12 06:17:51', '2021-06-12 06:17:51', NULL, NULL, NULL),
(512, NULL, 't 2', NULL, 't2', NULL, NULL, 'vv bnS', '23', '23', '23', 'NEW', 'N', NULL, 31, 1, '2021-06-12 06:18:36', '2021-06-12 06:18:36', NULL, NULL, NULL),
(513, NULL, 't 3', NULL, 't 3', NULL, NULL, 'bgE v454 t', '12', '12', '12', 'NEW', 'N', NULL, 31, 1, '2021-06-12 06:21:10', '2021-06-12 06:21:10', NULL, NULL, NULL),
(514, NULL, 'test', NULL, 'test', NULL, NULL, 'dd', '1', '1', '1', 'NEW', 'N', NULL, 31, 1, '2021-06-14 10:43:26', '2021-06-14 10:43:26', NULL, NULL, NULL),
(515, NULL, 'tk baru', NULL, 'tk', NULL, NULL, 'sdad', '1', '1', '1', 'NEW', 'N', NULL, 31, 1, '2021-06-14 10:45:13', '2021-06-14 10:45:13', NULL, NULL, NULL),
(516, NULL, 'gg', NULL, 'tg', NULL, NULL, 'dsg', '2', '3', '2', 'NEW', 'N', NULL, 31, 1, '2021-06-14 10:50:00', '2021-06-14 10:50:00', NULL, NULL, NULL),
(517, 'BARU01', 'asda', NULL, 'NEW MOTOR RENOVATION STORE', NULL, 153, 'adasd', '098765421123', '2', '3', 'ACTIVE', 'N', '40 Days', 31, 1, '2021-06-14 10:52:04', '2021-09-01 04:11:07', 4, NULL, NULL),
(518, 'Q2344R', 'Ani', 'asds@asdfs.com', 'asffas', NULL, 153, 'Jakarta Selatan', '234234234324', NULL, NULL, 'ACTIVE', 'N', 'Cash', 5, 1, '2021-06-24 06:16:37', '2021-10-19 05:13:11', 4, '-6.428203772215549', '107.03719830967393'),
(519, 'BARUDAYS', 'Baru', 'baru@days.com', 'baru days', 4, 153, 'Jakarta Selatan', '09876534212', NULL, NULL, 'ACTIVE', 'N', '45 Days', 8, 1, '2021-06-25 03:12:29', '2021-10-19 05:12:57', 4, '-6.289215896700362', '106.41750189405957'),
(520, 'BARUDAYS01', 'Baru', 'baru@days.com', 'baru days', 4, 153, 'Jakarta Utara kanan', '09876534212', '81211111000', '81212123123', 'ACTIVE', 'N', '45 Days', 8, 1, '2021-06-25 04:17:57', '2021-09-07 10:57:11', 4, '-6.289290987795586', '106.41740238931274'),
(521, NULL, 'tt', NULL, 'tt', NULL, NULL, 'skskskskks', '082110292929', '09192828222', '0210291232', 'NEW', 'N', NULL, 3, 1, '2021-08-25 05:01:02', '2021-08-25 05:01:02', NULL, NULL, NULL),
(524, 'ZST01', 'Zst', NULL, 'ZST-STORE', 4, 456, 'Kota Batara', '082113464465', NULL, NULL, 'ACTIVE', 'Y', '45 Days', 3, 1, '2021-09-06 10:23:34', '2021-09-29 09:01:52', 4, '-6.289290987795586', '106.41740238931274'),
(525, 'ZUKO', 'ZST01', NULL, 'Zuko-store', 5, 456, 'Kabupaten Tangerang', '0812132312312', NULL, NULL, 'ACTIVE', 'Y', 'Cash', 5, 1, '2021-09-08 06:07:10', '2021-10-26 06:12:51', 4, '-6.187605400378965', '106.63458124664099'),
(526, 'ZST02', 'zst021', NULL, 'zst-02', NULL, 151, 'sadfasdfasdfsadfsfsdfsdf', '1242343534534', NULL, NULL, 'ACTIVE', 'Y', 'Cash', 3, 1, '2021-09-08 17:05:01', '2022-01-07 06:35:29', 4, NULL, NULL),
(565, NULL, 'Baru ditambah', NULL, 'Toko Baru', NULL, NULL, 'Sumber Sari', '02932847171111', '029394111111111', '2039492734711', 'NEW', 'N', NULL, 5, 1, '2022-01-24 09:22:58', '2022-01-24 09:22:58', NULL, NULL, NULL),
(562, NULL, 'asdASDASD', NULL, 'QWEQW', NULL, NULL, 'sfasfafafafd', '1234124234234', '12341242423434', '234124123341234', 'NEW', 'N', NULL, 5, 1, '2021-10-18 03:03:45', '2021-10-18 03:03:45', NULL, NULL, NULL),
(563, NULL, 'asdas', NULL, 'werqwerwer', NULL, NULL, 'awasfasfsf', '23423553535', '335352352525', '235235235255', 'NEW', 'N', NULL, 5, 1, '2021-10-18 03:51:32', '2021-10-18 03:51:32', NULL, NULL, NULL),
(564, 'ADAD', 'sdgsdgsdg', NULL, 'asdasdadad', 5, 151, 'aSDAsdasd', '2412412421424', NULL, NULL, 'ACTIVE', 'N', 'Cash', 5, 1, '2021-11-13 03:57:25', '2021-12-28 02:36:29', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_points`
--

CREATE TABLE `customer_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `period_id` bigint(20) NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_points`
--

INSERT INTO `customer_points` (`id`, `client_id`, `customer_id`, `period_id`, `file`, `created_at`, `updated_at`) VALUES
(1, 1, 525, 1, NULL, '2021-11-02 17:43:15', '2021-11-02 17:43:15'),
(2, 1, 525, 2, NULL, '2021-11-15 09:35:02', '2021-11-15 09:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Berisi nama file image tanpa path',
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `version` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_cat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `group_image`, `display_name`, `client_id`, `version`, `status`, `group_cat`, `created_at`, `updated_at`) VALUES
(1, 'group1', 'groups-images/LrQAAC4Ejgw1iFCiGFtCMXkaANo9wICJpT94LLX1.jpg', 'group 1 nusa 1 bangsa', NULL, NULL, 'ACTIVE', NULL, '2021-03-16 04:50:51', '2021-04-14 10:28:50'),
(4, 'GROUP2', 'groups-images/kUtuYtCCdD6gjF0BXPakbyyTYjwy00sVWijT5L0I.jpg', 'Group 2', NULL, NULL, 'ACTIVE', NULL, '2021-03-18 04:33:26', '2021-03-24 06:36:30'),
(5, 'GROUP3', 'groups-images/vAZ3UbMkrxmoqESAhkv7yuHIpGEQiIA95bJlmMid.jpg', 'Group 3', NULL, NULL, 'ACTIVE', NULL, '2021-03-18 08:58:00', '2021-03-24 06:37:05'),
(10, 'ALL-PRODUCT', 'groups-images/HARTNSbOEK68K7b08GdHnf6E6fZQhkcld8JzluwN.png', 'ALL product', NULL, NULL, 'ACTIVE', 'ALL_PRODUCT', '2021-04-15 10:07:17', '2021-04-15 10:07:17'),
(12, 'ALL-PRODUCT', 'groups-images/1XJZ8LmNqiLBhhMEGc4ooZPVkEEA6BI5uxHZelAl.jpg', 'Group All Product', 1, NULL, 'ACTIVE', 'ALL_PRODUCT', '2021-06-10 03:04:39', '2021-06-10 03:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `groups_paket`
--

CREATE TABLE `groups_paket` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `paket_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_product`
--

CREATE TABLE `group_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_product`
--

INSERT INTO `group_product` (`id`, `group_id`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(12, 1, 5, 'INACTIVE', '2021-03-17 05:22:28', '2021-04-14 10:28:24'),
(13, 1, 7, 'ACTIVE', '2021-03-17 05:22:28', '2021-04-14 10:28:50'),
(14, 1, 3, 'INACTIVE', '2021-03-17 05:29:41', '2021-04-14 10:28:24'),
(15, 1, 8, 'ACTIVE', '2021-03-18 03:05:55', '2021-04-14 10:28:50'),
(16, 4, 2, 'ACTIVE', NULL, '2021-04-14 10:12:46'),
(17, 4, 5, 'ACTIVE', NULL, '2021-04-14 10:12:51'),
(18, 5, 3, 'ACTIVE', NULL, NULL),
(19, 5, 5, 'INACTIVE', NULL, NULL),
(23, 1, 10, 'ACTIVE', '2021-03-25 07:38:46', '2021-04-14 10:28:50'),
(24, 1, 20, 'ACTIVE', '2021-03-25 07:38:46', '2021-04-14 10:28:50'),
(25, 1, 22, 'ACTIVE', '2021-03-25 07:38:46', '2021-04-14 10:28:50'),
(27, 1, 4, 'ACTIVE', '2021-04-14 07:57:34', '2021-04-14 10:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wp_id` bigint(20) UNSIGNED NOT NULL,
  `date_holiday` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `wp_id`, `date_holiday`, `created_at`, `updated_at`) VALUES
(25, 1, '2021-08-01', '2021-08-16 13:43:23', '2021-08-16 13:43:23'),
(26, 1, '2021-08-08', '2021-08-16 13:43:23', '2021-08-16 13:43:23'),
(27, 1, '2021-08-15', '2021-08-16 13:43:24', '2021-08-16 13:43:24'),
(28, 1, '2021-08-22', '2021-08-16 13:43:24', '2021-08-16 13:43:24'),
(29, 1, '2021-08-29', '2021-08-16 13:43:24', '2021-08-16 13:43:24'),
(30, 1, '2021-08-10', '2021-08-16 13:43:24', '2021-08-16 13:43:24'),
(31, 1, '2021-08-17', '2021-08-16 13:43:25', '2021-08-16 13:43:25'),
(32, 2, '2021-10-03', '2021-10-22 02:37:06', '2021-10-22 02:37:06'),
(33, 2, '2021-10-10', '2021-10-22 02:37:06', '2021-10-22 02:37:06'),
(34, 2, '2021-10-17', '2021-10-22 02:37:06', '2021-10-22 02:37:06'),
(35, 2, '2021-10-24', '2021-10-22 02:37:06', '2021-10-22 02:37:06'),
(36, 2, '2021-10-31', '2021-10-22 02:37:06', '2021-10-22 02:37:06'),
(37, 2, '2021-10-20', '2021-10-22 02:37:06', '2021-10-22 02:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `login_records`
--

CREATE TABLE `login_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `logged_in` timestamp NULL DEFAULT NULL,
  `logged_out` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_records`
--

INSERT INTO `login_records` (`id`, `client_id`, `user_id`, `logged_in`, `logged_out`) VALUES
(1, 1, 3, '2021-08-30 08:53:59', '2021-08-30 08:54:21'),
(2, 1, 3, '2021-08-31 04:33:01', '2021-08-31 04:33:29'),
(3, 1, 3, '2021-09-01 05:56:32', '2021-09-01 08:01:02'),
(4, 1, 3, '2021-09-02 02:23:43', NULL),
(5, 1, 3, '2021-09-02 17:49:50', NULL),
(6, 1, 3, '2021-09-04 15:42:50', '2021-09-04 16:05:58'),
(7, 1, 3, '2021-09-06 02:20:23', '2021-09-06 07:32:08'),
(8, 1, 3, '2021-09-07 03:35:56', '2021-09-07 10:36:00'),
(9, 1, 3, '2021-09-08 06:41:25', NULL),
(10, 1, 3, '2021-09-08 17:07:03', NULL),
(11, 1, 3, '2021-09-12 17:48:51', NULL),
(12, 1, 3, '2021-09-14 02:11:40', '2021-09-14 03:22:37'),
(13, 1, 3, '2021-09-15 03:04:20', '2021-09-15 08:04:43'),
(14, 1, 3, '2021-09-16 02:25:51', '2021-09-16 14:59:12'),
(15, 1, 3, '2021-09-16 18:20:39', NULL),
(16, 1, 3, '2021-09-20 02:17:17', '2021-09-20 02:28:13'),
(17, 1, 3, '2021-09-24 07:29:33', '2021-09-24 08:14:27'),
(18, 1, 3, '2021-09-28 13:44:42', '2021-09-28 13:47:24'),
(19, 1, 3, '2021-09-29 02:38:08', '2021-09-29 04:49:42'),
(20, 1, 3, '2021-10-01 08:20:27', '2021-10-01 08:24:45'),
(21, 1, 5, '2021-10-12 07:28:02', '2021-10-12 14:47:16'),
(22, 1, 5, '2021-10-13 03:06:30', '2021-10-13 15:37:51'),
(23, 1, 5, '2021-10-13 17:31:00', NULL),
(24, 1, 5, '2021-10-14 17:22:18', '2021-10-15 07:41:16'),
(25, 1, 5, '2021-10-16 03:45:57', NULL),
(26, 1, 5, '2021-10-18 03:00:23', '2021-10-18 06:44:09'),
(27, 1, 5, '2021-10-21 05:41:31', '2021-10-21 16:45:37'),
(28, 1, 5, '2021-10-22 02:37:31', '2021-10-22 02:59:57'),
(29, 1, 5, '2021-10-25 03:30:16', '2021-10-25 07:59:18'),
(30, 1, 5, '2021-10-26 06:13:05', '2021-10-26 16:15:59'),
(31, 1, 5, '2021-10-27 22:01:40', '2021-10-28 16:44:00'),
(32, 1, 5, '2021-10-29 06:11:41', NULL),
(33, 1, 5, '2021-11-01 04:10:00', NULL),
(34, 1, 5, '2021-11-02 03:59:52', '2021-11-02 10:18:30'),
(35, 1, 5, '2021-11-02 17:20:00', '2021-11-03 09:38:49'),
(36, 1, 5, '2021-11-04 02:22:12', NULL),
(37, 1, 5, '2021-11-05 03:01:38', '2021-11-05 09:06:06'),
(38, 1, 5, '2021-11-08 03:27:16', '2021-11-08 10:49:07'),
(39, 1, 5, '2021-11-09 07:18:20', NULL),
(40, 1, 5, '2021-11-12 04:49:55', '2021-11-12 07:52:40'),
(41, 1, 5, '2021-11-14 18:15:43', '2021-11-15 14:13:20'),
(42, 1, 5, '2021-11-16 06:06:01', '2021-11-16 08:07:18'),
(43, 1, 5, '2021-11-17 02:08:01', NULL),
(44, 1, 5, '2021-11-18 03:01:22', '2021-11-18 03:05:30'),
(45, 1, 5, '2021-11-18 18:12:27', '2021-11-19 08:19:14'),
(46, 1, 5, '2021-11-21 10:35:43', NULL),
(47, 1, 5, '2021-11-21 18:51:13', '2021-11-22 06:40:40'),
(48, 1, 5, '2021-11-23 00:37:49', NULL),
(49, 1, 5, '2021-11-23 18:06:00', '2021-11-24 07:58:17'),
(50, 1, 5, '2021-11-26 06:18:03', '2021-11-26 06:39:55'),
(51, 1, 5, '2021-11-27 17:17:15', NULL),
(52, 1, 5, '2021-11-29 03:07:40', '2021-11-29 05:00:28'),
(53, 1, 5, '2021-11-30 03:25:39', '2021-11-30 10:23:58'),
(54, 1, 5, '2021-12-01 02:44:09', '2021-12-01 06:40:56'),
(55, 2, 9, '2021-12-01 07:03:31', '2021-12-01 07:10:28'),
(56, 1, 5, '2021-12-06 04:05:48', '2021-12-06 04:27:14'),
(57, 1, 3, '2021-12-12 17:51:29', '2021-12-12 17:52:11'),
(58, 1, 5, '2021-12-17 03:43:33', '2021-12-17 04:58:11'),
(59, 1, 5, '2021-12-20 04:36:14', NULL),
(60, 1, 5, '2021-12-22 02:54:19', '2021-12-22 03:16:01'),
(61, 1, 5, '2021-12-27 06:26:25', '2021-12-27 06:36:52'),
(62, 1, 5, '2021-12-28 06:04:11', '2021-12-28 07:17:34'),
(63, 1, 5, '2021-12-29 06:13:34', '2021-12-29 07:43:50'),
(64, 1, 5, '2021-12-30 02:22:11', NULL),
(65, 1, 5, '2021-12-31 03:11:44', '2021-12-31 03:27:27'),
(66, 1, 5, '2021-12-31 19:42:55', '2022-01-01 05:19:51'),
(67, 1, 5, '2022-01-01 19:06:23', '2022-01-02 08:26:53'),
(68, 1, 5, '2022-01-03 02:26:36', '2022-01-03 16:45:56'),
(69, 1, 5, '2022-01-04 08:10:22', '2022-01-04 08:11:06'),
(70, 1, 5, '2022-01-06 02:48:28', '2022-01-06 05:09:39'),
(71, 1, 5, '2022-01-10 11:05:57', NULL),
(72, 1, 5, '2022-01-11 03:29:01', '2022-01-11 03:31:29'),
(73, 1, 5, '2022-01-12 05:00:34', '2022-01-12 16:01:27'),
(74, 1, 5, '2022-01-12 18:02:56', '2022-01-13 08:21:55'),
(75, 1, 5, '2022-01-14 02:15:39', '2022-01-14 03:42:48'),
(76, 1, 5, '2022-01-17 05:26:09', NULL),
(77, 1, 5, '2022-01-18 07:29:31', '2022-01-18 11:26:08'),
(78, 1, 5, '2022-01-19 04:58:56', '2022-01-19 07:31:06'),
(79, 1, 5, '2022-01-20 03:04:41', '2022-01-20 06:02:09'),
(80, 1, 5, '2022-01-21 08:03:10', '2022-01-21 09:44:04'),
(81, 1, 5, '2022-01-22 07:00:33', NULL),
(82, 1, 5, '2022-01-24 06:20:51', '2022-01-24 06:22:48'),
(83, 1, 5, '2022-01-25 09:28:19', '2022-01-25 10:29:55'),
(84, 1, 5, '2022-01-26 04:36:31', '2022-01-26 11:20:56'),
(85, 1, 5, '2022-01-28 14:53:41', NULL),
(86, 1, 5, '2022-01-31 02:51:23', '2022-01-31 03:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `m_tittle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_tittle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_tittle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_tittle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `client_id`, `m_tittle`, `s_tittle`, `c_tittle`, `o_tittle`, `created_at`, `updated_at`) VALUES
(2, 1, 'PO SALES RETAIL PT. PRIMA JIREH', 'Detail Sales', 'Detail Pelanggan', 'Detail Pesanan', '2021-08-23 06:04:40', '2021-09-12 10:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_04_140929_penyesuaian_table_users', 1),
(5, '2020_07_15_063013_create_categories_table', 1),
(6, '2020_09_25_175720_create_products_table', 1),
(7, '2020_09_26_080203_penyesuaian_table_products', 1),
(8, '2020_09_26_164807_create_category_product_table', 1),
(9, '2020_09_28_042214_create_orders_table', 1),
(10, '2020_09_28_042951_create_order_product_table', 1),
(11, '2020_10_09_093227_create_sessions_table', 1),
(12, '2020_11_30_065551_create_banners_table', 1),
(13, '2020_12_03_071455_add_top_product_on_products_table', 1),
(14, '2020_12_10_093039_add_discount_on_products_table', 1),
(15, '2020_12_16_110739_create_vouchers_table', 1),
(16, '2020_12_22_120502_add_id_voucher_on_orders_table', 1),
(17, '2021_01_04_101334_add_price_item_on_order_product_table', 1),
(18, '2021_01_15_101441_add_low_stock_treshold_on_product_table', 1),
(19, '2021_01_26_115302_add_id_city_province_on_table_user', 1),
(20, '2021_01_26_135803_create_cities_table', 1),
(21, '2021_01_26_140107_create_provinces_table', 1),
(22, '2021_02_02_041038_create_customers_table', 1),
(23, '2021_02_02_091546_add_user_loc_on_table_orders', 1),
(24, '2021_02_18_163030_add_payment_method_on_orders_table', 2),
(25, '2021_02_22_034508_add_store_code_and_status_on_table_customers', 3),
(26, '2021_02_22_095143_add_payment_term_on_customers', 4),
(27, '2021_02_22_095731_add_sales_area_on_users', 5),
(28, '2021_02_24_094752_change_unique_column_phone_on_customers', 6),
(29, '2021_03_02_170109_add_position_on_table_banner', 7),
(30, '2021_03_03_114930_add_optional_numbertelefon_on_customer', 8),
(31, '2021_03_04_102413_add_notes_on_order', 9),
(37, '2021_03_09_092745_create_paket_table', 13),
(36, '2021_03_10_110521_create_groups_paket_table', 12),
(40, '2021_03_11_153808_create_group_product_table', 15),
(39, '2021_03_10_105733_create_groups_table', 14),
(41, '2021_03_17_135934_add_group_id_on_order_product_table', 16),
(42, '2021_03_18_235202_add_paket_id_on_order_product', 17),
(43, '2021_03_19_162119_add_product_kode_on_product_table', 18),
(44, '2021_03_24_120840_add_image_field_on_group_table', 19),
(45, '2021_03_30_134357_add_bonus_cat_on_order_product_table', 20),
(46, '2021_04_03_060053_change_default_totalprice_on_table_orders', 21),
(47, '2021_04_15_133038_add_group_cat_on_group_table', 22),
(48, '2021_04_21_132745_add_time_proses_finish_cancel_on_orde_table', 23),
(49, '2021_04_28_203330_create_spv_sales_table', 24),
(50, '2021_05_20_171122_add_display_order_on_cities_table', 25),
(51, '2021_05_21_152326_add_city_id_on_customers_table', 26),
(54, '2021_05_26_225304_create_product_stock_status_table', 28),
(68, '2021_06_02_110539_create_b2b_client_table', 39),
(57, '2021_06_02_155602_add_client_id_on_banners', 30),
(58, '2021_06_02_155653_add_client_id_on_categories', 31),
(59, '2021_06_02_155733_add_client_id_on_customers', 32),
(60, '2021_06_02_155831_add_client_id_on_groups', 33),
(61, '2021_06_02_155852_add_client_id_on_orders', 34),
(62, '2021_06_02_155923_add_client_id_on_pakets', 35),
(63, '2021_06_02_160027_add_client_id_on_products', 36),
(64, '2021_06_02_160235_add_client_id_on_product_stock_status', 37),
(65, '2021_06_02_160316_add_client_id_on_users', 38),
(69, '2021_06_17_143249_add_type_client_on_table_b2b_client', 40),
(70, '2021_06_22_093623_add_cust_type_on_customer_table', 41),
(72, '2021_06_28_095037_create_type_customer_table', 42),
(73, '2021_06_28_161026_change_column_cust_type_on_customers', 43),
(75, '2021_06_30_044828_add_cancel_notes_on_orders_table', 44),
(76, '2021_06_30_140536_add_cancled_by_on_order_table', 45),
(79, '2021_07_05_164326_create_sales_targets_table', 46),
(80, '2021_07_12_165319_add_parent_id_on_categories_table', 47),
(84, '2021_08_04_103136_cat_pareto', 50),
(82, '2021_08_04_110735_add_pareto_id_on_customer_table', 49),
(86, '2021_08_05_104022_add_target_store_on_customers_table', 51),
(88, '2021_08_05_162435_add_updated_created_by_on_sales_targets_table', 52),
(92, '2021_08_07_192937_add_updated_created_by_on_store_target_table', 54),
(91, '2021_08_06_164220_create_store_target_table', 53),
(95, '2021_08_10_141340_create_work_plans_table', 55),
(96, '2021_08_10_142102_create_holidays_table', 56),
(100, '2021_08_19_095134_create_messages_table', 57),
(102, '2021_08_25_095653_create_reasons_checkouts_table', 58),
(103, '2021_08_25_134530_add_notes_no_order_and_reasons_id_on_order_table', 59),
(106, '2021_08_30_093105_create_login_records_table', 60),
(107, '2021_08_31_151940_add_ppn_on_sales_target_tale', 61),
(109, '2021_09_06_135003_add_column_lat_lng_on_customers_table', 62),
(119, '2021_09_27_095508_create_point_periods_table', 70),
(118, '2021_09_21_122151_create_product_rewards_table', 69),
(127, '2021_09_22_094530_create_point_claims_table', 77),
(120, '2021_09_21_113543_create_point_rewards_table', 71),
(121, '2021_09_28_113910_add_reg_point_on_customer_table', 72),
(122, '2021_09_30_033644_add_status_on_product_rewards_table', 73),
(128, '2021_02_24_151720_add_key_code_on_table_product', 78),
(124, '2021_10_05_103527_add_period_id_on_point_claims_table', 75),
(126, '2021_10_06_142644_create_customer_points_table', 76),
(129, '2021_09_17_095041_create_catalogs_table', 78),
(131, '2021_10_13_091432_add_target_qty_on_sales_targets_table', 79),
(132, '2021_10_14_160009_add_version_pareto_on_store_target_table', 80),
(133, '2021_10_18_153102_add_target_type_on_store_target_table', 81),
(134, '2021_11_03_100048_add_status_on_point_claims_table', 82),
(136, '2021_11_10_091408_create_product_targets_table', 83),
(137, '2021_11_23_121133_add_info_product_on_order_prodact_table', 84),
(138, '2021_11_23_121314_add_info_product_on_order_paket_tmp_table', 85),
(142, '2021_11_25_034911_add_delivery_qty_on_order_product_table', 86),
(143, '2021_11_25_145232_add_notes_partial_shipping_on_orders_table', 87),
(146, '2021_12_22_102534_create_volume_discounts_table', 90),
(145, '2021_12_23_100640_create_volume_discount_products_table', 89),
(147, '2022_01_02_135232_add_vol_disc_price_on_order_product', 91),
(149, '2022_01_25_094158_create_partial_deliveries_table', 92);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_loc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_voucher` bigint(20) UNSIGNED DEFAULT NULL,
  `total_price` decimal(11,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('SUBMIT','PROCESS','FINISH','CANCEL','NO-ORDER','PARTIAL-SHIPMENT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `process_time` timestamp NULL DEFAULT NULL,
  `finish_time` timestamp NULL DEFAULT NULL,
  `cancel_time` timestamp NULL DEFAULT NULL,
  `notes_cancel` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canceled_by` bigint(20) DEFAULT NULL,
  `reasons_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes_no_order` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NotesPartialShip` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `user_id`, `user_loc`, `customer_id`, `phone`, `id_voucher`, `total_price`, `invoice_number`, `payment_method`, `notes`, `status`, `created_at`, `updated_at`, `process_time`, `finish_time`, `cancel_time`, `notes_cancel`, `canceled_by`, `reasons_id`, `notes_no_order`, `NotesPartialShip`) VALUES
(1, 1, 3, 'Off Location', 503, NULL, NULL, '1141500.00', '20210225101232', 'Non Tunai', NULL, 'CANCEL', '2021-02-25 03:12:32', '2021-07-01 09:20:02', '2021-06-10 17:46:17', NULL, '2021-07-01 09:20:02', 'teri', 3, NULL, NULL, NULL),
(2, NULL, 4, 'Off Location', 2, NULL, NULL, '741000.00', '20210225115721', 'Non Tunai', NULL, 'SUBMIT', '2021-02-25 04:57:21', '2021-02-25 05:03:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 3, 'On Location', 5, NULL, NULL, '1170000.00', '20210225140028', 'Tunai', NULL, 'SUBMIT', '2021-02-25 07:00:28', '2021-02-25 07:00:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 7, 'On Location', 5, NULL, NULL, '1170000.00', '20210225140554', 'Tunai', NULL, 'SUBMIT', '2021-02-25 07:05:54', '2021-02-25 07:06:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 7, 'On Location', 1, NULL, NULL, '1863000.00', '20210225140737', 'Non Tunai', NULL, 'SUBMIT', '2021-02-25 07:07:37', '2021-02-25 07:31:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 3, 'On Location', 5, NULL, NULL, '234000.00', '20210225140803', 'Non Tunai', NULL, 'SUBMIT', '2021-02-25 07:08:03', '2021-02-25 07:08:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 3, 'On Location', 5, NULL, NULL, '1170000.00', '20210225141234', 'Tunai', NULL, 'SUBMIT', '2021-02-25 07:12:34', '2021-02-25 07:13:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 1, 3, 'Off Location', 2, NULL, NULL, '104640.00', '20210729134403', 'TOP', NULL, 'CANCEL', '2021-08-03 04:27:03', '2021-08-18 06:19:53', NULL, NULL, '2021-08-18 06:19:53', 'ttt', 3, NULL, NULL, NULL),
(9, NULL, 7, 'On Location', 1, NULL, NULL, '6020000.00', '20210225144200', 'Tunai', NULL, 'SUBMIT', '2021-02-25 07:42:00', '2021-02-25 07:42:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 7, 'On Location', 6, NULL, NULL, '63256250.00', '20210225151559', 'Tunai', NULL, 'SUBMIT', '2021-02-25 08:15:59', '2021-02-25 10:27:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, 7, 'On Location', 1, NULL, NULL, '117000.00', '20210225172946', 'Tunai', NULL, 'SUBMIT', '2021-02-25 10:29:46', '2021-02-25 10:29:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 7, 'On Location', 1, NULL, NULL, '27607500.00', '20210225173330', 'Tunai', NULL, 'SUBMIT', '2021-02-25 10:33:30', '2021-02-25 10:35:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, 7, 'On Location', 12, NULL, NULL, '7545000.00', '20210226115424', 'Tunai', NULL, 'SUBMIT', '2021-02-26 04:54:24', '2021-02-26 04:55:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, 7, 'Off Location', 1, NULL, NULL, '20696500.00', '20210226130532', 'Tunai', NULL, 'SUBMIT', '2021-02-26 06:05:32', '2021-02-26 07:12:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, 3, 'Off Location', 2, NULL, NULL, '459000.00', '20210228204416', 'Tunai', NULL, 'SUBMIT', '2021-02-28 13:44:16', '2021-03-01 08:42:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, 7, 'On Location', 13, NULL, NULL, '12529500.00', '20210301082846', 'Tunai', NULL, 'SUBMIT', '2021-03-01 01:28:46', '2021-03-03 07:01:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, NULL, 3, 'Off Location', 5, NULL, NULL, '117000.00', '20210301163826', 'Tunai', NULL, 'SUBMIT', '2021-03-01 09:38:26', '2021-03-01 09:39:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, 3, 'Off Location', 5, NULL, NULL, '682500.00', '20210301164829', 'Tunai', NULL, 'SUBMIT', '2021-03-01 09:48:29', '2021-03-01 09:50:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, NULL, 3, 'Off Location', 5, NULL, NULL, '600000.00', '20210301170211', 'Tunai', NULL, 'SUBMIT', '2021-03-01 10:02:11', '2021-03-01 10:04:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, NULL, 3, 'Off Location', 5, NULL, NULL, '624000.00', '20210301171150', 'Tunai', NULL, 'SUBMIT', '2021-03-01 10:11:50', '2021-03-01 10:16:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, NULL, 3, 'On Location', 5, NULL, NULL, '1141500.00', '20210303112606', 'Tunai', NULL, 'SUBMIT', '2021-03-03 04:26:06', '2021-03-03 04:26:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, NULL, 3, 'Off Location', 2, NULL, NULL, '530750.00', '20210303113643', 'TOP 30 Days', NULL, 'SUBMIT', '2021-03-03 04:36:43', '2021-03-04 08:48:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, 7, 'On Location', 1, NULL, NULL, '234000.00', '20210304102252', 'Tunai', NULL, 'SUBMIT', '2021-03-04 03:22:52', '2021-03-04 03:23:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, NULL, 7, 'On Location', 1, NULL, NULL, '117000.00', '20210304102333', 'Tunai', NULL, 'SUBMIT', '2021-03-04 03:23:33', '2021-03-04 03:23:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, NULL, 3, 'On Location', 51, NULL, NULL, '600750.00', '20210304165831', 'Cash', NULL, 'SUBMIT', '2021-03-04 09:58:31', '2021-03-04 13:07:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, NULL, 7, 'On Location', 1, NULL, NULL, '8700000.00', '20210305061819', 'Cash', NULL, 'SUBMIT', '2021-03-04 23:18:19', '2021-03-05 06:45:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, NULL, 3, 'On Location', 5, NULL, NULL, '1225250.00', '20210305095039', 'TOP 7 Days', 'jkjjijpom', 'SUBMIT', '2021-03-05 02:50:39', '2021-03-05 02:51:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, NULL, 3, 'On Location', 53, NULL, NULL, '1496750.00', '20210305100224', 'Cash', NULL, 'SUBMIT', '2021-03-05 03:02:24', '2021-03-05 07:20:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, NULL, 3, 'Off Location', 5, NULL, NULL, '940000.00', '20210305174312', 'Cash', NULL, 'SUBMIT', '2021-03-05 10:43:12', '2021-03-12 07:25:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, NULL, 7, 'On Location', 1, NULL, NULL, '1707000.00', '20210307154016', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-07 08:40:16', '2021-03-07 08:55:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, NULL, 7, 'On Location', 1, NULL, NULL, '117000.00', '20210307170734', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-07 10:07:34', '2021-03-07 10:07:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, NULL, 7, 'On Location', 1, NULL, NULL, '576000.00', '20210307170826', 'Cash', NULL, 'SUBMIT', '2021-03-07 10:08:26', '2021-03-07 10:08:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, NULL, 7, 'On Location', 2, NULL, NULL, '1152000.00', '20210307170950', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-07 10:09:50', '2021-03-07 10:11:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, NULL, 7, 'On Location', 1, NULL, NULL, '4439500.00', '20210307171201', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-07 10:12:01', '2021-03-07 10:19:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, NULL, 7, 'On Location', 1, NULL, NULL, '576000.00', '20210307172347', 'Cash', NULL, 'SUBMIT', '2021-03-07 10:23:47', '2021-03-07 10:23:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, NULL, 7, 'On Location', 1, NULL, NULL, '576000.00', '20210308081725', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-08 01:17:25', '2021-03-08 01:17:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, NULL, 7, 'On Location', 2, NULL, NULL, '576000.00', '20210308082808', 'TOP 7 Days', NULL, 'SUBMIT', '2021-03-08 01:28:08', '2021-03-08 01:28:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, NULL, 3, 'Off Location', 2, NULL, NULL, '4170000.00', '20210405174943', 'Cash', 'test', 'SUBMIT', '2021-04-05 10:49:43', '2021-04-06 06:06:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, NULL, 3, 'Off Location', 2, NULL, NULL, '1141500.00', '20210406130732', 'Cash', 'tes', 'SUBMIT', '2021-04-06 06:07:32', '2021-04-06 06:07:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, NULL, 3, 'Off Location', 5, NULL, NULL, '2269000.00', '20210406130807', 'Cash', 'test', 'SUBMIT', '2021-04-06 06:08:07', '2021-04-06 06:08:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, NULL, 3, 'Off Location', 2, NULL, NULL, '1765500.00', '20210406130911', 'Cash', 'test', 'SUBMIT', '2021-04-06 06:09:11', '2021-04-06 06:09:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, NULL, 3, 'Off Location', 2, NULL, NULL, '1423500.00', '20210406145245', 'TOP 14 Days', 'test', 'SUBMIT', '2021-04-06 07:52:45', '2021-04-06 07:55:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, NULL, 3, 'Off Location', 5, NULL, NULL, '576000.00', '20210406145733', 'Cash', 'test', 'SUBMIT', '2021-04-06 07:57:33', '2021-04-06 07:57:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, NULL, 3, 'Off Location', 2, NULL, NULL, '576000.00', '20210406150721', 'Cash', 'asdasd\r\nadasdad\r\nadadad', 'SUBMIT', '2021-04-06 08:07:21', '2021-04-06 08:07:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, NULL, 3, 'Off Location', 2, NULL, NULL, '799500.00', '20210406150845', 'Cash', 'ADSASD\r\nasAS\r\nADSAs', 'SUBMIT', '2021-04-06 08:08:45', '2021-04-06 08:09:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, NULL, 3, 'Off Location', 5, NULL, NULL, '1306500.00', '20210406151006', 'Cash', NULL, 'SUBMIT', '2021-04-06 08:10:06', '2021-04-06 08:10:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, NULL, 3, 'Off Location', 2, NULL, NULL, '682500.00', '20210406151041', 'Cash', 'ASDAD\r\nADASDA\r\nADADSA', 'SUBMIT', '2021-04-06 08:10:41', '2021-04-06 08:10:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, NULL, 3, 'Off Location', 2, NULL, NULL, '459000.00', '20210406153449', 'Cash', 'wert\r\nwert', 'SUBMIT', '2021-04-06 08:34:49', '2021-04-06 08:35:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, NULL, 3, 'Off Location', 2, NULL, NULL, '210370750.00', '20210406165950', 'Cash', NULL, 'SUBMIT', '2021-04-06 09:59:50', '2021-04-09 08:58:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, NULL, 9, 'Off Location', 2, NULL, NULL, '3016500.00', '20210409143356', 'Cash', 'sdsd', 'SUBMIT', '2021-04-09 07:33:56', '2021-04-09 08:23:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, NULL, 3, 'Off Location', 2, NULL, NULL, '2744000.00', '20210409155904', 'Cash', NULL, 'SUBMIT', '2021-04-09 08:59:04', '2021-04-09 09:57:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, NULL, 3, 'Off Location', 5, NULL, NULL, '4959000.00', '20210409170159', 'Cash', 'ok', 'SUBMIT', '2021-04-09 10:01:59', '2021-04-10 17:58:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, NULL, 3, 'Off Location', 5, NULL, NULL, '576000.00', '20210411010518', 'Cash', 'test\r\nlagi', 'SUBMIT', '2021-04-10 18:05:18', '2021-04-10 18:07:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, NULL, 3, 'Off Location', 5, NULL, NULL, '576000.00', '20210411011130', 'Cash', 'oce\r\noce', 'SUBMIT', '2021-04-10 18:11:30', '2021-04-10 18:12:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, NULL, 3, 'Off Location', 2, NULL, NULL, '117000.00', '20210412103204', 'Cash', 'test note', 'SUBMIT', '2021-04-12 03:32:04', '2021-04-12 03:32:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, NULL, 3, 'Off Location', 2, NULL, NULL, '459000.00', '20210412103544', 'Cash', 'test wa lagi', 'SUBMIT', '2021-04-12 03:35:44', '2021-04-12 03:35:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, NULL, 3, 'Off Location', 5, NULL, NULL, '741000.00', '20210412103855', 'Cash', 'test wa  meneh', 'SUBMIT', '2021-04-12 03:38:55', '2021-04-12 03:39:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, NULL, 3, 'Off Location', 5, NULL, NULL, '1083000.00', '20210412104126', 'TOP 7 Days', 'tets', 'SUBMIT', '2021-04-12 03:41:26', '2021-04-12 03:41:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, NULL, 3, 'Off Location', 2, NULL, NULL, '422500.00', '20210412104424', 'Cash', 'lagiiii', 'SUBMIT', '2021-04-12 03:44:24', '2021-04-12 03:44:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, NULL, 3, 'Off Location', 5, NULL, NULL, '592500.00', '20210412104907', 'Cash', 'yes', 'SUBMIT', '2021-04-12 03:49:07', '2021-04-12 03:49:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, NULL, 3, 'Off Location', 5, NULL, NULL, '234000.00', '20210412105056', 'Cash', 'okyes', 'SUBMIT', '2021-04-12 03:50:56', '2021-04-12 03:51:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, NULL, 3, 'Off Location', 2, NULL, NULL, '234000.00', '20210412105305', 'Cash', 'yeah', 'SUBMIT', '2021-04-12 03:53:05', '2021-04-12 03:53:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, NULL, 3, 'Off Location', 2, NULL, NULL, '7755000.00', '20210412105421', 'Cash', 'ok', 'SUBMIT', '2021-04-12 03:54:21', '2021-04-12 03:57:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, NULL, 3, 'Off Location', 5, NULL, NULL, '5003750.00', '20210412110702', 'Cash', 'ok', 'SUBMIT', '2021-04-12 04:07:02', '2021-04-12 04:08:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, NULL, 3, 'Off Location', 5, NULL, NULL, '4137500.00', '20210412111137', 'Cash', NULL, 'SUBMIT', '2021-04-12 04:11:37', '2021-04-12 04:16:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, NULL, 3, 'Off Location', 5, NULL, NULL, '1875000.00', '20210412111832', 'Cash', NULL, 'SUBMIT', '2021-04-12 04:18:32', '2021-04-12 04:21:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, NULL, 3, 'Off Location', 5, NULL, NULL, '1875000.00', '20210412113450', 'Cash', NULL, 'SUBMIT', '2021-04-12 04:34:50', '2021-04-12 04:35:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, NULL, 3, 'Off Location', 5, NULL, NULL, '4137500.00', '20210412114346', 'Cash', NULL, 'SUBMIT', '2021-04-12 04:43:46', '2021-04-12 06:08:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, NULL, 3, 'Off Location', 5, NULL, NULL, '1875000.00', '20210412131255', 'Cash', NULL, 'SUBMIT', '2021-04-12 06:12:55', '2021-04-12 06:13:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, NULL, 3, 'Off Location', 5, NULL, NULL, '6825000.00', '20210412132445', 'Cash', NULL, 'SUBMIT', '2021-04-12 06:24:45', '2021-04-12 06:25:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, NULL, 3, 'Off Location', 5, NULL, NULL, '6000000.00', '20210412133055', 'Cash', NULL, 'SUBMIT', '2021-04-12 06:30:55', '2021-04-12 06:31:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, NULL, 3, 'Off Location', 5, NULL, NULL, '2050000.00', '20210412134256', 'Cash', NULL, 'SUBMIT', '2021-04-12 06:42:56', '2021-04-12 06:43:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, NULL, 3, 'Off Location', 5, NULL, NULL, '6012500.00', '20210412135156', 'Cash', NULL, 'SUBMIT', '2021-04-12 06:51:56', '2021-04-12 06:53:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, NULL, 3, 'Off Location', 5, NULL, NULL, '4715000.00', '20210412144645', 'Cash', NULL, 'SUBMIT', '2021-04-12 07:46:45', '2021-04-12 07:48:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, NULL, 3, 'Off Location', 5, NULL, NULL, '8336250.00', '20210412150637', 'Cash', NULL, 'SUBMIT', '2021-04-12 08:06:37', '2021-04-12 08:08:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, NULL, 3, 'Off Location', 5, NULL, NULL, '7370000.00', '20210412153054', 'Cash', NULL, 'SUBMIT', '2021-04-12 08:30:54', '2021-04-12 08:33:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, NULL, 3, 'Off Location', 5, NULL, NULL, '4025000.00', '20210412155007', 'Cash', NULL, 'SUBMIT', '2021-04-12 08:50:07', '2021-04-12 08:50:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, NULL, 3, 'Off Location', 5, NULL, NULL, '3006250.00', '20210412161655', 'Cash', NULL, 'SUBMIT', '2021-04-12 09:16:55', '2021-04-12 09:17:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, NULL, 3, 'Off Location', 5, NULL, NULL, '6330750.00', '20210412162010', 'Cash', NULL, 'SUBMIT', '2021-04-12 09:20:10', '2021-04-29 16:15:32', '2021-04-21 08:11:00', '2021-04-21 08:12:43', '2021-04-29 16:15:32', NULL, NULL, NULL, NULL, NULL),
(118, NULL, 3, 'Off Location', 5, NULL, NULL, '740000.00', '20210518113828', 'Cash', NULL, 'SUBMIT', '2021-05-18 04:38:28', '2021-05-27 17:23:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, NULL, 3, 'Off Location', 5, NULL, NULL, '620000.00', '20210528003835', 'Cash', NULL, 'SUBMIT', '2021-05-27 17:38:35', '2021-05-28 03:25:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 1, 31, 'Off Location', 2, NULL, NULL, '300000.00', '20210614161634', 'Cash', NULL, 'SUBMIT', '2021-06-14 09:16:34', '2021-06-14 09:17:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 1, 31, 'Off Location', 2, NULL, NULL, '758400.00', '20210614110758', 'Cash', NULL, 'SUBMIT', '2021-06-14 04:07:58', '2021-06-14 08:56:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 1, 31, 'Off Location', 2, NULL, NULL, '252800.00', '20210614163042', 'Cash', NULL, 'SUBMIT', '2021-06-14 09:30:42', '2021-06-14 09:30:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 1, 31, 'Off Location', 2, NULL, NULL, '433920.00', '20210614164856', 'Cash', NULL, 'SUBMIT', '2021-06-14 09:48:56', '2021-06-14 09:49:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 1, 31, 'Off Location', 2, NULL, NULL, '1280000.00', '20210614170256', 'Cash', NULL, 'SUBMIT', '2021-06-14 10:02:56', '2021-06-14 10:03:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 1, 31, 'Off Location', 2, NULL, NULL, '50000.00', '20210614172623', 'Cash', NULL, 'SUBMIT', '2021-06-14 10:26:23', '2021-06-14 10:27:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 1, 31, 'On Location', 517, NULL, NULL, '300000.00', '20210614172844', 'Cash', NULL, 'SUBMIT', '2021-06-14 10:28:44', '2021-06-14 10:52:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 1, 31, 'Off Location', 2, NULL, NULL, '16860800.00', '20210615004227', 'TOP', NULL, 'SUBMIT', '2021-06-14 17:42:27', '2021-06-15 08:28:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 1, 31, 'On Location', 2, NULL, NULL, '2995200.00', '20210615154121', 'Cash', NULL, 'SUBMIT', '2021-06-15 08:41:21', '2021-06-15 08:42:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 1, 31, 'Off Location', 2, NULL, NULL, '20620799.95', '20210615212919', 'Cash', NULL, 'CANCEL', '2021-06-15 14:29:19', '2021-06-30 19:23:35', NULL, NULL, '2021-06-30 19:23:35', 'dddd', 29, NULL, NULL, NULL),
(132, 1, 31, 'Off Location', 2, NULL, NULL, '196000.00', '20210616105623', 'Cash', NULL, 'CANCEL', '2021-06-16 03:56:23', '2021-06-30 19:15:27', '2021-06-30 02:44:25', '2021-06-30 02:44:30', '2021-06-30 19:15:27', 'coba lagi dari admin', 29, NULL, NULL, NULL),
(133, 1, 3, 'On Location', 3, NULL, NULL, '6990080.00', '20210625091556', 'Cash', NULL, 'CANCEL', '2021-06-25 02:15:56', '2021-07-02 18:06:51', NULL, NULL, '2021-07-02 18:06:51', 'batal bos', 3, NULL, NULL, NULL),
(134, 1, 31, 'Off Location', 4, NULL, NULL, '300000.00', '20210701024734', 'Cash', NULL, 'CANCEL', '2021-06-30 19:47:34', '2021-06-30 19:50:30', NULL, NULL, '2021-06-30 19:50:30', 'test', 31, NULL, NULL, NULL),
(135, 1, 3, 'Off Location', 2, NULL, NULL, '2001920.00', '20210703005753', 'Cash', NULL, 'CANCEL', '2021-07-02 17:57:53', '2021-09-16 17:45:06', NULL, NULL, '2021-09-16 17:45:06', 'asdasdasdasdas', 3, NULL, NULL, NULL),
(136, 1, 3, 'Off Location', 55, NULL, NULL, '3196000.00', '20210710230321', 'Cash', NULL, 'CANCEL', '2021-07-10 16:03:21', '2021-09-16 17:27:50', NULL, NULL, '2021-09-16 17:27:50', 'Sangat Benar Berrro', 3, NULL, NULL, NULL),
(139, 1, 5, 'On Location', 518, NULL, NULL, '1440000.00', '20210712054912', 'Cash', NULL, 'CANCEL', '2021-07-11 22:49:12', '2021-07-12 02:31:57', NULL, NULL, '2021-07-12 02:31:57', 'test ach cancel', 5, NULL, NULL, NULL),
(141, 1, 5, 'Off Location', 518, NULL, NULL, '104640.00', '20210803101131', 'Cash', NULL, 'SUBMIT', '2021-08-03 03:11:31', '2021-08-03 03:11:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 1, 5, 'Off Location', 518, NULL, NULL, '480000.00', '20210803105055', 'Cash', NULL, 'SUBMIT', '2021-08-03 03:50:55', '2021-08-03 03:52:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 1, 5, 'Off Location', 518, NULL, NULL, '104640.00', '20210803105351', 'Cash', NULL, 'SUBMIT', '2021-08-03 03:53:51', '2021-08-03 03:54:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 1, 5, 'Off Location', 518, NULL, NULL, '752000.00', '20210803105629', 'Cash', NULL, 'SUBMIT', '2021-08-03 03:56:29', '2021-08-03 03:56:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 1, 5, 'Off Location', 518, NULL, NULL, '480000.00', '20210803105913', 'Cash', NULL, 'SUBMIT', '2021-08-03 03:59:13', '2021-08-03 03:59:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 1, 3, 'Off Location', 55, NULL, NULL, '17052800.00', '20210803112902', 'Cash', NULL, 'CANCEL', '2021-08-12 07:05:58', '2021-09-16 17:46:54', NULL, NULL, '2021-09-16 17:46:54', 'Bajingan', 3, NULL, NULL, NULL),
(147, 1, 3, 'On Location', 59, NULL, NULL, '480000.00', '20210816220507', 'Cash', NULL, 'CANCEL', '2021-08-23 03:14:26', '2021-09-16 17:43:34', NULL, NULL, '2021-09-16 17:43:34', 'adasdasdasd', 3, NULL, NULL, NULL),
(148, 1, 3, 'On Location', 59, NULL, NULL, '104640.00', '20210823101507', 'Cash', NULL, 'CANCEL', '2021-08-23 03:15:24', '2021-09-16 17:42:53', NULL, NULL, '2021-09-16 17:42:53', 'dfgdfhdfh', 3, NULL, NULL, NULL),
(149, 1, 3, 'On Location', 59, NULL, NULL, '7904640.00', '20210823101612', 'Cash', NULL, 'CANCEL', '2021-08-23 05:10:14', '2021-09-16 17:24:12', NULL, NULL, '2021-09-16 17:24:12', 'Sekali Lagi Baru Benar sekali', 3, NULL, NULL, NULL),
(150, 1, 3, 'Off Location', 55, NULL, NULL, '5844800.00', '20210823121143', 'Cash', NULL, 'CANCEL', '2021-08-23 06:05:18', '2021-09-16 17:16:53', NULL, NULL, '2021-09-16 17:16:53', 'INiBaru benar', 3, NULL, NULL, NULL),
(151, 1, 3, 'On Location', 59, NULL, NULL, '4885920.00', '20210823132230', 'Cash', NULL, 'CANCEL', '2021-08-23 06:23:24', '2021-09-16 17:02:06', NULL, NULL, '2021-09-16 17:02:06', 'lasldlasdasdasdasdadsasd', 3, NULL, NULL, NULL),
(152, 1, 3, 'On Location', 2, NULL, NULL, '3433920.00', '20210823134034', 'Cash', NULL, 'CANCEL', '2021-08-23 06:44:37', '2021-09-16 16:52:06', NULL, NULL, '2021-09-16 16:52:06', 'gggggggggggggggg', 3, NULL, NULL, NULL),
(153, 1, 3, 'On Location', 59, NULL, NULL, '433920.00', '20210823134744', 'Cash', NULL, 'CANCEL', '2021-08-23 06:47:50', '2021-09-16 17:40:43', NULL, NULL, '2021-09-16 17:40:43', 'Jajal Lagi', 3, NULL, NULL, NULL),
(154, 1, 3, 'On Location', 2, NULL, NULL, '3300000.00', '20210823134840', 'Cash', NULL, 'CANCEL', '2021-08-23 06:49:21', '2021-09-16 16:51:19', NULL, NULL, '2021-09-16 16:51:19', 'ffffffffffffffffffffffffffff', 3, NULL, NULL, NULL),
(155, 1, 3, 'On Location', 59, NULL, NULL, '12920000.00', '20210823135242', 'Cash', NULL, 'CANCEL', '2021-08-23 06:53:35', '2021-09-16 16:28:25', NULL, NULL, '2021-09-16 16:28:25', 'coba lagi test email', 3, NULL, NULL, NULL),
(156, 1, 3, 'On Location', 59, NULL, NULL, '4904640.00', '20210823150515', 'Cash', NULL, 'CANCEL', '2021-08-23 08:06:10', '2021-09-16 16:24:05', NULL, NULL, '2021-09-16 16:24:05', 'email test cancel', 3, NULL, NULL, NULL),
(157, 1, 3, 'On Location', 59, NULL, NULL, '5528000.00', '20210823152215', 'Cash', NULL, 'CANCEL', '2021-08-23 08:22:42', '2021-09-16 11:03:12', NULL, NULL, '2021-09-16 11:03:12', 'asdfasdfsadfsdfsdfsdfsdf sdfsdfsdffsd', 3, NULL, NULL, NULL),
(158, 1, 3, 'On Location', 59, NULL, NULL, '12575040.00', '20210823152332', 'Cash', NULL, 'CANCEL', '2021-08-23 08:24:51', '2021-09-16 11:01:55', NULL, NULL, '2021-09-16 11:01:55', 'sadfsdfsadfsdfsdfd', 3, NULL, NULL, NULL),
(159, 1, 3, 'Off Location', 2, NULL, NULL, '5056000.00', '20210823152808', 'Cash', NULL, 'CANCEL', '2021-08-23 08:28:27', '2021-09-16 11:00:38', NULL, NULL, '2021-09-16 11:00:38', 'sdfsdgdfgdfgdfg', 3, NULL, NULL, NULL),
(160, 1, 3, 'On Location', 2, NULL, NULL, '4179200.00', '20210823153705', 'Cash', NULL, 'CANCEL', '2021-08-23 08:37:55', '2021-09-16 10:46:44', NULL, NULL, '2021-09-16 10:46:44', 'efefsdfsdfsdfsdf', 3, NULL, NULL, NULL),
(161, 1, 3, 'On Location', 59, NULL, NULL, '4602400.00', '20210823154940', 'Cash', NULL, 'CANCEL', '2021-08-23 08:50:47', '2021-09-16 10:58:52', NULL, NULL, '2021-09-16 10:58:52', 'sdfsfsfsfsdf', 3, NULL, NULL, NULL),
(162, 1, 3, 'On Location', 59, NULL, NULL, '6560000.00', '20210823161345', 'Cash', NULL, 'CANCEL', '2021-08-23 09:14:20', '2021-09-16 10:57:55', NULL, NULL, '2021-09-16 10:57:55', 'sdfsdfsdfsdfsdf', 3, NULL, NULL, NULL),
(163, 1, 3, 'On Location', 55, NULL, NULL, '3446400.00', '20210823163844', 'Cash', NULL, 'CANCEL', '2021-08-23 09:39:08', '2021-09-16 10:56:43', NULL, NULL, '2021-09-16 10:56:43', 'sdfdfdgdg', 3, NULL, NULL, NULL),
(164, 1, 3, 'On Location', 59, NULL, NULL, '4152000.00', '20210823170751', 'Cash', NULL, 'CANCEL', '2021-08-23 10:08:14', '2021-09-16 10:27:37', NULL, NULL, '2021-09-16 10:27:37', 'sdfsdfsdfsdfsdf', 3, NULL, NULL, NULL),
(165, 1, 3, 'Off Location', 59, NULL, NULL, '3360000.00', '20210823172016', 'Cash', NULL, 'CANCEL', '2021-08-23 10:20:57', '2021-09-16 10:26:21', NULL, NULL, '2021-09-16 10:26:21', 'sdfsdfsdfsdf', 3, NULL, NULL, NULL),
(166, 1, 3, 'Off Location', 55, NULL, NULL, '7800000.00', '20210823172202', 'Cash', NULL, 'CANCEL', '2021-08-23 10:23:24', '2021-09-16 10:23:44', NULL, NULL, '2021-09-16 10:23:44', 'dfsdfsdfsdfsdf', 3, NULL, NULL, NULL),
(167, 1, 3, 'Off Location', 55, NULL, NULL, '6000000.00', '20210823174630', 'Cash', NULL, 'CANCEL', '2021-08-23 10:48:36', '2021-09-16 10:20:33', NULL, NULL, '2021-09-16 10:20:33', 'ASdasdasdasdas', 3, NULL, NULL, NULL),
(168, 1, 3, 'Off Location', 59, NULL, NULL, '3360000.00', '20210823174956', 'Cash', NULL, 'CANCEL', '2021-08-23 10:50:13', '2021-09-16 10:18:10', NULL, NULL, '2021-09-16 10:18:10', 'asdasdasdasd', 3, NULL, NULL, NULL),
(169, 1, 3, 'On Location', 59, NULL, NULL, '4800000.00', '20210823185038', 'Cash', NULL, 'CANCEL', '2021-08-23 11:51:07', '2021-08-26 16:02:39', NULL, NULL, '2021-08-26 16:02:39', 'test batal', 3, NULL, NULL, NULL),
(170, 1, 3, 'On Location', 59, NULL, NULL, '9948000.00', '20210823185801', 'Cash', NULL, 'CANCEL', '2021-08-23 11:58:52', '2021-08-26 16:08:54', NULL, NULL, '2021-08-26 16:08:54', 'test lagi', 3, NULL, NULL, NULL),
(171, 1, 3, 'Off Location', 2, NULL, NULL, '629920.00', '20210823190725', 'Cash', NULL, 'CANCEL', '2021-08-23 12:07:34', '2021-09-16 10:17:09', NULL, NULL, '2021-09-16 10:17:09', 'ASDASFASDFSDF', 3, NULL, NULL, NULL),
(172, 1, 3, 'Off Location', 2, NULL, NULL, '1713920.00', '20210823192401', 'Cash', 'test', 'FINISH', '2021-08-23 12:24:16', '2021-08-26 14:00:35', NULL, '2021-08-26 14:00:35', NULL, NULL, NULL, NULL, NULL, NULL),
(173, 1, 3, 'On Location', 59, NULL, NULL, '2032000.00', '20210823193606', 'Cash', NULL, 'PROCESS', '2021-08-24 10:46:39', '2021-08-26 14:00:22', '2021-08-26 14:00:22', NULL, NULL, NULL, NULL, 2, NULL, NULL),
(174, 1, 3, 'On Location', 521, NULL, NULL, '433920.00', '20210825120053', 'Cash', NULL, 'CANCEL', '2021-08-25 05:01:02', '2021-09-16 10:13:07', NULL, NULL, '2021-09-16 10:13:07', 'asdasdasdasdasd', 3, NULL, NULL, NULL),
(175, 1, 3, 'Off Location', 2, NULL, NULL, '1305440.00', '20210826160729', 'Cash', NULL, 'CANCEL', '2021-09-03 09:03:59', '2021-09-16 10:10:22', NULL, NULL, '2021-09-16 10:10:22', 'asdasdasdasd', 3, NULL, NULL, NULL),
(176, 1, 3, 'On Location', 2, NULL, NULL, '0.00', '20210826203337', NULL, NULL, 'NO-ORDER', '2021-08-26 13:33:37', '2021-08-26 13:33:37', NULL, NULL, NULL, NULL, NULL, 2, 'Tidak mau membeli barang', NULL),
(177, 1, 3, 'On Location', 2, NULL, NULL, '0.00', '20210826214711', NULL, NULL, 'NO-ORDER', '2021-08-26 14:47:11', '2021-08-26 14:47:11', NULL, NULL, NULL, NULL, NULL, 3, 'ok habis', NULL),
(178, 1, 3, 'On Location', 2, NULL, NULL, '0.00', '20210826215635', NULL, NULL, 'NO-ORDER', '2021-08-26 14:56:35', '2021-08-26 14:56:35', NULL, NULL, NULL, NULL, NULL, 3, 'ok sip', NULL),
(179, 1, 3, 'Off Location', 59, NULL, NULL, '104640.00', '20210903161647', 'Cash', NULL, 'CANCEL', '2021-09-03 09:16:53', '2021-09-16 10:09:09', NULL, NULL, '2021-09-16 10:09:09', 'asdffasfdasfsadf', 3, NULL, NULL, NULL),
(180, 1, 3, 'Off Location', 59, NULL, NULL, '288000.00', '20210903161856', 'Cash', NULL, 'CANCEL', '2021-09-03 09:19:02', '2021-09-16 09:50:58', NULL, NULL, '2021-09-16 09:50:58', 'ASDAsdasdasd', 3, NULL, NULL, NULL),
(181, 1, 3, 'Off Location', 2, NULL, NULL, '1280000.00', '20210903162018', 'Cash', NULL, 'CANCEL', '2021-09-03 09:20:24', '2021-09-16 09:55:03', NULL, NULL, '2021-09-16 09:55:03', 'sdgsdgsdgdsfg', 3, NULL, NULL, NULL),
(182, 1, 3, 'Off Location', 2, NULL, NULL, '240000.00', '20210903162131', 'Cash', NULL, 'CANCEL', '2021-09-03 09:21:37', '2021-09-16 09:44:08', NULL, NULL, '2021-09-16 09:44:08', 'fghgjklkjllk;', 3, NULL, NULL, NULL),
(183, 1, 3, 'Off Location', 2, NULL, NULL, '480000.00', '20210903162309', 'Cash', NULL, 'CANCEL', '2021-09-03 09:23:17', '2021-09-16 09:42:13', NULL, NULL, '2021-09-16 09:42:13', 'dfgdfgdfgf', 3, NULL, NULL, NULL),
(184, 1, 3, 'Off Location', 2, NULL, NULL, '1196160.00', '20210903162613', 'Cash', NULL, 'CANCEL', '2021-09-03 09:26:38', '2021-09-16 09:38:46', NULL, NULL, '2021-09-16 09:38:46', 'tes batal email', 3, NULL, NULL, NULL),
(185, 1, 3, 'Off Location', 2, NULL, NULL, '1199840.00', '20210903165538', 'Cash', NULL, 'CANCEL', '2021-09-03 09:55:53', '2021-09-16 09:30:05', NULL, NULL, '2021-09-16 09:30:05', 'test email', 3, NULL, NULL, NULL),
(186, 1, 3, 'On Location', 59, NULL, NULL, '0.00', '20210906100454', NULL, NULL, 'NO-ORDER', '2021-09-06 03:04:54', '2021-09-06 03:04:54', NULL, NULL, NULL, NULL, NULL, 3, 'ok-insert no-order-product', NULL),
(187, 1, 3, 'On Location', 2, NULL, NULL, '0.00', '20210906100604', NULL, NULL, 'NO-ORDER', '2021-09-06 03:06:04', '2021-09-06 03:06:04', NULL, NULL, NULL, NULL, NULL, 3, 'cek yang kedua no order', NULL),
(188, 1, 3, 'On Location', 524, NULL, NULL, '0.00', '20210907173557', NULL, NULL, 'NO-ORDER', '2021-09-07 10:35:57', '2021-09-07 10:35:57', NULL, NULL, NULL, NULL, NULL, 3, 'ok habis', NULL),
(190, 1, 3, 'Off Location', 2, NULL, NULL, '3000000.00', '20210916225503', 'Cash', NULL, 'CANCEL', '2021-09-16 15:55:21', '2021-09-16 16:23:16', NULL, NULL, '2021-09-16 16:23:16', 'batal pesan email', 3, NULL, NULL, NULL),
(191, 1, 3, 'Off Location', 59, NULL, NULL, '252800.00', '20210917012057', 'Cash', NULL, 'CANCEL', '2021-09-16 18:21:01', '2021-09-16 18:21:22', NULL, NULL, '2021-09-16 18:21:22', 'test batal', 3, NULL, NULL, NULL),
(192, 1, 3, 'Off Location', 59, NULL, NULL, '480000.00', '20210917012432', 'Cash', NULL, 'CANCEL', '2021-09-16 18:24:36', '2021-09-16 18:24:59', NULL, NULL, '2021-09-16 18:24:59', 'batal lagi', 3, NULL, NULL, NULL),
(193, 1, 3, 'Off Location', 59, NULL, NULL, '300000.00', '20210920092322', 'Cash', NULL, 'SUBMIT', '2021-09-20 02:23:27', '2021-09-20 02:23:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 1, 3, 'Off Location', 525, NULL, NULL, '2736000.00', '20210928204546', 'Cash', NULL, 'SUBMIT', '2021-09-28 13:46:48', '2021-09-28 13:46:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 1, 3, 'On Location', 526, NULL, NULL, '673920.00', '20210929103053', 'Cash', NULL, 'SUBMIT', '2021-09-29 03:31:13', '2021-09-29 03:31:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 1, 3, 'Off Location', 525, NULL, NULL, '4800000.00', '20210929114715', 'Cash', NULL, 'SUBMIT', '2021-09-29 04:49:27', '2021-09-29 04:49:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 1, 3, 'Off Location', 526, NULL, NULL, '4800000.00', '20210929124559', 'Cash', NULL, 'SUBMIT', '2021-09-29 05:46:16', '2021-09-29 05:46:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 1, 3, 'Off Location', 2, NULL, NULL, '4800000.00', '20211001152106', 'Cash', NULL, 'SUBMIT', '2021-10-01 08:21:28', '2021-10-01 08:21:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 1, 3, 'Off Location', 525, NULL, NULL, '4800000.00', '20211001152419', 'Cash', NULL, 'FINISH', '2022-01-02 08:24:37', '2021-10-01 08:25:09', NULL, '2022-01-03 07:33:30', NULL, NULL, NULL, NULL, NULL, NULL),
(200, 1, 5, 'Off Location', 562, NULL, NULL, '288000.00', '20211018100339', 'Cash', NULL, 'SUBMIT', '2022-01-02 03:03:45', '2021-10-18 03:03:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 1, 5, 'Off Location', 563, NULL, NULL, '0.00', '20211018105132', NULL, NULL, 'NO-ORDER', '2021-10-18 03:51:32', '2021-10-18 03:51:32', NULL, NULL, NULL, NULL, NULL, 2, 'new toko error', NULL),
(202, 1, 5, 'Off Location', 482, NULL, NULL, '12800000.00', '20211018142511', 'Cash', NULL, 'SUBMIT', '2021-10-18 07:25:16', '2021-10-18 07:25:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 1, 5, 'Off Location', 525, NULL, NULL, '1260000.00', '20211026092022', 'Cash', NULL, 'SUBMIT', '2021-10-26 07:36:18', '2021-10-26 07:36:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 1, 5, 'Off Location', 525, NULL, NULL, '1440000.00', '20211026144139', 'Cash', NULL, 'FINISH', '2021-10-26 07:41:46', '2021-10-26 07:43:11', NULL, '2021-10-26 07:43:11', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 1, 5, 'Off Location', 482, NULL, NULL, '1064640.00', '20211027163246', 'Cash', NULL, 'FINISH', '2021-10-28 16:43:54', '2021-10-28 16:45:06', NULL, '2021-10-28 16:45:06', NULL, NULL, NULL, NULL, NULL, NULL),
(206, 1, 5, 'Off Location', 525, NULL, NULL, '5100000.00', '20211102175625', 'Cash', NULL, 'SUBMIT', '2021-11-04 08:51:18', '2021-11-04 08:51:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 1, 5, 'Off Location', 525, NULL, NULL, '0.00', '20211104134743', NULL, NULL, 'NO-ORDER', '2021-11-04 06:47:43', '2021-11-04 06:47:43', NULL, NULL, NULL, NULL, NULL, 2, 'Tidak mau membeli karena stok masih banyak', NULL),
(208, 1, 5, 'Off Location', 421, NULL, NULL, '0.00', '20211105100703', NULL, NULL, 'NO-ORDER', '2021-11-05 03:07:03', '2021-11-05 03:07:03', NULL, NULL, NULL, NULL, NULL, 2, 'sdfsdfsdfsdf', NULL),
(209, 1, 5, 'Off Location', 482, NULL, NULL, '496000.00', '20211109141837', 'Cash', NULL, 'SUBMIT', '2021-11-09 07:18:50', '2021-11-09 07:18:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 1, 5, 'Off Location', 525, NULL, NULL, '433920.00', '20211112165109', 'Cash', NULL, 'FINISH', '2021-11-15 04:09:05', '2021-11-15 04:10:27', NULL, '2021-11-15 04:10:27', NULL, NULL, NULL, NULL, NULL, NULL),
(211, 1, 5, 'Off Location', 525, NULL, NULL, '1200000.00', '20211115114327', 'Cash', NULL, 'FINISH', '2021-10-15 09:32:15', '2021-11-15 09:33:54', NULL, '2021-10-15 09:33:54', NULL, NULL, NULL, NULL, NULL, NULL),
(212, 1, 5, 'Off Location', 525, NULL, NULL, '900000.00', '20211115205532', 'Cash', NULL, 'FINISH', '2021-11-15 14:13:03', '2021-11-15 14:14:11', NULL, '2021-11-15 14:14:11', NULL, NULL, NULL, NULL, NULL, NULL),
(256, 1, 5, 'Off Location', 525, NULL, NULL, '3803520.00', '20211123224015', 'Cash', NULL, 'SUBMIT', '2021-11-23 17:44:27', '2021-11-23 17:44:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 1, 5, 'Off Location', 525, NULL, NULL, '1301760.00', '20211118100512', 'Cash', NULL, 'FINISH', '2021-11-18 03:05:22', '2021-11-18 03:05:53', NULL, '2021-11-18 03:05:53', NULL, NULL, NULL, NULL, NULL, NULL),
(257, 1, 5, 'Off Location', 525, NULL, NULL, '750000.00', '20211124004859', 'Cash', NULL, 'SUBMIT', '2021-11-23 18:10:51', '2021-11-23 18:10:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 1, 5, 'Off Location', 525, NULL, NULL, '6071040.00', '20211126132520', 'Cash', NULL, 'SUBMIT', '2021-11-26 06:26:02', '2021-11-26 06:26:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 1, 5, 'Off Location', 525, NULL, NULL, '6942720.00', '20211126133218', 'Cash', NULL, 'FINISH', '2021-11-26 06:39:41', '2021-11-26 09:16:34', NULL, '2021-11-26 09:16:34', NULL, NULL, NULL, NULL, NULL, NULL),
(263, 1, 5, 'Off Location', 525, NULL, NULL, '9840960.00', '20211129100952', 'Cash', NULL, 'SUBMIT', '2021-11-30 08:31:35', '2021-11-30 08:31:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 1, 3, 'On Location', 55, NULL, NULL, '0.00', '20211213005205', NULL, NULL, 'SUBMIT', '2021-12-12 17:52:05', '2021-12-12 17:52:05', NULL, NULL, NULL, NULL, NULL, 2, 'asfsafsf', NULL),
(268, 1, 5, 'Off Location', 482, NULL, NULL, '960000.00', '20220101025837', 'Cash', NULL, 'SUBMIT', '2022-01-01 19:11:58', '2022-01-01 19:11:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 1, 5, 'Off Location', 482, NULL, NULL, '4205280.00', '20220102152442', 'Cash', NULL, 'SUBMIT', '2022-01-02 08:25:56', '2022-01-15 17:42:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 1, 5, 'Off Location', 2, NULL, NULL, '4773120.00', '20220103130903', 'Cash', NULL, 'FINISH', '2022-01-10 17:31:51', '2022-01-26 18:31:02', '2022-01-26 18:29:08', '2022-01-26 18:31:02', NULL, NULL, NULL, NULL, NULL, 'adaDad'),
(271, 1, 5, 'Off Location', 525, NULL, NULL, '4500000.00', '20220111102941', 'Cash', NULL, 'FINISH', '2022-01-31 16:01:11', '2022-01-12 16:02:07', NULL, '2022-02-15 16:02:07', NULL, NULL, NULL, NULL, NULL, NULL),
(289, 1, 5, 'Off Location', 2, NULL, NULL, '19600000.00', '20220118155314', 'Cash', NULL, 'PARTIAL-SHIPMENT', '2022-01-18 08:53:28', '2022-01-20 04:47:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asfdaf'),
(306, 1, 5, 'Off Location', 2, NULL, NULL, '3000000.00', '20220120131552', 'Cash', NULL, 'PARTIAL-SHIPMENT', '2022-01-20 06:15:58', '2022-01-20 10:19:20', '2022-01-20 10:05:49', '2022-01-20 10:06:38', NULL, NULL, NULL, NULL, NULL, 'kurang'),
(312, 1, 5, 'Off Location', 421, NULL, NULL, '300000.00', '20220124161204', 'Cash', NULL, 'SUBMIT', '2022-01-24 09:12:10', '2022-01-24 09:12:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 1, 5, 'Off Location', 2, NULL, NULL, '300000.00', '20220124161401', 'Cash', NULL, 'SUBMIT', '2022-01-24 09:14:07', '2022-01-24 09:14:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 1, 5, 'Off Location', 565, NULL, NULL, '1280000.00', '20220124162253', 'Cash', NULL, 'SUBMIT', '2022-01-24 09:22:58', '2022-01-24 09:22:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(316, 1, 5, 'Off Location', 2, NULL, NULL, '3000000.00', '20220124164343', 'Cash', NULL, 'SUBMIT', '2022-01-25 09:28:45', '2022-01-25 09:28:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(317, 1, 5, 'Off Location', 525, NULL, NULL, '7840000.00', '20220125172847', 'Cash', NULL, 'PARTIAL-SHIPMENT', '2022-01-25 10:29:29', '2022-01-25 10:49:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dites');

-- --------------------------------------------------------

--
-- Table structure for table `order_paket_tmp`
--

CREATE TABLE `order_paket_tmp` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price_item` double(8,2) DEFAULT NULL,
  `price_item_promo` double(8,2) DEFAULT NULL,
  `discount_item` double(8,2) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `paket_id` int(10) UNSIGNED DEFAULT NULL,
  `bonus_cat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` int(10) UNSIGNED NOT NULL,
  `preorder` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price_item` double(11,2) DEFAULT NULL,
  `price_item_promo` double(11,2) DEFAULT NULL,
  `vol_disc_price` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_item` double(11,2) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `paket_id` int(10) UNSIGNED DEFAULT NULL,
  `bonus_cat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` int(10) UNSIGNED NOT NULL,
  `preorder` int(10) UNSIGNED NOT NULL,
  `deliveryQty` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `price_item`, `price_item_promo`, `vol_disc_price`, `discount_item`, `quantity`, `created_at`, `updated_at`, `group_id`, `paket_id`, `bonus_cat`, `available`, `preorder`, `deliveryQty`) VALUES
(1, 1, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-02-25 03:12:32', '2021-02-25 03:12:32', NULL, NULL, NULL, 0, 0, NULL),
(3, 2, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-02-25 04:57:21', '2021-02-25 04:57:21', NULL, NULL, NULL, 0, 0, NULL),
(4, 2, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-02-25 05:03:22', '2021-02-25 05:03:22', NULL, NULL, NULL, 0, 0, NULL),
(5, 3, 1, 117000.00, 117000.00, 0.00, 0.00, 10, '2021-02-25 07:00:28', '2021-02-25 07:00:28', NULL, NULL, NULL, 0, 0, NULL),
(6, 4, 1, 117000.00, 117000.00, 0.00, 0.00, 10, '2021-02-25 07:05:54', '2021-02-25 07:05:54', NULL, NULL, NULL, 0, 0, NULL),
(7, 5, 1, 117000.00, 117000.00, 0.00, 0.00, 12, '2021-02-25 07:07:37', '2021-02-25 07:30:58', NULL, NULL, NULL, 0, 0, NULL),
(8, 6, 1, 117000.00, 117000.00, 0.00, 0.00, 2, '2021-02-25 07:08:03', '2021-02-25 07:08:03', NULL, NULL, NULL, 0, 0, NULL),
(9, 7, 1, 117000.00, 117000.00, 0.00, 0.00, 10, '2021-02-25 07:12:34', '2021-02-25 07:12:34', NULL, NULL, NULL, 0, 0, NULL),
(10, 5, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-02-25 07:31:05', '2021-02-25 07:31:05', NULL, NULL, NULL, 0, 0, NULL),
(67, 23, 2, 459000.00, 459000.00, 0.00, 0.00, 2, '2021-02-26 06:50:52', '2021-02-26 06:50:52', NULL, NULL, NULL, 0, 0, NULL),
(12, 9, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-02-25 07:42:00', '2021-02-25 07:42:17', NULL, NULL, NULL, 0, 0, NULL),
(13, 9, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-02-25 07:42:03', '2021-02-25 07:42:03', NULL, NULL, NULL, 0, 0, NULL),
(14, 9, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-02-25 07:42:05', '2021-02-25 07:42:05', NULL, NULL, NULL, 0, 0, NULL),
(15, 9, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-02-25 07:42:07', '2021-02-25 07:42:07', NULL, NULL, NULL, 0, 0, NULL),
(16, 9, 5, 413750.00, 413750.00, 0.00, 0.00, 10, '2021-02-25 07:42:11', '2021-02-25 07:42:11', NULL, NULL, NULL, 0, 0, NULL),
(17, 10, 1, 117000.00, 117000.00, 0.00, 0.00, 28, '2021-02-25 08:15:59', '2021-02-25 10:24:02', NULL, NULL, NULL, 0, 0, NULL),
(33, 11, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-02-25 10:29:46', '2021-02-25 10:29:46', NULL, NULL, NULL, 0, 0, NULL),
(19, 10, 3, 682500.00, 682500.00, 0.00, 0.00, 12, '2021-02-25 08:17:19', '2021-02-25 10:24:07', NULL, NULL, NULL, 0, 0, NULL),
(20, 10, 4, 624000.00, 624000.00, 0.00, 0.00, 41, '2021-02-25 08:17:24', '2021-02-25 10:24:07', NULL, NULL, NULL, 0, 0, NULL),
(21, 10, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-02-25 08:19:45', '2021-02-25 08:19:45', NULL, NULL, NULL, 0, 0, NULL),
(22, 10, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-02-25 08:19:46', '2021-02-25 08:19:46', NULL, NULL, NULL, 0, 0, NULL),
(65, 23, 9, 516250.00, 516250.00, 0.00, 0.00, 7, '2021-02-26 06:05:32', '2021-02-26 07:11:27', NULL, NULL, NULL, 0, 0, NULL),
(66, 23, 5, 413750.00, 413750.00, 0.00, 0.00, 9, '2021-02-26 06:11:41', '2021-02-26 07:12:20', NULL, NULL, NULL, 0, 0, NULL),
(62, 21, 27, 600000.00, 600000.00, 0.00, 0.00, 2, '2021-02-26 04:54:54', '2021-02-26 04:54:54', NULL, NULL, NULL, 0, 0, NULL),
(32, 10, 6, 624000.00, 624000.00, 0.00, 0.00, 30, '2021-02-25 10:24:06', '2021-02-25 10:24:06', NULL, NULL, NULL, 0, 0, NULL),
(35, 13, 18, 296250.00, 296250.00, 0.00, 0.00, 30, '2021-02-25 10:33:30', '2021-02-25 10:33:30', NULL, NULL, NULL, 0, 0, NULL),
(36, 13, 6, 624000.00, 624000.00, 0.00, 0.00, 30, '2021-02-25 10:33:55', '2021-02-25 10:33:55', NULL, NULL, NULL, 0, 0, NULL),
(61, 21, 11, 235000.00, 235000.00, 0.00, 0.00, 27, '2021-02-26 04:54:24', '2021-02-26 04:54:31', NULL, NULL, NULL, 0, 0, NULL),
(478, 139, 13, 288000.00, 288000.00, 0.00, 0.00, 1, '2021-07-11 22:49:12', '2021-07-11 22:49:12', NULL, NULL, NULL, 0, 0, NULL),
(477, 138, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-07-11 20:06:45', '2021-07-11 20:06:45', NULL, NULL, NULL, 0, 0, NULL),
(58, 19, 1, 117000.00, 117000.00, 0.00, 0.00, 5, '2021-02-26 03:31:33', '2021-02-26 03:31:40', NULL, NULL, NULL, 0, 0, NULL),
(57, 19, 2, 459000.00, 459000.00, 0.00, 0.00, 2, '2021-02-26 03:31:16', '2021-02-26 03:31:16', NULL, NULL, NULL, 0, 0, NULL),
(68, 23, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-02-26 06:50:59', '2021-02-26 06:50:59', NULL, NULL, NULL, 0, 0, NULL),
(70, 23, 1, 117000.00, 117000.00, 0.00, 0.00, 101, '2021-02-26 07:04:56', '2021-02-26 07:05:31', NULL, NULL, NULL, 0, 0, NULL),
(101, 40, 5, 413750.00, 413750.00, 0.00, 0.00, 18, '2021-03-01 01:28:50', '2021-03-01 01:28:50', NULL, NULL, NULL, 0, 0, NULL),
(100, 40, 8, 413750.00, 413750.00, 0.00, 0.00, 12, '2021-03-01 01:28:46', '2021-03-01 01:28:46', NULL, NULL, NULL, 0, 0, NULL),
(104, 41, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-01 09:38:26', '2021-03-01 09:38:26', NULL, NULL, NULL, 0, 0, NULL),
(96, 38, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-02-28 13:44:16', '2021-02-28 13:44:16', NULL, NULL, NULL, 0, 0, NULL),
(102, 20, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-03-01 03:37:14', '2021-03-01 03:37:14', NULL, NULL, NULL, 0, 0, NULL),
(105, 42, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-03-01 09:48:29', '2021-03-01 09:48:29', NULL, NULL, NULL, 0, 0, NULL),
(106, 43, 27, 600000.00, 600000.00, 0.00, 0.00, 1, '2021-03-01 10:02:11', '2021-03-01 10:02:11', NULL, NULL, NULL, 0, 0, NULL),
(107, 44, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-01 10:11:50', '2021-03-01 10:11:50', NULL, NULL, NULL, 0, 0, NULL),
(109, 46, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-03-03 04:26:06', '2021-03-03 04:26:06', NULL, NULL, NULL, 0, 0, NULL),
(110, 46, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-03 04:26:07', '2021-03-03 04:26:07', NULL, NULL, NULL, 0, 0, NULL),
(111, 47, 2, 459000.00, 459000.00, 0.00, 0.00, 21, '2021-03-03 04:30:48', '2021-03-04 03:36:14', NULL, NULL, NULL, 0, 0, NULL),
(112, 47, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-03-03 04:30:50', '2021-03-03 04:30:50', NULL, NULL, NULL, 0, 0, NULL),
(113, 47, 4, 624000.00, 624000.00, 0.00, 0.00, 2, '2021-03-03 04:30:53', '2021-03-03 04:30:53', NULL, NULL, NULL, 0, 0, NULL),
(114, 48, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-03-03 04:36:43', '2021-03-03 04:36:43', NULL, NULL, NULL, 0, 0, NULL),
(115, 40, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-03 07:01:00', '2021-03-03 07:01:00', NULL, NULL, NULL, 0, 0, NULL),
(116, 48, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-04 02:37:20', '2021-03-04 02:37:20', NULL, NULL, NULL, 0, 0, NULL),
(117, 49, 1, 117000.00, 117000.00, 0.00, 0.00, 2, '2021-03-04 03:22:52', '2021-03-04 03:22:52', NULL, NULL, NULL, 0, 0, NULL),
(118, 50, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-04 03:23:33', '2021-03-04 03:23:33', NULL, NULL, NULL, 0, 0, NULL),
(119, 51, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-03-04 09:58:31', '2021-03-04 09:58:31', NULL, NULL, NULL, 0, 0, NULL),
(120, 51, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-04 13:02:24', '2021-03-04 13:02:24', NULL, NULL, NULL, 0, 0, NULL),
(121, 51, 18, 296250.00, 296250.00, 0.00, 0.00, 1, '2021-03-04 13:07:18', '2021-03-04 13:07:18', NULL, NULL, NULL, 0, 0, NULL),
(134, 54, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-05 07:20:35', '2021-03-05 07:20:35', NULL, NULL, NULL, 0, 0, NULL),
(123, 52, 3, 682500.00, 682500.00, 0.00, 0.00, 7, '2021-03-04 23:18:29', '2021-03-05 05:32:14', NULL, NULL, NULL, 0, 0, NULL),
(124, 52, 5, 413750.00, 413750.00, 0.00, 0.00, 2, '2021-03-04 23:18:32', '2021-03-05 05:32:17', NULL, NULL, NULL, 0, 0, NULL),
(125, 53, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-03-05 02:50:39', '2021-03-05 02:50:39', NULL, NULL, NULL, 0, 0, NULL),
(126, 53, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-05 02:50:41', '2021-03-05 02:50:41', NULL, NULL, NULL, 0, 0, NULL),
(127, 53, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-03-05 02:50:43', '2021-03-05 02:50:43', NULL, NULL, NULL, 0, 0, NULL),
(128, 54, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-05 03:02:24', '2021-03-05 03:02:24', NULL, NULL, NULL, 0, 0, NULL),
(129, 54, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-03-05 03:02:24', '2021-03-05 03:02:24', NULL, NULL, NULL, 0, 0, NULL),
(130, 52, 2, 459000.00, 459000.00, 0.00, 0.00, 3, '2021-03-05 05:03:17', '2021-03-05 05:32:12', NULL, NULL, NULL, 0, 0, NULL),
(131, 52, 11, 235000.00, 235000.00, 0.00, 0.00, 2, '2021-03-05 05:03:23', '2021-03-05 05:03:23', NULL, NULL, NULL, 0, 0, NULL),
(132, 52, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-05 05:32:15', '2021-03-05 05:32:15', NULL, NULL, NULL, 0, 0, NULL),
(133, 52, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-05 05:32:17', '2021-03-05 05:32:17', NULL, NULL, NULL, 0, 0, NULL),
(135, 55, 14, 940000.00, 940000.00, 0.00, 0.00, 1, '2021-03-05 10:43:12', '2021-03-05 10:43:12', NULL, NULL, NULL, 0, 0, NULL),
(141, 58, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-07 10:08:26', '2021-03-07 10:08:26', NULL, NULL, NULL, 0, 0, NULL),
(137, 56, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-07 08:40:17', '2021-03-07 08:40:17', NULL, NULL, NULL, 0, 0, NULL),
(140, 57, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-07 10:07:34', '2021-03-07 10:07:34', NULL, NULL, NULL, 0, 0, NULL),
(139, 56, 6, 624000.00, 624000.00, 0.00, 0.00, 2, '2021-03-07 08:45:19', '2021-03-07 08:45:19', NULL, NULL, NULL, 0, 0, NULL),
(142, 58, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-07 10:08:29', '2021-03-07 10:08:29', NULL, NULL, NULL, 0, 0, NULL),
(143, 59, 1, 117000.00, 117000.00, 0.00, 0.00, 2, '2021-03-07 10:09:50', '2021-03-07 10:09:53', NULL, NULL, NULL, 0, 0, NULL),
(144, 59, 2, 459000.00, 459000.00, 0.00, 0.00, 2, '2021-03-07 10:09:55', '2021-03-07 10:11:09', NULL, NULL, NULL, 0, 0, NULL),
(145, 60, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-07 10:12:01', '2021-03-07 10:12:01', NULL, NULL, NULL, 0, 0, NULL),
(146, 60, 2, 459000.00, 459000.00, 0.00, 0.00, 3, '2021-03-07 10:12:12', '2021-03-07 10:15:32', NULL, NULL, NULL, 0, 0, NULL),
(147, 60, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-07 10:12:15', '2021-03-07 10:12:15', NULL, NULL, NULL, 0, 0, NULL),
(148, 60, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-03-07 10:12:16', '2021-03-07 10:12:16', NULL, NULL, NULL, 0, 0, NULL),
(149, 60, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-03-07 10:12:17', '2021-03-07 10:12:17', NULL, NULL, NULL, 0, 0, NULL),
(150, 60, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-03-07 10:12:18', '2021-03-07 10:12:18', NULL, NULL, NULL, 0, 0, NULL),
(151, 60, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-03-07 10:12:20', '2021-03-07 10:12:20', NULL, NULL, NULL, 0, 0, NULL),
(152, 60, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-03-07 10:12:21', '2021-03-07 10:12:21', NULL, NULL, NULL, 0, 0, NULL),
(153, 61, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-07 10:23:47', '2021-03-07 10:23:47', NULL, NULL, NULL, 0, 0, NULL),
(154, 61, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-07 10:23:49', '2021-03-07 10:23:49', NULL, NULL, NULL, 0, 0, NULL),
(155, 62, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-08 01:17:25', '2021-03-08 01:17:25', NULL, NULL, NULL, 0, 0, NULL),
(156, 62, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-08 01:17:26', '2021-03-08 01:17:26', NULL, NULL, NULL, 0, 0, NULL),
(157, 63, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-03-08 01:28:08', '2021-03-08 01:28:08', NULL, NULL, NULL, 0, 0, NULL),
(158, 63, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-03-08 01:28:13', '2021-03-08 01:28:13', NULL, NULL, NULL, 0, 0, NULL),
(185, 72, 2, 459000.00, 459000.00, 0.00, 0.00, 5, '2021-04-05 10:49:43', '2021-04-05 10:53:15', NULL, NULL, NULL, 0, 0, NULL),
(188, 72, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-06 02:42:26', '2021-04-06 02:42:26', 1, 2, 'BONUS', 0, 0, NULL),
(189, 72, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-06 02:42:22', '2021-04-06 02:42:22', 1, 2, NULL, 0, 0, NULL),
(190, 73, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 06:07:32', '2021-04-06 06:07:32', NULL, NULL, NULL, 0, 0, NULL),
(191, 73, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 06:07:34', '2021-04-06 06:07:34', NULL, NULL, NULL, 0, 0, NULL),
(192, 74, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 06:08:07', '2021-04-06 06:08:07', NULL, NULL, NULL, 0, 0, NULL),
(193, 74, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 06:08:10', '2021-04-06 06:08:10', NULL, NULL, NULL, 0, 0, NULL),
(194, 74, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-06 06:08:13', '2021-04-06 06:08:13', NULL, NULL, NULL, 0, 0, NULL),
(195, 74, 14, 940000.00, 940000.00, 0.00, 0.00, 1, '2021-04-06 06:08:17', '2021-04-06 06:08:17', NULL, NULL, NULL, 0, 0, NULL),
(196, 75, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 06:09:11', '2021-04-06 06:09:11', NULL, NULL, NULL, 0, 0, NULL),
(197, 75, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 06:09:15', '2021-04-06 06:09:15', NULL, NULL, NULL, 0, 0, NULL),
(198, 75, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-06 06:09:17', '2021-04-06 06:09:17', NULL, NULL, NULL, 0, 0, NULL),
(199, 76, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-06 07:52:45', '2021-04-06 07:52:45', NULL, NULL, NULL, 0, 0, NULL),
(200, 76, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 07:53:48', '2021-04-06 07:53:48', NULL, NULL, NULL, 0, 0, NULL),
(201, 76, 6, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-06 07:53:53', '2021-04-06 07:53:53', NULL, NULL, NULL, 0, 0, NULL),
(202, 77, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-06 07:57:33', '2021-04-06 07:57:33', NULL, NULL, NULL, 0, 0, NULL),
(203, 77, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 07:57:35', '2021-04-06 07:57:35', NULL, NULL, NULL, 0, 0, NULL),
(204, 78, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-06 08:07:21', '2021-04-06 08:07:21', NULL, NULL, NULL, 0, 0, NULL),
(205, 78, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 08:07:23', '2021-04-06 08:07:23', NULL, NULL, NULL, 0, 0, NULL),
(206, 79, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 08:08:45', '2021-04-06 08:08:45', NULL, NULL, NULL, 0, 0, NULL),
(207, 79, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-06 08:08:48', '2021-04-06 08:08:48', NULL, NULL, NULL, 0, 0, NULL),
(208, 80, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 08:10:06', '2021-04-06 08:10:06', NULL, NULL, NULL, 0, 0, NULL),
(209, 80, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-06 08:10:07', '2021-04-06 08:10:07', NULL, NULL, NULL, 0, 0, NULL),
(210, 81, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-06 08:10:41', '2021-04-06 08:10:41', NULL, NULL, NULL, 0, 0, NULL),
(211, 82, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-06 08:34:49', '2021-04-06 08:34:49', NULL, NULL, NULL, 0, 0, NULL),
(239, 83, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-09 08:58:11', '2021-04-09 08:58:11', NULL, NULL, NULL, 0, 0, NULL),
(215, 83, 8, 413750.00, 413750.00, 0.00, 0.00, 4, '2021-04-07 16:20:01', '2021-04-09 08:54:53', 1, 2, 'BONUS', 0, 0, NULL),
(216, 83, 8, 413750.00, 413750.00, 0.00, 0.00, 30, '2021-04-07 16:19:57', '2021-04-07 16:21:49', 1, 2, NULL, 0, 0, NULL),
(221, 83, 8, 413750.00, 413750.00, 0.00, 0.00, 6, '2021-04-08 03:02:19', '2021-04-08 03:02:42', 1, 3, 'BONUS', 0, 0, NULL),
(222, 83, 7, 187500.00, 187500.00, 0.00, 0.00, 3, '2021-04-08 03:01:29', '2021-04-08 03:01:39', 1, 3, 'BONUS', 0, 0, NULL),
(223, 83, 8, 413750.00, 413750.00, 0.00, 0.00, 30, '2021-04-08 03:01:15', '2021-04-08 03:01:39', 1, 3, NULL, 0, 0, NULL),
(224, 83, 7, 187500.00, 187500.00, 0.00, 0.00, 60, '2021-04-08 03:02:07', '2021-04-08 03:02:42', 1, 3, NULL, 0, 0, NULL),
(225, 83, 5, 413750.00, 413750.00, 0.00, 0.00, 3, '2021-04-08 03:03:54', '2021-04-08 03:04:06', 4, 3, 'BONUS', 0, 0, NULL),
(226, 83, 2, 459000.00, 459000.00, 0.00, 0.00, 32, '2021-04-08 03:03:50', '2021-04-09 08:58:07', 4, 3, NULL, 0, 0, NULL),
(230, 83, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-09 06:20:48', '2021-04-09 06:22:58', 1, 2, NULL, 0, 0, NULL),
(231, 83, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-09 06:21:21', '2021-04-09 06:22:58', 1, 2, 'BONUS', 0, 0, NULL),
(233, 84, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-09 07:40:20', '2021-04-09 07:40:20', NULL, NULL, NULL, 0, 0, NULL),
(234, 84, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-09 07:40:39', '2021-04-09 07:40:46', 1, 2, NULL, 0, 0, NULL),
(235, 84, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-09 07:40:43', '2021-04-09 07:40:46', 1, 2, 'BONUS', 0, 0, NULL),
(236, 84, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-09 07:42:29', '2021-04-09 07:42:29', NULL, NULL, NULL, 0, 0, NULL),
(237, 85, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-09 08:24:30', '2021-04-09 08:24:30', NULL, NULL, NULL, 0, 0, NULL),
(240, 83, 19, 110000.00, 110000.00, 0.00, 0.00, 1, '2021-04-09 08:58:19', '2021-04-09 08:58:19', NULL, NULL, NULL, 0, 0, NULL),
(248, 86, 20, 205000.00, 205000.00, 0.00, 0.00, 10, '2021-04-09 09:41:44', '2021-04-09 09:44:26', 1, 2, NULL, 0, 0, NULL),
(245, 86, 11, 235000.00, 235000.00, 0.00, 0.00, 1, '2021-04-09 09:16:00', '2021-04-09 09:16:00', NULL, NULL, NULL, 0, 0, NULL),
(249, 86, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-09 09:44:22', '2021-04-09 09:44:26', 1, 2, 'BONUS', 0, 0, NULL),
(250, 86, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-09 09:45:57', '2021-04-09 09:45:57', NULL, NULL, NULL, 0, 0, NULL),
(288, 87, 2, 459000.00, 459000.00, 0.00, 0.00, 4, '2021-04-10 15:09:40', '2021-04-10 15:10:35', NULL, NULL, NULL, 0, 0, NULL),
(281, 87, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-10 14:39:34', '2021-04-10 14:39:41', 1, 2, NULL, 0, 0, NULL),
(280, 87, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-10 14:39:38', '2021-04-10 14:39:41', 1, 2, 'BONUS', 0, 0, NULL),
(287, 87, 4, 624000.00, 624000.00, 0.00, 0.00, 2, '2021-04-10 15:01:11', '2021-04-10 15:10:40', NULL, NULL, NULL, 0, 0, NULL),
(292, 88, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-10 18:07:04', '2021-04-10 18:07:04', NULL, NULL, NULL, 0, 0, NULL),
(293, 88, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-10 18:07:08', '2021-04-10 18:07:08', NULL, NULL, NULL, 0, 0, NULL),
(294, 89, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-10 18:11:30', '2021-04-10 18:11:30', NULL, NULL, NULL, 0, 0, NULL),
(295, 89, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-10 18:11:34', '2021-04-10 18:11:34', NULL, NULL, NULL, 0, 0, NULL),
(296, 90, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:32:04', '2021-04-12 03:32:04', NULL, NULL, NULL, 0, 0, NULL),
(297, 91, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-12 03:35:44', '2021-04-12 03:35:44', NULL, NULL, NULL, 0, 0, NULL),
(298, 92, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:38:55', '2021-04-12 03:39:09', NULL, NULL, NULL, 0, 0, NULL),
(299, 92, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-12 03:39:13', '2021-04-12 03:39:13', NULL, NULL, NULL, 0, 0, NULL),
(300, 93, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-12 03:41:26', '2021-04-12 03:41:26', NULL, NULL, NULL, 0, 0, NULL),
(301, 93, 4, 624000.00, 624000.00, 0.00, 0.00, 1, '2021-04-12 03:41:29', '2021-04-12 03:41:29', NULL, NULL, NULL, 0, 0, NULL),
(302, 94, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 03:44:24', '2021-04-12 03:44:24', NULL, NULL, NULL, 0, 0, NULL),
(303, 94, 11, 235000.00, 235000.00, 0.00, 0.00, 1, '2021-04-12 03:44:30', '2021-04-12 03:44:30', NULL, NULL, NULL, 0, 0, NULL),
(304, 95, 16, 296250.00, 296250.00, 0.00, 0.00, 1, '2021-04-12 03:49:07', '2021-04-12 03:49:07', NULL, NULL, NULL, 0, 0, NULL),
(305, 95, 18, 296250.00, 296250.00, 0.00, 0.00, 1, '2021-04-12 03:49:09', '2021-04-12 03:49:09', NULL, NULL, NULL, 0, 0, NULL),
(306, 96, 32, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:50:56', '2021-04-12 03:50:56', NULL, NULL, NULL, 0, 0, NULL),
(307, 96, 31, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:50:58', '2021-04-12 03:50:58', NULL, NULL, NULL, 0, 0, NULL),
(308, 97, 30, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:53:05', '2021-04-12 03:53:05', NULL, NULL, NULL, 0, 0, NULL),
(309, 97, 31, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 03:53:07', '2021-04-12 03:53:07', NULL, NULL, NULL, 0, 0, NULL),
(310, 98, 10, 580000.00, 580000.00, 0.00, 0.00, 2, '2021-04-12 03:54:33', '2021-04-12 03:56:32', 1, 2, 'BONUS', 0, 0, NULL),
(311, 98, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-12 03:54:21', '2021-04-12 03:55:01', 1, 2, NULL, 0, 0, NULL),
(312, 98, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-12 03:55:27', '2021-04-12 03:55:31', 4, 2, 'BONUS', 0, 0, NULL),
(313, 98, 2, 459000.00, 459000.00, 0.00, 0.00, 10, '2021-04-12 03:55:17', '2021-04-12 03:55:31', 4, 2, NULL, 0, 0, NULL),
(314, 98, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 03:56:29', '2021-04-12 03:56:29', NULL, NULL, NULL, 0, 0, NULL),
(315, 98, 18, 296250.00, 296250.00, 0.00, 0.00, 1, '2021-04-12 03:57:04', '2021-04-12 03:57:04', NULL, NULL, NULL, 0, 0, NULL),
(316, 99, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 04:07:02', '2021-04-12 04:07:02', NULL, NULL, NULL, 0, 0, NULL),
(317, 99, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 04:07:37', '2021-04-12 04:07:41', 4, 2, 'BONUS', 0, 0, NULL),
(318, 99, 2, 459000.00, 459000.00, 0.00, 0.00, 10, '2021-04-12 04:07:28', '2021-04-12 04:07:41', 4, 2, NULL, 0, 0, NULL),
(319, 100, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 04:16:28', '2021-04-12 04:16:32', 1, 2, 'BONUS', 0, 0, NULL),
(320, 100, 8, 413750.00, 413750.00, 0.00, 0.00, 10, '2021-04-12 04:16:17', '2021-04-12 04:16:32', 1, 2, NULL, 0, 0, NULL),
(321, 101, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 04:19:20', '2021-04-12 04:19:46', 1, 2, 'BONUS', 0, 0, NULL),
(322, 101, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-12 04:18:32', '2021-04-12 04:19:46', 1, 2, NULL, 0, 0, NULL),
(323, 102, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 04:35:12', '2021-04-12 04:35:18', 1, 2, 'BONUS', 0, 0, NULL),
(324, 102, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-12 04:34:50', '2021-04-12 04:35:18', 1, 2, NULL, 0, 0, NULL),
(325, 103, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 06:08:12', '2021-04-12 06:08:14', 1, 2, 'BONUS', 0, 0, NULL),
(326, 103, 8, 413750.00, 413750.00, 0.00, 0.00, 10, '2021-04-12 04:43:46', '2021-04-12 06:08:14', 1, 2, NULL, 0, 0, NULL),
(327, 104, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 06:13:10', '2021-04-12 06:13:12', 1, 2, 'BONUS', 0, 0, NULL),
(328, 104, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-12 06:12:55', '2021-04-12 06:13:12', 1, 2, NULL, 0, 0, NULL),
(329, 105, 3, 682500.00, 682500.00, 0.00, 0.00, 1, '2021-04-12 06:25:00', '2021-04-12 06:25:02', 5, 2, 'BONUS', 0, 0, NULL),
(330, 105, 3, 682500.00, 682500.00, 0.00, 0.00, 10, '2021-04-12 06:24:45', '2021-04-12 06:25:02', 5, 2, NULL, 0, 0, NULL),
(331, 106, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 06:31:05', '2021-04-12 06:31:07', 1, 2, 'BONUS', 0, 0, NULL),
(332, 106, 22, 600000.00, 600000.00, 0.00, 0.00, 10, '2021-04-12 06:30:55', '2021-04-12 06:31:07', 1, 2, NULL, 0, 0, NULL),
(333, 107, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-12 06:43:03', '2021-04-12 06:43:08', 1, 2, 'BONUS', 0, 0, NULL),
(334, 107, 20, 205000.00, 205000.00, 0.00, 0.00, 10, '2021-04-12 06:42:56', '2021-04-12 06:43:08', 1, 2, NULL, 0, 0, NULL),
(335, 108, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 06:52:06', '2021-04-12 06:52:42', 1, 2, 'BONUS', 0, 0, NULL),
(336, 108, 7, 187500.00, 187500.00, 0.00, 0.00, 10, '2021-04-12 06:51:56', '2021-04-12 06:52:42', 1, 2, NULL, 0, 0, NULL),
(337, 108, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-12 06:53:14', '2021-04-12 06:53:21', 4, 2, 'BONUS', 0, 0, NULL),
(338, 108, 5, 413750.00, 413750.00, 0.00, 0.00, 10, '2021-04-12 06:53:07', '2021-04-12 06:53:21', 4, 2, NULL, 0, 0, NULL),
(339, 109, 8, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 07:47:16', '2021-04-12 07:47:21', 1, 2, 'BONUS', 0, 0, NULL),
(340, 109, 22, 600000.00, 600000.00, 0.00, 0.00, 2, '2021-04-12 07:47:02', '2021-04-12 07:47:21', 1, 2, NULL, 0, 0, NULL),
(341, 109, 20, 205000.00, 205000.00, 0.00, 0.00, 3, '2021-04-12 07:46:55', '2021-04-12 07:47:21', 1, 2, NULL, 0, 0, NULL),
(342, 109, 10, 580000.00, 580000.00, 0.00, 0.00, 5, '2021-04-12 07:46:45', '2021-04-12 07:47:21', 1, 2, NULL, 0, 0, NULL),
(343, 110, 2, 459000.00, 459000.00, 0.00, 0.00, 1, '2021-04-12 08:07:03', '2021-04-12 08:07:07', 4, 2, 'BONUS', 0, 0, NULL),
(344, 110, 2, 459000.00, 459000.00, 0.00, 0.00, 5, '2021-04-12 08:06:54', '2021-04-12 08:07:07', 4, 2, NULL, 0, 0, NULL),
(345, 110, 5, 413750.00, 413750.00, 0.00, 0.00, 5, '2021-04-12 08:06:37', '2021-04-12 08:07:07', 4, 2, NULL, 0, 0, NULL),
(346, 110, 22, 600000.00, 600000.00, 0.00, 0.00, 2, '2021-04-12 08:07:59', '2021-04-12 08:08:21', 1, 2, NULL, 0, 0, NULL),
(347, 110, 20, 205000.00, 205000.00, 0.00, 0.00, 2, '2021-04-12 08:07:49', '2021-04-12 08:08:21', 1, 2, NULL, 0, 0, NULL),
(348, 110, 10, 580000.00, 580000.00, 0.00, 0.00, 2, '2021-04-12 08:07:44', '2021-04-12 08:08:21', 1, 2, NULL, 0, 0, NULL),
(349, 110, 8, 413750.00, 413750.00, 0.00, 0.00, 2, '2021-04-12 08:07:39', '2021-04-12 08:08:21', 1, 2, NULL, 0, 0, NULL),
(350, 110, 7, 187500.00, 187500.00, 0.00, 0.00, 2, '2021-04-12 08:07:33', '2021-04-12 08:08:21', 1, 2, NULL, 0, 0, NULL),
(351, 110, 22, 600000.00, 600000.00, 0.00, 0.00, 1, '2021-04-12 08:08:19', '2021-04-12 08:08:21', 1, 2, 'BONUS', 0, 0, NULL),
(352, 111, 20, 205000.00, 205000.00, 0.00, 0.00, 1, '2021-04-12 08:31:11', '2021-04-12 08:31:53', 1, 2, 'BONUS', 0, 0, NULL),
(353, 111, 8, 413750.00, 413750.00, 0.00, 0.00, 5, '2021-04-12 08:30:58', '2021-04-12 08:31:53', 1, 2, NULL, 0, 0, NULL),
(354, 111, 7, 187500.00, 187500.00, 0.00, 0.00, 5, '2021-04-12 08:30:54', '2021-04-12 08:31:53', 1, 2, NULL, 0, 0, NULL),
(355, 111, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 08:32:23', '2021-04-12 08:32:31', 4, 2, 'BONUS', 0, 0, NULL),
(356, 111, 5, 413750.00, 413750.00, 0.00, 0.00, 5, '2021-04-12 08:32:10', '2021-04-12 08:32:31', 4, 2, NULL, 0, 0, NULL),
(357, 111, 2, 459000.00, 459000.00, 0.00, 0.00, 5, '2021-04-12 08:32:06', '2021-04-12 08:32:31', 4, 2, NULL, 0, 0, NULL),
(358, 112, 20, 205000.00, 205000.00, 0.00, 0.00, 1, '2021-04-12 08:50:23', '2021-04-12 08:50:30', 1, 2, 'BONUS', 0, 0, NULL),
(359, 112, 22, 600000.00, 600000.00, 0.00, 0.00, 5, '2021-04-12 08:50:14', '2021-04-12 08:50:30', 1, 2, NULL, 0, 0, NULL),
(360, 112, 20, 205000.00, 205000.00, 0.00, 0.00, 5, '2021-04-12 08:50:07', '2021-04-12 08:50:30', 1, 2, NULL, 0, 0, NULL),
(361, 113, 20, 205000.00, 205000.00, 0.00, 0.00, 1, '2021-04-12 09:17:19', '2021-04-12 09:17:23', 1, 2, 'BONUS', 0, 0, NULL),
(362, 113, 8, 413750.00, 413750.00, 0.00, 0.00, 5, '2021-04-12 09:17:05', '2021-04-12 09:17:23', 1, 2, NULL, 0, 0, NULL),
(363, 113, 7, 187500.00, 187500.00, 0.00, 0.00, 5, '2021-04-12 09:16:55', '2021-04-12 09:17:23', 1, 2, NULL, 0, 0, NULL),
(364, 114, 1, 117000.00, 117000.00, 0.00, 0.00, 1, '2021-04-12 09:20:10', '2021-04-12 09:20:10', NULL, NULL, NULL, 0, 0, NULL),
(365, 114, 5, 413750.00, 413750.00, 0.00, 0.00, 1, '2021-04-12 09:20:15', '2021-04-12 09:20:15', NULL, NULL, NULL, 0, 0, NULL),
(366, 114, 10, 580000.00, 580000.00, 0.00, 0.00, 1, '2021-04-12 09:21:01', '2021-04-12 09:21:07', 1, 2, 'BONUS', 0, 0, NULL),
(367, 114, 10, 580000.00, 580000.00, 0.00, 0.00, 10, '2021-04-12 09:20:45', '2021-04-12 09:21:07', 1, 2, NULL, 0, 0, NULL),
(368, 115, 8, 413750.00, 413750.00, 0.00, 0.00, 10, '2021-04-20 17:11:13', '2021-04-20 17:11:23', 1, NULL, NULL, 0, 0, NULL),
(369, 115, 8, 413750.00, 413750.00, 0.00, 0.00, 3, '2021-04-20 17:11:19', '2021-04-20 17:11:23', 1, NULL, 'BONUS', 0, 0, NULL),
(370, 115, 7, 187500.00, 187500.00, 0.00, 0.00, 1, '2021-04-20 17:01:09', '2021-04-20 17:11:23', 1, NULL, 'BONUS', 0, 0, NULL),
(371, 115, 7, 187500.00, 187500.00, 0.00, 0.00, 20, '2021-04-20 17:01:03', '2021-04-20 17:11:23', 1, NULL, NULL, 0, 0, NULL),
(407, 119, 39, 50000.00, 50000.00, 0.00, 0.00, 1, '2021-05-27 17:38:56', '2021-05-27 17:38:58', 10, 2, 'BONUS', 0, 0, NULL),
(408, 119, 39, 50000.00, 50000.00, 0.00, 0.00, 10, '2021-05-27 17:38:35', '2021-05-27 17:38:58', 10, 2, NULL, 0, 0, NULL),
(409, 119, 40, 60000.00, 60000.00, 0.00, 0.00, 2, '2021-05-27 18:04:23', '2021-05-27 18:04:23', NULL, NULL, NULL, 0, 0, NULL),
(405, 118, 39, 50000.00, 50000.00, 0.00, 0.00, 1, '2021-05-27 17:22:53', '2021-05-27 17:22:56', 10, 2, 'BONUS', 0, 0, NULL),
(402, 118, 40, 60000.00, 60000.00, 0.00, 0.00, 4, '2021-05-27 08:17:17', '2021-05-27 08:17:17', NULL, NULL, NULL, 0, 0, NULL),
(406, 118, 39, 50000.00, 50000.00, 0.00, 0.00, 10, '2021-05-27 17:22:36', '2021-05-27 17:22:56', 10, 2, NULL, 0, 0, NULL),
(412, 121, 11, 196000.00, 196000.00, 0.00, 0.00, 10, '2021-06-14 04:07:05', '2021-06-14 04:07:05', NULL, NULL, NULL, 0, 0, NULL),
(414, 122, 16, 252800.00, 252800.00, 0.00, 0.00, 3, '2021-06-14 04:14:09', '2021-06-14 08:56:01', NULL, NULL, NULL, 0, 0, NULL),
(416, 123, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-06-14 09:16:35', '2021-06-14 09:16:35', NULL, NULL, NULL, 0, 0, NULL),
(417, 124, 16, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-06-14 09:30:42', '2021-06-14 09:30:42', NULL, NULL, NULL, 0, 0, NULL),
(418, 125, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-06-14 09:48:56', '2021-06-14 09:48:56', NULL, NULL, NULL, 0, 0, NULL),
(419, 126, 15, 999999.99, 999999.99, 0.00, 0.00, 1, '2021-06-14 10:02:56', '2021-06-14 10:02:56', NULL, NULL, NULL, 0, 0, NULL),
(420, 127, 39, 50000.00, 50000.00, 0.00, 0.00, 1, '2021-06-14 10:26:23', '2021-06-14 10:26:23', NULL, NULL, NULL, 0, 0, NULL),
(421, 128, 33, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-06-14 10:28:44', '2021-06-14 10:28:44', NULL, NULL, NULL, 0, 0, NULL),
(436, 130, 1, 115200.00, 115200.00, 0.00, 0.00, 1, '2021-06-15 08:41:21', '2021-06-15 08:41:21', NULL, NULL, NULL, 0, 0, NULL),
(435, 129, 12, 156800.00, 156800.00, 0.00, 0.00, 20, '2021-06-15 08:27:04', '2021-06-15 08:27:37', 12, 2, NULL, 0, 0, NULL),
(434, 129, 11, 196000.00, 196000.00, 0.00, 0.00, 2, '2021-06-15 08:27:35', '2021-06-15 08:27:37', 12, 2, 'BONUS', 0, 0, NULL),
(426, 129, 12, 156800.00, 156800.00, 0.00, 0.00, 5, '2021-06-15 08:15:37', '2021-06-15 08:15:37', NULL, NULL, NULL, 0, 0, NULL),
(437, 130, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-06-15 08:42:06', '2021-06-15 08:42:08', 12, 2, 'BONUS', 0, 0, NULL),
(438, 130, 13, 288000.00, 288000.00, 0.00, 0.00, 10, '2021-06-15 08:41:48', '2021-06-15 08:42:08', 12, 2, NULL, 0, 0, NULL),
(439, 131, 14, 752000.00, 752000.00, 0.00, 0.00, 10, '2021-06-15 14:29:36', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(440, 131, 12, 156800.00, 156800.00, 0.00, 0.00, 10, '2021-06-15 14:29:30', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(441, 131, 4, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-06-15 14:29:19', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(442, 131, 15, 999999.99, 999999.99, 0.00, 0.00, 5, '2021-06-15 14:29:42', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(443, 131, 17, 104640.00, 104640.00, 0.00, 0.00, 10, '2021-06-15 14:29:49', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(444, 131, 20, 207200.00, 207200.00, 0.00, 0.00, 12, '2021-06-15 14:29:58', '2021-06-15 14:30:22', 12, 2, NULL, 0, 0, NULL),
(445, 131, 12, 156800.00, 156800.00, 0.00, 0.00, 5, '2021-06-15 14:30:18', '2021-06-15 14:30:22', 12, 2, 'BONUS', 0, 0, NULL),
(448, 132, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-06-16 04:10:04', '2021-06-16 04:10:04', NULL, NULL, NULL, 0, 0, NULL),
(449, 133, 16, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-06-25 02:15:56', '2021-06-25 02:15:56', NULL, NULL, NULL, 0, 0, NULL),
(450, 134, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-06-30 19:47:34', '2021-06-30 19:47:34', NULL, NULL, NULL, 0, 0, NULL),
(451, 133, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-07-02 17:25:45', '2021-07-02 17:25:45', NULL, NULL, NULL, 0, 0, NULL),
(452, 133, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-07-02 17:25:48', '2021-07-02 17:25:48', NULL, NULL, NULL, 0, 0, NULL),
(453, 133, 16, 252800.00, 252800.00, 0.00, 0.00, 3, '2021-07-02 17:26:54', '2021-07-02 17:26:59', 12, 2, 'BONUS', 0, 0, NULL),
(454, 133, 4, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-07-02 17:26:18', '2021-07-02 17:26:59', 12, 2, NULL, 0, 0, NULL),
(455, 133, 11, 196000.00, 196000.00, 0.00, 0.00, 10, '2021-07-02 17:26:17', '2021-07-02 17:26:59', 12, 2, NULL, 0, 0, NULL),
(456, 133, 12, 156800.00, 156800.00, 0.00, 0.00, 10, '2021-07-02 17:26:15', '2021-07-02 17:26:59', 12, 2, NULL, 0, 0, NULL),
(457, 135, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-07-02 17:57:53', '2021-07-02 17:57:53', NULL, NULL, NULL, 0, 0, NULL),
(460, 135, 12, 156800.00, 156800.00, 0.00, 0.00, 1, '2021-07-02 17:58:54', '2021-07-02 17:58:55', 12, 2, 'BONUS', 0, 0, NULL),
(461, 135, 12, 156800.00, 156800.00, 0.00, 0.00, 10, '2021-07-02 17:58:44', '2021-07-02 17:58:55', 12, 2, NULL, 0, 0, NULL),
(476, 137, 17, 104640.00, 104640.00, 0.00, 0.00, 10, '2021-07-10 16:35:16', '2021-07-10 16:35:51', 12, 2, NULL, 0, 0, NULL),
(474, 137, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-07-10 16:34:22', '2021-07-10 16:34:22', NULL, NULL, NULL, 0, 0, NULL),
(475, 137, 30, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-07-10 16:35:49', '2021-07-10 16:35:51', 12, 2, 'BONUS', 0, 0, NULL),
(482, 136, 31, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-07-12 03:05:19', '2021-07-12 03:05:31', 12, 2, NULL, 0, 0, NULL),
(467, 136, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-07-10 16:04:08', '2021-07-10 16:04:08', NULL, NULL, NULL, 0, 0, NULL),
(481, 136, 32, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-07-12 03:05:29', '2021-07-12 03:05:31', 12, 2, 'BONUS', 0, 0, NULL),
(473, 137, 13, 288000.00, 288000.00, 0.00, 0.00, 1, '2021-07-10 16:34:20', '2021-07-10 16:34:20', NULL, NULL, NULL, 0, 0, NULL),
(479, 139, 36, 115200.00, 115200.00, 0.00, 0.00, 1, '2021-07-11 22:49:58', '2021-07-11 22:50:00', 12, 2, 'BONUS', 0, 0, NULL),
(480, 139, 36, 115200.00, 115200.00, 0.00, 0.00, 10, '2021-07-11 22:49:32', '2021-07-11 22:50:00', 12, 2, NULL, 0, 0, NULL),
(490, 146, 18, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-08-03 04:29:02', '2021-08-03 04:29:02', NULL, NULL, NULL, 0, 0, NULL),
(484, 141, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-03 03:11:31', '2021-08-03 03:11:31', NULL, NULL, NULL, 0, 0, NULL),
(485, 142, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-08-03 03:50:55', '2021-08-03 03:50:55', NULL, NULL, NULL, 0, 0, NULL),
(486, 143, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-03 03:53:51', '2021-08-03 03:53:51', NULL, NULL, NULL, 0, 0, NULL),
(487, 144, 14, 752000.00, 752000.00, 0.00, 0.00, 1, '2021-08-03 03:56:29', '2021-08-03 03:56:29', NULL, NULL, NULL, 0, 0, NULL),
(488, 145, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-08-03 03:59:13', '2021-08-03 03:59:13', NULL, NULL, NULL, 0, 0, NULL),
(489, 140, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-03 04:27:19', '2021-08-03 04:27:19', NULL, NULL, NULL, 0, 0, NULL),
(491, 146, 35, 433920.00, 433920.00, 0.00, 0.00, 6, '2021-08-12 07:05:41', '2021-08-12 07:05:45', 12, 2, 'BONUS', 0, 0, NULL),
(492, 146, 28, 300000.00, 300000.00, 0.00, 0.00, 20, '2021-08-12 07:05:09', '2021-08-12 07:05:45', 12, 2, NULL, 0, 0, NULL),
(493, 146, 30, 300000.00, 300000.00, 0.00, 0.00, 20, '2021-08-12 07:05:16', '2021-08-12 07:05:45', 12, 2, NULL, 0, 0, NULL),
(494, 146, 25, 240000.00, 240000.00, 0.00, 0.00, 20, '2021-08-12 07:05:01', '2021-08-12 07:05:45', 12, 2, NULL, 0, 0, NULL),
(495, 147, 26, 240000.00, 240000.00, 0.00, 0.00, 1, '2021-08-16 15:05:07', '2021-08-16 15:05:07', NULL, NULL, NULL, 0, 0, NULL),
(496, 147, 21, 240000.00, 240000.00, 0.00, 0.00, 1, '2021-08-16 15:05:14', '2021-08-16 15:05:14', NULL, NULL, NULL, 0, 0, NULL),
(497, 148, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 03:15:07', '2021-08-23 03:15:07', NULL, NULL, NULL, 0, 0, NULL),
(498, 149, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 03:16:12', '2021-08-23 03:16:12', NULL, NULL, NULL, 0, 0, NULL),
(499, 149, 25, 240000.00, 240000.00, 0.00, 0.00, 20, '2021-08-23 05:09:41', '2021-08-23 05:09:58', 12, 2, NULL, 0, 0, NULL),
(500, 149, 30, 300000.00, 300000.00, 0.00, 0.00, 3, '2021-08-23 05:09:53', '2021-08-23 05:09:58', 12, 2, 'BONUS', 0, 0, NULL),
(501, 149, 4, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 05:09:29', '2021-08-23 05:09:58', 12, 2, NULL, 0, 0, NULL),
(502, 150, 14, 752000.00, 752000.00, 0.00, 0.00, 1, '2021-08-23 05:11:43', '2021-08-23 05:11:43', NULL, NULL, NULL, 0, 0, NULL),
(503, 150, 19, 104640.00, 104640.00, 0.00, 0.00, 20, '2021-08-23 06:02:56', '2021-08-23 06:03:05', 12, 2, NULL, 0, 0, NULL),
(504, 150, 2, 433920.00, 433920.00, 0.00, 0.00, 3, '2021-08-23 06:03:01', '2021-08-23 06:03:05', 12, 2, 'BONUS', 0, 0, NULL),
(505, 150, 4, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 06:02:41', '2021-08-23 06:03:05', 12, 2, NULL, 0, 0, NULL),
(506, 151, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 06:22:30', '2021-08-23 06:22:30', NULL, NULL, NULL, 0, 0, NULL),
(507, 151, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 06:22:33', '2021-08-23 06:22:33', NULL, NULL, NULL, 0, 0, NULL),
(508, 151, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 06:23:12', '2021-08-23 06:23:13', 12, 2, 'BONUS', 0, 0, NULL),
(509, 151, 1, 115200.00, 115200.00, 0.00, 0.00, 1, '2021-08-23 06:23:07', '2021-08-23 06:23:13', 12, 2, 'BONUS', 0, 0, NULL),
(510, 151, 36, 115200.00, 115200.00, 0.00, 0.00, 10, '2021-08-23 06:23:02', '2021-08-23 06:23:13', 12, 2, NULL, 0, 0, NULL),
(511, 151, 33, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 06:22:58', '2021-08-23 06:23:13', 12, 2, NULL, 0, 0, NULL),
(512, 152, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 06:40:34', '2021-08-23 06:40:34', NULL, NULL, NULL, 0, 0, NULL),
(515, 152, 37, 864000.00, 864000.00, 0.00, 0.00, 1, '2021-08-23 06:42:29', '2021-08-23 06:42:31', 12, 2, 'BONUS', 0, 0, NULL),
(516, 152, 33, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 06:42:19', '2021-08-23 06:42:31', 12, 2, NULL, 0, 0, NULL),
(517, 153, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 06:47:44', '2021-08-23 06:47:44', NULL, NULL, NULL, 0, 0, NULL),
(518, 154, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 06:48:40', '2021-08-23 06:48:40', NULL, NULL, NULL, 0, 0, NULL),
(519, 154, 33, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 06:49:11', '2021-08-23 06:49:12', 12, 2, 'BONUS', 0, 0, NULL),
(520, 154, 28, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 06:49:02', '2021-08-23 06:49:12', 12, 2, NULL, 0, 0, NULL),
(521, 155, 15, 999999.99, 999999.99, 0.00, 0.00, 1, '2021-08-23 06:52:42', '2021-08-23 06:52:42', NULL, NULL, NULL, 0, 0, NULL),
(522, 155, 30, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 06:53:22', '2021-08-23 06:53:26', 12, 2, 'BONUS', 0, 0, NULL),
(523, 155, 28, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 06:53:18', '2021-08-23 06:53:26', 12, 2, 'BONUS', 0, 0, NULL),
(524, 155, 33, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 06:53:05', '2021-08-23 06:53:26', 12, 2, NULL, 0, 0, NULL),
(525, 155, 37, 864000.00, 864000.00, 0.00, 0.00, 10, '2021-08-23 06:53:00', '2021-08-23 06:53:26', 12, 2, NULL, 0, 0, NULL),
(526, 156, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 08:05:16', '2021-08-23 08:05:16', NULL, NULL, NULL, 0, 0, NULL),
(527, 156, 30, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:05:57', '2021-08-23 08:05:59', 12, 2, 'BONUS', 0, 0, NULL),
(528, 156, 28, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:05:53', '2021-08-23 08:05:59', 12, 2, 'BONUS', 0, 0, NULL),
(529, 156, 25, 240000.00, 240000.00, 0.00, 0.00, 20, '2021-08-23 08:05:46', '2021-08-23 08:05:59', 12, 2, NULL, 0, 0, NULL),
(530, 157, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 08:22:32', '2021-08-23 08:22:33', 12, 2, 'BONUS', 0, 0, NULL),
(531, 157, 18, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-08-23 08:22:28', '2021-08-23 08:22:33', 12, 2, 'BONUS', 0, 0, NULL),
(532, 157, 18, 252800.00, 252800.00, 0.00, 0.00, 10, '2021-08-23 08:22:21', '2021-08-23 08:22:33', 12, 2, NULL, 0, 0, NULL),
(533, 157, 4, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 08:22:16', '2021-08-23 08:22:33', 12, 2, NULL, 0, 0, NULL),
(534, 158, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 08:23:32', '2021-08-23 08:23:32', NULL, NULL, NULL, 0, 0, NULL),
(541, 158, 29, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:24:33', '2021-08-23 08:24:41', 12, 2, 'BONUS', 0, 0, NULL),
(540, 158, 28, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:24:35', '2021-08-23 08:24:41', 12, 2, 'BONUS', 0, 0, NULL),
(539, 158, 33, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:24:39', '2021-08-23 08:24:41', 12, 2, 'BONUS', 0, 0, NULL),
(542, 158, 34, 647040.00, 647040.00, 0.00, 0.00, 10, '2021-08-23 08:24:28', '2021-08-23 08:24:41', 12, 2, NULL, 0, 0, NULL),
(543, 158, 31, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 08:24:23', '2021-08-23 08:24:41', 12, 2, NULL, 0, 0, NULL),
(544, 158, 30, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 08:24:20', '2021-08-23 08:24:41', 12, 2, NULL, 0, 0, NULL),
(545, 159, 25, 240000.00, 240000.00, 0.00, 0.00, 1, '2021-08-23 08:28:16', '2021-08-23 08:28:17', 12, 2, 'BONUS', 0, 0, NULL),
(546, 159, 24, 96000.00, 96000.00, 0.00, 0.00, 1, '2021-08-23 08:28:15', '2021-08-23 08:28:17', 12, 2, 'BONUS', 0, 0, NULL),
(547, 159, 18, 252800.00, 252800.00, 0.00, 0.00, 20, '2021-08-23 08:28:08', '2021-08-23 08:28:17', 12, 2, NULL, 0, 0, NULL),
(548, 160, 18, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-08-23 08:37:05', '2021-08-23 08:37:05', NULL, NULL, NULL, 0, 0, NULL),
(549, 160, 28, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 08:37:42', '2021-08-23 08:37:43', 12, 2, 'BONUS', 0, 0, NULL),
(550, 160, 20, 207200.00, 207200.00, 0.00, 0.00, 1, '2021-08-23 08:37:33', '2021-08-23 08:37:43', 12, 2, 'BONUS', 0, 0, NULL),
(551, 160, 17, 104640.00, 104640.00, 0.00, 0.00, 10, '2021-08-23 08:37:24', '2021-08-23 08:37:43', 12, 2, NULL, 0, 0, NULL),
(552, 160, 13, 288000.00, 288000.00, 0.00, 0.00, 10, '2021-08-23 08:37:18', '2021-08-23 08:37:43', 12, 2, NULL, 0, 0, NULL),
(555, 161, 20, 207200.00, 207200.00, 0.00, 0.00, 2, '2021-08-23 08:50:36', '2021-08-23 08:50:38', 12, 2, 'BONUS', 0, 0, NULL),
(554, 161, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-08-23 08:49:41', '2021-08-23 08:49:41', NULL, NULL, NULL, 0, 0, NULL),
(556, 161, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-08-23 08:50:34', '2021-08-23 08:50:38', 12, 2, 'BONUS', 0, 0, NULL),
(557, 161, 24, 96000.00, 96000.00, 0.00, 0.00, 10, '2021-08-23 08:50:25', '2021-08-23 08:50:38', 12, 2, NULL, 0, 0, NULL),
(558, 161, 25, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 08:50:18', '2021-08-23 08:50:38', 12, 2, NULL, 0, 0, NULL),
(559, 161, 19, 104640.00, 104640.00, 0.00, 0.00, 10, '2021-08-23 08:50:13', '2021-08-23 08:50:38', 12, 2, NULL, 0, 0, NULL),
(560, 162, 23, 560000.00, 560000.00, 0.00, 0.00, 2, '2021-08-23 09:14:10', '2021-08-23 09:14:11', 12, 2, 'BONUS', 0, 0, NULL),
(561, 162, 24, 96000.00, 96000.00, 0.00, 0.00, 10, '2021-08-23 09:14:03', '2021-08-23 09:14:11', 12, 2, NULL, 0, 0, NULL),
(562, 162, 23, 560000.00, 560000.00, 0.00, 0.00, 10, '2021-08-23 09:13:54', '2021-08-23 09:14:11', 12, 2, NULL, 0, 0, NULL),
(563, 163, 1, 115200.00, 115200.00, 0.00, 0.00, 2, '2021-08-23 09:38:57', '2021-08-23 09:38:58', 12, 2, 'BONUS', 0, 0, NULL),
(564, 163, 21, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 09:38:51', '2021-08-23 09:38:58', 12, 2, NULL, 0, 0, NULL),
(565, 163, 19, 104640.00, 104640.00, 0.00, 0.00, 10, '2021-08-23 09:38:44', '2021-08-23 09:38:58', 12, 2, NULL, 0, 0, NULL),
(566, 164, 2, 433920.00, 433920.00, 0.00, 0.00, 2, '2021-08-23 10:08:02', '2021-08-23 10:08:04', 12, 2, 'BONUS', 0, 0, NULL),
(567, 164, 36, 115200.00, 115200.00, 0.00, 0.00, 10, '2021-08-23 10:07:57', '2021-08-23 10:08:04', 12, 2, NULL, 0, 0, NULL),
(568, 164, 33, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 10:07:51', '2021-08-23 10:08:04', 12, 2, NULL, 0, 0, NULL),
(569, 165, 28, 300000.00, 300000.00, 0.00, 0.00, 2, '2021-08-23 10:20:32', '2021-08-23 10:20:34', 12, 2, 'BONUS', 0, 0, NULL),
(570, 165, 25, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 10:20:25', '2021-08-23 10:20:34', 12, 2, NULL, 0, 0, NULL),
(571, 165, 24, 96000.00, 96000.00, 0.00, 0.00, 10, '2021-08-23 10:20:16', '2021-08-23 10:20:34', 12, 2, NULL, 0, 0, NULL),
(572, 166, 27, 480000.00, 480000.00, 0.00, 0.00, 2, '2021-08-23 10:22:17', '2021-08-23 10:22:19', 12, 2, 'BONUS', 0, 0, NULL),
(573, 166, 29, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 10:22:10', '2021-08-23 10:22:19', 12, 2, NULL, 0, 0, NULL),
(574, 166, 27, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-08-23 10:22:02', '2021-08-23 10:22:19', 12, 2, NULL, 0, 0, NULL),
(575, 167, 25, 240000.00, 240000.00, 0.00, 0.00, 2, '2021-08-23 10:48:24', '2021-08-23 10:48:25', 12, 2, 'BONUS', 0, 0, NULL),
(576, 167, 30, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 10:48:07', '2021-08-23 10:48:25', 12, 2, NULL, 0, 0, NULL),
(577, 167, 29, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 10:46:30', '2021-08-23 10:48:25', 12, 2, NULL, 0, 0, NULL),
(578, 168, 25, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 10:49:59', '2021-08-23 10:50:03', 12, 2, NULL, 0, 0, NULL),
(579, 168, 24, 96000.00, 96000.00, 0.00, 0.00, 10, '2021-08-23 10:49:56', '2021-08-23 10:50:03', 12, 2, NULL, 0, 0, NULL),
(580, 169, 12, 156800.00, 156800.00, 0.00, 0.00, 2, '2021-08-23 11:50:55', '2021-08-23 11:50:57', 12, 2, 'BONUS', 0, 0, NULL),
(581, 169, 26, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 11:50:45', '2021-08-23 11:50:57', 12, 2, NULL, 0, 0, NULL),
(582, 169, 25, 240000.00, 240000.00, 0.00, 0.00, 10, '2021-08-23 11:50:38', '2021-08-23 11:50:57', 12, 2, NULL, 0, 0, NULL),
(583, 170, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-08-23 11:58:01', '2021-08-23 11:58:01', NULL, NULL, NULL, 0, 0, NULL),
(584, 170, 14, 752000.00, 752000.00, 0.00, 0.00, 1, '2021-08-23 11:58:02', '2021-08-23 11:58:02', NULL, NULL, NULL, 0, 0, NULL),
(585, 170, 33, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 11:58:40', '2021-08-23 11:58:42', 12, 2, 'BONUS', 0, 0, NULL),
(586, 170, 32, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 11:58:36', '2021-08-23 11:58:42', 12, 2, 'BONUS', 0, 0, NULL),
(587, 170, 29, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-08-23 11:58:32', '2021-08-23 11:58:42', 12, 2, 'BONUS', 0, 0, NULL),
(588, 170, 29, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 11:58:25', '2021-08-23 11:58:42', 12, 2, NULL, 0, 0, NULL),
(589, 170, 31, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 11:58:22', '2021-08-23 11:58:42', 12, 2, NULL, 0, 0, NULL),
(590, 170, 30, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-08-23 11:58:19', '2021-08-23 11:58:42', 12, 2, NULL, 0, 0, NULL),
(591, 171, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 12:07:25', '2021-08-23 12:07:25', NULL, NULL, NULL, 0, 0, NULL),
(592, 171, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-08-23 12:07:27', '2021-08-23 12:07:27', NULL, NULL, NULL, 0, 0, NULL),
(593, 172, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-23 12:24:01', '2021-08-23 12:24:01', NULL, NULL, NULL, 0, 0, NULL),
(594, 172, 15, 999999.99, 999999.99, 0.00, 0.00, 1, '2021-08-23 12:24:04', '2021-08-23 12:24:04', NULL, NULL, NULL, 0, 0, NULL),
(595, 173, 15, 999999.99, 999999.99, 0.00, 0.00, 1, '2021-08-23 12:36:06', '2021-08-23 12:36:06', NULL, NULL, NULL, 0, 0, NULL),
(596, 173, 14, 752000.00, 752000.00, 0.00, 0.00, 1, '2021-08-24 10:28:27', '2021-08-24 10:28:27', NULL, NULL, NULL, 0, 0, NULL),
(597, 174, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-08-25 05:00:53', '2021-08-25 05:00:53', NULL, NULL, NULL, 0, 0, NULL),
(624, 181, 15, 999999.99, 999999.99, 0.00, 0.00, 1, '2021-09-03 09:20:18', '2021-09-03 09:20:18', NULL, NULL, NULL, 0, 0, NULL),
(625, 182, 26, 240000.00, 240000.00, 0.00, 0.00, 1, '2021-09-03 09:21:31', '2021-09-03 09:21:31', NULL, NULL, NULL, 0, 0, NULL),
(623, 180, 13, 288000.00, 288000.00, 0.00, 0.00, 1, '2021-09-03 09:18:56', '2021-09-03 09:18:56', NULL, NULL, NULL, 0, 0, NULL),
(622, 179, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-09-03 09:16:47', '2021-09-03 09:16:47', NULL, NULL, NULL, 0, 0, NULL),
(621, 175, 19, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-09-03 09:03:47', '2021-09-03 09:03:47', NULL, NULL, NULL, 0, 0, NULL),
(620, 175, 16, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-09-03 09:03:44', '2021-09-03 09:03:44', NULL, NULL, NULL, 0, 0, NULL),
(618, 175, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-09-01 07:37:21', '2021-09-01 07:37:21', NULL, NULL, NULL, 0, 0, NULL),
(619, 175, 14, 752000.00, 752000.00, 0.00, 0.00, 1, '2021-09-03 09:03:42', '2021-09-03 09:03:42', NULL, NULL, NULL, 0, 0, NULL),
(626, 183, 27, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-09-03 09:23:09', '2021-09-03 09:23:09', NULL, NULL, NULL, 0, 0, NULL),
(630, 184, 35, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-09-03 09:26:31', '2021-09-03 09:26:31', NULL, NULL, NULL, 0, 0, NULL),
(631, 184, 36, 115200.00, 115200.00, 0.00, 0.00, 1, '2021-09-03 09:26:31', '2021-09-03 09:26:31', NULL, NULL, NULL, 0, 0, NULL),
(632, 184, 34, 647040.00, 647040.00, 0.00, 0.00, 1, '2021-09-03 09:26:32', '2021-09-03 09:26:32', NULL, NULL, NULL, 0, 0, NULL),
(633, 185, 18, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-09-03 09:55:38', '2021-09-03 09:55:38', NULL, NULL, NULL, 0, 0, NULL),
(634, 185, 31, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-09-03 09:55:42', '2021-09-03 09:55:42', NULL, NULL, NULL, 0, 0, NULL),
(635, 185, 34, 647040.00, 647040.00, 0.00, 0.00, 1, '2021-09-03 09:55:44', '2021-09-03 09:55:44', NULL, NULL, NULL, 0, 0, NULL),
(636, 178, 0, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(637, 186, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(638, 187, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(639, 176, 0, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(640, 177, 0, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(641, 178, 0, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(642, 186, 0, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(643, 187, 0, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(644, 188, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(645, 189, 16, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-09-15 06:53:33', '2021-09-15 06:53:33', NULL, NULL, NULL, 0, 0, NULL),
(646, 190, 28, 300000.00, 300000.00, 0.00, 0.00, 10, '2021-09-16 15:55:03', '2021-09-16 15:55:12', 12, 2, NULL, 0, 0, NULL),
(647, 190, 36, 115200.00, 115200.00, 0.00, 0.00, 1, '2021-09-16 15:55:10', '2021-09-16 15:55:12', 12, 2, 'BONUS', 0, 0, NULL),
(648, 191, 16, 252800.00, 252800.00, 0.00, 0.00, 1, '2021-09-16 18:20:57', '2021-09-16 18:20:57', NULL, NULL, NULL, 0, 0, NULL),
(649, 192, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-09-16 18:24:32', '2021-09-16 18:24:32', NULL, NULL, NULL, 0, 0, NULL);
INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `price_item`, `price_item_promo`, `vol_disc_price`, `discount_item`, `quantity`, `created_at`, `updated_at`, `group_id`, `paket_id`, `bonus_cat`, `available`, `preorder`, `deliveryQty`) VALUES
(650, 193, 29, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-09-20 02:23:22', '2021-09-20 02:23:22', NULL, NULL, NULL, 0, 0, NULL),
(651, 194, 22, 480000.00, 480000.00, 0.00, 0.00, 2, '2021-09-28 13:45:46', '2021-09-28 13:45:46', NULL, NULL, NULL, 0, 0, NULL),
(652, 194, 23, 560000.00, 560000.00, 0.00, 0.00, 3, '2021-09-28 13:46:15', '2021-09-28 13:46:15', NULL, NULL, NULL, 0, 0, NULL),
(653, 194, 24, 96000.00, 96000.00, 0.00, 0.00, 1, '2021-09-28 13:46:38', '2021-09-28 13:46:38', NULL, NULL, NULL, 0, 0, NULL),
(654, 195, 26, 240000.00, 240000.00, 0.00, 0.00, 1, '2021-09-29 03:30:53', '2021-09-29 03:30:53', NULL, NULL, NULL, 0, 0, NULL),
(655, 195, 35, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-09-29 03:31:06', '2021-09-29 03:31:06', NULL, NULL, NULL, 0, 0, NULL),
(656, 196, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-09-29 04:47:33', '2021-09-29 04:47:36', 12, 2, 'BONUS', 0, 0, NULL),
(657, 196, 22, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-09-29 04:47:15', '2021-09-29 04:47:36', 12, 2, NULL, 0, 0, NULL),
(658, 197, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-09-29 05:46:07', '2021-09-29 05:46:09', 12, 2, 'BONUS', 0, 0, NULL),
(659, 197, 22, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-09-29 05:45:59', '2021-09-29 05:46:09', 12, 2, NULL, 0, 0, NULL),
(660, 198, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-10-01 08:21:16', '2021-10-01 08:21:18', 12, 2, 'BONUS', 0, 0, NULL),
(661, 198, 22, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-10-01 08:21:06', '2021-10-01 08:21:18', 12, 2, NULL, 0, 0, NULL),
(662, 199, 22, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-10-01 08:24:19', '2021-10-01 08:24:29', 12, 2, NULL, 0, 0, NULL),
(663, 199, 22, 480000.00, 480000.00, 0.00, 0.00, 1, '2021-10-01 08:24:27', '2021-10-01 08:24:29', 12, 2, 'BONUS', 0, 0, NULL),
(664, 200, 13, 288000.00, 288000.00, 0.00, 0.00, 1, '2021-10-18 03:03:39', '2021-10-18 03:03:39', NULL, NULL, NULL, 0, 0, NULL),
(665, 201, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(666, 202, 15, 999999.99, 999999.99, 0.00, 0.00, 10, '2021-10-18 07:25:11', '2021-10-18 07:25:11', NULL, NULL, NULL, 0, 0, NULL),
(667, 203, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-10-26 02:20:22', '2021-10-26 02:20:22', NULL, NULL, NULL, 0, 0, NULL),
(668, 203, 22, 480000.00, 480000.00, 0.00, 0.00, 2, '2021-10-26 07:36:13', '2021-10-26 07:36:13', NULL, NULL, NULL, 0, 0, NULL),
(669, 204, 22, 480000.00, 480000.00, 0.00, 0.00, 2, '2021-10-26 07:41:39', '2021-10-26 07:41:39', NULL, NULL, NULL, 0, 0, NULL),
(670, 204, 21, 240000.00, 240000.00, 0.00, 0.00, 2, '2021-10-26 07:41:40', '2021-10-26 07:41:40', NULL, NULL, NULL, 0, 0, NULL),
(671, 205, 17, 104640.00, 104640.00, 0.00, 0.00, 1, '2021-10-27 09:32:46', '2021-10-27 09:32:46', NULL, NULL, NULL, 0, 0, NULL),
(672, 205, 22, 480000.00, 480000.00, 0.00, 0.00, 2, '2021-10-28 16:43:46', '2021-10-28 16:43:46', NULL, NULL, NULL, 0, 0, NULL),
(673, 206, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-11-02 10:56:25', '2021-11-02 10:56:25', NULL, NULL, NULL, 0, 0, NULL),
(674, 207, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(675, 206, 22, 480000.00, 480000.00, 0.00, 0.00, 10, '2021-11-04 08:51:04', '2021-11-04 08:51:04', NULL, NULL, NULL, 0, 0, NULL),
(676, 208, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(677, 209, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-11-09 07:18:37', '2021-11-09 07:18:37', NULL, NULL, NULL, 0, 0, NULL),
(678, 209, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-11-09 07:18:42', '2021-11-09 07:18:42', NULL, NULL, NULL, 0, 0, NULL),
(681, 211, 33, 300000.00, 300000.00, 0.00, 0.00, 4, '2021-11-15 09:32:09', '2021-11-15 09:32:09', NULL, NULL, NULL, 0, 0, NULL),
(680, 210, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-11-15 04:08:44', '2021-11-15 04:08:44', NULL, NULL, NULL, 0, 0, NULL),
(682, 212, 4, 300000.00, 300000.00, 0.00, 0.00, 3, '2021-11-15 13:55:32', '2021-11-15 13:55:32', NULL, NULL, NULL, 0, 0, NULL),
(685, 214, 2, 433920.00, 433920.00, 0.00, 0.00, 3, '2021-11-18 03:05:12', '2021-11-18 03:05:12', NULL, NULL, NULL, 0, 0, NULL),
(812, 215, 2, 433920.00, 433920.00, 0.00, 0.00, 5, '2021-11-22 06:43:50', '2021-11-22 06:43:50', NULL, NULL, NULL, 0, 0, NULL),
(813, 215, 4, 300000.00, 300000.00, 0.00, 0.00, 4, '2021-11-22 06:44:15', '2021-11-22 06:44:15', NULL, NULL, NULL, 0, 0, NULL),
(814, 216, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-11-22 10:45:30', '2021-11-22 10:45:30', NULL, NULL, NULL, 0, 0, NULL),
(815, 217, 2, 433920.00, 433920.00, 0.00, 0.00, 3, '2021-11-22 10:48:18', '2021-11-23 00:30:03', NULL, NULL, NULL, 0, 0, NULL),
(850, 256, 4, 300000.00, 300000.00, 0.00, 0.00, 4, '2021-11-23 15:40:15', '2021-11-23 15:40:58', 12, 2, NULL, 0, 4, NULL),
(849, 256, 2, 433920.00, 433920.00, 0.00, 0.00, 6, '2021-11-23 15:40:23', '2021-11-23 15:40:58', 12, 2, NULL, 6, 0, NULL),
(851, 256, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-11-23 15:40:27', '2021-11-23 15:40:58', 12, 2, 'BONUS', 0, 1, NULL),
(854, 257, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2021-11-23 18:06:22', '2021-11-23 18:06:22', NULL, NULL, NULL, 0, 1, NULL),
(855, 257, 39, 50000.00, 50000.00, 0.00, 0.00, 9, '2021-11-23 18:06:40', '2021-11-23 18:06:40', NULL, NULL, NULL, 8, 1, NULL),
(857, 258, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-11-24 03:45:50', '2021-11-24 03:45:50', NULL, NULL, NULL, 1, 0, NULL),
(860, 260, 4, 300000.00, 300000.00, 0.00, 0.00, 3, '2021-11-24 07:53:41', '2021-11-27 17:14:19', NULL, NULL, NULL, 0, 3, 3),
(861, 260, 2, 433920.00, 433920.00, 0.00, 0.00, 40, '2021-11-24 07:56:04', '2021-11-27 17:14:19', NULL, NULL, NULL, 37, 3, 40),
(862, 261, 2, 433920.00, 433920.00, 0.00, 0.00, 3, '2021-11-26 06:25:30', '2021-11-26 06:25:52', 12, 2, 'BONUS', 3, 0, NULL),
(863, 261, 2, 433920.00, 433920.00, 0.00, 0.00, 10, '2021-11-26 06:25:20', '2021-11-26 06:25:32', 12, 2, NULL, 10, 0, NULL),
(864, 261, 13, 288000.00, 288000.00, 0.00, 0.00, 3, '2021-11-26 06:25:55', '2021-11-26 06:25:55', NULL, NULL, NULL, 3, 0, NULL),
(869, 262, 2, 433920.00, 433920.00, 0.00, 0.00, 11, '2021-11-26 06:39:19', '2021-11-26 06:39:26', 12, 2, NULL, 11, 0, NULL),
(868, 262, 2, 433920.00, 433920.00, 0.00, 0.00, 1, '2021-11-26 06:39:24', '2021-11-26 06:39:26', 12, 2, 'BONUS', 1, 0, NULL),
(867, 262, 2, 433920.00, 433920.00, 0.00, 0.00, 3, '2021-11-26 06:38:16', '2021-11-26 06:38:43', NULL, NULL, NULL, 3, 0, NULL),
(940, 264, 2, 433920.00, 433920.00, 0.00, 0.00, 10, '2021-11-30 08:58:49', '2021-11-30 09:18:00', 12, 2, NULL, 0, 10, 0),
(939, 264, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-11-30 08:58:55', '2021-11-30 09:18:00', 12, 2, 'BONUS', 1, 0, 1),
(917, 263, 2, 433920.00, 433920.00, 0.00, 0.00, 13, '2021-11-30 06:06:09', '2021-11-30 06:06:19', NULL, NULL, NULL, 10, 3, NULL),
(933, 263, 4, 300000.00, 300000.00, 0.00, 0.00, 14, '2021-11-30 08:25:13', '2021-11-30 08:31:06', NULL, NULL, NULL, 15, 0, NULL),
(938, 264, 4, 300000.00, 300000.00, 0.00, 0.00, 12, '2021-11-30 08:58:06', '2021-11-30 09:18:00', NULL, NULL, NULL, 1, 11, 1),
(941, 265, 43, NULL, NULL, 0.00, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL),
(968, 268, 11, 196000.00, 196000.00, 0.00, 0.00, 1, '2021-12-31 19:58:47', '2021-12-31 19:58:49', 12, 2, 'BONUS', 1, 0, NULL),
(969, 268, 24, 96000.00, 96000.00, 0.00, 0.00, 10, '2021-12-31 19:58:37', '2021-12-31 19:58:49', 12, 2, NULL, 10, 0, NULL),
(971, 269, 2, 433920.00, 433920.00, 30000.00, 0.00, 9, '2022-01-02 08:24:42', '2022-01-15 17:43:02', NULL, NULL, NULL, 0, 9, NULL),
(972, 269, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2022-01-02 08:24:50', '2022-01-15 17:43:02', NULL, NULL, NULL, 0, 1, NULL),
(973, 270, 2, 433920.00, 433920.00, 0.00, 0.00, 11, '2022-01-03 06:09:03', '2022-01-26 18:30:56', NULL, NULL, NULL, 0, 11, 11),
(1053, 306, 4, 300000.00, 300000.00, 409344.00, 0.00, 10, '2022-01-20 06:15:52', '2022-01-20 10:19:20', NULL, NULL, NULL, 0, 0, 8),
(1065, 310, 2, 433920.00, 433920.00, 0.00, 0.00, 10, '2022-01-22 07:03:14', '2022-01-22 07:03:42', 12, 2, NULL, 10, 0, NULL),
(976, 271, 33, 300000.00, 300000.00, 0.00, 0.00, 5, '2022-01-12 16:00:54', '2022-01-12 16:00:54', NULL, NULL, NULL, 5, 0, NULL),
(1067, 312, 4, 300000.00, 300000.00, 409344.00, 0.00, 1, '2022-01-24 09:12:04', '2022-01-24 09:12:10', NULL, NULL, NULL, 1, 0, NULL),
(1036, 289, 11, 196000.00, 196000.00, 160720.00, 0.00, 100, '2022-01-18 08:53:14', '2022-01-20 04:47:33', NULL, NULL, NULL, 100, 0, 10),
(1066, 310, 4, 300000.00, 300000.00, 0.00, 0.00, 1, '2022-01-22 07:03:20', '2022-01-22 07:03:42', 12, 2, 'BONUS', 0, 1, NULL),
(1069, 314, 4, 300000.00, 300000.00, 409344.00, 0.00, 1, '2022-01-24 09:14:01', '2022-01-24 09:14:07', NULL, NULL, NULL, 1, 0, NULL),
(1070, 315, 15, 1280000.00, 1280000.00, 1049600.00, 0.00, 1, '2022-01-24 09:22:53', '2022-01-24 09:22:58', NULL, NULL, NULL, 1, 0, NULL),
(1071, 316, 4, 300000.00, 300000.00, 409344.00, 0.00, 10, '2022-01-25 09:28:32', '2022-01-25 09:28:45', NULL, NULL, NULL, 2, 8, NULL),
(1072, 317, 4, 300000.00, 300000.00, 409344.00, 0.00, 10, '2022-01-25 10:28:47', '2022-01-25 16:03:13', NULL, NULL, NULL, 0, 10, 2),
(1073, 317, 11, 196000.00, 196000.00, 160720.00, 0.00, 10, '2022-01-25 10:28:50', '2022-01-25 10:49:42', NULL, NULL, NULL, 10, 0, 10),
(1074, 317, 13, 288000.00, 288000.00, 236160.00, 0.00, 10, '2022-01-25 10:28:57', '2022-01-25 10:49:42', NULL, NULL, NULL, 10, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pakets`
--

CREATE TABLE `pakets` (
  `id` int(10) UNSIGNED NOT NULL,
  `paket_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonus_quantity` int(11) NOT NULL,
  `purchase_quantity` int(11) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pakets`
--

INSERT INTO `pakets` (`id`, `paket_name`, `display_name`, `bonus_quantity`, `purchase_quantity`, `display_order`, `client_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'PAKET1', 'Paket 10 free 1', 1, 10, 0, 1, 'ACTIVE', '2021-03-23 10:01:29', '2021-06-10 03:24:58'),
(3, 'PAKET2', 'Paket 1000 free 1000', 4, 30, 0, 2, 'ACTIVE', '2021-03-23 10:01:58', '2021-03-23 10:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `partial_deliveries`
--

CREATE TABLE `partial_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `op_id` int(10) UNSIGNED NOT NULL,
  `partial_qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partial_deliveries`
--

INSERT INTO `partial_deliveries` (`id`, `op_id`, `partial_qty`, `created_at`, `updated_at`) VALUES
(4, 1072, 2, '2022-01-25 10:49:42', '2022-01-25 10:49:42'),
(5, 1073, 10, '2022-01-25 10:49:42', '2022-01-25 10:49:42'),
(6, 1074, 10, '2022-01-25 10:49:42', '2022-01-25 10:49:42'),
(8, 1073, 0, '2022-01-25 10:50:33', '2022-01-25 10:50:33'),
(9, 1074, 0, '2022-01-25 10:50:33', '2022-01-25 10:50:33'),
(11, 1073, 0, '2022-01-25 16:03:13', '2022-01-25 16:03:13'),
(12, 1074, 0, '2022-01-25 16:03:13', '2022-01-25 16:03:13'),
(13, 973, 2, '2022-01-26 18:30:22', '2022-01-26 18:30:22'),
(14, 973, 9, '2022-01-26 18:30:56', '2022-01-26 18:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('testsales@sales.com', '$2y$10$ryX19U6ew613bd06hRyLsOSdPA7rRn5BoT6C22Pu.roYOqRIu02/2', '2021-04-01 10:19:46'),
('setyawanzuky@gmail.com', '$2y$10$hWd8vOTEWYgOoukaEqpzmeBpXAy/d.2wffEbNh1chTuLsg8SDDhUG', '2021-04-01 10:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `point_claims`
--

CREATE TABLE `point_claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custpoint_id` bigint(20) UNSIGNED NOT NULL,
  `reward_id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `override_points` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('SUBMIT','FINISH') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_claims`
--

INSERT INTO `point_claims` (`id`, `custpoint_id`, `reward_id`, `type`, `override_points`, `created_at`, `updated_at`, `status`) VALUES
(6, 525, 1, 2, 16.00, NULL, NULL, 'FINISH'),
(8, 525, 4, 1, NULL, '2022-01-12 05:02:42', '2022-01-12 05:02:42', 'SUBMIT');

-- --------------------------------------------------------

--
-- Table structure for table `point_periods`
--

CREATE TABLE `point_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_periods`
--

INSERT INTO `point_periods` (`id`, `client_id`, `name`, `starts_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'period 1', '2021-08-31 17:00:00', '2021-12-30 17:00:00', '2021-11-02 17:41:50', '2021-11-02 17:41:50'),
(2, 1, 'periode 2', '2021-12-31 17:00:00', '2022-01-30 17:00:00', '2021-11-05 09:08:07', '2021-11-05 09:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `point_rewards`
--

CREATE TABLE `point_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `period_id` bigint(20) UNSIGNED NOT NULL,
  `point_rule` double(8,2) NOT NULL,
  `bonus_amount` double(11,2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_rewards`
--

INSERT INTO `point_rewards` (`id`, `client_id`, `period_id`, `point_rule`, `bonus_amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 10.00, 50000.00, '2021-11-02 17:42:52', '2021-11-02 17:42:52', NULL),
(2, 1, 1, 20.00, 100000.00, '2021-11-02 17:42:52', '2021-11-02 17:42:52', NULL),
(3, 1, 1, 30.00, 150000.00, '2021-11-02 17:42:52', '2021-11-02 17:42:52', NULL),
(4, 1, 1, 40.00, 200000.00, '2021-11-02 17:42:52', '2021-11-02 17:42:52', NULL),
(5, 1, 2, 100.00, 800000.00, '2021-11-05 09:09:33', '2021-11-05 09:09:33', NULL),
(6, 1, 2, 50.00, 500000.00, '2021-11-05 09:09:33', '2021-11-05 09:09:33', NULL),
(7, 1, 2, 30.00, 300000.00, '2021-11-05 09:09:33', '2021-11-05 09:09:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `key_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(11,2) NOT NULL,
  `price_promo` double(11,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `low_stock_treshold` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `top_product` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('PUBLISH','DRAFT','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `key_code`, `client_id`, `product_code`, `Product_name`, `slug`, `description`, `image`, `price`, `price_promo`, `discount`, `stock`, `low_stock_treshold`, `top_product`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(2, NULL, 1, 'MCLBF.005', 'BRAKE FLUID 300 ML - RED ( 1 X 24 BTL )', 'brake-fluid-300-ml-red-1-x-24-btl', 'BRAKE FLUID 300 ML - RED ( 1 X 24 BTL )', NULL, 433920.00, 433920.00, 0.00, 2207, 12, 1, 1, 29, NULL, '2021-05-19 08:44:30', '2022-01-26 18:30:56', NULL, 'PUBLISH'),
(4, NULL, 1, 'MCCBP.001', 'BRAKEPART CLEANER 500 ML ( 20 X 1 KLG )', 'brakepart-cleaner-500-ml-20-x-1-klg', 'BRAKEPART CLEANER 500 ML ( 20 X 1 KLG )', NULL, 300000.00, 300000.00, 0.00, 54, 5, 1, 1, 29, NULL, '2021-05-19 08:44:30', '2022-02-04 09:25:50', NULL, 'PUBLISH'),
(5, NULL, 2, 'MCLCL.001', 'CHAIN LUBE 300 ML ( 20 X 1 KLG )', 'chain-lube-300-ml-20-x-1-klg', 'CHAIN LUBE 300 ML ( 20 X 1 KLG )', NULL, 342400.00, 342400.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:30', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(6, NULL, 2, 'MCCKC.001', 'CONTACT CLEANER 500 ML ( 20 X 1 KLG)', 'contact-cleaner-500-ml-20-x-1-klg', 'CONTACT CLEANER 500 ML ( 20 X 1 KLG)', NULL, 300000.00, 300000.00, 0.00, 9999999, 0, 0, 1, 29, NULL, '2021-05-19 08:44:30', '2021-06-09 09:09:01', NULL, 'PUBLISH'),
(7, NULL, 2, 'MCLCV.001', 'CVT GREASE 10ML ( 50 X 1 PCS )', 'cvt-grease-10ml-50-x-1-pcs', 'CVT GREASE 10ML ( 50 X 1 PCS )', NULL, 152000.00, 152000.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:30', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(8, NULL, 2, 'MCLFP.002', 'FULL PENETRATE 300 ML ( 20 X 1 KLG )', 'full-penetrate-300-ml-20-x-1-klg', 'FULL PENETRATE 300 ML ( 20 X 1 KLG )', NULL, 377600.00, 377600.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:30', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(9, NULL, 2, 'MCLFP.001', 'FULL PENETRATE 500 ML ( 20 X 1 KLG )', 'full-penetrate-500-ml-20-x-1-klg', 'FULL PENETRATE 500 ML ( 20 X 1 KLG )', NULL, 446400.00, 446400.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(10, NULL, 2, 'MCCIC.001', 'INJECTION CLEANING SYSTEM 100ML ( 20 X 1 KLG )', 'injection-cleaning-system-100ml-20-x-1-klg', 'INJECTION CLEANING SYSTEM 100ML ( 20 X 1 KLG )', NULL, 300000.00, 300000.00, 0.00, 9999999, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-06-09 09:09:01', NULL, 'PUBLISH'),
(11, NULL, 1, 'MCLOG.002', 'OLI GEAR MATIC 120 ML ( 20 X 1 BTL )', 'oli-gear-matic-120-ml-20-x-1-btl', 'OLI GEAR MATIC 120 ML ( 20 X 1 BTL )', NULL, 196000.00, 196000.00, 0.00, 1970, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2022-01-25 10:49:42', NULL, 'PUBLISH'),
(12, NULL, 1, 'MCLOG.001', 'OLI GEAR MATIC 100 ML ( 20 X 1 BTL )', 'oli-gear-matic-100-ml-20-x-1-btl', 'OLI GEAR MATIC 100 ML ( 20 X 1 BTL )', NULL, 156800.00, 156800.00, 0.00, 2000, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-09-11 17:26:11', NULL, 'DRAFT'),
(13, NULL, 1, 'MCMMO.004', 'MO+SHINE 150 ML ( 12 X 1 BTL )', 'moshine-150-ml-12-x-1-btl', 'MO+SHINE 150 ML ( 12 X 1 BTL )', NULL, 288000.00, 288000.00, 0.00, 1980, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2022-01-25 10:49:42', NULL, 'PUBLISH'),
(14, NULL, 1, 'MCMMO.002', 'MO+SHINE 400 ML ( 20 X 1 PCS )', 'moshine-400-ml-20-x-1-pcs', 'MO+SHINE 400 ML ( 20 X 1 PCS )', NULL, 752000.00, 752000.00, 0.00, 9999989, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-07-02 02:49:27', NULL, 'PUBLISH'),
(15, NULL, 1, 'MCMMO.001', 'MO+SHINE 500 ML ( 20 X 1 BTL )', 'moshine-500-ml-20-x-1-btl', 'MO+SHINE 500 ML ( 20 X 1 BTL )', NULL, 1280000.00, 1280000.00, 0.00, 9999983, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-10-18 07:25:16', NULL, 'PUBLISH'),
(16, NULL, 1, 'MCMRC.003', 'RADIATOR COOLANT - LITER GREEN (20 X 1LTR)', 'radiator-coolant-liter-green-20-x-1ltr', 'RADIATOR COOLANT - LITER GREEN (20 X 1LTR)', NULL, 252800.00, 252800.00, 0.00, 9999985, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-09-16 18:21:01', NULL, 'PUBLISH'),
(17, NULL, 1, 'MCMRC.001', 'RADIATOR COOLANT - GALON GREEN (4 X 5 LTR)', 'radiator-coolant-galon-green-4-x-5-ltr', 'RADIATOR COOLANT - GALON GREEN (4 X 5 LTR)', NULL, 104640.00, 104640.00, 0.00, 9999976, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-10-28 16:43:54', NULL, 'PUBLISH'),
(19, NULL, 1, 'MCMRC.002', 'RADIATOR COOLANT - GALON RED (4 X 5 LTR)', 'radiator-coolant-galon-red-4-x-5-ltr', 'RADIATOR COOLANT - GALON RED (4 X 5 LTR)', NULL, 104640.00, 104640.00, 0.00, 9999998, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-07-02 17:27:45', NULL, 'PUBLISH'),
(20, NULL, 1, 'MCLSB.001', 'OLI SHOCK BREAKER 100 ML (20 X 1 PSG)', 'oli-shock-breaker-100-ml-20-x-1-psg', 'OLI SHOCK BREAKER 100 ML (20 X 1 PSG)', NULL, 207200.00, 207200.00, 0.00, 9999987, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-06-15 14:31:31', NULL, 'PUBLISH'),
(21, NULL, 1, 'MCMWX.002', 'SiO2 SLICK WAX 250ML ( 12 X 1 BTL )', 'sio2-slick-wax-250ml-12-x-1-btl', 'SiO2 SLICK WAX 250ML ( 12 X 1 BTL )', NULL, 240000.00, 240000.00, 0.00, 9999997, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-10-26 07:41:46', NULL, 'PUBLISH'),
(22, NULL, 1, 'MCMWX.001', 'SiO2 SLICK WAX 500ML ( 12 X 1 BTL )', 'sio2-slick-wax-500ml-12-x-1-btl', 'SiO2 SLICK WAX 500ML ( 12 X 1 BTL )', NULL, 480000.00, 480000.00, 0.00, 9999936, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-11-04 08:51:18', NULL, 'PUBLISH'),
(23, NULL, 1, 'MCLUL.001', 'ULTRALUBE 300 ML ( 20 X 1 KLG )', 'ultralube-300-ml-20-x-1-klg', 'ULTRALUBE 300 ML ( 20 X 1 KLG )', NULL, 560000.00, 560000.00, 0.00, 9999996, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-09-28 13:46:48', NULL, 'PUBLISH'),
(24, NULL, 1, 'MCMWF.002', 'WIPER FLUID 400ML - POUCH', 'wiper-fluid-400ml-pouch', 'WIPER FLUID 400ML - POUCH', NULL, 96000.00, 96000.00, 0.00, 9999998, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-09-28 13:46:48', NULL, 'PUBLISH'),
(25, NULL, 1, 'MCMWF.001', 'WIPER FLUID 500ML ( 20 X 1 BTL )', 'wiper-fluid-500ml-20-x-1-btl', 'WIPER FLUID 500ML ( 20 X 1 BTL )', NULL, 240000.00, 240000.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(26, NULL, 1, 'MCMWR.002', 'ZERO DROP 250ML ( 12 X 1 BTL )', 'zero-drop-250ml-12-x-1-btl', 'ZERO DROP 250ML ( 12 X 1 BTL )', NULL, 240000.00, 240000.00, 0.00, 9999998, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-09-29 03:31:13', NULL, 'PUBLISH'),
(27, NULL, 1, 'MCMWR.001', 'ZERO DROP 500ML ( 12 X 1 BTL )', 'zero-drop-500ml-12-x-1-btl', 'ZERO DROP 500ML ( 12 X 1 BTL )', NULL, 480000.00, 480000.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(28, NULL, 1, 'MCCCC.001', 'CARBURATOR CLEANER 500 ML ( 20 X 1 KLG)', 'carburator-cleaner-500-ml-20-x-1-klg', 'CARBURATOR CLEANER 500 ML ( 20 X 1 KLG)', NULL, 300000.00, 300000.00, 0.00, 9999989, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-09-16 15:55:21', NULL, 'PUBLISH'),
(29, NULL, 1, 'MCCCC.002', 'CARBURATOR CLEANER 300 ML ( 20 X 1 KLG)', 'carburator-cleaner-300-ml-20-x-1-klg', 'CARBURATOR CLEANER 300 ML ( 20 X 1 KLG)', NULL, 300000.00, 300000.00, 0.00, 9999998, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-09-20 02:23:27', NULL, 'PUBLISH'),
(30, NULL, 1, 'MCCBX.001', 'PAKET BOMAX ICS 100 ML ( 8 KLG ICS + 1 MCT )', 'paket-bomax-ics-100-ml-8-klg-ics-1-mct', 'PAKET BOMAX ICS 100 ML ( 8 KLG ICS + 1 MCT )', NULL, 300000.00, 300000.00, 0.00, 2, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2022-01-25 10:27:38', NULL, 'PUBLISH'),
(31, NULL, 1, 'MCCBX.002', 'PAKET BOMAX ICS 100 ML - VIXION', 'paket-bomax-ics-100-ml-vixion', 'PAKET BOMAX ICS 100 ML - VIXION', NULL, 300000.00, 300000.00, 0.00, 9999989, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-09-12 17:43:55', '2021-09-12 17:43:55', 'PUBLISH'),
(32, NULL, 1, 'MCMCT.001', 'MEGACOOLS CLEANING TOOLS', 'megacools-cleaning-tools', 'MEGACOOLS CLEANING TOOLS', NULL, 300000.00, 300000.00, 0.00, 9999998, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2021-07-12 03:13:58', NULL, 'PUBLISH'),
(33, NULL, 1, 'MCMCT.002', 'MEGACOOLS CLEANING TOOLS - VIXION', 'megacools-cleaning-tools-vixion', 'MEGACOOLS CLEANING TOOLS - VIXION', NULL, 300000.00, 300000.00, 0.00, 9999985, 0, 0, 1, 29, NULL, '2021-05-19 08:44:31', '2022-01-12 16:02:07', NULL, 'PUBLISH'),
(34, NULL, 1, 'MCLBF.003', 'BRAKE FLUID 1000 ML - CLEAR ( 1 X 12 BTL )', 'brake-fluid-1000-ml-clear-1-x-12-btl', 'BRAKE FLUID 1000 ML - CLEAR ( 1 X 12 BTL )', NULL, 647040.00, 647040.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(35, NULL, 1, 'MCLBF.002', 'BRAKE FLUID 300 ML - CLEAR ( 1 X 24 BTL )', 'brake-fluid-300-ml-clear-1-x-24-btl', 'BRAKE FLUID 300 ML - CLEAR ( 1 X 24 BTL )', NULL, 433920.00, 433920.00, 0.00, 9999998, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-09-29 03:31:13', NULL, 'PUBLISH'),
(36, NULL, 1, 'MCLBF.001', 'BRAKE FLUID 50 ML - CLEAR ( 1 X 24 BTL )', 'brake-fluid-50-ml-clear-1-x-24-btl', 'BRAKE FLUID 50 ML - CLEAR ( 1 X 24 BTL )', NULL, 115200.00, 115200.00, 0.00, 9999987, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-09-16 15:55:21', NULL, 'PUBLISH'),
(37, NULL, 1, 'MCMKV.002', 'BIO KIVO 350 ML', 'bio-kivo-350-ml', 'BIO KIVO 350 ML', NULL, 864000.00, 864000.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(38, NULL, 1, 'MCMKV.001', 'BIO KIVO 5000 ML', 'bio-kivo-5000-ml', 'BIO KIVO 5000 ML', NULL, 1088000.00, 1088000.00, 0.00, 9999999, 0, 0, 1, 1, NULL, '2021-05-19 08:44:31', '2021-05-19 08:55:35', NULL, 'PUBLISH'),
(39, NULL, 1, 'ASAS', 'ASas', 'asas', 'oklek', NULL, 50000.00, 50000.00, 0.00, 20, 0, 0, 1, 29, NULL, '2021-05-26 16:38:07', '2022-02-04 09:25:15', NULL, 'PUBLISH'),
(40, NULL, 1, 'ASDFSDF', 'sfsdfsdf', 'sfsdfsdf', 'oklek', NULL, 60000.00, 60000.00, 0.00, 0, 0, 0, 1, 29, NULL, '2021-05-26 16:41:11', '2021-06-09 09:09:34', NULL, 'PUBLISH'),
(43, NULL, NULL, NULL, 'No Product', 'no-product-for-checkout', 'No Product', NULL, 0.00, 0.00, 0.00, 0, 0, 0, 0, NULL, NULL, '2021-09-06 03:04:54', '2021-09-06 03:04:54', NULL, 'PUBLISH'),
(44, NULL, 1, '13100004001000000002', 'EKA1000 F   DISC.4\" VELCRO', 'eka1000-f-disc4-velcro', 'EKA1000 F   DISC.4\" VELCRO', 'products-images/kpVTkZytpojlsSBH9StMUkqyRw3jRStJZWPi99rA.jpg', 13300.00, 13300.00, 0.00, 0, 0, 0, 29, 29, NULL, '2021-09-16 05:47:19', '2022-01-19 03:46:20', NULL, 'PUBLISH'),
(41, NULL, 2, 'TNT-TEST01', 'test tnt edit', 'test-tnt', 'test tnt', NULL, 129000.00, 129000.00, 0.00, 2, 0, 1, 24, 24, NULL, '2021-06-09 05:06:04', '2021-06-09 06:06:38', NULL, 'PUBLISH'),
(45, NULL, 1, 'MEGA007', 'MEGACOOLS BRAKE PART CLEANER 500 ML', 'megacools-brake-part-cleaner-500-ml', 'MEGACOOLS BRAKE PART CLEANER 500 ML', NULL, 511680.00, 511680.00, 0.00, 5000, 0, 0, 29, NULL, NULL, '2022-01-05 04:15:54', '2022-01-05 04:15:54', NULL, 'PUBLISH'),
(46, NULL, 1, 'MEGA006', 'MEGACOOLS CONTACT CLEANER 500 ML', 'megacools-contact-cleaner-500-ml', 'MEGACOOLS CONTACT CLEANER 500 ML', NULL, 511680.00, 511680.00, 0.00, 5000, 0, 0, 29, NULL, NULL, '2022-01-05 04:15:54', '2022-01-05 04:15:54', NULL, 'PUBLISH');

-- --------------------------------------------------------

--
-- Table structure for table `product_rewards`
--

CREATE TABLE `product_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity_rule` int(10) UNSIGNED NOT NULL,
  `prod_point_val` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','EXPIRED') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_rewards`
--

INSERT INTO `product_rewards` (`id`, `client_id`, `product_id`, `quantity_rule`, `prod_point_val`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 24, 2, 1, '2021-09-27 18:58:24', '2021-09-28 02:50:42', 'ACTIVE'),
(3, 1, 33, 2, 1, '2021-09-27 18:58:24', '2021-09-29 20:59:51', 'EXPIRED'),
(4, 1, 22, 3, 1, '2021-09-28 13:42:59', '2021-09-30 03:10:08', 'EXPIRED'),
(5, 1, 23, 1, 1, '2021-09-28 13:42:59', '2021-09-28 13:42:59', 'ACTIVE'),
(7, 1, 33, 2, 2, '2021-09-29 20:59:51', '2021-09-29 20:59:51', 'ACTIVE'),
(9, 1, 22, 2, 20, '2021-09-30 03:10:08', '2021-10-01 08:49:07', 'ACTIVE'),
(10, 1, 4, 2, 1, '2022-01-25 11:12:15', '2022-01-25 11:12:15', 'ACTIVE'),
(11, 1, 11, 2, 2, '2022-01-25 11:12:15', '2022-01-25 11:12:15', 'ACTIVE'),
(12, 1, 13, 4, 1, '2022-01-25 11:12:15', '2022-01-25 11:12:15', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_status`
--

CREATE TABLE `product_stock_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` enum('ON','OFF') COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stock_status`
--

INSERT INTO `product_stock_status` (`id`, `status_name`, `stock_status`, `client_id`, `created_at`, `updated_at`) VALUES
(3, 'Product Stock-Mega Pro', 'ON', 2, NULL, NULL),
(4, 'Product Stock-Mega Cool', 'ON', 1, NULL, NULL),
(5, 'Product Stock-Asli', 'ON', 10, NULL, NULL),
(6, 'Product Stock-Owner', 'ON', 3, NULL, NULL),
(7, 'Product Stock-New Test', 'ON', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_targets`
--

CREATE TABLE `product_targets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `storeTargetId` bigint(20) UNSIGNED NOT NULL,
  `productId` int(10) UNSIGNED NOT NULL,
  `nominalValues` double(11,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `quantityValues` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_targets`
--

INSERT INTO `product_targets` (`id`, `storeTargetId`, `productId`, `nominalValues`, `quantityValues`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 30000.00, 3, '2021-11-11 09:59:20', '2021-11-11 09:59:20'),
(2, 1, 4, 60000.00, 6, '2021-11-11 09:59:20', '2021-11-11 09:59:20'),
(3, 2, 2, 30000.00, 3, '2021-11-11 09:59:20', '2021-11-11 09:59:20'),
(4, 2, 4, 20000.00, 2, '2021-11-11 09:59:20', '2021-11-11 09:59:20'),
(5, 3, 2, 1301760.00, 3, '2021-11-11 09:59:51', '2021-11-16 08:32:28'),
(7, 4, 2, 1301760.00, 3, '2021-11-11 09:59:51', '2021-11-16 08:32:28'),
(8, 4, 4, 600000.00, 2, '2021-11-11 09:59:51', '2021-11-27 17:01:02'),
(9, 5, 2, 1301760.00, 3, '2021-11-11 10:00:08', '2021-11-16 08:32:28'),
(10, 5, 4, 1800000.00, 6, '2021-11-11 10:00:08', '2021-11-27 17:01:02'),
(11, 6, 2, 1301760.00, 3, '2021-11-11 10:00:08', '2021-11-16 08:32:28'),
(12, 6, 4, 600000.00, 2, '2021-11-11 10:00:08', '2021-11-27 17:01:02'),
(13, 7, 2, 1735680.00, 4, '2021-11-12 03:28:29', '2021-11-16 08:32:28'),
(14, 8, 4, 600000.00, 2, '2021-11-12 03:45:23', '2021-11-27 17:01:02'),
(15, 9, 13, 30000.00, 2, '2021-11-12 04:07:34', '2021-11-12 04:07:34'),
(16, 3, 4, 1800000.00, 6, '2021-11-12 08:01:42', '2021-11-27 17:01:02'),
(17, 10, 2, 1735680.00, 4, '2021-11-12 08:01:42', '2021-11-16 08:32:28'),
(18, 11, 4, 600000.00, 2, '2021-11-12 08:01:42', '2021-11-27 17:01:02'),
(19, 12, 13, 30000.00, 2, '2021-11-12 08:01:42', '2021-11-12 08:01:42'),
(20, 13, 2, 1301760.00, 3, '2021-11-12 08:01:42', '2021-11-16 08:32:28'),
(21, 13, 4, 1800000.00, 6, '2021-11-12 08:01:42', '2021-11-27 17:01:02'),
(22, 14, 4, 600000.00, 2, '2021-11-12 08:01:42', '2021-11-27 17:01:02'),
(23, 14, 2, 1735680.00, 4, '2021-11-12 08:01:42', '2021-11-16 08:32:28'),
(24, 15, 2, 4339200.00, 10, '2021-11-16 04:50:02', '2021-11-16 08:32:28'),
(25, 15, 4, 3600000.00, 12, '2021-11-16 04:50:02', '2021-11-16 04:50:02'),
(26, 16, 2, 4773120.00, 11, '2021-11-16 04:50:02', '2021-11-16 08:32:28'),
(27, 16, 4, 4500000.00, 15, '2021-11-16 04:50:02', '2021-11-16 04:50:02'),
(28, 17, 2, 4339200.00, 10, '2021-11-16 06:03:18', '2021-11-16 08:32:28'),
(29, 17, 4, 3600000.00, 12, '2021-11-16 06:03:18', '2021-11-16 06:03:18'),
(30, 18, 2, 8678400.00, 20, '2021-11-16 06:03:18', '2021-11-16 08:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `province`) VALUES
(1, 'Bali'),
(2, 'Bangka Belitung'),
(3, 'Banten'),
(4, 'Bengkulu'),
(5, 'DI Yogyakarta'),
(6, 'DKI Jakarta'),
(7, 'Gorontalo'),
(8, 'Jambi'),
(9, 'Jawa Barat'),
(10, 'Jawa Tengah'),
(11, 'Jawa Timur'),
(12, 'Kalimantan Barat'),
(13, 'Kalimantan Selatan'),
(14, 'Kalimantan Tengah'),
(15, 'Kalimantan Timur'),
(16, 'Kalimantan Utara'),
(17, 'Kepulauan Riau'),
(18, 'Lampung'),
(19, 'Maluku'),
(20, 'Maluku Utara'),
(21, 'Nanggroe Aceh Darussalam (NAD)'),
(22, 'Nusa Tenggara Barat (NTB)'),
(23, 'Nusa Tenggara Timur (NTT)'),
(24, 'Papua'),
(25, 'Papua Barat'),
(26, 'Riau'),
(27, 'Sulawesi Barat'),
(28, 'Sulawesi Selatan'),
(29, 'Sulawesi Tengah'),
(30, 'Sulawesi Tenggara'),
(31, 'Sulawesi Utara'),
(32, 'Sumatera Barat'),
(33, 'Sumatera Selatan'),
(34, 'Sumatera Utara');

-- --------------------------------------------------------

--
-- Table structure for table `reasons_checkouts`
--

CREATE TABLE `reasons_checkouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `reasons_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reasons_checkouts`
--

INSERT INTO `reasons_checkouts` (`id`, `client_id`, `reasons_name`, `position`, `created_at`, `updated_at`) VALUES
(2, 1, 'Tidak mau beli b', 2, '2021-08-25 06:16:22', '2021-08-25 06:29:05'),
(3, 1, 'stok barang habis', 3, '2021-08-26 06:39:15', '2021-08-26 06:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `sales_targets`
--

CREATE TABLE `sales_targets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target_values` double(12,2) NOT NULL,
  `target_achievement` double(12,2) NOT NULL,
  `period` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `ppn` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `target_type` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `target_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_targets`
--

INSERT INTO `sales_targets` (`id`, `client_id`, `user_id`, `target_values`, `target_achievement`, `period`, `created_at`, `updated_at`, `created_by`, `updated_by`, `ppn`, `target_type`, `target_quantity`) VALUES
(11, 1, 5, 20000000.00, 0.00, '2021-07-01', '2021-07-11 22:47:25', '2021-07-12 02:31:57', 29, 2, 0, 1, 0),
(13, 1, 5, 240000000.00, 0.00, '2021-08-01', '2021-08-02 06:43:48', '2021-08-02 06:43:48', NULL, NULL, 0, 2, 0),
(15, 1, 4, 240000000.00, 0.00, '2021-08-01', '2021-08-05 13:54:55', '2021-08-05 13:54:55', NULL, NULL, 0, 2, 0),
(17, 1, 3, 240000000.00, 0.00, '2021-06-01', '2021-08-05 14:36:55', '2021-08-05 15:22:06', 29, 38, 0, 0, 0),
(18, 1, 3, 240000000.00, 0.00, '2021-07-01', '2021-08-05 15:16:27', '2021-09-16 17:45:06', 29, 29, 0, 2, 0),
(19, 1, 3, 40000000.00, 13562720.00, '2021-09-01', '2021-08-26 17:17:09', '2021-09-29 05:46:16', 29, 29, 1, 0, 0),
(20, 1, 8, 25000000.00, 0.00, '2021-08-01', '2021-08-31 21:40:56', '2021-08-31 21:40:56', 29, NULL, 0, 2, 0),
(21, 1, 6, 240000000.00, 0.00, '2021-08-01', '2021-09-01 03:05:05', '2021-09-01 03:05:05', 29, NULL, 1, 2, 0),
(22, 1, 6, 250000000.00, 0.00, '2021-09-01', '2021-09-01 03:05:45', '2021-09-01 03:05:45', 29, NULL, 0, 0, 0),
(23, 1, 3, 9000000000.00, -8317178.18, '2021-08-01', '2021-09-01 03:07:41', '2021-09-16 17:46:54', 29, 29, 1, 2, 0),
(24, 1, 4, 39.00, 0.00, '2021-09-01', '2021-09-01 04:25:28', '2021-09-01 04:25:28', 29, NULL, 1, 0, 0),
(25, 1, 3, 35000000.00, 0.00, '2021-12-01', '2021-09-01 04:29:21', '2021-09-01 04:29:21', 29, NULL, 1, 0, 0),
(26, 1, 4, 45000000.00, 0.00, '2021-10-01', '2021-10-13 02:46:08', '2022-01-03 17:08:35', 29, 29, 1, 2, 0),
(27, 1, 3, 0.00, 8727272.73, '2021-10-01', '2021-10-13 02:50:13', '2021-10-13 02:50:13', 29, NULL, 1, 0, 0),
(28, 1, 5, 450000000.00, 16826458.18, '2021-10-01', '2021-10-13 02:51:33', '2021-10-28 16:43:54', 29, 29, 1, 3, 500),
(29, 1, 6, 40000000.00, 0.00, '2021-10-01', '2021-10-13 02:52:22', '2021-10-13 02:52:22', 29, NULL, 1, 0, 0),
(30, 1, 8, 0.00, 0.00, '2021-10-01', '2021-10-13 09:16:18', '2021-10-13 09:16:18', 29, NULL, 0, 1, 20),
(31, 1, 8, 0.00, 0.00, '2021-11-01', '2021-10-13 09:17:09', '2021-10-13 14:59:28', 29, 29, 0, 1, 20),
(32, 1, 8, 3000000.00, 0.00, '2021-12-01', '2021-10-13 09:17:49', '2021-10-13 09:17:49', 29, NULL, 0, 3, 30),
(33, 1, 40, 0.00, 0.00, '2021-08-01', '2021-10-18 04:49:58', '2021-10-18 05:01:03', 29, 29, 0, 2, 0),
(34, 1, 5, 0.00, 64396290.91, '2021-11-01', '2021-11-01 05:16:46', '2021-12-10 09:19:51', 29, 38, 1, 1, 20),
(35, 1, 5, 420000000.00, 0.00, '2021-12-01', '2021-12-01 03:11:10', '2021-12-01 03:11:10', 29, NULL, 1, 2, 0),
(36, 1, 4, 25000000.00, 0.00, '2021-07-01', '2021-12-09 08:15:29', '2021-12-09 08:15:29', 38, NULL, 1, 1, 10),
(37, 1, 3, 2000000.00, 0.00, '2021-11-01', '2021-12-10 07:45:42', '2021-12-10 07:54:30', 38, 38, 1, 2, 0),
(38, 1, 4, 30000.00, 0.00, '2021-11-01', '2021-12-10 08:49:13', '2021-12-10 08:49:13', 38, NULL, 1, 2, 0),
(39, 1, 5, 50000000.00, 389371840.00, '2022-01-01', '2022-01-03 02:33:05', '2022-01-25 10:29:29', 29, NULL, 0, 3, 100);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fWxywZ3sjWQeUbBsjMSYX2mupW9Oy0om1yJrfJA1', 29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTlQyQTRqU005WFQydlZlSzMyQ1VweEN0Wkc3VGxoM3VzT0F2ZzR1ViI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYyOiJodHRwOi8vbG9jYWxob3N0L2FwcF9zdWRhaGRpZ2l0YWwvbWVnYS1jb29sL3Byb2R1Y3RzL2xvd19zdG9jayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI5O3M6MTE6ImNsaWVudF9zZXNzIjthOjI6e3M6MTE6ImNsaWVudF9uYW1lIjtzOjk6Ik1lZ2EgQ29vbCI7czoxMjoiY2xpZW50X2ltYWdlIjtzOjQwOiIvY2xpZW50X2ltYWdlL0xPR08gTUVHQUNPT0xTX0RFRkFVTFQucG5nIjt9fQ==', 1644202375);

-- --------------------------------------------------------

--
-- Table structure for table `spv_sales`
--

CREATE TABLE `spv_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `spv_id` int(10) UNSIGNED DEFAULT NULL,
  `sls_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spv_sales`
--

INSERT INTO `spv_sales` (`id`, `spv_id`, `sls_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 38, 3, 'ACTIVE', '2021-09-12 08:59:35', '2021-09-12 16:19:15'),
(2, 38, 4, 'ACTIVE', '2021-09-12 08:59:35', '2021-09-12 16:19:15'),
(5, 38, 5, 'ACTIVE', '2021-09-12 16:10:08', '2021-09-12 16:19:15'),
(7, 38, 6, 'ACTIVE', '2021-12-06 09:21:28', '2021-12-06 09:21:28'),
(8, 38, 8, 'ACTIVE', '2021-12-06 09:21:37', '2021-12-06 09:21:37'),
(9, 76, 75, 'ACTIVE', '2022-01-25 06:51:48', '2022-01-25 06:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `store_target`
--

CREATE TABLE `store_target` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `target_values` double(14,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `target_achievement` double(14,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `period` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `version_pareto` bigint(20) DEFAULT NULL,
  `target_type` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `target_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_target`
--

INSERT INTO `store_target` (`id`, `client_id`, `customer_id`, `target_values`, `target_achievement`, `period`, `created_at`, `updated_at`, `created_by`, `updated_by`, `version_pareto`, `target_type`, `target_quantity`) VALUES
(1, 1, 2, 0.00, 0.00, '2021-10-01', '2021-11-11 09:59:20', '2021-11-11 09:59:20', 29, 29, 4, 3, 0),
(2, 1, 55, 0.00, 0.00, '2021-10-01', '2021-11-11 09:59:20', '2021-11-11 09:59:20', 29, 29, 4, 3, 0),
(3, 1, 2, 0.00, 0.00, '2021-11-01', '2021-11-11 09:59:51', '2021-11-12 08:01:42', 29, 29, 4, 3, 0),
(4, 1, 55, 0.00, 0.00, '2021-11-01', '2021-11-11 09:59:51', '2021-11-12 08:01:42', 29, 29, 4, 3, 0),
(5, 1, 2, 0.00, 0.00, '2021-12-01', '2021-11-11 10:00:08', '2021-11-12 04:13:18', 29, 29, 4, 3, 0),
(6, 1, 55, 0.00, 0.00, '2021-12-01', '2021-11-11 10:00:08', '2021-11-12 04:13:18', 29, 29, 4, 3, 0),
(7, 1, 482, 0.00, 0.00, '2021-12-01', '2021-11-12 03:28:29', '2021-11-12 04:13:18', 29, 29, 4, 3, 0),
(8, 1, 517, 0.00, 0.00, '2021-12-01', '2021-11-12 03:45:23', '2021-11-12 04:13:18', 29, 29, 4, 3, 0),
(9, 1, 519, 0.00, 0.00, '2021-12-01', '2021-11-12 04:07:34', '2021-11-12 04:13:18', 29, 29, 4, 3, 0),
(10, 1, 482, 0.00, 0.00, '2021-11-01', '2021-11-12 08:01:42', '2021-11-12 08:01:42', 29, NULL, 4, 3, 0),
(11, 1, 517, 0.00, 0.00, '2021-11-01', '2021-11-12 08:01:42', '2021-11-12 08:01:42', 29, NULL, 4, 3, 0),
(12, 1, 519, 0.00, 0.00, '2021-11-01', '2021-11-12 08:01:42', '2021-11-12 08:01:42', 29, NULL, 4, 3, 0),
(13, 1, 525, 0.00, 0.00, '2021-11-01', '2021-11-12 08:01:42', '2021-11-12 08:01:42', 29, 29, 4, 3, 0),
(14, 1, 518, 0.00, 0.00, '2021-11-01', '2021-11-12 08:01:42', '2021-11-12 08:01:42', 29, 29, 4, 3, 0),
(15, 1, 2, 0.00, 0.00, '2022-01-01', '2021-11-16 04:50:02', '2021-11-16 04:50:02', 29, 29, 4, 3, 0),
(16, 1, 525, 0.00, 0.00, '2022-01-01', '2021-11-16 04:50:02', '2021-11-16 04:50:02', 29, 29, 4, 3, 0),
(17, 1, 2, 0.00, 0.00, '2022-02-01', '2021-11-16 06:03:18', '2021-11-16 06:03:18', 29, 29, 4, 3, 0),
(18, 1, 525, 0.00, 0.00, '2022-02-01', '2021-11-16 06:03:18', '2021-11-16 06:03:18', 29, 29, 4, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `type_customer`
--

CREATE TABLE `type_customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_customer`
--

INSERT INTO `type_customer` (`id`, `name`, `status`, `client_id`, `created_at`, `updated_at`) VALUES
(4, 'DISTRIBUTOR', 'ACTIVE', 1, '2021-06-28 09:27:54', '2021-06-28 09:27:54'),
(5, 'PREMIUM STORE', 'ACTIVE', 1, '2021-06-28 21:19:12', '2021-06-28 21:19:12'),
(6, 'REGULAR STORE', 'ACTIVE', 1, '2021-06-28 21:19:20', '2021-06-28 21:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `profile_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `roles`, `address`, `city_id`, `profile_desc`, `phone`, `avatar`, `status`, `sales_area`) VALUES
(37, 10, 'Superadmin', 'asli@email.com', NULL, '$2y$10$xwDmY1ez9yKPTuBeps1ApOsF8BiRlxU8aneTrNz7rXBdD70jJZ1eO', NULL, '2021-06-17 18:22:30', '2021-06-17 18:22:31', NULL, 'SUPERADMIN', NULL, NULL, NULL, NULL, NULL, 'ACTIVE', NULL),
(2, 1, 'Admin', 'admin_cools@admin.com', NULL, '$2y$10$65zUBzHyYhqZItg1CJFIe.1DAfmo.gVePIKDsCcwA.ltuq0RNxJwS', NULL, '2020-11-08 10:50:27', '2021-04-29 15:55:16', NULL, 'ADMIN', 'Address Mega Cools', NULL, NULL, '999999999999', 'avatars/8QQimiPKSDY8QDxAUk7dhGyzJPIDHmzu4ZqrwwbD.png', 'ACTIVE', NULL),
(3, 1, 'Anonymouse', 'sales@test.com', NULL, '$2y$10$k5RT4MmT1DaIpRjqcfxgzuHT.F4MUn5WMmF2NyXORzr5DRTiXfhhq', NULL, '2021-09-12 07:26:59', '2021-09-12 07:28:15', NULL, 'SALES', 'Tangerang', NULL, NULL, '1231234234234', NULL, 'ACTIVE', 'Jabodetabek'),
(4, 1, 'DENI PURNAMA', 'deni@test.com', NULL, '$2y$10$jkKBFcixHCQOCI.kfTyjd.zWG3Tu9CykzWwkn5bPDY6IOgwBgc5bC', NULL, '2021-02-25 04:08:41', '2021-03-12 03:14:44', NULL, 'SALES', 'Jakarta Selatan', NULL, NULL, '021000000000', NULL, 'ACTIVE', 'Retail - JABOTABEK'),
(5, 1, 'DENVIN', 'denvin@test.com', NULL, '$2y$10$0dzgluA3/2yNHsOr3JBLn.zG5.U6XkBlBAqXlIjD2hYDxmNCaLDOW', NULL, '2021-02-25 04:09:43', '2021-02-25 04:09:43', NULL, 'SALES', 'Bekasi', NULL, NULL, '021000000000', NULL, 'ACTIVE', 'Retail - JABOTABEK'),
(6, 1, 'HIDAYAT', 'hidayat@test.com', NULL, '$2y$10$d.NRdsD6YotA0h9Zd9b.J.4cSoj.en549LLkM1baWCB0QFO8borpi', NULL, '2021-02-25 04:10:55', '2021-02-25 04:10:55', NULL, 'SALES', 'DEPOK', NULL, NULL, '021000000002', NULL, 'ACTIVE', 'Retail - JABOTABEK'),
(7, 1, 'KRIS', 'kris@test.com', NULL, '$2y$10$5bERIPan8/3jwOxTIKDNEusRZynB7OvwS468TN3oCXVozQaHZVaNy', NULL, '2021-02-25 04:11:46', '2021-02-25 04:11:46', NULL, 'SALES', 'JAKTIM', NULL, NULL, '021000000003', NULL, 'ACTIVE', 'Retail - JABOTABEK'),
(8, 1, 'WARJANTO', 'warjanto@test.com', NULL, '$2y$10$NhVujzPVCsUJYDcv03jUHe7GnTaYYMpM6eFA/LR88uvWKz1byqlHa', NULL, '2021-02-25 04:12:46', '2021-02-25 04:12:46', NULL, 'SALES', 'BEKASI', NULL, NULL, '021000000004', NULL, 'ACTIVE', 'Retail - JABOTABEK'),
(9, 2, 'Zuki', 'spv_21@test.com', NULL, '$2y$10$iJ2x.PnVNORVrWBOfrvda.5tmUoI0yL3naM6rD.JqPSPyIkHIzQCe', NULL, '2021-04-01 10:22:07', '2021-04-01 10:22:07', NULL, 'SALES', 'Tangerang', NULL, NULL, '0282113464465', NULL, 'ACTIVE', 'Tangerang'),
(31, 1, 'test tnt sls edit', 'test_sales@sales.com', NULL, '$2y$10$zHr9BarSalutoqSFe8SXAOmz1LOCGocsbQIcyY.JCGomgosU/emvW', NULL, '2021-06-08 02:34:11', '2021-06-15 10:11:01', NULL, 'SALES', 'asdasdfasfsf', NULL, 'sdgfsdg', '123124234242', 'avatars/PuzsiZtzKgjdWqMkaOogJXcT2ndN06yFve3V1tZH.png', 'ACTIVE', 'Jakarta'),
(21, 1, 'spvtest', 'spvtest@test.com', NULL, '$2y$10$zHr9BarSalutoqSFe8SXAOmz1LOCGocsbQIcyY.JCGomgosU/emvW', NULL, '2021-04-29 17:01:57', '2021-06-17 19:38:18', NULL, 'SUPERVISOR', 'addr apv test', NULL, NULL, '0987654321', 'avatars/y1HPBYsrjh3YDF3LhY058bIntYwE6gprYT1OsYla.jpg', 'ACTIVE', NULL),
(38, 1, 'Karijan', 'setyawanzuky@gmail.com', NULL, '$2y$10$pK7x/D.TPlTybibz160tW.diNQrBLfCcPnJ2.vcCVWVrQIOWrpOdO', NULL, '2021-09-12 08:59:35', '2021-09-12 16:19:15', NULL, 'SUPERVISOR', 'Tangerang', NULL, NULL, '0192983838485', 'avatars/8sjw1WggfVdTTzTZEIIVpCc3MMYVqOCsx59Mf4Ho.jpg', 'ACTIVE', NULL),
(24, 2, 'Super Hot', 'super_pro@admin.com', NULL, '$2y$10$odzJCZUNbbU4d9Lwb6EYYO6DXWk1Hlg5cUZL3BgkG9gMAW/q0NDcG', NULL, '2021-06-03 13:07:28', '2021-06-03 13:07:28', NULL, 'SUPERADMIN', 'Superhot', NULL, NULL, '029293838474', 'avatars/WEROePaiRUUlMgKqoYrAY5IiZn0Nt2k23Cb90hzA.png', 'ACTIVE', NULL),
(25, 3, 'testenancy', 'testtenant@admin.com', NULL, '$2y$10$crReFNyT55nV9mHBSxS4sukI8qWjWjymr4i/nmzTVX796nmUFT1oy', NULL, '2021-06-04 13:06:48', '2021-06-06 17:40:05', NULL, 'SUPERADMIN', 'askdfhjawkjdfhbas', NULL, NULL, '123091239284', 'avatars/zqKwyw1nR6rWlGEmPq0jhfT2Dj2CdK39zYdIdRv1.png', 'ACTIVE', NULL),
(35, 3, 'Admin Sudahonline', 'admin@sudahonline.com', NULL, '$2y$10$Po8hETF8h1Iu.G8BX2zB4uHhihu1GMvZXjihxTke6HWElcgavNEKi', NULL, '2021-06-17 04:05:59', '2021-06-17 19:41:48', NULL, 'OWNER', NULL, NULL, NULL, NULL, NULL, 'ACTIVE', NULL),
(34, 2, 'coba', 'coba@mail.com', NULL, '$2y$10$P.jLIHyM/.mXNLbaBUi67uw9.v/RP7HGGlFF4iAjsCd24VX6CLAWq', NULL, '2021-06-08 04:11:22', '2021-06-08 04:11:22', NULL, 'SALES', 'asfasfsafd', NULL, NULL, '3412423423424', NULL, 'ACTIVE', 'Jakarta'),
(36, 9, 'Superadmin', 'ojo@new.com', NULL, 'superadmin', NULL, '2021-06-17 18:18:37', '2021-06-17 18:18:37', NULL, 'SUPERADMIN', NULL, NULL, NULL, NULL, NULL, 'ACTIVE', NULL),
(29, 1, 'Super Admin', 'super_cools@admin.com', NULL, '$2y$10$GZWmM3PhnqRaQ0EBDEEUxOIDsU5spLGVkHZKPpZG9LZ2WHNrSqc2K', NULL, NULL, '2021-06-10 18:10:10', NULL, 'SUPERADMIN', 'MEGA MEndung', NULL, NULL, '12345677899', NULL, 'ACTIVE', NULL),
(40, 1, 'Zuko', 'zuko@email.com', NULL, '$2y$10$CwUe9rXZ8SmEsQMT8ggck.sRkRgYyZWpdl.DGfC7YcFUMbbazU4XK', NULL, '2021-09-08 04:10:48', '2021-09-08 04:15:29', NULL, 'SALES', 'Kota Batara', NULL, NULL, '0239239230942', 'avatars/yfccHjW20bpWzw2g4cMLVcxNKo3GuiffedmO4jCs.png', 'ACTIVE', 'Jabotabek'),
(74, 12, 'Superadmin', 'newtest@test.com', NULL, '$2y$10$DG3xjDkq/SI/s8eiTskLy.pksvqcjW8i..jLGqMjhpZz0SiNIrjFO', NULL, '2022-01-25 06:48:27', '2022-01-25 06:48:28', NULL, 'SUPERADMIN', NULL, NULL, NULL, NULL, NULL, 'ACTIVE', NULL),
(75, 12, 'Sales1newtest', 'newtestsales@test.com', NULL, '$2y$10$3/.RmYDxeV9yAitmNn9oKuhieFCknz6B405gRdjbS8uJTj9xvcOqG', NULL, '2022-01-25 06:50:54', '2022-01-25 06:50:54', NULL, 'SALES', 'asddasfjasfsaf', NULL, NULL, '0129318237127', NULL, 'ACTIVE', 'Jakrata'),
(76, 12, 'newtestspv', 'newtestspv@test.com', NULL, '$2y$10$28JfF9gt9MaIdf.BXE6TsOwhU6.PWVi.hTbW6wmsZ.79iEMWcpqLW', NULL, '2022-01-25 06:51:48', '2022-01-25 06:51:48', NULL, 'SUPERVISOR', 'asfasfsafasf', NULL, NULL, '0593482374237', 'avatars/DYZNHkjIuE8HE4WQrfbc9jySndUfRxXZEeztYdzg.jpg', 'ACTIVE', NULL),
(77, 1, 'Sales Counter', 'salescounter@admin.com', NULL, '$2y$10$BZYCe.uHzRC4QiMQg7uSmeys0EynmsLvDPQuA6p5Aqr8LTsxIvn6G', NULL, '2022-01-27 08:39:19', '2022-01-27 08:39:19', NULL, 'SALES-COUNTER', 'Tangerang', NULL, NULL, '082113476254', NULL, 'ACTIVE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `volume_discounts`
--

CREATE TABLE `volume_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `min_order` int(10) UNSIGNED NOT NULL,
  `max_order` int(10) UNSIGNED NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volume_discounts`
--

INSERT INTO `volume_discounts` (`id`, `client_id`, `name`, `type`, `min_order`, `max_order`, `status`, `created_at`, `updated_at`) VALUES
(7, 1, 'test 1', 1, 1, 9, 'ACTIVE', '2022-01-10 03:43:38', '2022-01-13 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `volume_discount_products`
--

CREATE TABLE `volume_discount_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `volume_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `discount_price` double(11,2) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volume_discount_products`
--

INSERT INTO `volume_discount_products` (`id`, `volume_id`, `product_id`, `discount_price`, `created_at`, `updated_at`) VALUES
(36, 7, 2, 355814.40, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(37, 7, 4, 409344.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(38, 7, 11, 160720.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(39, 7, 12, 128576.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(40, 7, 13, 236160.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(41, 7, 14, 616640.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(42, 7, 15, 1049600.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(43, 7, 16, 207296.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(44, 7, 17, 85804.80, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(45, 7, 19, 85804.80, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(46, 7, 20, 169904.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(47, 7, 21, 196800.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(48, 7, 22, 393600.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(49, 7, 23, 459200.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(50, 7, 24, 78720.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(51, 7, 25, 196800.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(52, 7, 26, 196800.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(53, 7, 27, 393600.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(54, 7, 28, 366048.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(55, 7, 29, 309632.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(56, 7, 30, 275520.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(57, 7, 32, 180400.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(58, 7, 33, 180400.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(59, 7, 34, 530572.80, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(60, 7, 35, 355814.40, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(61, 7, 36, 94464.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(62, 7, 37, 708480.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28'),
(63, 7, 38, 892160.00, '2022-01-13 05:17:28', '2022-01-13 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uses` int(10) UNSIGNED DEFAULT NULL,
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_plans`
--

CREATE TABLE `work_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `work_period` date NOT NULL,
  `working_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_plans`
--

INSERT INTO `work_plans` (`id`, `client_id`, `work_period`, `working_days`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-08-01', 24, '2021-08-11 08:42:24', '2021-08-16 13:43:22'),
(2, 1, '2021-10-01', 25, '2021-10-22 02:37:06', '2021-10-22 02:37:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b2b_client`
--
ALTER TABLE `b2b_client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `b2b_client_client_name_unique` (`client_name`),
  ADD UNIQUE KEY `b2b_client_client_slug_unique` (`client_slug`),
  ADD UNIQUE KEY `b2b_client_email_unique` (`email`),
  ADD UNIQUE KEY `b2b_client_phone_whatsapp_unique` (`phone_whatsapp`),
  ADD UNIQUE KEY `b2b_client_phone_unique` (`phone`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_client_id_foreign` (`client_id`);

--
-- Indexes for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_client_id_foreign` (`client_id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`),
  ADD KEY `category_product_category_id_foreign` (`category_id`);

--
-- Indexes for table `cat_pareto`
--
ALTER TABLE `cat_pareto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_client_id_foreign` (`client_id`),
  ADD KEY `customers_pareto_id_foreign` (`pareto_id`);

--
-- Indexes for table `customer_points`
--
ALTER TABLE `customer_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_paket`
--
ALTER TABLE `groups_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_paket_group_id_foreign` (`group_id`),
  ADD KEY `groups_paket_paket_id_foreign` (`paket_id`);

--
-- Indexes for table `group_product`
--
ALTER TABLE `group_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_wp_id_foreign` (`wp_id`);

--
-- Indexes for table `login_records`
--
ALTER TABLE `login_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_client_id_foreign` (`client_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_client_id_foreign` (`client_id`),
  ADD KEY `orders_reasons_id_foreign` (`reasons_id`);

--
-- Indexes for table `order_paket_tmp`
--
ALTER TABLE `order_paket_tmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`),
  ADD KEY `order_product_group_id_foreign` (`group_id`),
  ADD KEY `order_product_paket_id_foreign` (`paket_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`),
  ADD KEY `order_product_group_id_foreign` (`group_id`),
  ADD KEY `order_product_paket_id_foreign` (`paket_id`);

--
-- Indexes for table `pakets`
--
ALTER TABLE `pakets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partial_deliveries`
--
ALTER TABLE `partial_deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `point_claims`
--
ALTER TABLE `point_claims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_periods`
--
ALTER TABLE `point_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_periods_client_id_foreign` (`client_id`);

--
-- Indexes for table `point_rewards`
--
ALTER TABLE `point_rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_rewards_client_id_foreign` (`client_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`),
  ADD UNIQUE KEY `products_key_code_unique` (`key_code`),
  ADD KEY `products_client_id_foreign` (`client_id`);

--
-- Indexes for table `product_rewards`
--
ALTER TABLE `product_rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_rewards_client_id_foreign` (`client_id`);

--
-- Indexes for table `product_stock_status`
--
ALTER TABLE `product_stock_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_targets`
--
ALTER TABLE `product_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reasons_checkouts`
--
ALTER TABLE `reasons_checkouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_targets`
--
ALTER TABLE `sales_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `spv_sales`
--
ALTER TABLE `spv_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_target`
--
ALTER TABLE `store_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_customer`
--
ALTER TABLE `type_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_client_id_foreign` (`client_id`);

--
-- Indexes for table `volume_discounts`
--
ALTER TABLE `volume_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volume_discount_products`
--
ALTER TABLE `volume_discount_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_plans`
--
ALTER TABLE `work_plans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b2b_client`
--
ALTER TABLE `b2b_client`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `cat_pareto`
--
ALTER TABLE `cat_pareto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT for table `customer_points`
--
ALTER TABLE `customer_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `groups_paket`
--
ALTER TABLE `groups_paket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_product`
--
ALTER TABLE `group_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `login_records`
--
ALTER TABLE `login_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `order_paket_tmp`
--
ALTER TABLE `order_paket_tmp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=782;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1075;

--
-- AUTO_INCREMENT for table `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `partial_deliveries`
--
ALTER TABLE `partial_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `point_claims`
--
ALTER TABLE `point_claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `point_periods`
--
ALTER TABLE `point_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `point_rewards`
--
ALTER TABLE `point_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_rewards`
--
ALTER TABLE `product_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_stock_status`
--
ALTER TABLE `product_stock_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_targets`
--
ALTER TABLE `product_targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `reasons_checkouts`
--
ALTER TABLE `reasons_checkouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_targets`
--
ALTER TABLE `sales_targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `spv_sales`
--
ALTER TABLE `spv_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `store_target`
--
ALTER TABLE `store_target`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `type_customer`
--
ALTER TABLE `type_customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `volume_discounts`
--
ALTER TABLE `volume_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `volume_discount_products`
--
ALTER TABLE `volume_discount_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_plans`
--
ALTER TABLE `work_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups_paket`
--
ALTER TABLE `groups_paket`
  ADD CONSTRAINT `groups_paket_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `groups_paket_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `pakets` (`id`);

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_wp_id_foreign` FOREIGN KEY (`wp_id`) REFERENCES `work_plans` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `b2b_client` (`id`);

--
-- Constraints for table `point_periods`
--
ALTER TABLE `point_periods`
  ADD CONSTRAINT `point_periods_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `b2b_client` (`id`);

--
-- Constraints for table `point_rewards`
--
ALTER TABLE `point_rewards`
  ADD CONSTRAINT `point_rewards_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `b2b_client` (`id`);

--
-- Constraints for table `product_rewards`
--
ALTER TABLE `product_rewards`
  ADD CONSTRAINT `product_rewards_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `b2b_client` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_order_product` ON SCHEDULE EVERY 10 MINUTE STARTS '2021-11-23 22:39:35' ON COMPLETION NOT PRESERVE ENABLE DO DELETE orders, order_product
  FROM orders 
  JOIN order_product ON order_product.order_id = orders.id
  WHERE orders.customer_id IS NULL
  AND orders.status = 'SUBMIT'
  AND orders.created_at < NOW() - INTERVAL 45 MINUTE$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_order_paket` ON SCHEDULE EVERY 10 MINUTE STARTS '2021-11-23 22:39:35' ON COMPLETION NOT PRESERVE ENABLE DO DELETE orders, order_paket_tmp 
  FROM orders 
  JOIN order_paket_tmp ON order_paket_tmp.order_id = orders.id
  WHERE orders.customer_id IS NULL
  AND orders.status = 'SUBMIT'
  AND orders.created_at < NOW() - INTERVAL 45 MINUTE$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
