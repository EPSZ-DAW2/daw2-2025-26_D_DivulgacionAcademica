-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 20:01:53
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materiaId` (`materiaId`),
  ADD KEY `autorId` (`autorId`),
  ADD KEY `institucionId` (`institucionId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`materiaId`) REFERENCES `materia` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`autorId`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`institucionId`) REFERENCES `institucion` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
