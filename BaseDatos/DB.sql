-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-04-2016 a las 23:11:40
-- Versión del servidor: 5.5.47-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bdnasa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capa`
--

CREATE TABLE IF NOT EXISTS `capa` (
  `idcapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  `color` varchar(7) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcapa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `capa`
--

INSERT INTO `capa` (`idcapa`, `nombre`, `color`) VALUES
(1, 'Edificio publico', '#000066'),
(2, 'Estadio deportivo', '#33FF33'),
(3, 'Rio', '#00CCFF'),
(4, 'Zona Militar', '#FF0000'),
(5, 'Ruta/Autopista', '#666666'),
(6, 'Espacio verde', '#009900'),
(7, 'Centro Comercial', '#FF3399'),
(8, 'Zona de aeropuerto/Aeroclub', '#CCFF00'),
(9, 'Nueva capa de prueba', ''),
(10, 'Capa con picker', '#ff80c0'),
(11, 'Casa historica', '#9d44bb'),
(12, '', '#ff0000'),
(13, '', '#ff0000'),
(14, 'k', '#ff0000'),
(15, 'kk', '#000000'),
(16, 'y', '#ff0000'),
(17, '', '#000000'),
(18, '', '#000000'),
(19, 'g', '#000000'),
(20, 'h', '#ff0000'),
(21, 'Capa colortuti', '#00ff00'),
(22, 'k', '#ff0000'),
(23, 'a', '#ff0000'),
(24, 'a', '#ff0000'),
(25, 'a', '#ff0000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dron`
--

CREATE TABLE IF NOT EXISTS `dron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `idmodelo` int(11) DEFAULT NULL,
  `vientomax` int(11) DEFAULT NULL,
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`),
  KEY `idmodelo` (`idmodelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dron`
--

INSERT INTO `dron` (`id`, `descripcion`, `idmodelo`, `vientomax`, `idusuario`) VALUES
(1, 'Rojo a cuadritos', 1, 40, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `idmarca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_marca` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  `descripcion_marca` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  PRIMARY KEY (`idmarca`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`idmarca`, `nombre_marca`, `descripcion_marca`) VALUES
(1, 'DJI', 'De Shenzhen, China');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE IF NOT EXISTS `modelo` (
  `idmodelo` int(11) NOT NULL AUTO_INCREMENT,
  `idmarca` int(11) NOT NULL,
  `nombre_modelo` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  `peso` int(11) NOT NULL,
  `frecuencia` float NOT NULL,
  `autonomia` int(11) NOT NULL,
  `alcance` int(11) NOT NULL,
  `descripcion_modelo` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  PRIMARY KEY (`idmodelo`),
  KEY `idmarca` (`idmarca`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`idmodelo`, `idmarca`, `nombre_modelo`, `peso`, `frecuencia`, `autonomia`, `alcance`, `descripcion_modelo`) VALUES
(1, 1, 'Phantom 2', 1000, 2.4, 25, 1000, 'Velocidad máxima de 15m/s'),
(2, 1, 'Phantom 1', 1000, 2.4, 15, 1000, '-'),
(3, 1, 'Phantom 3 Standard', 1216, 2.4, 25, 1000, 'Velocidad máxima de 16m/s'),
(4, 1, 'Phantom 3 Advanced', 1280, 2.4, 25, 5000, 'Velocidad máxima de 16m/s'),
(5, 1, 'Phantom 3 Professional', 1280, 2.4, 25, 5000, 'Velocidad máxima de 16m/s'),
(6, 1, 'Phantom 4', 1380, 2.4, 28, 5000, 'Velocidad máxima de 20m/s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poligono`
--

CREATE TABLE IF NOT EXISTS `poligono` (
  `idpoligono` int(11) NOT NULL AUTO_INCREMENT,
  `idcapa` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nro_res` int(11) NOT NULL,
  PRIMARY KEY (`idpoligono`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=139 ;

--
-- Volcado de datos para la tabla `poligono`
--

INSERT INTO `poligono` (`idpoligono`, `idcapa`, `descripcion`, `nro_res`) VALUES
(1, 1, 'Monumento a la Bandera', 4),
(2, 6, 'Plaza 25 de Mayo', 4),
(3, 3, 'Rio Parana', 26),
(4, 6, 'Parque independencia', 9),
(5, 6, 'Plaza Sarmiento', 8),
(6, 6, 'Plaza San Martin', 4),
(7, 1, 'Facultad de Derecho', 4),
(8, 6, 'Plaza Pringles', 4),
(9, 1, 'Facultad de Artes', 6),
(10, 1, 'UTN FRRo', 4),
(11, 6, 'Plaza Lopez', 4),
(12, 6, 'Plaza Libertad', 4),
(13, 6, 'Plaza Urquiza', 3),
(14, 1, 'Complejo Astronomico Municipal', 3),
(15, 1, 'Batallon 121', 10),
(16, 2, 'Estadio Newells Old Boys', 4),
(17, 7, 'Shopping Alto Rosario', 4),
(18, 6, 'Parque Scalabrini Ortiz', 6),
(19, 6, 'Parque EspaÃ±a', 11),
(20, 2, 'Club Rosario Central', 4),
(21, 6, 'Parque Alem', 10),
(22, 8, 'Aeropuerto Fisherton', 8),
(23, 4, 'Preuba Sta Fe', 3),
(24, 0, ' ', 0),
(25, 0, ' ', 0),
(26, 0, ' ', 0),
(27, 1, 'Plaza San Carlos', 3),
(28, 2, 'Argentino sc', 3),
(29, 4, 'Batallon san carlos', 4),
(30, 6, 'Plaza inexistente', 4),
(31, 0, ' ', 0),
(32, 11, 'Mia casa', 4),
(33, 1, '', 4),
(34, 3, 'a', 3),
(35, 1, 'h', 5),
(36, 0, ' ', 0),
(37, 0, ' ', 0),
(38, 2, 'Argentino', 3),
(39, 0, ' ', 0),
(40, 0, ' ', 0),
(41, 0, ' ', 0),
(42, 0, ' ', 0),
(43, 0, ' ', 0),
(44, 0, ' ', 0),
(45, 1, 'sd', 3),
(46, 0, ' ', 0),
(47, 0, ' ', 0),
(48, 0, ' ', 0),
(49, 0, ' ', 0),
(50, 0, ' ', 0),
(51, 1, 'jajajajaja', 4),
(52, 2, 'j', 3),
(53, 0, ' ', 0),
(54, 0, ' ', 0),
(55, 0, ' ', 0),
(56, 0, ' ', 0),
(57, 0, ' ', 0),
(58, 0, ' ', 0),
(59, 0, ' ', 0),
(60, 2, 'kjh', 3),
(61, 3, 'g', 1),
(62, 0, ' ', 0),
(63, 0, ' ', 0),
(64, 0, ' ', 0),
(65, 0, ' ', 0),
(66, 0, ' ', 0),
(67, 0, ' ', 0),
(68, 0, ' ', 0),
(69, 0, ' ', 0),
(70, 0, ' ', 0),
(71, 0, ' ', 0),
(72, 0, ' ', 0),
(73, 0, ' ', 0),
(74, 0, ' ', 0),
(75, 0, ' ', 0),
(76, 0, ' ', 0),
(77, 0, ' ', 0),
(78, 0, ' ', 0),
(79, 0, ' ', 0),
(80, 0, ' ', 0),
(81, 2, 'La casa del tuti', 4),
(82, 3, 'aaaaaaaaaaaa', 4),
(83, 0, ' ', 0),
(84, 2, 'z', 1),
(85, 22, 'k', 3),
(86, 0, ' ', 0),
(87, 0, ' ', 0),
(88, 0, ' ', 0),
(89, 0, ' ', 0),
(90, 0, ' ', 0),
(91, 0, ' ', 0),
(92, 0, ' ', 0),
(93, 0, ' ', 0),
(94, 0, ' ', 0),
(95, 0, ' ', 0),
(96, 0, ' ', 0),
(97, 0, ' ', 0),
(98, 0, ' ', 0),
(99, 0, ' ', 0),
(100, 0, ' ', 0),
(101, 0, ' ', 0),
(102, 0, ' ', 0),
(103, 0, ' ', 0),
(104, 0, ' ', 0),
(105, 0, ' ', 0),
(106, 0, ' ', 0),
(107, 0, ' ', 0),
(108, 0, ' ', 0),
(109, 0, ' ', 0),
(110, 0, ' ', 0),
(111, 0, ' ', 0),
(112, 0, ' ', 0),
(113, 0, ' ', 0),
(114, 0, ' ', 0),
(115, 0, ' ', 0),
(116, 0, ' ', 0),
(117, 0, ' ', 0),
(118, 0, ' ', 0),
(119, 0, ' ', 0),
(120, 0, ' ', 0),
(121, 0, ' ', 0),
(122, 0, ' ', 0),
(123, 0, ' ', 0),
(124, 0, ' ', 0),
(125, 9, 'Zavalla', 14),
(126, 6, 'McDonald', 4),
(127, 11, 'a', 1),
(128, 0, ' ', 0),
(129, 0, ' ', 0),
(130, 0, ' ', 0),
(131, 0, ' ', 0),
(132, 0, ' ', 0),
(133, 0, ' ', 0),
(134, 6, 'Plaza 25 de mayo', 4),
(135, 0, ' ', 0),
(136, 0, ' ', 0),
(137, 0, ' ', 0),
(138, 6, '25 de Mayo - Plaza', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restriccion`
--

CREATE TABLE IF NOT EXISTS `restriccion` (
  `idrestriccion` int(11) NOT NULL AUTO_INCREMENT,
  `idpoligono` int(11) NOT NULL,
  `latitud` float(10,6) NOT NULL,
  `longitud` float(10,6) NOT NULL,
  PRIMARY KEY (`idrestriccion`),
  KEY `idpoligono` (`idpoligono`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=336 ;

--
-- Volcado de datos para la tabla `restriccion`
--

INSERT INTO `restriccion` (`idrestriccion`, `idpoligono`, `latitud`, `longitud`) VALUES
(1, 1, -32.947632, -60.629543),
(2, 1, -32.948120, -60.629650),
(3, 1, -32.947803, -60.631100),
(4, 1, -32.947407, -60.630947),
(5, 2, -32.946690, -60.633575),
(6, 2, -32.947281, -60.633835),
(7, 2, -32.947453, -60.632793),
(8, 2, -32.946957, -60.632652),
(9, 3, -32.890472, -60.685471),
(10, 3, -32.896526, -60.682297),
(11, 3, -32.908272, -60.674660),
(12, 3, -32.921314, -60.664787),
(13, 3, -32.928303, -60.653889),
(14, 3, -32.933990, -60.642815),
(15, 3, -32.942204, -60.632343),
(16, 3, -32.948830, -60.625565),
(17, 3, -32.958553, -60.620327),
(18, 3, -32.966618, -60.618011),
(19, 3, -32.974178, -60.617237),
(20, 3, -32.987644, -60.615864),
(21, 3, -32.993763, -60.613716),
(22, 3, -32.998585, -60.611057),
(23, 3, -33.011326, -60.602219),
(24, 3, -33.025936, -60.592003),
(25, 3, -33.034573, -60.583591),
(26, 3, -33.026367, -60.577496),
(27, 3, -33.017590, -60.585735),
(28, 3, -33.001251, -60.596554),
(29, 3, -32.989445, -60.601189),
(30, 3, -32.961796, -60.603848),
(31, 3, -32.944942, -60.612431),
(32, 3, -32.926430, -60.643929),
(33, 3, -32.910000, -60.661957),
(34, 3, -32.887371, -60.674915),
(35, 4, -32.953297, -60.666759),
(36, 4, -32.955601, -60.667492),
(37, 4, -32.955315, -60.664959),
(38, 4, -32.959743, -60.665215),
(39, 4, -32.961830, -60.662598),
(40, 4, -32.964062, -60.662769),
(41, 4, -32.964638, -60.658951),
(42, 4, -32.954880, -60.656548),
(43, 4, -32.953369, -60.665947),
(44, 5, -32.950245, -60.643414),
(45, 5, -32.950172, -60.643028),
(46, 5, -32.950165, -60.642696),
(47, 5, -32.950279, -60.642365),
(48, 5, -32.950424, -60.642139),
(49, 5, -32.949722, -60.641991),
(50, 5, -32.949657, -60.642601),
(51, 5, -32.949497, -60.643147),
(52, 6, -32.942905, -60.650192),
(53, 6, -32.944180, -60.650513),
(54, 6, -32.944405, -60.649284),
(55, 6, -32.943146, -60.648930),
(56, 7, -32.942703, -60.651489),
(57, 7, -32.943954, -60.651897),
(58, 7, -32.944176, -60.650654),
(59, 7, -32.942875, -60.650398),
(60, 8, -32.944778, -60.644890),
(61, 8, -32.945156, -60.645020),
(62, 8, -32.945393, -60.643768),
(63, 8, -32.945038, -60.643673),
(64, 9, -32.945164, -60.640804),
(65, 9, -32.945072, -60.641373),
(66, 9, -32.945381, -60.641457),
(67, 9, -32.945435, -60.641228),
(68, 9, -32.945557, -60.641251),
(69, 9, -32.945602, -60.640903),
(70, 10, -32.954384, -60.644081),
(71, 10, -32.954578, -60.644135),
(72, 10, -32.954678, -60.643604),
(73, 10, -32.954453, -60.643555),
(74, 11, -32.958210, -60.636936),
(75, 11, -32.959633, -60.637299),
(76, 11, -32.959885, -60.635948),
(77, 11, -32.958447, -60.635647),
(78, 12, -32.959435, -60.642719),
(79, 12, -32.960461, -60.642975),
(80, 12, -32.960678, -60.641838),
(81, 12, -32.959633, -60.641518),
(82, 13, -32.955006, -60.624081),
(83, 13, -32.959743, -60.625198),
(84, 13, -32.960480, -60.621380),
(85, 14, -32.958969, -60.624210),
(86, 14, -32.959671, -60.624062),
(87, 14, -32.959202, -60.623459),
(88, 15, -32.990883, -60.643200),
(89, 15, -32.994286, -60.644100),
(90, 15, -32.994358, -60.641399),
(91, 15, -32.996464, -60.641033),
(92, 15, -32.996174, -60.636784),
(93, 15, -32.991711, -60.637192),
(94, 15, -32.991711, -60.639103),
(95, 15, -32.992287, -60.639038),
(96, 15, -32.992340, -60.642021),
(97, 15, -32.990776, -60.642170),
(98, 16, -32.955566, -60.661869),
(99, 16, -32.956535, -60.661934),
(100, 16, -32.956573, -60.660934),
(101, 16, -32.955482, -60.661041),
(102, 17, -32.929131, -60.671394),
(103, 17, -32.929092, -60.666031),
(104, 17, -32.926624, -60.665947),
(105, 17, -32.927006, -60.671848),
(106, 18, -32.929417, -60.671825),
(107, 18, -32.930443, -60.672062),
(108, 18, -32.930786, -60.668026),
(109, 18, -32.930302, -60.663670),
(110, 18, -32.929455, -60.663372),
(111, 18, -32.929508, -60.668285),
(112, 19, -32.936810, -60.639446),
(113, 19, -32.937286, -60.639812),
(114, 19, -32.937748, -60.638641),
(115, 19, -32.938259, -60.637871),
(116, 19, -32.938908, -60.636955),
(117, 19, -32.939510, -60.636517),
(118, 19, -32.939079, -60.636463),
(119, 19, -32.938892, -60.636700),
(120, 19, -32.938179, -60.637463),
(121, 19, -32.937603, -60.638222),
(122, 19, -32.936836, -60.639435),
(123, 20, -32.913322, -60.675247),
(124, 20, -32.914684, -60.675163),
(125, 20, -32.914677, -60.674015),
(126, 20, -32.913296, -60.674015),
(127, 21, -32.909145, -60.679176),
(128, 21, -32.909901, -60.680054),
(129, 21, -32.911018, -60.680172),
(130, 21, -32.911701, -60.679539),
(131, 21, -32.912125, -60.678307),
(132, 21, -32.912010, -60.676846),
(133, 21, -32.911633, -60.676762),
(134, 21, -32.910378, -60.677650),
(135, 21, -32.909443, -60.678326),
(136, 21, -32.909119, -60.678692),
(137, 22, -32.885784, -60.782375),
(138, 22, -32.920090, -60.790787),
(139, 22, -32.921387, -60.781174),
(140, 22, -32.912594, -60.777912),
(141, 22, -32.909279, -60.774994),
(142, 22, -32.896164, -60.769501),
(143, 22, -32.893425, -60.780144),
(144, 22, -32.885784, -60.778770),
(145, 23, -31.608282, -60.671730),
(146, 23, -31.607689, -60.671074),
(147, 23, -31.608391, -60.671162),
(148, 25, -31.720062, -61.092739),
(149, 25, -31.723896, -61.094028),
(150, 25, -31.724480, -61.089306),
(151, 25, -31.720137, -61.088448),
(152, 26, -31.721415, -61.091881),
(153, 26, -31.726524, -61.090466),
(154, 26, -31.721998, -61.087673),
(155, 27, -31.728897, -61.094456),
(156, 27, -31.731087, -61.094711),
(157, 27, -31.729628, -61.090851),
(158, 28, -31.724882, -61.092697),
(159, 28, -31.726213, -61.093555),
(160, 28, -31.725557, -61.091473),
(161, 29, -31.721523, -61.091022),
(162, 29, -31.723787, -61.091797),
(163, 29, -31.724007, -61.089821),
(164, 29, -31.721487, -61.089436),
(165, 30, -32.957111, -60.643459),
(166, 30, -32.958050, -60.643715),
(167, 30, -32.958340, -60.642555),
(168, 30, -32.957111, -60.642429),
(169, 31, -32.953693, -60.635391),
(170, 32, -32.954720, -60.631516),
(171, 32, -32.954647, -60.631905),
(172, 32, -32.954906, -60.631969),
(173, 32, -32.954971, -60.631603),
(174, 33, -32.957363, -60.643543),
(175, 33, -32.960320, -60.644188),
(176, 33, -32.960533, -60.641525),
(177, 33, -32.957619, -60.640797),
(178, 34, -32.952755, -60.634445),
(179, 34, -32.954376, -60.634747),
(180, 34, -32.953369, -60.632771),
(181, 35, -32.951893, -60.647148),
(182, 35, -32.953693, -60.647320),
(183, 35, -32.952358, -60.644615),
(184, 35, -32.950344, -60.641743),
(185, 35, -32.949516, -60.644917),
(186, 38, -31.725063, -61.095615),
(187, 38, -31.727291, -61.095917),
(188, 38, -31.725430, -61.093639),
(189, 40, -31.724663, -61.096088),
(190, 43, -31.728350, -61.097244),
(191, 44, -31.727985, -61.098019),
(192, 44, -31.730284, -61.098789),
(193, 45, -31.727619, -61.098534),
(194, 45, -31.730322, -61.098831),
(195, 45, -31.728716, -61.096687),
(196, 48, -31.727291, -61.089092),
(197, 48, -31.730614, -61.092953),
(198, 50, -31.725321, -61.089561),
(199, 50, -31.728788, -61.090721),
(200, 50, -31.727110, -61.087460),
(201, 51, -31.721889, -61.081924),
(202, 51, -31.723715, -61.082481),
(203, 51, -31.724115, -61.080036),
(204, 51, -31.721962, -61.079781),
(205, 52, -31.727402, -61.095741),
(206, 52, -31.730211, -61.097462),
(207, 52, -31.729591, -61.093941),
(208, 57, -31.723715, -61.096474),
(209, 58, -31.724955, -61.088577),
(210, 58, -31.729225, -61.089691),
(211, 58, -31.727402, -61.085571),
(212, 59, -31.729773, -61.097675),
(213, 59, -31.732328, -61.098877),
(214, 59, -31.730722, -61.094799),
(215, 60, -31.728605, -61.097931),
(216, 60, -31.730028, -61.098618),
(217, 60, -31.728897, -61.095573),
(218, 61, -31.724371, -61.099392),
(219, 73, -31.727219, -61.099861),
(220, 76, -31.722837, -61.109135),
(221, 76, -31.717800, -61.102695),
(222, 81, -31.728167, -61.097073),
(223, 81, -31.727802, -61.094669),
(224, 81, -31.725321, -61.094757),
(225, 81, -31.725027, -61.096989),
(226, 82, -31.724735, -61.096817),
(227, 82, -31.728897, -61.098232),
(228, 82, -31.728861, -61.094326),
(229, 82, -31.724152, -61.094196),
(230, 84, -31.724079, -61.108189),
(231, 85, -31.723860, -61.103294),
(232, 85, -31.725868, -61.105743),
(233, 85, -31.725210, -61.101406),
(234, 87, -32.954845, -60.639252),
(235, 87, -32.959671, -60.640369),
(236, 87, -32.955959, -60.635693),
(237, 88, -31.729773, -61.099648),
(238, 88, -31.732145, -61.101109),
(239, 91, -32.951389, -60.647835),
(240, 95, -32.957619, -60.647579),
(241, 105, -32.952648, -60.647835),
(242, 105, -32.957546, -60.650799),
(243, 105, -32.956394, -60.637405),
(244, 108, -32.950668, -60.648350),
(245, 108, -32.953152, -60.649338),
(246, 109, -32.952072, -60.646290),
(247, 109, -32.954990, -60.647064),
(248, 116, -32.954594, -60.637108),
(249, 116, -32.955566, -60.636333),
(250, 116, -32.954231, -60.634361),
(251, 117, -32.953548, -60.636848),
(252, 117, -32.951496, -60.626678),
(253, 117, -32.959812, -60.630199),
(254, 118, -32.953442, -60.640156),
(255, 118, -32.957474, -60.630928),
(256, 118, -32.954342, -60.627235),
(257, 119, -32.951389, -60.646851),
(258, 120, -32.952576, -60.641956),
(259, 121, -32.954990, -60.640842),
(260, 121, -32.953117, -60.631271),
(261, 121, -32.962048, -60.632645),
(262, 122, -32.952290, -60.640583),
(263, 122, -32.965790, -60.631313),
(264, 125, -33.019279, -60.884857),
(265, 125, -33.026836, -60.884815),
(266, 125, -33.026981, -60.873528),
(267, 125, -33.020935, -60.873486),
(268, 125, -33.020863, -60.866405),
(269, 125, -33.023525, -60.866318),
(270, 125, -33.023670, -60.863831),
(271, 125, -33.018234, -60.863914),
(272, 125, -33.018345, -60.873055),
(273, 125, -33.013809, -60.873142),
(274, 125, -33.013596, -60.884556),
(275, 125, -33.015430, -60.884686),
(276, 125, -33.016186, -60.904682),
(277, 125, -33.019066, -60.904770),
(278, 126, -32.939251, -60.670601),
(279, 126, -32.940601, -60.670967),
(280, 126, -32.941341, -60.666889),
(281, 126, -32.939987, -60.666504),
(282, 127, -32.951893, -60.644573),
(283, 128, -32.953510, -60.632603),
(284, 128, -32.953548, -60.645348),
(285, 128, -32.959274, -60.644100),
(286, 128, -32.951172, -60.624359),
(287, 128, -32.960896, -60.631699),
(288, 128, -32.945660, -60.620842),
(289, 128, -32.946632, -60.633457),
(290, 128, -32.953621, -60.632557),
(291, 130, -34.551636, -58.430229),
(292, 130, -34.552166, -58.430313),
(293, 130, -34.555878, -58.424606),
(294, 130, -34.559376, -58.419456),
(295, 130, -34.562061, -58.416237),
(296, 130, -34.563438, -58.414223),
(297, 130, -34.566372, -58.408382),
(298, 130, -34.566833, -58.407269),
(299, 130, -34.567116, -58.403965),
(300, 130, -34.559975, -58.409199),
(301, 130, -34.558140, -58.411648),
(302, 130, -34.555805, -58.415421),
(303, 130, -34.554108, -58.421860),
(304, 130, -34.552273, -58.427353),
(305, 130, -34.551315, -58.429413),
(306, 131, -34.582962, -58.393322),
(307, 131, -34.583740, -58.391262),
(308, 131, -34.582520, -58.390446),
(309, 132, -32.947285, -60.633862),
(310, 132, -32.947601, -60.632690),
(311, 132, -32.946915, -60.632648),
(312, 132, -32.946671, -60.633625),
(313, 133, -32.947327, -60.633865),
(314, 133, -32.946678, -60.633640),
(315, 133, -32.946938, -60.632633),
(316, 133, -32.947582, -60.632748),
(317, 134, -32.946690, -60.633602),
(318, 134, -32.947315, -60.633865),
(319, 134, -32.947582, -60.632736),
(320, 134, -32.946899, -60.632629),
(321, 135, -32.947327, -60.633869),
(322, 135, -32.946644, -60.633636),
(323, 135, -32.946903, -60.632584),
(324, 135, -32.947571, -60.632755),
(325, 136, -32.946659, -60.633614),
(326, 136, -32.947304, -60.633862),
(327, 136, -32.947594, -60.632698),
(328, 136, -32.946915, -60.632629),
(329, 137, -32.946659, -60.633595),
(330, 137, -32.947010, -60.633759),
(331, 137, -32.947075, -60.633465),
(332, 138, -32.946648, -60.633610),
(333, 138, -32.947327, -60.633884),
(334, 138, -32.947605, -60.632729),
(335, 138, -32.946907, -60.632633);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restriccion_zonavuelo`
--

CREATE TABLE IF NOT EXISTS `restriccion_zonavuelo` (
  `idrestriccion` int(11) NOT NULL AUTO_INCREMENT,
  `latitud` float(10,6) NOT NULL,
  `longitud` float(10,6) NOT NULL,
  `idvuelo` int(11) NOT NULL,
  PRIMARY KEY (`idrestriccion`),
  KEY `idvuelo` (`idvuelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=61 ;

--
-- Volcado de datos para la tabla `restriccion_zonavuelo`
--

INSERT INTO `restriccion_zonavuelo` (`idrestriccion`, `latitud`, `longitud`, `idvuelo`) VALUES
(1, -32.951317, -60.647236, 118),
(2, -32.957043, -60.647881, 118),
(3, -32.951748, -60.637966, 118),
(4, -32.954773, -60.638008, 119),
(5, -32.957474, -60.638653, 119),
(6, -32.953152, -60.643715, 120),
(7, -32.958984, -60.644276, 120),
(8, -32.955818, -60.639595, 121),
(9, -32.956142, -60.635563, 121),
(10, -32.953728, -60.648865, 122),
(11, -32.950954, -60.637451, 122),
(12, -32.958553, -60.639339, 122),
(13, -32.954773, -60.641655, 123),
(14, -32.959957, -60.642986, 123),
(15, -32.956467, -60.628483, 123),
(16, -32.955242, -60.634960, 123),
(17, -32.954086, -60.647320, 124),
(18, -32.959743, -60.646721, 124),
(19, -32.954628, -60.639767, 124),
(20, -32.955097, -60.641186, 125),
(21, -32.958698, -60.637363, 125),
(22, -32.955097, -60.638393, 125),
(23, -32.955746, -60.648224, 126),
(24, -32.959274, -60.646336, 126),
(25, -32.954845, -60.633759, 125),
(26, -32.952721, -60.641483, 127),
(27, -32.957111, -60.642429, 127),
(28, -32.953476, -60.642555, 128),
(29, -32.951206, -60.642086, 128),
(30, -32.951603, -60.639339, 128),
(31, -32.953117, -60.641010, 129),
(32, -32.954304, -60.633286, 129),
(33, -32.951714, -60.635391, 129),
(34, -32.948830, -60.667191, 130),
(35, -32.944294, -60.659294, 130),
(36, -32.943287, -60.667446, 130),
(37, -32.949730, -60.647663, 131),
(38, -32.954700, -60.647533, 131),
(39, -32.953800, -60.630112, 131),
(40, -32.954556, -60.632515, 132),
(41, -32.951172, -60.633415, 132),
(42, -32.953621, -60.638138, 132),
(43, -32.956680, -60.653759, 133),
(44, -32.965179, -60.655949, 133),
(45, -32.964890, -60.658264, 133),
(46, -32.955891, -60.655991, 133),
(47, -32.951675, -60.639168, 131),
(48, -32.948414, -60.628273, 135),
(49, -32.948627, -60.627453, 135),
(50, -32.949120, -60.627316, 135),
(51, -32.949539, -60.627514, 135),
(52, -32.949684, -60.628021, 135),
(53, -32.948338, -60.628613, 135),
(54, -32.948544, -60.648781, 134),
(55, -32.959560, -60.649551, 134),
(56, -32.954880, -60.641056, 134),
(57, -32.952106, -60.643116, 134),
(58, -32.955421, -60.641483, 136),
(59, -32.959812, -60.647663, 136),
(60, -32.960068, -60.634361, 136);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vuelo`
--

CREATE TABLE IF NOT EXISTS `tipo_vuelo` (
  `id_tipovuelo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipovuelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_vuelo`
--

INSERT INTO `tipo_vuelo` (`id_tipovuelo`, `descripcion`) VALUES
(0, 'Vuelo invalido'),
(1, 'Filmacion'),
(2, 'Mapeo/Automosaico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `mail`, `pass`, `telefono`, `nombre`) VALUES
(8, 'aaa@aaa.com', '6efaf38fc03b16ba52c99d527b1a862ecf0b939d364a75996bf39edde4c72d8f46d2d7da0ac197e40a55ca07d5f3081b7dfe20e01ff4611b3451c23add8d808c', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo`
--

CREATE TABLE IF NOT EXISTS `vuelo` (
  `idvuelo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `iddron` int(11) DEFAULT NULL,
  `tipo_vuelo` int(11) DEFAULT NULL,
  `altura_min` int(11) DEFAULT NULL,
  `altura_max` int(11) DEFAULT NULL,
  `dia` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`idvuelo`),
  KEY `iddron` (`iddron`),
  KEY `tipo_vuelo` (`tipo_vuelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=137 ;

--
-- Volcado de datos para la tabla `vuelo`
--

INSERT INTO `vuelo` (`idvuelo`, `fecha_hora`, `duracion`, `iddron`, `tipo_vuelo`, `altura_min`, `altura_max`, `dia`, `hora`) VALUES
(4, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(22, '2016-04-08 00:00:00', 1, NULL, 2, 1, 1, NULL, NULL),
(23, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(25, '2016-04-16 00:00:00', 1, NULL, 2, 1, 1, NULL, NULL),
(26, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(27, '2016-04-07 00:00:00', 1, NULL, 1, 1, 1, NULL, NULL),
(28, '2016-04-10 00:00:00', 1, NULL, 1, 2, 2, NULL, NULL),
(29, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(30, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(36, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(37, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(38, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(40, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(41, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(42, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(43, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(44, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(45, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(47, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(48, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(50, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(51, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(52, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(53, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(54, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(55, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(56, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(57, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(58, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(59, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(60, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(61, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(62, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(63, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(64, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(65, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(66, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(67, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(68, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(69, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(70, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(71, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(72, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(73, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(74, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(75, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(76, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(77, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(78, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(79, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(80, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(81, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(82, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(83, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(84, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(85, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(86, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(87, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(88, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(89, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(90, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(91, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(92, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(93, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(94, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(95, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(96, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(97, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(98, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(99, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(100, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(101, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(102, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(103, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(104, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(105, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(106, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(107, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(108, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(109, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(110, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(111, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(112, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(113, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(114, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(115, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(116, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(117, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(118, '0000-00-00 00:00:00', 30, 1, 1, 10, 15, NULL, NULL),
(119, '0000-00-00 00:00:00', 45, 1, 2, 5, 10, NULL, NULL),
(120, '0000-00-00 00:00:00', 75, 1, 2, 1, 2, NULL, NULL),
(121, NULL, 60, 1, 1, 3, 4, '0000-00-00', '17:27:00'),
(122, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(123, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(124, NULL, 15, 1, 2, 4, 4, '0000-00-00', '22:55:00'),
(125, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(126, '0000-00-00 00:00:00', 25, 1, 2, 25, 250, '0000-00-00', '09:18:00'),
(127, '0000-00-00 00:00:00', 25, 1, 1, 123, 1, '0000-00-00', '18:30:00'),
(128, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(129, '2016-05-02 11:05:00', 50, 1, 2, 25, 100, '2016-05-02', '11:05:00'),
(130, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(133, '2016-04-30 23:49:00', 50, 1, 1, 2, 10, '2016-04-30', '23:49:00'),
(134, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(135, '2016-05-02 04:30:00', 50, 1, 1, 2, 15, '2016-05-02', '04:30:00'),
(136, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dron`
--
ALTER TABLE `dron`
  ADD CONSTRAINT `dron_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `dron_vuelo` FOREIGN KEY (`idmodelo`) REFERENCES `modelo` (`idmodelo`);

--
-- Filtros para la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_marca` FOREIGN KEY (`idmarca`) REFERENCES `marca` (`idmarca`);

--
-- Filtros para la tabla `restriccion`
--
ALTER TABLE `restriccion`
  ADD CONSTRAINT `idpoligono_idrestricc` FOREIGN KEY (`idpoligono`) REFERENCES `poligono` (`idpoligono`);

--
-- Filtros para la tabla `restriccion_zonavuelo`
--
ALTER TABLE `restriccion_zonavuelo`
  ADD CONSTRAINT `restriccion_zonavuelo_ibfk_1` FOREIGN KEY (`idvuelo`) REFERENCES `vuelo` (`idvuelo`);

--
-- Filtros para la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD CONSTRAINT `vuelo_ibfk_1` FOREIGN KEY (`iddron`) REFERENCES `dron` (`id`),
  ADD CONSTRAINT `vuelo_ibfk_2` FOREIGN KEY (`tipo_vuelo`) REFERENCES `tipo_vuelo` (`id_tipovuelo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
