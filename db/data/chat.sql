CREATE TABLE IF NOT EXISTS `chat`(
  `chatID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `stageID` int(11) DEFAULT NULL,
  `questionID` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `message` text,
  `timestamp` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`chatID`),
  KEY `userID` (`userID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;