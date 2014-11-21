-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2014 at 09:22 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlinetest`
--
CREATE DATABASE IF NOT EXISTS `onlinetest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `onlinetest`;

-- --------------------------------------------------------

--
-- Table structure for table `test_admin`
--

CREATE TABLE IF NOT EXISTS `test_admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `test_admin`
--

INSERT INTO `test_admin` (`adminid`, `adminname`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `test_choice`
--

CREATE TABLE IF NOT EXISTS `test_choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choice` varchar(100) NOT NULL DEFAULT '',
  `extends` int(11) DEFAULT '0',
  `IsDefault` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_setmark`
--

CREATE TABLE IF NOT EXISTS `test_setmark` (
  `radio` tinyint(5) NOT NULL DEFAULT '2',
  `checkbox` tinyint(5) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_setmark`
--

INSERT INTO `test_setmark` (`radio`, `checkbox`) VALUES
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `test_thread`
--

CREATE TABLE IF NOT EXISTS `test_thread` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_title`
--

CREATE TABLE IF NOT EXISTS `test_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `threadid` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `choicetype` enum('radio','checkbox','text','textarea') DEFAULT NULL,
  `answer` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
