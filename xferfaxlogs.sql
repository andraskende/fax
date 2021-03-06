CREATE TABLE `xferfaxlogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `server` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `entrytype` varchar(255) DEFAULT NULL,
  `commid` varchar(255) DEFAULT NULL,
  `modem` varchar(255) DEFAULT NULL,
  `jobid` varchar(255) DEFAULT NULL,
  `jobtag` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `localnumber` varchar(255) DEFAULT NULL,
  `tsi` varchar(255) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL,
  `npages` int(11) DEFAULT NULL,
  `jobtime` varchar(10) DEFAULT NULL,
  `conntime` varchar(10) DEFAULT NULL,
  `jobseconds` int(11) DEFAULT NULL,
  `connseconds` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `CIDName` varchar(255) DEFAULT NULL,
  `CIDNumber` varchar(255) DEFAULT NULL,
  `callid` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `dcs` varchar(255) DEFAULT NULL,
  `jobinfo` varchar(255) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `server` (`server`),
  KEY `reason` (`reason`),
  KEY `modem` (`modem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
