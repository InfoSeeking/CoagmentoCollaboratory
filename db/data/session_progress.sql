CREATE TABLE IF NOT EXISTS `session_progress` (
  `projectID` int(10) unsigned DEFAULT NULL,
  `userID` int(10) unsigned DEFAULT NULL,
  `progressID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stageID` int(10) unsigned DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`progressID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;