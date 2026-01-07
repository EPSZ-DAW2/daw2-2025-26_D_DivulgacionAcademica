-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2026 a las 13:37:07
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
-- Base de datos: `gestion_academica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clienteempresa`
--

CREATE TABLE `clienteempresa` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `cif` varchar(20) DEFAULT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clienteempresa`
--

INSERT INTO `clienteempresa` (`id`, `razon_social`, `cif`, `usuarioId`) VALUES
(1, 'Tech Solutions S.L.', 'B99999991', 5),
(2, 'Consultora Global S.A.', 'A88888882', 6),
(3, 'Innova StartUp', 'B77777773', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratacion`
--

CREATE TABLE `contratacion` (
  `id` int(11) NOT NULL,
  `clienteId` int(11) NOT NULL,
  `servicioId` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contratacion`
--

INSERT INTO `contratacion` (`id`, `clienteId`, `servicioId`, `fecha`) VALUES
(1, 1, 2, '2023-09-01 10:00:00'),
(2, 1, 3, '2024-01-15 09:30:00'),
(3, 2, 4, '2024-02-01 11:00:00'),
(4, 3, 2, '2024-03-10 16:45:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `archivo_url` varchar(255) NOT NULL,
  `tipo_acceso` enum('publico','privado') DEFAULT 'publico',
  `materiaId` int(11) DEFAULT NULL,
  `autorId` int(11) DEFAULT NULL,
  `institucionId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id`, `titulo`, `archivo_url`, `tipo_acceso`, `materiaId`, `autorId`, `institucionId`) VALUES
(1, 'Plan de Estudios 2025', 'plan2025.pdf', 'publico', 1, 1, 1),
(2, 'Tesis Doctoral: IA Generativa', 'tesis_ia.pdf', 'publico', 1, 1, 1),
(3, 'Ejercicios de Álgebra Lineal', 'algebra_ej.pdf', 'privado', 9, 2, 1),
(4, 'Guía Definitiva de React Hooks', 'react_guide.pdf', 'publico', 11, 4, 2),
(5, 'Manual de Hacking Ético', 'hacking_v1.pdf', 'privado', 5, 3, 2),
(6, 'Cheat Sheet PHP 8.2', 'php_resumen.pdf', 'publico', 12, 4, 2),
(7, 'Laboratorio SQL Avanzado', 'sql_lab.pdf', 'privado', 6, 3, 2),
(8, 'Phrasal Verbs List', 'phrasal_verbs.pdf', 'publico', 7, 5, 3),
(9, 'German Grammar B1', 'deutsch_b1.pdf', 'privado', 8, 6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `institucionId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `titulo`, `fecha_inicio`, `institucionId`) VALUES
(1, 'Examen Parcial Álgebra', '2024-05-15 09:00:00', 1),
(2, 'Feria de Empleo UPM', '2024-06-20 10:00:00', 1),
(3, 'Webinar: React vs Vue', '2024-04-10 18:00:00', 2),
(4, 'Hackathon de Seguridad', '2024-11-05 09:00:00', 2),
(5, 'Open Day: English for Business', '2024-09-01 17:00:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('abierta','cerrada') DEFAULT 'abierta',
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id`, `descripcion`, `estado`, `usuarioId`) VALUES
(1, 'No puedo restablecer mi contraseña', 'cerrada', 8),
(2, 'El PDF de React da error 404 al descargar', 'abierta', 9),
(3, 'Quiero factura del último curso contratado', 'abierta', 5),
(4, 'Error al subir documento nuevo', 'abierta', 2),
(5, 'La plataforma va lenta por las tardes', 'abierta', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('universidad','academia') NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `institucion`
--

INSERT INTO `institucion` (`id`, `nombre`, `tipo`, `ubicacion`, `contacto`) VALUES
(1, 'Universidad Politécnica de Madrid', 'universidad', 'Av. Complutense, 30, Madrid', 'secretaria@upm.es'),
(2, 'Academia CodeMasters', 'academia', 'Calle Pez 42, Barcelona', 'info@codemasters.com'),
(3, 'English Now School', 'academia', 'Gran Vía 12, Valencia', 'contact@englishnow.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `parentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id`, `nombre`, `parentId`) VALUES
(1, 'Ciencias de la Computación', NULL),
(2, 'Idiomas', NULL),
(3, 'Matemáticas', NULL),
(4, 'Desarrollo Web', 1),
(5, 'Ciberseguridad', 1),
(6, 'Bases de Datos', 1),
(7, 'Inglés', 2),
(8, 'Alemán', 2),
(9, 'Álgebra', 3),
(10, 'Estadística', 3),
(11, 'Frontend React', 4),
(12, 'Backend PHP', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `institucionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `nombre`, `apellidos`, `institucionId`) VALUES
(1, 'Dr. Roberto', 'Méndez', 1),
(2, 'Dra. Laura', 'Física', 1),
(3, 'Javier', 'Hacker', 2),
(4, 'Sara', 'Coder', 2),
(5, 'John', 'Smith', 3),
(6, 'Frau', 'Müller', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `institucionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id`, `nombre`, `precio`, `institucionId`) VALUES
(1, 'Máster en Ingeniería de Datos', 4500.00, 1),
(2, 'Bootcamp Full Stack Developer', 2900.00, 2),
(3, 'Auditoría de Seguridad Web', 1200.00, 2),
(4, 'Curso Inglés de Negocios (In-Company)', 800.00, 3),
(5, 'Pack Formación Alemán Técnico', 1500.00, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','gestor','empresa','alumno') DEFAULT 'alumno',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Super Admin', 'admin@portal.com', '1234', 'admin', '2026-01-03 11:21:26'),
(2, 'Gestor Politécnica', 'gestor@upm.es', '1234', 'gestor', '2026-01-03 11:21:26'),
(3, 'Gestor CodeMasters', 'director@codemasters.com', '1234', 'gestor', '2026-01-03 11:21:26'),
(4, 'Gestor EnglishNow', 'hello@englishnow.com', '1234', 'gestor', '2026-01-03 11:21:26'),
(5, 'Tech Solutions CEO', 'contacto@techsolutions.com', '1234', 'empresa', '2026-01-03 11:21:26'),
(6, 'Consultora Global', 'rrhh@consultoraglobal.com', '1234', 'empresa', '2026-01-03 11:21:26'),
(7, 'StartUp Innova', 'admin@innova.io', '1234', 'empresa', '2026-01-03 11:21:26'),
(8, 'Carlos Pérez', 'carlos@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(9, 'María García', 'maria@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(10, 'Lucía Méndez', 'lucia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(11, 'David Torres', 'david@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(12, 'Elena Nito', 'elena@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(13, 'Sofía Rivas', 'sofia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(14, 'Jorge Bua', 'jorge@mail.com', '1234', 'alumno', '2026-01-03 11:21:26'),
(15, 'Ana Bot', 'ana@mail.com', '1234', 'alumno', '2026-01-03 11:21:26');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clienteempresa`
--
ALTER TABLE `clienteempresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `contratacion`
--
ALTER TABLE `contratacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clienteId` (`clienteId`),
  ADD KEY `servicioId` (`servicioId`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiaId` (`materiaId`),
  ADD KEY `autorId` (`autorId`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentId` (`parentId`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clienteempresa`
--
ALTER TABLE `clienteempresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contratacion`
--
ALTER TABLE `contratacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clienteempresa`
--
ALTER TABLE `clienteempresa`
  ADD CONSTRAINT `clienteempresa_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contratacion`
--
ALTER TABLE `contratacion`
  ADD CONSTRAINT `contratacion_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `clienteempresa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contratacion_ibfk_2` FOREIGN KEY (`servicioId`) REFERENCES `servicio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`materiaId`) REFERENCES `materia` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`autorId`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `materia` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
