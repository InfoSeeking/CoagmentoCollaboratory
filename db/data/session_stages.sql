CREATE TABLE IF NOT EXISTS `session_stages` (
  `stageID` smallint(4) NOT NULL,
  `description` varchar(45) NOT NULL,
  `page` varchar(45) DEFAULT NULL,
  `maxTime` int(11) DEFAULT NULL,
  `maxTimeQuestion` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `maxLoops` int(11) DEFAULT NULL,
  `loopStage` smallint(4) DEFAULT NULL,
  `synchStage` tinyint(4) DEFAULT NULL,
  `allowBrowsing` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`stageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;