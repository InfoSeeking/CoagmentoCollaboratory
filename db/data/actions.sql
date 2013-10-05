CREATE TABLE IF NOT EXISTS `actions` (
  `actionID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `stageID` int(11) DEFAULT NULL,
  `questionID` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `clientTimestamp` bigint(20) DEFAULT NULL,
  `clientTime` time DEFAULT NULL,
  `clientDate` date DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `value` varchar(1000) DEFAULT NULL,
  `ip` text,
  `valid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`actionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;