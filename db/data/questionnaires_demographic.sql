CREATE TABLE IF NOT EXISTS `questionnaires_demographic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `program` varchar(20) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `searchExperience` smallint(4) DEFAULT NULL,
  `oftenSearch` varchar(20) DEFAULT NULL,
  `oftenTextMsg` varchar(20) DEFAULT NULL,
  `oftenProjectWithOthers` varchar(20) DEFAULT NULL,
  `numCollaborationPastYear` int(11) DEFAULT NULL,
  `enjoyCollaboration` smallint(4) DEFAULT NULL,
  `successCollaboartion` smallint(4) DEFAULT NULL,
  `mostUsedSearchEngine` varchar(100) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `majorClassificationRutgers` text,
  `majorClassificationGeneral` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;