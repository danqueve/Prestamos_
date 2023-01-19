-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2023 a las 02:37:35
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u335739870_amigos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `id` int(9) NOT NULL,
  `nombre` varchar(900) NOT NULL,
  `importe` int(9) NOT NULL,
  `transferencia` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `observacion` varchar(900) NOT NULL,
  `cheque` varchar(90) NOT NULL,
  `importecheque` int(9) NOT NULL,
  `tipo` varchar(90) NOT NULL,
  `usuario` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(9) NOT NULL,
  `detalle` varchar(900) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `observacion` varchar(900) NOT NULL,
  `tipo` varchar(90) NOT NULL,
  `usuario` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja2`
--

CREATE TABLE `caja2` (
  `id` int(9) NOT NULL,
  `detalle` varchar(900) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `observacion` varchar(900) NOT NULL,
  `tipo` varchar(90) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `idmes` int(9) NOT NULL,
  `idcobro` int(9) NOT NULL,
  `idpago` int(9) NOT NULL,
  `idfactura` int(9) NOT NULL,
  `idprestamo` int(9) NOT NULL,
  `idinversion` int(9) NOT NULL,
  `idfacturai` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja2`
--

INSERT INTO `caja2` (`id`, `detalle`, `importe`, `fecha`, `fechasql`, `observacion`, `tipo`, `usuario`, `idmes`, `idcobro`, `idpago`, `idfactura`, `idprestamo`, `idinversion`, `idfacturai`) VALUES
(1, 'Prestamo NÂ°:1', -10000, '23-11-2022', '2022-11-23', 'cliente:QUEVEDO,DANIEL', 'EGRESO', '', 0, 0, 0, 0, 1, 0, 0),
(2, 'Pago cuota/s Prestamo NÂ°:1', 2500, '23-11-2022', '2022-11-23', 'cliente:QUEVEDO,DANIEL', 'INGRESO', '', 0, 0, 0, 1, 1, 0, 0),
(4, 'Pago cuota/s Prestamo NÂ°:1', 5000, '25-11-2022', '2022-11-25', 'cliente:QUEVEDO,DANIEL', 'INGRESO', '', 0, 0, 0, 2, 1, 0, 0),
(5, 'Pago cuota/s Prestamo NÂ°:1', 5000, '25-11-2022', '2022-11-25', 'cliente:QUEVEDO,DANIEL', 'INGRESO', '', 0, 0, 0, 3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claves`
--

CREATE TABLE `claves` (
  `id` int(9) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `clave` varchar(90) NOT NULL,
  `rol` varchar(90) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `claves`
--

INSERT INTO `claves` (`id`, `usuario`, `clave`, `rol`) VALUES
(1, 'admin', 'admin', 'ADMINISTRADOR'),
(11, 'mohamed', '123456', 'ADMINISTRADOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(9) NOT NULL,
  `apellido` varchar(90) NOT NULL,
  `nombre` varchar(90) NOT NULL,
  `dni` varchar(90) NOT NULL,
  `edad` varchar(90) NOT NULL,
  `fechanac` varchar(90) NOT NULL,
  `telefono` varchar(90) NOT NULL,
  `email` varchar(90) NOT NULL,
  `direccion` varchar(90) NOT NULL,
  `ciudad` varchar(90) NOT NULL,
  `observacion` varchar(90) NOT NULL,
  `referencia` varchar(200) NOT NULL,
  `telefonoref` varchar(90) NOT NULL,
  `relacion` varchar(90) NOT NULL,
  `estadocivil` varchar(90) NOT NULL,
  `provincia` varchar(90) NOT NULL,
  `limite` int(9) NOT NULL,
  `fechanacsql` date NOT NULL,
  `sueldo` varchar(90) NOT NULL,
  `trabajo` varchar(200) NOT NULL,
  `telefonotrabajo` varchar(90) NOT NULL,
  `entrecalles` varchar(200) NOT NULL,
  `cp` int(9) NOT NULL,
  `celular` varchar(90) NOT NULL,
  `direccione` varchar(90) NOT NULL,
  `ciudade` varchar(90) NOT NULL,
  `telefono2` varchar(90) NOT NULL,
  `interno` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `apellido`, `nombre`, `dni`, `edad`, `fechanac`, `telefono`, `email`, `direccion`, `ciudad`, `observacion`, `referencia`, `telefonoref`, `relacion`, `estadocivil`, `provincia`, `limite`, `fechanacsql`, `sueldo`, `trabajo`, `telefonotrabajo`, `entrecalles`, `cp`, `celular`, `direccione`, `ciudade`, `telefono2`, `interno`) VALUES
(1, 'quevedo', 'daniel', '31.812.857', '', '10-09-1985', '3815096109', 'danqueve@gmail.com', 'octaviano vera 845', 'tucuman', '', '', '', '', 'tucumÃ¡n', 'tucuman', 780000, '1985-09-10', '65000', '', '', '', 4000, '', '', '', '', ''),
(2, 'fernandez', 'nomra', '17.619.302', '', '26-05-1966', '11111111', '', '', '', '', '', '', '', '', '', 600000, '1966-05-26', '', '', '', '', 0, '', '', '', '', ''),
(3, 'quevedo', 'florencia', '34.111.111', '', '14-12-1989', '1', '', 'vera 845', 'tucuman', '', '', '', '', '', 'tucuman', 600000, '1989-12-14', '', '', '', '', 0, '1', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` int(9) NOT NULL,
  `idprestamo` int(9) NOT NULL,
  `idcliente` int(9) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `interes` int(9) NOT NULL,
  `fechasql` date NOT NULL,
  `cuota` int(11) NOT NULL,
  `observacion` varchar(900) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `ncuota` int(9) NOT NULL,
  `cobrador` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`id`, `idprestamo`, `idcliente`, `importe`, `fecha`, `interes`, `fechasql`, `cuota`, `observacion`, `usuario`, `ncuota`, `cobrador`) VALUES
(1, 1, 1, 2500, '23-11-2022', 0, '2022-11-23', 1, '', '', 0, ''),
(2, 1, 1, 5000, '25-11-2022', 0, '2022-11-25', 2, '', '', 0, ''),
(3, 1, 1, 5000, '25-11-2022', 0, '2022-11-25', 2, '', '', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros2`
--

CREATE TABLE `cobros2` (
  `id` int(9) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechasql` date NOT NULL,
  `idcontribuyente` int(9) NOT NULL,
  `apellido` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(900) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante` int(9) NOT NULL,
  `idinfraccion` int(9) NOT NULL,
  `idcarnet` int(9) NOT NULL,
  `idcomercio` int(9) NOT NULL,
  `detalle` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idautomotor` int(9) NOT NULL,
  `inspector` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contribuyentes`
--

CREATE TABLE `contribuyentes` (
  `id` int(9) NOT NULL,
  `apellido` varchar(90) NOT NULL,
  `nombre` varchar(90) NOT NULL,
  `dni` varchar(90) NOT NULL,
  `direccion` varchar(90) NOT NULL,
  `fechanac` varchar(90) NOT NULL,
  `fechanacsql` date NOT NULL,
  `gruposanguineo` varchar(9) NOT NULL,
  `foto` varchar(90) NOT NULL,
  `nacionalidad` varchar(90) NOT NULL,
  `estadocivil` varchar(90) NOT NULL,
  `frh` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contribuyentes`
--

INSERT INTO `contribuyentes` (`id`, `apellido`, `nombre`, `dni`, `direccion`, `fechanac`, `fechanacsql`, `gruposanguineo`, `foto`, `nacionalidad`, `estadocivil`, `frh`) VALUES
(1, 'quevedo', 'daniel', '31.812.857', 'vera 845', '', '0000-00-00', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int(9) NOT NULL,
  `idprestamo` int(9) NOT NULL,
  `idcliente` int(9) NOT NULL,
  `cuota` int(9) NOT NULL,
  `monto` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `estado` varchar(90) NOT NULL,
  `observacion` varchar(90) NOT NULL,
  `porlasdudas` varchar(90) NOT NULL,
  `idcobro` int(9) NOT NULL,
  `interes` int(9) NOT NULL,
  `original` int(9) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `motivo` varchar(90) NOT NULL,
  `mora` int(9) NOT NULL,
  `totalconmora` int(9) NOT NULL,
  `totalfinal` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `idprestamo`, `idcliente`, `cuota`, `monto`, `fecha`, `fechasql`, `estado`, `observacion`, `porlasdudas`, `idcobro`, `interes`, `original`, `usuario`, `motivo`, `mora`, `totalconmora`, `totalfinal`) VALUES
(1, 1, 1, 1, 0, '01-12-2022', '2022-12-01', 'PAGADA', '', '', 0, 0, 2500, '', '', 0, 0, 0),
(2, 1, 1, 2, 0, '08-12-2022', '2022-12-08', 'PAGADA', '', '', 0, 0, 2500, '', '', 0, 0, 0),
(3, 1, 1, 3, 0, '15-12-2022', '2022-12-15', 'PAGADA', '', '', 0, 0, 2500, '', '', 0, 0, 0),
(4, 1, 1, 4, 0, '22-12-2022', '2022-12-22', 'PAGADA', '', '', 3, 0, 2500, '', '', 0, 0, 0),
(5, 1, 1, 5, 0, '29-12-2022', '2022-12-29', 'PAGADA', '', '', 3, 0, 2500, '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `id` int(9) NOT NULL,
  `interes` int(9) NOT NULL,
  `pordia` double NOT NULL,
  `unpago` int(9) NOT NULL,
  `dospagos` int(9) NOT NULL,
  `trespagos` int(9) NOT NULL,
  `sistema` varchar(900) NOT NULL,
  `comisionv` int(9) NOT NULL,
  `comisionc` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`id`, `interes`, `pordia`, `unpago`, `dospagos`, `trespagos`, `sistema`, `comisionv`, `comisionc`) VALUES
(1, 240, 1, 240, 20, 600000, '<H2>IMPERIO COMERCIALES</H2>', 30, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(9) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechasql` date NOT NULL,
  `idcontribuyente` int(9) NOT NULL,
  `apellido` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(900) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante` int(9) NOT NULL,
  `idinfraccion` int(9) NOT NULL,
  `idcarnet` int(9) NOT NULL,
  `idcomercio` int(9) NOT NULL,
  `detalle` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idautomotor` int(9) NOT NULL,
  `inspector` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `importe`, `fecha`, `fechasql`, `idcontribuyente`, `apellido`, `nombre`, `dni`, `tipo`, `observacion`, `comprobante`, `idinfraccion`, `idcarnet`, `idcomercio`, `detalle`, `mes`, `idautomotor`, `inspector`, `estado`) VALUES
(1, 2500, '23-11-2022', '2022-11-23', 1, 'quevedo', 'daniel', '31.812.857', '', '', 1, 0, 0, 0, '', '', 0, '', 'ANULADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(9) NOT NULL,
  `idcliente` int(9) NOT NULL,
  `monto` int(9) NOT NULL,
  `interes` int(9) NOT NULL,
  `cuota` int(9) NOT NULL,
  `montofinal` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `observacion` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `estado` varchar(90) NOT NULL,
  `observ` varchar(900) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `vendedor` varchar(90) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `idcliente`, `monto`, `interes`, `cuota`, `montofinal`, `fecha`, `observacion`, `fechasql`, `estado`, `observ`, `usuario`, `vendedor`) VALUES
(1, 1, 10000, 240, 5, 12500, '23-11-2022', 'VENTILADOR', '2022-11-23', 'CANCELADO', '', '', 'DAVID');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reimpresion`
--

CREATE TABLE `reimpresion` (
  `id` int(9) NOT NULL,
  `idprestamo` int(9) NOT NULL,
  `idcliente` int(9) NOT NULL,
  `importe` int(9) NOT NULL,
  `fecha` varchar(90) NOT NULL,
  `fechasql` date NOT NULL,
  `cuota` int(9) NOT NULL,
  `interes` int(9) NOT NULL,
  `total` int(9) NOT NULL,
  `idcobro` int(9) NOT NULL,
  `idcuota` int(9) NOT NULL,
  `observacion` varchar(90) NOT NULL,
  `usuario` varchar(90) NOT NULL,
  `bandera` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reimpresion`
--

INSERT INTO `reimpresion` (`id`, `idprestamo`, `idcliente`, `importe`, `fecha`, `fechasql`, `cuota`, `interes`, `total`, `idcobro`, `idcuota`, `observacion`, `usuario`, `bandera`) VALUES
(1, 1, 1, 2500, '23-11-2022', '2022-11-23', 1, 0, 2500, 1, 1, '', '', 1),
(2, 1, 1, 2500, '25-11-2022', '2022-11-25', 2, 0, 2500, 2, 2, '', '', 1),
(3, 1, 1, 2500, '25-11-2022', '2022-11-25', 3, 0, 2500, 2, 3, '', '', 1),
(4, 1, 1, 2500, '25-11-2022', '2022-11-25', 4, 0, 2500, 3, 4, '', '', 1),
(5, 1, 1, 2500, '25-11-2022', '2022-11-25', 5, 0, 2500, 3, 5, '', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja2`
--
ALTER TABLE `caja2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `claves`
--
ALTER TABLE `claves`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cobros2`
--
ALTER TABLE `cobros2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contribuyentes`
--
ALTER TABLE `contribuyentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reimpresion`
--
ALTER TABLE `reimpresion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `caja2`
--
ALTER TABLE `caja2`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `claves`
--
ALTER TABLE `claves`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cobros2`
--
ALTER TABLE `cobros2`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `contribuyentes`
--
ALTER TABLE `contribuyentes`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `reimpresion`
--
ALTER TABLE `reimpresion`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
