-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2012 at 11:25 PM
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
('Missouri S&T', 1212, 2111, 'pimp room');

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
('Missouri S&T', 2.3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Name` varchar(20) NOT NULL,
  `ChairID` int(11) NOT NULL,
  PRIMARY KEY (`Name`),
  KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Name`, `ChairID`) VALUES
('Computer Science', 5);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `eventTimeStart` timestamp NULL DEFAULT NULL,
  `eventTimeEnd` timestamp NULL DEFAULT NULL,
  `accessTimeStart` timestamp NULL DEFAULT NULL,
  `accessTimeEnd` timestamp NULL DEFAULT NULL,
  `date` date NOT NULL,
  `numAttendees` int(10) unsigned DEFAULT NULL,
  `decorations` tinyint(1) DEFAULT NULL,
  `alcohol` tinyint(1) DEFAULT NULL,
  `prizes` tinyint(1) DEFAULT NULL,
  `tickets` tinyint(1) DEFAULT NULL,
  `outsideVendors` tinyint(1) DEFAULT NULL,
  `foodOption` tinyint(1) DEFAULT NULL,
  `typeOfEvent` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `eventTimeStart`, `eventTimeEnd`, `accessTimeStart`, `accessTimeEnd`, `date`, `numAttendees`, `decorations`, `alcohol`, `prizes`, `tickets`, `outsideVendors`, `foodOption`, `typeOfEvent`) VALUES
(1, 'Hello World', '2012-10-17 08:20:28', '2012-10-25 11:10:10', '2012-10-27 10:24:31', '2012-10-31 13:16:20', '2012-10-24', 1337, 1, 1, 1, 0, NULL, 0, 'Saying hello to the world');

-- --------------------------------------------------------

--
-- Table structure for table `member_of`
--

CREATE TABLE IF NOT EXISTS `member_of` (
  `UserID` int(11) NOT NULL,
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
  `description` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`Name`),
  KEY `department` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`Name`, `department`, `description`) VALUES
('IEEE', 'Computer Science', 'stuff and things');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `equipmentNeeded` set('Transparency Projector','Multimedia Projector','TV / DVD','Microphones','Easel','Dry-Erase Board','Tabletop Podium','Floor Podium','Dance Floor','Carousel Projector','Piano','U.S. Flag','MO Flag','University Flag','Other') DEFAULT NULL,
  `eventId` int(10) unsigned NOT NULL,
  `primaryRoomNumber` int(10) unsigned NOT NULL,
  `backupRoomNumber` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user` (`user`),
  KEY `eventId` (`eventId`),
  KEY `primaryRoomNumber` (`primaryRoomNumber`),
  KEY `backupRoomNumber` (`backupRoomNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `buildingName` varchar(20) NOT NULL,
  `roomNumber` int(10) unsigned NOT NULL,
  `capacity` int(10) unsigned NOT NULL,
  `roomName` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`roomNumber`),
  KEY `name` (`buildingName`),
  KEY `buildingName` (`buildingName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`buildingName`, `roomNumber`, `capacity`, `roomName`, `type`) VALUES
('pimp room', 1337, 1337, 'not pimp room', 'not pimp room');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Email`, `isAdmin`) VALUES
(12269597, 'Bob white', 'bw123@mst.edu', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`campusName`) REFERENCES `campus` (`campusName`);

--
-- Constraints for table `member_of`
--
ALTER TABLE `member_of`
  ADD CONSTRAINT `member_of_ibfk_2` FOREIGN KEY (`org_name`) REFERENCES `organization` (`Name`),
  ADD CONSTRAINT `member_of_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`Name`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`primaryRoomNumber`) REFERENCES `room` (`roomNumber`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`backupRoomNumber`) REFERENCES `room` (`roomNumber`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`buildingName`) REFERENCES `building` (`name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
