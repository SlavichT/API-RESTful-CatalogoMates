-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2024 a las 00:22:37
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
-- Base de datos: `catalogomates`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `material_fabricacion` varchar(50) NOT NULL,
  `descripcion` varchar(510) NOT NULL,
  `requiere_curado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `material_fabricacion`, `descripcion`, `requiere_curado`) VALUES
(1, 'Calabaza', 'Es el tipo de mate más tradicional, hecho a partir del fruto seco de la calabaza. Su interior se cura para absorber los sabores de la yerba y potenciar la experiencia del mate. Tiene un diseño rústico y natural, siendo valorado por los puristas del mate.', 1),
(2, 'Madera', 'Hecho de maderas como algarrobo o palo santo, este tipo de mate tiene un aroma particular que se mezcla con el sabor de la yerba. Debe ser curado antes de su uso, y con el tiempo, adquiere una pátina que intensifica su carácter único.', 1),
(3, 'Vidrio', 'Este mate tiene un cuerpo de vidrio, generalmente cubierto por una funda de cuero. El vidrio no altera el sabor de la yerba, por lo que es ideal para quienes prefieren un sabor puro y fresco. Además, es fácil de limpiar y no necesita ser curado.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_mate` int(11) NOT NULL,
  `nombre_mate` varchar(255) NOT NULL,
  `forma_mate` varchar(255) NOT NULL,
  `imagen` varchar(510) NOT NULL,
  `recubrimiento_mate` varchar(50) NOT NULL,
  `color_mate` varchar(255) NOT NULL,
  `id_categoria_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_mate`, `nombre_mate`, `forma_mate`, `imagen`, `recubrimiento_mate`, `color_mate`, `id_categoria_fk`) VALUES
(5, 'Mate escuirol', 'Imperial', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9368-4370cd752e2375a44516987629639789-1024-1024.jpeg', 'Cuero natural', 'marron', 2),
(12, 'Mate calavera', 'Torpedo', 'https://acdn.mitiendanube.com/stores/942/536/products/calavera11-1ca3f197da940d247116187157038750-1024-1024.webp', 'Cuero natural', 'Negro', 2),
(14, 'Mate Clásico', 'Imperial', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9368-4370cd752e2375a44516987629639789-1024-1024.jpeg', 'Cuero natural', 'Negro', 2),
(15, 'Mate Elegante', 'Torpedo', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9376_jpg-a11ecf50788d52680716987627000158-1024-1024.webp', 'Cuero sintético', 'Marrón', 2),
(16, 'Mate Clásico Uruguayo', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Rojo', 3),
(18, 'Mate de Estilo', 'Torpedo', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9376_jpg-a11ecf50788d52680716987627000158-1024-1024.webp', 'Cuero sintético', 'Negro', 2),
(19, 'Mate del Sur', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Azul', 3),
(20, 'Mate Sobrio', 'Imperial', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9368-4370cd752e2375a44516987629639789-1024-1024.jpeg', 'Cuero sintético', 'Gris', 1),
(21, 'Mate Moderno', 'Torpedo', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9376_jpg-a11ecf50788d52680716987627000158-1024-1024.webp', 'Cuero natural', 'Blanco', 2),
(22, 'Mate de Uruguay', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Amarillo', 3),
(23, 'Mate Especial', 'Imperial', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9368-4370cd752e2375a44516987629639789-1024-1024.jpeg', 'Cuero natural', 'Violeta', 1),
(24, 'Mate de la Pampa', 'Torpedo', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9376_jpg-a11ecf50788d52680716987627000158-1024-1024.webp', 'Cuero sintético', 'Naranja', 2),
(27, 'Mate EDITADO desde API', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'ROJO', 2),
(28, 'Mate AGREGADO desde API', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Negro', 1),
(29, 'Mate AGREGADO desde API', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Negro', 1),
(30, 'Mate MODIFICADO desde API 3', 'Camionero', 'https://estiloaustral.com/wp-content/uploads/2023/03/MATE0052-MATE-CAMIONERO-URUGUAYO-1.png', 'Cuero natural', 'Azul', 3),
(31, 'Mate EDITADO desde API test FINAL', 'Torpedo', 'https://acdn.mitiendanube.com/stores/001/143/953/products/img_9376_jpg-a11ecf50788d52680716987627000158-1024-1024.webp', 'Cuero natural', 'AZUL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`) VALUES
(1, 'webadmin', '$2y$10$.WoEuCMaMPTfNhJmqba.yeseGNBtlL8wIPcix0BGg3sUbimlBhety');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_mate`),
  ADD KEY `id_categoria_fk` (`id_categoria_fk`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_mate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `id_categoria_fk` FOREIGN KEY (`id_categoria_fk`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
