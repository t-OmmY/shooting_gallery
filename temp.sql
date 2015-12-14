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
-- Table structure for table `caliber`
--

DROP TABLE IF EXISTS `caliber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caliber` (
  `caliber_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `diameter` decimal(10,2) NOT NULL,
  PRIMARY KEY (`caliber_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caliber`
--

LOCK TABLES `caliber` WRITE;
/*!40000 ALTER TABLE `caliber` DISABLE KEYS */;
INSERT INTO `caliber` VALUES (1,'first caliber',4.34),(2,'second caliler',3.14),(3,'third caliber',5.43);
/*!40000 ALTER TABLE `caliber` ENABLE KEYS */;
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
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'Green'),(2,'Blue'),(3,'Red'),(4,'Black'),(5,'Yellow'),(6,'Gray');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hits`
--

LOCK TABLES `hits` WRITE;
/*!40000 ALTER TABLE `hits` DISABLE KEYS */;
INSERT INTO `hits` VALUES (1,1,134,143),(2,1,254,223),(3,1,334,343),(4,1,454,423),(5,1,134,143),(6,1,254,223),(7,1,334,343),(8,1,454,423),(9,2,134,143),(10,2,254,223),(11,2,334,343),(12,2,454,423),(13,3,134,143),(14,3,254,223),(15,3,334,343),(16,3,454,423),(17,6,134,143),(18,6,254,223),(19,6,334,343),(20,6,454,423),(21,6,134,143),(22,6,254,223),(23,6,334,343),(24,6,454,423),(25,6,1,2),(26,6,3,4),(27,6,5,6),(28,6,0,0),(29,6,21,32),(30,6,32,5656),(31,6,123,12332),(35,6,0,0),(36,7,1,2),(37,7,3,4),(38,7,64352,8765432),(39,7,122,23),(40,7,234,4243),(41,7,122,23),(42,12,1,2),(43,13,1,1),(44,13,2,2),(45,13,3,3),(46,13,4,4),(47,13,5,5),(48,14,6,6),(49,14,7,7),(50,14,8,8),(51,14,9,9),(52,15,10,10),(53,15,11,11),(54,15,12,12);
/*!40000 ALTER TABLE `hits` ENABLE KEYS */;
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
  `scope` int(11) NOT NULL,
  `firestyle` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`serie_id`),
  KEY `session_id` (`session_id`),
  KEY `color` (`color_id`),
  CONSTRAINT `series_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE CASCADE,
  CONSTRAINT `series_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` VALUES (1,3,25,1,3,'test_name_serie','some content',1,1),(2,3,25,1,3,'test_name_serie','some content',1,6),(3,3,25,1,3,'test_name_serie','some content',1,7),(6,2,123,3,2,'lklk','tyuio',4,9),(7,4,50,1,2,'ÐŸÐµÑ€ÐµÐ½Ð¾Ñ 1','',1,10),(8,1,50,2,1,'you','lkj',3,19),(9,1,50,2,1,'you','lkj',3,19),(10,4,0,1,1,'asdf','sdf',3,19),(11,3,34,1,2,'denys','nonono',1,21),(12,4,50,1,1,'test','',3,22),(13,1,50,2,1,'first serie','',1,26),(14,2,50,2,2,'second serie','',2,26),(15,6,50,1,1,'third try','no comments',3,26);
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
  KEY `caliber_id` (`caliber_id`),
  KEY `target_id` (`target_id`),
  KEY `shooter_id` (`shooter_id`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`target_id`) REFERENCES `targets` (`target_id`) ON DELETE CASCADE,
  CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`shooter_id`) REFERENCES `shooters` (`shooter_id`) ON DELETE CASCADE,
  CONSTRAINT `sessions_ibfk_3` FOREIGN KEY (`caliber_id`) REFERENCES `caliber` (`caliber_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,'2015-12-10','test',1,3,1),(2,'2015-12-10','test',1,3,1),(3,'2015-12-10','test',1,3,1),(4,'2015-12-10','test',1,3,1),(5,'2015-12-09','My first session',2,3,1),(6,'2015-12-10','test',1,3,1),(7,'2015-12-10','test',1,3,1),(9,'2015-12-01','last test',2,3,1),(10,'2015-12-12','ÐŸÐµÑ€ÐµÐ½Ð¾ÑÑ‹',2,1,2),(11,'2015-12-31','ÐŸÑ€Ð¸Ð²ÐµÑ‚, ÐŸÑ€Ð¸Ð²ÐµÑ‚',3,2,2),(12,'2015-12-15','Ñ‹Ð²Ð°',3,1,3),(13,'2015-12-15','Ñ‹Ð²Ð°',3,1,3),(14,'2015-12-01','Ð´Ð»Ð¾',1,2,3),(15,'2015-12-01','Ð´Ð»Ð¾',1,2,3),(16,'2015-12-01','Ð´Ð»Ð¾',1,2,3),(17,'2015-12-09','jtllo',2,2,3),(18,'2015-12-16','hello',3,1,2),(19,'2015-12-16','hello',3,1,2),(20,'2015-12-16','111',3,1,1),(21,'2015-12-08','asdf',1,2,2),(22,'2015-12-09','first MVC',2,3,2),(23,'2015-12-02','asff',1,1,1),(24,'2015-12-09','kjj;lj',1,1,1),(25,'2015-12-03','Hello',1,1,1),(26,'2015-12-31','Happy New Year!',1,1,1),(27,'2015-12-17','ljhjk',1,1,1);
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
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  PRIMARY KEY (`shooter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shooters`
--

LOCK TABLES `shooters` WRITE;
/*!40000 ALTER TABLE `shooters` DISABLE KEYS */;
INSERT INTO `shooters` VALUES (1,'Dmytro','Krasnykh'),(2,'Alexandr','Krasnykh'),(3,'Denys','Krasnykh');
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
  PRIMARY KEY (`target_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targets`
--

LOCK TABLES `targets` WRITE;
/*!40000 ALTER TABLE `targets` DISABLE KEYS */;
INSERT INTO `targets` VALUES (1,'target #4'),(2,'target #7'),(3,'circle'),(4,'triangle');
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

-- Dump completed on 2015-12-15  1:24:52
