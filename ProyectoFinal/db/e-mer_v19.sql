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
  `nombre_curso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_tema` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_subtema` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_ejercicio` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  KEY `FK_nombreCurso_idx` (`nombre_curso`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_curso` (`nombre_curso`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_subtema` (`nombre_subtema`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_ejercicio` (`nombre_ejercicio`),
  KEY `FK_nombreSubTema_idx` (`nombre_subtema`),
  KEY `idx_asc_curso_tema_subtema_ejercicio_nombre_tema` (`nombre_tema`),
  CONSTRAINT `FK_nombreCurso2` FOREIGN KEY (`nombre_curso`) REFERENCES `dim_curso` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreEjercicio2` FOREIGN KEY (`nombre_ejercicio`) REFERENCES `dim_ejercicio` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreSubTema2` FOREIGN KEY (`nombre_subtema`) REFERENCES `dim_subtema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombreTema2` FOREIGN KEY (`nombre_tema`) REFERENCES `dim_tema` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_curso_tema_subtema_ejercicio`
--

LOCK TABLES `asc_curso_tema_subtema_ejercicio` WRITE;
/*!40000 ALTER TABLE `asc_curso_tema_subtema_ejercicio` DISABLE KEYS */;
INSERT INTO `asc_curso_tema_subtema_ejercicio` VALUES ('','Atributos','Atributos Simples','AlumnoPractico'),('','Atributos','Atributos Complejos','EmpleadoEmpresa'),('','Atributos','Atributos Determinantes','AlumnoUniversidadDet'),('ING2017','Atributos','Atributos Simples','AlumnoPractico'),('ING2017','Atributos','Atributos Complejos','EmpleadoEmpresa'),('ING2017','Atributos','Atributos Determinantes','AlumnoUniversidadDet'),('','Atributos','Atributos Simples','PersonaCasa'),('','Atributos','Atributos Complejos','PersonasCasasVerano'),('','Atributos','Atributos Determinantes','AutoPersonaDet'),('','Autorelacion','','EmpleadoSupervisaEmpleados'),('ING2017','Autorelacion','','EmpleadoSupervisaEmpleados'),('','Autorelacion','','JugadorCapitaneaJugador'),('ATI2017','Autorelacion','','EmpleadoSupervisaEmpleados'),('ATI2017','Autorelacion','','JugadorCapitaneaJugador'),('','Categorizacion','Categorizacion Disjunta','AvionesAccidentesDisjunto'),('ING2017','Categorizacion','Categorizacion Disjunta','AvionesAccidentesDisjunto'),('','Categorizacion','Categorizacion Disjunta','EmpresaVehiculosDisjunto'),('','Categorizacion','Categorizacion Completa','EmpresaEmpleadosTotalidad'),('ING2017','Categorizacion','Categorizacion Completa','EmpresaEmpleadosTotalidad'),('','Entidades','','AutoDueno'),('','Entidades','','PerroCucha'),('ING2017','Entidades','','PerroCucha'),('ATI2017','Entidades','','AutoDueno'),('ATI2017','Entidades','','PerroCucha'),('','Entidades Debiles','','AutoMotor'),('ATI2017','Entidades Debiles','','AutoMotor'),('ATI2017','Entidades Debiles','','HospitalSala'),('ING2017','Entidades Debiles','','AutoMotor'),('ING2017','Entidades Debiles','','HospitalSala'),('','Relaciones','Relacion con Atributos','EmpleadoEmpresaRelAtr'),('','Relaciones','Relacion con Atributos','PersonaAutoRelAtr'),('ING2017','Relaciones','Relacion con Atributos','EmpleadoEmpresaRelAtr'),('ATI2017','Relaciones','Relacion con Atributos','EmpleadoEmpresaRelAtr'),('','Relaciones','','ChoferCamionRel'),('','Relaciones','','MusicoInstrumento'),('ATI2017','Atributos','Atributos Simples','AlumnoPractico'),('ATI2017','Atributos','Atributos Complejos','EmpleadoEmpresa'),('ATI2017','Atributos','Atributos Determinantes','AlumnoUniversidadDet'),('ATI2017','Atributos','Atributos Simples','PersonaCasa'),('ATI2017','Atributos','Atributos Complejos','PersonasCasasVerano'),('ATI2017','Atributos','Atributos Determinantes','AutoPersonaDet'),('ATI2017','Categorizacion','Categorizacion Disjunta','AvionesAccidentesDisjunto'),('ATI2017','Categorizacion','Categorizacion Disjunta','EmpresaVehiculosDisjunto'),('ATI2017','Categorizacion','Categorizacion Completa','EmpresaEmpleadosTotalidad');
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
INSERT INTO `asc_curso_usuario` VALUES ('ATI2017','12345679'),('ING2017','12345679'),('ATI2017','38072948');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_curso`
--

LOCK TABLES `dim_curso` WRITE;
/*!40000 ALTER TABLE `dim_curso` DISABLE KEYS */;
INSERT INTO `dim_curso` VALUES (7,'ATI2016',2016,'14-16','2017-05-31','2017-10-01',1),(1,'ATI2017',2017,'20-22','2017-08-07','2017-08-15',0),(9,'ATI2018',2018,'20-20','2017-05-31','2017-10-01',1),(2,'ING2017',2017,'16-18','2017-05-10','2017-09-30',1),(8,'ING2018',2018,'20-22','2017-05-31','2017-12-31',1),(3,'LIC2017',2017,'12-14','2017-08-01','2017-12-01',1);
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
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `letra` longtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`),
  UNIQUE KEY `UNIQUE` (`id_ejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_ejercicio`
--

LOCK TABLES `dim_ejercicio` WRITE;
/*!40000 ALTER TABLE `dim_ejercicio` DISABLE KEYS */;
INSERT INTO `dim_ejercicio` VALUES (5,'AlumnoPractico','Represente la siguiente realidad: Los alumnos realizan  ejercicios. De los alumnos se conoce el nombre y apellido, y de los ejercicios la letra.'),(9,'AlumnoUniversidadDet','Represente la siguiente realidad: Un alumno estudia en la universidad. Del alumno se conocen el nombre y el número de estudiante el cual lo identifica. La universidad tiene nombre.'),(4,'AutoDueno','Represente la siguiente realidad: Un auto tiene un dueño. Del auto interesa guardar el modelo y de su dueño el nombre.'),(20,'AutoMotor','Represente la siguiente realidad: Los  autos tienen motor. De los autos se conoce la matricula, mientras que de los motores la cilindrada.'),(10,'AutoPersonaDet','Represente la siguiente realidad: Una persona tiene un auto. Un auto tiene un solo dueño. De la persona se sabe el nombre y cedula, mientras que del auto la matrícula y rodado.'),(24,'AvionesAccidentesDisjunto','Represente la siguiente realidad: Los aviones tienen accidentes. De los aviones se conoce el nombre y número. Dichos accidentes pueden ocurrir en el mar o en tierra. De los que suceden en tierra conocemos la altura del terreno, mientras que los que suceden en mar la superficie.'),(11,'ChoferCamionRel','Represente la siguiente realidad: Un chofer maneja un camión y un camión es manejado solo por un chofer. El chofer tiene nombre y CI. Del camión se conoce el número de móvil asignado.'),(7,'EmpleadoEmpresa','Represente la siguiente realidad: Los empleados tienen nombre y apellido. Los empleados trabajan en una o varias empresas. En las empresas trabajan uno o más empleados. Las empresas tienen nombre y una dirección compuesta por la calle y el número de puerta.'),(15,'EmpleadoEmpresaCardi','Represente la siguiente realidad: De un empleado se conoce el nombre y apellido. El empleado trabaja en una o más de una empresa. Las empresas tienen nombre y teléfono.'),(13,'EmpleadoEmpresaRelAtr','Represente la siguiente realidad: Los empleados tienen nombre y apellido. Los empleados trabajan en una o varias secciones, mientras que en cada sección puede trabajar uno o muchos empleados. Interesa saber desde que año trabajo allí cada empleado y el nombre de la sección.'),(17,'EmpleadoSupervisaEmpleados','Represente la siguiente realidad: Los empleados supervisan a otros empleados de los cuales se conoce el nombre.'),(22,'EmpresaEmpleadosTotalidad','Represente la siguiente realidad: Las empresas contratan empleados. De la empresa se conoce el nombre y dirección. Los empleados son vendedores-cobradores (cumplen ambos roles a la vez). De los vendedores se sabe el apellido, mientras que de los cobradores el nombre.'),(16,'EmpresaProveedoresCardi','Represente la siguiente realidad: Una empresa tiene de 1 a 10 proveedores. La empresa tiene nombre al igual que los proveedores.'),(25,'EmpresaVehiculosDisjunto','Represente la siguiente realidad: Una empresa compra vehículos. Los vehículos pueden ser camiones o autos pero nunca ambos a la vez. De la empresa se sabe el nombre, mientras que de los camiones la marca y de los autos la cilindradas del motor.'),(21,'HospitalSala','Represente la siguiente realidad: Los hospitales poseen salas. De los mismos se conocen el nombre y dirección. Mientras que, de las salas, el número.'),(18,'JugadorCapitaneaJugador','Represente la siguiente realidad: Los jugadores capitanean a jugadores. De ellos se conocen el nombre y apellido.'),(12,'MusicoInstrumento','Represente la siguiente realidad: Un músico toca un instrumento y un instrumento es tocado solo por un músico. Del músico se conoce el nombre y apellido. Del instrumento interesa guardar el tipo de material del que está compuesto.'),(3,'PerroChulo','Existe un Perro que tiene nombre y raza.El Perro vive en la Cucha que es de color rojo.'),(2,'PerroCucha','Represente la siguiente realidad: Un perro vive en una cucha. Del perro se conoce el nombre y raza, mientras que de la cucha se conoce el color.'),(14,'PersonaAutoRelAtr','Represente la siguiente realidad: De una persona se conocen el Nombre y Apellido. Esa persona tiene uno o varios autos, mientras que un auto solo tiene un dueño. Del el auto interesa saber la cilindradas del motor.'),(6,'PersonaCasa','Represente la siguiente realidad: Una persona tiene nombre y apellido. Esa persona es dueño de una casa, de la cual se sabe el barrio donde está ubicada. La casa tiene solo un dueño.'),(8,'PersonasCasasVerano','Represente la siguiente realidad: Las personas tienen nombre y apellido. Cada persona tiene una casa de veraneo. De las casas se conoce el nombre y la dirección que está compuesta por la calle y el número de puerta.'),(23,'PersonaUniversidadCategorizacion','Represente la siguiente realidad: Las personas estudian en universidades, aunque también trabajan en las mismas. Por lo que las personas pueden ser empleados y alumnos al mismo tiempo. De los empleados se conocen el apellido y de los alumnos el nombre, mientras que de las universidades el nombre.'),(19,'PesonaCuentaBanco','Represente la siguiente realidad: Los clientes pueden poseer cuentas en el banco, una en $ y otra en U$S. De los clientes se conoce el nombre y apellido. Cuando un cliente reúne ciertos requisitos se le puede otorgar una tarjeta para operar sus cuenteas (vinculada a una cuenta que posea). De las cuentas se conoce el numero al igual que des las tarjetas.');
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
INSERT INTO `dim_subtema` VALUES (4,'Atributos Complejos','Algunos atributos pueden estar compuestos por sub-atributos.','Atributos'),(6,'Atributos Determinantes','Se denominan Clave Primaria y denotan el conjunto de atributos que determinan unívocamente a la Entidad, no permitiendo que se repita en la misma Entidad.','Atributos'),(3,'Atributos Simples','Es un atributo que tiene un solo componente, que no se puede dividir en partes más pequeñas que tengan un significado propio','Atributos'),(7,'Cardinalidad','Especifican la cantidad de entidades que se relacionan en la realidad.Tipos:- 1 a 1 Una Entidad se relaciona únicamente con otro y viceversa.- 1 a N Determina que una Entidad puede estar relacionado con varios de la otra Entidad.- N a N Una Entidad puede relacionarse con otra Entidad con ninguna o varios registros ','Relaciones'),(12,'Categorizacion Completa','Si una instancia del supertipo puede ser, a la vez, miembro de más de un subtipo','Categorizacion'),(13,'Categorizacion Disjunta','SI una instancia del supertipo puede ser miembro de, como máximo, uno de los subtipos','Categorizacion'),(8,'Relacion con Atributos','A veces interesa reflejar propiedades de cada instancia de una relación.Cuando la cantidad de atributos es grande puede tener sentido que la relación se denote como una entidad por sí misma.','Relaciones');
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
INSERT INTO `dim_tema` VALUES (6,'Agregaciones','Se denomina Agregacion y representa una abstracción a través de la cual las relaciones se tratan como entidades de un nivel más alto. Se utiliza para expresar relaciones entre relaciones o entre entidades y relaciones. Se representa englobando la relación abstraída y las entidades que participan entre ellas en un rectángulo. En muchos casos de relaciones con orden > 2 no se refleja exactamente la realidad',5),(2,'Atributos','Son características que definen o identifican a una Entidad.De cada entidad del mundo real identificamos las propiedades. A cada propiedad le llamamos ATRIBUTO de la Entidad. Una entidad debe contener al menos UN atributo.',3),(4,'Autorelacion','Relaciones entre una Entidad y si misma',6),(8,'Categorizacion','Mecanismo de Abstracción que permite expresar conjuntos de Entidades que comparte atributos comunes.',8),(1,'Entidades','Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten característicassimilares se denomina Conjunto Representación abstracta de un objeto del mundo real.Un grupo de entidades que comparten características similares se denomina Conjunto de Entidades.',2),(7,'Entidades Debiles','Entidad cuya existencia no tiene sentido en forma aislada.',7),(9,'Introduccion','Modelo conceptual gráfico, usado para representar estructuras que almacenan información. No contiene lenguaje para representar operaciones de manipulación de información. Se utilizan Entidades, Conjuntos de Entidades y Relaciones',1),(3,'Relaciones','Vinculo que permite definir una dependencia entre los conjuntos de dos o más Entidades. Por lo general son Verbos como asignar, asociar. Las relaciones se representan con una figura de diamante y también pueden tener atributos.',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_usuario`
--

LOCK TABLES `dim_usuario` WRITE;
/*!40000 ALTER TABLE `dim_usuario` DISABLE KEYS */;
INSERT INTO `dim_usuario` VALUES (4,'00000000','Sistema','Sistema','M','admin@admin.com','00000000000000000000000000000000','00000000','000000000','Administrativo'),(50,'11111111','Jorge','ajasdjp','F','rperez9594@gmail.com','1bbd886460827015e5d605ed44252251','654','54645','Alumno'),(43,'1234555','Henry','Foth','M','henry.foth.m@gmail.com','cb5e35fe0160c0a3439ecec60523ff30','23546772','091320029','Alumno'),(2,'12345678','Administrativo','Administrativo','M','admin@admin.com','21232f297a57a5a743894a0e4a801fc3','12345678','091123456','Administrativo'),(3,'12345679','Profe','Profe','F','profe@profe.com','1145cbf42070c6704b66d6ac75347726','12345678','091123456','Profesor'),(32,'23546444','Esteban','Quito','M','esteEsMiEmail@hotmail.com','1d77d3d67546e6e79c8dd310eb1c20ab','87987','432132','Alumno'),(51,'31246754','Martha','Aguirre','F','rperez9594@gmail.com','855124cc5f617e881a5f3a66159d8c8e','22457545','099154784','Alumno'),(29,'32165472','Javier ','Garcia','M','esteEsMiEmail@hotmail.com','95585fd7a799220e53e8c43605b4b580','67987','323187','Alumno'),(39,'35378668','Daniel','Jenci','M','esteEsMiEmail@hotmail.com','4fdf57c9b06e457754e333196c8a371e','54987','548676','Profesor'),(1,'38072948','Henry','Foth','M','henry.foth.m@gmail.com','027e4180beedb29744413a7ea6b84a42','23546772','091320029','Alumno'),(47,'40245737','Alejandro','Varcasia','M','alemartin2014@hotmail.com','f3b6964f6433ef6e627fffff292a3342','23546184','099456158','Alumno'),(25,'4026973','Alejandro','Varcasia','M','esteEsMiEmail@hotmail.com','4d9236bf255b698a17d35206ad642ed2','265','654','Alumno'),(44,'40269737','Alejandro','Varcasia','M','alemartin2014@hotmail.com','245f13fa45bff5d1256c98b11686c36e','23546184','099456158','Alumno'),(24,'40269737','Raul','Gomez','M','esteEsMiEmail@hotmail.com','245f13fa45bff5d1256c98b11686c36e','12346','095884306','Alumno'),(45,'42578920','Rodrigo','Perez','M','rperez9594@gmail.com','5b66bc40a6cdd836b6ba07aa02eb39a1','25487655','094315648','Alumno'),(36,'44444444','Lucas','Sugo','M','esteEsMiEmail@hotmail.com','b857eed5c9405c1f2b98048aae506792','54987','68798','Profesor'),(33,'5465484','Anibal','Conde','M','esteEsMiEmail@hotmail.com','d1d069a8b664e133337f5d48b7b4f073','87921351','54','Alumno'),(35,'55555555','Tabare','Vazquez','M','esteEsMiEmail@hotmail.com','f638f4354ff089323d1a5f78fd8f63ca','4879','8798','Profesor'),(49,'58772521','Lacha','Gar','M','rperez9594@gmail.com','83ce6a310c7a9302156af518c6121f39','25487655','094315648','Alumno'),(46,'58792521','Rodrigo','Perez','M','rperez9594@gmail.com','42cdab6e75d666650526c82b47a5d134','25487655','094315648','Alumno'),(48,'65984627','Raul','Gomez','M','rperez9594@gmail.com','0ea21f28e90fd095da00a66c6399cc49','C','094315648','Alumno'),(38,'7777777','Soledad','Perez','M','esteEsMiEmail@hotmail.com','dc0fa7df3d07904a09288bd2d2bb5f40','879','878987','Profesor'),(40,'82444444','Enrique','Abella','M','esteEsMiEmail@hotmail.com','0125cb694cc29a610a0c7989ffaf739a','5987','844','Profesor'),(42,'85858585','Juan','Moreno','M','esteEsMiEmail@hotmail.com','a9d39ae016c9a7238a95c877758784c4','8','4','Profesor'),(30,'89765465','Rodigo','Perez','M','esteEsMiEmail@hotmail.com','00f326e0d9d814fde747dfd2d63b445d','354987','1258789','Alumno'),(37,'9999999','Jose','Dominguez','M','esteEsMiEmail@hotmail.com','283f42764da6dba2522412916b031080','-1','','Profesor');
/*!40000 ALTER TABLE `dim_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_atributo`
--

DROP TABLE IF EXISTS `sol_atributo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_atributo` (
  `id_atributo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_atributo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_atributo` enum('comun','complejo','determinante') COLLATE utf8_spanish_ci NOT NULL,
  `nombre_atributo_multivaluado` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_entidad` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_relacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_mer` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_atributo`),
  KEY `FK_nombre_entidad_idx` (`nombre_entidad`),
  KEY `FK_ci_usuario_idx` (`ci_usuario`),
  KEY `FK_nombre_mer_idx` (`nombre_mer`),
  KEY `FK_nombre_relacion` (`nombre_relacion`),
  CONSTRAINT `FK_ciUsuario` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_entidad` FOREIGN KEY (`nombre_entidad`) REFERENCES `sol_entidad` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_mer` FOREIGN KEY (`nombre_mer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_relacion` FOREIGN KEY (`nombre_relacion`) REFERENCES `sol_relacion` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=529 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_atributo`
--

LOCK TABLES `sol_atributo` WRITE;
/*!40000 ALTER TABLE `sol_atributo` DISABLE KEYS */;
INSERT INTO `sol_atributo` VALUES (1,'Color','comun',NULL,'Cucha',NULL,'PerroCucha','00000000'),(2,'Nombre','comun',NULL,'Perro',NULL,'PerroCucha','00000000'),(3,'Raza','comun',NULL,'Perro',NULL,'PerroCucha','00000000'),(91,'Nombre','comun',NULL,'Dueño',NULL,'AutoDueno','00000000'),(92,'Modelo','comun',NULL,'Auto',NULL,'AutoDueno','00000000'),(101,'Matricula','comun',NULL,'Auto',NULL,'AutoMotor','00000000'),(102,'Cilindrada','comun',NULL,'Motor',NULL,'AutoMotor','00000000'),(123,'Nombre','comun',NULL,'Empleado',NULL,'EmpleadoEmpresaRelAtr','00000000'),(124,'Apellido','comun',NULL,'Empleado',NULL,'EmpleadoEmpresaRelAtr','00000000'),(125,'Nombre','comun',NULL,'Seccion',NULL,'EmpleadoEmpresaRelAtr','00000000'),(129,'Nombre','comun',NULL,'Alumno',NULL,'AlumnoPractico','00000000'),(130,'Apellido','comun',NULL,'Alumno',NULL,'AlumnoPractico','00000000'),(131,'Letra','comun',NULL,'Ejercicio',NULL,'AlumnoPractico','00000000'),(141,'Nombre','comun',NULL,'Empleado',NULL,'EmpleadoEmpresa','00000000'),(142,'Apellido','comun',NULL,'Empleado',NULL,'EmpleadoEmpresa','00000000'),(143,'Nombre','comun',NULL,'Empresa',NULL,'EmpleadoEmpresa','00000000'),(144,'Direccion','complejo','Calle','Empresa',NULL,'EmpleadoEmpresa','00000000'),(145,'Direccion','complejo','Numero','Empresa',NULL,'EmpleadoEmpresa','00000000'),(146,'Nombre','comun',NULL,'Empleado',NULL,'EmpleadoSupervisaEmpleados','00000000'),(151,'Nombre','comun',NULL,'Jugador',NULL,'JugadorCapitaneaJugador','00000000'),(152,'Apellido','comun',NULL,'Jugador',NULL,'JugadorCapitaneaJugador','00000000'),(216,'Nombre','comun',NULL,'Alumno',NULL,'AlumnoUniversidadDet','00000000'),(217,'Numero','determinante',NULL,'Alumno',NULL,'AlumnoUniversidadDet','00000000'),(218,'Nombre','comun',NULL,'Universidad',NULL,'AlumnoUniversidadDet','00000000'),(237,'Año','comun',NULL,NULL,'Trabaja','EmpleadoEmpresaRelAtr','00000000'),(270,'año','comun',NULL,'trabaja',NULL,'EmpleadoEmpresaRelAtr','38072948'),(271,'apellido','comun',NULL,'empleado',NULL,'EmpleadoEmpresaRelAtr','38072948'),(272,'nombre','comun',NULL,'empleado',NULL,'EmpleadoEmpresaRelAtr','38072948'),(281,'letra','comun',NULL,'ejercicio',NULL,'AlumnoPractico','38072948'),(282,'apellido','comun',NULL,'alumno',NULL,'AlumnoPractico','38072948'),(283,'nombre','comun',NULL,'alumno',NULL,'AlumnoPractico','38072948'),(302,'nombre','comun',NULL,'dueño',NULL,'AutoDueno','38072948'),(303,'fsd','comun',NULL,'auto',NULL,'AutoDueno','38072948'),(304,'color','comun',NULL,'cucha',NULL,'PerroCucha','38072948'),(305,'raza','comun',NULL,'perro',NULL,'PerroCucha','38072948'),(306,'nombre','comun',NULL,'perro',NULL,'PerroCucha','38072948'),(310,'Apellido','comun',NULL,'Empleado',NULL,'PersonaUniversidadCategorizacion','00000000'),(311,'Nombre','comun',NULL,'Alumno',NULL,'PersonaUniversidadCategorizacion','00000000'),(312,'Nombre','comun',NULL,'Universidad',NULL,'PersonaUniversidadCategorizacion','00000000'),(418,'cilindrada','comun',NULL,'motor',NULL,'AutoMotor','38072948'),(419,'matricula','comun',NULL,'auto',NULL,'AutoMotor','38072948'),(457,'nombre','comun',NULL,'empleado',NULL,'PersonaUniversidadCategorizacion','38072948'),(458,'apellido','comun',NULL,'alumno',NULL,'PersonaUniversidadCategorizacion','38072948'),(459,'nombre','comun',NULL,'universidad',NULL,'PersonaUniversidadCategorizacion','38072948'),(463,'nombre','comun',NULL,'universidad',NULL,'AlumnoUniversidadDet','38072948'),(464,'nombre','determinante',NULL,'alumno',NULL,'AlumnoUniversidadDet','38072948'),(465,'numero','comun',NULL,'alumno',NULL,'AlumnoUniversidadDet','38072948'),(466,'apellido','comun',NULL,'jugador',NULL,'JugadorCapitaneaJugador','38072948'),(467,'nombre','comun',NULL,'jugador',NULL,'JugadorCapitaneaJugador','38072948'),(470,'Apellido','comun',NULL,'Vendedor',NULL,'EmpresaEmpleadosTotalidad','00000000'),(471,'Nombre','comun',NULL,'Cobrador',NULL,'EmpresaEmpleadosTotalidad','00000000'),(472,'Nombre','comun',NULL,'Empresa',NULL,'EmpresaEmpleadosTotalidad','00000000'),(473,'Direccion','comun',NULL,'Empresa',NULL,'EmpresaEmpleadosTotalidad','00000000'),(486,'nombre','comun',NULL,'vendedor',NULL,'EmpresaEmpleadosTotalidad','38072948'),(487,'apellido','comun',NULL,'cobrador',NULL,'EmpresaEmpleadosTotalidad','38072948'),(488,'direccion','comun',NULL,'empresa',NULL,'EmpresaEmpleadosTotalidad','38072948'),(489,'nombre','comun',NULL,'empresa',NULL,'EmpresaEmpleadosTotalidad','38072948'),(490,'Superficie','comun',NULL,'Mar',NULL,'AvionesAccidentesDisjunto','00000000'),(491,'Altura','comun',NULL,'Tierra',NULL,'AvionesAccidentesDisjunto','00000000'),(492,'Nombre','comun',NULL,'Avion',NULL,'AvionesAccidentesDisjunto','00000000'),(493,'Numero','comun',NULL,'Avion',NULL,'AvionesAccidentesDisjunto','00000000'),(506,'Nombre','comun',NULL,'Hospital',NULL,'HospitalSala','00000000'),(507,'Direccion','comun',NULL,'Hospital',NULL,'HospitalSala','00000000'),(508,'Numero','comun',NULL,'Sala',NULL,'HospitalSala','00000000'),(512,'numero','comun',NULL,'sala',NULL,'HospitalSala','38072948'),(513,'direccion','comun',NULL,'hospital',NULL,'HospitalSala','38072948'),(514,'nombre','comun',NULL,'hospital',NULL,'HospitalSala','38072948'),(515,'nombre','comun',NULL,'empleado',NULL,'EmpleadoSupervisaEmpleados','38072948'),(520,'altura','comun',NULL,'mar',NULL,'AvionesAccidentesDisjunto','38072948'),(521,'superficie','comun',NULL,'tierra',NULL,'AvionesAccidentesDisjunto','38072948'),(522,'numero','comun',NULL,'avion',NULL,'AvionesAccidentesDisjunto','38072948'),(523,'nombre','comun',NULL,'avion',NULL,'AvionesAccidentesDisjunto','38072948'),(524,'nombre','comun',NULL,'empresa',NULL,'EmpleadoEmpresa','38072948'),(525,'direccion','complejo','numero','empresa',NULL,'EmpleadoEmpresa','38072948'),(526,'direccion','complejo','calle','empresa',NULL,'EmpleadoEmpresa','38072948'),(527,'apellido','comun',NULL,'empleado',NULL,'EmpleadoEmpresa','38072948'),(528,'nombre','comun',NULL,'empleado',NULL,'EmpleadoEmpresa','38072948');
/*!40000 ALTER TABLE `sol_atributo` ENABLE KEYS */;
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
  `tipo_entidad` enum('comun','debil','supertipo','subtipo') COLLATE utf8_spanish_ci NOT NULL,
  `entidad_supertipo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_categorizacion` enum('N/A','completa','disjunta') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/A',
  `nombre_mer` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`nombre_mer`,`ci_usuario`,`tipo_entidad`,`tipo_categorizacion`),
  UNIQUE KEY `id_entidad` (`id_entidad`),
  KEY `FK_nombre_mer_idx` (`nombre_mer`),
  KEY `FK_ci_usuario_idx` (`ci_usuario`),
  CONSTRAINT `FK_ci_usuario_2` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombre_mer_2` FOREIGN KEY (`nombre_mer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=634 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_entidad`
--

LOCK TABLES `sol_entidad` WRITE;
/*!40000 ALTER TABLE `sol_entidad` DISABLE KEYS */;
INSERT INTO `sol_entidad` VALUES (601,'Accidente','supertipo',NULL,'disjunta','AvionesAccidentesDisjunto','00000000'),(628,'accidente','supertipo',NULL,'disjunta','AvionesAccidentesDisjunto','38072948'),(349,'Alumno','comun',NULL,'N/A','AlumnoPractico','00000000'),(457,'alumno','comun',NULL,'N/A','AlumnoPractico','38072948'),(404,'Alumno','comun',NULL,'N/A','AlumnoUniversidadDet','00000000'),(577,'alumno','comun',NULL,'N/A','AlumnoUniversidadDet','38072948'),(477,'Alumno','subtipo','Persona','completa','PersonaUniversidadCategorizacion','00000000'),(572,'alumno','subtipo','persona','completa','PersonaUniversidadCategorizacion','38072948'),(316,'Auto','comun',NULL,'N/A','AutoDueno','00000000'),(469,'auto','comun',NULL,'N/A','AutoDueno','38072948'),(327,'Auto','debil',NULL,'N/A','AutoMotor','00000000'),(549,'auto','debil',NULL,'N/A','AutoMotor','38072948'),(604,'Avion','comun',NULL,'N/A','AvionesAccidentesDisjunto','00000000'),(631,'avion','comun',NULL,'N/A','AvionesAccidentesDisjunto','38072948'),(583,'Cobrador','subtipo','Empleado','completa','EmpresaEmpleadosTotalidad','00000000'),(599,'cobrador','subtipo','empleado','completa','EmpresaEmpleadosTotalidad','38072948'),(15,'Cucha','comun',NULL,'N/A','PerroCucha','00000000'),(470,'cucha','comun',NULL,'N/A','PerroCucha','38072948'),(317,'Dueño','comun',NULL,'N/A','AutoDueno','00000000'),(468,'dueño','comun',NULL,'N/A','AutoDueno','38072948'),(350,'Ejercicio','comun',NULL,'N/A','AlumnoPractico','00000000'),(456,'ejercicio','comun',NULL,'N/A','AlumnoPractico','38072948'),(355,'Empleado','comun',NULL,'N/A','EmpleadoEmpresa','00000000'),(633,'empleado','comun',NULL,'N/A','EmpleadoEmpresa','38072948'),(347,'Empleado','comun',NULL,'N/A','EmpleadoEmpresaRelAtr','00000000'),(449,'empleado','comun',NULL,'N/A','EmpleadoEmpresaRelAtr','38072948'),(357,'Empleado','comun',NULL,'N/A','EmpleadoSupervisaEmpleados','00000000'),(623,'empleado','comun',NULL,'N/A','EmpleadoSupervisaEmpleados','38072948'),(581,'Empleado','supertipo',NULL,'completa','EmpresaEmpleadosTotalidad','00000000'),(597,'empleado','supertipo',NULL,'completa','EmpresaEmpleadosTotalidad','38072948'),(476,'Empleado','subtipo','Persona','completa','PersonaUniversidadCategorizacion','00000000'),(571,'empleado','subtipo','persona','completa','PersonaUniversidadCategorizacion','38072948'),(356,'Empresa','comun',NULL,'N/A','EmpleadoEmpresa','00000000'),(632,'empresa','comun',NULL,'N/A','EmpleadoEmpresa','38072948'),(584,'Empresa','comun',NULL,'N/A','EmpresaEmpleadosTotalidad','00000000'),(600,'empresa','comun',NULL,'N/A','EmpresaEmpleadosTotalidad','38072948'),(617,'Hospital','comun',NULL,'N/A','HospitalSala','00000000'),(622,'hospital','comun',NULL,'N/A','HospitalSala','38072948'),(362,'Jugador','comun',NULL,'N/A','JugadorCapitaneaJugador','00000000'),(578,'jugador','comun',NULL,'N/A','JugadorCapitaneaJugador','38072948'),(602,'Mar','subtipo','Accidente','disjunta','AvionesAccidentesDisjunto','00000000'),(629,'mar','subtipo','accidente','disjunta','AvionesAccidentesDisjunto','38072948'),(328,'Motor','comun',NULL,'N/A','AutoMotor','00000000'),(548,'motor','comun',NULL,'N/A','AutoMotor','38072948'),(195,'Perro','comun',NULL,'N/A','PerroCucha','00000000'),(471,'perro','comun',NULL,'N/A','PerroCucha','38072948'),(474,'Persona','supertipo',NULL,'completa','PersonaUniversidadCategorizacion','00000000'),(570,'persona','supertipo',NULL,'completa','PersonaUniversidadCategorizacion','38072948'),(618,'Sala','debil',NULL,'N/A','HospitalSala','00000000'),(621,'sala','comun',NULL,'N/A','HospitalSala','38072948'),(348,'Seccion','comun',NULL,'N/A','EmpleadoEmpresaRelAtr','00000000'),(603,'Tierra','subtipo','Accidente','disjunta','AvionesAccidentesDisjunto','00000000'),(630,'tierra','subtipo','accidente','disjunta','AvionesAccidentesDisjunto','38072948'),(448,'trabaja','comun',NULL,'N/A','EmpleadoEmpresaRelAtr','38072948'),(405,'Universidad','comun',NULL,'N/A','AlumnoUniversidadDet','00000000'),(576,'universidad','comun',NULL,'N/A','AlumnoUniversidadDet','38072948'),(475,'Universidad','comun',NULL,'N/A','PersonaUniversidadCategorizacion','00000000'),(573,'universidad','comun',NULL,'N/A','PersonaUniversidadCategorizacion','38072948'),(582,'Vendedor','subtipo','Empleado','completa','EmpresaEmpleadosTotalidad','00000000'),(598,'vendedor','subtipo','empleado','completa','EmpresaEmpleadosTotalidad','38072948');
/*!40000 ALTER TABLE `sol_entidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sol_mer`
--

DROP TABLE IF EXISTS `sol_mer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sol_mer` (
  `id_mer` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('sol_sistema','sol_alumno') COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_ejercicio` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `restriccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `inicioEjercicio` datetime DEFAULT NULL,
  `finEjercicio` datetime DEFAULT NULL,
  PRIMARY KEY (`nombre`,`tipo`,`ci_usuario`,`nombre_ejercicio`),
  UNIQUE KEY `id_mer_UNIQUE` (`id_mer`),
  KEY `FK_ci_usuario_idx` (`ci_usuario`),
  KEY `idx_sol_mer_nombre` (`nombre`),
  KEY `FK_nombre_ejercicio_idx` (`nombre_ejercicio`)
) ENGINE=InnoDB AUTO_INCREMENT=367 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_mer`
--

LOCK TABLES `sol_mer` WRITE;
/*!40000 ALTER TABLE `sol_mer` DISABLE KEYS */;
INSERT INTO `sol_mer` VALUES (229,'AlumnoPractico','sol_sistema','00000000','AlumnoPractico',NULL,NULL,NULL),(286,'AlumnoPractico','sol_alumno','38072948','AlumnoPractico','','2017-10-27 23:57:10','2017-10-27 23:57:47'),(260,'AlumnoUniversidadDet','sol_sistema','00000000','AlumnoUniversidadDet',NULL,NULL,NULL),(347,'AlumnoUniversidadDet','sol_alumno','38072948','AlumnoUniversidadDet','','2017-10-29 01:15:18','2017-10-29 01:15:41'),(210,'AutoDueno','sol_sistema','00000000','AutoDueno',NULL,NULL,NULL),(292,'AutoDueno','sol_alumno','38072948','AutoDueno','fdsasadfdsafsafdsa','2017-10-28 00:02:51','2017-10-28 00:03:14'),(217,'AutoMotor','sol_sistema','00000000','AutoMotor',NULL,NULL,NULL),(336,'AutoMotor','sol_alumno','38072948','AutoMotor','','2017-10-29 00:26:28','2017-10-29 00:27:15'),(356,'AvionesAccidentesDisjunto','sol_sistema','00000000','AvionesAccidentesDisjunto',NULL,NULL,NULL),(365,'AvionesAccidentesDisjunto','sol_alumno','38072948','AvionesAccidentesDisjunto','','2017-10-29 18:47:44','2017-10-29 18:49:00'),(232,'EmpleadoEmpresa','sol_sistema','00000000','EmpleadoEmpresa',NULL,NULL,NULL),(366,'EmpleadoEmpresa','sol_alumno','38072948','EmpleadoEmpresa','','2017-10-29 19:42:19','2017-10-29 19:44:15'),(228,'EmpleadoEmpresaRelAtr','sol_sistema','00000000','EmpleadoEmpresaRelAtr',NULL,NULL,NULL),(282,'EmpleadoEmpresaRelAtr','sol_alumno','38072948','EmpleadoEmpresaRelAtr','','2017-10-27 23:53:12','2017-10-27 23:53:56'),(233,'EmpleadoSupervisaEmpleados','sol_sistema','00000000','EmpleadoSupervisaEmpleados',NULL,NULL,NULL),(363,'EmpleadoSupervisaEmpleados','sol_alumno','38072948','EmpleadoSupervisaEmpleados','','2017-10-29 18:45:22','2017-10-29 18:45:56'),(351,'EmpresaEmpleadosTotalidad','sol_sistema','00000000','EmpresaEmpleadosTotalidad',NULL,NULL,NULL),(355,'EmpresaEmpleadosTotalidad','sol_alumno','38072948','EmpresaEmpleadosTotalidad','','2017-10-29 13:26:22','2017-10-29 13:27:11'),(360,'HospitalSala','sol_sistema','00000000','HospitalSala',NULL,NULL,NULL),(362,'HospitalSala','sol_alumno','38072948','HospitalSala','','2017-10-29 16:05:43','2017-10-29 16:06:20'),(238,'JugadorCapitaneaJugador','sol_sistema','00000000','JugadorCapitaneaJugador',NULL,NULL,NULL),(348,'JugadorCapitaneaJugador','sol_alumno','38072948','JugadorCapitaneaJugador','','2017-10-29 01:15:58','2017-10-29 01:16:26'),(47,'PerroCucha','sol_sistema','00000000','PerroCucha',NULL,NULL,NULL),(293,'PerroCucha','sol_alumno','38072948','PerroCucha','','2017-10-28 00:03:21','2017-10-28 00:03:51'),(296,'PersonaUniversidadCategorizacion','sol_sistema','00000000','PersonaUniversidadCategorizacion',NULL,NULL,NULL),(345,'PersonaUniversidadCategorizacion','sol_alumno','38072948','PersonaUniversidadCategorizacion','','2017-10-29 01:04:34','2017-10-29 01:05:29');
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
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_entidadA` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_entidadB` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_mer` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `ci_usuario` char(8) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`,`nombre_entidadA`,`nombre_entidadB`,`nombre_mer`,`ci_usuario`),
  UNIQUE KEY `id_relacion_UNIQUE` (`id_relacion`),
  KEY `FK_ci_usuario_idx` (`ci_usuario`),
  KEY `FK_nombreMer_idx` (`nombre_mer`),
  CONSTRAINT `FK_ciUsu` FOREIGN KEY (`ci_usuario`) REFERENCES `dim_usuario` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_nombMer` FOREIGN KEY (`nombre_mer`) REFERENCES `sol_mer` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sol_relacion`
--

LOCK TABLES `sol_relacion` WRITE;
/*!40000 ALTER TABLE `sol_relacion` DISABLE KEYS */;
INSERT INTO `sol_relacion` VALUES (4,'Vive','Perro','Cucha','PerroCucha','00000000'),(34,'Tiene','Dueño','Auto','AutoDueno','00000000'),(39,'Tiene','Auto','Motor','AutoMotor','00000000'),(50,'Trabaja','Empleado','Seccion','EmpleadoEmpresaRelAtr','00000000'),(51,'Realiza','Alumno','Ejercicio','AlumnoPractico','00000000'),(54,'Trabaja','Empleado','Empresa','EmpleadoEmpresa','00000000'),(55,'Supervisa','Empleado','Empleado','EmpleadoSupervisaEmpleados','00000000'),(57,'Capitanea','Jugador','Jugador','JugadorCapitaneaJugador','00000000'),(73,'Estudia','Alumno','Universidad','AlumnoUniversidadDet','00000000'),(85,'seccion','trabaja','empleado','EmpleadoEmpresaRelAtr','38072948'),(89,'fdsa','ejercicio','alumno','AlumnoPractico','38072948'),(95,'tiene','dueño','auto','AutoDueno','38072948'),(96,'vive','cucha','perro','PerroCucha','38072948'),(99,'Estudia','Persona','Universidad','PersonaUniversidadCategorizacion','00000000'),(136,'tiene','motor','auto','AutoMotor','38072948'),(145,'estudia','universidad','persona','PersonaUniversidadCategorizacion','38072948'),(147,'estudia','universidad','alumno','AlumnoUniversidadDet','38072948'),(148,'capitanea','jugador','jugador','JugadorCapitaneaJugador','38072948'),(151,'Contrata','Empleado','Empresa','EmpresaEmpleadosTotalidad','00000000'),(155,'contrata','empresa','empleado','EmpresaEmpleadosTotalidad','38072948'),(156,'Tiene','Accidente','Avion','AvionesAccidentesDisjunto','00000000'),(160,'Posee','Hospital','Sala','HospitalSala','00000000'),(162,'posee','sala','hospital','HospitalSala','38072948'),(163,'supervisa','empleado','empleado','EmpleadoSupervisaEmpleados','38072948'),(165,'tiene','avion','accidente','AvionesAccidentesDisjunto','38072948'),(166,'trabaja','empresa','empleado','EmpleadoEmpresa','38072948');
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

-- Dump completed on 2017-10-29 17:48:39
