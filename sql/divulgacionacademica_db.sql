SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
INSERT INTO `documento` (`titulo`, `archivo_url`, `tipo_acceso`, `materiaId`, `autorId`, `institucionId`) VALUES
('Cálculo Integral: Guía de Supervivencia', 'calculo_int.pdf', 'publico', 9, 2, 1),
('Algoritmos y Estructuras de Datos en JS', 'algoritmos_js.pdf', 'publico', 4, 4, 2),
('Seguridad en Redes WiFi', 'wifi_security.pdf', 'privado', 5, 3, 2),
('Diccionario Técnico Alemán-Español', 'diccionario_de.pdf', 'publico', 8, 6, 3),
('Normalización de Bases de Datos (1NF a 5NF)', 'sql_norm.pdf', 'privado', 6, 3, 2),
('Introducción a la Mecánica Cuántica', 'cuantica_intro.pdf', 'publico', 1, 1, 1),
('CSS Grid y Flexbox: Masterclass', 'css_master.pdf', 'publico', 11, 4, 2),
('React Query y Gestión de Estado', 'react_state.pdf', 'privado', 11, 4, 2),
('Configuración de Firewalls Linux', 'linux_fw.pdf', 'privado', 5, 3, 2);

-- coleccion
INSERT INTO `coleccion` (`id`, `titulo`, `descripcion`, `usuarioId`, `descargas`, `fecha_actualizacion`) VALUES
(1, 'Matemáticas para Ingeniería', 'Materiales de cálculo y álgebra.', 9, 2350, '2026-01-05 10:00:00'),
(2, 'Programación Web Full Stack', 'HTML, CSS y JS.', 8, 1890, '2026-01-01 12:30:00'),
(4, 'Seguridad Informática Avanzada', 'Hacking ético y auditoría.', 2, 3100, '2026-01-07 14:00:00'),
(6, 'Bases de Datos con SQL', 'Diseño y optimización SQL.', 12, 1200, '2026-01-02 11:45:00');

-- coleccion_documento
INSERT INTO `coleccion_documento` (`coleccionId`, `documentoId`) VALUES
(1, 20), -- Matemáticas -> Cálculo
(2, 21), -- Web -> Algoritmos
(4, 22), -- Seguridad -> WiFi
(5, 23), -- Alemán -> Diccionario
(6, 24), -- SQL -> Normalización
(2, 26), -- Web -> CSS Grid
(2, 27), -- Web -> React Query
(4, 28); -- Seguridad -> Linux FW

-- usuario_coleccion
INSERT INTO `usuario_coleccion` (`usuarioId`, `coleccionId`, `fecha_union`) VALUES
(9, 2, '2026-01-08 10:00:00'),
(8, 1, '2026-01-07 15:30:00'),
(16, 4, '2026-01-09 09:15:00'),
(16, 6, '2026-01-09 09:20:00');

COMMIT;