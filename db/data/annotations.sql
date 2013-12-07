CREATE TABLE IF NOT EXISTS `annotations` (
  `annotationID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned DEFAULT NULL,
  `projectID` int(10) unsigned DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `annotation` text,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`annotationID`)
);