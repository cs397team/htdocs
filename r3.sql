-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2012 at 11:14 PM
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
('121', 121, 12, 'Computer Science');

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
  `title` varchar(20) NOT NULL,
  `eventTimeStart` time NOT NULL,
  `eventTimeEnd` time NOT NULL,
  `accessTimeStart` time NOT NULL,
  `accessTimeEnd` time NOT NULL,
  `date` date NOT NULL,
  `recurrence` enum('Once','Daily','Weekly','Bi-Weekly') NOT NULL,
  `recurrenceEnd` date DEFAULT NULL,
  `numAttendees` int(10) unsigned NOT NULL,
  `decorations` tinyint(1) NOT NULL DEFAULT '0',
  `alcohol` tinyint(1) NOT NULL DEFAULT '0',
  `prizes` tinyint(1) NOT NULL DEFAULT '0',
  `tickets` tinyint(1) NOT NULL DEFAULT '0',
  `outsideVendors` tinyint(1) NOT NULL DEFAULT '0',
  `foodOption` tinyint(1) NOT NULL DEFAULT '0',
  `typeOfEvent` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `eventTimeStart`, `eventTimeEnd`, `accessTimeStart`, `accessTimeEnd`, `date`, `recurrence`, `recurrenceEnd`, `numAttendees`, `decorations`, `alcohol`, `prizes`, `tickets`, `outsideVendors`, `foodOption`, `typeOfEvent`) VALUES
(121, '1221', '04:00:00', '07:00:00', '03:00:00', '07:00:00', '2012-11-21', 'Once', NULL, 12111111, 1, 1, 1, 1, 1, 0, 'test');

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
(2, 'Computer Science', 'images/cs_building/second floor/exported/CS_second_floor_0051_Layer-0.png'),
(3, 'Computer Science', 'images/cs_building/third floor/exported/CS_third_floor_0147_Layer-0.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buildingName` varchar(20) NOT NULL,
  `floorNum` int(11) NOT NULL,
  `roomNumber` varchar(30) NOT NULL,
  `capacity` int(10) unsigned NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `availableImageURL` varchar(128) NOT NULL,
  `notAvailableImageURL` varchar(128) NOT NULL,
  `pendingAvailableImageURL` varchar(128) NOT NULL,
  `isReservable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uniqueIDByBuildingFloorRoomNum` (`buildingName`,`floorNum`,`roomNumber`),
  KEY `name` (`buildingName`),
  KEY `floorNum` (`floorNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ID`, `buildingName`, `floorNum`, `roomNumber`, `capacity`, `type`, `availableImageURL`, `notAvailableImageURL`, `pendingAvailableImageURL`, `isReservable`) VALUES
(15, 'Computer Science', 1, '101', 0, NULL, 'images/cs_building/first floor/exported/available/cs_101_available.png', 'images/cs_building/first floor/exported/unavailable/cs_101_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_101_pending.png', 0),
(16, 'Computer Science', 1, '102', 0, NULL, 'images/cs_building/first floor/exported/available/cs_102_available.png', 'images/cs_building/first floor/exported/unavailable/cs_102_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_102_pending.png', 0),
(17, 'Computer Science', 1, '103', 0, NULL, 'images/cs_building/first floor/exported/available/cs_103_available.png', 'images/cs_building/first floor/exported/unavailable/cs_103_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_103_pending.png', 0),
(18, 'Computer Science', 1, '104', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104_pending.png', 0),
(19, 'Computer Science', 1, '105', 0, NULL, 'images/cs_building/first floor/exported/available/cs_105_available.png', 'images/cs_building/first floor/exported/unavailable/cs_105_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_105_pending.png', 0),
(20, 'Computer Science', 1, '107a1', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107a1_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107a1_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107a1_pending.png', 0),
(21, 'Computer Science', 1, '106', 0, NULL, 'images/cs_building/first floor/exported/available/cs_106_available.png', 'images/cs_building/first floor/exported/unavailable/cs_106_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_106_pending.png', 0),
(22, 'Computer Science', 1, '106a', 0, NULL, 'images/cs_building/first floor/exported/available/cs_106a_available.png', 'images/cs_building/first floor/exported/unavailable/cs_106a_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_101_pending.png', 0),
(23, 'Computer Science', 1, '106b', 0, NULL, 'images/cs_building/first floor/exported/available/cs_106b_available.png', 'images/cs_building/first floor/exported/unavailable/cs_106b_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_106b_pending.png', 0),
(24, 'Computer Science', 1, '106c', 0, NULL, 'images/cs_building/first floor/exported/available/cs_106c_available.png', 'images/cs_building/first floor/exported/unavailable/cs_106c_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_106c_pending.png', 0),
(25, 'Computer Science', 1, '113', 0, NULL, 'images/cs_building/first floor/exported/available/cs_113_available.png', 'images/cs_building/first floor/exported/unavailable/cs_113_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_113_pending.png', 0),
(26, 'Computer Science', 1, '112', 0, NULL, 'images/cs_building/first floor/exported/available/cs_112_available.png', 'images/cs_building/first floor/exported/unavailable/cs_112_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_112_pending.png', 0),
(27, 'Computer Science', 1, '111', 0, NULL, 'images/cs_building/first floor/exported/available/cs_111_available.png', 'images/cs_building/first floor/exported/unavailable/cs_111_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_111_pending.png', 0),
(28, 'Computer Science', 1, '110', 0, NULL, 'images/cs_building/first floor/exported/available/cs_110_available.png', 'images/cs_building/first floor/exported/unavailable/cs_110_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_110_pending.png', 0),
(29, 'Computer Science', 1, '100a', 0, NULL, 'images/cs_building/first floor/exported/available/cs_100a_available.png', 'images/cs_building/first floor/exported/unavailable/cs_100a_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_100a_pending.png', 0),
(30, 'Computer Science', 1, '109', 0, NULL, 'images/cs_building/first floor/exported/available/cs_109_available.png', 'images/cs_building/first floor/exported/unavailable/cs_109_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_109_pending.png', 0),
(31, 'Computer Science', 1, '108', 0, NULL, 'images/cs_building/first floor/exported/available/cs_108_available.png', 'images/cs_building/first floor/exported/unavailable/cs_108_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_108_pending.png', 0),
(32, 'Computer Science', 1, '107f', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107f_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107f_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107f_pending.png', 0),
(33, 'Computer Science', 1, '107', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107_pending.png', 0),
(34, 'Computer Science', 1, '107d', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107d_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107d_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107d_pending.png', 0),
(35, 'Computer Science', 1, '107a', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107a_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107a_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107a_pending.png', 0),
(36, 'Computer Science', 1, '107c', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107c_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107c_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107c_pending.png', 0),
(37, 'Computer Science', 1, '107e', 0, NULL, 'images/cs_building/first floor/exported/available/cs_107e_available.png', 'images/cs_building/first floor/exported/unavailable/cs_107e_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_107e_pending.png', 0),
(38, 'Computer Science', 1, '104e1', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104e1_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104e1_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104e1_pending.png', 0),
(39, 'Computer Science', 1, '104e', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104e_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104e_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104e_pending.png', 0),
(40, 'Computer Science', 1, '104d', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104d_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104d_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104d_pending.png', 0),
(41, 'Computer Science', 1, '104c', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104c_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104c_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104c_pending.png', 0),
(42, 'Computer Science', 1, '104b', 0, NULL, 'images/cs_building/first floor/exported/available/cs_104b_available.png', 'images/cs_building/first floor/exported/unavailable/cs_104b_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_104b_pending.png', 0),
(43, 'Computer Science', 1, '103a', 0, NULL, 'images/cs_building/first floor/exported/available/cs_103a_available.png', 'images/cs_building/first floor/exported/unavailable/cs_103a_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_103a_pending.png', 0),
(44, 'Computer Science', 1, '1cr5', 0, NULL, 'images/cs_building/first floor/exported/available/cs_1cr5_available.png', 'images/cs_building/first floor/exported/unavailable/cs_1cr5_unavailable.png', 'images/cs_building/first floor/exported/pending/cs_1cr5_pending.png', 0),
(45, 'Computer Science', 2, '202', 45, NULL, 'images/cs_building/second floor/exported/available/cs_202_available.png', 'images/cs_building/second floor/exported/unavailable/cs_202_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_202_pending.png', 1),
(46, 'Computer Science', 2, '203', 49, NULL, 'images/cs_building/second floor/exported/available/cs_203_available.png', 'images/cs_building/second floor/exported/unavailable/cs_203_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_203_pending.png', 1),
(47, 'Computer Science', 2, '204', 39, NULL, 'images/cs_building/second floor/exported/available/cs_204_available.png', 'images/cs_building/second floor/exported/unavailable/cs_204_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_204_pending.png', 1),
(48, 'Computer Science', 2, '205', 38, NULL, 'images/cs_building/second floor/exported/available/cs_205_available.png', 'images/cs_building/second floor/exported/unavailable/cs_205_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_205_pending.png', 1),
(49, 'Computer Science', 2, '207', 58, NULL, 'images/cs_building/second floor/exported/available/cs_207_available.png', 'images/cs_building/second floor/exported/unavailable/cs_207_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_207_pending.png', 1),
(50, 'Computer Science', 2, '216', 49, NULL, 'images/cs_building/second floor/exported/available/cs_216_available.png', 'images/cs_building/second floor/exported/unavailable/cs_216_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_216_pending.png', 1),
(51, 'Computer Science', 2, '209', 0, NULL, 'images/cs_building/second floor/exported/available/cs_209_available.png', 'images/cs_building/second floor/exported/unavailable/cs_209_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_209_pending.png', 0),
(52, 'Computer Science', 2, '206', 0, NULL, 'images/cs_building/second floor/exported/available/cs_206_available.png', 'images/cs_building/second floor/exported/unavailable/cs_206_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_206_pending.png', 0),
(53, 'Computer Science', 2, '213', 0, NULL, 'images/cs_building/second floor/exported/available/cs_213_available.png', 'images/cs_building/second floor/exported/unavailable/cs_213_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_213_pending.png', 0),
(54, 'Computer Science', 2, '208', 0, NULL, 'images/cs_building/second floor/exported/available/cs_208_available.png', 'images/cs_building/second floor/exported/unavailable/cs_208_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_208_pending.png', 0),
(55, 'Computer Science', 2, '212', 0, NULL, 'images/cs_building/second floor/exported/available/cs_212_available.png', 'images/cs_building/second floor/exported/unavailable/cs_212_unavailable.png', 'images/cs_building/second floor/exported/pending/cs_212_pending.png', 0),
(56, 'Computer Science', 3, '327', 40, NULL, 'images/cs_building/third floor/exported/available/cs_327_available.png', 'images/cs_building/third floor/exported/unavailable/cs_327_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_327_pending.png', 1),
(57, 'Computer Science', 3, '324', 10, NULL, 'images/cs_building/third floor/exported/available/cs_324_available.png', 'images/cs_building/third floor/exported/unavailable/cs_324_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_324_pending.png', 1),
(58, 'Computer Science', 3, '325', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325_pending.png', 0),
(59, 'Computer Science', 3, '325a', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325a_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325a_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325a_pending.png', 0),
(60, 'Computer Science', 3, '325b', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325b_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325b_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325b_pending.png', 0),
(61, 'Computer Science', 3, '325c', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325c_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325c_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325c_pending.png', 0),
(62, 'Computer Science', 3, '325d', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325d_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325d_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325d_pending.png', 0),
(63, 'Computer Science', 3, '325e', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325e_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325e_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325e_pending.png', 0),
(64, 'Computer Science', 3, '325f', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325f_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325f_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325f_pending.png', 0),
(65, 'Computer Science', 3, '325g', 0, NULL, 'images/cs_building/third floor/exported/available/cs_325g_available.png', 'images/cs_building/third floor/exported/unavailable/cs_325g_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_325g_pending.png', 0),
(66, 'Computer Science', 3, '331', 0, NULL, 'images/cs_building/third floor/exported/available/cs_331_available.png', 'images/cs_building/third floor/exported/unavailable/cs_331_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_331_pending.png', 0),
(67, 'Computer Science', 3, '332', 0, NULL, 'images/cs_building/third floor/exported/available/cs_332_available.png', 'images/cs_building/third floor/exported/unavailable/cs_332_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_332_pending.png', 0),
(68, 'Computer Science', 3, '333', 0, NULL, 'images/cs_building/third floor/exported/available/cs_333_available.png', 'images/cs_building/third floor/exported/unavailable/cs_333_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_333_pending.png', 0),
(69, 'Computer Science', 3, '334', 0, NULL, 'images/cs_building/third floor/exported/available/cs_334_available.png', 'images/cs_building/third floor/exported/unavailable/cs_334_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_334_pending.png', 0),
(70, 'Computer Science', 3, '335', 0, NULL, 'images/cs_building/third floor/exported/available/cs_335_available.png', 'images/cs_building/third floor/exported/unavailable/cs_335_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_335_pending.png', 0),
(71, 'Computer Science', 3, '336', 0, NULL, 'images/cs_building/third floor/exported/available/cs_336_available.png', 'images/cs_building/third floor/exported/unavailable/cs_336_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_336_pending.png', 0),
(72, 'Computer Science', 3, '337', 0, NULL, 'images/cs_building/third floor/exported/available/cs_337_available.png', 'images/cs_building/third floor/exported/unavailable/cs_337_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_337_pending.png', 0),
(73, 'Computer Science', 3, '338', 0, NULL, 'images/cs_building/third floor/exported/available/cs_338_available.png', 'images/cs_building/third floor/exported/unavailable/cs_338_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_338_pending.png', 0),
(74, 'Computer Science', 3, '339', 0, NULL, 'images/cs_building/third floor/exported/available/cs_339_available.png', 'images/cs_building/third floor/exported/unavailable/cs_339_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_339_pending.png', 0),
(75, 'Computer Science', 3, '340', 0, NULL, 'images/cs_building/third floor/exported/available/cs_340_available.png', 'images/cs_building/third floor/exported/unavailable/cs_340_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_340_pending.png', 0),
(76, 'Computer Science', 3, '341', 0, NULL, 'images/cs_building/third floor/exported/available/cs_341_available.png', 'images/cs_building/third floor/exported/unavailable/cs_341_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_341_pending.png', 0),
(78, 'Computer Science', 3, '343', 0, NULL, 'images/cs_building/third floor/exported/available/cs_343_available.png', 'images/cs_building/third floor/exported/unavailable/cs_343_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_343_pending.png', 0),
(79, 'Computer Science', 3, '344', 0, NULL, 'images/cs_building/third floor/exported/available/cs_344_available.png', 'images/cs_building/third floor/exported/unavailable/cs_344_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_344_pending.png', 0),
(80, 'Computer Science', 3, '345', 0, NULL, 'images/cs_building/third floor/exported/available/cs_345_available.png', 'images/cs_building/third floor/exported/unavailable/cs_345_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_345_pending.png', 0),
(81, 'Computer Science', 3, '346', 0, NULL, 'images/cs_building/third floor/exported/available/cs_346_available.png', 'images/cs_building/third floor/exported/unavailable/cs_346_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_346_pending.png', 0),
(82, 'Computer Science', 3, '343a', 0, NULL, 'images/cs_building/third floor/exported/available/cs_343a_available.png', 'images/cs_building/third floor/exported/unavailable/cs_343a_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_343a_pending.png', 0),
(83, 'Computer Science', 3, '304', 0, NULL, 'images/cs_building/third floor/exported/available/cs_304_available.png', 'images/cs_building/third floor/exported/unavailable/cs_304_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_304_pending.png', 0),
(84, 'Computer Science', 3, '305', 0, NULL, 'images/cs_building/third floor/exported/available/cs_305_available.png', 'images/cs_building/third floor/exported/unavailable/cs_305_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_305_pending.png', 0),
(85, 'Computer Science', 3, '306', 0, NULL, 'images/cs_building/third floor/exported/available/cs_306_available.png', 'images/cs_building/third floor/exported/unavailable/cs_306_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_306_pending.png', 0),
(86, 'Computer Science', 3, '307', 0, NULL, 'images/cs_building/third floor/exported/available/cs_307_available.png', 'images/cs_building/third floor/exported/unavailable/cs_307_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_307_pending.png', 0),
(87, 'Computer Science', 3, '308', 0, NULL, 'images/cs_building/third floor/exported/available/cs_308_available.png', 'images/cs_building/third floor/exported/unavailable/cs_308_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_308_pending.png', 0),
(88, 'Computer Science', 3, '309', 0, NULL, 'images/cs_building/third floor/exported/available/cs_309_available.png', 'images/cs_building/third floor/exported/unavailable/cs_309_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_309_pending.png', 0),
(89, 'Computer Science', 3, '310', 0, NULL, 'images/cs_building/third floor/exported/available/cs_310_available.png', 'images/cs_building/third floor/exported/unavailable/cs_310_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_310_pending.png', 0),
(90, 'Computer Science', 3, '311', 0, NULL, 'images/cs_building/third floor/exported/available/cs_311_available.png', 'images/cs_building/third floor/exported/unavailable/cs_311_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_311_pending.png', 0),
(91, 'Computer Science', 3, '312', 0, NULL, 'images/cs_building/third floor/exported/available/cs_312_available.png', 'images/cs_building/third floor/exported/unavailable/cs_312_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_312_pending.png', 0),
(92, 'Computer Science', 3, '313', 0, NULL, 'images/cs_building/third floor/exported/available/cs_313_available.png', 'images/cs_building/third floor/exported/unavailable/cs_313_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_313_pending.png', 0),
(93, 'Computer Science', 3, '314', 0, NULL, 'images/cs_building/third floor/exported/available/cs_314_available.png', 'images/cs_building/third floor/exported/unavailable/cs_314_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_314_pending.png', 0),
(94, 'Computer Science', 3, '315', 0, NULL, 'images/cs_building/third floor/exported/available/cs_315_available.png', 'images/cs_building/third floor/exported/unavailable/cs_315_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_315_pending.png', 0),
(95, 'Computer Science', 3, '316', 0, NULL, 'images/cs_building/third floor/exported/available/cs_316_available.png', 'images/cs_building/third floor/exported/unavailable/cs_316_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_316_pending.png', 0),
(96, 'Computer Science', 3, '317', 0, NULL, 'images/cs_building/third floor/exported/available/cs_317_available.png', 'images/cs_building/third floor/exported/unavailable/cs_317_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_317_pending.png', 0),
(97, 'Computer Science', 3, '318', 0, NULL, 'images/cs_building/third floor/exported/available/cs_318_available.png', 'images/cs_building/third floor/exported/unavailable/cs_318_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_318_pending.png', 0),
(98, 'Computer Science', 3, '319', 0, NULL, 'images/cs_building/third floor/exported/available/cs_319_available.png', 'images/cs_building/third floor/exported/unavailable/cs_319_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_319_pending.png', 0),
(99, 'Computer Science', 3, '320', 0, NULL, 'images/cs_building/third floor/exported/available/cs_320_available.png', 'images/cs_building/third floor/exported/unavailable/cs_320_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_320_pending.png', 0),
(100, 'Computer Science', 3, '321', 0, NULL, 'images/cs_building/third floor/exported/available/cs_321_available.png', 'images/cs_building/third floor/exported/unavailable/cs_321_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_321_pending.png', 0),
(101, 'Computer Science', 3, '322', 0, NULL, 'images/cs_building/third floor/exported/available/cs_322_available.png', 'images/cs_building/third floor/exported/unavailable/cs_322_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_322_pending.png', 0),
(102, 'Computer Science', 3, '323', 0, NULL, 'images/cs_building/third floor/exported/available/cs_323_available.png', 'images/cs_building/third floor/exported/unavailable/cs_323_unavailable.png', 'images/cs_building/third floor/exported/pending/cs_323_pending.png', 0);

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
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`buildingName`) REFERENCES `building` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`floorNum`) REFERENCES `floor` (`floorNum`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
