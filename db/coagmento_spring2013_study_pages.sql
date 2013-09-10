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
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `stageID` int(11) DEFAULT NULL,
  `questionID` int(11) DEFAULT NULL,
  `url` text,
  `title` text,
  `source` text,
  `query` text,
  `startTimestamp` int(11) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `clientStartTimestamp` bigint(20) DEFAULT NULL,
  `clientStartDate` date DEFAULT NULL,
  `clientStartTime` time DEFAULT NULL,
  `bookmark` tinyint(1) DEFAULT NULL,
  `snippet` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `endTimestamp` int(11) DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `clientEndTimestamp` bigint(20) DEFAULT NULL,
  `clientEndDate` date DEFAULT NULL,
  `clientEndTime` time DEFAULT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-08 19:16:15
