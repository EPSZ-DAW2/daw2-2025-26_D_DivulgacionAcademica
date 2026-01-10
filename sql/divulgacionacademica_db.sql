-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 20:25:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS divulgacionacademica_db;
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS divulgacionacademica_db;
USE divulgacionacademica_db;

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
(3, 'Innova StartUp', 'B77777773', 7),
(4, 'TechSoft Development', 'B12345678', 21),
(5, 'Construcciones Civiles Norte', 'A98765432', 22),
(6, 'Estudio de Diseño Marta', 'B11223344', 25),
(7, 'Hospital General Universitario', 'Q2812345G', 26),
(8, 'Editorial El Saber S.L.', 'B55443322', 27);

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
(4, 3, 2, '2024-03-10 16:45:00'),
(5, 4, 8, '2026-01-10 10:00:00'),
(6, 6, 7, '2026-01-12 11:30:00'),
(7, 1, 9, '2026-01-15 09:00:00'),
(8, 2, 1, '2025-11-15 09:00:00'),
(9, 3, 8, '2025-12-01 10:30:00'),
(10, 5, 5, '2025-12-10 16:00:00'),
(11, 1, 9, '2026-01-02 08:45:00'),
(12, 4, 2, '2026-01-05 11:15:00'),
(13, 6, 6, '2026-01-08 14:20:00'),
(14, 2, 3, '2026-01-09 09:00:00'),
(15, 7, 6, '2026-01-05 10:00:00'),
(16, 8, 4, '2026-01-07 12:30:00');

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
(4, 'Guía Definitiva de React Hooks', 'react_guide.pdf', 'publico', 4, 4, 2),
(5, 'Manual de Hacking Ético', 'hacking_v1.pdf', 'privado', 5, 3, 2),
(6, 'Cheat Sheet PHP 8.2', 'php_resumen.pdf', 'publico', 4, 4, 2),
(7, 'Laboratorio SQL Avanzado', 'sql_lab.pdf', 'privado', 6, 3, 2),
(8, 'Phrasal Verbs List', 'phrasal_verbs.pdf', 'publico', 7, 5, 3),
(9, 'German Grammar B1', 'deutsch_b1.pdf', 'privado', 8, 6, 3),
(20, 'Introducción a la Edición Genética CRISPR', 'crispr_intro.pdf', 'publico', 16, 10, 4),
(21, 'Historia del Renacimiento Italiano', 'renacimiento.pdf', 'privado', 17, 11, 5),
(22, 'Redes Neuronales Convolucionales', 'cnn_guide.pdf', 'privado', 19, 12, 6),
(23, 'Principios de Composición Visual', 'composicion.pdf', 'publico', 18, 11, 5),
(24, 'Atlas Celular 2026', 'atlas_celular.pdf', 'privado', 15, 10, 4),
(35, 'Leyes de Newton: Resumen y Ejercicios', 'newton_resumen.pdf', 'publico', 28, 14, 1),
(36, 'Formulario de Física para Selectividad', 'formulario_fisica.pdf', 'publico', 21, 14, 1),
(37, 'Tabla de Valencias para Imprimir', 'valencias.pdf', 'publico', 31, 15, 1),
(38, 'Ejercicios de Ajuste de Reacciones', 'ajuste_reacciones.pdf', 'privado', 33, 15, 1),
(39, 'Mi primer programa: Hola Mundo en Python', 'python_intro.pdf', 'publico', 25, 17, 2),
(40, 'Guía de Bucles y Condicionales', 'bucles_java.pdf', 'privado', 1, 17, 2),
(41, 'Eje Cronológico de la Guerra Civil', 'eje_guerra_civil.pdf', 'publico', 34, 18, 1),
(42, 'Resumen Primera Guerra Mundial', 'ww1_resumen.pdf', 'publico', 35, 18, 1),
(43, 'Conceptos básicos: Oferta y Demanda', 'oferta_demanda.pdf', 'publico', 38, 5, 2),
(44, 'Balance de Situación: Ejercicio Resuelto', 'balance_ejemplo.pdf', 'privado', 37, 5, 2),
(45, 'Comportamiento de la Luz', 'optica_intro.pdf', 'publico', 42, 20, 1),
(46, 'Energía Nuclear: Ventajas y Riesgos', 'nuclear_debate.pdf', 'privado', 43, 14, 1),
(47, 'Nomenclatura de Carbono', 'quimica_organica_1.pdf', 'publico', 45, 19, 4),
(48, 'Manual de Seguridad en Laboratorio', 'safety_lab.pdf', 'publico', 47, 15, 1),
(49, 'Creando tu primera App en Android', 'android_start.pdf', 'privado', 40, 21, 2),
(50, 'Árboles y Grafos en Python', 'estructuras_datos.pdf', 'privado', 41, 21, 2),
(51, 'La vida en Roma', 'roma_antigua.pdf', 'publico', 48, 18, 1),
(52, 'Impacto de la Máquina de Vapor', 'revolucion_ind.pdf', 'publico', 50, 18, 1),
(53, 'Estrategias de Marketing 2026', 'marketing_trends.pdf', 'publico', 52, 22, 7),
(54, 'Plan General Contable', 'pgc_resumen.pdf', 'privado', 53, 5, 2),
(55, 'Gramática Francesa A1: Lecciones Básicas', 'fr_grammar_a1.pdf', 'publico', 69, 6, 3),
(56, 'Vocabulario de Viajes: París', 'fr_vocab_travel.pdf', 'publico', 69, 6, 3),
(57, 'Escritura Hiragana: Cuaderno de Práctica', 'jp_hiragana.pdf', 'privado', 70, 5, 3),
(58, 'Saludos y Cortesía en Japón', 'jp_culture.pdf', 'publico', 70, 5, 3),
(59, 'Italiano para Gastronomía', 'it_food_vocab.pdf', 'publico', 71, 6, 3),
(60, 'Conjugación de Verbos Italianos', 'it_verbs.pdf', 'privado', 71, 6, 3),
(61, 'Introducción a los Límites', 'calc_limites.pdf', 'publico', 72, 14, 1),
(62, 'Derivadas paso a paso', 'calc_derivadas.pdf', 'privado', 72, 14, 1),
(63, 'Vectores en el Espacio 3D', 'geo_vectores.pdf', 'publico', 73, 20, 1),
(64, 'Identidades Trigonométricas Fundamentales', 'trig_sheet.pdf', 'publico', 74, 20, 1),
(65, 'Cálculo de Interés Compuesto', 'fin_interest.xlsx', 'privado', 75, 16, 2),
(66, 'Amortización de Préstamos: Guía', 'fin_loans.pdf', 'publico', 75, 16, 2),
(67, 'Teoría del Color: RGB vs CMYK', 'color_theory.pdf', 'publico', 76, 11, 5),
(68, 'Psicología del Color en Publicidad', 'color_psych.pdf', 'privado', 76, 11, 5),
(69, 'La Regla de los Tercios en Fotografía', 'photo_composition.pdf', 'publico', 77, 11, 5),
(70, 'Guía de ISO, Apertura y Velocidad', 'photo_exposure.pdf', 'privado', 77, 11, 5),
(71, 'Introducción a la Producción Musical', 'music_intro.pdf', 'publico', 78, 11, 5),
(72, 'Uso de Compresores y EQ', 'music_mix.mp4', 'privado', 78, 11, 5),
(73, 'Fauna Ibérica: Mamíferos', 'zoo_mammals.pdf', 'publico', 79, 10, 4),
(74, 'Invertebrados Marinos del Mediterráneo', 'zoo_marine.pdf', 'privado', 79, 10, 4),
(75, 'Estrategias de Economía Circular', 'eco_circular.pdf', 'publico', 80, 19, 4),
(76, 'Impacto del Cambio Climático 2026', 'eco_climate.pdf', 'publico', 80, 19, 4),
(77, 'Neurotransmisores y Sinapsis', 'neuro_synapse.pdf', 'privado', 81, 10, 4),
(78, 'Plasticidad Cerebral: Resumen', 'neuro_plasticity.pdf', 'publico', 81, 10, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_comentario`
--

CREATE TABLE `documento_comentario` (
  `id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `usuarioId` int(11) NOT NULL,
  `documentoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento_comentario`
--

INSERT INTO `documento_comentario` (`id`, `contenido`, `fecha`, `usuarioId`, `documentoId`) VALUES
(1, '¡Excelente guía! Por fin entiendo useEffect.', '2026-01-05 10:00:00', 8, 4),
(2, '¿Podrías añadir ejemplos con TypeScript?', '2026-01-05 12:30:00', 16, 4),
(3, 'Me ha salvado para el proyecto final, gracias.', '2026-01-06 09:15:00', 9, 4),
(4, 'El PDF no se ve bien en móvil, ¿pueden revisarlo?', '2026-01-02 18:00:00', 13, 39),
(5, 'Muy básico pero bien explicado.', '2026-01-03 11:20:00', 11, 39),
(6, 'Los ejercicios del final no tienen solución, ¿dónde puedo verlas?', '2026-01-07 16:45:00', 20, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_valoracion`
--

CREATE TABLE `documento_valoracion` (
  `usuarioId` int(11) NOT NULL,
  `documentoId` int(11) NOT NULL,
  `puntuacion` int(1) NOT NULL CHECK (`puntuacion` between 1 and 5),
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento_valoracion`
--

INSERT INTO `documento_valoracion` (`usuarioId`, `documentoId`, `puntuacion`, `fecha`) VALUES
(8, 4, 5, '2026-01-09 20:00:48'),
(8, 35, 5, '2026-01-09 20:00:48'),
(9, 4, 5, '2026-01-09 20:00:48'),
(11, 39, 4, '2026-01-09 20:00:48'),
(13, 4, 5, '2026-01-09 20:00:48'),
(13, 39, 3, '2026-01-09 20:00:48'),
(16, 4, 4, '2026-01-09 20:00:48'),
(20, 35, 4, '2026-01-09 20:00:48'),
(20, 39, 5, '2026-01-09 20:00:48');

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
(5, 'Open Day: English for Business', '2024-09-01 17:00:00', 3),
(6, 'Simposio de Biotecnología', '2026-03-15 09:00:00', 4),
(7, 'Exposición de Arte Digital', '2026-04-20 18:00:00', 5),
(8, 'Hackathon AI for Good', '2026-05-10 08:00:00', 6),
(9, 'Networking Empresarial', '2026-02-28 19:00:00', 7),
(10, 'Simposio de Biotecnología', '2026-03-15 09:00:00', 4),
(11, 'Exposición de Arte Digital', '2026-04-20 18:00:00', 5),
(12, 'Hackathon AI for Good', '2026-05-10 08:00:00', 6),
(13, 'Networking Empresarial', '2026-02-28 19:00:00', 7),
(14, 'Simposio de Biotecnología', '2026-03-15 09:00:00', 4),
(15, 'Exposición de Arte Digital', '2026-04-20 18:00:00', 5),
(16, 'Hackathon AI for Good', '2026-05-10 08:00:00', 6),
(17, 'Networking Empresarial', '2026-02-28 19:00:00', 7);

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
(5, 'La plataforma va lenta por las tardes', 'abierta', 10),
(6, 'No puedo acceder al curso de Genética', 'abierta', 19),
(7, 'Error en la pasarela de pago', 'cerrada', 21),
(8, 'Solicito cambio de contraseña manual', 'abierta', 20),
(9, 'Solicito reembolso del curso de Java', 'cerrada', 11),
(10, 'No me llegó el correo de confirmación', 'abierta', 13),
(11, 'Error visual en el menú de perfil', 'abierta', 16);

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
(3, 'English Now School', 'academia', 'Gran Vía 12, Valencia', 'contact@englishnow.com'),
(4, 'Centro de Investigaciones Biológicas', 'academia', 'Calle Ciencia 88, Sevilla', 'contacto@cib.es'),
(5, 'Universidad de las Artes y Diseño', 'universidad', 'Av. Creativa 10, Bilbao', 'admit@uartes.edu'),
(6, 'Instituto Tecnológico del Norte', 'universidad', 'Plaza Mayor 5, Santander', 'info@itn.edu'),
(7, 'Escuela de Negocios Global', 'academia', 'Paseo de la Castellana 200, Madrid', 'mba@negocios.com');

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
(1, 'Programación', NULL),
(2, 'Idiomas', NULL),
(3, 'Matemáticas', NULL),
(4, 'Desarrollo Web', 1),
(5, 'Ciberseguridad', 1),
(6, 'Bases de Datos', 1),
(7, 'Inglés', 2),
(8, 'Alemán', 2),
(9, 'Álgebra', 3),
(10, 'Estadística', 3),
(13, 'Biología', NULL),
(14, 'Arte y Humanidades', NULL),
(15, 'Biología Celular', 13),
(16, 'Genética Molecular', 13),
(17, 'Historia del Arte', 14),
(18, 'Diseño Gráfico Digital', 14),
(19, 'Inteligencia Artificial', 1),
(21, 'Física', NULL),
(22, 'Química', NULL),
(23, 'Historia', NULL),
(24, 'Economía', NULL),
(25, 'Introducción a Python', 1),
(28, 'Cinemática y Dinámica', 21),
(29, 'Electromagnetismo', 21),
(30, 'Termodinámica', 21),
(31, 'Formulación Inorgánica', 22),
(32, 'Tabla Periódica', 22),
(33, 'Reacciones Químicas', 22),
(34, 'Historia de España (Siglo XX)', 23),
(35, 'Historia Universal', 23),
(36, 'Geografía', 23),
(37, 'Economía de la Empresa', 24),
(38, 'Macroeconomía Básica', 24),
(39, 'Python Avanzado', 1),
(40, 'Desarrollo de Apps Móviles', 1),
(41, 'Estructuras de Datos', 1),
(42, 'Óptica y Ondas', 21),
(43, 'Física Nuclear', 21),
(45, 'Química Orgánica', 22),
(46, 'Bioquímica Básica', 22),
(47, 'Laboratorio Químico', 22),
(48, 'Historia Antigua', 23),
(49, 'Edad Media en Europa', 23),
(50, 'Revolución Industrial', 23),
(51, 'Microeconomía', 24),
(52, 'Marketing Digital', 24),
(53, 'Contabilidad Financiera', 24),
(59, 'Mecánica de Fluidos', 21),
(69, 'Francés Básico', 2),
(70, 'Japonés Inicial', 2),
(71, 'Italiano para Viajeros', 2),
(72, 'Cálculo Diferencial', 3),
(73, 'Geometría Analítica', 3),
(74, 'Trigonometría', 3),
(75, 'Matemática Financiera', 3),
(76, 'Teoría del Color', 14),
(77, 'Fotografía Digital', 14),
(78, 'Producción Musical', 14),
(79, 'Zoología', 13),
(80, 'Ecología y Medio Ambiente', 13),
(81, 'Neurociencia Básica', 13);

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
(6, 'Frau', 'Müller', 3),
(10, 'Dra. Elena', 'Genoma', 4),
(11, 'Prof. Marco', 'Pincel', 5),
(12, 'Ing. Sofia', 'Robótica', 6),
(13, 'Dr. Alan', 'Turing', 1),
(14, 'Prof. Alberto', 'Einstein', 1),
(15, 'Dra. Marie', 'Curie', 1),
(16, 'Prof. Adam', 'Smith', 2),
(17, 'Lic. Juana', 'Lovelace', 2),
(18, 'Dr. Herodoto', 'Pérez', 1),
(19, 'Dra. Rosalind', 'Franklin', 4),
(20, 'Prof. Isaac', 'Newton', 1),
(21, 'Lic. Ada', 'Byron', 2),
(22, 'Dr. John', 'Keynes', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `vistas` int(11) DEFAULT 0,
  `votos_utiles` int(11) DEFAULT 0,
  `estado` enum('sin_responder','respondida','resuelta') DEFAULT 'sin_responder',
  `usuarioId` int(11) NOT NULL,
  `materiaId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `titulo`, `descripcion`, `fecha_creacion`, `vistas`, `votos_utiles`, `estado`, `usuarioId`, `materiaId`) VALUES
(1, '¿Cómo implementar recursividad en Python?', 'No entiendo bien el caso base en las funciones recursivas. ¿Alguien tiene un ejemplo simple con factoriales?', '2026-01-05 10:30:00', 23, 2, 'sin_responder', 16, 25),
(2, 'Diferencia conceptual entre derivada e integral', 'Entiendo cómo calcularlas, pero no entiendo qué significan en la vida real. ¿Ayuda?', '2026-01-06 14:15:00', 156, 5, 'resuelta', 9, 72),
(3, 'Trucos para memorizar Phrasal Verbs', 'Son demasiados y me confundo entre \"get on\", \"get in\", \"get by\". ¿Algún consejo?', '2026-01-04 09:00:00', 342, 10, 'respondida', 8, 7),
(4, 'Demostración visual de Pitágoras', 'Busco una explicación geométrica, no solo la fórmula a^2 + b^2 = c^2.', '2026-01-02 18:20:00', 198, 3, 'resuelta', 15, 73),
(5, 'Organización de la Tabla Periódica', '¿Por qué los gases nobles están a la derecha del todo?', '2026-01-07 11:45:00', 67, 0, 'sin_responder', 13, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_guardada`
--

CREATE TABLE `pregunta_guardada` (
  `usuarioId` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `fecha_guardado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_guardada`
--

INSERT INTO `pregunta_guardada` (`usuarioId`, `preguntaId`, `fecha_guardado`) VALUES
(8, 5, '2026-01-09 19:24:04'),
(9, 1, '2026-01-09 19:24:04'),
(16, 2, '2026-01-09 19:24:04'),
(16, 3, '2026-01-09 19:24:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_voto`
--

CREATE TABLE `pregunta_voto` (
  `usuarioId` int(11) NOT NULL,
  `preguntaId` int(11) NOT NULL,
  `fecha_voto` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_voto`
--

INSERT INTO `pregunta_voto` (`usuarioId`, `preguntaId`, `fecha_voto`) VALUES
(8, 2, '2026-01-09 19:22:14'),
(8, 4, '2026-01-09 19:22:14'),
(9, 1, '2026-01-09 19:22:14'),
(10, 2, '2026-01-09 19:22:14'),
(11, 2, '2026-01-09 19:22:14'),
(13, 2, '2026-01-09 19:22:14'),
(13, 4, '2026-01-09 19:22:14'),
(15, 2, '2026-01-09 19:22:14'),
(16, 4, '2026-01-09 19:22:14'),
(20, 1, '2026-01-09 19:22:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `es_solucion` tinyint(1) DEFAULT 0,
  `preguntaId` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `contenido`, `fecha`, `es_solucion`, `preguntaId`, `usuarioId`) VALUES
(1, 'La derivada es la velocidad del coche (ritmo de cambio) y la integral es la distancia total recorrida.', '2026-01-06 15:00:00', 1, 2, 14),
(2, 'Matemáticamente son operaciones inversas, como la multiplicación y la división.', '2026-01-06 16:30:00', 0, 2, 20),
(3, 'Intenta agruparlos por tema en lugar de por verbo. Por ejemplo, todos los que sirven para \"viajar\".', '2026-01-04 12:00:00', 0, 3, 11),
(4, 'Yo uso tarjetas de memoria (Flashcards) con la app Anki, funciona muy bien.', '2026-01-05 09:15:00', 0, 3, 10),
(5, 'Imagina un cuadrado construido sobre cada lado del triángulo. El área del cuadrado grande es igual a la suma de las áreas de los pequeños.', '2026-01-03 10:00:00', 1, 4, 24);

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
(4, 'Curso Inglés de Negocios', 800.00, 3),
(5, 'Pack Formación Alemán Técnico', 1500.00, 3),
(6, 'Curso Avanzado de Genética', 600.00, 4),
(7, 'Máster en Diseño UI/UX', 3500.00, 5),
(8, 'Bootcamp de Inteligencia Artificial', 2200.00, 6),
(9, 'MBA Executive', 12000.00, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_log`
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
-- Volcado de datos para la tabla `user_log`
--

INSERT INTO `user_log` (`id`, `user_id`, `user_identifier`, `action`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 18, 'juanrv2@mail.com', 'Logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:12'),
(2, 16, 'juan@mail.com', 'Login Success', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:24'),
(3, 16, 'juan@mail.com', 'Logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2026-01-08 13:54:30'),
(4, 8, 'carlos@mail.com', 'Login Success', '192.168.1.10', 'Mozilla/5.0 (Windows) Chrome/90', '2026-01-09 16:53:02'),
(5, 9, 'maria@mail.com', 'View Document ID 20', '192.168.1.11', 'Mozilla/5.0 (Macintosh) Safari/14', '2026-01-09 16:53:02'),
(6, 8, 'carlos@mail.com', 'Download PDF', '192.168.1.10', 'Mozilla/5.0 (Windows) Chrome/90', '2026-01-09 16:53:02'),
(7, 19, 'robert_stud', 'Login Failed', '10.0.0.5', 'Mozilla/5.0 (Linux) Firefox/88', '2026-01-09 16:53:02'),
(8, 19, 'robert_stud', 'Login Success', '10.0.0.5', 'Mozilla/5.0 (Linux) Firefox/88', '2026-01-09 16:53:02'),
(9, 10, 'lucia@mail.com', 'Update Profile', '192.168.1.15', 'Mozilla/5.0 (iPhone) Safari/14', '2026-01-09 16:53:02'),
(10, 5, 'contacto', 'View Invoice', '80.20.10.5', 'Mozilla/5.0 (Windows) Edge/90', '2026-01-09 16:53:02'),
(11, 20, 'lau2024', 'Search query: \"Python\"', '192.168.0.22', 'Mozilla/5.0 (Android) Chrome/89', '2026-01-09 16:53:02'),
(12, 11, 'david@mail.com', 'Logout', '192.168.1.30', 'Mozilla/5.0 (Windows) Chrome/90', '2026-01-09 16:53:02'),
(13, 16, 'juanrv', 'Login Success', '::1', 'Mozilla/5.0 (Windows) Chrome/120', '2026-01-09 16:53:02'),
(14, 16, 'juanrv', 'View Dashboard', '::1', 'Mozilla/5.0 (Windows) Chrome/120', '2026-01-09 16:53:02'),
(15, 9, 'maria@mail.com', 'Download PDF ID 45', '192.168.1.11', 'Mozilla/5.0 (Macintosh) Safari/14', '2026-01-09 16:53:02');

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
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `username` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`, `username`) VALUES
(1, 'Super Admin', 'admin@portal.com', '1234', 'admin', '2026-01-03 11:21:26', 'admin'),
(2, 'Gestor Politécnica', 'gestor@upm.es', '1234', 'gestor', '2026-01-03 11:21:26', 'gestor'),
(3, 'Gestor CodeMasters', 'director@codemasters.com', '1234', 'gestor', '2026-01-03 11:21:26', 'director'),
(4, 'Gestor EnglishNow', 'hello@englishnow.com', '1234', 'gestor', '2026-01-03 11:21:26', 'hello'),
(5, 'Tech Solutions CEO', 'contacto@techsolutions.com', '1234', 'empresa', '2026-01-03 11:21:26', 'contacto'),
(6, 'Consultora Global', 'rrhh@consultoraglobal.com', '1234', 'empresa', '2026-01-03 11:21:26', 'rrhh'),
(7, 'StartUp Innova', 'admin@innova.io', '1234', 'empresa', '2026-01-03 11:21:26', 'innova'),
(8, 'Carlos Pérez', 'carlos@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'carlos'),
(9, 'María García', 'maria@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'maria'),
(10, 'Lucía Méndez', 'lucia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'lucia'),
(11, 'David Torres', 'david@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'david'),
(12, 'Elena Nito', 'elena@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'elena'),
(13, 'Sofía Rivas', 'sofia@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'sofia'),
(14, 'Jorge Bua', 'jorge@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'jorge'),
(15, 'Ana Bot', 'ana@mail.com', '1234', 'alumno', '2026-01-03 11:21:26', 'ana'),
(16, 'Juan Riego Vila', 'juan@mail.com', '1234', 'alumno', '2026-01-08 10:33:50', 'juanrv'),
(17, 'Andrea Colorado Esteban', 'andreace@mail.com', '1234', '', '2026-01-08 13:01:31', 'andreace'),
(18, 'Juan Riego Vila', 'juanrv2@mail.com', '1234', '', '2026-01-08 13:40:35', 'juanrv2'),
(19, 'Roberto Estudiante', 'robert@mail.com', '1234', 'alumno', '2026-01-09 16:01:32', 'robert_stud'),
(20, 'Laura Aprendiz', 'laura_new@mail.com', '1234', 'alumno', '2026-01-09 16:01:32', 'lau2024'),
(21, 'Empresa TechSoft', 'admin@techsoft.com', '1234', 'empresa', '2026-01-09 16:01:32', 'techsoft_admin'),
(22, 'Constructora Civil S.L.', 'info@constructora.com', '1234', 'empresa', '2026-01-09 16:01:32', 'constructora_sl'),
(23, 'Academia BioAdmin', 'gestion@bioadmin.com', '1234', 'gestor', '2026-01-09 16:01:32', 'bio_gestor'),
(24, 'Pedro Profesor', 'pedro@mail.com', '1234', 'alumno', '2026-01-09 16:01:32', 'pedroprof'),
(25, 'Marta Diseño', 'marta@design.com', '1234', 'empresa', '2026-01-09 16:01:32', 'marta_design'),
(26, 'Hospital General', 'compras@hospitalgeneral.com', '1234', 'empresa', '2026-01-09 16:54:16', 'hosp_general'),
(27, 'Editorial Saber', 'pedidos@editorialsaber.com', '1234', 'empresa', '2026-01-09 16:54:16', 'edit_saber');

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
-- Indices de la tabla `documento_comentario`
--
ALTER TABLE `documento_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doc_com_usuario` (`usuarioId`),
  ADD KEY `fk_doc_com_documento` (`documentoId`);

--
-- Indices de la tabla `documento_valoracion`
--
ALTER TABLE `documento_valoracion`
  ADD PRIMARY KEY (`usuarioId`,`documentoId`),
  ADD KEY `fk_doc_val_documento` (`documentoId`);

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
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pregunta_usuario` (`usuarioId`),
  ADD KEY `fk_pregunta_materia` (`materiaId`);

--
-- Indices de la tabla `pregunta_guardada`
--
ALTER TABLE `pregunta_guardada`
  ADD PRIMARY KEY (`usuarioId`,`preguntaId`),
  ADD KEY `fk_pg_pregunta` (`preguntaId`);

--
-- Indices de la tabla `pregunta_voto`
--
ALTER TABLE `pregunta_voto`
  ADD PRIMARY KEY (`usuarioId`,`preguntaId`),
  ADD KEY `fk_pv_pregunta` (`preguntaId`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_respuesta_pregunta` (`preguntaId`),
  ADD KEY `fk_respuesta_usuario` (`usuarioId`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucionId` (`institucionId`);

--
-- Indices de la tabla `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `contratacion`
--
ALTER TABLE `contratacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `documento_comentario`
--
ALTER TABLE `documento_comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- Filtros para la tabla `documento_comentario`
--
ALTER TABLE `documento_comentario`
  ADD CONSTRAINT `fk_doc_com_documento` FOREIGN KEY (`documentoId`) REFERENCES `documento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doc_com_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documento_valoracion`
--
ALTER TABLE `documento_valoracion`
  ADD CONSTRAINT `fk_doc_val_documento` FOREIGN KEY (`documentoId`) REFERENCES `documento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doc_val_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

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
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_pregunta_materia` FOREIGN KEY (`materiaId`) REFERENCES `materia` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pregunta_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pregunta_guardada`
--
ALTER TABLE `pregunta_guardada`
  ADD CONSTRAINT `fk_pg_pregunta` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pg_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pregunta_voto`
--
ALTER TABLE `pregunta_voto`
  ADD CONSTRAINT `fk_pv_pregunta` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pv_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `fk_respuesta_pregunta` FOREIGN KEY (`preguntaId`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_respuesta_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;



--
-- Estructura de tabla para la tabla `coleccion`
--

-- TABLA: coleccion
DROP TABLE IF EXISTS `coleccion`;
CREATE TABLE `coleccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `usuarioId` int(11) NOT NULL,
  `descargas` int(11) DEFAULT 0,
  `tipo_acceso` enum('publico','privado') NOT NULL DEFAULT 'publico',
  `fecha_actualizacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_coleccion_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLA: coleccion_documento (Relación N:M)
CREATE TABLE `coleccion_documento` (
  `coleccionId` int(11) NOT NULL,
  `documentoId` int(11) NOT NULL,
  PRIMARY KEY (`coleccionId`, `documentoId`),
  CONSTRAINT `fk_cd_coleccion` FOREIGN KEY (`coleccionId`) REFERENCES `coleccion` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cd_documento` FOREIGN KEY (`documentoId`) REFERENCES `documento` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLA: usuario_coleccion (Relación N:M)
CREATE TABLE `usuario_coleccion` (
  `usuarioId` int(11) NOT NULL,
  `coleccionId` int(11) NOT NULL,
  `fecha_union` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`usuarioId`, `coleccionId`),
  CONSTRAINT `fk_uc_usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_uc_coleccion` FOREIGN KEY (`coleccionId`) REFERENCES `coleccion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INSERTS

INSERT INTO `coleccion` (`id`, `titulo`, `descripcion`, `usuarioId`, `descargas`, `tipo_acceso`) VALUES
(1, 'Matemáticas de Ingeniería', 'Cálculo diferencial, integral y vectores en 3D.', 10, 450, 'publico'),
(2, 'Desarrollo Frontend Moderno', 'Dominando React Hooks y composición visual.', 4, 1200, 'publico'),
(3, 'Ciberseguridad y Redes', 'Hacking ético, SQL avanzado y seguridad en redes.', 3, 890, 'publico'),
(4, 'Idiomas y Cultura Global', 'Francés, Alemán, Italiano y cultura japonesa.', 6, 340, 'publico'),
(5, 'Historia y Civilizaciones', 'Del Renacimiento a la Guerra Civil Española.', 18, 560, 'publico'),
(6, 'Biología y Genética 2026', 'Edición genética CRISPR y Atlas Celular.', 10, 210, 'publico'),
(7, 'Física y Química General', 'Leyes de Newton, óptica y nomenclatura de carbono.', 15, 670, 'publico'),
(8, 'Economía y Finanzas', 'Oferta, demanda, contabilidad e interés compuesto.', 5, 430, 'publico'),
(9, 'Arte y Composición Visual', 'Teoría del color, fotografía y diseño gráfico.', 11, 780, 'publico'),
(10, 'IA y Neurociencia', 'Redes neuronales y plasticidad cerebral.', 1, 1500, 'publico'),
(11, 'Programación con Python', 'Desde Hola Mundo hasta estructuras de datos.', 17, 920, 'publico'),
(12, 'Tecnología Móvil y Apps', 'Desarrollo en Android y estrategias móviles.', 21, 310, 'publico'),
(13, 'Producción Musical Pro', 'Mezcla, ecualización y teoría musical.', 11, 150, 'publico'),
(14, 'Zoología y Ecosistemas', 'Fauna ibérica e invertebrados marinos.', 10, 85, 'publico'),
(15, 'Sostenibilidad y Marketing', 'Economía circular y tendencias de mercado.', 22, 195, 'publico');
-- INSERTS de coleccion_documento

INSERT INTO `coleccion_documento` (`coleccionId`, `documentoId`) VALUES
-- Matemáticas (Col 1): 3, 61, 62, 63, 64
(1, 3), (1, 61), (1, 62), (1, 63), (1, 64),
-- Frontend (Col 2): 4, 6, 23
(2, 4), (2, 6), (2, 23),
-- Ciberseguridad (Col 3): 5, 7, 48
(3, 5), (3, 7), (3, 48),
-- Idiomas (Col 4): 8, 9, 55, 56, 57, 58, 59, 60
(4, 8), (4, 9), (4, 55), (4, 56), (4, 57), (4, 58), (4, 59), (4, 60),
-- Historia (Col 5): 21, 41, 42, 51, 52
(5, 21), (5, 41), (5, 42), (5, 51), (5, 52),
-- Biología (Col 6): 20, 24, 73, 74
(6, 20), (6, 24), (6, 73), (6, 74),
-- Física/Química (Col 7): 35, 36, 37, 38, 45, 46, 47
(7, 35), (7, 36), (7, 37), (7, 38), (7, 45), (7, 46), (7, 47),
-- Economía (Col 8): 43, 44, 54, 65, 66
(8, 43), (8, 44), (8, 54), (8, 65), (8, 66),
-- Arte (Col 9): 67, 68, 69, 70
(9, 67), (9, 68), (9, 69), (9, 70),
-- IA (Col 10): 2, 22, 77, 78
(10, 2), (10, 22), (10, 77), (10, 78),
-- Python (Col 11): 39, 40, 50
(11, 39), (11, 40), (11, 50),
-- Móvil (Col 12): 49, 53
(12, 49), (12, 53),
-- Música (Col 13): 71, 72
(13, 71), (13, 72),
-- Zoología (Col 14): 73, 74
(14, 73), (14, 74),
-- Sostenibilidad (Col 15): 75, 76
(15, 75), (15, 76);

-- INSERTS de usuario_coleccion

INSERT INTO `usuario_coleccion` (`usuarioId`, `coleccionId`, `fecha_union`) VALUES
-- Juan Riego (ID 16) está muy activo
(16, 1, '2026-01-10 10:00:00'), (16, 2, '2026-01-10 10:05:00'),
(16, 10, '2026-01-10 10:10:00'), (16, 11, '2026-01-10 10:15:00'),
-- Carlos Pérez (ID 8)
(8, 2, '2026-01-09 09:00:00'), (8, 3, '2026-01-09 09:30:00'),
(8, 12, '2026-01-09 10:00:00'),
-- María García (ID 9)
(9, 6, '2026-01-08 11:00:00'), (9, 7, '2026-01-08 11:30:00'),
(9, 14, '2026-01-08 12:00:00'),
-- Otros alumnos
(12, 5, '2026-01-07 15:00:00'), (12, 8, '2026-01-07 15:30:00'),
(12, 9, '2026-01-07 16:00:00'), (12, 15, '2026-01-07 16:30:00');


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
