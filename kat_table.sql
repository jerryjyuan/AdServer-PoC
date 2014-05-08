-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. April 2010 um 08:18
-- Server Version: 5.0.67
-- PHP-Version: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `usr_web20_39`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `markt_inserate_kats`
--

CREATE TABLE IF NOT EXISTS `markt_inserate_kats` (
  `id` bigint(20) NOT NULL auto_increment,
  `kat` varchar(30) NOT NULL,
  `sub` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Daten für Tabelle `markt_inserate_kats`
--

INSERT INTO `markt_inserate_kats` (`id`, `kat`, `sub`) VALUES
(1, 'Tierwelt', 0),
(2, 'Fische', 1),
(3, 'Hunde', 1),
(4, 'Katzen', 1),
(5, 'Kleintiere', 1),
(6, 'Pferde', 1),
(7, 'Reptilien', 1),
(8, 'Voegel', 1),
(9, 'Betreuung', 1),
(10, 'Antiquitaeten', 0),
(11, 'Briefmarken', 10),
(12, 'Kunst', 10),
(13, 'Mobiliar', 10),
(14, 'Uhren & Schmuck', 10),
(15, 'Wertpapiere', 10),
(16, 'Kunstobjekte', 10),
(17, 'Baby & Kind', 0),
(18, 'Autositze', 17),
(19, 'Babyartikel', 17),
(20, 'Kleider', 17),
(21, 'Kinderwagen', 17),
(92, 'Accessoires', 30),
(23, 'Spielzeug', 17),
(24, 'Babysitter', 17),
(25, 'Elektronik', 0),
(26, 'DVD', 25),
(27, 'HiFi & Radio', 25),
(28, 'Fernsehen', 25),
(29, 'Foto & Video', 25),
(30, 'Ferien', 0),
(31, 'Camping', 30),
(32, 'Reisen', 30),
(33, 'Fahrgelegenheit', 30),
(34, 'Gratis & Tausch', 0),
(35, 'Zu verschenken', 34),
(36, 'Tauschen', 34),
(37, 'Kleider', 0),
(38, 'Damenkleider', 37),
(39, 'Herrenkleider', 37),
(40, 'Hochzeitskleider', 37),
(41, 'Uhren & Schmuck', 37),
(42, 'Schuhe', 37),
(43, 'Accessoires', 37),
(44, 'Buecher', 0),
(45, 'Belletristik', 44),
(46, 'Comics', 44),
(47, 'Jugendbuecher', 44),
(48, 'Sachbuecher', 44),
(49, 'Zeitschriften', 44),
(50, 'Musik & Film', 0),
(51, 'Instrumente', 50),
(52, 'CD-Alben', 50),
(53, 'Schallplatten', 50),
(54, 'DVD', 50),
(55, 'Tickets', 50),
(56, 'Haushalt', 0),
(58, 'Esszimmer', 56),
(59, 'Schlafzimmer', 56),
(60, 'Wohnzimmer', 56),
(62, 'Schraenke', 56),
(63, 'Dekoration', 56),
(64, 'Haushaltsgeraete', 56),
(65, 'Spiele', 0),
(66, 'PC-Spiele', 65),
(67, 'Nintendo', 65),
(68, 'Xbox', 65),
(69, 'Playstation', 65),
(70, 'Spiele', 65),
(71, 'Sport', 0),
(72, 'Wintersport', 71),
(73, 'Sommersport', 71),
(74, 'Wassersport', 71),
(75, 'Sportgeraete', 71),
(76, 'Handy & Telefon', 0),
(77, 'Handys Nokia', 76),
(78, 'Handys Sony', 76),
(79, 'Handys Motorola', 76),
(81, 'Handys Diverse', 76),
(83, 'Telefongeraete', 76),
(84, 'Faxgeraete', 76),
(85, 'Business', 0),
(90, 'Fabrikverkauf', 85),
(87, 'Gastronomie', 85),
(88, 'Grosshandel', 85),
(89, 'Dienstleistung', 85),
(91, 'Druckerei', 85),
(93, 'Unterkuenfte', 30),
(94, 'F?r Bastler', 25);
