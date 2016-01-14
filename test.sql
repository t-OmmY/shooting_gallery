-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: weber
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `calibers`
--

DROP TABLE IF EXISTS `calibers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calibers` (
  `caliber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `diameter` decimal(10,2) NOT NULL,
  PRIMARY KEY (`caliber_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calibers`
--

LOCK TABLES `calibers` WRITE;
/*!40000 ALTER TABLE `calibers` DISABLE KEYS */;
INSERT INTO `calibers` VALUES (1,'first caliber',4.34),(2,'second caliler',3.14),(3,'third caliber',5.43);
/*!40000 ALTER TABLE `calibers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `color_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `color_name` varchar(45) NOT NULL,
  PRIMARY KEY (`color_id`),
  UNIQUE KEY `color_name` (`color_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (4,'Black'),(2,'Blue'),(6,'Gray'),(1,'Green'),(3,'Red'),(5,'Yellow');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firestyle`
--

DROP TABLE IF EXISTS `firestyle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firestyle` (
  `firestyle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firestyle_name` varchar(100) NOT NULL,
  PRIMARY KEY (`firestyle_id`),
  UNIQUE KEY `firestyle_name` (`firestyle_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firestyle`
--

LOCK TABLES `firestyle` WRITE;
/*!40000 ALTER TABLE `firestyle` DISABLE KEYS */;
INSERT INTO `firestyle` VALUES (1,'fireStyle1'),(2,'fireStyle2'),(3,'fireStyle3'),(4,'fireStyle4');
/*!40000 ALTER TABLE `firestyle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hits`
--

DROP TABLE IF EXISTS `hits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hits` (
  `hit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serie_id` int(10) unsigned NOT NULL,
  `x` decimal(10,0) NOT NULL,
  `y` decimal(10,0) NOT NULL,
  PRIMARY KEY (`hit_id`),
  KEY `serie_id` (`serie_id`),
  CONSTRAINT `hits_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `series` (`serie_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hits`
--

LOCK TABLES `hits` WRITE;
/*!40000 ALTER TABLE `hits` DISABLE KEYS */;
INSERT INTO `hits` VALUES (64,21,3,3),(65,21,1,2),(70,23,456,99999994),(71,23,67,76),(72,30,23321,2313),(76,32,2,1);
/*!40000 ALTER TABLE `hits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) CHARACTER SET utf8mb4 NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (15,'Denys','den@urk.net','kjh','2016-01-13 17:01:30'),(16,'Admin','xperiask17ise@gmail.com','try to find some mistakes','2016-01-13 17:08:45'),(17,'Dasha','j-boo@mail.ru','Who are you?','2016-01-13 17:09:43'),(18,'John','f@ukr.net','How much it cost?','2016-01-13 17:10:07'),(19,'Jack','asdfs@urk.net','I am proud that I was here. Thanks yoou','2016-01-13 17:10:42'),(20,'ро','ton@ukr.net','just some letter','2016-01-13 17:10:55'),(21,'asdf','asdfs@urk.net','tra ra ra arla','2016-01-13 17:11:06'),(22,'Kim','denis@ukr.net','The last one have to be good one','2016-01-13 17:11:25'),(23,'Sam','f@ukr.net','hello Wolrd','2016-01-13 17:11:51'),(24,'Luijy','Luino@mail.net','Where is my Mario?','2016-01-13 17:12:42'),(25,'Admin','xperiask17ise@gmail.com','ваыдаоаоыаождлыоддддддддддддддддддд длооооооооооооооооооооооо ыдлоооооооооооооооооооооооооооооуыдло дл оызхщ шыфзал луоафрцушгмлфты баьф.юбаь жывао аждлыаолдо о  одло одоаждцкодлткафарщ л оджаожщуафладжваож оафцуоажфуаоцулаофжлуаолжуаоы','2016-01-13 17:38:49');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scope`
--

DROP TABLE IF EXISTS `scope`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scope` (
  `scope_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope_name` varchar(100) NOT NULL,
  PRIMARY KEY (`scope_id`),
  UNIQUE KEY `scope_name` (`scope_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scope`
--

LOCK TABLES `scope` WRITE;
/*!40000 ALTER TABLE `scope` DISABLE KEYS */;
INSERT INTO `scope` VALUES (1,'Scope 1'),(2,'Scope 2'),(3,'Scope 3'),(4,'Scope 4');
/*!40000 ALTER TABLE `scope` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series` (
  `serie_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `color_id` int(11) unsigned NOT NULL,
  `range` int(11) NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `firestyle_id` int(10) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`serie_id`),
  UNIQUE KEY `name` (`name`),
  KEY `session_id` (`session_id`),
  KEY `color` (`color_id`),
  KEY `scope` (`scope_id`),
  KEY `firestyle` (`firestyle_id`),
  CONSTRAINT `series_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE CASCADE,
  CONSTRAINT `series_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE CASCADE,
  CONSTRAINT `series_ibfk_3` FOREIGN KEY (`scope_id`) REFERENCES `scope` (`scope_id`) ON DELETE CASCADE,
  CONSTRAINT `series_ibfk_4` FOREIGN KEY (`firestyle_id`) REFERENCES `firestyle` (`firestyle_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` VALUES (21,1,30,3,2,'some','asf',1,42),(23,1,23,1,1,'или нет','kjhjhjh',3,42),(26,1,30,1,1,'Нормальное имя','',1,58),(30,4,30,1,1,'133','3131',1,42),(32,4,30,1,1,'Выстрел из-за препятствия','фа',1,83);
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `session_name` varchar(45) NOT NULL,
  `target_id` int(10) unsigned NOT NULL,
  `shooter_id` int(10) unsigned NOT NULL,
  `caliber_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_name` (`session_name`),
  KEY `caliber_id` (`caliber_id`),
  KEY `target_id` (`target_id`),
  KEY `shooter_id` (`shooter_id`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`target_id`) REFERENCES `targets` (`target_id`) ON DELETE CASCADE,
  CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`shooter_id`) REFERENCES `shooters` (`shooter_id`) ON DELETE CASCADE,
  CONSTRAINT `sessions_ibfk_3` FOREIGN KEY (`caliber_id`) REFERENCES `calibers` (`caliber_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (42,'2015-12-09','try to fire',2,2,2),(58,'2016-01-06','Тт тоже есть что то',3,1,1),(83,'2016-01-07','Тут есть серии',3,1,1),(90,'2016-01-14','Норм имя',3,1,1),(91,'2016-01-12','test ses',3,0,1);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shooters`
--

DROP TABLE IF EXISTS `shooters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shooters` (
  `shooter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`shooter_id`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shooters`
--

LOCK TABLES `shooters` WRITE;
/*!40000 ALTER TABLE `shooters` DISABLE KEYS */;
INSERT INTO `shooters` VALUES (0,'Admin','Admin','Admin','dvkrasnykh@ukr.net','5fc7f41d0f76f006141df89b92018dfe'),(1,'weber','Dmytro','Krasnykh','web@ukr.net','70a266e23c90409e4521fc3631e4ce80'),(2,'alexdesign','Alexandr','Krasnykh','alex@ukr.net','70a266e23c90409e4521fc3631e4ce80'),(7,'t-ommY','Denys','Krasnykh','den@urk.net','70a266e23c90409e4521fc3631e4ce80'),(14,'say_nani','Даша','Дейнекова',NULL,'vk_id10407424'),(25,'Денис66092230','Денис','Краснов',NULL,'vk_id66092230'),(27,'Денис113379253969686637383','Денис','Красных','xperiask17ise@gmail.com','Google_id113379253969686637383'),(28,'tommy','Danyla','sdf','foo@ukr.net','bd7b5533ae31096557d516cb92b6a924');
/*!40000 ALTER TABLE `shooters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `targets`
--

DROP TABLE IF EXISTS `targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `targets` (
  `target_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`target_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targets`
--

LOCK TABLES `targets` WRITE;
/*!40000 ALTER TABLE `targets` DISABLE KEYS */;
INSERT INTO `targets` VALUES (3,'circle'),(1,'target #4'),(2,'target #7'),(4,'triangle');
/*!40000 ALTER TABLE `targets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-14 21:43:32
