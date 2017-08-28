-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2017 a las 22:08:13
-- Versión del servidor: 5.7.14
-- Versión de PHP: 7.0.10

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
-- Estructura de tabla para la tabla `asc_curso_tema_subtema_ejercicio`
--

CREATE TABLE `asc_curso_tema_subtema_ejercicio` (
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_tema` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_subtema` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_ejercicio` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asc_curso_tema_subtema_ejercicio`
--

INSERT INTO `asc_curso_tema_subtema_ejercicio` (`nombre_curso`, `nombre_tema`, `nombre_subtema`, `nombre_ejercicio`) VALUES
('ATI 2017 20-22', 'Entidades', 'Atributos Complejos', 'PerroCucha'),
('ATI 2017 20-22', 'Atributos', 'Atributos Simples', 'PerroCucha'),
('ATI 2017 20-22', 'Atributos', 'Atributos Multivaluados', 'PerroCucha'),
('ATI 2017 20-22', 'Entidades Debiles', 'Atributos Complejos', 'PerroCucha'),
('ATI 2017 20-22', 'Relaciones', 'Relacion con Atributos', 'PerroCucha'),
('ATI 2017 20-22', 'Autorelacion', 'Atributos Complejos', 'PerroCucha'),
('ATI 2017 20-22', 'Categorizacion ', 'Categorizacion Completa', 'PerroCucha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asc_curso_usuario`
--

CREATE TABLE `asc_curso_usuario` (
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asc_curso_usuario`
--

INSERT INTO `asc_curso_usuario` (`nombre_curso`, `nombre_usuario`, `apellido_usuario`) VALUES
('ATI 2017 20-22', 'Ale', 'Varcasia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_curso`
--

CREATE TABLE `dim_curso` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `anio` int(11) NOT NULL,
  `horario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_curso`
--

INSERT INTO `dim_curso` (`id_curso`, `nombre`, `anio`, `horario`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(1, 'ATI 2017 20-22', 2017, '20-22', '2017-08-19', '2017-08-31', 1),
(2, 'ING 2017 20-22', 2017, '16-18', '2017-08-22', '2017-12-01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_ejercicio`
--

CREATE TABLE `dim_ejercicio` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_ejercicio`
--

INSERT INTO `dim_ejercicio` (`id_ejercicio`, `nombre`, `letra`) VALUES
(2, 'Perro', 'Letra'),
(1, 'PerroCucha', 'Letra de ejercicio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_subtema`
--

CREATE TABLE `dim_subtema` (
  `id_sub_tema` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  `nombreTema` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_subtema`
--

INSERT INTO `dim_subtema` (`id_sub_tema`, `nombre`, `letra`, `nombreTema`) VALUES
(4, 'Atributos Complejos', 'Algunos atributos pueden estar compuestos por sub-atributos.', 'Atributos'),
(6, 'Atributos Determinantes', 'Se denominan Clave Primaria y denotan el conjunto de atributos que determinan unívocamente a la Entidad, no permitiendo que se repita en la misma Entidad.', 'Atributos'),
(5, 'Atributos Multivaluados', 'Contienen un CONJUNTO de valores para una Entidad dada.', 'Atributos'),
(3, 'Atributos Simples', 'Es un atributo que tiene un solo componente, que no se puede dividir en partes más pequeñas que tengan un significado propio', 'Atributos'),
(7, 'Cardinalidad', 'Especifican la cantidad de entidades que se relacionan en la realidad.Tipos:- 1 a 1 Una Entidad se relaciona únicamente con otro y viceversa.- 1 a N Determina que una Entidad puede estar relacionado con varios de la otra Entidad.- N a N Una Entidad puede relacionarse con otra Entidad con ninguna o varios registros ', 'Relaciones'),
(12, 'Categorizacion Completa', 'Si una instancia del supertipo puede ser, a la vez, miembro de más de un subtipo', 'Categorizacion '),
(13, 'Categorizacion Disjunta', 'SI una instancia del supertipo puede ser miembro de, como máximo, uno de los subtipos', 'Categorizacion '),
(8, 'Relacion con Atributos', 'A veces interesa reflejar propiedades de cada instancia de una relación.Cuando la cantidad de atributos es grande puede tener sentido que la relación se denote como una entidad por sí misma.', 'Relaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_tema`
--

CREATE TABLE `dim_tema` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_tema`
--

INSERT INTO `dim_tema` (`id_tema`, `nombre`, `letra`) VALUES
(2, 'Atributos', 'Son características que definen o identifican a una Entidad.De cada entidad del mundo real identificamos las propiedades. A cada propiedad le llamamos ATRIBUTO de la Entidad. Una entidad debe contener al menos UN atributo.'),
(4, 'Autorelacion', 'Relaciones entre una Entidad y si misma'),
(8, 'Categorizacion ', 'Mecanismo de Abstracción que permite expresar conjuntos de Entidades que comparte atributos comunes.'),
(1, 'Entidades', 'Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten característicassimilares se denomina Conjunto Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten características similares se denomina Conjunto de Entidades.'),
(7, 'Entidades Debiles', 'Entidad cuya existencia no tiene sentido en forma aislada.'),
(9, 'Introduccion', 'Modelo conceptual gráfico, usado para representar estructuras que almacenan información.No contiene lenguaje para representar operaciones de manipulación información.Se utilizan Entidades, Conjuntos de Entidades y Relaciones'),
(6, 'Relacion entre tres Entidades', 'Se denomina Agregacion y representa una abstracción a través de la cual las relaciones se tratan como entidades de un nivel más alto. Se utiliza para expresar relaciones entre relaciones o entre entidades y relaciones. Se representa englobando la relación abstraída y las entidades que participan entre ellas en un rectángulo. En muchos casos de relaciones con orden > 2 no se refleja exactamente la realidad'),
(3, 'Relaciones', 'Vinculo que permite definir una dependencia entre los conjuntos de dos o más Entidades. Por lo general son Verbos como asignar, asociar. Las relaciones se representan con una figura de diamante y también pueden tener atributos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_usuario`
--

CREATE TABLE `dim_usuario` (
  `id_usuario` int(11) NOT NULL,
  `ci` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `celular` char(9) COLLATE utf8_spanish_ci NOT NULL,
  `categoria_usuario` enum('Administrativo','Alumno','Profesor') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_usuario`
--

INSERT INTO `dim_usuario` (`id_usuario`, `ci`, `nombre`, `apellido`, `sexo`, `email`, `clave`, `telefono`, `celular`, `categoria_usuario`) VALUES
(8, '11111111', 'Jorge', 'ajasdjp', 'F', 'rperez9594@gmail.com', '1bbd886460827015e5d605ed44252251', '654', '54645', 'Alumno'),
(1, '1234555', 'Henry', 'Foth', 'M', 'henry.foth.m@gmail.com', 'cb5e35fe0160c0a3439ecec60523ff30', '23546772', '091320029', 'Alumno'),
(9, '12345678', 'Alberto', 'Gomez', 'M', 'eabella@adinet.com.uy', '25d55ad283aa400af464c76d713c07ad', '23546666', '091555555', 'Profesor'),
(11, '36843532', 'Aldo', 'Garcia', 'M', 'eabella@adinet.com.uy', '1e9035f0e0d0ae3cdc285a1240a5e99d', '23546666', '091555555', 'Profesor'),
(5, '40245737', 'Ale', 'Varcasia', 'M', 'alemartin2014@hotmail.com', 'f3b6964f6433ef6e627fffff292a3342', '23546184', '099456158', 'Alumno'),
(2, '40269737', 'Alejandro', 'Varcasia', 'M', 'alemartin2014@hotmail.com', '245f13fa45bff5d1256c98b11686c36e', '23546184', '099456158', 'Alumno'),
(3, '42578920', 'Rodrigo', 'Perez', 'M', 'rperez9594@gmail.com', '5b66bc40a6cdd836b6ba07aa02eb39a1', '25487655', '094315648', 'Alumno'),
(7, '58772521', 'Lacha', 'Gar', 'M', 'rperez9594@gmail.com', '83ce6a310c7a9302156af518c6121f39', '25487655', '094315648', 'Alumno'),
(4, '58792521', 'Rodrigo', 'Perez', 'M', 'rperez9594@gmail.com', '42cdab6e75d666650526c82b47a5d134', '25487655', '094315648', 'Alumno'),
(6, '65984627', 'Raul', 'Gomez', 'M', 'rperez9594@gmail.com', '0ea21f28e90fd095da00a66c6399cc49', 'C', '094315648', 'Alumno'),
(14, '69898982', 'Susana', 'Estevez', 'M', 'eabella@adinet.com.uy', 'ba09c2d33328c2d66dd9387d64cb8f47', '23546666', '091555555', 'Profesor'),
(12, '78645444', 'Miguel', 'Silva', 'M', 'eabella@adinet.com.uy', '95ed7be290aa734b77a32c4513404094', '23546666', '091555555', 'Profesor'),
(13, '87965121', 'Fernando', 'Gil', 'M', 'eabella@adinet.com.uy', 'dbdba8ea71263b4e6da1581391efa71c', '23546666', '091555555', 'Profesor'),
(10, '87965462', 'Milton', 'Perez', 'M', 'eabella@adinet.com.uy', 'c5cb353b0f5cc4e974650183b366fe7a', '23546666', '091555555', 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_agregacion`
--

CREATE TABLE `sol_agregacion` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_atributo_multivaluado`
--

CREATE TABLE `sol_atributo_multivaluado` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_atributo_simple`
--

CREATE TABLE `sol_atributo_simple` (
  `id_atributo_simple` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `esPK` enum('0','1') COLLATE utf8_spanish_ci NOT NULL,
  `nombreEntidad` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSuperTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSubTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_atributo_simple`
--

INSERT INTO `sol_atributo_simple` (`id_atributo_simple`, `nombre`, `esPK`, `nombreEntidad`, `nombreEntidadSuperTipo`, `nombreEntidadSubTipo`) VALUES
(6, 'Color', '0', 'Cucha', NULL, NULL),
(4, 'Nombre', '1', 'Perro', NULL, NULL),
(5, 'Raza', '0', 'Perro', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_entidad`
--

CREATE TABLE `sol_entidad` (
  `id_entidad` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci,
  `nombreMer` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_entidad`
--

INSERT INTO `sol_entidad` (`id_entidad`, `nombre`, `colAtributosSimples`, `colAtributosMultivaluados`, `nombreMer`) VALUES
(2, 'Cucha', '"Color" => "Color"', NULL, 'PerroCucha'),
(1, 'Perro', '"Nombre" => "Nombre", "Raza" => "Raza', NULL, 'PerroCucha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_entidad_subtipo`
--

CREATE TABLE `sol_entidad_subtipo` (
  `id_entidad_subtipo` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci,
  `nombreMer` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_entidad_supertipo`
--

CREATE TABLE `sol_entidad_supertipo` (
  `id_entidad_supertipo` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidadesSubtipos` longtext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_mer`
--

CREATE TABLE `sol_mer` (
  `id_mer` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colRelaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAgregaciones` longtext COLLATE utf8_spanish_ci,
  `tipo` enum('sol_sistema','sol_alumno') COLLATE utf8_spanish_ci NOT NULL,
  `nombreEjercicio` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_mer`
--

INSERT INTO `sol_mer` (`id_mer`, `nombre`, `colEntidades`, `colRelaciones`, `colAgregaciones`, `tipo`, `nombreEjercicio`) VALUES
(1, 'PerroCucha', '"Perro" => "Perro", "Cucha" => "Cucha"', '"PerroCucha" => "PerroCucha"', NULL, 'sol_sistema', 'PerroCucha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_relacion`
--

CREATE TABLE `sol_relacion` (
  `id_relacion` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadA` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadB` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `cardinalidadA` int(2) NOT NULL,
  `cardinalidadB` int(2) NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_relacion`
--

INSERT INTO `sol_relacion` (`id_relacion`, `nombre`, `entidadA`, `entidadB`, `cardinalidadA`, `cardinalidadB`, `colAtributosSimples`) VALUES
(2, 'PerroCucha', 'Perro', 'Cucha', 1, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asc_curso_tema_subtema_ejercicio`
--
ALTER TABLE `asc_curso_tema_subtema_ejercicio`
  ADD KEY `FK_nombreCurso_idx` (`nombre_curso`),
  ADD KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_curso` (`nombre_curso`),
  ADD KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_subtema` (`nombre_subtema`),
  ADD KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_ejercicio` (`nombre_ejercicio`),
  ADD KEY `FK_nombreSubTema_idx` (`nombre_subtema`),
  ADD KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_tema` (`nombre_tema`);

--
-- Indices de la tabla `asc_curso_usuario`
--
ALTER TABLE `asc_curso_usuario`
  ADD KEY `FK_curso_idx` (`nombre_curso`),
  ADD KEY `idx_asc_curso_usuario_nombre_usuario` (`nombre_usuario`),
  ADD KEY `FK_nombre_usuario_idx` (`nombre_usuario`),
  ADD KEY `idx_asc_curso_usuario_apellido_usuario` (`apellido_usuario`),
  ADD KEY `FK_apellido_usuario_idx` (`apellido_usuario`);

--
-- Indices de la tabla `dim_curso`
--
ALTER TABLE `dim_curso`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `dim_ejercicio`
--
ALTER TABLE `dim_ejercicio`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `UNIQUE` (`id_ejercicio`);

--
-- Indices de la tabla `dim_subtema`
--
ALTER TABLE `dim_subtema`
  ADD PRIMARY KEY (`nombre`,`nombreTema`),
  ADD UNIQUE KEY `UNIQUE` (`id_sub_tema`),
  ADD KEY `FK_nombreTema_idx` (`nombreTema`),
  ADD KEY `idx_dim_subtema_nombre` (`nombre`);

--
-- Indices de la tabla `dim_tema`
--
ALTER TABLE `dim_tema`
  ADD PRIMARY KEY (`nombre`) USING BTREE,
  ADD UNIQUE KEY `UNIQUE` (`id_tema`),
  ADD KEY `idx_dim_tema_nombre` (`nombre`);

--
-- Indices de la tabla `dim_usuario`
--
ALTER TABLE `dim_usuario`
  ADD PRIMARY KEY (`ci`,`nombre`,`apellido`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_dim_usuario_nombre_apellido` (`nombre`,`apellido`),
  ADD KEY `idx_dim_usuario_nombre` (`nombre`),
  ADD KEY `idx_dim_usuario_apellido` (`apellido`);

--
-- Indices de la tabla `sol_atributo_simple`
--
ALTER TABLE `sol_atributo_simple`
  ADD PRIMARY KEY (`nombre`,`esPK`),
  ADD UNIQUE KEY `id_atributo_simple` (`id_atributo_simple`),
  ADD KEY `FK_nombreEntidad_idx` (`nombreEntidad`),
  ADD KEY `FK_nombreEntidadSuperTipo_idx` (`nombreEntidadSuperTipo`),
  ADD KEY `FK_nombreEntidadSubTipo_idx` (`nombreEntidadSubTipo`);

--
-- Indices de la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `id_entidad` (`id_entidad`),
  ADD KEY `FK_nombreMER_idx` (`nombreMer`);

--
-- Indices de la tabla `sol_entidad_subtipo`
--
ALTER TABLE `sol_entidad_subtipo`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `id_entidad_subtipo` (`id_entidad_subtipo`);

--
-- Indices de la tabla `sol_entidad_supertipo`
--
ALTER TABLE `sol_entidad_supertipo`
  ADD PRIMARY KEY (`nombre`),
  ADD UNIQUE KEY `id_entidad_supertipo` (`id_entidad_supertipo`);

--
-- Indices de la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  ADD PRIMARY KEY (`nombre`,`tipo`),
  ADD UNIQUE KEY `id_mer` (`id_mer`),
  ADD KEY `FK_nombreEjercicio_idx` (`nombreEjercicio`);

--
-- Indices de la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  ADD PRIMARY KEY (`nombre`,`entidadA`,`entidadB`,`cardinalidadA`,`cardinalidadB`),
  ADD UNIQUE KEY `id_relacion` (`id_relacion`),
  ADD KEY `FK_entidadA_idx` (`entidadA`),
  ADD KEY `FK_entidadB_idx` (`entidadB`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dim_curso`
--
ALTER TABLE `dim_curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `dim_ejercicio`
--
ALTER TABLE `dim_ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `dim_subtema`
--
ALTER TABLE `dim_subtema`
  MODIFY `id_sub_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `dim_tema`
--
ALTER TABLE `dim_tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `dim_usuario`
--
ALTER TABLE `dim_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `sol_atributo_simple`
--
ALTER TABLE `sol_atributo_simple`
  MODIFY `id_atributo_simple` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  MODIFY `id_entidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `sol_entidad_subtipo`
--
ALTER TABLE `sol_entidad_subtipo`
  MODIFY `id_entidad_subtipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sol_entidad_supertipo`
--
ALTER TABLE `sol_entidad_supertipo`
  MODIFY `id_entidad_supertipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  MODIFY `id_mer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  MODIFY `id_relacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asc_curso_tema_subtema_ejercicio`
--
ALTER TABLE `asc_curso_tema_subtema_ejercicio`
  ADD CONSTRAINT `FK_nombreCurso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombreSubTema` FOREIGN KEY (`nombre_subtema`) REFERENCES `dim_subtema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombre_Ejercicio` FOREIGN KEY (`nombre_ejercicio`) REFERENCES `dim_ejercicio` (`nombre`),
  ADD CONSTRAINT `FK_nombre_Tema` FOREIGN KEY (`nombre_tema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asc_curso_usuario`
--
ALTER TABLE `asc_curso_usuario`
  ADD CONSTRAINT `FK_apellido_usuario` FOREIGN KEY (`apellido_usuario`) REFERENCES `dim_usuario` (`apellido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_curso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombre_usuario` FOREIGN KEY (`nombre_usuario`) REFERENCES `dim_usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dim_subtema`
--
ALTER TABLE `dim_subtema`
  ADD CONSTRAINT `FK_nombreTema` FOREIGN KEY (`nombreTema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_atributo_simple`
--
ALTER TABLE `sol_atributo_simple`
  ADD CONSTRAINT `FK_nombreEntidad` FOREIGN KEY (`nombreEntidad`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombreEntidadSubTipo` FOREIGN KEY (`nombreEntidadSubTipo`) REFERENCES `sol_entidad_subtipo` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombreEntidadSuperTipo` FOREIGN KEY (`nombreEntidadSuperTipo`) REFERENCES `sol_entidad_supertipo` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  ADD CONSTRAINT `FK_nombreMER` FOREIGN KEY (`nombreMer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  ADD CONSTRAINT `FK_nombreEjercicio` FOREIGN KEY (`nombreEjercicio`) REFERENCES `dim_ejercicio` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  ADD CONSTRAINT `FK_entidadA` FOREIGN KEY (`entidadA`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_entidadB` FOREIGN KEY (`entidadB`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
