CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `study` tinyint(1) DEFAULT NULL,
  `condition` varchar(2) DEFAULT NULL,
  `conditionCode` tinyint(1) DEFAULT NULL,
  `observations` text,
  `api_key` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  KEY `userID` (`userID`)
);