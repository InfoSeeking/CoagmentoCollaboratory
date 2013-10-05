CREATE TABLE IF NOT EXISTS `projects` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;