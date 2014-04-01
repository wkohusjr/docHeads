-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2014 at 12:58 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `docdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userTypeID` int(10) NOT NULL,
  `password` varchar(128) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `emailAddress` text NOT NULL,
  `emailOptIn` tinyint(1) DEFAULT NULL,
  `tempPassKey` varchar(128) DEFAULT NULL,
  `createDate` text NOT NULL,
  `updateDate` text NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userTypeID` (`userTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userTypeID`, `password`, `fname`, `lname`, `emailAddress`, `emailOptIn`, `tempPassKey`, `createDate`, `updateDate`) VALUES
(25, 1, '7ffde559d8276534f862791b6057db944f06394bf63c08c37fa919470816636271c717466d75c86bf1860375633b4f5c172038be454b30feb02450a8996ae08c', 'Brian', 'Dunavent', 'dunavebc@mail.uc.edu', 1, NULL, '2014-03-23 20:09:42', '2014-03-23 20:09:42'),
(35, 1, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'Brian', 'Dunavent', 'b.dunavent@test.com', 1, NULL, '2014-03-23 23:09:51', '2014-03-23 23:09:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
