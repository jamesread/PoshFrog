-- +migrate Up
-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: mysql5x.streamline.net
-- Generation Time: Mar 10, 2006 at 03:17 PM
-- Server version: 4.0.25
-- PHP Version: 4.3.11
-- 
-- Database: `jwread1`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `activitys`
-- 

CREATE TABLE `activitys` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `turns` int(11) NOT NULL default '0',
  `gold` int(11) NOT NULL default '0',
  `type` enum('PRODUCTION','SPARE_TIME') NOT NULL default 'PRODUCTION',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `clans`
-- 

CREATE TABLE `clans` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `members` longtext NOT NULL,
  `password` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hints`
-- 

CREATE TABLE `hints` (
  `id` int(11) NOT NULL auto_increment,
  `hint` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `inventory`
-- 

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL default '',
  `owner` varchar(255) NOT NULL default '',
  `item` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `map`
-- 

CREATE TABLE `map` (
  `id` int(11) NOT NULL auto_increment,
  `tileset` varchar(255) NOT NULL default '',
  `traversable` varchar(255) NOT NULL default '',
  `coordinates` varchar(255) NOT NULL default '',
  `quadrent` varchar(255) NOT NULL default '',
  `exit` varchar(255) NOT NULL default '',
  `exit_quadrent` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `quadrents`
-- 

CREATE TABLE `quadrents` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE `settings` (
  `key` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  KEY `key` (`key`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `shop`
-- 

CREATE TABLE `shop` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('BUSSINESS','ACCESSORY') NOT NULL default 'BUSSINESS',
  `name` varchar(255) NOT NULL default '',
  `gold` int(11) NOT NULL default '0',
  `turns` int(11) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `slaves`
-- 

CREATE TABLE `slaves` (
  `id` int(11) NOT NULL auto_increment,
  `owner` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `gold` int(11) NOT NULL default '10',
  `type` enum('SLAVE') NOT NULL default 'SLAVE',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tilesets`
-- 

CREATE TABLE `tilesets` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `gold` int(11) NOT NULL default '0',
  `registerd` varchar(255) NOT NULL default '',
  `userlevel` int(11) NOT NULL default '0',
  `usedturns` int(11) NOT NULL default '0',
  `slaves` varchar(255) NOT NULL default '',
  `bankgold` int(11) NOT NULL default '0',
  `map_location` varchar(255) NOT NULL default '',
  `clan` varchar(255) NOT NULL default '',
  `registered` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 ;

-- +migrate Down
