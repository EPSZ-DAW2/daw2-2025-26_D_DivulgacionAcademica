-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `divulgacionacademica_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clienteempresa`
--

CREATE TABLE `clienteempresa` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `cif` varchar(20) DEFAULT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clienteempresa`
--

INSERT INTO `clienteempresa` (`id`, `razon_social`, `cif`, `usuarioId`) VALUES
(1, 'Tech Solutions S.L.', 'B99999991', 5),
(2, 'Consultora Global S.A.', 'A88888882', 6),
(3, 'Innova StartUp', 'B77777773', 7);

-- --------------------------------------------------------

--
-- Table structure for table `contratacion`
--

CREATE TABLE `contratacion` (
  `id` int(11) NOT NULL,
  `clienteId` int(11) NOT NULL,
  `servicioId` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contratacion`
--

INSERT INTO `contratacion` (`id`, `clienteId`, `servicioId`, `fecha`) VALUES
(1, 1, 2, '2023-09-01 10:00:00'),
(2, 1, 3, '2024-01-15 09:30:00'),
(3, 2, 4, '2024-02-01 11:00:00'),
(4, 3, 2, '2024-03-10 16:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `documento`
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
-- Dumping data for table `documento`
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
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `institucionId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id`, `titulo`, `fecha_inicio`, `institucionId`) VALUES
(1, 'Examen Parcial Álgebra', '2024-05-15 09:00:00', 1),
(2, 'Feria de Empleo UPM', '2024-06-20 10:00:00', 1),
(3, 'Webinar: React vs Vue', '2024-04-10 18:00:00', 2),
(4, 'Hackathon de Seguridad', '2024-11-05 09:00:00', 2),
(5, 'Open Day: English for Business', '2024-09-01 17:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `incidencia`
--

CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('abierta','cerrada') DEFAULT 'abierta',
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidencia`
--

INSERT INTO `incidencia` (`id`, `descripcion`, `estado`, `usuarioId`) VALUES
(1, 'No puedo restablecer mi contraseña', 'cerrada', 8),
(2, 'El PDF de React da error 404 al descargar', 'abierta', 9),
(3, 'Quiero factura del último curso contratado', 'abierta', 5),
(4, 'Error al subir documento nuevo', 'abierta', 2),
(5, 'La plataforma va lenta por las tardes', 'abierta', 10);

-- --------------------------------------------------------

--
-- Table structure for table `institucion`
--

CREATE TABLE `institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('universidad','academia') NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institucion`
--

INSERT INTO `institucion` (`id`, `nombre`, `tipo`, `ubicacion`, `contacto`) VALUES
(1, 'Universidad Politécnica de Madrid', 'universidad', 'Av. Complutense, 30, Madrid', 'secretaria@upm.es'),
(2, 'Academia CodeMasters', 'academia', 'Calle Pez 42, Barcelona', 'info@codemasters.com'),
(3, 'English Now School', 'academia', 'Gran Vía 12, Valencia', 'contact@englishnow.com');

-- --------------------------------------------------------

--
-- Table structure for table `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `parentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materia`
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
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `institucionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal`
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
-- Table structure for table `servicio`
--

CREATE TABLE `servicio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `institucionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicio`
--

INSERT INTO `servicio` (`id`, `nombre`, `precio`, `institucionId`) VALUES
(1, 'Máster en Ingeniería de Datos', 4500.00, 1),
(2, 'Bootcamp Full Stack Developer', 2900.00, 2),
(3, 'Auditoría de Seguridad Web', 1200.00, 2),
(4, 'Curso Inglés de Negocios (In-Company)', 800.00, 3),
(5, 'Pack Formación Alemán Técnico', 1500.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_identifier` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `user_id`, `user_identifier`, `action`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 18, 'juanrv2@mail.com', 'Logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:12'),
(2, 16, 'juan@mail.com', 'Login Success', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:24'),
(3, 16, 'juan@mail.com', 'Logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','gestor','empresa','alumno') DEFAULT 'alumno',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `username` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`, `username`) VALUES
(1, 'Super Admin', 'admin@portal.com', '1234', 'admin', '2026-01-03 11:21:26', 'admin@portal.com'),
(2, 'Gestor Politécnica', 'gestor@upm.es', '1234', 'gestor', '2026-01-03 11:21:26', 'gestor@upm.es'),
(3, 'Gestor CodeMasters', 'director@codemasters.com', '1234', 'gestor', '2026-01-03 11:21:26', 'director@codemasters.com'),
(4, 'Gestor EnglishNow', 'hello@englishnow.com', '1234', 'gestor', '2026-01-03 11:21:26', 'hello@englishnow.com'),
(5, 'Tech Solutions CEO', 'contacto@techsolutions.com', '1234', 'empresa', '2026-01-03 11:21:26', 'contacto@techsolutions.com'),
(6, 'Consultora Global', 'rrhh@consultoraglobal.com', '1234', 'empresa', '2026-01-03 11:21:26', 'rrhh@consultoraglobal.com'),
(7, 'StartUp Innova', 'admin@innova.io', '1234', 'empresa', '2026-01-03 11:21:26', 'admin@innova.io'),
(8, 'Carlos Pérez', 'carlos@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'carlos@mail.com'),
(9, 'María García', 'maria@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'maria@mail.com'),
(10, 'Lucía Méndez', 'lucia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'lucia@mail.com'),
(11, 'David Torres', 'david@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'david@mail.com'),
(12, 'Elena Nito', 'elena@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'elena@mail.com'),
(13, 'Sofía Rivas', 'sofia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'sofia@mail.com'),
(14, 'Jorge Bua', 'jorge@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'jorge@mail.com'),
(15, 'Ana Bot', 'ana@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'ana@mail.com'),
(16, 'Juan Riego Vila', 'juan@mail.com', '1234', 'alumno', '2026-01-08 10:33:50', 'juanrv'),
(17, 'Andrea Colorado Esteban', 'andreace@mail.com', '1234', '', '2026-01-08 13:01:31', 'andreace'),
(18, 'Juan Riego Vila', 'juanrv2@mail.com', '1234', '', '2026-01-08 13:40:35', 'juanrv2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clienteempresa`
--
ALTER TABLE `clienteempresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indexes for table `contratacion`
--
ALTER TABLE `contratacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clienteId` (`clienteId`),
  ADD KEY `servicioId` (`servicioId`);

--
-- Indexes for table `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiaId` (`materiaId`),
  ADD KEY `autorId` (`autorId`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indexes for table `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indexes for table `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentId` (`parentId`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indexes for table `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clienteempresa`
--
ALTER TABLE `clienteempresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contratacion`
--
ALTER TABLE `contratacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clienteempresa`
--
ALTER TABLE `clienteempresa`
  ADD CONSTRAINT `clienteempresa_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contratacion`
--
ALTER TABLE `contratacion`
  ADD CONSTRAINT `contratacion_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `clienteempresa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contratacion_ibfk_2` FOREIGN KEY (`servicioId`) REFERENCES `servicio` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`materiaId`) REFERENCES `materia` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`autorId`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `materia` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
