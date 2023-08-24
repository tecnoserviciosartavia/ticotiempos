-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2023 a las 00:05:10
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `num_id` varchar(20) NOT NULL,
  `nombre` varchar(191) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `num_id`, `nombre`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(3, '1000000000', 'CLIENTE CONTADO', '9999999999', 'CONTADO@gmail.com', '2022-09-06 22:54:01', '2022-09-06 22:54:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_sorteo`
--

CREATE TABLE `config_sorteo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idsorteo` bigint(20) UNSIGNED NOT NULL,
  `restrinccion_numero` int(3) UNSIGNED DEFAULT NULL,
  `restrinccion_monto` double(18,5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
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
-- Estructura de tabla para la tabla `jobs`
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
(1, '2022_10_27_151141_add_new_field_venta', 1),
(3, '2022_11_12_092942_add_column_to_sorteos', 2),
(4, '2022_11_19_081727_add_column_name_on_table_sorteos', 3),
(6, '2022_12_10_114639_create_user_balances', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros_sorteos`
--

CREATE TABLE `parametros_sorteos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idsorteo` bigint(20) UNSIGNED NOT NULL,
  `paga` double(18,3) UNSIGNED NOT NULL,
  `comision` double(5,2) NOT NULL,
  `devolucion` double(4,2) NOT NULL DEFAULT 0.00,
  `monto_arranque` double(18,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_parametros`
--

CREATE TABLE `resultados_parametros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(2) NOT NULL,
  `color` varchar(191) NOT NULL,
  `paga_resultado` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_parametros`
--

INSERT INTO `resultados_parametros` (`id`, `descripcion`, `color`, `paga_resultado`) VALUES
(1, 'B', '#ffffff', 0),
(4, 'R', '#ee2c1b', 300),
(5, 'V', '#008000', 120);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sorteos`
--

CREATE TABLE `sorteos` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idusuario` int(20) UNSIGNED NOT NULL,
  `monto` double(18,5) NOT NULL,
  `concepto` varchar(191) NOT NULL,
  `tipo_concepto` enum('venta','comision','premio','retiro','otro') NOT NULL,
  `json_dinamico` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_dinamico`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `es_administrador` int(1) UNSIGNED DEFAULT 0,
  `saldo_actual` double(18,5) DEFAULT 0.00000,
  `block_user` int(11) NOT NULL DEFAULT 0,
  `cod_unico` varchar(255) NOT NULL DEFAULT 'MTIzNDU2',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `gender`, `active`, `es_administrador`, `saldo_actual`, `block_user`, `cod_unico`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(14, 'aserri1', 'aserri1@gmail.com', NULL, '$2y$10$o/CHDADtqN0/1zKrLPQCO.zY2yZqrxOQNCA/6tByCUfYiSokeUQLO', '63ae5823876da_IMG-20221015-WA0000.jpg', 'female', 1, 0, 0.00000, 0, 'Nzg3OA==', NULL, NULL, '2022-08-30 20:22:49', '2022-12-30 16:26:34'),
(15, 'aserri2', 'aserri2@gmail.com', NULL, '$2y$10$Sc9nQ9PKJoYnN0lyztN1rutHp17.pGDa6eRkWCEaHoplaQdW6g/J.', '631d15be9bcdd_WhatsApp Image 2022-08-15 at 11.59.23 AM.jpeg', 'male', 1, 0, 0.00000, 0, 'MTIzNDU2', NULL, NULL, '2022-08-30 20:24:01', '2022-09-10 17:35:28'),
(16, 'Winston', 'winston@gmail.com', NULL, '$2y$10$f89PnL4pSH54cKhgEAN3juAEjvb6s870LP0pO2WE9iNiORnmSFn0u', '63ae57973b7b6_IMG-20220905-WA0000.jpg', 'male', 1, 1, 0.00000, 0, 'MTIzNDU2', NULL, NULL, '2022-09-05 16:12:41', '2022-10-01 22:33:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_balances`
--

CREATE TABLE `user_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `saldo_anterior` double(18,3) NOT NULL,
  `premios_del_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `ventas_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `comisiones_dia` double(18,3) NOT NULL DEFAULT 0.000,
  `saldo_final` double(18,3) NOT NULL DEFAULT 0.000,
  `fecha_diaria` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_cabecera`
--

CREATE TABLE `venta_cabecera` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idsorteo` bigint(20) UNSIGNED NOT NULL,
  `idconfigsorteo` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estatus` enum('abierto','cerrado','calculado','finalizado') NOT NULL DEFAULT 'abierto',
  `cierra_antes` int(11) NOT NULL,
  `monto_venta` double(18,5) NOT NULL DEFAULT 0.00000,
  `numero_ganador` int(3) DEFAULT NULL,
  `adicional_ganador` varchar(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `id` bigint(30) UNSIGNED NOT NULL,
  `idventa_cabecera` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idcliente` bigint(20) UNSIGNED NOT NULL,
  `numero` int(3) UNSIGNED NOT NULL,
  `monto` double(18,5) NOT NULL,
  `reventado` int(11) NOT NULL DEFAULT 0,
  `monto_reventado` double(18,3) DEFAULT 0.000,
  `jugada_padre` bigint(20) UNSIGNED DEFAULT NULL,
  `estatus` enum('en proceso','apostada','calculada','ganadora') NOT NULL DEFAULT 'en proceso',
  `es_ganador` int(1) DEFAULT 0,
  `monto_ganador` double(18,5) DEFAULT 0.00000,
  `fue_pagado` int(11) NOT NULL DEFAULT 0,
  `impreso` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `config_sorteo`
--
ALTER TABLE `config_sorteo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parametros_sorteos`
--
ALTER TABLE `parametros_sorteos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `resultados_parametros`
--
ALTER TABLE `resultados_parametros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sorteos`
--
ALTER TABLE `sorteos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_balances`
--
ALTER TABLE `user_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta_cabecera`
--
ALTER TABLE `venta_cabecera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `config_sorteo`
--
ALTER TABLE `config_sorteo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `parametros_sorteos`
--
ALTER TABLE `parametros_sorteos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resultados_parametros`
--
ALTER TABLE `resultados_parametros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sorteos`
--
ALTER TABLE `sorteos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `user_balances`
--
ALTER TABLE `user_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_cabecera`
--
ALTER TABLE `venta_cabecera`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `id` bigint(30) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
