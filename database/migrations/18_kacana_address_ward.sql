-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2015 at 01:15 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kacana`
--

-- --------------------------------------------------------

--
-- Table structure for table `kacana_address_ward`
--

CREATE TABLE IF NOT EXISTS `kacana_address_ward` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kacana_address_ward`
--

INSERT INTO `kacana_address_ward` (`id`, `city_id`, `name`) VALUES
(1, 1, 'Quận 1'),
(2, 1, 'Quận 2'),
(3, 1, 'Quận 3'),
(4, 1, 'Quận 4'),
(5, 2, 'Hoàn Kiếm'),
(6, 2, 'Ba Đình');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kacana_address_ward`
--
ALTER TABLE `kacana_address_ward`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kacana_address_ward`
--
ALTER TABLE `kacana_address_ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
