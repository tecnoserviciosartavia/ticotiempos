/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tiempos
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `num_id` varchar(20) NOT NULL,
  `nombre` varchar(191) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES
(3,'1000000000','CLIENTE CONTADO','9999999999','CONTADO@gmail.com','2022-09-06 22:54:01','2022-09-06 22:54:01');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_sorteo`
--

DROP TABLE IF EXISTS `config_sorteo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `config_sorteo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsorteo` bigint(20) unsigned NOT NULL,
  `restrinccion_numero` int(3) unsigned DEFAULT NULL,
  `restrinccion_monto` double(18,5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_sorteo`
--

LOCK TABLES `config_sorteo` WRITE;
/*!40000 ALTER TABLE `config_sorteo` DISABLE KEYS */;
INSERT INTO `config_sorteo` VALUES
(1,1,NULL,NULL,'2025-09-04 00:00:00','2025-09-04 00:00:00'),
(2,2,NULL,NULL,'2025-09-04 00:00:00','2025-09-04 00:00:00'),
(3,3,NULL,NULL,'2025-09-04 00:00:00','2025-09-04 00:00:00');
/*!40000 ALTER TABLE `config_sorteo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2022_10_27_151141_add_new_field_venta',1),
(3,'2022_11_12_092942_add_column_to_sorteos',2),
(4,'2022_11_19_081727_add_column_name_on_table_sorteos',3),
(6,'2022_12_10_114639_create_user_balances',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros_sorteos`
--

DROP TABLE IF EXISTS `parametros_sorteos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametros_sorteos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) unsigned NOT NULL,
  `idsorteo` bigint(20) unsigned NOT NULL,
  `paga` double(18,3) unsigned NOT NULL,
  `comision` double(5,2) NOT NULL,
  `devolucion` double(4,2) NOT NULL DEFAULT 0.00,
  `monto_arranque` double(18,3) NOT NULL DEFAULT 0.000,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros_sorteos`
--

LOCK TABLES `parametros_sorteos` WRITE;
/*!40000 ALTER TABLE `parametros_sorteos` DISABLE KEYS */;
INSERT INTO `parametros_sorteos` VALUES
(1,14,1,90.000,5.00,0.00,0.000),
(2,15,1,90.000,5.00,0.00,0.000),
(3,19,1,90.000,5.00,0.00,0.000),
(4,14,2,90.000,5.00,0.00,0.000),
(5,15,2,90.000,5.00,0.00,0.000),
(6,19,2,90.000,5.00,0.00,0.000),
(7,14,3,90.000,5.00,0.00,0.000),
(8,15,3,90.000,5.00,0.00,0.000),
(9,19,3,90.000,5.00,0.00,0.000);
/*!40000 ALTER TABLE `parametros_sorteos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultados_parametros`
--

DROP TABLE IF EXISTS `resultados_parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultados_parametros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(2) NOT NULL,
  `color` varchar(191) NOT NULL,
  `paga_resultado` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultados_parametros`
--

LOCK TABLES `resultados_parametros` WRITE;
/*!40000 ALTER TABLE `resultados_parametros` DISABLE KEYS */;
INSERT INTO `resultados_parametros` VALUES
(1,'B','#ffffff',0),
(4,'R','#ee2c1b',300),
(5,'V','#008000',120);
/*!40000 ALTER TABLE `resultados_parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sorteos`
--

DROP TABLE IF EXISTS `sorteos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sorteos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) NOT NULL,
  `hora` time NOT NULL,
  `dias` longtext NOT NULL,
  `estatus` int(1) DEFAULT 1,
  `logo` varchar(255) DEFAULT NULL,
  `es_reventado` int(11) NOT NULL DEFAULT 0,
  `usa_webservice` int(11) NOT NULL DEFAULT 0,
  `numero_sorteo_webservice` int(11) NOT NULL DEFAULT 0,
  `url_webservice` text NOT NULL,
  `monto_limite_numero` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sorteos`
--

LOCK TABLES `sorteos` WRITE;
/*!40000 ALTER TABLE `sorteos` DISABLE KEYS */;
INSERT INTO `sorteos` VALUES
(1,'TICA DIA','12:55:00','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]',1,NULL,0,0,0,'',5000,'2025-09-04 00:00:00','2025-09-04 00:00:00'),
(2,'TICA TARDE','16:30:00','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]',1,NULL,0,0,0,'',5000,'2025-09-04 00:00:00','2025-09-04 00:00:00'),
(3,'TICA NOCHE','19:30:00','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]',1,NULL,0,0,0,'',5000,'2025-09-04 00:00:00','2025-09-04 00:00:00');
/*!40000 ALTER TABLE `sorteos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transacciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` int(20) unsigned NOT NULL,
  `monto` double(18,5) NOT NULL,
  `concepto` varchar(191) NOT NULL,
  `tipo_concepto` enum('venta','comision','premio','retiro','otro') NOT NULL,
  `json_dinamico` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_dinamico`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones`
--

LOCK TABLES `transacciones` WRITE;
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `transacciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_balances`
--

DROP TABLE IF EXISTS `user_balances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_balances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(10) unsigned NOT NULL,
  `saldo_anterior` double(18,3) NOT NULL,
  `premios_del_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `ventas_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `comisiones_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `saldo_final` double(18,3) NOT NULL DEFAULT 0.000,
  `fecha_diaria` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_balances`
--

LOCK TABLES `user_balances` WRITE;
/*!40000 ALTER TABLE `user_balances` DISABLE KEYS */;
INSERT INTO `user_balances` VALUES
(1,14,0.000,0.000,0.000,0.000,0.000,'2023-08-23','2023-08-24 04:24:57','2023-08-24 04:24:57'),
(2,15,0.000,0.000,0.000,0.000,0.000,'2023-08-23','2023-08-24 04:24:57','2023-08-24 04:24:57'),
(3,16,0.000,0.000,0.000,0.000,0.000,'2023-08-23','2023-08-24 04:24:57','2023-08-24 04:24:57'),
(4,19,0.000,0.000,0.000,0.000,0.000,'2023-08-23','2023-08-24 04:44:04','2023-08-24 04:44:04');
/*!40000 ALTER TABLE `user_balances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `es_administrador` int(1) unsigned DEFAULT 0,
  `saldo_actual` double(18,5) DEFAULT 0.00000,
  `block_user` int(11) NOT NULL DEFAULT 0,
  `cod_unico` varchar(255) NOT NULL DEFAULT 'MTIzNDU2',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(14,'puesto1','puesto1@ticotiempos.com',NULL,'$2y$10$d4wDwhzzJqvFpm.Rts4c4u5qGJ1VEXGyztSB8BqSYLA9/CZlbfdZe','64ec07e484299_LOGODkk.png','female',1,0,0.00000,0,'Nzg3OA==',NULL,NULL,'2022-08-30 20:22:49','2023-08-28 02:42:01'),
(15,'puesto2','puesto2@ticotiempos.com',NULL,'$2y$10$N9qb4laG4pL3Yvj0sAGl1.ix9o7lUpORz5SoaI49zQpYjSEeSOdDu','64ec08616059e_LOGODkk.png','male',1,0,0.00000,0,'MTIzNDU2',NULL,NULL,'2022-08-30 20:24:01','2023-08-28 02:42:17'),
(16,'Administrador','admin@ticotiempos.com',NULL,'$2y$10$d6B9eevI0MEWx7nItd1qfemcmtXkRwlhxnzjdr9LXy1sPYstI/gfC','64ec086f25502_LOGODkk.png','male',1,1,0.00000,0,'MTIzNDU2',NULL,NULL,'2022-09-05 16:12:41','2025-09-04 18:15:38'),
(19,'puesto3','puesto3@ticotiempos.com',NULL,'$2y$10$k5rp76ZPVqUzUYvh5cVtlOJbe8BDMdj7/EAk4dAcFs42jCZ1UBaY2','64ec09ab3bf33_LOGODkk.png','male',1,0,0.00000,0,'MTIzNDU2',NULL,NULL,'2023-08-24 04:44:04','2023-08-28 02:43:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_cabecera`
--

DROP TABLE IF EXISTS `venta_cabecera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_cabecera` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsorteo` bigint(20) unsigned NOT NULL,
  `idconfigsorteo` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estatus` enum('abierto','cerrado','calculado','finalizado') NOT NULL DEFAULT 'abierto',
  `cierra_antes` int(11) NOT NULL,
  `monto_venta` double(18,5) NOT NULL DEFAULT 0.00000,
  `numero_ganador` int(3) DEFAULT NULL,
  `adicional_ganador` varchar(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_cabecera`
--

LOCK TABLES `venta_cabecera` WRITE;
/*!40000 ALTER TABLE `venta_cabecera` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_cabecera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_detalle` (
  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
  `idventa_cabecera` bigint(20) unsigned NOT NULL,
  `idusuario` bigint(20) unsigned NOT NULL,
  `idcliente` bigint(20) unsigned NOT NULL,
  `numero` int(3) unsigned NOT NULL,
  `monto` double(18,5) NOT NULL,
  `reventado` int(11) NOT NULL DEFAULT 0,
  `monto_reventado` double(18,3) DEFAULT 0.000,
  `jugada_padre` bigint(20) unsigned DEFAULT NULL,
  `estatus` enum('en proceso','apostada','calculada','ganadora') NOT NULL DEFAULT 'en proceso',
  `es_ganador` int(1) DEFAULT 0,
  `monto_ganador` double(18,5) DEFAULT 0.00000,
  `fue_pagado` int(11) NOT NULL DEFAULT 0,
  `impreso` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_detalle`
--

LOCK TABLES `venta_detalle` WRITE;
/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-04 18:19:17
