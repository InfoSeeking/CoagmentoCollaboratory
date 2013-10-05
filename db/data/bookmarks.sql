CREATE TABLE IF NOT EXISTS `bookmarks` (
  `bookmarkID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `stageID` varchar(45) DEFAULT NULL,
  `url` text,
  `title` text,
  `timestamp` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `clientTimestamp` bigint(20) DEFAULT NULL,
  `clientDate` date DEFAULT NULL,
  `clientTime` time DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`bookmarkID`),
  KEY `userID` (`userID`),
  KEY `projectID` (`projectID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;