-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2017 a las 00:12:26
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `e-mer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agregacion`
--

CREATE TABLE `agregacion` (
  `Nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asc_cursos_temas_subtemas_ejercicios`
--

CREATE TABLE `asc_cursos_temas_subtemas_ejercicios` (
  `nombre_curso` varchar(50) NOT NULL,
  `nombre_tema` varchar(20) NOT NULL,
  `nombre_subtema` varchar(20) NOT NULL,
  `nombre_ejercicio` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributo_multivaluado`
--

CREATE TABLE `atributo_multivaluado` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributo_simple`
--

CREATE TABLE `atributo_simple` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `esPK` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_cursos`
--

CREATE TABLE `dim_cursos` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `anio` int(11) NOT NULL,
  `horario` varchar(9) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `profesor` varchar(50) NOT NULL,
  `ind_activo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dim_cursos`
--

INSERT INTO `dim_cursos` (`id_curso`, `nombre`, `anio`, `horario`, `fecha_inicio`, `fecha_fin`, `profesor`, `ind_activo`) VALUES
(5, 'ATI 2017 18-20', 2017, '20-22', '2017-05-30', '2017-07-17', 'Enrique Abella', 0),
(6, 'Lic 2017 09-13', 2017, '09-13', '2017-05-30', '2017-07-18', 'Enrique Abella', 0),
(7, 'Ing 2017 18-22', 2017, '18-22', '2017-05-30', '2017-07-19', 'Enrique Abella', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_ejercicios`
--

CREATE TABLE `dim_ejercicios` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  `solucion_sistema` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_subtemas`
--

CREATE TABLE `dim_subtemas` (
  `id_sub_tema` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_temas`
--

CREATE TABLE `dim_temas` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_usuarios`
--

CREATE TABLE `dim_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `ci` char(8) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
  `apellido` varchar(50) CHARACTER SET latin1 NOT NULL,
  `sexo` char(1) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `clave` varchar(50) CHARACTER SET latin1 NOT NULL,
  `telefono` char(8) CHARACTER SET latin1 NOT NULL,
  `celular` char(9) CHARACTER SET latin1 NOT NULL,
  `curso` varchar(50) CHARACTER SET latin1 NOT NULL,
  `categoria_usuario` enum('alumno','administrativo','profesor') CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_usuarios`
--

INSERT INTO `dim_usuarios` (`id_usuario`, `ci`, `nombre`, `apellido`, `sexo`, `email`, `clave`, `telefono`, `celular`, `curso`, `categoria_usuario`) VALUES
(17, '40269733', 'Heny', 'Prfos', 'F', 'eabella@adinet.com.uy', '072a212d274af36f760355b60ed41d81', '23546666', '091555555', 'Ing 2017 18-22\n', 'profesor'),
(16, '12345687', 'Enrique', 'Abella', 'M', 'eabella@adinet.com.uy', '95d47be0d380a7cd3bb5bbe78e8bed49', '23546666', '091555555', 'Ing 2017 18-22', 'profesor'),
(15, '12345665', 'Enrique', 'Abella', 'M', 'eabella@adinet.com.uy', 'd2322484d96897dca51bef5dc8126ef2', '23546666', '091555555', 'Lic 2017 09-13', 'profesor'),
(14, '40269733', 'Ale', 'Varcasia', 'M', 'eabella@adinet.com.uy', '072a212d274af36f760355b60ed41d81', '23546666', '091555555', 'ATI 2017 20-22', 'profesor'),
(18, '12345665', 'Heny', 'Prfos', 'F', 'eabella@adinet.com.uy', 'd2322484d96897dca51bef5dc8126ef2', '23546666', '091555555', 'Ing 2017 18-22\n', 'profesor'),
(19, '12345687', 'Ale', 'Varcasia', 'M', 'eabella@adinet.com.uy', '95d47be0d380a7cd3bb5bbe78e8bed49', '23546666', '091555555', 'ATI 2017 20-22', 'profesor'),
(20, '89513218', 'Pepe', 'Tito', 'M', 'pepe@hotmail', 'f9a57f3771a1f7292ad580da9ae1f165', '6588', '6878', '54689898', 'profesor'),
(21, '', '', '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'profesor'),
(22, '1234555', 'Henry', 'Foth', 'M', 'henry.foth.m@gmail.com', 'cb5e35fe0160c0a3439ecec60523ff30', '23546772', '091320029', 'ATI 2017 20-22', 'alumno'),
(23, '7654321', 'Alejandro', 'Varcasia', 'M', 'alemartin2014@hotmail.com', 'f0898af949a373e72a4f6a34b4de9090', '23546184', '099456158', 'Lic 2017 09-13', 'alumno'),
(24, '123654', 'Rodrigo', 'Perez', 'M', 'rperez9594@gmail.com', '733d7be2196ff70efaf6913fc8bdcabf', '25487655', '094315648', 'Ing 2017 18-22', 'alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_subtipo`
--

CREATE TABLE `entidad_subtipo` (
  `Nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_supertipo`
--

CREATE TABLE `entidad_supertipo` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidadesSubtipos` longtext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mer`
--

CREATE TABLE `mer` (
  `Nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colRelaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAgregaciones` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion`
--

CREATE TABLE `relacion` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadA` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadB` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `cardinalidadA` int(2) NOT NULL,
  `cardinalidadB` int(2) NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asc_cursos_temas_subtemas_ejercicios`
--
ALTER TABLE `asc_cursos_temas_subtemas_ejercicios`
  ADD PRIMARY KEY (`nombre_curso`,`nombre_tema`,`nombre_subtema`,`nombre_ejercicio`);

--
-- Indices de la tabla `dim_cursos`
--
ALTER TABLE `dim_cursos`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `dim_ejercicios`
--
ALTER TABLE `dim_ejercicios`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `UNIQUE` (`id_ejercicio`);

--
-- Indices de la tabla `dim_subtemas`
--
ALTER TABLE `dim_subtemas`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `UNIQUE` (`id_sub_tema`);

--
-- Indices de la tabla `dim_temas`
--
ALTER TABLE `dim_temas`
  ADD PRIMARY KEY (`nombre`) USING BTREE,
  ADD UNIQUE KEY `UNIQUE` (`id_tema`);

--
-- Indices de la tabla `dim_usuarios`
--
ALTER TABLE `dim_usuarios`
  ADD PRIMARY KEY (`ci`,`nombre`,`apellido`,`curso`),
  ADD UNIQUE KEY `UNIQUE` (`id_usuario`) USING BTREE,
  ADD KEY `FK_curso` (`curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dim_cursos`
--
ALTER TABLE `dim_cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `dim_ejercicios`
--
ALTER TABLE `dim_ejercicios`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dim_subtemas`
--
ALTER TABLE `dim_subtemas`
  MODIFY `id_sub_tema` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dim_temas`
--
ALTER TABLE `dim_temas`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dim_usuarios`
--
ALTER TABLE `dim_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
