-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2025 a las 04:02:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parque_acuatico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `usuario`, `password`) VALUES
(1, 'admin', '$2y$10$34h5dZZ2g1hMUvOSX2SL7OxstW2Y59KXjFY1td42y1C3UTo.Ggrdi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `codigo`, `fecha_registro`) VALUES
(1, '8KK8SA', '2025-03-26 17:16:42'),
(2, 'CSTUY4', '2025-03-26 17:23:16'),
(3, '1P2J1H', '2025-03-26 17:25:05'),
(4, 'ER4O5E', '2025-03-26 17:28:31'),
(5, 'E2JJ4S', '2025-03-26 17:30:48'),
(6, '27UJYZ', '2025-03-26 17:32:28'),
(7, 'OTOWG9', '2025-03-26 17:35:48'),
(8, '4NYXOP', '2025-03-26 17:36:19'),
(9, '3W2YAY', '2025-03-26 17:37:03'),
(10, 'GD47RP', '2025-03-26 17:39:02'),
(11, '1JN0VE', '2025-03-27 17:48:22'),
(12, 'MXLR0L', '2025-03-29 01:53:08'),
(13, 'CIB32K', '2025-03-29 01:54:12'),
(14, 'J1BUV3', '2025-03-29 01:56:21'),
(15, 'JYAFXU', '2025-03-29 01:56:52'),
(16, 'QT31PJ', '2025-03-29 01:57:55'),
(18, 'SLFJEQ', '2025-03-29 17:23:04'),
(19, '2YNM47', '2025-03-29 17:24:58'),
(20, 'HG4QSU', '2025-03-29 17:29:53'),
(21, '88DSIV', '2025-03-29 17:38:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_orden`
--

CREATE TABLE `detalles_orden` (
  `id_detalle` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `producto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_orden`
--

INSERT INTO `detalles_orden` (`id_detalle`, `id_orden`, `producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 'entradasAdulto', 1, 180.00, 180.00),
(2, 1, 'entradasNino', 1, 120.00, 120.00),
(3, 1, 'sillas', 3, 30.00, 90.00),
(4, 1, 'mesas', 1, 50.00, 50.00),
(5, 1, 'sombrillas', 1, 50.00, 50.00),
(6, 1, 'casaCampana4', 1, 150.00, 150.00),
(7, 2, 'entradasAdulto', 2, 180.00, 360.00),
(8, 2, 'sillas', 2, 30.00, 60.00),
(9, 2, 'mesas', 1, 50.00, 50.00),
(10, 2, 'sombrillas', 1, 50.00, 50.00),
(11, 2, 'cabaña4', 1, 2500.00, 2500.00),
(12, 3, 'entradasAdulto', 3, 180.00, 540.00),
(13, 3, 'entradasNino', 5, 120.00, 600.00),
(14, 3, 'sillas', 5, 30.00, 150.00),
(15, 3, 'mesas', 1, 50.00, 50.00),
(16, 3, 'sombrillas', 1, 50.00, 50.00),
(17, 3, 'cabaña6', 1, 3000.00, 3000.00),
(18, 4, 'entradasAdulto', 2, 180.00, 360.00),
(19, 4, 'casaCampanaEspacio', 1, 350.00, 350.00),
(20, 5, 'entradasAdulto', 2, 180.00, 360.00),
(21, 5, 'entradasNino', 1, 120.00, 120.00),
(22, 5, 'casaCampana4', 1, 150.00, 150.00),
(23, 6, 'entradasAdulto', 3, 180.00, 540.00),
(24, 6, 'casaCampanaEspacio', 1, 350.00, 350.00),
(25, 7, 'entradasNino', 2, 120.00, 240.00),
(26, 7, 'sillas', 2, 30.00, 60.00),
(27, 8, 'entradasAdulto', 2, 180.00, 360.00),
(28, 9, 'entradasAdulto', 1, 180.00, 180.00),
(29, 9, 'entradasNino', 1, 120.00, 120.00),
(30, 10, 'entradasAdulto', 1, 180.00, 180.00),
(31, 11, 'entradasAdulto', 1, 180.00, 180.00),
(32, 12, 'entradasAdulto', 2, 180.00, 360.00),
(33, 12, 'sillas', 2, 30.00, 60.00),
(34, 12, 'mesas', 1, 50.00, 50.00),
(35, 12, 'sombrillas', 1, 50.00, 50.00),
(36, 12, 'casaCampanaEspacio', 1, 350.00, 350.00),
(37, 13, 'entradasAdulto', 1, 180.00, 180.00),
(38, 13, 'entradasNino', 3, 120.00, 360.00),
(39, 13, 'casaCampana4', 1, 150.00, 150.00),
(40, 14, 'entradasAdulto', 1, 180.00, 180.00),
(41, 14, 'sillas', 1, 30.00, 30.00),
(42, 14, 'mesas', 1, 50.00, 50.00),
(43, 15, 'entradasAdulto', 1, 180.00, 180.00),
(44, 15, 'sillas', 1, 30.00, 30.00),
(45, 16, 'entradasAdulto', 3, 180.00, 540.00),
(46, 18, 'entradasAdulto', 2, 180.00, 360.00),
(47, 18, 'casaCampanaEspacio', 1, 350.00, 350.00),
(48, 19, 'entradasAdulto', 2, 180.00, 360.00),
(49, 19, 'entradasNino', 4, 120.00, 480.00),
(50, 19, 'cabaña4', 1, 2500.00, 2500.00),
(51, 20, 'entradasAdulto', 2, 180.00, 360.00),
(52, 20, 'entradasNino', 4, 120.00, 480.00),
(53, 20, 'sillas', 6, 30.00, 180.00),
(54, 20, 'mesas', 1, 50.00, 50.00),
(55, 20, 'sombrillas', 1, 50.00, 50.00),
(56, 20, 'casaCampana8', 1, 180.00, 180.00),
(57, 21, 'entradasAdulto', 5, 180.00, 900.00),
(58, 21, 'entradasNino', 8, 120.00, 960.00),
(59, 21, 'sillas', 14, 30.00, 420.00),
(60, 21, 'mesas', 2, 50.00, 100.00),
(61, 21, 'sombrillas', 3, 50.00, 150.00),
(62, 21, 'cabaña6', 2, 3000.00, 6000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id_orden` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id_orden`, `id_cliente`, `total`, `fecha`) VALUES
(1, 1, 640.00, '2025-03-26 17:16:42'),
(2, 2, 3020.00, '2025-03-26 17:23:16'),
(3, 3, 4390.00, '2025-03-26 17:25:05'),
(4, 4, 710.00, '2025-03-26 17:28:31'),
(5, 5, 630.00, '2025-03-26 17:30:48'),
(6, 6, 890.00, '2025-03-26 17:32:28'),
(7, 7, 300.00, '2025-03-26 17:35:48'),
(8, 8, 360.00, '2025-03-26 17:36:19'),
(9, 9, 300.00, '2025-03-26 17:37:03'),
(10, 10, 180.00, '2025-03-26 17:39:02'),
(11, 11, 180.00, '2025-03-27 17:48:22'),
(12, 12, 870.00, '2025-03-29 01:53:08'),
(13, 13, 690.00, '2025-03-29 01:54:12'),
(14, 14, 260.00, '2025-03-29 01:56:21'),
(15, 15, 210.00, '2025-03-29 01:56:52'),
(16, 16, 540.00, '2025-03-29 01:57:55'),
(18, 18, 710.00, '2025-03-29 17:23:04'),
(19, 19, 3340.00, '2025-03-29 17:24:58'),
(20, 20, 1300.00, '2025-03-29 17:29:53'),
(21, 21, 8530.00, '2025-03-29 17:38:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `detalles_orden`
--
ALTER TABLE `detalles_orden`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_orden` (`id_orden`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `detalles_orden`
--
ALTER TABLE `detalles_orden`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_orden`
--
ALTER TABLE `detalles_orden`
  ADD CONSTRAINT `detalles_orden_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
