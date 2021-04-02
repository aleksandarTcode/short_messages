-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2021 at 06:23 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messages`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `msg_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user1` (`user1`),
  KEY `user2` (`user2`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user1`, `user2`, `msg_count`) VALUES
(1, 'aco', 'dave', 1),
(2, 'aco', 'jane', 1),
(5, 'aco', 'susie', 5),
(6, 'dave', 'joe', 1),
(7, 'jane', 'susie', 0),
(8, 'joe', 'miki', 1),
(9, 'dave', 'aco', 0),
(10, 'miki', 'aco', 0);

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

DROP TABLE IF EXISTS `msg`;
CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `recipient` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `msg_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_msg` tinyint(4) NOT NULL DEFAULT '0',
  `read_msg` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `sender`, `recipient`, `msg_text`, `time`, `sent_msg`, `read_msg`) VALUES
(2, 'aco', 'dave', 'Hey, how are you?', '2021-03-23 08:58:07', 1, 1),
(3, 'aco', 'susie', 'Bring me those books please', '2021-03-23 08:58:07', 1, 0),
(4, 'aco', 'susie', 'Tomorrow would be the best', '2021-03-23 09:00:39', 1, 0),
(5, 'dave', 'joe', 'When do we have practice', '2021-03-23 09:00:39', 1, 0),
(6, 'joe', 'miki', 'Man you are moron', '2021-03-23 09:01:15', 1, 0),
(7, 'jane', 'aco', 'Ok, I will!', '2021-03-29 06:57:06', 1, 1),
(9, 'susie', 'aco', 'Its a deal', '2021-03-23 08:59:00', 1, 1),
(10, 'susie', 'aco', 'No problem', '2021-03-29 09:55:35', 1, 1),
(11, 'susie', 'aco', 'tomorrow ', '2021-03-29 11:24:49', 1, 1),
(12, 'aco', 'susie', '<p>see you then</p>\r\n', '2021-03-30 08:32:16', 1, 0),
(13, 'aco', 'susie', '<p>are&nbsp;<strong>you already&nbsp;<em>here?</em></strong></p>\r\n', '2021-03-30 08:33:53', 1, 0),
(14, 'aco', 'susie', '<p>im here</p>\r\n', '2021-03-30 08:42:16', 1, 0),
(15, 'susie', 'aco', '<p>coming in two minutes</p>\r\n', '2021-03-30 08:43:12', 1, 1),
(16, 'aco', 'susie', '<p>waiting&nbsp;</p>\r\n', '2021-03-30 09:14:28', 1, 0),
(17, 'aco', 'dave', '<p>hey man, whats up</p>\r\n', '2021-03-30 09:21:55', 1, 1),
(18, 'dave', 'aco', '<p>hey im great, you</p>', '2021-03-30 09:22:51', 1, 1),
(19, 'joe', 'dave', '<p>who is that</p>\r\n', '2021-03-30 10:35:46', 1, 1),
(20, 'aco', 'dave', '<p>next week</p>\r\n', '2021-04-01 10:35:32', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone_1` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone_2` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `phone_1`, `phone_2`) VALUES
(1, 'aco', 'aco123', 'Aleksandar', 'Trmcic', '0643214321', ''),
(2, 'miki', 'miki123', 'Mike', 'Michelson', '0641234567', '069345678'),
(3, 'jane', 'jane123', 'Jane', 'Johnson', '0601112333', '0612223444'),
(4, 'joe', 'joe123', 'John', 'Doe', '063223344', ''),
(5, 'dave', 'dave123', 'Dave', 'Davidson', '0652002000', ''),
(6, 'susie', 'susie123', 'Susan', 'Richardson', '063333444', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `users` (`username`);

--
-- Constraints for table `msg`
--
ALTER TABLE `msg`
  ADD CONSTRAINT `msg_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `msg_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
