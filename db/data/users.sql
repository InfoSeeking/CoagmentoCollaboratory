CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `study` tinyint(1) DEFAULT NULL,
  `condition` varchar(2) DEFAULT NULL,
  `conditionCode` tinyint(1) DEFAULT NULL,
  `observations` text,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;