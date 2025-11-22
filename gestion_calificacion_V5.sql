-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2025 a las 21:26:24
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
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre`, `email`, `password`, `estado`) VALUES
(1, 'administrador', 'administrador@gmail.com', '$2a$12$Shb3Nkp9bYWSTWgYEk/zzeSrbAEIJ0WHume/HLjnuJJ63s18fnBZy', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `fichas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `aprendices`
--

INSERT INTO `aprendices` (`id`, `nombre`, `email`, `password`, `estado`, `fichas_id`) VALUES
(1, 'aprendiz', 'aprendiz@gmail.com', '$2a$12$hwI0hNJmfNHLPZYEBo3EiuDuewXpon0wP5zLfotiuAQH4f83jVTrm', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `calificacion` varchar(70) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_calificacion` datetime NOT NULL,
  `instructores_id` int(11) NOT NULL,
  `entregas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `fecha_subida` datetime NOT NULL,
  `estado` varchar(70) NOT NULL,
  `aprendices_id` int(11) NOT NULL,
  `trabajos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `area` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id`, `codigo`, `nombre`, `area`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 3064749, 'Analisis y desarrollo de software', 'Sistemas', '2024-10-15', '2026-07-15');

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
  `nombre` varchar(100) NOT NULL,
  `area` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `instructores`
--

INSERT INTO `instructores` (`id`, `nombre`, `area`, `email`, `password`, `estado`) VALUES
(1, 'instructor', 'Tecnologia', 'instructor@gmail.com', '$2a$12$Shb3Nkp9bYWSTWgYEk/zzeSrbAEIJ0WHume/HLjnuJJ63s18fnBZy', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

CREATE TABLE `trabajos` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_publicacion` datetime NOT NULL,
  `fecha_limite` date NOT NULL,
  `instructores_id` int(11) NOT NULL,
  `fichas_id` int(11) NOT NULL
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
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calificaciones_instructores1_idx` (`instructores_id`),
  ADD KEY `fk_calificaciones_entregas1_idx` (`entregas_id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entregas_aprendices1_idx` (`aprendices_id`),
  ADD KEY `fk_entregas_trabajos1_idx` (`trabajos_id`);

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
  ADD KEY `fk_trabajos_instructores1_idx` (`instructores_id`),
  ADD KEY `fk_trabajos_fichas1_idx` (`fichas_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fk_calificaciones_entregas1` FOREIGN KEY (`entregas_id`) REFERENCES `entregas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_calificaciones_instructores1` FOREIGN KEY (`instructores_id`) REFERENCES `instructores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `fk_entregas_aprendices1` FOREIGN KEY (`aprendices_id`) REFERENCES `aprendices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entregas_trabajos1` FOREIGN KEY (`trabajos_id`) REFERENCES `trabajos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_trabajos_fichas1` FOREIGN KEY (`fichas_id`) REFERENCES `fichas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_trabajos_instructores1` FOREIGN KEY (`instructores_id`) REFERENCES `instructores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
