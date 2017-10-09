-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2017 a las 17:36:51
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
('ATI2017', 'Entidades', '', 'PerroCucha'),
('ATI2017', 'Atributos', 'Atributos Simples', 'PerroCucha'),
('ATI2017', 'Atributos', 'Atributos Multivaluados', 'PerroCucha'),
('ATI2017', 'Entidades Debiles', 'Atributos Complejos', 'PerroCucha'),
('ATI2017', 'Relaciones', 'Relacion con Atributos', 'PerroCucha'),
('ATI2017', 'Autorelacion', 'Atributos Complejos', 'PerroCucha'),
('ATI2017', 'Categorizacion ', 'Categorizacion Completa', 'PerroCucha'),
('ING2017', 'Relaciones', 'Relacion con Atributos', 'PerroCucha'),
('ING2017', 'Atributos', 'Atributos Multivaluados', 'PerroCucha'),
('ATI2017', 'Atributos', 'Atributos Simples', 'PerroCucha'),
('ATI2017', 'Atributos', 'Atributos Simples', 'PerroChulo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asc_curso_usuario`
--

CREATE TABLE `asc_curso_usuario` (
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asc_curso_usuario`
--

INSERT INTO `asc_curso_usuario` (`nombre_curso`, `ci_usuario`) VALUES
('ATI2017', '38072948'),
('ATI2017', '12345679'),
('ATI2016', '35378668');

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
(7, 'ATI2016', 2016, '14-16', '2017-05-31', '2017-10-01', 1),
(1, 'ATI2017', 2017, '20-22', '2017-08-07', '2017-08-15', 1),
(9, 'ATI20178', 2018, '20-20', '2017-05-31', '2017-10-01', 1),
(2, 'ING2017', 2017, '16-18', '2017-05-10', '2017-09-30', 1),
(8, 'ING2018', 2018, '20-22', '2017-05-31', '2017-12-31', 1),
(3, 'LIC2017', 2017, '12-14', '2017-08-01', '2017-12-01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_ejercicio`
--

CREATE TABLE `dim_ejercicio` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_ejercicio`
--

INSERT INTO `dim_ejercicio` (`id_ejercicio`, `nombre`, `letra`) VALUES
(3, 'PerroChulo', 'Existe un Perro que tiene nombre y raza.El Perro vive en la Cucha que es de color rojo.'),
(2, 'PerroCucha', 'Existe un Perro que tiene nombre y raza.El Perro vive en la Cucha que es de color rojo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dim_subtema`
--

CREATE TABLE `dim_subtema` (
  `id_sub_tema` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  `nombreTema` varchar(40) COLLATE utf8_spanish_ci NOT NULL
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
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  `indice` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dim_tema`
--

INSERT INTO `dim_tema` (`id_tema`, `nombre`, `letra`, `indice`) VALUES
(2, 'Atributos', 'Son características que definen o identifican a una Entidad.De cada entidad del mundo real identificamos las propiedades. A cada propiedad le llamamos ATRIBUTO de la Entidad. Una entidad debe contener al menos UN atributo.', 3),
(4, 'Autorelacion', 'Relaciones entre una Entidad y si misma', 5),
(8, 'Categorizacion ', 'Mecanismo de Abstracción que permite expresar conjuntos de Entidades que comparte atributos comunes.', 8),
(1, 'Entidades', 'Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten característicassimilares se denomina Conjunto Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten características similares se denomina Conjunto de Entidades.', 2),
(7, 'Entidades Debiles', 'Entidad cuya existencia no tiene sentido en forma aislada.', 7),
(9, 'Introduccion', 'Modelo conceptual gráfico, usado para representar estructuras que almacenan información.No contiene lenguaje para representar operaciones de manipulación información.Se utilizan Entidades, Conjuntos de Entidades y Relaciones', 1),
(6, 'Relacion entre tres Entidades', 'Se denomina Agregacion y representa una abstracción a través de la cual las relaciones se tratan como entidades de un nivel más alto. Se utiliza para expresar relaciones entre relaciones o entre entidades y relaciones. Se representa englobando la relación abstraída y las entidades que participan entre ellas en un rectángulo. En muchos casos de relaciones con orden > 2 no se refleja exactamente la realidad', 5),
(3, 'Relaciones', 'Vinculo que permite definir una dependencia entre los conjuntos de dos o más Entidades. Por lo general son Verbos como asignar, asociar. Las relaciones se representan con una figura de diamante y también pueden tener atributos.', 4);

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
(4, '00000000', 'Sistema', 'Sistema', 'M', 'admin@admin.com', '00000000000000000000000000000000', '00000000', '000000000', 'Administrativo'),
(2, '12345678', 'Administrativo', 'Administrativo', 'M', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '12345678', '091123456', 'Administrativo'),
(3, '12345679', 'Profe', 'Profe', 'F', 'profe@profe.com', '1145cbf42070c6704b66d6ac75347726', '12345678', '091123456', 'Profesor'),
(32, '23546444', 'Esteban', 'Quito', 'M', 'esteEsMiEmail@hotmail.com', '1d77d3d67546e6e79c8dd310eb1c20ab', '87987', '432132', 'Alumno'),
(29, '32165472', 'Javier ', 'Garcia', 'M', 'esteEsMiEmail@hotmail.com', '95585fd7a799220e53e8c43605b4b580', '67987', '323187', 'Alumno'),
(39, '35378668', 'Daniel ', 'Jenci', 'M', 'esteEsMiEmail@hotmail.com', '4fdf57c9b06e457754e333196c8a371e', '54987', '548676', 'Profesor'),
(1, '38072948', 'Henry', 'Foth', 'M', 'henry.foth.m@gmail.com', '027e4180beedb29744413a7ea6b84a42', '23546772', '091320029', 'Alumno'),
(25, '4026973', 'Alejandro', 'Varcasia', 'M', 'esteEsMiEmail@hotmail.com', '4d9236bf255b698a17d35206ad642ed2', '265', '654', 'Alumno'),
(24, '40269737', 'Raul', 'Gomez', 'M', 'esteEsMiEmail@hotmail.com', '245f13fa45bff5d1256c98b11686c36e', '12346', '095884306', 'Alumno'),
(36, '44444444', 'Lucas', 'Sugo', 'M', 'esteEsMiEmail@hotmail.com', 'b857eed5c9405c1f2b98048aae506792', '54987', '68798', 'Profesor'),
(33, '5465484', 'Anibal', 'Conde', 'M', 'esteEsMiEmail@hotmail.com', 'd1d069a8b664e133337f5d48b7b4f073', '87921351', '54', 'Alumno'),
(35, '55555555', 'Tabare', 'Vazquez', 'M', 'esteEsMiEmail@hotmail.com', 'f638f4354ff089323d1a5f78fd8f63ca', '4879', '8798', 'Profesor'),
(38, '7777777', 'Soledad', 'Perez', 'M', 'esteEsMiEmail@hotmail.com', 'dc0fa7df3d07904a09288bd2d2bb5f40', '879', '878987', 'Profesor'),
(40, '82444444', 'Enrique', 'Abella', 'M', 'esteEsMiEmail@hotmail.com', '0125cb694cc29a610a0c7989ffaf739a', '5987', '844', 'Profesor'),
(42, '85858585', 'Juan', 'Moreno', 'M', 'esteEsMiEmail@hotmail.com', 'a9d39ae016c9a7238a95c877758784c4', '8', '4', 'Profesor'),
(30, '89765465', 'Rodigo', 'Perez', 'M', 'esteEsMiEmail@hotmail.com', '00f326e0d9d814fde747dfd2d63b445d', '354987', '1258789', 'Alumno'),
(37, '9999999', 'Jose', 'Dominguez', 'M', 'esteEsMiEmail@hotmail.com', '283f42764da6dba2522412916b031080', '-1', '', 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_entidad`
--

CREATE TABLE `sol_entidad` (
  `id_entidad` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_entidad` enum('comun','supertipo','subtipo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'comun',
  `entidad_supertipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `atributo_simple` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `atributo_multivaluado` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `agregacion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_categorizacion` enum('N/A','Solapada','Disjunta') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/A',
  `nombre_mer` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_entidad`
--

INSERT INTO `sol_entidad` (`id_entidad`, `nombre`, `tipo_entidad`, `entidad_supertipo`, `atributo_simple`, `atributo_multivaluado`, `agregacion`, `tipo_categorizacion`, `nombre_mer`, `ci_usuario`) VALUES
(6, 'Cucha', 'comun', NULL, 'Color', NULL, NULL, 'N/A', 'PerroCucha', '00000000'),
(7, 'Cucha', 'comun', '', 'Tamaño', NULL, NULL, 'N/A', 'PerroCucha', '00000000'),
(8, 'Perro', 'comun', NULL, 'Peso', NULL, NULL, 'N/A', 'PerroCucha', '00000000'),
(5, 'Perro', 'comun', NULL, 'Raza', NULL, NULL, 'N/A', 'PerroCucha', '00000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_mer`
--

CREATE TABLE `sol_mer` (
  `id_mer` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('sol_sistema','sol_alumno') COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_ejercicio` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_mer`
--

INSERT INTO `sol_mer` (`id_mer`, `nombre`, `tipo`, `ci_usuario`, `nombre_ejercicio`) VALUES
(3, 'PerroCucha', 'sol_sistema', '00000000', 'PerroCucha'),
(19, 'PerroCucha', 'sol_alumno', '40269737', 'PerroCucha'),
(38, 'PerroCucha', 'sol_alumno', '38072948', 'PerroCucha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol_relacion`
--

CREATE TABLE `sol_relacion` (
  `id_relacion` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_entidadA` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_entidadB` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cardinalidadA` int(2) NOT NULL,
  `cardinalidadB` int(2) NOT NULL,
  `nombre_atributo_simple` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_mer` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sol_relacion`
--

INSERT INTO `sol_relacion` (`id_relacion`, `nombre`, `nombre_entidadA`, `nombre_entidadB`, `cardinalidadA`, `cardinalidadB`, `nombre_atributo_simple`, `nombre_mer`, `ci_usuario`) VALUES
(3, 'Vive', 'Perro', 'Cucha', 1, 1, NULL, 'PerroCucha', '00000000');

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
  ADD KEY `FK_ci_usuario_idx` (`ci_usuario`);

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
-- Indices de la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  ADD PRIMARY KEY (`nombre`,`tipo_entidad`,`atributo_simple`,`nombre_mer`,`ci_usuario`),
  ADD UNIQUE KEY `id_entidad` (`id_entidad`),
  ADD KEY `FK_nombre_mer_idx` (`nombre_mer`),
  ADD KEY `FK_ci_usuario_idx` (`ci_usuario`);

--
-- Indices de la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  ADD PRIMARY KEY (`nombre`,`tipo`,`ci_usuario`,`nombre_ejercicio`),
  ADD UNIQUE KEY `id_mer_UNIQUE` (`id_mer`),
  ADD KEY `FK_ci_usuario_idx` (`ci_usuario`),
  ADD KEY `idx_sol_mer_nombre` (`nombre`),
  ADD KEY `FK_nombre_ejercicio_idx` (`nombre_ejercicio`);

--
-- Indices de la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  ADD PRIMARY KEY (`nombre`,`nombre_entidadA`,`nombre_entidadB`,`cardinalidadA`,`cardinalidadB`,`nombre_mer`,`ci_usuario`),
  ADD UNIQUE KEY `id_relacion` (`id_relacion`),
  ADD KEY `FK_entidadA_idx` (`nombre_entidadA`),
  ADD KEY `FK_entidadB_idx` (`nombre_entidadB`),
  ADD KEY `FK_nombre_mer_idx` (`nombre_mer`),
  ADD KEY `FK_ci_usuario_idx` (`ci_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dim_curso`
--
ALTER TABLE `dim_curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `dim_ejercicio`
--
ALTER TABLE `dim_ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  MODIFY `id_entidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  MODIFY `id_mer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  MODIFY `id_relacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  ADD CONSTRAINT `FK_ci_usuario` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_curso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dim_subtema`
--
ALTER TABLE `dim_subtema`
  ADD CONSTRAINT `FK_nombreTema` FOREIGN KEY (`nombreTema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_entidad`
--
ALTER TABLE `sol_entidad`
  ADD CONSTRAINT `FK_ci_usuario_2` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombre_mer_2` FOREIGN KEY (`nombre_mer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_mer`
--
ALTER TABLE `sol_mer`
  ADD CONSTRAINT `FK_ci_usuario2` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombre_ejercicio2` FOREIGN KEY (`nombre_ejercicio`) REFERENCES `dim_ejercicio` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sol_relacion`
--
ALTER TABLE `sol_relacion`
  ADD CONSTRAINT `FK_ci_usuario_3` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_entidadA` FOREIGN KEY (`nombre_entidadA`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_entidadB` FOREIGN KEY (`nombre_entidadB`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_nombre_mer` FOREIGN KEY (`nombre_mer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
