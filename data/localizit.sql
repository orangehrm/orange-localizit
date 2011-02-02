-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2011 at 09:03 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `orhrm_localization_mysql`
--

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_label`
--

CREATE TABLE IF NOT EXISTS `ohrm_label` (
  `label_id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(45) NOT NULL,
  `label_comment` varchar(100) DEFAULT NULL,
  `label_status` enum('0','1') NOT NULL,
  PRIMARY KEY (`label_id`),
  UNIQUE KEY `label_name` (`label_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_language`
--

CREATE TABLE IF NOT EXISTS `ohrm_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(10) NOT NULL,
  `language_name` varchar(45) NOT NULL,
  `language_status` enum('0','1') NOT NULL,
  PRIMARY KEY (`language_id`),
  UNIQUE KEY `language_code` (`language_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_language_label_string`
--

CREATE TABLE IF NOT EXISTS `ohrm_language_label_string` (
  `language_label_string_id` int(11) NOT NULL,
  `label_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `language_label_string` varchar(45) NOT NULL,
  `language_label_string_status` enum('0','1') NOT NULL,
  PRIMARY KEY (`language_label_string_id`),
  UNIQUE KEY `label_id_language_id_language_string` (`label_id`,`language_id`,`language_label_string`),
  KEY `fk_ohrm_language_label_string_ohrm_label` (`label_id`),
  KEY `fk_ohrm_language_label_string_ohrm_language` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ohrm_language_label_string`
--
ALTER TABLE `ohrm_language_label_string`
  ADD CONSTRAINT `fk_ohrm_language_label_string_ohrm_label` FOREIGN KEY (`label_id`) REFERENCES `ohrm_label` (`label_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ohrm_language_label_string_ohrm_language` FOREIGN KEY (`language_id`) REFERENCES `ohrm_language` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

