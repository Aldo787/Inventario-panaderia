-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2025 a las 06:33:31
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
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `movimiento` varchar(50) DEFAULT '"Creación","Actualización", "Eliminación"',
  `descripcion` text NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `movimiento`, `descripcion`, `fecha`) VALUES
(1, 'Creación', 'Creación de productos de panadería', '2025-11-18'),
(2, 'Creación', 'Creación de productos de pastelería', '2025-11-18'),
(3, 'Creación', 'Creación de productos dulces', '2025-11-18'),
(4, 'Creación', 'Creación de productos salados', '2025-11-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `descripcion` text NOT NULL,
  `stock` int(25) NOT NULL,
  `precio` int(25) NOT NULL,
  `movimiento` int(11) NOT NULL,
  `provedor` int(11) NOT NULL,
  `fecha_movimiento` varchar(20) DEFAULT NULL,
  `categoria` varchar(30) NOT NULL,
  `img` varchar(255) DEFAULT 'default.png',
  `limite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `stock`, `precio`, `movimiento`, `provedor`, `fecha_movimiento`, `categoria`, `img`, `limite`) VALUES
(1, 'Pan Blanco', 'Pan blanco tradicional', 14, 5, 1, 1, '2025-11-18', 'Pan', 'default.png', 20),
(2, 'Pan Integral', 'Pan integral con semillas', 10, 7, 1, 1, '2025-11-18', 'Pan', 'default.png', 18),
(3, 'Baguette', 'Pan francés crujiente', 22, 8, 1, 1, '2025-11-18', 'Pan', 'default.png', 20),
(4, 'Croissant', 'Croissant de mantequilla', 6, 12, 1, 1, '2025-11-18', 'Pastelería', 'default.png', 12),
(5, 'Donas', 'Donas glaseadas', 12, 10, 3, 3, '2025-11-18', 'Dulces', 'default.png', 15),
(6, 'Pastel de Chocolate', 'Torta de chocolate negro', 5, 45, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 8),
(7, 'Galletas de Avena', 'Galletas con avena y pasas', 30, 8, 3, 3, '2025-11-18', 'Galletas', 'default.png', 25),
(8, 'Pan de Centeno', 'Pan de centeno alemán', 11, 9, 1, 1, '2025-11-18', 'Pan', 'default.png', 14),
(9, 'Empanadas de Carne', 'Empanadas de carne jugosa', 20, 15, 4, 4, '2025-11-18', 'Salados', 'default.png', 16),
(10, 'Tarta de Manzana', 'Tarta con manzanas frescas', 4, 35, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 7),
(11, 'Pan de Maíz', 'Pan dulce de maíz', 13, 6, 1, 1, '2025-11-18', 'Pan', 'default.png', 15),
(12, 'Rosquillas', 'Rosquillas azucaradas', 18, 8, 3, 3, '2025-11-18', 'Dulces', 'default.png', 20),
(13, 'Pan de Ajo', 'Pan con ajo y perejil', 9, 10, 4, 4, '2025-11-18', 'Salados', 'default.png', 17),
(14, 'Cheesecake', 'Tarta de queso New York', 3, 50, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 5),
(15, 'Pan de Pasas', 'Pan dulce con pasas', 12, 8, 1, 1, '2025-11-18', 'Pan', 'default.png', 12),
(16, 'Palmeras de Chocolate', 'Hojaldre con chocolate', 8, 12, 3, 3, '2025-11-18', 'Dulces', 'default.png', 14),
(17, 'Pan de Queso', 'Pan relleno de queso', 21, 11, 4, 4, '2025-11-18', 'Salados', 'default.png', 18),
(18, 'Tarta de Limón', 'Tarta refrescante de limón', 4, 38, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 6),
(19, 'Pan Multicereal', 'Pan con múltiples cereales', 9, 9, 1, 1, '2025-11-18', 'Pan', 'default.png', 10),
(20, 'Brownies', 'Brownies de chocolate intenso', 28, 15, 3, 3, '2025-11-18', 'Dulces', 'default.png', 22),
(21, 'Pizza Pequeña', 'Pizza individual', 11, 25, 4, 4, '2025-11-18', 'Salados', 'default.png', 13),
(22, 'Pan de Banana', 'Pan de banana y nueces', 15, 10, 1, 1, '2025-11-18', 'Pan', 'default.png', 16),
(23, 'Alfajores', 'Galletas rellenas de dulce de leche', 19, 18, 3, 3, '2025-11-18', 'Dulces', 'default.png', 20),
(24, 'Pan de Olivas', 'Pan con olivas negras', 12, 11, 4, 4, '2025-11-18', 'Salados', 'default.png', 14),
(25, 'Tarta de Frutas', 'Tarta con frutas frescas', 5, 42, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 7),
(26, 'Pan Rústico', 'Pan rústico campesino', 10, 7, 1, 1, '2025-11-18', 'Pan', 'default.png', 15),
(27, 'Muffins de Arándanos', 'Muffins con arándanos azules', 16, 13, 3, 3, '2025-11-18', 'Dulces', 'default.png', 18),
(28, 'Pan de Cebolla', 'Pan con cebolla caramelizada', 7, 12, 4, 4, '2025-11-18', 'Salados', 'default.png', 13),
(29, 'Tarta de Zanahoria', 'Tarta de zanahoria con nueces', 4, 40, 2, 3, '2025-11-18', 'Pasteles', 'default.png', 6),
(30, 'Pan de Calabaza', 'Pan dulce de calabaza', 9, 9, 1, 1, '2025-11-18', 'Pan', 'default.png', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedores`
--

CREATE TABLE `provedores` (
  `id` int(11) NOT NULL,
  `nombre_provedor` varchar(100) NOT NULL,
  `telefono` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provedores`
--

INSERT INTO `provedores` (`id`, `nombre_provedor`, `telefono`) VALUES
(1, 'Panadería Central S.A.', 5551001),
(2, 'Harinas Premium S.A.', 5551002),
(3, 'Dulces y Pasteles S.A.', 5551003),
(4, 'Ingredientes Naturales S.A.', 5551004);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimiento` (`movimiento`),
  ADD KEY `provedor` (`provedor`);

--
-- Indices de la tabla `provedores`
--
ALTER TABLE `provedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `provedores`
--
ALTER TABLE `provedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`provedor`) REFERENCES `provedores` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`movimiento`) REFERENCES `movimientos` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
