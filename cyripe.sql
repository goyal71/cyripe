-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 14, 2014 at 12:12 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cyripe`
--

-- --------------------------------------------------------

--
-- Table structure for table `dropdowns`
--

CREATE TABLE IF NOT EXISTS `dropdowns` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `profile_fields_ID` int(11) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `Sequence` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `profile_fields_ID` (`profile_fields_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dropdowns`
--

INSERT INTO `dropdowns` (`ID`, `profile_fields_ID`, `Value`, `Sequence`) VALUES
(1, 1, 'SM', 0),
(2, 1, 'MED', 1),
(3, 1, 'LG', 2),
(4, 1, 'XL', 3),
(5, 16, 'Metal', 0),
(6, 16, 'Rap', 1),
(7, 16, 'Country', 2),
(8, 16, 'Dubstep', 3);

-- --------------------------------------------------------

--
-- Table structure for table `input_types`
--

CREATE TABLE IF NOT EXISTS `input_types` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `input_types`
--



-- --------------------------------------------------------

--
-- Table structure for table `profile_fields`
--

CREATE TABLE IF NOT EXISTS `profile_fields` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Label` varchar(250) NOT NULL,
  `input_types_ID` int(11) NOT NULL,
  `profile_types_ID` int(11) NOT NULL,
  `Sequence` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `profile_fields_input_types` (`input_types_ID`),
  KEY `profile_fields_profile_types` (`profile_types_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `profile_fields`
--

INSERT INTO `profile_fields` (`ID`, `Label`, `input_types_ID`, `profile_types_ID`, `Sequence`) VALUES
(1, 'Size', 2, 1, 0),
(2, 'Color', 1, 1, 2),
(7, 'Test Add Field', 1, 1, 3),
(9, 'Favorite Artist', 1, 2, 1),
(10, 'Test 1', 2, 9, 1),
(11, 'Test Multiline Field', 3, 1, 1),
(13, 'asdfg', 3, 1, 5),
(16, 'Genre', 6, 2, 2),
(17, 'Test multiselect', 6, 11, 1),
(19, 'Dropdown', 2, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `profile_types`
--

CREATE TABLE IF NOT EXISTS `profile_types` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DisplayName` varchar(100) NOT NULL,
  `IconUrl` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `profile_types`
--

INSERT INTO `profile_types` (`ID`, `DisplayName`, `IconUrl`) VALUES
(1, 'Shopping', 'shopping-bag-icon.png'),
(2, 'Music', 'music-note-icon.png'),
(3, 'Dating', 'dating-icon.png'),
(9, 'Test 2', ''),
(11, 'test1', '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_configuration`
--

CREATE TABLE IF NOT EXISTS `uc_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `uc_configuration`
--

INSERT INTO `uc_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'Cyripe'),
(2, 'website_url', ''),
(3, 'email', 'mail@nimit.me'),
(4, 'activation', 'false'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', 'models/languages/en.php'),
(7, 'template', 'models/site-templates/default.css');

-- --------------------------------------------------------

--
-- Table structure for table `uc_pages`
--

CREATE TABLE IF NOT EXISTS `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `uc_pages`
--

INSERT INTO `uc_pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(4, 'admin_page.php', 1),
(5, 'admin_pages.php', 1),
(6, 'admin_permission.php', 1),
(7, 'admin_permissions.php', 1),
(8, 'admin_user.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(12, 'left-nav.php', 0),
(13, 'login.php', 0),
(14, 'logout.php', 1),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(17, 'user_settings.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uc_permissions`
--

CREATE TABLE IF NOT EXISTS `uc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `uc_permissions`
--

INSERT INTO `uc_permissions` (`id`, `name`) VALUES
(1, 'New Member'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `uc_permission_page_matches`
--

CREATE TABLE IF NOT EXISTS `uc_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `uc_permission_page_matches`
--

INSERT INTO `uc_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(1, 1, 1),
(2, 1, 14),
(3, 1, 17),
(4, 2, 1),
(5, 2, 3),
(6, 2, 4),
(7, 2, 5),
(8, 2, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 14),
(13, 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `uc_users`
--

CREATE TABLE IF NOT EXISTS `uc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `uc_users`
--

INSERT INTO `uc_users` (`id`, `user_name`, `display_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
(1, 'admin', 'admin', '9d0772255f592d4a2b1bd7162ff51bbad056758c284a0daf7347f053ae7662895', 'mail@nimit.me', 'd73cf4ce5de944d0868cd992268df0fe', 1410855264, 0, 1, 'New Member', 1410855264, 1413242698),
(2, 'goyal', 'goyal', 'a25f7f11bee45d774fb677ec215a0fd1e64b75ebd0dbfcf428d80e6168dd82214', 'goyal.71@osu.edu', '6e1cdd1ecadcde94a6e8ec3915eb0858', 1410857075, 0, 1, 'New Member', 1410857075, 1410904173),
(3, 'ravik', 'ravik', 'cbe640bfe68ca76c48e01b43546fa7bd53c438a1f31a37c645506c4571d379eb0', 'kumar.428@osu.edu', '4c20ebdddb139602cbccf6989cf8f417', 1410888004, 0, 1, 'New Member', 1410888004, 0),
(4, 'batman', 'DarkKnight', '63c239fc02768e95b0f1e0bdfc97bd0e43d67da5967f8532e48bbf97406e3d38f', 'batman@batcave.com', '050d5bd6b09b7f5762bf1c44ea662cc0', 1410899045, 0, 1, 'Leader of Justice League', 1410899045, 1410899225),
(5, 'abcde', 'abcde', 'f30f9900027b650ee4815d995a9af35c84b42aa5bf5798b0bf72a77f77b36753a', 'kumarravi.k78c@gmail.com', '33929875bfcd88ea74fde08347ac1e35', 1410901466, 0, 1, 'New Member', 1410901466, 0),
(6, 'qwerty', 'qwerty', '52713af0b22b2b1bebfa3aca8e6a28492e5f5e8b87ddfa7ab2e7aa4ff959c5bb6', 'nimit.goyal2009@vit.ac.in', 'f9ccaa8b9fe7160edc5586e950215783', 1410901716, 0, 0, 'New Member', 1410901716, 0),
(7, 'aaaaa', 'aaaaa', 'a678a1f6fd489e96cd9ef8d721e5df62fa6ffd528b7e6aed2fcd01a39a380683b', 'goyal.71@buckeyemail.osu.edu', '3ecb586f670e0f3d5ebbe5dd6864be53', 1410932784, 0, 1, 'New Member', 1410932784, 0),
(8, 'teej2010', 'Timothy', '58c985b416738c939840420eacc0a8cbea1c8d2b7c18f84c142ef30e65a22b12f', 'van-eerten.1@osu.edu', '93d4c48f03d30613910484fbc648b48d', 1411418903, 0, 1, 'New Member', 1411418903, 1412923265),
(9, 'teej20001', 'Timothy', 'e4576514c9f428d76b2a0eb3f353c91b6ad31e0bbca056a1c233170d5f24b3f6f', 'teej_2010@yahoo.com', 'a65b2d9b8f34d17b83f3bb608940180b', 1412133294, 0, 1, 'New Member', 1412133294, 1412133307);

-- --------------------------------------------------------

--
-- Table structure for table `uc_user_permission_matches`
--

CREATE TABLE IF NOT EXISTS `uc_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `uc_user_permission_matches`
--

INSERT INTO `uc_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 1),
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 1),
(8, 7, 1),
(9, 8, 1),
(10, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile_map`
--

CREATE TABLE IF NOT EXISTS `user_profile_map` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `profile_types_ID` int(11) NOT NULL,
  `uc_users_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_profile_map_profile_types` (`profile_types_ID`),
  KEY `uc_users_ID` (`uc_users_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `user_profile_map`
--

INSERT INTO `user_profile_map` (`ID`, `profile_types_ID`, `uc_users_ID`) VALUES
(2, 2, 8),
(3, 3, 8),
(30, 1, 8),
(32, 1, 1),
(34, 3, 1),
(39, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_saved_fields`
--

CREATE TABLE IF NOT EXISTS `user_saved_fields` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Value` varchar(1000) NOT NULL,
  `profile_fields_ID` int(11) NOT NULL,
  `uc_users_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_saved_fields_profile_fields` (`profile_fields_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `user_saved_fields`
--

INSERT INTO `user_saved_fields` (`ID`, `Value`, `profile_fields_ID`, `uc_users_ID`) VALUES
(34, 'XL', 1, 8),
(38, 'LG', 1, 1),
(41, 'Blue', 2, 1),
(42, 'test add field value', 7, 1),
(46, 'Test multiline saved field', 11, 1),
(48, 'test', 13, 1),
(49, 'Blue', 2, 8),
(50, '', 7, 8),
(51, '', 11, 8),
(53, '', 13, 8),
(61, '', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_saved_multiselect`
--

CREATE TABLE IF NOT EXISTS `user_saved_multiselect` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Value` varchar(200) NOT NULL,
  `profile_fields_ID` int(11) NOT NULL,
  `uc_users_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `dropdowns_ID` (`Value`,`profile_fields_ID`,`uc_users_ID`),
  KEY `profile_fields_ID` (`profile_fields_ID`),
  KEY `uc_users_ID` (`uc_users_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_saved_multiselect`
--

INSERT INTO `user_saved_multiselect` (`ID`, `Value`, `profile_fields_ID`, `uc_users_ID`) VALUES
(10, 'Country', 16, 1),
(9, 'Rap', 16, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dropdowns`
--
ALTER TABLE `dropdowns`
  ADD CONSTRAINT `dropdowns_ibfk_2` FOREIGN KEY (`profile_fields_ID`) REFERENCES `profile_fields` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `profile_fields`
--
ALTER TABLE `profile_fields`
  ADD CONSTRAINT `profile_fields_input_types` FOREIGN KEY (`input_types_ID`) REFERENCES `input_types` (`ID`),
  ADD CONSTRAINT `profile_fields_profile_types` FOREIGN KEY (`profile_types_ID`) REFERENCES `profile_types` (`ID`);

--
-- Constraints for table `user_profile_map`
--
ALTER TABLE `user_profile_map`
  ADD CONSTRAINT `user_profile_map_ibfk_1` FOREIGN KEY (`uc_users_ID`) REFERENCES `uc_users` (`id`),
  ADD CONSTRAINT `user_profile_map_profile_types` FOREIGN KEY (`profile_types_ID`) REFERENCES `profile_types` (`ID`);

--
-- Constraints for table `user_saved_fields`
--
ALTER TABLE `user_saved_fields`
  ADD CONSTRAINT `user_saved_fields_profile_fields` FOREIGN KEY (`profile_fields_ID`) REFERENCES `profile_fields` (`ID`);

--
-- Constraints for table `user_saved_multiselect`
--
ALTER TABLE `user_saved_multiselect`
  ADD CONSTRAINT `user_saved_multiselect_ibfk_4` FOREIGN KEY (`profile_fields_ID`) REFERENCES `profile_fields` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_saved_multiselect_ibfk_3` FOREIGN KEY (`uc_users_ID`) REFERENCES `uc_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
