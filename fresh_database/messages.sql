-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 29, 2023 at 08:34 AM
-- Server version: 5.7.24
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `msg_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user1` (`user1`),
  KEY `user2` (`user2`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user1`, `user2`, `msg_count`) VALUES
(13, 'ebrown234', 'aleksandar', 0),
(14, 'ebrown234', 'jsmith456', 0),
(15, 'ljacks901', 'aleksandar', 0),
(16, 'ljacks901', 'rjones012', 0),
(17, 'ljacks901', 'swilson123', 0),
(18, 'rjones012', 'ebrown234', 0),
(19, 'rgarc567', 'aleksandar', 0),
(20, 'rgarc567', 'jsmith456', 0),
(21, 'rgarc567', 'ebrown234', 0),
(22, 'rgarc567', 'swilson123', 0),
(23, 'rgarc567', 'ljacks901', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `sender`, `recipient`, `msg_text`, `time`, `sent_msg`, `read_msg`) VALUES
(31, 'ebrown234', 'aleksandar', '<p>hey sir</p>\r\n', '2023-04-29 08:22:10', 0, 1),
(33, 'rjones012', 'ebrown234', '<p>hello emily</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2023-04-29 08:28:26', 0, 0),
(34, 'rgarc567', 'aleksandar', '<p>how are you aleksandar</p>\r\n', '2023-04-29 08:31:46', 0, 0),
(35, 'aleksandar', 'ebrown234', '<p>im fine how are you</p>\r\n', '2023-04-29 08:32:44', 0, 0);

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
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `user_photo` text COLLATE utf8_unicode_ci,
  `time_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `role`, `user_photo`, `time_registered`) VALUES
(22, 'aleksandar', '$2y$10$nK7AYbiXmgHt0b9l0FQrKerXOrCzIe/d4rYvFP3x/aO7MUwSIfLUe', 'Aleksandar', 'Trmcic', 'aleksandar.trmcic@gmail.com', '123456789', 'admin', '04-29-2023_10-10-47.jpeg', '2023-04-29 08:09:26'),
(23, 'jsmith456', '$2y$10$b.mgqYmGvw7UNaWh9iQ9U.XlnIXitDvrEwiuED4AXYxo.0XOh5Exm', 'John', 'Smith', 'jsmith456@gmail.com', '123456789', 'user', '04-29-2023_10-24-33.jpg', '2023-04-29 08:15:11'),
(24, 'dsmith789', '$2y$10$yXKCVtcHQwE8z2Y1FIVOruZWTh4FZHMzvXs743EyBYsyggxoDIP1m', 'David', 'Smith', 'dsmith789@gmail.com', '987654321', 'user', '04-29-2023_10-25-40.jpeg', '2023-04-29 08:16:03'),
(25, 'rjones012', '$2y$10$RZNhtgVHymXismrTF0xrIeXdeIrka6vBT72tca/ZGvROYrd1M10Wq', 'Robert', 'Jones', 'rjones012@gmail.com', '123654789', 'user', '04-29-2023_10-27-26.jpeg', '2023-04-29 08:16:58'),
(26, 'swilson123', '$2y$10$2WRJ52CmN/6yjFx9uBXOJulZkNw.pP.PnS/Xmdq/huTB4ISbhMeI2', 'Sarah', 'Wilson', 'swilson123@gmail.com', '6542139877', 'user', '04-29-2023_10-29-03.jpeg', '2023-04-29 08:17:36'),
(27, 'ljacks901', '$2y$10$xMeoKu4Yqsueukc2QngL6e4BqNCeEF/WeLSkcWqGbtnhjmhWfJ6Wi', 'Laura', 'Jackson', 'ljacks901@gmail.com', '9996587412', 'user', '04-29-2023_10-23-04.jpg', '2023-04-29 08:18:11'),
(28, 'rgarc567', '$2y$10$ukE7ZNsvcbdlgQX5SZqBw./bJ62uMNV/IfL3Wm8dONxoKM3NYkxm2', 'Rebecca', 'Garcia', 'rgarc567@gmail.com', '456123987', 'user', '04-29-2023_10-29-47.jpeg', '2023-04-29 08:18:52'),
(29, 'ebrown234', '$2y$10$.NvMoZ.U1FgvOzrQwKBpAO7Kdy50PdFN7z4AKX1RFkNY7YBHm8ejK', 'Emily', 'Brown', 'ebrown234@gmail.com', '123456789', 'user', '04-29-2023_10-21-05.jpg', '2023-04-29 08:19:44');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `msg`
--
ALTER TABLE `msg`
  ADD CONSTRAINT `msg_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `msg_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
