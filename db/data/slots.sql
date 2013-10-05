CREATE TABLE IF NOT EXISTS `slots` (
  `slotID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `day` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `available` tinyint(1) DEFAULT '1',
  `week` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`slotID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;