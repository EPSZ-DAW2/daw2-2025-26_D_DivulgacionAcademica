SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
DROP DATABASE IF EXISTS divulgacionacademica_db;
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS divulgacionacademica_db;
USE divulgacionacademica_db;

-- 1. TABLA: usuario (Referenciada por casi todas)
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','gestor','empresa','alumno') DEFAULT 'alumno',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `username` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=19;

-- 2. TABLA: institucion
CREATE TABLE `institucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('universidad','academia') NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=4;

-- 3. TABLA: materia
CREATE TABLE `materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `materia` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=13;

-- 4. TABLA: personal
CREATE TABLE `personal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `institucionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=10;

-- 5. TABLA: servicio
CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `institucionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=6;

-- 6. TABLA: clienteempresa
CREATE TABLE `clienteempresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(150) NOT NULL,
  `cif` varchar(20) DEFAULT NULL,
  `usuarioId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `clienteempresa_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=4;

-- 7. TABLA: documento
CREATE TABLE `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `archivo_url` varchar(255) NOT NULL,
  `tipo_acceso` enum('publico','privado') DEFAULT 'publico',
  `materiaId` int(11) DEFAULT NULL,
  `autorId` int(11) DEFAULT NULL,
  `institucionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`materiaId`) REFERENCES `materia` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`autorId`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=20;

-- 8. TABLA: coleccion
CREATE TABLE `coleccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `usuarioId` int(11) NOT NULL,
  `descargas` int(11) DEFAULT 0,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_coleccion_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=7;

-- 9. TABLA: coleccion_documento (Relación N:M)
CREATE TABLE `coleccion_documento` (
  `coleccionId` int(11) NOT NULL,
  `documentoId` int(11) NOT NULL,
  PRIMARY KEY (`coleccionId`, `documentoId`),
  CONSTRAINT `fk_cd_coleccion` FOREIGN KEY (`coleccionId`) REFERENCES `coleccion` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cd_documento` FOREIGN KEY (`documentoId`) REFERENCES `documento` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. TABLA: usuario_coleccion (Relación N:M)
CREATE TABLE `usuario_coleccion` (
  `usuarioId` int(11) NOT NULL,
  `coleccionId` int(11) NOT NULL,
  `fecha_union` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`usuarioId`, `coleccionId`),
  CONSTRAINT `fk_uc_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_uc_coleccion` FOREIGN KEY (`coleccionId`) REFERENCES `coleccion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 11. TABLA: contratacion
CREATE TABLE `contratacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clienteId` int(11) NOT NULL,
  `servicioId` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `contratacion_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `clienteempresa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contratacion_ibfk_2` FOREIGN KEY (`servicioId`) REFERENCES `servicio` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=5;

-- 12. TABLA: evento
CREATE TABLE `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `institucionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=6;

-- 13. TABLA: incidencia
CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `estado` enum('abierta','cerrada') DEFAULT 'abierta',
  `usuarioId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=6;

-- 14. TABLA: user_log
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_identifier` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=4;

-- --------------------------------------------------------
-- INSERCIÓN DE DATOS
-- --------------------------------------------------------

-- usuario
INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`, `username`) VALUES
(1, 'Super Admin', 'admin@portal.com', '1234', 'admin', '2026-01-03 11:21:26', 'admin@portal.com'),
(2, 'Gestor Politécnica', 'gestor@upm.es', '1234', 'gestor', '2026-01-03 11:21:26', 'gestor@upm.es'),
(3, 'Gestor CodeMasters', 'director@codemasters.com', '1234', 'gestor', '2026-01-03 11:21:26', 'director@codemasters.com'),
(4, 'Gestor EnglishNow', 'hello@englishnow.com', '1234', 'gestor', '2026-01-03 11:21:26', 'hello@englishnow.com'),
(8, 'Carlos Pérez', 'carlos@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'carlos@mail.com'),
(9, 'María García', 'maria@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'maria@mail.com'),
(10, 'Lucía Méndez', 'lucia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'lucia@mail.com'),
(11, 'David Torres', 'david@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'david@mail.com'),
(12, 'Elena Nito', 'elena@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'elena@mail.com'),
(16, 'Juan Riego Vila', 'juan@mail.com', '1234', 'alumno', '2026-01-08 10:33:50', 'juanrv');

-- institucion
INSERT INTO `institucion` (`id`, `nombre`, `tipo`, `ubicacion`, `contacto`) VALUES
(1, 'Universidad Politécnica de Madrid', 'universidad', 'Av. Complutense, 30, Madrid', 'secretaria@upm.es'),
(2, 'Academia CodeMasters', 'academia', 'Calle Pez 42, Barcelona', 'info@codemasters.com'),
(3, 'English Now School', 'academia', 'Gran Vía 12, Valencia', 'contact@englishnow.com');

-- materia
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
(11, 'Frontend React', 4),
(12, 'Backend PHP', 4);

-- personal
INSERT INTO `personal` (`id`, `nombre`, `apellidos`, `institucionId`) VALUES
(1, 'Dr. Roberto', 'Méndez', 1),
(2, 'Dra. Laura', 'Física', 1),
(3, 'Javier', 'Hacker', 2),
(4, 'Sara', 'Coder', 2),
(5, 'John', 'Smith', 3),
(6, 'Frau', 'Müller', 3);

-- documento
INSERT INTO `documento` (`id`, `titulo`, `archivo_url`, `tipo_acceso`, `materiaId`, `autorId`, `institucionId`) VALUES
(1, 'Plan de Estudios 2025', 'plan2025.pdf', 'publico', 1, 1, 1),
(2, 'Tesis Doctoral: IA Generativa', 'tesis_ia.pdf', 'publico', 1, 1, 1),
(3, 'Ejercicios de Álgebra Lineal', 'algebra_ej.pdf', 'privado', 9, 2, 1),
(4, 'Guía Definitiva de React Hooks', 'react_guide.pdf', 'publico', 11, 4, 2),
(5, 'Manual de Hacking Ético', 'hacking_v1.pdf', 'privado', 5, 3, 2),
(6, 'Cheat Sheet PHP 8.2', 'php_resumen.pdf', 'publico', 12, 4, 2),
(7, 'Laboratorio SQL Avanzado', 'sql_lab.pdf', 'privado', 6, 3, 2),
(8, 'Phrasal Verbs List', 'phrasal_verbs.pdf', 'publico', 7, 5, 3),
(9, 'German Grammar B1', 'deutsch_b1.pdf', 'privado', 8, 6, 3),
(10, 'Cálculo Diferencial Avanzado', 'calculo_av.pdf', 'publico', 9, 2, 1),
(11, 'Redes de Computadoras', 'redes_comp.pdf', 'privado', 5, 3, 2),
(12, 'Introducción a Node.js', 'nodejs_intro.pdf', 'publico', 12, 4, 2),
(13, 'Seguridad en la Nube', 'cloud_sec.pdf', 'privado', 5, 3, 2),
(14, 'JavaScript ES6+ Resumen', 'js_es6.pdf', 'publico', 11, 4, 2),
(15, 'Modelado de Datos NoSQL', 'nosql_model.pdf', 'privado', 6, 3, 2),
(16, 'Inglés para Negocios', 'business_eng.pdf', 'publico', 7, 5, 3),
(17, 'Física Clásica: Cinemática', 'fisica_cin.pdf', 'publico', 1, 1, 1),
(18, 'Despliegue con Docker', 'docker_deploy.pdf', 'privado', 12, 4, 2),
(19, 'Principios de UI/UX', 'ui_ux_basics.pdf', 'publico', 4, 4, 2),
(20, 'Cálculo Integral: Guía Práctica', 'calculo_practica.pdf', 'publico', 9, 2, 1),
(21, 'Fundamentos de Redes Neuronales', 'redes_neuronales.pdf', 'publico', 1, 1, 1),
(22, 'Seguridad en Aplicaciones Móviles', 'mobile_sec.pdf', 'privado', 5, 3, 2),
(23, 'Patrones de Diseño en JS', 'js_patterns.pdf', 'publico', 11, 4, 2),
(24, 'Optimización de Queries MySQL', 'mysql_opt.pdf', 'privado', 6, 3, 2),
(25, 'Gramática Alemana Ingenieros', 'aleman_ing.pdf', 'publico', 8, 6, 3),
(26, 'Docker y Kubernetes Pro', 'k8s_pro.pdf', 'privado', 12, 4, 2);

-- coleccion
INSERT INTO `coleccion` (`id`, `titulo`, `descripcion`, `usuarioId`, `descargas`) VALUES
(1, 'Matemáticas para Ingeniería', 'Recursos de cálculo y álgebra lineal.', 9, 120),
(2, 'Desarrollo Frontend Moderno', 'React, JS y diseño UI/UX.', 8, 450),
(3, 'Ciberseguridad y Redes', 'Hacking ético y seguridad cloud.', 2, 320),
(4, 'Backend con PHP y Node', 'Servidores, Docker y APIs.', 3, 210),
(5, 'Base de Datos Relacionales', 'SQL avanzado y optimización.', 12, 180),
(6, 'Idiomas para Profesionales', 'Alemán e inglés técnico.', 11, 95),
(7, 'Inteligencia Artificial', 'Redes neuronales y fundamentos de IA.', 1, 560),
(8, 'Sistemas Operativos', 'Linux y gestión de servidores.', 2, 140),
(9, 'Física y Ciencias', 'Cinemática y tesis doctorales.', 10, 80),
(10, 'Herramientas de Devops', 'Contenedores y automatización.', 4, 275);

-- coleccion_documento
INSERT INTO `coleccion_documento` (`coleccionId`, `documentoId`) VALUES
-- Colección 1 (Matemáticas): Docs 3, 10, 20
(1, 3), (1, 10), (1, 20),
-- Colección 2 (Frontend): Docs 4, 14, 19, 23
(2, 4), (2, 14), (2, 19), (2, 23),
-- Colección 3 (Ciberseguridad): Docs 5, 11, 13, 22
(3, 5), (3, 11), (3, 13), (3, 22),
-- Colección 4 (Backend): Docs 6, 12, 18
(4, 6), (4, 12), (4, 18),
-- Colección 5 (Bases de Datos): Docs 7, 15, 24
(5, 7), (5, 15), (5, 24),
-- Colección 6 (Idiomas): Docs 8, 9, 16, 25
(6, 8), (6, 9), (6, 16), (6, 25),
-- Colección 7 (IA): Docs 2, 21
(7, 2), (7, 21),
-- Colección 8 (Sistemas): Docs 18, 26
(8, 18), (8, 26),
-- Colección 9 (Física): Docs 1, 17
(9, 1), (9, 17),
-- Colección 10 (Devops): Docs 18, 26
(10, 18), (10, 26);

-- usuario_coleccion
INSERT INTO `usuario_coleccion` (`usuarioId`, `coleccionId`, `fecha_union`) VALUES
-- Carlos Pérez (ID 8) se interesa por el desarrollo y sistemas
(8, 2, '2026-01-05 09:00:00'), -- Frontend
(8, 4, '2026-01-05 10:30:00'), -- Backend
(8, 8, '2026-01-06 11:00:00'), -- Sistemas Operativos

-- María García (ID 9) se enfoca en IA y Matemáticas
(9, 1, '2026-01-04 15:20:00'), -- Matemáticas
(9, 7, '2026-01-07 12:00:00'), -- IA
(9, 9, '2026-01-08 09:45:00'), -- Física

-- Lucía Méndez (ID 10) estudia Ciberseguridad e Idiomas
(10, 3, '2026-01-02 14:00:00'), -- Ciberseguridad
(10, 6, '2026-01-03 16:30:00'), -- Idiomas

-- David Torres (ID 11) se especializa en Infraestructura
(11, 10, '2026-01-08 10:00:00'), -- Devops
(11, 8, '2026-01-08 11:15:00'),  -- Sistemas Operativos
(11, 3, '2026-01-09 08:30:00'),  -- Ciberseguridad

-- Elena Nito (ID 12) centrada en Datos
(12, 5, '2026-01-07 13:45:00'), -- Bases de Datos
(12, 7, '2026-01-08 17:20:00'), -- IA

-- Juan Riego Vila (ID 16) tiene un perfil variado
(16, 1, '2026-01-09 10:00:00'), -- Matemáticas
(16, 2, '2026-01-09 10:05:00'), -- Frontend
(16, 5, '2026-01-09 10:10:00'), -- Bases de Datos
(16, 10, '2026-01-09 10:15:00');-- Devops


COMMIT;