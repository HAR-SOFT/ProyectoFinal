-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: e-mer
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asc_curso_tema_subtema_ejercicio`
--

DROP TABLE IF EXISTS `asc_curso_tema_subtema_ejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asc_curso_tema_subtema_ejercicio` (
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_tema` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_subtema` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_ejercicio` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  KEY `FK_nombreCurso_idx` (`nombre_curso`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_curso` (`nombre_curso`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_subtema` (`nombre_subtema`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_ejercicio` (`nombre_ejercicio`),
  KEY `FK_nombreSubTema_idx` (`nombre_subtema`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_tema` (`nombre_tema`),
  CONSTRAINT `FK_nombreCurso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreSubTema` FOREIGN KEY (`nombre_subtema`) REFERENCES `dim_subtema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_Ejercicio` FOREIGN KEY (`nombre_ejercicio`) REFERENCES `dim_ejercicio` (`nombre`),
  CONSTRAINT `FK_nombre_Tema` FOREIGN KEY (`nombre_tema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_curso_tema_subtema_ejercicio`
--

LOCK TABLES `asc_curso_tema_subtema_ejercicio` WRITE;
/*!40000 ALTER TABLE `asc_curso_tema_subtema_ejercicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `asc_curso_tema_subtema_ejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asc_curso_usuario`
--

DROP TABLE IF EXISTS `asc_curso_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asc_curso_usuario` (
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  KEY `FK_curso_idx` (`nombre_curso`),
  KEY `idx_asc_curso_usuario_nombre_usuario` (`nombre_usuario`),
  KEY `FK_nombre_usuario_idx` (`nombre_usuario`),
  KEY `idx_asc_curso_usuario_apellido_usuario` (`apellido_usuario`),
  KEY `FK_apellido_usuario_idx` (`apellido_usuario`),
  CONSTRAINT `FK_apellido_usuario` FOREIGN KEY (`apellido_usuario`) REFERENCES `dim_usuario` (`apellido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_curso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_usuario` FOREIGN KEY (`nombre_usuario`) REFERENCES `dim_usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_curso_usuario`
--

LOCK TABLES `asc_curso_usuario` WRITE;
/*!40000 ALTER TABLE `asc_curso_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `asc_curso_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_curso`
--

DROP TABLE IF EXISTS `dim_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_curso` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `anio` int(11) NOT NULL,
  `horario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_curso`
--

LOCK TABLES `dim_curso` WRITE;
/*!40000 ALTER TABLE `dim_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_ejercicio`
--

DROP TABLE IF EXISTS `dim_ejercicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_ejercicio` (
  `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `UNIQUE` (`id_ejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_ejercicio`
--

LOCK TABLES `dim_ejercicio` WRITE;
/*!40000 ALTER TABLE `dim_ejercicio` DISABLE KEYS */;
INSERT INTO `dim_ejercicio` VALUES (1,'PerroCucha','Letra de ejercicio');
/*!40000 ALTER TABLE `dim_ejercicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_subtema`
--

DROP TABLE IF EXISTS `dim_subtema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_subtema` (
  `id_sub_tema` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  `nombreTema` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`nombreTema`),
  UNIQUE KEY `UNIQUE` (`id_sub_tema`),
  KEY `FK_nombreTema_idx` (`nombreTema`),
  KEY `idx_dim_subtema_nombre` (`nombre`),
  CONSTRAINT `FK_nombreTema` FOREIGN KEY (`nombreTema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_subtema`
--

LOCK TABLES `dim_subtema` WRITE;
/*!40000 ALTER TABLE `dim_subtema` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_subtema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_tema`
--

DROP TABLE IF EXISTS `dim_tema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_tema` (
  `id_tema` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  PRIMARY KEY (`nombre`) USING BTREE,
  UNIQUE KEY `UNIQUE` (`id_tema`),
  KEY `idx_dim_tema_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_tema`
--

LOCK TABLES `dim_tema` WRITE;
/*!40000 ALTER TABLE `dim_tema` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_tema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_usuario`
--

DROP TABLE IF EXISTS `dim_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `ci` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `celular` char(9) COLLATE utf8_spanish_ci NOT NULL,
  `categoria_usuario` enum('Administrativo','Alumno','Profesor') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ci`,`nombre`,`apellido`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  KEY `idx_dim_usuario_nombre_apellido` (`nombre`,`apellido`),
  KEY `idx_dim_usuario_nombre` (`nombre`),
  KEY `idx_dim_usuario_apellido` (`apellido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_usuario`
--

LOCK TABLES `dim_usuario` WRITE;
/*!40000 ALTER TABLE `dim_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_agregacion`
--

DROP TABLE IF EXISTS `sol_agregacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_agregacion` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_agregacion`
--

LOCK TABLES `sol_agregacion` WRITE;
/*!40000 ALTER TABLE `sol_agregacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_agregacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_atributo_multivaluado`
--

DROP TABLE IF EXISTS `sol_atributo_multivaluado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_atributo_multivaluado` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_atributo_multivaluado`
--

LOCK TABLES `sol_atributo_multivaluado` WRITE;
/*!40000 ALTER TABLE `sol_atributo_multivaluado` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_atributo_multivaluado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_atributo_simple`
--

DROP TABLE IF EXISTS `sol_atributo_simple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_atributo_simple` (
  `id_atributo_simple` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `esPK` enum('0','1') COLLATE utf8_spanish_ci NOT NULL,
  `nombreEntidad` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSuperTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSubTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nombre`,`esPK`),
  UNIQUE KEY `id_atributo_simple` (`id_atributo_simple`),
  KEY `FK_nombreEntidad_idx` (`nombreEntidad`),
  KEY `FK_nombreEntidadSuperTipo_idx` (`nombreEntidadSuperTipo`),
  KEY `FK_nombreEntidadSubTipo_idx` (`nombreEntidadSubTipo`),
  CONSTRAINT `FK_nombreEntidad` FOREIGN KEY (`nombreEntidad`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreEntidadSubTipo` FOREIGN KEY (`nombreEntidadSubTipo`) REFERENCES `sol_entidad_subtipo` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreEntidadSuperTipo` FOREIGN KEY (`nombreEntidadSuperTipo`) REFERENCES `sol_entidad_supertipo` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_atributo_simple`
--

LOCK TABLES `sol_atributo_simple` WRITE;
/*!40000 ALTER TABLE `sol_atributo_simple` DISABLE KEYS */;
INSERT INTO `sol_atributo_simple` VALUES (6,'Color','0','Cucha',NULL,NULL),(4,'Nombre','1','Perro',NULL,NULL),(5,'Raza','0','Perro',NULL,NULL);
/*!40000 ALTER TABLE `sol_atributo_simple` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_entidad`
--

DROP TABLE IF EXISTS `sol_entidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_entidad` (
  `id_entidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci,
  `nombreMer` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `id_entidad` (`id_entidad`),
  KEY `FK_nombreMER_idx` (`nombreMer`),
  CONSTRAINT `FK_nombreMER` FOREIGN KEY (`nombreMer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad`
--

LOCK TABLES `sol_entidad` WRITE;
/*!40000 ALTER TABLE `sol_entidad` DISABLE KEYS */;
INSERT INTO `sol_entidad` VALUES (2,'Cucha','\"Color\" => \"Color\"',NULL,'PerroCucha'),(1,'Perro','\"Nombre\" => \"Nombre\", \"Raza\" => \"Raza',NULL,'PerroCucha');
/*!40000 ALTER TABLE `sol_entidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_entidad_subtipo`
--

DROP TABLE IF EXISTS `sol_entidad_subtipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_entidad_subtipo` (
  `id_entidad_subtipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci,
  `nombreMer` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `id_entidad_subtipo` (`id_entidad_subtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad_subtipo`
--

LOCK TABLES `sol_entidad_subtipo` WRITE;
/*!40000 ALTER TABLE `sol_entidad_subtipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_entidad_subtipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_entidad_supertipo`
--

DROP TABLE IF EXISTS `sol_entidad_supertipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_entidad_supertipo` (
  `id_entidad_supertipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidadesSubtipos` longtext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `id_entidad_supertipo` (`id_entidad_supertipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad_supertipo`
--

LOCK TABLES `sol_entidad_supertipo` WRITE;
/*!40000 ALTER TABLE `sol_entidad_supertipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_entidad_supertipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_mer`
--

DROP TABLE IF EXISTS `sol_mer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_mer` (
  `id_mer` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colRelaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAgregaciones` longtext COLLATE utf8_spanish_ci,
  `tipo` enum('sol_sistema','sol_alumno') COLLATE utf8_spanish_ci NOT NULL,
  `nombreEjercicio` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`tipo`),
  UNIQUE KEY `id_mer` (`id_mer`),
  KEY `FK_nombreEjercicio_idx` (`nombreEjercicio`),
  CONSTRAINT `FK_nombreEjercicio` FOREIGN KEY (`nombreEjercicio`) REFERENCES `dim_ejercicio` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_mer`
--

LOCK TABLES `sol_mer` WRITE;
/*!40000 ALTER TABLE `sol_mer` DISABLE KEYS */;
INSERT INTO `sol_mer` VALUES (1,'PerroCucha','\"Perro\" => \"Perro\", \"Cucha\" => \"Cucha\"','\"PerroCucha\" => \"PerroCucha\"',NULL,'sol_sistema','PerroCucha');
/*!40000 ALTER TABLE `sol_mer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_relacion`
--

DROP TABLE IF EXISTS `sol_relacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_relacion` (
  `id_relacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadA` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadB` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `cardinalidadA` int(2) NOT NULL,
  `cardinalidadB` int(2) NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`nombre`,`entidadA`,`entidadB`,`cardinalidadA`,`cardinalidadB`),
  UNIQUE KEY `id_relacion` (`id_relacion`),
  KEY `FK_entidadA_idx` (`entidadA`),
  KEY `FK_entidadB_idx` (`entidadB`),
  CONSTRAINT `FK_entidadA` FOREIGN KEY (`entidadA`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_entidadB` FOREIGN KEY (`entidadB`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_relacion`
--

LOCK TABLES `sol_relacion` WRITE;
/*!40000 ALTER TABLE `sol_relacion` DISABLE KEYS */;
INSERT INTO `sol_relacion` VALUES (2,'PerroCucha','Perro','Cucha',1,1,NULL);
/*!40000 ALTER TABLE `sol_relacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-13 15:34:58
