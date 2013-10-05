CREATE TABLE IF NOT EXISTS `study` (
  `studyID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`studyID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;