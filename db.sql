-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.9 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for f3blog
DROP DATABASE IF EXISTS `f3blog`;
CREATE DATABASE IF NOT EXISTS `f3blog` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `f3blog`;

-- Dumping structure for table f3blog.tadmin
DROP TABLE IF EXISTS `tadmin`;
CREATE TABLE IF NOT EXISTS `tadmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL DEFAULT '0',
  `full_name` varchar(150) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table f3blog.tadmin: ~0 rows (approximately)
/*!40000 ALTER TABLE `tadmin` DISABLE KEYS */;
/*!40000 ALTER TABLE `tadmin` ENABLE KEYS */;

-- Dumping structure for table f3blog.tcategory
DROP TABLE IF EXISTS `tcategory`;
CREATE TABLE IF NOT EXISTS `tcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table f3blog.tcategory: ~0 rows (approximately)
/*!40000 ALTER TABLE `tcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcategory` ENABLE KEYS */;

-- Dumping structure for table f3blog.tmember
DROP TABLE IF EXISTS `tmember`;
CREATE TABLE IF NOT EXISTS `tmember` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` int(100) DEFAULT NULL,
  `password` int(100) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL COMMENT 'FREE or PREMIUM',
  `last_login` datetime DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `activation_date` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table f3blog.tmember: ~0 rows (approximately)
/*!40000 ALTER TABLE `tmember` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmember` ENABLE KEYS */;

-- Dumping structure for table f3blog.tpost
DROP TABLE IF EXISTS `tpost`;
CREATE TABLE IF NOT EXISTS `tpost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(11) DEFAULT NULL,
  `short_content` varchar(255) DEFAULT NULL,
  `full_content` longtext,
  `image` longtext,
  `create_date` datetime DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `allow_comments` tinyint(1) DEFAULT NULL,
  `types` tinyint(1) DEFAULT NULL COMMENT '0=free, 1=berbayar',
  `status` tinyint(1) DEFAULT NULL COMMENT 'Draft or Publish',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table f3blog.tpost: ~0 rows (approximately)
/*!40000 ALTER TABLE `tpost` DISABLE KEYS */;
/*!40000 ALTER TABLE `tpost` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
