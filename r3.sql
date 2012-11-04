-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2012 at 05:11 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `password_SHA256_hash` char(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_4` FOREIGN KEY (`campusName`) REFERENCES `campus` (`campusName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_of`
--
ALTER TABLE `member_of`
  ADD CONSTRAINT `member_of_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_of_ibfk_4` FOREIGN KEY (`org_name`) REFERENCES `organization` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_2` FOREIGN KEY (`department`) REFERENCES `department` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_5` FOREIGN KEY (`user`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_6` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_7` FOREIGN KEY (`primaryRoomNumber`) REFERENCES `room` (`roomNumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_8` FOREIGN KEY (`backupRoomNumber`) REFERENCES `room` (`roomNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`buildingName`) REFERENCES `building` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
