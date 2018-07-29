-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 29 jul 2018 om 18:36
-- Serverversie: 5.5.60
-- PHP-Versie: 5.4.45-0+deb7u13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `paintdatabase`
--
CREATE DATABASE `paintdatabase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `paintdatabase`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brand_types`
--

CREATE TABLE IF NOT EXISTS `brand_types` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) NOT NULL,
  `imagepath` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brands_types`
--

CREATE TABLE IF NOT EXISTS `brands_types` (
  `brands_id` int(5) NOT NULL,
  `types_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `color_id` int(6) NOT NULL AUTO_INCREMENT,
  `brands_id` int(5) NOT NULL,
  `types_id` int(5) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `color_code` varchar(50) NOT NULL,
  `rgb` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`color_id`),
  UNIQUE KEY `brands_id` (`brands_id`,`types_id`,`color_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=728 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logging`
--

CREATE TABLE IF NOT EXISTS `logging` (
  `logentryid` int(11) NOT NULL AUTO_INCREMENT,
  `logvalue` text NOT NULL,
  `usersid` int(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`logentryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `models`
--

CREATE TABLE IF NOT EXISTS `models` (
  `models_id` int(5) NOT NULL AUTO_INCREMENT,
  `models_brand` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `scale` varchar(10) NOT NULL,
  `prodnumber` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`models_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `airbrush` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(5) NOT NULL AUTO_INCREMENT,
  `users_name` varchar(50) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `last_login` int(50) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_colors`
--

CREATE TABLE IF NOT EXISTS `users_colors` (
  `paints_id` int(5) NOT NULL AUTO_INCREMENT,
  `users_id` int(5) NOT NULL,
  `color_id` int(6) NOT NULL,
  `stock` int(5) NOT NULL,
  PRIMARY KEY (`paints_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_models`
--

CREATE TABLE IF NOT EXISTS `users_models` (
  `um_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `model_id` int(5) NOT NULL,
  `model_date` int(11) DEFAULT NULL,
  `comments` text,
  `shared` int(2) NOT NULL,
  PRIMARY KEY (`um_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_models_colors`
--

CREATE TABLE IF NOT EXISTS `users_models_colors` (
  `umc_id` int(5) NOT NULL AUTO_INCREMENT,
  `um_id` int(5) NOT NULL,
  `paints_id` int(5) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`umc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_models_images`
--

CREATE TABLE IF NOT EXISTS `users_models_images` (
  `umg_id` int(5) NOT NULL AUTO_INCREMENT,
  `um_id` int(5) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `upload_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`umg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
