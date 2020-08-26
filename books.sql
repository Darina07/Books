-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2020 at 11:01 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lr`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `isbn` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `isbn`, `description`, `image`) VALUES
(54, 'test1', '12345', '  test 1 creating book', 'books.jpg'),
(52, 'testbook111', '111', '			 				 				 				 				 				 				 				 				 				 	  dcwdcwc			 			 			 			 			 			 			 			 			 			 ', 'bbb.png'),
(53, 'Alice', '1234567', 'Alisia		 			 ', 'untitled.png'),
(51, 'book-444', '333book333', '			 				 				 				 				 				 				 	  rtgrtgrtg			 			 			 			 			 			 			 ', 'untitled.png'),
(55, 'yyy', '123456', '  eeeeeeeeeeeeeeee', 'aaa.jpg'),
(49, 'book123456', '111', '			 				 	  hdvbduf			 			 ', 'llll.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_administrator` tinyint(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `active` tinyint(11) DEFAULT NULL,
  `approved` tinyint(10) UNSIGNED DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_administrator`, `first_name`, `last_name`, `email`, `password`, `active`, `approved`) VALUES
(1, 1, 'Darina', 'Zvetanovaa', 'karidimitrova@yahoo.com', '1fb4bf9c86aa8e496e51e396c1f98f4e', 1, 1),
(2, 1, 'Karita', 'Ivanovaa', 'kari@site.com', 'a3ea445eff353621363621207e8d11a5', 1, 1),
(3, 1, 'aaa', 'aaa', 'aaa@site.com', 'd9f6e636e369552839e7bb8057aeb8da', NULL, 1),
(4, 1, 'georgi', 'ivanov', 'georgi@site.com', 'dacbd77a9d6b06bc4fd990cd9b1d9902', 1, 1),
(5, 0, 'wawa', 'wawa', 'wawa@site.com', '3dd1eb4d3ab5dee548b6bd522d8b5f1d', 1, 1),
(6, 0, 'riri', 'rorrpp', 'riri@site.com', '86ae0211818cfc618f8c84433a433467', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_books`
--

CREATE TABLE `users_books` (
  `id` int(10) UNSIGNED NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `books_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_books`
--

INSERT INTO `users_books` (`id`, `users_id`, `books_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 2),
(12, 2, 47),
(11, 2, 48),
(28, 6, 52),
(34, 2, 52),
(35, 2, 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_books`
--
ALTER TABLE `users_books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_books`
--
ALTER TABLE `users_books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
