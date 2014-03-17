-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;

DROP TABLE IF EXISTS `batting`;
CREATE TABLE `batting` (
  `player` varchar(128) NOT NULL,
  `pa` int(11) NOT NULL,
  `h` int(11) NOT NULL,
  `bb` int(11) NOT NULL,
  `so` int(11) NOT NULL,
  `hbp` int(11) NOT NULL,
  `2b` int(11) NOT NULL,
  `3b` int(11) NOT NULL,
  `hr` int(11) NOT NULL,
  `rbi` int(11) NOT NULL,
  `sac` int(11) NOT NULL,
  `r` int(11) NOT NULL,
  `sb` int(11) NOT NULL,
  `cs` int(11) NOT NULL,
  `ob` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `pitching`;
CREATE TABLE `pitching` (
  `player` varchar(128) NOT NULL,
  `w` int(11) NOT NULL,
  `l` int(11) NOT NULL,
  `ip` double NOT NULL,
  `h` int(11) NOT NULL,
  `bb` int(11) NOT NULL,
  `hbp` int(11) NOT NULL,
  `er` int(11) NOT NULL,
  `k` int(11) NOT NULL,
  `g` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `bf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2014-03-17 12:12:33
