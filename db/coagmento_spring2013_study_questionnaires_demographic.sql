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
-- Table structure for table `questionnaires_demographic`
--

DROP TABLE IF EXISTS `questionnaires_demographic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaires_demographic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `program` varchar(20) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `searchExperience` smallint(4) DEFAULT NULL,
  `oftenSearch` varchar(20) DEFAULT NULL,
  `oftenTextMsg` varchar(20) DEFAULT NULL,
  `oftenProjectWithOthers` varchar(20) DEFAULT NULL,
  `numCollaborationPastYear` int(11) DEFAULT NULL,
  `enjoyCollaboration` smallint(4) DEFAULT NULL,
  `successCollaboartion` smallint(4) DEFAULT NULL,
  `mostUsedSearchEngine` varchar(100) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `majorClassificationRutgers` text,
  `majorClassificationGeneral` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaires_demographic`
--

LOCK TABLES `questionnaires_demographic` WRITE;
/*!40000 ALTER TABLE `questionnaires_demographic` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaires_demographic` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-08 19:16:20
