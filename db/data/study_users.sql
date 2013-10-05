CREATE TABLE IF NOT EXISTS `study_users` (
  `studyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`studyID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;