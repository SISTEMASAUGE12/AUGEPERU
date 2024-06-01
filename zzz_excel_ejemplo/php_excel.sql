-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2017 a las 03:38:17
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `php_excel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excel`
--

CREATE TABLE `excel` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `carrera` varchar(150) NOT NULL,
  `edad` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `excel`
--

INSERT INTO `excel` (`id`, `nombres`, `apellidos`, `genero`, `carrera`, `edad`, `email`, `activo`) VALUES
(1, 'Juan Carlos', 'Flores', 'Masculino', 'Computacion', '21', 'juan@micorreo.com', 1),
(2, 'Maria', 'Ugarte', 'Femenino', 'Contabilidad', '19', 'maria@micorreo.com', 1),
(3, 'Vanessa', 'Torres', 'Femenino', 'Computacion', '17', 'Vanessa@micorreo.com', 1),
(4, 'Juan Carlos', 'Flores', 'Masculino', 'Computacion', '21', 'juan@micorreo.com', 1),
(5, 'Maria', 'Ugarte', 'Femenino', 'Contabilidad', '19', 'maria@micorreo.com', 1),
(6, 'Vanessa', 'Torres', 'Femenino', 'Computacion', '17', 'Vanessa@micorreo.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `excel`
--
ALTER TABLE `excel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `excel`
--
ALTER TABLE `excel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
