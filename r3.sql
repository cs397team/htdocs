-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2012 at 07:04 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `r3`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `campusName` varchar(50) NOT NULL,
  `latitude` decimal(10,0) DEFAULT NULL,
  `longitude` decimal(10,0) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `campusName` (`campusName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`campusName`, `latitude`, `longitude`, `name`) VALUES
('121', 121, 12, 'Computer Science'),
('121', NULL, NULL, 'EECH');

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE IF NOT EXISTS `campus` (
  `campusName` varchar(50) NOT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  PRIMARY KEY (`campusName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`campusName`, `longitude`, `latitude`) VALUES
('121', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Name` varchar(20) NOT NULL,
  `ChairID` int(8) unsigned zerofill NOT NULL,
  PRIMARY KEY (`Name`),
  KEY `Name` (`Name`),
  KEY `ChairID` (`ChairID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Name`, `ChairID`) VALUES
('Computer Science', 12269597),
('ECE', 12344567);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `eventTimeStart` time DEFAULT NULL,
  `eventTimeEnd` time DEFAULT NULL,
  `accessTimeStart` time DEFAULT NULL,
  `accessTimeEnd` time DEFAULT NULL,
  `date` date NOT NULL,
  `recurrence` enum('Once','Daily','Weekly','Bi-Weekly') NOT NULL,
  `recurrenceEnd` date DEFAULT NULL,
  `numAttendees` int(10) unsigned DEFAULT NULL,
  `decorations` tinyint(1) DEFAULT NULL,
  `alcohol` tinyint(1) DEFAULT NULL,
  `prizes` tinyint(1) DEFAULT NULL,
  `tickets` tinyint(1) DEFAULT NULL,
  `outsideVendors` tinyint(1) DEFAULT NULL,
  `foodOption` tinyint(1) DEFAULT NULL,
  `typeOfEvent` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `eventTimeStart`, `eventTimeEnd`, `accessTimeStart`, `accessTimeEnd`, `date`, `recurrence`, `recurrenceEnd`, `numAttendees`, `decorations`, `alcohol`, `prizes`, `tickets`, `outsideVendors`, `foodOption`, `typeOfEvent`) VALUES
(121, '1221', '04:00:00', '07:00:00', '03:00:00', '07:00:00', '2012-11-21', 'Once', NULL, 12111111, 1, 1, 1, 1, 1, 0, 'test'),
(122, 'Event 2', NULL, NULL, NULL, NULL, '0000-00-00', 'Once', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(123, 'Event 3', '03:00:00', '04:00:00', '02:30:00', '04:30:00', '2012-11-21', 'Once', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE IF NOT EXISTS `floor` (
  `floorNum` int(11) NOT NULL,
  `buildingName` varchar(50) NOT NULL,
  `floorImageURL` varchar(128) NOT NULL,
  PRIMARY KEY (`floorNum`,`buildingName`),
  KEY `buildingName` (`buildingName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`floorNum`, `buildingName`, `floorImageURL`) VALUES
(1, 'Computer Science', 'images/cs_building/first floor/exported/cs_1st_floor.png'),
(1, 'EECH', ''),
(2, 'Computer Science', 'images/cs_building/second floor/exported/CS_second_floor_0051_Layer-0.png'),
(2, 'EECH', ''),
(15, 'EECH', '');

-- --------------------------------------------------------

--
-- Table structure for table `member_of`
--

CREATE TABLE IF NOT EXISTS `member_of` (
  `UserID` int(8) unsigned zerofill NOT NULL,
  `org_name` varchar(20) NOT NULL,
  `rank` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`org_name`),
  KEY `org_name` (`org_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `Name` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL,
  `president` int(8) unsigned zerofill NOT NULL,
  `advisor` int(8) unsigned zerofill NOT NULL,
  `description` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`Name`),
  KEY `department` (`department`),
  KEY `president` (`president`),
  KEY `advisor` (`advisor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`Name`, `department`, `president`, `advisor`, `description`) VALUES
('ACM', 'Computer Science', 12269597, 12344567, NULL),
('IEEE', 'ECE', 12345677, 14456654, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(8) unsigned zerofill NOT NULL,
  `alternateUser` int(8) unsigned zerofill NOT NULL,
  `organization` varchar(20) NOT NULL,
  `equipmentNeeded` set('Transparency Projector','Multimedia Projector','TV / DVD','Microphones','Easel','Dry-Erase Board','Tabletop Podium','Floor Podium','Dance Floor','Carousel Projector','Piano','U.S. Flag','MO Flag','University Flag','Other') DEFAULT NULL,
  `eventId` int(10) unsigned NOT NULL,
  `primaryRoomNumber` int(10) unsigned NOT NULL,
  `backupRoomNumber` int(10) unsigned NOT NULL,
  `Approval` enum('Pending','Approved','Denied') NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user` (`user`),
  KEY `eventId` (`eventId`),
  KEY `primaryRoomNumber` (`primaryRoomNumber`),
  KEY `backupRoomNumber` (`backupRoomNumber`),
  KEY `alternateUser` (`alternateUser`),
  KEY `organization` (`organization`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ID`, `user`, `alternateUser`, `organization`, `equipmentNeeded`, `eventId`, `primaryRoomNumber`, `backupRoomNumber`, `Approval`) VALUES
(3, 12269597, 12344567, 'ACM', 'Transparency Projector', 121, 2, 1, 'Pending'),
(4, 12344567, 12269597, 'ACM', 'Microphones', 122, 3, 2, 'Pending'),
(5, 14456654, 12269597, 'ACM', 'TV / DVD', 123, 2, 3, 'Pending'),
(6, 16016314, 12269597, 'ACM', 'Microphones', 121, 2, 1, 'Denied');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buildingName` varchar(20) NOT NULL,
  `floorNum` int(11) NOT NULL,
  `roomNumber` int(10) unsigned NOT NULL,
  `capacity` int(10) unsigned NOT NULL,
  `roomName` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `availableImageURL` varchar(128) NOT NULL,
  `notAvailableImageURL` varchar(128) NOT NULL,
  `pendingAvailableImageURL` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uniqueIDByBuildingFloorRoomNum` (`buildingName`,`floorNum`,`roomNumber`),
  KEY `name` (`buildingName`),
  KEY `floorNum` (`floorNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ID`, `buildingName`, `floorNum`, `roomNumber`, `capacity`, `roomName`, `type`, `availableImageURL`, `notAvailableImageURL`, `pendingAvailableImageURL`) VALUES
(1, 'Computer Science', 1, 121, 121, '1', '121', '', '', ''),
(2, 'Computer Science', 2, 208, 54, NULL, 'Classroom', 'images/cs_building/second floor/exported/available/cs_208_available.png', 'images/cs_building/second floor/exported/unavailable/cs_208_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_208_pending.png'),
(3, 'Computer Science', 1, 13131, 3131, '131', '133', '', '', ''),
(4, 'Computer Science', 2, 216, 50, NULL, NULL, 'images/cs_building/second floor/exported/available/cs_216_available.png', 'images/cs_building/second floor/exported/unavailable/cs_216_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_216_pending.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(8) unsigned zerofill NOT NULL,
  `Name` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `password_SHA256_hash` char(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Email`, `isAdmin`, `password_SHA256_hash`) VALUES
(12269597, 'Andrew Schrader', 'arstk8@mst.edu', 0, '2fe93ebff8af32d75b4de8283b8e2bfecc725336cfc37b09b06a629ea49c24a9'),
(12344567, 'Bobby', 'bobby@mst.edu', 1, '2fe93ebff8af32d75b4de8283b8e2bfecc725336cfc37b09b06a629ea49c24a9'),
(12345677, 'Andrew', 'r3@mst.edu', 1, '2fe93ebff8af32d75b4de8283b8e2bfecc725336cfc37b09b06a629ea49c24a9'),
(14456654, 'Bob', 'bob@mst.edu', 1, '9a125785bef6c04b1847934facfb53854f8acf04ead8bb6fb5ee1cb0cf68953c'),
(16016314, 'Neil Patel', 'nsp2t5@mst.edu', 1, '81b637d8fcd2c6da6359e6963113a1170de795e4b725b84d1e0b4cfd9ec58ce9');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_4` FOREIGN KEY (`campusName`) REFERENCES `campus` (`campusName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`ChairID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `floor`
--
ALTER TABLE `floor`
  ADD CONSTRAINT `floor_ibfk_1` FOREIGN KEY (`buildingName`) REFERENCES `building` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_of`
--
ALTER TABLE `member_of`
  ADD CONSTRAINT `member_of_ibfk_5` FOREIGN KEY (`UserID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_of_ibfk_4` FOREIGN KEY (`org_name`) REFERENCES `organization` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_4` FOREIGN KEY (`advisor`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_ibfk_2` FOREIGN KEY (`department`) REFERENCES `department` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_ibfk_3` FOREIGN KEY (`president`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_13` FOREIGN KEY (`organization`) REFERENCES `organization` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_10` FOREIGN KEY (`primaryRoomNumber`) REFERENCES `room` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_11` FOREIGN KEY (`backupRoomNumber`) REFERENCES `room` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_12` FOREIGN KEY (`alternateUser`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_6` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_9` FOREIGN KEY (`user`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`floorNum`) REFERENCES `floor` (`floorNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`buildingName`) REFERENCES `building` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
