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
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  KEY `FK_curso_idx` (`nombre_curso`),
  KEY `FK_ci_usuario_idx` (`ci_usuario`),
  CONSTRAINT `FK_ci_usuario` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_curso` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_curso_usuario`
--

LOCK TABLES `asc_curso_usuario` WRITE;
/*!40000 ALTER TABLE `asc_curso_usuario` DISABLE KEYS */;
INSERT INTO `asc_curso_usuario` VALUES ('ATI2017','38072948'),('ATI2017','12345679');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_curso`
--

LOCK TABLES `dim_curso` WRITE;
/*!40000 ALTER TABLE `dim_curso` DISABLE KEYS */;
INSERT INTO `dim_curso` VALUES (1,'ATI2017',2017,'20-22','2017-08-07','2017-08-15',1);
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
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  `nombreTema` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`nombreTema`),
  UNIQUE KEY `UNIQUE` (`id_sub_tema`),
  KEY `FK_nombreTema_idx` (`nombreTema`),
  KEY `idx_dim_subtema_nombre` (`nombre`),
  CONSTRAINT `FK_nombreTema` FOREIGN KEY (`nombreTema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_subtema`
--

LOCK TABLES `dim_subtema` WRITE;
/*!40000 ALTER TABLE `dim_subtema` DISABLE KEYS */;
INSERT INTO `dim_subtema` VALUES (4,'Atributos Complejos','Algunos atributos pueden estar compuestos por sub-atributos.','Atributos'),(6,'Atributos Determinantes','Se denominan Clave Primaria y denotan el conjunto de atributos que determinan unívocamente a la Entidad, no permitiendo que se repita en la misma Entidad.','Atributos'),(5,'Atributos Multivaluados','Contienen un CONJUNTO de valores para una Entidad dada.','Atributos'),(3,'Atributos Simples','Es un atributo que tiene un solo componente, que no se puede dividir en partes más pequeñas que tengan un significado propio','Atributos'),(7,'Cardinalidad','Especifican la cantidad de entidades que se relacionan en la realidad.Tipos:- 1 a 1 Una Entidad se relaciona únicamente con otro y viceversa.- 1 a N Determina que una Entidad puede estar relacionado con varios de la otra Entidad.- N a N Una Entidad puede relacionarse con otra Entidad con ninguna o varios registros ','Relaciones'),(12,'Categorizacion Completa','Si una instancia del supertipo puede ser, a la vez, miembro de más de un subtipo','Categorizacion '),(13,'Categorizacion Disjunta','SI una instancia del supertipo puede ser miembro de, como máximo, uno de los subtipos','Categorizacion '),(8,'Relacion con Atributos','A veces interesa reflejar propiedades de cada instancia de una relación.Cuando la cantidad de atributos es grande puede tener sentido que la relación se denote como una entidad por sí misma.','Relaciones');
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
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  `indice` int(25) NOT NULL,
  PRIMARY KEY (`nombre`) USING BTREE,
  UNIQUE KEY `UNIQUE` (`id_tema`),
  KEY `idx_dim_tema_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_tema`
--

LOCK TABLES `dim_tema` WRITE;
/*!40000 ALTER TABLE `dim_tema` DISABLE KEYS */;
INSERT INTO `dim_tema` VALUES (2,'Atributos','Son características que definen o identifican a una Entidad.De cada entidad del mundo real identificamos las propiedades. A cada propiedad le llamamos ATRIBUTO de la Entidad. Una entidad debe contener al menos UN atributo.',3),(4,'Autorelacion','Relaciones entre una Entidad y si misma',5),(8,'Categorizacion ','Mecanismo de Abstracción que permite expresar conjuntos de Entidades que comparte atributos comunes.',8),(1,'Entidades','Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten característicassimilares se denomina Conjunto Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten características similares se denomina Conjunto de Entidades.',2),(7,'Entidades Debiles','Entidad cuya existencia no tiene sentido en forma aislada.',7),(9,'Introduccion','Modelo conceptual gráfico, usado para representar estructuras que almacenan información.No contiene lenguaje para representar operaciones de manipulación información.Se utilizan Entidades, Conjuntos de Entidades y Relaciones',1),(6,'Relacion entre tres Entidades','Se denomina Agregacion y representa una abstracción a través de la cual las relaciones se tratan como entidades de un nivel más alto. Se utiliza para expresar relaciones entre relaciones o entre entidades y relaciones. Se representa englobando la relación abstraída y las entidades que participan entre ellas en un rectángulo. En muchos casos de relaciones con orden > 2 no se refleja exactamente la realidad',5),(3,'Relaciones','Vinculo que permite definir una dependencia entre los conjuntos de dos o más Entidades. Por lo general son Verbos como asignar, asociar. Las relaciones se representan con una figura de diamante y también pueden tener atributos.',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_usuario`
--

LOCK TABLES `dim_usuario` WRITE;
/*!40000 ALTER TABLE `dim_usuario` DISABLE KEYS */;
INSERT INTO `dim_usuario` VALUES (2,'12345678','Admin','Admin','M','admin@admin.com','21232f297a57a5a743894a0e4a801fc3','12345678','091123456','Administrativo'),(3,'12345679','Profe','Profe','F','profe@profe.com','1145cbf42070c6704b66d6ac75347726','12345678','091123456','Profesor'),(1,'38072948','Henry','Foth','M','henry.foth.m@gmail.com','027e4180beedb29744413a7ea6b84a42','23546772','091320029','Alumno');
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
  `nombreEntidad` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSuperTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreEntidadSubTipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`nombre`),
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
INSERT INTO `sol_atributo_simple` VALUES (6,'Color','Cucha',NULL,NULL),(4,'Nombre','Perro',NULL,NULL),(5,'Raza','Perro',NULL,NULL);
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

-- Dump completed on 2017-09-02 14:29:38
