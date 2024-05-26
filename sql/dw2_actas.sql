-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2024 a las 22:34:22
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dw2_actas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas`
--

CREATE TABLE `actas` (
  `id` int(11) NOT NULL,
  `acta_codi` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `acta_fecha` date DEFAULT NULL,
  `acta_archivo` varchar(120) COLLATE latin1_spanish_ci DEFAULT NULL,
  `acta_recibido` date DEFAULT NULL,
  `acta_planilla` varchar(120) COLLATE latin1_spanish_ci DEFAULT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `mate_id` int(11) DEFAULT NULL,
  `opor_id` int(11) DEFAULT NULL,
  `usr_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `actas`
--

INSERT INTO `actas` (`id`, `acta_codi`, `created_date_time`, `acta_fecha`, `acta_archivo`, `acta_recibido`, `acta_planilla`, `updated_date_time`, `mate_id`, `opor_id`, `usr_id`) VALUES
(1, 'sw53p2', '2024-05-26 10:10:21.000000', '2024-05-27', 'sw53p_acta.pdf', '2024-06-05', 'sw53p_planilla.pdf', '2024-05-26 10:54:19.000000', 1, 2, 2),
(3, 'sw53x', '2024-05-26 10:39:27.000000', '2024-05-13', 'sw53x_acta.pdf', '2024-05-28', 'sw53x_planilla.pdf', NULL, 1, 5, 1),
(4, 'sw533', '2024-05-26 10:40:32.000000', '2024-05-20', 'sw533_acta.pdf', '2024-05-27', 'sw533_planilla.pdf', '2024-05-26 10:53:58.000000', 1, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `carre_sigla` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `carre_nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `facu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `carre_sigla`, `created_date_time`, `carre_nombre`, `updated_date_time`, `facu_id`) VALUES
(1, 'LASI', '2024-05-25 18:05:22.000000', 'Licenciatura en AnÃ¡lisis de Sistemas InformÃ¡ticos', NULL, 3),
(11, 'ARQ', '2024-05-25 18:30:33.000000', 'Arquitectura ', '2024-05-25 18:31:02.000000', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `doce_cumple` date DEFAULT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `doce_nombre` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `doce_apellido` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `doce_mail` varchar(80) COLLATE latin1_spanish_ci DEFAULT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `doce_cel` varchar(60) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `doce_cumple`, `created_date_time`, `doce_nombre`, `doce_apellido`, `doce_mail`, `updated_date_time`, `doce_cel`) VALUES
(1, '1980-07-30', '2024-05-25 17:51:32.000000', 'Osvaldo', 'Micniuk', 'osvaldo.micniuk@unae.edu.py', NULL, '+595986230264');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE `facultades` (
  `id` int(11) NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `facu_code` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `facu_name` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`id`, `created_date_time`, `updated_date_time`, `facu_code`, `facu_name`) VALUES
(3, '2024-05-25 17:33:47.000000', NULL, 'FACAT', 'Facultad de Ciencias Artes y TecnologÃ­as');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `mate_code` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `mate_name` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `mate_anho` int(11) NOT NULL,
  `carre_id` int(11) DEFAULT NULL,
  `doce_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `mate_code`, `created_date_time`, `mate_name`, `updated_date_time`, `mate_anho`, `carre_id`, `doce_id`) VALUES
(1, 'xz15', '2024-05-25 18:53:44.000000', 'DiseÃ±o Web 1', NULL, 2021, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oportunidades`
--

CREATE TABLE `oportunidades` (
  `id` int(11) NOT NULL,
  `opor_code` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `opor_name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `oportunidades`
--

INSERT INTO `oportunidades` (`id`, `opor_code`, `created_date_time`, `opor_name`, `updated_date_time`) VALUES
(1, 'Parcial', '2024-05-25 17:21:21.000000', 'EvaluaciÃ³n Parcial', NULL),
(2, 'Primera', '2024-05-25 17:21:38.000000', 'Primera Oportunidad', NULL),
(3, 'Segunda', '2024-05-25 17:21:51.000000', 'Segunda Oportunidad', NULL),
(4, 'Tercera', '2024-05-25 17:22:12.000000', 'Tercera Oportunidad', NULL),
(5, 'Extraord', '2024-05-25 17:22:56.000000', 'EvaluaciÃ³n Extraordinaria', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `rol_name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `created_date_time`, `rol_name`, `updated_date_time`) VALUES
(1, NULL, 'Administrador', NULL),
(2, NULL, 'Secretario', NULL),
(3, NULL, 'Vistas', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usr_roles`
--

CREATE TABLE `usr_roles` (
  `usr_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usr_roles`
--

INSERT INTO `usr_roles` (`usr_id`, `rol_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user_activo` bit(1) DEFAULT NULL,
  `created_date_time` datetime(6) DEFAULT NULL,
  `user_mail` varchar(120) COLLATE latin1_spanish_ci NOT NULL,
  `user_nombre` varchar(120) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(120) COLLATE latin1_spanish_ci NOT NULL,
  `updated_date_time` datetime(6) DEFAULT NULL,
  `username` varchar(120) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user_activo`, `created_date_time`, `user_mail`, `user_nombre`, `password`, `updated_date_time`, `username`) VALUES
(1, NULL, NULL, 'fatimagrecosolis77@gmail.com', 'Fatima Greco', '36164dcf8fd4febbe8625adf723e189bc647e938', NULL, 'fatigreco'),
(2, NULL, NULL, 'sonia.blade@gmail.com', 'Sonia Blade', 'soniabld', NULL, 'soniabld');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actas`
--
ALTER TABLE `actas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_9npla883q31ylj96wmd7d3hmb` (`acta_codi`) USING BTREE,
  ADD KEY `UK_ch4was050xtnfa97yk7imotib` (`opor_id`) USING BTREE,
  ADD KEY `UK_td5ko3m1bpebrfk5yo76otmh4` (`mate_id`) USING BTREE,
  ADD KEY `UK_ehscxkeo0i6hp2iwvfa6tyrhb` (`usr_id`) USING BTREE;

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK178mgetbmmtsj4xdvis369kk7` (`facu_id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_o0c9w2ubxdu2vk6h4hifavcnm` (`doce_apellido`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_ksp9bh692rep7k2snveped4bl` (`facu_code`),
  ADD UNIQUE KEY `UK_62q3vsg7509lff1jk9g8b605n` (`facu_name`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_tjsy8orpwaepn8vfdf8kr1xcp` (`mate_code`),
  ADD UNIQUE KEY `UK_61t0rktb860li7p1r58oosdy8` (`carre_id`),
  ADD UNIQUE KEY `UK_6brf8cxux5ew1tdegy06swxt8` (`doce_id`);

--
-- Indices de la tabla `oportunidades`
--
ALTER TABLE `oportunidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_ab93so0xb6tsdlcal883ryirl` (`opor_code`),
  ADD UNIQUE KEY `UK_jky8o9487rvp7hotooms0tscj` (`opor_name`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_cqi864cbljauxnpcypgwwvo59` (`rol_name`);

--
-- Indices de la tabla `usr_roles`
--
ALTER TABLE `usr_roles`
  ADD KEY `FK7tqk1oku12flmqxa1v4poreg5` (`rol_id`),
  ADD KEY `FKnftlpjjkd70mhbiv28ylkfejs` (`usr_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_rwnyyloq71vas5u8mq9borwrf` (`user_mail`),
  ADD UNIQUE KEY `UK_m2dvbwfge291euvmk6vkkocao` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actas`
--
ALTER TABLE `actas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `facultades`
--
ALTER TABLE `facultades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `oportunidades`
--
ALTER TABLE `oportunidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actas`
--
ALTER TABLE `actas`
  ADD CONSTRAINT `FK95iqgf3ncym1k4paa5s9tqajl` FOREIGN KEY (`mate_id`) REFERENCES `materias` (`id`),
  ADD CONSTRAINT `FKpmy1a3ixbakw1g4nqnfbc3vw9` FOREIGN KEY (`usr_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FKtgsvmlm9niqte2b2beyfsm0vl` FOREIGN KEY (`opor_id`) REFERENCES `oportunidades` (`id`);

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `FK178mgetbmmtsj4xdvis369kk7` FOREIGN KEY (`facu_id`) REFERENCES `facultades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `FK6k95qai1lv3j5j0nmnxk86ioc` FOREIGN KEY (`doce_id`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `FK91ih8qd23g7qdgkgws5hbqqoq` FOREIGN KEY (`carre_id`) REFERENCES `carreras` (`id`);

--
-- Filtros para la tabla `usr_roles`
--
ALTER TABLE `usr_roles`
  ADD CONSTRAINT `FK7tqk1oku12flmqxa1v4poreg5` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FKnftlpjjkd70mhbiv28ylkfejs` FOREIGN KEY (`usr_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
