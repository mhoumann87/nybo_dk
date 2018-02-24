-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1:3306
-- Genereringstid: 24. 02 2018 kl. 19:02:35
-- Serverversion: 5.7.19
-- PHP-version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nybo_dk`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `kategorier`
--

DROP TABLE IF EXISTS `kategorier`;
CREATE TABLE IF NOT EXISTS `kategorier` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_navn` varchar(255) NOT NULL,
  PRIMARY KEY (`kategori_id`),
  UNIQUE KEY `kategori_navn` (`kategori_navn`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
