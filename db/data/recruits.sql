CREATE TABLE IF NOT EXISTS `recruits` (
  `recruitsID` int(11) NOT NULL AUTO_INCREMENT,
  `registrationID` tinyint(1) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `english` tinyint(1) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  PRIMARY KEY (`recruitsID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;