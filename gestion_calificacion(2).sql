-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2025 a las 17:27:32
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
-- Base de datos: `gestion_calificacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `id` int(11) NOT NULL,
  `identificacion` varchar(150) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `fichas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `area` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas_has_instructores`
--

CREATE TABLE `fichas_has_instructores` (
  `fichas_id` int(11) NOT NULL,
  `instructores_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructores`
--

CREATE TABLE `instructores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `area` varchar(45) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

CREATE TABLE `trabajos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `archivo` varchar(45) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` varchar(70) DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `estadoCalificacion` varchar(45) DEFAULT NULL,
  `aprendices_id` int(11) NOT NULL,
  `instructores_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_aprendices_fichas1_idx` (`fichas_id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichas_has_instructores`
--
ALTER TABLE `fichas_has_instructores`
  ADD PRIMARY KEY (`fichas_id`,`instructores_id`),
  ADD KEY `fk_fichas_has_instructores_instructores1_idx` (`instructores_id`),
  ADD KEY `fk_fichas_has_instructores_fichas1_idx` (`fichas_id`);

--
-- Indices de la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trabajos_aprendices1_idx` (`aprendices_id`),
  ADD KEY `fk_trabajos_instructores1_idx` (`instructores_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD CONSTRAINT `fk_aprendices_fichas1` FOREIGN KEY (`fichas_id`) REFERENCES `fichas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fichas_has_instructores`
--
ALTER TABLE `fichas_has_instructores`
  ADD CONSTRAINT `fk_fichas_has_instructores_fichas1` FOREIGN KEY (`fichas_id`) REFERENCES `fichas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fichas_has_instructores_instructores1` FOREIGN KEY (`instructores_id`) REFERENCES `instructores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD CONSTRAINT `fk_trabajos_aprendices1` FOREIGN KEY (`aprendices_id`) REFERENCES `aprendices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_trabajos_instructores1` FOREIGN KEY (`instructores_id`) REFERENCES `instructores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
