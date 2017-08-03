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
-- Table structure for table `agregacion`
--

DROP TABLE IF EXISTS `agregacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agregacion` (
  `Nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agregacion`
--

LOCK TABLES `agregacion` WRITE;
/*!40000 ALTER TABLE `agregacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `agregacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asc_cursos_temas_subtemas_ejercicios`
--

DROP TABLE IF EXISTS `asc_cursos_temas_subtemas_ejercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asc_cursos_temas_subtemas_ejercicios` (
  `nombre_curso` varchar(50) NOT NULL,
  `nombre_tema` varchar(20) NOT NULL,
  `nombre_subtema` varchar(20) NOT NULL,
  `nombre_ejercicio` varchar(20) NOT NULL,
  PRIMARY KEY (`nombre_curso`,`nombre_tema`,`nombre_subtema`,`nombre_ejercicio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_cursos_temas_subtemas_ejercicios`
--

LOCK TABLES `asc_cursos_temas_subtemas_ejercicios` WRITE;
/*!40000 ALTER TABLE `asc_cursos_temas_subtemas_ejercicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `asc_cursos_temas_subtemas_ejercicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atributo_multivaluado`
--

DROP TABLE IF EXISTS `atributo_multivaluado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atributo_multivaluado` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo_multivaluado`
--

LOCK TABLES `atributo_multivaluado` WRITE;
/*!40000 ALTER TABLE `atributo_multivaluado` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo_multivaluado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atributo_simple`
--

DROP TABLE IF EXISTS `atributo_simple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atributo_simple` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `esPK` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo_simple`
--

LOCK TABLES `atributo_simple` WRITE;
/*!40000 ALTER TABLE `atributo_simple` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo_simple` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_cursos`
--

DROP TABLE IF EXISTS `dim_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `anio` int(11) NOT NULL,
  `horario` varchar(9) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `profesor` varchar(50) NOT NULL,
  `ind_activo` int(11) NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `id_curso` (`id_curso`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_cursos`
--

LOCK TABLES `dim_cursos` WRITE;
/*!40000 ALTER TABLE `dim_cursos` DISABLE KEYS */;
INSERT INTO `dim_cursos` VALUES (5,'ATI 2017 18-20',2017,'20-22','2017-05-30','2017-07-17','Enrique Abella',0),(6,'Lic 2017 09-13',2017,'09-13','2017-05-30','2017-07-18','Enrique Abella',0),(7,'Ing 2017 18-22',2017,'18-22','2017-05-30','2017-07-19','Enrique Abella',0);
/*!40000 ALTER TABLE `dim_cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_ejercicios`
--

DROP TABLE IF EXISTS `dim_ejercicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_ejercicios` (
  `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  `solucion_sistema` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `UNIQUE` (`id_ejercicio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_ejercicios`
--

LOCK TABLES `dim_ejercicios` WRITE;
/*!40000 ALTER TABLE `dim_ejercicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_ejercicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_subtemas`
--

DROP TABLE IF EXISTS `dim_subtemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_subtemas` (
  `id_sub_tema` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `UNIQUE` (`id_sub_tema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_subtemas`
--

LOCK TABLES `dim_subtemas` WRITE;
/*!40000 ALTER TABLE `dim_subtemas` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_subtemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_temas`
--

DROP TABLE IF EXISTS `dim_temas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_temas` (
  `id_tema` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `letra` blob NOT NULL,
  PRIMARY KEY (`nombre`) USING BTREE,
  UNIQUE KEY `UNIQUE` (`id_tema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_temas`
--

LOCK TABLES `dim_temas` WRITE;
/*!40000 ALTER TABLE `dim_temas` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim_temas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_usuarios`
--

DROP TABLE IF EXISTS `dim_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `ci` char(8) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
  `apellido` varchar(50) CHARACTER SET latin1 NOT NULL,
  `sexo` char(1) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `clave` varchar(50) CHARACTER SET latin1 NOT NULL,
  `telefono` char(8) CHARACTER SET latin1 NOT NULL,
  `celular` char(9) CHARACTER SET latin1 NOT NULL,
  `curso` varchar(50) CHARACTER SET latin1 NOT NULL,
  `categoria_usuario` enum('alumno','administrativo','profesor') CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ci`,`nombre`,`apellido`,`curso`),
  UNIQUE KEY `UNIQUE` (`id_usuario`) USING BTREE,
  KEY `FK_curso` (`curso`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_usuarios`
--

LOCK TABLES `dim_usuarios` WRITE;
/*!40000 ALTER TABLE `dim_usuarios` DISABLE KEYS */;
INSERT INTO `dim_usuarios` VALUES (17,'40269733','Heny','Prfos','F','eabella@adinet.com.uy','072a212d274af36f760355b60ed41d81','23546666','091555555','Ing 2017 18-22\n','profesor'),(16,'12345687','Enrique','Abella','M','eabella@adinet.com.uy','95d47be0d380a7cd3bb5bbe78e8bed49','23546666','091555555','Ing 2017 18-22','profesor'),(15,'12345665','Enrique','Abella','M','eabella@adinet.com.uy','d2322484d96897dca51bef5dc8126ef2','23546666','091555555','Lic 2017 09-13','profesor'),(14,'40269733','Ale','Varcasia','M','eabella@adinet.com.uy','072a212d274af36f760355b60ed41d81','23546666','091555555','ATI 2017 20-22','profesor'),(18,'12345665','Heny','Prfos','F','eabella@adinet.com.uy','d2322484d96897dca51bef5dc8126ef2','23546666','091555555','Ing 2017 18-22\n','profesor'),(19,'12345687','Ale','Varcasia','M','eabella@adinet.com.uy','95d47be0d380a7cd3bb5bbe78e8bed49','23546666','091555555','ATI 2017 20-22','profesor'),(20,'89513218','Pepe','Tito','M','pepe@hotmail','f9a57f3771a1f7292ad580da9ae1f165','6588','6878','54689898','profesor'),(21,'','','','','','d41d8cd98f00b204e9800998ecf8427e','','','','profesor'),(22,'1234555','Henry','Foth','M','henry.foth.m@gmail.com','cb5e35fe0160c0a3439ecec60523ff30','23546772','091320029','ATI 2017 20-22','alumno'),(23,'7654321','Alejandro','Varcasia','M','alemartin2014@hotmail.com','f0898af949a373e72a4f6a34b4de9090','23546184','099456158','Lic 2017 09-13','alumno'),(24,'123654','Rodrigo','Perez','M','rperez9594@gmail.com','733d7be2196ff70efaf6913fc8bdcabf','25487655','094315648','Ing 2017 18-22','alumno');
/*!40000 ALTER TABLE `dim_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entidad_supertipo`
--

DROP TABLE IF EXISTS `entidad_supertipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entidad_supertipo` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidadesSubtipos` longtext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entidad_supertipo`
--

LOCK TABLES `entidad_supertipo` WRITE;
/*!40000 ALTER TABLE `entidad_supertipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `entidad_supertipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relacion`
--

DROP TABLE IF EXISTS `relacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relacion` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadA` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `entidadB` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `cardinalidadA` int(2) NOT NULL,
  `cardinalidadB` int(2) NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relacion`
--

LOCK TABLES `relacion` WRITE;
/*!40000 ALTER TABLE `relacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `relacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_entidad`
--

DROP TABLE IF EXISTS `sol_entidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_entidad` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci NOT NULL,
  `nombreMer` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  KEY `FK_nombreMER` (`nombreMer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad`
--

LOCK TABLES `sol_entidad` WRITE;
/*!40000 ALTER TABLE `sol_entidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_entidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_entidad_subtipo`
--

DROP TABLE IF EXISTS `sol_entidad_subtipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_entidad_subtipo` (
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `colAtributosSimples` longtext COLLATE utf8_spanish_ci,
  `colAtributosMultivaluados` longtext COLLATE utf8_spanish_ci,
  `nombreMer` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nombre`),
  KEY `FK_nombreMER` (`nombreMer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad_subtipo`
--

LOCK TABLES `sol_entidad_subtipo` WRITE;
/*!40000 ALTER TABLE `sol_entidad_subtipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_entidad_subtipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_mer`
--

DROP TABLE IF EXISTS `sol_mer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_mer` (
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `colEntidades` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colRelaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  `colAgregaciones` longtext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('sol_sistema','sol_alumno') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`tipo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_mer`
--

LOCK TABLES `sol_mer` WRITE;
/*!40000 ALTER TABLE `sol_mer` DISABLE KEYS */;
/*!40000 ALTER TABLE `sol_mer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-31 18:56:57
