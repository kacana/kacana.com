-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2015 at 04:56 PM
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
-- Table structure for table `kacana_tag`
--

CREATE TABLE IF NOT EXISTS `kacana_tag` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kacana_tag`
--

INSERT INTO `kacana_tag` (`id`, `parent_id`, `name`, `type`, `image`, `description`, `status`, `created`, `updated`) VALUES
(1, 0, 'Giày/Ví Da Nam 01', 1, 'name_avata-10229new.jpg', 'Hello', 1, '2015-11-23 16:21:11', '2015-11-26 15:49:39'),
(2, 1, 'Giày da', 2, 'name_10420414-1784124981814871-4331881213611395279-n.jpg', '', 1, '2015-11-23 16:21:11', '2015-11-26 15:47:27'),
(3, 1, 'Ví nam', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(4, 0, 'Giày nữ', 1, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(5, 4, 'Sandal', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(6, 4, 'Giày cao gót', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(7, 4, 'Giày đế bệt', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(8, 0, 'Túi xách', 1, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(9, 8, 'Túi xách da thật 100%', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(10, 8, 'Túi xách nữ', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(11, 8, 'Túi xách hàn quốc', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(12, 8, 'Ví nữ', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(13, 8, 'Túi xách bộ ba', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(14, 8, 'Túi xách bộ hai', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(15, 0, 'Túi xách nam', 0, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(16, 15, 'Cặp da', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(17, 15, 'Túi đeo chéo', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(18, 15, 'Cặp da laptop', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(19, 0, 'Làm đẹp', 0, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(20, 19, 'Triệt lông', 2, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(21, 0, 'Váy', 1, NULL, NULL, 1, '2015-11-23 16:21:11', '2015-11-23 16:21:11'),
(22, 21, 'Đầm xuông', 2, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-23 16:21:12'),
(23, 21, 'Đầm công sở', 2, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-23 16:21:12'),
(24, 21, 'Đầm xoè', 2, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-23 16:21:12'),
(25, 0, 'Phụ kiện điện thoại', 0, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-25 17:26:11'),
(26, 25, 'Ốp điện thoại', 2, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-23 16:21:12'),
(27, 25, 'Sạc dự phòng', 2, NULL, NULL, 1, '2015-11-23 16:21:12', '2015-11-23 16:21:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kacana_tag`
--
ALTER TABLE `kacana_tag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kacana_tag`
--
ALTER TABLE `kacana_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
