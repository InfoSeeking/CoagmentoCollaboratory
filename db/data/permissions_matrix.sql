CREATE TABLE IF NOT EXISTS `permissions_matrix` (
  `roleID` int(11) NOT NULL,
  `permissionID` int(11) NOT NULL,
  PRIMARY KEY (`roleID`,`permissionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;