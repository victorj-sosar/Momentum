-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2018 a las 19:59:43
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `momentum_clothes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `dni_usuario` int(11) NOT NULL,
  `talla` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `unidades_producto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total_producto` double NOT NULL,
  `realizado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `id_producto`, `dni_usuario`, `talla`, `unidades_producto`, `fecha`, `total_producto`, `realizado`) VALUES
(1, 5, 2, '4xl', 1, '2018-05-01', 600, 1),
(2, 10, 2, 'unitalla', 1, '2018-05-01', 500, 1),
(3, 13, 2, 'unitalla', 1, '2018-05-02', 1000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `md` int(11) NOT NULL,
  `lg` int(11) NOT NULL,
  `xl` int(11) NOT NULL,
  `2xl` int(11) NOT NULL,
  `3xl` int(11) NOT NULL,
  `4xl` int(11) NOT NULL,
  `unitalla` int(11) NOT NULL,
  `precio_costo` double NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `unitalla`, `precio_costo`, `precio_venta`) VALUES
(1, 'Sudadera Crewneck lisa', 'La sudadera de cuello redondo está hecha de cómodos materiales,además viene con la funcionalidad típica de M-C: dos bolsillos laterales incrustados, que apenas se notan y se pueden cerrar con cremalleras. El bolsillo derecho está equipado con un orificio para el cable de tu auricular, por lo que se puede mantener el dispositivo seguro.<br><br>\r\nCualidades:<br><br>\r\n- 100% algodón orgánico<br>\r\n- Producción 100% justa<br>\r\n- Moda 100% ecológica<br>\r\n- 100% de textiles neutros en CO2<br>', 20, 20, 30, 30, 0, 0, 0, 300, 350),
(2, 'Playera EFfect Gris', 'La camiseta esta diseñada para experimentar tu propio efecto de movimiento libre. El logotipo EFfect está impreso en la parte delantera y el logo de la marca en la parte posterior debajo del cuello.<br><br>\r\nCualidades:<br><br>\r\n- Color: gris brezo claro<br>\r\n- Impresión: negro<br>\r\n- 95% algodón y 5% elastano<br>', 20, 20, 30, 30, 0, 0, 0, 150, 200),
(3, 'Playera Etre-Fort blanca', 'Presentamos con orgullo nuestra camiseta "Etre-fort". Viene en color blanco con el emblema ETRE-FORT impreso en negro en el frente. Así que saca tu caracter y representa ésta frase tan importante del Parkour.<br><br>\r\nCualidades:<br><br>\r\n- Color: blanco<br>\r\n- Impresión: negro<br>\r\n- 100% algodón orgánico<br>', 20, 20, 30, 30, 0, 0, 0, 150, 200),
(4, 'Pants Parkour EF-OT', 'Las características hablan por sí mismas. La funcionalidad convence a tu mente, el diseño gana su corazón. Los pantalones Parkour EF-OT se adaptan idealmente a las demandas de alta calidad y ofrecen la máxima libertad, así como una utilidad óptima.<br><br>\r\nCualidades:<br><br>\r\n- Correa clave en el bolsillo lateral<br>\r\n- Bolsillo de dinero<br>\r\n- Bolsillo del teléfono<br>\r\n- Titular de la camiseta<br>\r\n- Bolsillos laterales con cremallera<br>\r\n- 80% algodón / 20% poliéster<br>', 20, 20, 20, 20, 30, 30, 0, 500, 600),
(5, 'Pants Parkour EF-T1', 'Las características hablan por sí mismas. La funcionalidad convence a tu mente, el diseño gana su corazón. Los pantalones Parkour EF-OT se adaptan idealmente a las demandas de alta calidad y ofrecen la máxima libertad, así como una utilidad óptima.<br><br>\r\nCualidades:<br><br>\r\n- Correa clave en el bolsillo lateral<br>\r\n- Bolsillo de dinero<br>\r\n- Bolsillo del teléfono<br>\r\n- Titular de la camiseta<br>\r\n- Bolsillos laterales con cremallera<br>\r\n- 80% algodón / 20% poliéster', 20, 20, 20, 30, 30, 29, 0, 500, 600),
(6, 'Sudadera Crewneck EF', 'La sudadera de cuello redondo está hecha de cómodos materiales,además viene con la funcionalidad típica de M-C: dos bolsillos laterales incrustados, que apenas se notan y se pueden cerrar con cremalleras. El bolsillo derecho está equipado con un orificio para el cable de tu auricular, por lo que se puede mantener el dispositivo seguro.<br><br>\r\nCualidades:<br><br>\r\n- 100% algodón orgánico<br>\r\n- Producción 100% justa<br>\r\n- Moda 100% ecológica<br>\r\n- 100% de textiles neutros en CO2', 20, 20, 20, 30, 0, 0, 0, 300, 350),
(7, 'Shorts Parkour EF-S1', 'El estilo holgado brinda libertad, comodidad y se ve bien. Ya sea que estés entrenando o descansando, la funcionalidad satisface todas tus necesidades. ¡No te pierdas de su comodidad!\r\nGran versión corta de nuestros pantalones Parkour EF-T1.<br><br>\r\nCualidades:<br><br>\r\n- Color: negro<br>\r\n- Bolsillo de dinero<br>\r\n- Bolsillo del teléfono<br>\r\n- Titular de la camiseta<br>\r\n- Bolsillos laterales con cremallera<br>\r\n- Pretina de cordón<br>\r\n- 80% algodón, 20% poliéster', 20, 20, 30, 30, 0, 0, 0, 250, 300),
(8, 'Playera EF gris basic', 'El diseño de impresión en nuestro Crewneck EF fue un gran éxito, y decidimos colocarlo en una camiseta. La camiseta EF presenta un nuevo tono gris en nuestra línea, con una impresión EF negra en el frente.<br><br>\r\nCualidades:<br><br>\r\n- Color: gris brezo claro<br>\r\n- Impresión: negro<br>\r\n- 95% algodón y 5% elastano', 20, 20, 20, 30, 0, 0, 0, 150, 200),
(9, 'Playera Comfort Zone', 'La nueva camiseta de manga larga "Comfort Zone" de Parkour te mantendrá a gusto en las situaciones más intensas. Domine las circunstancias más difíciles con elegancia y sensación de comodidad.<br>Adecuado para cualquier ocasión, la camisa de manga larga viene en un corte fino con detalles sutiles. De moda, elegante, deportivo y casual.<br><br>\r\nCualidades:<br><br>\r\n- 100% algodón orgánico<br>\r\n- Moda 100% ecológica<br>\r\n- 100% de textiles neutros en CO2<br>\r\n- Color: negro<br>\r\n- Bordado: gris', 20, 20, 30, 30, 0, 0, 0, 200, 250),
(10, 'Mochila GymSack', 'La mochila perfecta para transportar desde y hacia tu práctica diaria, la GYM SACK es lo suficientemente robusta como para resistir tu duro entrenamiento de Parkour, además, es resistente al agua para mantener tu equipo seco.<br><br>\r\nCualidades:<br><br>\r\n- Color: negro<br>\r\n- Impresion: blanco<br>\r\n- Bolsillo lateral de acceso rápido con cremallera<br>\r\n- 2 asas de transporte, se pueden guardar<br>\r\n- Material robusto y resistente al agua', 0, 0, 0, 0, 0, 0, 49, 400, 500),
(11, 'Snapback Identity', 'Si amas y apoyas algo, identifícate con él. La nueva Snapback te permite hacer exactamente eso. ¡Identifícate con tu onda favorita de  ETRE-FORT! La elegante y sutil Snapback Identity tiene un aspecto relajado, pero muestra claramente aquello que representa.<br><br>\r\nCualidades:<br><br>\r\n- Color: gris claro y negro<br>\r\n- Bordado y detalles: negro', 0, 0, 0, 0, 0, 0, 50, 250, 300),
(12, 'Gorro Etre-Fort Reverse', 'El gorro reversible viene con un lado negro y otro gris, por lo que puedes cambiarlo cuando lo desees. Obten tu propio Beanie "Reverse" y ve con la corriente!<br><br>\r\nCualidades:<br><br>\r\n- Color: Negro/gris<br>\r\n- Tela: 95% algodón y 5% elastano', 0, 0, 0, 0, 0, 0, 50, 150, 200),
(13, 'Mochila Travel Tracer', 'La mochila perfecta. Simplemente elije lo que más te convenga para tu próximo viaje. El tamaño es lo suficientemente grande como para un viaje de fin de semana, sin embargo, permanece dentro de los estándares de las línes aéreas internacionales, por lo que esta es la bolsa de viajero perfecto.<br><br>\r\nCualidades:<br><br>\r\n- Bolsillos laterales con cremallera<br>\r\n- Bolsillo interno con cremallera<br>\r\n- Pequeña asa de agarre<br>\r\n- Tamaño: 30 * 25 * 60 cm', 0, 0, 0, 0, 0, 0, 49, 800, 1000),
(14, 'Pulsera  Etre-Fort THTC', 'Esta pulsera representa un entrenamiento duro pero siempre cuidándose entre sí.<br><br>\r\nCualidades:<br><br>\r\n- 100% silicona<br>\r\n- Frente: impresión verde "TRAIN HARD TAKE CARE"<br>\r\n- Atrás: impresión verde "êtrefort"<br>\r\n- Color: negro', 0, 0, 0, 0, 0, 0, 100, 40, 50),
(15, 'Boardshorts "Be Strong"', 'Los shorts "Be Strong" están hechos de un material muy elástico, asegurando que no estés restringido de ninguna manera mientras realizas tus acrobacias en la playa o para un entrenamiento duro espontáneo.<br><br>\r\nCualidades:<br><br>\r\n- Color: verde / naranja<br>\r\n- Material elástico<br>\r\n- Bolsillo lateral con llave de correa<br>\r\n- Cartera con correa<br>\r\n- 92% poliéster / 8% elastano', 20, 20, 20, 30, 0, 0, 0, 250, 300),
(16, 'Pulsera Be Strong', 'ETRE-FORT significa ser fuerte. Estas pulseras le recuerdan su compromiso constante de mantenerse siempre fuerte y no darse por vencido.<br><br>\r\nCualidades:<br><br>\r\n- 100% silicona<br>\r\n- Frente: impresión blanca "SER FUERTE"<br>\r\n- Atras: impresión blanca "êtrefort"<br>\r\n- Color: negro', 0, 0, 0, 0, 0, 0, 100, 40, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `paterno` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `materno` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `last_sesion` datetime DEFAULT NULL,
  `activacion` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `token_password` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password_request` int(11) DEFAULT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `paterno`, `materno`, `direccion`, `correo`, `usuario`, `password`, `last_sesion`, `activacion`, `token`, `token_password`, `password_request`, `id_tipo`) VALUES
(1, 'Victor Jesus', 'Sosa', 'Reyes', 'Hermenegildo Galeana#39 Col. Juan Morales Yecapixtla, Morelos', 'victorsosa146@gmail.com', 'victor_sr', '$2y$10$cDMr1g5LuwMxZ6g./QyobOTEJFoQ9NQr7qbrX5kloSGfSOMrGVk26', '2018-05-02 12:49:51', 1, 'b6c50a22ce24279d641c25792555a0ad', '', 0, 1),
(2, 'Victor', 'Sosa', 'Cuevas', 'Hermenegildo Galeana#39 Col. Juan Morales Yecapixtla, Morelos', 'vicdarkus_sosa@hotmail.com', 'victor_sc', '$2y$10$za3tBx5V6t9OsM.w3XRzjOYPxan2ePfDkMQUxn5lao94UQWV7jmcG', '2018-05-02 12:53:33', 1, 'ec12d794b2e076a11eeebd425072bf5b', '', 0, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `dni_usuario` (`dni_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`dni_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
