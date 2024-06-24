-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 24, 2024 at 03:30 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_anggota`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `action`, `created_at`) VALUES
(3, '{\"title\":\"New Anggota\",\"name\":\"ipada\",\"birthdate\":\"2018-12-31\"}', '2024-06-16 12:59:50'),
(4, '{\"title\":\"Edit fraksi\",\"name\":\"tes fraksi dwadwa\"}', '2024-06-24 09:29:21'),
(5, '{\"title\":\"Edit fraksi\",\"name\":\"tes fraksi 2d awd dwa\"}', '2024-06-24 09:29:26'),
(6, '{\"title\":\"Delete fraksi\",\"id\":\"2\"}', '2024-06-24 09:34:59'),
(7, '{\"title\":\"Delete fraksi\",\"id\":\"1\"}', '2024-06-24 09:35:03'),
(8, '{\"title\":\"Edit fraksi\",\"name\":\"tess\"}', '2024-06-24 09:39:55'),
(9, '{\"title\":\"Delete fraksi\",\"id\":\"dwadawwa\"}', '2024-06-24 09:42:27'),
(10, '{\"title\":\"Edit fraksi\",\"name\":\"fraksi 1\"}', '2024-06-24 09:42:33'),
(11, '{\"title\":\"Delete fraksi\",\"id\":\"3\"}', '2024-06-24 09:42:36'),
(12, '{\"title\":\"Delete fraksi\",\"id\":\"core\"}', '2024-06-24 09:42:44'),
(13, '{\"title\":\"New Anggota\",\"name\":\"dwada\",\"birthdate\":\"2024-06-11\"}', '2024-06-24 09:54:30'),
(14, '{\"title\":\"Vote Anggota\",\"id\":\"10\"}', '2024-06-24 10:28:35'),
(15, '{\"title\":\"New Anggota\",\"name\":\"dwada a daw\",\"birthdate\":\"2024-06-12\"}', '2024-06-24 10:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES
(1, 'admin', 'admin', '$2y$10$AQwi1dTcUM8FbaJyREsX7O8qy7fz74uCGDh4JsdWJZVboQYr2oCve');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
CREATE TABLE IF NOT EXISTS `anggota` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fraksi_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fraksi_id` (`fraksi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `fraksi_id`, `name`, `birthdate`, `created_at`) VALUES
(10, 4, 'dwada', '2024-06-11', '2024-06-24 16:54:30'),
(11, 4, 'dwada a daw', '2024-06-12', '2024-06-24 17:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `fraksi`
--

DROP TABLE IF EXISTS `fraksi`;
CREATE TABLE IF NOT EXISTS `fraksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fraksi`
--

INSERT INTO `fraksi` (`id`, `name`) VALUES
(4, 'core');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_anggota` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `id_anggota`) VALUES
(1, 10),
(2, 10),
(3, 10);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`fraksi_id`) REFERENCES `fraksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
