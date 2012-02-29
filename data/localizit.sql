-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2012 at 10:57 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `localization_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_group`
--

CREATE TABLE IF NOT EXISTS `ohrm_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ohrm_group`
--

INSERT INTO `ohrm_group` (`id`, `name`) VALUES 
(1, 'General'), 
(2, 'Admin'), 
(3, 'PIM'), 
(4, 'Leave'), 
(5, 'Time'), 
(6, 'Attendance'), 
(7, 'Recruitment'), 
(8, 'RecruitmentApply'), 
(9, 'Performance'); 

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_language`
--

CREATE TABLE IF NOT EXISTS `ohrm_language` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ohrm_language`
--

INSERT INTO `ohrm_language` (`id`, `name`, `code`) VALUES
(1, 'English - US', 'en_US'),
(2, 'Sinhala - 	Sri Lanka', 'si_LK'),
(3, 'German - Germany', 'de_DE'),
(4, 'Spanish - Paraguay', 'es_PY'),
(5, 'Polish - Poland', 'pl_PL'),
(6, 'Romanian - Romania', 'ro_RO'),
(7, 'Amharic - Ethiopia', 'am_ET'),
(8, 'Oromo - Ethiopia', 'om_ET'),
(9, 'Indonesian - Indonesia', 'id_ID'),
(10, 'Danish - Denmark', 'da_DK'),
(11, 'Bulgarian - Bulgaria', 'bg_BG'),
(12, 'Spanish - Argentina', 'es_AR'),
(13, 'Arabic - Saudi Arabia', 'ar_SA'),
(14, 'Chinese - China', 'zh_CN'),
(15, 'Russian - Ukraine', 'ru_UA'),
(16, 'Italian - Italy', 'it_IT'),
(17, 'Spanish - Guatemala', 'es_GT'),
(18, 'Serbian - Serbia', 'sr_RS');


-- --------------------------------------------------------

--
-- Table structure for table `ohrm_source`
--

CREATE TABLE IF NOT EXISTS `ohrm_source` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `group_id_idx` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ohrm_source`
--


-- --------------------------------------------------------

--
-- Table structure for table `ohrm_target`
--

CREATE TABLE IF NOT EXISTS `ohrm_target` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `source_id` bigint(20) NOT NULL,
  `language_id` bigint(20) NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `source_id_idx` (`source_id`),
  KEY `language_id_idx` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ohrm_target`
--


-- --------------------------------------------------------

--
-- Table structure for table `ohrm_user`
--

CREATE TABLE IF NOT EXISTS `ohrm_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(25) NOT NULL,
  `user_type_id` bigint(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_type_id_idx` (`user_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ohrm_user`
--

INSERT INTO `ohrm_user` (`id`, `firstname`, `lastname`, `email`, `username`, `user_type_id`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin@localizit.orangehrm.com', 'admin', 1, '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Moderator', 'Moderator', 'moderator@localizit.orangehrm.com', 'moderator', 2, '0408f3c997f309c03b08bf3a4bc7b730');

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_user_language`
--

CREATE TABLE IF NOT EXISTS `ohrm_user_language` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `language_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id_idx` (`language_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ohrm_user_language`
--


-- --------------------------------------------------------

--
-- Table structure for table `ohrm_user_type`
--

CREATE TABLE IF NOT EXISTS `ohrm_user_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ohrm_user_type`
--

INSERT INTO `ohrm_user_type` (`id`, `user_type`) VALUES
(1, 'Admin'),
(2, 'Moderator');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ohrm_source`
--
ALTER TABLE `ohrm_source`
  ADD CONSTRAINT `ohrm_source_group_id_ohrm_group_id` FOREIGN KEY (`group_id`) REFERENCES `ohrm_group` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ohrm_target`
--
ALTER TABLE `ohrm_target`
  ADD CONSTRAINT `ohrm_target_language_id_ohrm_language_id` FOREIGN KEY (`language_id`) REFERENCES `ohrm_language` (`id`),
  ADD CONSTRAINT `ohrm_target_source_id_ohrm_source_id` FOREIGN KEY (`source_id`) REFERENCES `ohrm_source` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ohrm_user`
--
ALTER TABLE `ohrm_user`
  ADD CONSTRAINT `ohrm_user_user_type_id_ohrm_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `ohrm_user_type` (`id`);

--
-- Constraints for table `ohrm_user_language`
--
ALTER TABLE `ohrm_user_language`
  ADD CONSTRAINT `ohrm_user_language_language_id_ohrm_language_id` FOREIGN KEY (`language_id`) REFERENCES `ohrm_language` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ohrm_user_language_user_id_ohrm_user_id` FOREIGN KEY (`user_id`) REFERENCES `ohrm_user` (`id`) ON DELETE CASCADE;
