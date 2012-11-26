CREATE TABLE IF NOT EXISTS `character` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `crace` int(11) NOT NULL,
  `cculture` int(11) NOT NULL,
  `cprofession` int(11) NOT NULL,
  `csex` int(11) NOT NULL,
  `cbirth` date NOT NULL,
  `csize` float NOT NULL,
  `chaircolor` varchar(100) NOT NULL,
  `ceyecolor` varchar(100) NOT NULL,
  `cdescription` text NOT NULL,
  `cclass` varchar(100) NOT NULL,
  `ctitle` varchar(100) NOT NULL,
  `csocial` int(11) NOT NULL,
  `cstory` text NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `char_properties` (
  `cid` int(11) NOT NULL,
  `courage` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `intuition` int(11) NOT NULL,
  `charisma` int(11) NOT NULL,
  `dexterity` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `constitution` int(11) NOT NULL,
  `strength` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `char_properties_mod` (
  `cid` int(11) NOT NULL,
  `courage` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `intuition` int(11) NOT NULL,
  `charisma` int(11) NOT NULL,
  `dexterity` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `constitution` int(11) NOT NULL,
  `strength` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL,
  `upermissions` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;