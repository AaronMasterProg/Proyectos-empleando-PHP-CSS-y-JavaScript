-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2024 a las 20:40:48
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_archivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `fecha_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `elimina` datetime DEFAULT NULL,
  `id_carpeta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `nombre`, `tipo`, `fecha_create`, `estado`, `elimina`, `id_carpeta`, `id_usuario`) VALUES
(1, 'INMASIC- HOJA MEMBRETADA (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '2024-09-30 20:58:09', 1, NULL, 2, 1),
(3, 'anteproyecto.pptx', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', '2024-10-10 17:23:53', 0, '2024-11-10 12:23:53', 1, 2),
(4, '6.-IMSS.pdf', 'application/pdf', '2024-10-18 19:42:44', 1, NULL, 5, 2),
(5, 'ANEXO 10.pdf', 'application/pdf', '2024-10-24 17:08:19', 1, NULL, 4, 2),
(6, '7.-RIESGO DE TRABAJO.pdf', 'application/pdf', '2024-10-24 17:01:34', 0, '2024-11-24 12:01:34', 1, 2),
(7, 'CEDULAS_D.R.O. (1).xls', 'application/vnd.ms-excel', '2024-10-18 19:36:07', 0, '2024-11-18 14:36:07', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carpetas`
--

INSERT INTO `carpetas` (`id`, `nombre`, `fecha_create`, `estado`, `id_usuario`) VALUES
(1, 'default', '2024-09-27 19:23:13', 1, 1),
(2, 'blog', '2024-09-27 19:23:42', 1, 1),
(3, 'prueba 1', '2024-10-03 18:22:37', 1, 2),
(4, 'manual reporte fotografico', '2024-10-10 17:22:59', 1, 2),
(5, 'manual cotizaciones', '2024-10-10 17:23:28', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_archivos`
--

CREATE TABLE `detalle_archivos` (
  `id` int(11) NOT NULL,
  `fecha_add` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `correo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `elimina` datetime DEFAULT NULL,
  `id_archivo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_archivos`
--

INSERT INTO `detalle_archivos` (`id`, `fecha_add`, `correo`, `estado`, `elimina`, `id_archivo`, `id_usuario`) VALUES
(1, '2024-10-10 18:48:54', 'roseygabriela21@gmail.com', 1, NULL, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `perfil`, `clave`, `token`, `fecha`, `estado`, `rol`) VALUES
(1, 'Gabriela', 'Rosey', 'roseygabriela21@gmail.com', '5571988727', 'Norte 70 6121', NULL, '$2y$10$bKv9U3iEV5NYSmw.S0CjPO3poRIDt0gVzBZ8eGghjA07Dz5cxA12C', NULL, '2024-10-03 17:27:18', 1, 0),
(2, 'Paola', 'Paz', 'diana.villapaz@gmail.com', '45342521545', 'Torreon 31', NULL, '$2y$10$0hfBrfIt5pTMAwe8Tx2xfekC6yuIkRvFXd273sJYtMRcw3uergmC.', NULL, '2024-10-16 18:07:30', 1, 1),
(3, 'Marcos', 'Martinez', 'marcos@gmail.com', '453421564', 'valle de Aragon 68 ', NULL, '$2y$10$FNMVbjNgMofpO6tAkkinZ.TsQ5wTfzkQC5JaRnC99/tktERq3wSpS', NULL, '2024-10-10 18:02:24', 1, 2),
(4, 'Aileen', 'Rosey', 'ailen12@gmail.com', '53653156', 'Periferico sur 57', NULL, '$2y$10$T98c6BUOHpG82osOwH7vG.xan0k9LsdIkiCcpRg10USG4r7yhODJa', NULL, '2024-10-10 18:01:27', 1, 2),
(5, 'Mario', 'Elizalde', 'mareli@gmail.com', '536535621', 'zacatecas 105 ', NULL, '$2y$10$MAnV7luuWvnD55oiDDf0Oe2zC1zg2E9QHhMbi1sdZZRz/CLyB0C/6', NULL, '2024-10-10 18:00:45', 1, 2),
(6, 'Luis', 'Hernandez', 'ingeluis@gmail.com', '565554561', 'hjfgjh', NULL, '$2y$10$3./D6APKa2EsCOsBgWkxYuNQNJbwPcNiU5xrweJYYwts7ZULvLwoO', NULL, '2024-08-28 19:43:28', 0, 1),
(7, 'Rosa', 'modificado', 'ros@gmail.com', '545879', 'Merida 100', NULL, '$2y$10$hNwd8KWF.JGstKsSNgai9e.yrCK9TmYeKt1PJK//wIoCtYGJbBeAy', NULL, '2024-10-10 18:01:37', 1, 2),
(8, 'Enrique', 'galan', 'quique@gmail.com', '557896412', 'en mi corazon', NULL, '$2y$10$TJpjIlIEFyjePDghnWtOX.gdEDham/qpx8aSTMK2InEl975bzYGS2', NULL, '2024-08-28 19:45:50', 0, 1),
(9, 'nombre', 'modificado', 'roseygabriela31@gmail.com', '5254254', 'gfjhfghnft', NULL, '$2y$10$rTY8qmIg76ianUcQd0EuvOq0QCuVyPa19Z2N3oPeJhzM53jDGvgJW', NULL, '2024-09-02 19:55:06', 0, 1),
(12, 'Luis', 'Hernandez', 'ingeluis@gmail.com', '554897621', 'inmasicedificio', NULL, '$2y$10$DZlpnAt75e4x9YJW30NFpOJTyPTy4YB.NiC5H51Bu/sy2MlT9PGPe', NULL, '2024-09-02 19:56:52', 1, 1),
(13, 'gbg', 'bgb', 'gbg@gmail.com', '5554125545', 'bgbgb', NULL, '$2y$10$R12un9AIZA2aOza4hM5EsOmLP0MKU/Nwg7vH4ntDApcJ4GagUPa72', NULL, '2024-10-24 16:56:07', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carpeta` (`id_carpeta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_archivo` (`id_archivo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`id_carpeta`) REFERENCES `carpetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `archivos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD CONSTRAINT `carpetas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  ADD CONSTRAINT `detalle_archivos_ibfk_1` FOREIGN KEY (`id_archivo`) REFERENCES `archivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_archivos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
