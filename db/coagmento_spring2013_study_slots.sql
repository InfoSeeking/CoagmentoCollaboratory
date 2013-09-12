CREATE DATABASE  IF NOT EXISTS `coagmento_spring2013_study` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `coagmento_spring2013_study`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: coagmento_spring2013_study
-- ------------------------------------------------------
-- Server version	5.1.58-community

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
-- Table structure for table `slots`
--

DROP TABLE IF EXISTS `slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slots` (
  `slotID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `day` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `available` tinyint(1) DEFAULT '1',
  `week` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`slotID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slots`
--

LOCK TABLES `slots` WRITE;
/*!40000 ALTER TABLE `slots` DISABLE KEYS */;
INSERT INTO `slots` VALUES (1,'2015-09-07','Monday','09:00',9,1,'Sep 9th'),(2,'2015-09-07','Monday','10:00',10,1,'Sep 9th'),(3,'2015-09-07','Monday','11:00',11,0,'Sep 9th'),(4,'2015-09-07','Monday','12:00',12,1,'Sep 9th'),(5,'2015-09-07','Monday','13:00',13,1,'Sep 9th'),(6,'2015-09-07','Monday','14:00',14,1,'Sep 9th'),(7,'2015-09-07','Monday','15:00',15,1,'Sep 9th'),(8,'2015-09-08','Tuesday','11:00',11,1,'Sep 9th'),(9,'2015-09-08','Tuesday','12:00',12,1,'Sep 9th'),(10,'2015-09-08','Tuesday','15:00',15,1,'Sep 9th'),(11,'2015-09-08','Tuesday','19:00',19,1,'Sep 9th'),(12,'2015-09-10','Thursday','10:00',10,1,'Sep 9th'),(13,'2015-09-10','Thursday','12:00',12,1,'Sep 9th'),(14,'2015-09-10','Thursday','13:00',13,1,'Sep 9th'),(15,'2015-09-10','Thursday','14:00',14,1,'Sep 9th'),(16,'2015-09-14','Monday','10:00',10,1,'Sep 14th'),(17,'2015-09-14','Monday','11:00',11,0,'Sep 14th'),(18,'2015-09-14','Monday','15:00',15,1,'Sep 14th'),(19,'2015-09-14','Monday','20:00',20,1,'Sep 14th'),(20,'2015-09-15','Tuesday','12:00',12,1,'Sep 14th'),(21,'2015-09-15','Tuesday','14:00',14,0,'Sep 14th'),(22,'2015-09-15','Tuesday','20:00',20,1,'Sep 14th'),(23,'2015-09-19','Friday','15:00',15,1,'Sep 14th');
/*!40000 ALTER TABLE `slots` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-08 19:16:14
