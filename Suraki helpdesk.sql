-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla suraki_helpdesk.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.cache: ~6 rows (aproximadamente)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('suraki-helpdesk-cache-admin@suraki.local|127.0.0.1', 'i:1;', 1781132108),
	('suraki-helpdesk-cache-admin@suraki.local|127.0.0.1:timer', 'i:1781132108;', 1781132108),
	('suraki-helpdesk-cache-admin|127.0.0.1', 'i:1;', 1781131823),
	('suraki-helpdesk-cache-admin|127.0.0.1:timer', 'i:1781131823;', 1781131823),
	('suraki-helpdesk-cache-administrador|127.0.0.1', 'i:1;', 1781131863),
	('suraki-helpdesk-cache-administrador|127.0.0.1:timer', 'i:1781131863;', 1781131863);

-- Volcando estructura para tabla suraki_helpdesk.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla suraki_helpdesk.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla suraki_helpdesk.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla suraki_helpdesk.job_batches
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

-- Volcando datos para la tabla suraki_helpdesk.job_batches: ~0 rows (aproximadamente)

-- Volcando estructura para tabla suraki_helpdesk.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.migrations: ~7 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_06_10_001654_create_sucursals_table', 1),
	(5, '2026_06_10_001654_create_tickets_table', 1),
	(6, '2026_06_10_001655_add_fields_to_users_table', 1),
	(7, '2026_06_10_004857_create_notifications_table', 1);

-- Volcando estructura para tabla suraki_helpdesk.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.notifications: ~2 rows (aproximadamente)
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('06a4da2d-b543-484d-ac72-911d1aab71b6', 'App\\Notifications\\TicketStatusUpdatedNotification', 'App\\Models\\User', 2, '{"ticket_id":1,"message":"El estado de tu ticket ha cambiado a: Abierto","status":"abierto"}', '2026-06-11 02:21:17', '2026-06-11 02:20:59', '2026-06-11 02:21:17'),
	('f3701a89-43d9-4b4e-831d-25386f7c36b7', 'App\\Notifications\\TicketStatusUpdatedNotification', 'App\\Models\\User', 2, '{"ticket_id":1,"message":"El estado de tu ticket ha cambiado a: En proceso","status":"en_proceso"}', '2026-06-11 02:21:56', '2026-06-11 02:21:38', '2026-06-11 02:21:56');

-- Volcando estructura para tabla suraki_helpdesk.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla suraki_helpdesk.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.sessions: ~1 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('PDebPZ4HVE9y2u26PkIW3iqMiFKdXZnXkYLiJWTo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJ6R1JyNjJ3NWNia2JLOG53VUo3QmdnZE0zem16OUxHcXdUV3djSjBSIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvc3VyYWtpLWhlbHBkZXNrLnRlc3QiLCJyb3V0ZSI6bnVsbH0sInVybCI6eyJpbnRlbmRlZCI6Imh0dHA6XC9cL3N1cmFraS1oZWxwZGVzay50ZXN0XC9kYXNoYm9hcmQifX0=', 1781271354);

-- Volcando estructura para tabla suraki_helpdesk.sucursales
CREATE TABLE IF NOT EXISTS `sucursales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.sucursales: ~3 rows (aproximadamente)
INSERT INTO `sucursales` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
	(1, 'Andinka', '2026-06-11 02:02:33', '2026-06-11 02:02:33'),
	(2, 'Kikana', '2026-06-11 02:02:33', '2026-06-11 02:02:33'),
	(3, 'Nabilka', '2026-06-11 02:02:33', '2026-06-11 02:02:33');

-- Volcando estructura para tabla suraki_helpdesk.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sucursal_id` bigint unsigned NOT NULL,
  `area_departamento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipo_afectado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('baja','media','alta','critica') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'media',
  `status` enum('abierto','en_proceso','resuelto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'abierto',
  `creator_id` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `resolution_summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_sucursal_id_foreign` (`sucursal_id`),
  KEY `tickets_creator_id_foreign` (`creator_id`),
  KEY `tickets_assigned_to_foreign` (`assigned_to`),
  CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tickets_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `tickets_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.tickets: ~2 rows (aproximadamente)
INSERT INTO `tickets` (`id`, `title`, `description`, `sucursal_id`, `area_departamento`, `equipo_afectado`, `priority`, `status`, `creator_id`, `assigned_to`, `resolution_summary`, `created_at`, `updated_at`) VALUES
	(1, 'Impresora no Prende', 'La impresora estaba encendida y de repente se apago ', 1, 'Liquidacion', 'EPSON L3250', 'media', 'en_proceso', 2, 1, NULL, '2026-06-11 02:20:35', '2026-06-11 02:21:38'),
	(2, 'UPS dañado', 'El UPS se apaga y no resiste la carga de los equipos', 3, 'Administracion', 'Equipo Lcda Claudia', 'alta', 'en_proceso', 2, 1, NULL, '2026-06-11 02:37:46', '2026-06-11 02:37:59');

-- Volcando estructura para tabla suraki_helpdesk.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sucursal_id` bigint unsigned DEFAULT NULL,
  `rol` enum('admin','usuario') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_sucursal_id_foreign` (`sucursal_id`),
  CONSTRAINT `users_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla suraki_helpdesk.users: ~3 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `sucursal_id`, `rol`) VALUES
	(1, 'Juan Peñuela', 'admin@suraki.local', NULL, '$2y$12$71zQGryWUV7.7gpc9UsXUudBiGty/HMJ61EjS0sBcPcqs4UpdeyLG', 'buDLcxT59Y85jll498DGhi1C6Y6Ha0QRywAwdFgI5elNXi4qPZeNF24yXLu9', '2026-06-11 02:02:33', '2026-06-11 02:19:00', 'admin_sistemas', NULL, 'admin'),
	(2, 'Pedrito Perez', 'usuario@suraki.local', NULL, '$2y$12$1FULvzda59pwA6/fOUY58uokgHQWT97hMglRTdVvqsqYJgo8qfI0m', 'kWweNZw0sGLDRXBTZ0Quq5JImWgf1BK1glvjIKntco1WcuyrnzGDBTBeplib', '2026-06-11 02:02:33', '2026-06-11 02:18:26', 'usuario_caja1', 1, 'usuario'),
	(3, 'Test', 'admin@suraki.test', NULL, '$2y$12$VA0s2fF1dzmT/bUyrD2BFebrl0IuU7k0BKlDiwahZLMIKY9enZ1fy', NULL, '2026-06-11 02:52:19', '2026-06-11 02:52:19', 'admin_test_test', NULL, 'usuario');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
