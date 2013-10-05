CREATE TABLE IF NOT EXISTS `project_membership` (
  `projectID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `roleID` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`projectID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;