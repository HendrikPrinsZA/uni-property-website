-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2013 at 10:02 AM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbmain`
--
CREATE DATABASE `dbmain` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbmain`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CAT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_NAME` varchar(20) NOT NULL,
  `CAT_Description` varchar(200) NOT NULL,
  PRIMARY KEY (`CAT_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CAT_ID`, `CAT_NAME`, `CAT_Description`) VALUES
(1, 'Agricultural', 'Farmers'),
(2, 'Unknown', 'I don''t really know the category'),
(3, 'Commercial', 'Flats/Communes'),
(4, 'Guest House', 'Granny flat in yard'),
(5, 'Plot', 'House situated on a large '),
(6, 'Complex', 'Flat in enclosed area'),
(7, 'Apartment', 'A suite of rooms forming one residence'),
(8, 'Smallholding', 'A farm of small size');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `COMMENT_DESC` varchar(500) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LINK_ID` int(11) NOT NULL,
  PRIMARY KEY (`COMMENT_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`COMMENT_ID`, `COMMENT_DESC`, `USER_ID`, `LINK_ID`) VALUES
(8, 'asdsadsd', 52, 24),
(9, 'geseÃ«nde jaar wat voorlÃª waarin al jou drome en wense waar word!', 35, 26);

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `USER_ID` int(11) NOT NULL,
  `FRIEND_ID` int(11) NOT NULL,
  `FRIEND_STATUS` varchar(1) NOT NULL,
  PRIMARY KEY (`USER_ID`,`FRIEND_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`USER_ID`, `FRIEND_ID`, `FRIEND_STATUS`) VALUES
(52, 35, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `LINK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LINK_URL` varchar(200) DEFAULT NULL,
  `LINK_DESC` varchar(500) NOT NULL,
  `LINK_CAT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LINK_NAME` varchar(200) NOT NULL,
  `LINK_PIC_LOCATION` varchar(300) DEFAULT NULL,
  `Price` double NOT NULL,
  `RentOrSell` varchar(1) NOT NULL,
  PRIMARY KEY (`LINK_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`LINK_ID`, `LINK_URL`, `LINK_DESC`, `LINK_CAT_ID`, `USER_ID`, `LINK_NAME`, `LINK_PIC_LOCATION`, `Price`, `RentOrSell`) VALUES
(24, 'http://www.google.com', '3 bedroom house with open plan kitchen.', 4, 52, 'Dream house', '24.jpg', 0, ''),
(26, '', 'sadf', 1, 52, 'asdf', '26.jpg', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `RATING_ID` int(11) NOT NULL,
  `RATING_SCORE` decimal(11,2) NOT NULL,
  `RATING_TOTAL` int(11) NOT NULL,
  PRIMARY KEY (`RATING_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`RATING_ID`, `RATING_SCORE`, `RATING_TOTAL`) VALUES
(26, '0.00', 0),
(25, '2.00', 2),
(24, '2.25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_USERNAME` varchar(100) NOT NULL,
  `USER_EMAIL` varchar(200) NOT NULL,
  `USER_PASSWORD` varchar(100) NOT NULL,
  `USER_FN` varchar(200) NOT NULL,
  `USER_LN` varchar(200) NOT NULL,
  `USER_GENDER` char(1) NOT NULL,
  `USER_BIRTH` date NOT NULL,
  `USER_TYPE` varchar(1) NOT NULL,
  `USER_PIC_LOCATION` varchar(300) NOT NULL,
  UNIQUE KEY `USER_USERNAME` (`USER_USERNAME`,`USER_EMAIL`),
  UNIQUE KEY `USER_PIC_LOCATION` (`USER_PIC_LOCATION`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_USERNAME`, `USER_EMAIL`, `USER_PASSWORD`, `USER_FN`, `USER_LN`, `USER_GENDER`, `USER_BIRTH`, `USER_TYPE`, `USER_PIC_LOCATION`) VALUES
(35, 'Admin', 'admin@spiderweb.co.za', '761943', 'Hendrik', 'Prinsloo', 'M', '1991-06-23', 'A', 'Admin.jpg'),
(52, 'Hendrik', 'me@thePlace.net', 'a', 'Hendrik', 'Prinsloo', 'M', '1991-06-23', 'U', 'a.jpg'),
(50, 'b', 'b@thePlace.net', 'a', 'a', 'a', 'M', '1991-06-23', 'U', 'b.jpg');
