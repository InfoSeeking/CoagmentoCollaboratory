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
-- Table structure for table `recruits`
--

DROP TABLE IF EXISTS `recruits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recruits` (
  `recruitsID` int(11) NOT NULL AUTO_INCREMENT,
  `registrationID` tinyint(1) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `english` tinyint(1) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  PRIMARY KEY (`recruitsID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recruits`
--

LOCK TABLES `recruits` WRITE;
/*!40000 ALTER TABLE `recruits` DISABLE KEYS */;
INSERT INTO `recruits` VALUES (2,6,'User1','Last1','rgonzal@rutgers.edu',0,'M'),(11,11,'UserA','lastA','rgonzal@rutgers.edu',0,'M'),(12,11,'UserB','lastB','roberto.gonzalez.i@usach.cl',1,'F'),(13,12,'TUserA','LastA','rgonzal@rutgers.edu',1,'M'),(14,12,'TUserB','LastB','roberto.gonzalez.i@usach.cl',0,'F'),(15,12,'TUserC','LastC','chathra.hendahewa@gmail.com',1,'M');
/*!40000 ALTER TABLE `recruits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-08 19:16:18
