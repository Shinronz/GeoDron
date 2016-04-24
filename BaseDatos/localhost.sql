-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-04-2016 a las 00:29:48
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
CREATE DATABASE IF NOT EXISTS `bdnasa` DEFAULT CHARACTER SET utf32 COLLATE utf32_spanish_ci;
USE `bdnasa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capa`
--

DROP TABLE IF EXISTS `capa`;
CREATE TABLE IF NOT EXISTS `capa` (
  `idcapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf32_spanish_ci NOT NULL,
  `color` varchar(7) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcapa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `capa`
--

INSERT INTO `capa` (`idcapa`, `nombre`, `color`) VALUES
(1, 'Edificio publico', '#000099');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poligono`
--

DROP TABLE IF EXISTS `poligono`;
CREATE TABLE IF NOT EXISTS `poligono` (
  `idpoligono` int(11) NOT NULL AUTO_INCREMENT,
  `idcapa` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nro_res` int(11) NOT NULL,
  PRIMARY KEY (`idpoligono`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `poligono`
--

INSERT INTO `poligono` (`idpoligono`, `idcapa`, `descripcion`, `nro_res`) VALUES
(1, 1, 'Monumento a la Bandera', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restriccion`
--

DROP TABLE IF EXISTS `restriccion`;
CREATE TABLE IF NOT EXISTS `restriccion` (
  `idrestriccion` int(11) NOT NULL AUTO_INCREMENT,
  `idpoligono` int(11) NOT NULL,
  `latitud` float(10,6) NOT NULL,
  `longitud` float(10,6) NOT NULL,
  PRIMARY KEY (`idrestriccion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `restriccion`
--

INSERT INTO `restriccion` (`idrestriccion`, `idpoligono`, `latitud`, `longitud`) VALUES
(1, 1, -32.947418, -60.630798),
(2, 1, -32.947876, -60.630939),
(3, 1, -32.948174, -60.629211),
(4, 1, -32.947742, -60.629223);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
