-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2014 at 02:23 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `OilTankMonitor`
--
CREATE DATABASE IF NOT EXISTS `OilTankMonitor` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `OilTankMonitor`;

-- --------------------------------------------------------

--
-- Table structure for table `OilLog`
--

DROP TABLE IF EXISTS `OilLog`;
CREATE TABLE IF NOT EXISTS `OilLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TankID` int(11) NOT NULL,
  `MeasuredDepth` int(11) NOT NULL,
  `TankQty` float NOT NULL,
  `TankTemp` float NOT NULL,
  `RoomTemp` float NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2497 ;

-- --------------------------------------------------------

--
-- Table structure for table `RefuelLog`
--

DROP TABLE IF EXISTS `RefuelLog`;
CREATE TABLE IF NOT EXISTS `RefuelLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `QtyRefuelled` float NOT NULL,
  `PricePerL` float NOT NULL,
  `DateRefuelled` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TankID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
