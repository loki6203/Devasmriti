-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 05:15 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pg`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_deposits`
--

CREATE TABLE `account_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acc_debited_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gate_way_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_deposits`
--

INSERT INTO `account_deposits` (`id`, `user_id`, `description`, `payment_status`, `acc_debited_status`, `transaction_id`, `invoice_id`, `payment_response`, `card_details`, `created_at`, `updated_at`, `gate_way_id`, `amount`, `deleted_at`) VALUES
(1, 4, '', 'Success', 'Pending', '16333516209372654', '0001', 'Testing', '', '2021-10-04 07:29:17', '2021-10-04 07:29:17', 2, '10000.00', NULL),
(2, 4, '', 'Pending', 'Pending', '16341131119669954', '0002', NULL, NULL, '2021-10-13 02:48:32', '2021-10-13 02:48:32', 2, '10000.00', NULL),
(3, 4, '', 'Pending', 'Pending', '16341131504794201', '0003', NULL, NULL, '2021-10-13 02:49:11', '2021-10-13 02:49:11', 2, '10000.00', NULL),
(4, 4, '', 'Pending', 'Pending', '16341131544987625', '0004', NULL, NULL, '2021-10-13 02:49:15', '2021-10-13 02:49:15', 2, '10000.00', NULL),
(5, 4, '', 'Pending', 'Pending', '16341131992862627', '0005', NULL, NULL, '2021-10-13 02:50:00', '2021-10-13 02:50:00', 2, '10000.00', NULL),
(6, 4, '', 'Pending', 'Pending', '16341132037789714', '0006', NULL, NULL, '2021-10-13 02:50:04', '2021-10-13 02:50:04', 2, '10000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_history`
--

CREATE TABLE `account_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `cr_or_dr` enum('credit','debit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` enum('referel','internal_transfer','deposit','prepaid_recharge','postpaid_recharge','dth_recharge','bbps','bill_pay','rent_pay','admin') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `txn_id` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_history`
--

INSERT INTO `account_history` (`id`, `user_id`, `amount`, `cr_or_dr`, `action_type`, `description`, `transaction_id`, `created_at`, `updated_at`, `payment_details`, `deleted_at`, `txn_id`) VALUES
(4, 4, '10000.00', 'credit', 'deposit', '', 1, '2021-10-04 07:17:14', '2021-10-04 07:17:14', '{\"id\":1,\"user_id\":4,\"description\":\"\",\"payment_status\":\"Success\",\"acc_debited_status\":\"Pending\",\"transaction_id\":\"16333516209372654\",\"invoice_id\":\"0001\",\"payment_response\":\"Testing\",\"card_details\":\"\",\"created_at\":\"2021-10-04T12:47:14.000000Z\",\"updated_at\":\"2021-10-04T12:47:14.000000Z\",\"gate_way_id\":2,\"amount\":\"10000.00\"}', NULL, NULL),
(5, 4, '1000.00', 'debit', 'internal_transfer', '', 3, '2021-10-04 07:25:23', '2021-10-04 07:25:23', NULL, NULL, NULL),
(6, 4, '10000.00', 'credit', 'deposit', '', 1, '2021-10-04 07:29:17', '2021-10-04 07:29:17', '{\"id\":1,\"user_id\":4,\"description\":\"\",\"payment_status\":\"Success\",\"acc_debited_status\":\"Pending\",\"transaction_id\":\"16333516209372654\",\"invoice_id\":\"0001\",\"payment_response\":\"Testing\",\"card_details\":\"\",\"created_at\":\"2021-10-04T12:59:17.000000Z\",\"updated_at\":\"2021-10-04T12:59:17.000000Z\",\"gate_way_id\":2,\"amount\":\"10000.00\"}', NULL, NULL),
(7, 4, '1000.00', 'debit', 'internal_transfer', '', 4, '2021-10-04 07:29:24', '2021-10-04 07:29:24', NULL, NULL, NULL),
(8, 4, NULL, 'debit', 'bill_pay', 'Amount Debited For Biller Adding', 0, '2021-10-13 05:14:58', '2021-10-13 05:14:58', '{\"id\":0,\"txn_id\":\"BILLER7\",\"description\":\"Amount Debited For Biller Adding\"}', NULL, NULL),
(9, 4, NULL, 'debit', 'bill_pay', 'Amount Debited For Biller Adding', 0, '2021-10-13 05:16:25', '2021-10-13 05:16:25', '{\"id\":0,\"txn_id\":\"BILLER8\",\"description\":\"Amount Debited For Biller Adding\"}', NULL, 'BILLER8');

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ifsc_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_response` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acc_number` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fund_account_id` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cont_id` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billers`
--

INSERT INTO `billers` (`id`, `user_id`, `ifsc_code`, `name`, `api_response`, `is_active`, `created_at`, `updated_at`, `acc_number`, `bank_name`, `deleted_at`, `fund_account_id`, `cont_id`) VALUES
(10, 4, '131313', 'Venkat rao', NULL, 'active', '2021-10-13 09:27:15', '2021-10-13 09:40:13', '214124124124', NULL, NULL, NULL, 'cont_I8rhQwoJ3l78n1');

-- --------------------------------------------------------

--
-- Table structure for table `bill_pay`
--

CREATE TABLE `bill_pay` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `biller_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acc_debited_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `is_active`, `country_id`, `state_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hyderabad', 'active', 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `common_gateway_cards`
--

CREATE TABLE `common_gateway_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `gateway_charge` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'India', 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_transfers`
--

CREATE TABLE `internal_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acc_debited_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internal_transfers`
--

INSERT INTO `internal_transfers` (`id`, `from_user_id`, `to_user_id`, `description`, `payment_status`, `acc_debited_status`, `transaction_id`, `invoice_id`, `payment_response`, `created_at`, `updated_at`, `amount`, `deleted_at`) VALUES
(1, 4, 3, '', 'Success', 'Success', '16333519807804786', '0001', NULL, '2021-10-04 07:23:00', '2021-10-04 07:23:00', '1000.00', NULL),
(2, 4, 3, '', 'Success', 'Success', '16333520459943472', '0002', NULL, '2021-10-04 07:24:05', '2021-10-04 07:24:06', '1000.00', NULL),
(3, 4, 3, '', 'Success', 'Success', '16333521232895941', '0003', NULL, '2021-10-04 07:25:23', '2021-10-04 07:25:23', '1000.00', NULL),
(4, 4, 3, '', 'Success', 'Success', '1633352364314319', '0004', NULL, '2021-10-04 07:29:24', '2021-10-04 07:29:24', '1000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_01_133942_create_payagent_tables', 1),
(6, '2021_09_03_101957_add_message_on_user_details', 1),
(7, '2021_09_20_102905_create_add_column_gateway_id_on_deposites_table', 1),
(8, '2021_09_20_104638_create_add_column_keys_on_payment_gateways_table', 1),
(9, '2021_09_20_135447_create_add_details_on_account_history_table', 1),
(10, '2021_09_20_150723_create_add_acc_number_bank_name_on_billers_table', 1),
(11, '2021_09_22_061357_create_user_related_tables_table', 1),
(12, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(13, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(14, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(15, '2016_06_01_000004_create_oauth_clients_table', 2),
(16, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(17, '2021_09_22_102528_create_sessions_table', 2),
(19, '2021_10_04_091949_create_user_details_xtra_fields_table', 3),
(20, '2021_10_04_103150_create_display_name_on_gateway_table', 4),
(21, '2021_10_04_103844_create_drop_column_on_gateway_table', 5),
(22, '2021_10_04_122741_create_add_amount_column_on_account_deposits_table', 6),
(23, '2021_10_04_125200_create_add_amount_column_on_int_transf_table', 7),
(24, '2021_10_13_061428_create_add_deleted_at_all_tables_table', 8),
(25, '2021_10_13_074404_create_add_txn_id_table', 9),
(26, '2021_10_13_141313_create_add_funaccid_on_billres_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0249006e2a6b7cd0c640d40fff64c36af86d7122fd81e698edc1e521da1507816758e07889c5d426', 1, 4, 'PayAgent', '[]', 0, '2021-09-23 02:03:45', '2021-09-23 02:03:45', '2022-09-23 07:33:45'),
('02824a523cdafb3bdccd994655120760fa4f9b7964eaea3925100831e45962543aa210667334b382', 1, 2, NULL, '[]', 0, '2021-09-22 05:30:46', '2021-09-22 05:30:46', '2022-09-22 11:00:46'),
('07c5829cda074ec29cfc9bd5ab780db780a35d8100e407c32848af064ac60c0274373959587bb85b', 1, 2, NULL, '[]', 0, '2021-09-23 01:21:34', '2021-09-23 01:21:34', '2022-09-23 06:51:34'),
('1897d350a35896ac47073ccedab4370d20bdf4c60e3a586cb457f9e4009f2ec990e2d98631e1f067', 1, 2, NULL, '[]', 0, '2021-09-22 05:30:30', '2021-09-22 05:30:30', '2022-09-22 11:00:30'),
('2cb55112445b5bf57790beb6db078db88f830778cb10d6a1a03249026b40614825207239b42dfc66', 1, 2, NULL, '[]', 0, '2021-09-23 01:29:52', '2021-09-23 01:29:52', '2022-09-23 06:59:52'),
('2f86e3fbc8c6f1242f59a53256c1db05fb1d0de87eace76a1027c752974dcc7385daa8a97484e195', 1, 2, NULL, '[]', 0, '2021-09-22 05:30:05', '2021-09-22 05:30:05', '2022-09-22 11:00:05'),
('345b92fa563cbeb0d6faf08b48f6dbadba5e09fac231236325d86449f8bf35c4b1fa88245263df89', 1, 2, NULL, '[]', 0, '2021-09-22 06:57:48', '2021-09-22 06:57:48', '2022-09-22 12:27:48'),
('4cdedd1746fa8d46e7753c2bc92c5f9d039d7943c01668f2b6d9120ec7d60d53f459251641b58f2f', 1, 2, NULL, '[]', 0, '2021-09-22 05:31:05', '2021-09-22 05:31:05', '2022-09-22 11:01:05'),
('826cac8b8ba394fb01d80e2e107d8b847137c0e2e87af16fd0d0f84d82b14fdb2138ea172bf24c50', 1, 4, 'PayAgent', '[]', 0, '2021-09-23 01:38:02', '2021-09-23 01:38:02', '2022-09-23 07:08:02'),
('9fef4f597c9f707c966020a26b6fb95f4611d3b256da643f4b48fafc9714af0498b8527f7bb3015c', 1, 2, NULL, '[]', 0, '2021-09-23 01:19:18', '2021-09-23 01:19:18', '2022-09-23 06:49:18'),
('b82405b20502aaa3feb6877546db8a6ca18ef705641dbf606e94d9cd7ff06e0e22dd142c2c81517f', 1, 2, NULL, '[]', 0, '2021-09-22 08:00:23', '2021-09-22 08:00:23', '2022-09-22 13:30:23'),
('d11ceed82ddd085e177eb0af32720b32f444d0ae3a25f8b59adf6f15df2449e7f6b4a717201a9ec5', 1, 2, NULL, '[]', 0, '2021-09-22 08:01:19', '2021-09-22 08:01:19', '2022-09-22 13:31:19'),
('d43c36c99e919b00d300dd87130c2fbac58f8341a8289712c351579ad41f52a78bd1da89b163a2a1', 1, 4, 'PayAgent', '[]', 0, '2021-09-23 02:04:33', '2021-09-23 02:04:33', '2022-09-23 07:34:33'),
('dab57472e581116ff2737cb7a7ee0c67b3220cfe340ee26f5199334b7a41a997b89611c7ca085f7a', 1, 2, NULL, '[]', 0, '2021-09-23 01:17:46', '2021-09-23 01:17:46', '2022-09-23 06:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'g3UtLglxhKmSttpotUR5GgNt6SdTgbO7Bj1K9WdU', NULL, 'https://payagent.in/master/', 1, 0, 0, '2021-09-22 05:06:27', '2021-09-22 05:06:27'),
(2, NULL, 'Laravel Password Grant Client', 'Ty0Vk4auZvy2Swu3yc3CsGRBVI3BbVJVlFwBRgeI', 'users', 'https://payagent.in/master/', 0, 1, 0, '2021-09-22 05:06:27', '2021-09-22 05:06:27'),
(3, NULL, 'Laravel Personal Access Client', '8gjhW38J55nZkWtL3rlPdEebntvFvFws0wEyukKZ', NULL, 'https://payagent.in/master/', 1, 0, 0, '2021-09-23 01:29:34', '2021-09-23 01:29:34'),
(4, NULL, 'Laravel Personal Access Client', 'tTIxBe66R1HuVS2mbezAiW91Rangr4n7lUfQkiic', NULL, 'https://payagent.in/master/', 1, 0, 0, '2021-09-23 01:35:32', '2021-09-23 01:35:32'),
(5, NULL, 'Laravel Password Grant Client', 'fUoufCAsjse7v0tvptuFg6jcUm3gX4MGXPo7XXmo', 'users', 'https://payagent.in/master/', 0, 1, 0, '2021-09-23 01:35:32', '2021-09-23 01:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-09-22 05:06:27', '2021-09-22 05:06:27'),
(2, 3, '2021-09-23 01:29:34', '2021-09-23 01:29:34'),
(3, 4, '2021-09-23 01:35:32', '2021-09-23 01:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('0d1eefeb2d1397c70a04434007d3ddccd9de827bcc570aa0d164e7b876f61daa145f57c587266477', '1897d350a35896ac47073ccedab4370d20bdf4c60e3a586cb457f9e4009f2ec990e2d98631e1f067', 0, '2022-09-22 11:00:30'),
('35b1cb6756f6a12a4b3ec47a171d515e7b2d29a5a9994b977929d7115244933c732065b8d0c0724c', '2cb55112445b5bf57790beb6db078db88f830778cb10d6a1a03249026b40614825207239b42dfc66', 0, '2022-09-23 06:59:52'),
('3f49008793cb98f6193cc7edbfbb3172b7179ae7a87069a113bac12432d85c9364b54a69a077344a', '07c5829cda074ec29cfc9bd5ab780db780a35d8100e407c32848af064ac60c0274373959587bb85b', 0, '2022-09-23 06:51:34'),
('67545f8027aef2cb74939a0178fd948c4c08d6b843adb652ad6a85518975edf5310753078af06755', '02824a523cdafb3bdccd994655120760fa4f9b7964eaea3925100831e45962543aa210667334b382', 0, '2022-09-22 11:00:46'),
('69d30eb5f6da82486b8d9deb24552b0167d0f6da4d313a503f7074ed6da53518b74919b66a0e3a39', '345b92fa563cbeb0d6faf08b48f6dbadba5e09fac231236325d86449f8bf35c4b1fa88245263df89', 0, '2022-09-22 12:27:48'),
('968a8addafae2a62b64edb1aaa8fdfbe45c44cf325d7b4b0d5aa067b8039784f0fe40654e3887f00', 'd11ceed82ddd085e177eb0af32720b32f444d0ae3a25f8b59adf6f15df2449e7f6b4a717201a9ec5', 0, '2022-09-22 13:31:19'),
('a3aeb84a85ac23f89d2f9d0c79efa2a66a080279a22f3773b06e9fd07746bea1daa00a44debb3926', 'b82405b20502aaa3feb6877546db8a6ca18ef705641dbf606e94d9cd7ff06e0e22dd142c2c81517f', 0, '2022-09-22 13:30:23'),
('c87e73ea3149b56128f039482112ece4f6af60a4ffbe3a7b819c442f92a1942d4b58701b7fa0cdfa', 'dab57472e581116ff2737cb7a7ee0c67b3220cfe340ee26f5199334b7a41a997b89611c7ca085f7a', 0, '2022-09-23 06:47:47'),
('cdc15ae75dc7716b9bcef051267ccb612262fe713895c5047c0dd71c8003df83cc3f1fb9224360c4', '9fef4f597c9f707c966020a26b6fb95f4611d3b256da643f4b48fafc9714af0498b8527f7bb3015c', 0, '2022-09-23 06:49:18'),
('ee4db74a1c0c6f602a8b12692e11f0e9058ecc91ae04d87d3b44bed3be8e1e5f11b5f1fda6a77a38', '4cdedd1746fa8d46e7753c2bc92c5f9d039d7943c01668f2b6d9120ec7d60d53f459251641b58f2f', 0, '2022-09-22 11:01:05'),
('fd79e36ae5b4cd93729b3dac1b337e713f42a226c3ed3a56c49fc42aead7752e585632ac041fbd4e', '2f86e3fbc8c6f1242f59a53256c1db05fb1d0de87eace76a1027c752974dcc7385daa8a97484e195', 0, '2022-09-22 11:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `gateway_charge` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('test','live') COLLATE utf8mb4_unicode_ci DEFAULT 'test',
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `is_active`, `gateway_charge`, `created_at`, `updated_at`, `type`, `display_name`, `live`, `test`, `deleted_at`) VALUES
(1, 'zaakpay', 'active', '2.00', NULL, '2021-10-13 03:11:58', 'test', 'Zaak Pay', '{\"Merchant_ID\":\"242254d9a5f14a688d623bb05b9c9500\",\"SECRET_KEY\":\"190472e7272f4dad910932460cfe89a4\",\"API_KEY\":\"48ff8e97f2c24f0986e7ee389b53f8d7\",\"URL\":\"https:\\/\\/zaakstaging.zaakpay.com\\/api\\/v1\\/\"}', '{\"Merchant_ID\":\"889653b03ce04a57b54db6463b1e5445 \",\"SECRET_KEY\":\"0678056d96914a8583fb518caf42828a\",\"API_KEY\":\"\",\"URL\":\"https:\\/\\/zaakstaging.zaakpay.com\\/api\\/v1\\/\"}', NULL),
(2, 'razorpay', 'active', '10.00', NULL, '2021-10-13 03:11:58', 'test', 'razorpay', '{\"KEY_ID\":\"rzp_live_SCCUPJYTWQvAVQ\",\"SECRET_KEY\":\"jAUskVzf4hwRbFVCf0qFXPDe\",\"URL\":\"\"}', '{\"KEY_ID\":\"rzp_test_keeXcoyuO0njIB\",\"SECRET_KEY\":\"pgXZhMznTB4XPVKeWWPnqu4L\",\"URL\":\"\"}', NULL),
(3, 'safexpay', 'active', '10.00', NULL, '2021-10-13 03:11:58', 'test', 'safexpay', '{\"MARCHANT_ID\":\" \",\"MARCHANT_KEY\":\"\",\"AGGREGATOR_ID\":\"\",\"URL\":\"\"}', '{\"MARCHANT_ID\":\"202104210302\",\"MARCHANT_KEY\":\"B808GWxEls3oFzOz6wfxgEpSfPaQunLCU54vDJty4=\",\"AGGREGATOR_ID\":\"Paygate\",\"URL\":\"\"}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recharge_history`
--

CREATE TABLE `recharge_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recharge_type` enum('pre_paid','post_paid','dth') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acc_debited_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent_pay`
--

CREATE TABLE `rent_pay` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `biller_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acc_debited_status` enum('Pending','Processing','Success','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emails` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `common_code_percentage` decimal(10,2) DEFAULT NULL,
  `beneficiary_amount` decimal(10,2) DEFAULT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `address`, `emails`, `common_code_percentage`, `beneficiary_amount`, `site_name`, `site_email`, `site_logo`, `site_phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test', 'Test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Telanagana', 1, 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('business','admin','support','user','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `referel_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('active','inactive','not_verified') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_verified',
  `about_me` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `password`, `company_name`, `user_type`, `referel_code`, `profile_pic`, `is_active`, `about_me`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'kvr', 'kvr@test.com', '9640861076', '$2y$10$m9fOpMotUS2Scox/HTlQCuCyJT1w5NRTvMVGP2RmreYTSC7Ty2pXi', NULL, 'user', NULL, NULL, 'active', NULL, NULL, '2021-09-22 05:02:02', '2021-09-22 09:36:16', NULL),
(2, 'kvr', 'kvr@kvr.com', '5588996655', '$2y$10$AWoEiJVKzwmc9PWD5m6HO.pBlalvdKtmqH9hYxnj5u1ca2xjP8ULy', NULL, 'user', NULL, NULL, 'not_verified', NULL, NULL, '2021-10-04 01:11:06', '2021-10-04 01:11:06', NULL),
(3, 'bala', 'mbala6996@gmail.com', '12345678', '$2y$10$MKNpDUt0OecKRMILvuvPgOKq8NHytnflcMA6mj4DJFWGPKeAfqeQy', NULL, 'user', NULL, NULL, 'not_verified', NULL, NULL, '2021-10-04 01:19:03', '2021-10-04 01:19:03', NULL),
(4, 'kesanapalli', 'ksnp@gmail.com', '9999999999', '$2y$10$WlCsr3LUG3102vud5XhLYuUQ8H5TncQtrJdPRWh8Dzzq7cYPle6yu', NULL, 'user', NULL, 'uploads/3fda917ca411546e1816173467b8f184.png', 'active', NULL, NULL, '2021-10-04 01:23:38', '2021-10-04 03:56:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tpin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adhar_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `pan_verified_at` timestamp NULL DEFAULT NULL,
  `adhar_verified_at` timestamp NULL DEFAULT NULL,
  `pan_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adhar_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_otp` smallint(6) DEFAULT NULL,
  `pan_attempts` smallint(6) DEFAULT NULL,
  `adhar_otp` smallint(6) DEFAULT NULL,
  `email_otp` smallint(6) DEFAULT NULL,
  `gateway_charge` decimal(10,2) DEFAULT NULL,
  `referal_code_percentage` decimal(10,2) DEFAULT NULL,
  `beneficiary_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` smallint(6) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `adhar_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `first_name`, `last_name`, `acc_number`, `acc_balance`, `tpin`, `pan_number`, `adhar_number`, `email_verified_at`, `mobile_verified_at`, `pan_verified_at`, `adhar_verified_at`, `pan_response`, `adhar_response`, `mobile_otp`, `pan_attempts`, `adhar_otp`, `email_otp`, `gateway_charge`, `referal_code_percentage`, `beneficiary_amount`, `created_at`, `updated_at`, `message`, `address`, `pincode`, `country_id`, `state_id`, `city_id`, `adhar_file`, `pan_file`, `dob`, `verified_by`, `deleted_at`) VALUES
(1, 1, 'kvr', NULL, '4216893705', '0.00', NULL, NULL, NULL, '2021-09-07 18:30:00', '2021-09-22 05:02:55', '2021-09-21 18:30:00', NULL, NULL, NULL, 12345, 0, NULL, 12345, NULL, NULL, NULL, '2021-09-22 05:02:02', '2021-09-22 05:02:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'kvr', NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12345, 0, NULL, 12345, NULL, NULL, NULL, '2021-10-04 01:11:06', '2021-10-04 01:11:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'bala', NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12345, 0, NULL, 12345, NULL, NULL, NULL, '2021-10-04 01:19:03', '2021-10-04 01:19:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'kesanapalli', NULL, '5193684072', '18000.00', '1234', '1', '1', NULL, '2021-10-04 01:25:09', '2021-10-13 18:30:00', NULL, NULL, NULL, 12345, 1, NULL, 12345, NULL, NULL, NULL, '2021-10-04 01:23:38', '2021-10-04 07:29:24', NULL, 'hyderabad kukatpally', 1233, 1, 1, 1, 'uploads/405a1a8635a112ff03a69f0a3bca067d.jpg', 'uploads/ec601d9c2323b8c89c53094ee7dabb9d.jpg', '2021-12-12', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_deposits`
--
ALTER TABLE `account_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_deposits_user_id_foreign` (`user_id`),
  ADD KEY `account_deposits_gate_way_id_foreign` (`gate_way_id`);

--
-- Indexes for table `account_history`
--
ALTER TABLE `account_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_history_user_id_foreign` (`user_id`);

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billers_user_id_foreign` (`user_id`);

--
-- Indexes for table `bill_pay`
--
ALTER TABLE `bill_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_pay_user_id_foreign` (`user_id`),
  ADD KEY `bill_pay_biller_id_foreign` (`biller_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `common_gateway_cards`
--
ALTER TABLE `common_gateway_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internal_transfers_from_user_id_foreign` (`from_user_id`),
  ADD KEY `internal_transfers_to_user_id_foreign` (`to_user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `recharge_history`
--
ALTER TABLE `recharge_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recharge_history_user_id_foreign` (`user_id`);

--
-- Indexes for table `rent_pay`
--
ALTER TABLE `rent_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rent_pay_user_id_foreign` (`user_id`),
  ADD KEY `rent_pay_biller_id_foreign` (`biller_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_number_unique` (`mobile_number`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_details_user_id_foreign` (`user_id`),
  ADD KEY `user_details_country_id_foreign` (`country_id`),
  ADD KEY `user_details_state_id_foreign` (`state_id`),
  ADD KEY `user_details_city_id_foreign` (`city_id`),
  ADD KEY `user_details_verified_by_foreign` (`verified_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_deposits`
--
ALTER TABLE `account_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `account_history`
--
ALTER TABLE `account_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bill_pay`
--
ALTER TABLE `bill_pay`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `common_gateway_cards`
--
ALTER TABLE `common_gateway_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recharge_history`
--
ALTER TABLE `recharge_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent_pay`
--
ALTER TABLE `rent_pay`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_deposits`
--
ALTER TABLE `account_deposits`
  ADD CONSTRAINT `account_deposits_gate_way_id_foreign` FOREIGN KEY (`gate_way_id`) REFERENCES `payment_gateways` (`id`),
  ADD CONSTRAINT `account_deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `account_history`
--
ALTER TABLE `account_history`
  ADD CONSTRAINT `account_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `billers`
--
ALTER TABLE `billers`
  ADD CONSTRAINT `billers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bill_pay`
--
ALTER TABLE `bill_pay`
  ADD CONSTRAINT `bill_pay_biller_id_foreign` FOREIGN KEY (`biller_id`) REFERENCES `billers` (`id`),
  ADD CONSTRAINT `bill_pay_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  ADD CONSTRAINT `internal_transfers_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `internal_transfers_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `recharge_history`
--
ALTER TABLE `recharge_history`
  ADD CONSTRAINT `recharge_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rent_pay`
--
ALTER TABLE `rent_pay`
  ADD CONSTRAINT `rent_pay_biller_id_foreign` FOREIGN KEY (`biller_id`) REFERENCES `billers` (`id`),
  ADD CONSTRAINT `rent_pay_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `user_details_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `user_details_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_details_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
