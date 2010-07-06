-- phpMyAdmin SQL Dump
-- version 2.11.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2008 at 06:08 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5-3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `netaccess`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE IF NOT EXISTS `accesslog` (
  `timestamp` double NOT NULL,
  `delay` int(10) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `tcp_code` varchar(32) NOT NULL,
  `size` varchar(16) NOT NULL,
  `action` varchar(5) NOT NULL,
  `url` varchar(255) NOT NULL,
  `blank` varchar(5) NOT NULL,
  `director` varchar(255) NOT NULL,
  `mime` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accesslog`
--


-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(16) NOT NULL auto_increment,
  `adminname` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `logged_in` binary(1) NOT NULL default '0',
  UNIQUE KEY `adminid` (`adminid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `adminname`, `password`, `logged_in`) VALUES
(1, 'dynamic', 'b72f3bd391ba731a35708bfd8cd8a68f', '1');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL auto_increment,
  `free_bandwidth` varchar(10) NOT NULL,
  `price_per_mb` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `free_bandwidth`, `price_per_mb`, `timestamp`) VALUES
(1, '2', '1', '2008-08-01 18:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `loggedin`
--

CREATE TABLE IF NOT EXISTS `loggedin` (
  `ip` varchar(128) NOT NULL,
  `userid` varchar(10) NOT NULL,
  `time` double NOT NULL,
  PRIMARY KEY  (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loggedin`
--


-- --------------------------------------------------------

--
-- Table structure for table `loglogin`
--

CREATE TABLE IF NOT EXISTS `loglogin` (
  `id` int(16) NOT NULL auto_increment,
  `userid` int(16) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `logintime` double NOT NULL,
  `logouttime` double default NULL,
  `logouttype` varchar(8) default NULL COMMENT 'logout, kickout, expire',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `loglogin`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(16) NOT NULL auto_increment,
  `roomno` varchar(5) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL default '1',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

