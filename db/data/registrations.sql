CREATE TABLE IF NOT EXISTS `registrations` (
  `registrationID` int(11) NOT NULL AUTO_INCREMENT,
  `studyID` int(11) DEFAULT NULL,
  `pastCollab` text,
  `comments` text,
  `approved` tinyint(1) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `slotID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`registrationID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;