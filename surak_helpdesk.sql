-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-07-2026 a las 13:19:51
-- Versión del servidor: 10.11.10-MariaDB-cll-lve
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `surak_helpdesk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'delete_device', 'App\\Models\\Device', 6, 'Eliminó el equipo MacBook Pro 14 M3 (S/N: SN-C02XYZ1234)', '190.6.56.239', '2026-07-02 11:58:46', '2026-07-02 11:58:46'),
(2, 1, 'delete_device', 'App\\Models\\Device', 5, 'Eliminó el equipo Cisco Catalyst 9300 (S/N: SN-FOC9876WXY)', '190.6.56.239', '2026-07-02 23:43:15', '2026-07-02 23:43:15'),
(3, 1, 'delete_device', 'App\\Models\\Device', 4, 'Eliminó el equipo Lenovo ThinkPad T14 (S/N: SN-PF1AB2CD34)', '190.6.56.239', '2026-07-02 23:43:20', '2026-07-02 23:43:20'),
(4, 1, 'delete_device', 'App\\Models\\Device', 3, 'Eliminó el equipo Dell PowerEdge R750 (S/N: SN-SRV2024001)', '190.6.56.239', '2026-07-02 23:43:26', '2026-07-02 23:43:26'),
(5, 1, 'delete_device', 'App\\Models\\Device', 2, 'Eliminó el equipo HP ProDesk 600 G9 (S/N: SN-CZC5678XYZ)', '190.6.56.239', '2026-07-02 23:43:29', '2026-07-02 23:43:29'),
(6, 1, 'delete_device', 'App\\Models\\Device', 1, 'Eliminó el equipo Dell Latitude 7430 (S/N: SN-5CD1234ABC)', '190.6.56.239', '2026-07-02 23:43:53', '2026-07-02 23:43:53'),
(7, 1, 'create_user', 'App\\Models\\User', 2, 'Creó el usuario Alberto (chetoforex@gmail.com) con rol admin', '190.6.56.239', '2026-07-02 23:46:03', '2026-07-02 23:46:03'),
(8, 1, 'update_user', 'App\\Models\\User', 2, 'Actualizó la información del usuario Alberto (chetoforex@gmail.com)', '190.6.56.239', '2026-07-02 23:52:04', '2026-07-02 23:52:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Distribucion', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(2, 'Galpon', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(3, 'Hiper Suraki', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(4, '2kNR', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(5, 'Lacteos', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(6, 'Surakarne Americas', NULL, NULL, 1, '2026-07-01 20:21:49', '2026-07-01 20:21:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('suraki-helpdesk-cache-0485026ffb096d8283f16558ade0dc8a8d9a79b4', 'i:3;', 1783003202),
('suraki-helpdesk-cache-0485026ffb096d8283f16558ade0dc8a8d9a79b4:timer', 'i:1783003202;', 1783003202),
('suraki-helpdesk-cache-18e6148edd73a1a0f8c95e8c8730e4891b657db9', 'i:1;', 1783272203),
('suraki-helpdesk-cache-18e6148edd73a1a0f8c95e8c8730e4891b657db9:timer', 'i:1783272202;', 1783272202),
('suraki-helpdesk-cache-1ad89b195511557bdcf3ed8e88a87f197d2d13ba', 'i:1;', 1783272118),
('suraki-helpdesk-cache-1ad89b195511557bdcf3ed8e88a87f197d2d13ba:timer', 'i:1783272117;', 1783272117),
('suraki-helpdesk-cache-1d905bab4714e473aa72c13f69c4a1afde0b8a72', 'i:1;', 1783272613),
('suraki-helpdesk-cache-1d905bab4714e473aa72c13f69c4a1afde0b8a72:timer', 'i:1783272612;', 1783272612),
('suraki-helpdesk-cache-242006723ccfb04455c1713b1aac8903640dd564', 'i:1;', 1782996369),
('suraki-helpdesk-cache-242006723ccfb04455c1713b1aac8903640dd564:timer', 'i:1782996368;', 1782996368),
('suraki-helpdesk-cache-27e5b3d7424eddd37ef2f6a907e9601b5a8635ae', 'i:1;', 1782994612),
('suraki-helpdesk-cache-27e5b3d7424eddd37ef2f6a907e9601b5a8635ae:timer', 'i:1782994612;', 1782994612),
('suraki-helpdesk-cache-31986cf7b2b2366deaf344bc1f49c114e46569ad', 'i:3;', 1782941933),
('suraki-helpdesk-cache-31986cf7b2b2366deaf344bc1f49c114e46569ad:timer', 'i:1782941933;', 1782941933),
('suraki-helpdesk-cache-449c810b39b8af0ba8e22686b16f0e9a45a34aa3', 'i:2;', 1782972538),
('suraki-helpdesk-cache-449c810b39b8af0ba8e22686b16f0e9a45a34aa3:timer', 'i:1782972538;', 1782972538),
('suraki-helpdesk-cache-4bf3bb3745415416c7681cf05b4cb4d353fa7a33', 'i:1;', 1783078973),
('suraki-helpdesk-cache-4bf3bb3745415416c7681cf05b4cb4d353fa7a33:timer', 'i:1783078973;', 1783078973),
('suraki-helpdesk-cache-51c68b82a3cfcc19b8e9f87ced426f4592c0cb43', 'i:1;', 1783147330),
('suraki-helpdesk-cache-51c68b82a3cfcc19b8e9f87ced426f4592c0cb43:timer', 'i:1783147330;', 1783147330),
('suraki-helpdesk-cache-5250d4d2173bf88c11ea9b37f4847838215e4816', 'i:1;', 1783272686),
('suraki-helpdesk-cache-5250d4d2173bf88c11ea9b37f4847838215e4816:timer', 'i:1783272684;', 1783272684),
('suraki-helpdesk-cache-596376bdcd4aa60ddd5dac7ca95551630e4a0f0b', 'i:1;', 1783114930),
('suraki-helpdesk-cache-596376bdcd4aa60ddd5dac7ca95551630e4a0f0b:timer', 'i:1783114930;', 1783114930),
('suraki-helpdesk-cache-63a1bad772a8dad31116ff8cbbb3dc4cfd4f93aa', 'i:1;', 1783358390),
('suraki-helpdesk-cache-63a1bad772a8dad31116ff8cbbb3dc4cfd4f93aa:timer', 'i:1783358390;', 1783358390),
('suraki-helpdesk-cache-70a750160b9b96daacd13b2dfdfd8e55546fd402', 'i:1;', 1782996050),
('suraki-helpdesk-cache-70a750160b9b96daacd13b2dfdfd8e55546fd402:timer', 'i:1782996050;', 1782996050),
('suraki-helpdesk-cache-8b394e26d50eadefaaba3f0c477303901d94b191', 'i:1;', 1782941967),
('suraki-helpdesk-cache-8b394e26d50eadefaaba3f0c477303901d94b191:timer', 'i:1782941967;', 1782941967),
('suraki-helpdesk-cache-8d5d7e33b971b10ffdc90c15601a909405c20811', 'i:1;', 1782995673),
('suraki-helpdesk-cache-8d5d7e33b971b10ffdc90c15601a909405c20811:timer', 'i:1782995673;', 1782995673),
('suraki-helpdesk-cache-9595a99e7d34ae13a9fda34f445fae13c839e8f7', 'i:1;', 1782973833),
('suraki-helpdesk-cache-9595a99e7d34ae13a9fda34f445fae13c839e8f7:timer', 'i:1782973833;', 1782973833),
('suraki-helpdesk-cache-ab194a33042d7c7fa238d219a642f90a752490ea', 'i:1;', 1783067902),
('suraki-helpdesk-cache-ab194a33042d7c7fa238d219a642f90a752490ea:timer', 'i:1783067901;', 1783067901),
('suraki-helpdesk-cache-admin_sistemas|190.6.56.239', 'i:1;', 1783358407),
('suraki-helpdesk-cache-admin_sistemas|190.6.56.239:timer', 'i:1783358407;', 1783358407),
('suraki-helpdesk-cache-bc4c180c83fef78f4484677b17d668e834abc27c', 'i:1;', 1783026637),
('suraki-helpdesk-cache-bc4c180c83fef78f4484677b17d668e834abc27c:timer', 'i:1783026637;', 1783026637),
('suraki-helpdesk-cache-cb712de4389a7d7e485511a7eb1b1e8c9a700c5f', 'i:1;', 1782972520),
('suraki-helpdesk-cache-cb712de4389a7d7e485511a7eb1b1e8c9a700c5f:timer', 'i:1782972520;', 1782972520),
('suraki-helpdesk-cache-d0c83bd97542a3f184071545f897152eb2caef3e', 'i:1;', 1783028505),
('suraki-helpdesk-cache-d0c83bd97542a3f184071545f897152eb2caef3e:timer', 'i:1783028505;', 1783028505),
('suraki-helpdesk-cache-d35e34544690c723651e14388509777b84786a3c', 'i:1;', 1783040913),
('suraki-helpdesk-cache-d35e34544690c723651e14388509777b84786a3c:timer', 'i:1783040913;', 1783040913),
('suraki-helpdesk-cache-d942f55da6f0f1b59be76c5d9adda34e076b2ce9', 'i:1;', 1783113056),
('suraki-helpdesk-cache-d942f55da6f0f1b59be76c5d9adda34e076b2ce9:timer', 'i:1783113056;', 1783113056),
('suraki-helpdesk-cache-db69c531d8dab99d6f2a6aba5438edec', 'i:3;', 1783358390),
('suraki-helpdesk-cache-db69c531d8dab99d6f2a6aba5438edec:timer', 'i:1783358390;', 1783358390),
('suraki-helpdesk-cache-e1eec610794f98811ed5ee6d71fb48273e641d51', 'i:1;', 1783275239),
('suraki-helpdesk-cache-e1eec610794f98811ed5ee6d71fb48273e641d51:timer', 'i:1783275239;', 1783275239),
('suraki-helpdesk-cache-f14664ee3f0ecc8d6d581650a7f6c298235573e7', 'i:1;', 1782941109),
('suraki-helpdesk-cache-f14664ee3f0ecc8d6d581650a7f6c298235573e7:timer', 'i:1782941109;', 1782941109),
('suraki-helpdesk-cache-fc4524b8bc143dcc9ac570849a105bace9a85d88', 'i:2;', 1782940240),
('suraki-helpdesk-cache-fc4524b8bc143dcc9ac570849a105bace9a85d88:timer', 'i:1782940240;', 1782940240),
('suraki-helpdesk-cache-fd5d6d7311a6fe02d7d5fe83f5c3e518209f209f', 'i:1;', 1783058450),
('suraki-helpdesk-cache-fd5d6d7311a6fe02d7d5fe83f5c3e518209f209f:timer', 'i:1783058450;', 1783058450),
('suraki-helpdesk-cache-inventory_dropdowns', 'a:4:{s:5:\"types\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"statuses\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"branches\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"Distribucion\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"Distribucion\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:6:\"Galpon\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:6:\"Galpon\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:12:\"Hiper Suraki\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:12:\"Hiper Suraki\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:4:\"2kNR\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:4:\"2kNR\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:7:\"Lacteos\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:7:\"Lacteos\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:18:\"Surakarne Americas\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:18:\"Surakarne Americas\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"departments\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Sistemas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Sistemas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:9:\"Tesoreria\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:9:\"Tesoreria\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Compras\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Compras\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:11:\"Liquidacion\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:11:\"Liquidacion\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:6:\"Ventas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:6:\"Ventas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:16:\"Recursos Humanos\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:16:\"Recursos Humanos\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}', 1783039433),
('suraki-helpdesk-cache-inventory_stats', 'a:4:{s:5:\"total\";i:0;s:7:\"activos\";i:0;s:12:\"enReparacion\";i:0;s:9:\"dadosBaja\";i:0;}', 1783036839),
('suraki-helpdesk-cache-ticket_form_dropdowns', 'a:2:{s:8:\"branches\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"Distribucion\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"Distribucion\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:6:\"Galpon\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:6:\"Galpon\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:12:\"Hiper Suraki\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:12:\"Hiper Suraki\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:4:\"2kNR\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:4:\"2kNR\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:7:\"Lacteos\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:7:\"Lacteos\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:17:\"App\\Models\\Branch\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"branches\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:18:\"Surakarne Americas\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:18:\"Surakarne Americas\";s:7:\"address\";N;s:5:\"phone\";N;s:9:\"is_active\";s:1:\"1\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:4:\"name\";i:1;s:7:\"address\";i:2;s:5:\"phone\";i:3;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"departments\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Sistemas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Sistemas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:9:\"Tesoreria\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"2\";s:4:\"name\";s:9:\"Tesoreria\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Compras\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Compras\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:11:\"Liquidacion\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:11:\"Liquidacion\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:6:\"Ventas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:6:\"Ventas\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:21:\"App\\Models\\Department\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"departments\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:4:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:16:\"Recursos Humanos\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:11:\"\0*\0original\";a:4:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:16:\"Recursos Humanos\";s:10:\"created_at\";s:19:\"2026-07-01 16:21:49\";s:10:\"updated_at\";s:19:\"2026-07-01 16:21:49\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}', 1783039463);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Sistemas', '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(2, 'Tesoreria', '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(3, 'Compras', '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(4, 'Liquidacion', '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(5, 'Ventas', '2026-07-01 20:21:49', '2026-07-01 20:21:49'),
(6, 'Recursos Humanos', '2026-07-01 20:21:49', '2026-07-01 20:21:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `specs` varchar(255) DEFAULT NULL,
  `type` enum('Laptop','Desktop','Servidor','Red','Impresora','Otro') NOT NULL DEFAULT 'Laptop',
  `serial_number` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Activo','En reparacion','De baja') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `devices`
--

INSERT INTO `devices` (`id`, `name`, `specs`, `type`, `serial_number`, `branch_id`, `department_id`, `assigned_to`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dell Latitude 7430', 'i7-1265U / 16GB / 512GB SSD', 'Laptop', 'SN-5CD1234ABC', 1, 1, NULL, 'Activo', '2026-07-01 20:21:49', '2026-07-02 23:43:53', '2026-07-02 23:43:53'),
(2, 'HP ProDesk 600 G9', 'i5-13500 / 32GB / 1TB NVMe', 'Desktop', 'SN-CZC5678XYZ', 1, 2, NULL, 'Activo', '2026-07-01 20:21:49', '2026-07-02 23:43:29', '2026-07-02 23:43:29'),
(3, 'Dell PowerEdge R750', '2x Xeon Gold / 256GB / 8x 2TB', 'Servidor', 'SN-SRV2024001', 2, 1, NULL, 'Activo', '2026-07-01 20:21:49', '2026-07-02 23:43:26', '2026-07-02 23:43:26'),
(4, 'Lenovo ThinkPad T14', 'i5-1245U / 16GB / 256GB SSD', 'Laptop', 'SN-PF1AB2CD34', 3, NULL, NULL, 'En reparacion', '2026-07-01 20:21:49', '2026-07-02 23:43:19', '2026-07-02 23:43:19'),
(5, 'Cisco Catalyst 9300', '48 puertos / PoE+ / 10Gb uplink', 'Red', 'SN-FOC9876WXY', 2, 1, NULL, 'Activo', '2026-07-01 20:21:49', '2026-07-02 23:43:15', '2026-07-02 23:43:15'),
(6, 'MacBook Pro 14 M3', 'M3 Pro / 18GB / 512GB SSD', 'Laptop', 'SN-C02XYZ1234', 4, NULL, NULL, 'De baja', '2026-07-01 20:21:49', '2026-07-02 11:58:46', '2026-07-02 11:58:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
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
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_10_001655_create_tickets_table', 1),
(5, '2026_06_10_004857_create_notifications_table', 1),
(6, '2026_06_21_012413_create_activity_logs_table', 1),
(7, '2026_06_21_012418_create_route_logs_table', 1),
(8, '2026_06_21_150559_create_requests_table', 1),
(9, '2026_06_21_150600_create_request_comments_table', 1),
(10, '2026_06_21_205247_create_user_schedules_table', 1),
(11, '2026_06_21_205252_create_work_shifts_table', 1),
(12, '2026_06_29_000001_add_performance_indexes', 1),
(13, '2026_06_29_000002_add_soft_deletes_to_key_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('258116a1-76f2-43bd-9722-760a8b2283fe', 'App\\Notifications\\PasswordResetAdminNotification', 'App\\Models\\User', 2, '{\"message\":\"El usuario Administrador (admin_sistemas) olvid\\u00f3 su contrase\\u00f1a.\",\"title\":\"Solicitud de Restablecimiento de Clave\",\"ticket_id\":null}', NULL, '2026-07-06 17:04:49', '2026-07-06 17:04:49'),
('8f1e5d57-0120-45b1-858e-d8fb460fc590', 'App\\Notifications\\PasswordResetAdminNotification', 'App\\Models\\User', 1, '{\"message\":\"El usuario Administrador (admin_sistemas) olvid\\u00f3 su contrase\\u00f1a.\",\"title\":\"Solicitud de Restablecimiento de Clave\",\"ticket_id\":null}', NULL, '2026-07-06 17:04:49', '2026-07-06 17:04:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `urgency` enum('baja','media','alta','critica') NOT NULL DEFAULT 'media',
  `status` varchar(255) NOT NULL DEFAULT 'pendiente',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `proof_photo_path` varchar(255) DEFAULT NULL,
  `delivery_note` varchar(255) DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `request_comments`
--

CREATE TABLE `request_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `route_logs`
--

CREATE TABLE `route_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` varchar(1000) NOT NULL,
  `method` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `route_logs`
--

INSERT INTO `route_logs` (`id`, `user_id`, `url`, `method`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-07-01 21:06:14', '2026-07-01 21:06:14'),
(2, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-07-01 21:06:14', '2026-07-01 21:06:14'),
(3, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-07-01 21:06:30', '2026-07-01 21:06:30'),
(4, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-07-01 21:06:40', '2026-07-01 21:06:40'),
(5, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-07-01 21:06:40', '2026-07-01 21:06:40'),
(6, NULL, 'https://sistemassuraki.suraki.net', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:07:01', '2026-07-01 21:07:01'),
(7, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:07:01', '2026-07-01 21:07:01'),
(8, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:07:36', '2026-07-01 21:07:36'),
(9, 1, 'https://sistemassuraki.suraki.net/profile', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:07:51', '2026-07-01 21:07:51'),
(10, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:08:04', '2026-07-01 21:08:04'),
(11, 1, 'https://sistemassuraki.suraki.net/profile', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:08:07', '2026-07-01 21:08:07'),
(12, NULL, 'https://sistemassuraki.suraki.net', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:09:39', '2026-07-01 21:09:39'),
(13, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '154.39.138.19', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:09:40', '2026-07-01 21:09:40'),
(14, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '154.39.138.19', 'WhatsApp/2.23.20.0', '2026-07-01 21:10:13', '2026-07-01 21:10:13'),
(15, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-01 21:14:05', '2026-07-01 21:14:05'),
(16, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-01 21:14:06', '2026-07-01 21:14:06'),
(17, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '45.92.85.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-01 21:24:09', '2026-07-01 21:24:09'),
(18, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '45.92.85.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-01 21:24:09', '2026-07-01 21:24:09'),
(19, NULL, 'https://sistemassuraki.suraki.net', 'GET', '51.254.49.96', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', '2026-07-01 21:29:31', '2026-07-01 21:29:31'),
(20, NULL, 'https://sistemassuraki.suraki.net', 'GET', '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', '2026-07-01 21:37:52', '2026-07-01 21:37:52'),
(21, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', '2026-07-01 21:37:53', '2026-07-01 21:37:53'),
(22, NULL, 'https://sistemassuraki.suraki.net', 'GET', '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2026-07-01 21:37:54', '2026-07-01 21:37:54'),
(23, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2026-07-01 21:37:55', '2026-07-01 21:37:55'),
(24, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '52.16.245.145', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', '2026-07-01 21:37:56', '2026-07-01 21:37:56'),
(25, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '186.167.228.212', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', '2026-07-01 21:38:27', '2026-07-01 21:38:27'),
(26, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 22:19:50', '2026-07-01 22:19:50'),
(27, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-01 22:19:51', '2026-07-01 22:19:51'),
(28, NULL, 'https://sistemassuraki.suraki.net', 'GET', '185.220.101.14', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-07-01 23:10:18', '2026-07-01 23:10:18'),
(29, NULL, 'https://sistemassuraki.suraki.net', 'GET', '195.211.77.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2026-07-01 23:16:28', '2026-07-01 23:16:28'),
(30, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-01 23:30:23', '2026-07-01 23:30:23'),
(31, NULL, 'https://sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-01 23:39:33', '2026-07-01 23:39:33'),
(32, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-02 03:11:05', '2026-07-02 03:11:05'),
(33, NULL, 'https://sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-02 03:21:21', '2026-07-02 03:21:21'),
(34, NULL, 'https://sistemassuraki.suraki.net', 'GET', '149.50.96.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:39', '2026-07-02 06:07:39'),
(35, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '149.50.96.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:40', '2026-07-02 06:07:40'),
(36, NULL, 'https://sistemassuraki.suraki.net', 'GET', '172.86.119.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:57', '2026-07-02 06:07:57'),
(37, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '172.86.119.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:57', '2026-07-02 06:07:57'),
(38, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '172.86.119.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:58', '2026-07-02 06:07:58'),
(39, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '172.86.119.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-07-02 06:07:58', '2026-07-02 06:07:58'),
(40, NULL, 'https://sistemassuraki.suraki.net', 'GET', '104.248.121.128', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-02 06:29:27', '2026-07-02 06:29:27'),
(41, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '104.248.121.128', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-02 06:29:33', '2026-07-02 06:29:33'),
(42, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-02 06:51:28', '2026-07-02 06:51:28'),
(43, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:56:55', '2026-07-02 11:56:55'),
(44, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:57:58', '2026-07-02 11:57:58'),
(45, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:06', '2026-07-02 11:58:06'),
(46, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:08', '2026-07-02 11:58:08'),
(47, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:09', '2026-07-02 11:58:09'),
(48, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:14', '2026-07-02 11:58:14'),
(49, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:50', '2026-07-02 11:58:50'),
(50, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:58:55', '2026-07-02 11:58:55'),
(51, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:59:00', '2026-07-02 11:59:00'),
(52, 1, 'https://sistemassuraki.suraki.net/requests/crear', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:59:05', '2026-07-02 11:59:05'),
(53, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:59:09', '2026-07-02 11:59:09'),
(54, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 11:59:16', '2026-07-02 11:59:16'),
(55, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:32', '2026-07-02 12:01:32'),
(56, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:40', '2026-07-02 12:01:40'),
(57, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:40', '2026-07-02 12:01:40'),
(58, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:42', '2026-07-02 12:01:42'),
(59, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:44', '2026-07-02 12:01:44'),
(60, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:49', '2026-07-02 12:01:49'),
(61, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:01:51', '2026-07-02 12:01:51'),
(62, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:03:52', '2026-07-02 12:03:52'),
(63, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:03:54', '2026-07-02 12:03:54'),
(64, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:03:55', '2026-07-02 12:03:55'),
(65, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:02', '2026-07-02 12:04:02'),
(66, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:17', '2026-07-02 12:04:17'),
(67, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:20', '2026-07-02 12:04:20'),
(68, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:23', '2026-07-02 12:04:23'),
(69, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:23', '2026-07-02 12:04:23'),
(70, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:28', '2026-07-02 12:04:28'),
(71, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:32', '2026-07-02 12:04:32'),
(72, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:04:49', '2026-07-02 12:04:49'),
(73, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:07:24', '2026-07-02 12:07:24'),
(74, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:07:33', '2026-07-02 12:07:33'),
(75, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:07:37', '2026-07-02 12:07:37'),
(76, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:07:40', '2026-07-02 12:07:40'),
(77, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '34.139.16.189', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:15:51', '2026-07-02 12:15:51'),
(78, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '34.139.16.189', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:15:52', '2026-07-02 12:15:52'),
(79, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:30:43', '2026-07-02 12:30:43'),
(80, NULL, 'https://sistemassuraki.suraki.net', 'GET', '35.187.90.34', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:33:33', '2026-07-02 12:33:33'),
(81, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '35.187.90.34', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:33:33', '2026-07-02 12:33:33'),
(82, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:35:32', '2026-07-02 12:35:32'),
(83, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 12:35:33', '2026-07-02 12:35:33'),
(84, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '136.118.118.65', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:39:49', '2026-07-02 12:39:49'),
(85, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '136.118.118.65', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:39:50', '2026-07-02 12:39:50'),
(86, NULL, 'https://sistemassuraki.suraki.net', 'GET', '35.197.121.122', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:45:08', '2026-07-02 12:45:08'),
(87, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '35.197.121.122', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', '2026-07-02 12:45:09', '2026-07-02 12:45:09'),
(88, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:02', '2026-07-02 13:41:02'),
(89, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:02', '2026-07-02 13:41:02'),
(90, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:04', '2026-07-02 13:41:04'),
(91, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:05', '2026-07-02 13:41:05'),
(92, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:06', '2026-07-02 13:41:06'),
(93, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:09', '2026-07-02 13:41:09'),
(94, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 13:41:12', '2026-07-02 13:41:12'),
(95, NULL, 'https://sistemassuraki.suraki.net', 'GET', '45.45.237.214', 'Mozilla/5.0 (compatible; DeepSeekBot/1.0; +https://www.deepseek.com/bot)', '2026-07-02 14:39:02', '2026-07-02 14:39:02'),
(96, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.45.237.214', 'Mozilla/5.0 (compatible; DeepSeekBot/1.0; +https://www.deepseek.com/bot)', '2026-07-02 14:39:02', '2026-07-02 14:39:02'),
(97, NULL, 'https://sistemassuraki.suraki.net/forgot-password', 'GET', '45.45.237.214', 'Mozilla/5.0 (compatible; PerplexityBot/1.0; +https://perplexity.ai/perplexitybot)', '2026-07-02 14:39:06', '2026-07-02 14:39:06'),
(98, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.45.237.214', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', '2026-07-02 14:39:07', '2026-07-02 14:39:07'),
(99, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 15:02:53', '2026-07-02 15:02:53'),
(100, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 15:02:55', '2026-07-02 15:02:55'),
(101, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 15:02:58', '2026-07-02 15:02:58'),
(102, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 15:10:58', '2026-07-02 15:10:58'),
(103, NULL, 'https://sistemassuraki.suraki.net', 'GET', '155.2.228.196', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-02 19:54:10', '2026-07-02 19:54:10'),
(104, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 20:27:22', '2026-07-02 20:27:22'),
(105, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 20:27:23', '2026-07-02 20:27:23'),
(106, NULL, 'https://sistemassuraki.suraki.net', 'GET', '45.92.84.131', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-02 21:09:37', '2026-07-02 21:09:37'),
(107, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.92.84.131', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-02 21:09:37', '2026-07-02 21:09:37'),
(108, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '45.92.86.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-02 21:40:43', '2026-07-02 21:40:43'),
(109, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '45.92.86.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-02 21:40:45', '2026-07-02 21:40:45'),
(110, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:37:43', '2026-07-02 23:37:43'),
(111, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:41:59', '2026-07-02 23:41:59'),
(112, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:42:09', '2026-07-02 23:42:09'),
(113, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:42:42', '2026-07-02 23:42:42'),
(114, 1, 'https://sistemassuraki.suraki.net/requests', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:42:45', '2026-07-02 23:42:45'),
(115, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:42:50', '2026-07-02 23:42:50'),
(116, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:42:57', '2026-07-02 23:42:57'),
(117, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:43:00', '2026-07-02 23:43:00'),
(118, 1, 'https://sistemassuraki.suraki.net/inventario/crear', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:43:44', '2026-07-02 23:43:44'),
(119, 1, 'https://sistemassuraki.suraki.net/tickets', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:44:17', '2026-07-02 23:44:17'),
(120, 1, 'https://sistemassuraki.suraki.net/tickets/create', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:44:23', '2026-07-02 23:44:23'),
(121, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:44:48', '2026-07-02 23:44:48'),
(122, 1, 'https://sistemassuraki.suraki.net/usuarios/crear', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:44:51', '2026-07-02 23:44:51'),
(123, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:46:06', '2026-07-02 23:46:06'),
(124, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:46:45', '2026-07-02 23:46:45'),
(125, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:48:11', '2026-07-02 23:48:11'),
(126, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:48:19', '2026-07-02 23:48:19'),
(127, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:50:23', '2026-07-02 23:50:23'),
(128, 1, 'https://sistemassuraki.suraki.net/reportes', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:50:31', '2026-07-02 23:50:31'),
(129, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:50:48', '2026-07-02 23:50:48'),
(130, 1, 'https://sistemassuraki.suraki.net/dashboard', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:01', '2026-07-02 23:51:01'),
(131, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:21', '2026-07-02 23:51:21'),
(132, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:26', '2026-07-02 23:51:26'),
(133, 1, 'https://sistemassuraki.suraki.net/schedules/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:31', '2026-07-02 23:51:31'),
(134, 1, 'https://sistemassuraki.suraki.net/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:41', '2026-07-02 23:51:41'),
(135, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:43', '2026-07-02 23:51:43'),
(136, 1, 'https://sistemassuraki.suraki.net/usuarios/2/editar', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:51:51', '2026-07-02 23:51:51'),
(137, 1, 'https://sistemassuraki.suraki.net/usuarios', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:52:06', '2026-07-02 23:52:06'),
(138, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:52:13', '2026-07-02 23:52:13'),
(139, 1, 'https://sistemassuraki.suraki.net/schedules/configuracion', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:52:24', '2026-07-02 23:52:24'),
(140, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:55:14', '2026-07-02 23:55:14'),
(141, 1, 'https://sistemassuraki.suraki.net/inventario', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:55:40', '2026-07-02 23:55:40'),
(142, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-02 23:57:52', '2026-07-02 23:57:52'),
(143, NULL, 'https://sistemassuraki.suraki.net', 'GET', '143.198.72.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Edge/120.0.0.0', '2026-07-03 01:07:33', '2026-07-03 01:07:33'),
(144, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '143.198.72.111', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Edge/120.0.0.0', '2026-07-03 01:07:33', '2026-07-03 01:07:33'),
(145, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '45.83.145.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 01:50:12', '2026-07-03 01:50:12'),
(146, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '45.83.145.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 01:52:59', '2026-07-03 01:52:59'),
(147, NULL, 'https://sistemassuraki.suraki.net', 'GET', '202.78.167.209', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-07-03 04:37:46', '2026-07-03 04:37:46'),
(148, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '202.78.167.209', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-07-03 04:41:12', '2026-07-03 04:41:12'),
(149, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '202.78.167.209', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-07-03 04:41:18', '2026-07-03 04:41:18'),
(150, NULL, 'https://sistemassuraki.suraki.net', 'GET', '24.199.116.138', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:128.0) Gecko/20100101 Firefox/128.0', '2026-07-03 05:59:49', '2026-07-03 05:59:49'),
(151, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '24.199.116.138', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:128.0) Gecko/20100101 Firefox/128.0', '2026-07-03 05:59:50', '2026-07-03 05:59:50'),
(152, NULL, 'https://sistemassuraki.suraki.net', 'GET', '37.228.129.241', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', '2026-07-03 07:28:32', '2026-07-03 07:28:32'),
(153, NULL, 'https://sistemassuraki.suraki.net', 'GET', '171.25.193.78', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-03 08:20:19', '2026-07-03 08:20:19'),
(154, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '143.110.230.60', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-03 08:37:20', '2026-07-03 08:37:20'),
(155, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '143.110.230.60', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-03 08:37:22', '2026-07-03 08:37:22'),
(156, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.83.145.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 11:31:50', '2026-07-03 11:31:50'),
(157, 1, 'https://sistemassuraki.suraki.net/schedules', 'GET', '45.83.145.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 11:41:46', '2026-07-03 11:41:46'),
(158, NULL, 'https://sistemassuraki.suraki.net', 'GET', '45.83.145.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 11:41:53', '2026-07-03 11:41:53'),
(159, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.83.145.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-03 11:41:53', '2026-07-03 11:41:53'),
(160, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '204.48.21.54', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-03 18:29:22', '2026-07-03 18:29:22'),
(161, NULL, 'https://sistemassuraki.suraki.net', 'GET', '45.92.87.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-03 21:09:55', '2026-07-03 21:09:55'),
(162, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '45.92.87.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-03 21:09:56', '2026-07-03 21:09:56'),
(163, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '45.92.84.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-03 21:41:09', '2026-07-03 21:41:09'),
(164, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '45.92.84.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', '2026-07-03 21:41:10', '2026-07-03 21:41:10'),
(165, NULL, 'https://sistemassuraki.suraki.net', 'GET', '143.198.38.42', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-04 06:41:09', '2026-07-04 06:41:09'),
(166, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '143.198.38.42', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-04 06:41:10', '2026-07-04 06:41:10'),
(167, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-04 17:10:25', '2026-07-04 17:10:25'),
(168, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-05 13:32:34', '2026-07-05 13:32:34'),
(169, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '52.86.166.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', '2026-07-05 17:05:41', '2026-07-05 17:05:41'),
(170, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '52.86.166.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', '2026-07-05 17:05:42', '2026-07-05 17:05:42'),
(171, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '52.21.243.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2026-07-05 17:12:31', '2026-07-05 17:12:31'),
(172, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '52.21.243.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2026-07-05 17:12:33', '2026-07-05 17:12:33'),
(173, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '98.88.49.137', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '2026-07-05 17:20:56', '2026-07-05 17:20:56'),
(174, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '98.88.49.137', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '2026-07-05 17:20:59', '2026-07-05 17:20:59'),
(175, NULL, 'https://sistemassuraki.suraki.net', 'GET', '52.21.243.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', '2026-07-05 17:22:21', '2026-07-05 17:22:21'),
(176, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '52.21.243.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', '2026-07-05 17:22:23', '2026-07-05 17:22:23'),
(177, NULL, 'https://sistemassuraki.suraki.net', 'GET', '52.86.166.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '2026-07-05 17:29:10', '2026-07-05 17:29:10'),
(178, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '52.86.166.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '2026-07-05 17:29:13', '2026-07-05 17:29:13'),
(179, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '3.218.85.46', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36', '2026-07-05 17:30:23', '2026-07-05 17:30:23'),
(180, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '3.218.85.46', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36', '2026-07-05 17:30:26', '2026-07-05 17:30:26'),
(181, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '167.99.234.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-05 18:12:57', '2026-07-05 18:12:57'),
(182, NULL, 'https://www.sistemassuraki.suraki.net/login', 'GET', '167.99.234.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2026-07-05 18:12:59', '2026-07-05 18:12:59'),
(183, NULL, 'https://www.sistemassuraki.suraki.net', 'GET', '157.143.3.35', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-05 19:11:08', '2026-07-05 19:11:08'),
(184, NULL, 'https://sistemassuraki.suraki.net', 'GET', '157.143.3.35', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '2026-07-05 19:19:31', '2026-07-05 19:19:31'),
(185, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 16:47:31', '2026-07-06 16:47:31'),
(186, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 16:47:32', '2026-07-06 16:47:32'),
(187, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 17:03:17', '2026-07-06 17:03:17'),
(188, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 17:03:18', '2026-07-06 17:03:18'),
(189, NULL, 'https://sistemassuraki.suraki.net/forgot-password', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 17:04:35', '2026-07-06 17:04:35'),
(190, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-06 17:04:51', '2026-07-06 17:04:51'),
(191, NULL, 'https://sistemassuraki.suraki.net', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-06 17:18:50', '2026-07-06 17:18:50'),
(192, NULL, 'https://sistemassuraki.suraki.net/login', 'GET', '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-06 17:18:50', '2026-07-06 17:18:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
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
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4GtQsahyRGtyk6cukgjE2NpqZvqPaYErNjDhVY1X', NULL, '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJaVXlkMldodW1nNnZyaEdlbmFDMHlQQTFneGtDb0xlTU9PRW5EM3U2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9zaXN0ZW1hc3N1cmFraS5zdXJha2kubmV0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783357491),
('7BUJt3FcwgswTbtbtRIcr9XA6QjOxM5aIEftQGGL', NULL, '190.6.56.239', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlUVRTN01IOEt1Z1JrSmt5bnh1RDQ3V1czcGNiZjBUSHB1MExwaDVRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9zaXN0ZW1hc3N1cmFraS5zdXJha2kubmV0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1783358347);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` enum('hardware','software','redes','otros') NOT NULL DEFAULT 'otros',
  `priority` enum('baja','media','alta','critica') NOT NULL DEFAULT 'media',
  `status` enum('abierto','asignado','en_proceso','pendiente','resuelto','cerrado') NOT NULL DEFAULT 'abierto',
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `resolution_summary` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `display_preference` varchar(255) NOT NULL DEFAULT 'name',
  `role` enum('admin','usuario','outsourcing') NOT NULL DEFAULT 'usuario',
  `status` enum('Activo','Bloqueada','Inactivo') NOT NULL DEFAULT 'Activo',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `username`, `email`, `phone`, `email_verified_at`, `password`, `avatar`, `branch_id`, `department_id`, `bio`, `display_preference`, `role`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrador', NULL, 'admin_sistemas', 'admin@suraki.com', NULL, '2026-07-01 20:21:49', '$2y$12$UmWCIUfqsooFfLduDzrYXez28m7pScF2x6jSTZL2OoQkxPbE0NesC', NULL, NULL, 1, NULL, 'name', 'admin', 'Activo', NULL, '2026-07-01 20:21:49', '2026-07-01 21:09:05', NULL),
(2, 'Alberto', 'Sarmiento', 'Soporte IT Alberto Sarmiento', 'chetoforex@gmail.com', NULL, NULL, '$2y$12$iwCswW.oXZaZOA0sI6ihleJd8t8teER01Dgr00uxBxS6JHfhgHAlu', NULL, 3, 1, NULL, 'name', 'admin', 'Activo', NULL, '2026-07-02 23:46:03', '2026-07-02 23:52:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_schedules`
--

CREATE TABLE `user_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('fijo','outsourcing') NOT NULL DEFAULT 'fijo',
  `monday_start` time DEFAULT NULL,
  `monday_end` time DEFAULT NULL,
  `tuesday_start` time DEFAULT NULL,
  `tuesday_end` time DEFAULT NULL,
  `wednesday_start` time DEFAULT NULL,
  `wednesday_end` time DEFAULT NULL,
  `thursday_start` time DEFAULT NULL,
  `thursday_end` time DEFAULT NULL,
  `friday_start` time DEFAULT NULL,
  `friday_end` time DEFAULT NULL,
  `saturday_start` time DEFAULT NULL,
  `saturday_end` time DEFAULT NULL,
  `sunday_start` time DEFAULT NULL,
  `sunday_end` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_schedules`
--

INSERT INTO `user_schedules` (`id`, `user_id`, `type`, `monday_start`, `monday_end`, `tuesday_start`, `tuesday_end`, `wednesday_start`, `wednesday_end`, `thursday_start`, `thursday_end`, `friday_start`, `friday_end`, `saturday_start`, `saturday_end`, `sunday_start`, `sunday_end`, `created_at`, `updated_at`) VALUES
(1, 2, 'fijo', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '17:00:00', '07:00:00', '22:30:00', '07:00:00', '17:00:00', NULL, NULL, '08:00:00', '14:00:00', '2026-07-02 23:55:14', '2026-07-02 23:55:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_shifts`
--

CREATE TABLE `work_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `scheduled_start` time DEFAULT NULL,
  `scheduled_end` time DEFAULT NULL,
  `check_in` timestamp NULL DEFAULT NULL,
  `check_out` timestamp NULL DEFAULT NULL,
  `status` enum('programado','en_curso','completado','ausente','cancelado') NOT NULL DEFAULT 'programado',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_name_unique` (`name`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices_serial_number_unique` (`serial_number`),
  ADD KEY `devices_branch_id_foreign` (`branch_id`),
  ADD KEY `devices_department_id_foreign` (`department_id`),
  ADD KEY `devices_assigned_to_foreign` (`assigned_to`),
  ADD KEY `devices_status_index` (`status`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requests_user_id_foreign` (`user_id`),
  ADD KEY `requests_assigned_to_foreign` (`assigned_to`);

--
-- Indices de la tabla `request_comments`
--
ALTER TABLE `request_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_comments_user_id_foreign` (`user_id`),
  ADD KEY `request_comments_request_id_index` (`request_id`);

--
-- Indices de la tabla `route_logs`
--
ALTER TABLE `route_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_logs_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_branch_id_foreign` (`branch_id`),
  ADD KEY `tickets_department_id_foreign` (`department_id`),
  ADD KEY `tickets_device_id_foreign` (`device_id`),
  ADD KEY `tickets_status_index` (`status`),
  ADD KEY `tickets_priority_index` (`priority`),
  ADD KEY `tickets_creator_id_index` (`creator_id`),
  ADD KEY `tickets_assigned_to_index` (`assigned_to`),
  ADD KEY `tickets_status_created_at_index` (`status`,`created_at`);

--
-- Indices de la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_messages_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_branch_id_foreign` (`branch_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_status_index` (`status`);

--
-- Indices de la tabla `user_schedules`
--
ALTER TABLE `user_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_schedules_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `work_shifts`
--
ALTER TABLE `work_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_shifts_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `request_comments`
--
ALTER TABLE `request_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `route_logs`
--
ALTER TABLE `route_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_schedules`
--
ALTER TABLE `user_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `work_shifts`
--
ALTER TABLE `work_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `devices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `devices_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `request_comments`
--
ALTER TABLE `request_comments`
  ADD CONSTRAINT `request_comments_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `route_logs`
--
ALTER TABLE `route_logs`
  ADD CONSTRAINT `route_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `user_schedules`
--
ALTER TABLE `user_schedules`
  ADD CONSTRAINT `user_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_shifts`
--
ALTER TABLE `work_shifts`
  ADD CONSTRAINT `work_shifts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
