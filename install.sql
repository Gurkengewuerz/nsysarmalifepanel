-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Apr 2017 um 19:53
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `altislife`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `panel_logs`
--

CREATE TABLE `panel_logs` (
  `id` int(11) NOT NULL,
  `typ` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `msg` varchar(5012) NOT NULL,
  `datetime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `panel_notes`
--

CREATE TABLE `panel_notes` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `targetid` int(11) NOT NULL,
  `note` varchar(5012) CHARACTER SET utf8mb4 NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `panel_user`
--

CREATE TABLE `panel_user` (
  `id` int(11) NOT NULL,
  `sid` bigint(17) NOT NULL,
  `locked` int(2) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `panel_perms`
--

CREATE TABLE IF NOT EXISTS `panel_perms` (
  `id` int(11) NOT NULL,
  `sid` varchar(255) NOT NULL,
  `permission` varchar(50) NOT NULL,
  `val` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `panel_logs`
--
ALTER TABLE `panel_perms`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `panel_logs`
--
ALTER TABLE `panel_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `panel_notes`
--
ALTER TABLE `panel_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `panel_user`
--
ALTER TABLE `panel_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `panel_logs`
--
ALTER TABLE `panel_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `panel_notes`
--
ALTER TABLE `panel_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `panel_user`
--
ALTER TABLE `panel_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
