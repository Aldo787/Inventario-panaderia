-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2025 a las 03:28:44
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
(4, 'Creación', 'Creación de productos salados', '2025-11-18'),
(5, 'Actualización', 'Actualización de stock de productos panadería', '2025-11-20'),
(6, 'Actualización', 'Ingreso de nuevos productos de pastelería', '2025-11-21'),
(7, 'Eliminación', 'Eliminación de productos vencidos', '2025-11-22'),
(8, 'Creación', 'Creación de nueva línea de productos salados', '2025-11-23'),
(9, 'Actualización', 'Ajuste de precios por temporada', '2025-11-24'),
(10, 'Actualización', 'Reabastecimiento de productos más vendidos', '2025-11-25');

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
  `categoria` varchar(30) NOT NULL,
  `img` varchar(255) DEFAULT 'default.png',
  `limite` int(11) NOT NULL,
  `fecha_movimiento` varchar(20) NOT NULL,
  `proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `stock`, `precio`, `categoria`, `img`, `limite`, `fecha_movimiento`, `proveedor`) VALUES
(1, 'Pan Francés', 'Pan artesanal crujiente por fuera y suave por dentro', 45, 2500, 'Panadería', './productos/default.png', 20, '2025-11-25', 1),
(2, 'Croissant de Mantequilla', 'Croissant hojaldrado con mantequilla 100% natural', 32, 1800, 'Pastelería', './productos/default.png', 15, '2025-11-25', 1),
(3, 'Tarta de Manzana', 'Tarta casera con manzanas frescas y canela', 12, 12000, 'Pastelería', './productos/default.png', 8, '2025-11-25', 2),
(4, 'Empanada de Carne', 'Empanada horneada con carne molida y especias', 28, 2000, 'Salados', './productos/default.png', 25, '2025-11-25', 4),
(5, 'Pan Integral', 'Pan saludable con harina integral y semillas', 38, 3000, 'Panadería', './productos/default.png', 20, '2025-11-25', 1),
(6, 'Donas Glaseadas', 'Donas esponjosas con glaseado blanco', 24, 1500, 'Dulces', './productos/default.png', 30, '2025-11-25', 2),
(7, 'Quesadilla', 'Pan dulce tradicional con queso cremoso', 18, 2200, 'Salados', './productos/default.png', 12, '2025-11-25', 3),
(8, 'Torta de Chocolate', 'Torta húmeda con cobertura de chocolate belga', 8, 15000, 'Pastelería', './productos/default.png', 6, '2025-11-25', 2),
(9, 'Pan de Ajo', 'Pan francés con mantequilla de ajo y perejil', 22, 2800, 'Panadería', './productos/default.png', 18, '2025-11-25', 1),
(10, 'Alfajores', 'Galletas rellenas de dulce de leche y coco', 35, 1200, 'Dulces', './productos/default.png', 40, '2025-11-25', 2),
(11, 'Pan de Maíz', 'Pan tradicional hecho con harina de maíz', 15, 1900, 'Panadería', './productos/default.png', 10, '2025-11-25', 1),
(12, 'Cheesecake de Fresa', 'Cheesecake cremoso con salsa de fresas naturales', 6, 18000, 'Pastelería', './productos/default.png', 5, '2025-11-25', 3),
(13, 'Pan de Queso', 'Pan de queso brasileño recién horneado', 30, 1600, 'Salados', './productos/default.png', 25, '2025-11-25', 3),
(14, 'Palmeras de Hojaldre', 'Palmeras crujientes de hojaldre con azúcar', 42, 1300, 'Dulces', './productos/default.png', 35, '2025-11-25', 1),
(15, 'Baguette Tradicional', 'Baguette artesanal corteza crujiente', 20, 3200, 'Panadería', './productos/default.png', 15, '2025-11-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedores`
--

CREATE TABLE `provedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` int(20) NOT NULL,
  `contacto` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `estado` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provedores`
--

INSERT INTO `provedores` (`id`, `nombre`, `telefono`, `contacto`, `email`, `direccion`, `estado`) VALUES
(1, 'Harinas La Esperanza', 555123456, 'Carlos Mendoza', 'ventas@harinasesperanza.com', 'Av. Panaderos 123, Ciudad Central', 'Activo'),
(2, 'Dulces Delicias S.A.', 555987654, 'María González', 'pedidos@dulcesdelicias.com', 'Calle Dulce 456, Zona Industrial', 'Activo'),
(3, 'Lácteos Frescos Ltda.', 555456789, 'Roberto Silva', 'info@lacteosfrescos.com', 'Carretera Lechera 789, Campo Verde', 'Activo'),
(4, 'Frutas y Especias Don José', 555321987, 'José Martínez', 'contacto@frutasespecias.com', 'Mercado Central Local 15', 'Activo');

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
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `proveedor_2` (`proveedor`),
  ADD KEY `proveedor_3` (`proveedor`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

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
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `provedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
