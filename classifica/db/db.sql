-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 16, 2023 alle 17:37
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serie_a`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `classifica`
--

CREATE TABLE `classifica` (
  `id` int(11) NOT NULL,
  `squadra` int(11) DEFAULT NULL,
  `punti` int(11) DEFAULT NULL,
  `GF` int(11) DEFAULT NULL,
  `GS` int(11) DEFAULT NULL,
  `vinte` int(11) DEFAULT NULL,
  `pareggi` int(11) DEFAULT NULL,
  `sconfitte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `partita`
--

CREATE TABLE `partita` (
  `id` int(11) NOT NULL,
  `giornata` int(11) DEFAULT NULL,
  `squadra_casa` int(11) DEFAULT NULL,
  `squadra_ospite` int(11) DEFAULT NULL,
  `reti_casa` int(11) DEFAULT NULL,
  `reti_ospiti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `partita`
--

INSERT INTO `partita` (`id`, `giornata`, `squadra_casa`, `squadra_ospite`, `reti_casa`, `reti_ospiti`) VALUES
(1, 1, 5, 14, 4, 1),
(2, 1, 1, 6, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `squadra`
--

CREATE TABLE `squadra` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `squadra`
--

INSERT INTO `squadra` (`id`, `nome`) VALUES
(1, 'atalanta'),
(2, 'bologna'),
(3, 'cremonese'),
(4, 'Empoli'),
(5, 'fiorentina'),
(6, 'hellas Verona'),
(7, 'inter'),
(8, 'Juventus'),
(9, 'Lazio'),
(10, 'lecce'),
(11, 'milan'),
(12, 'Monza'),
(13, 'napoli'),
(14, 'roma'),
(15, 'salernitana'),
(16, 'Sampdoria'),
(17, 'Sassuolo'),
(18, 'spezia'),
(19, 'torino'),
(20, 'udinese');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `classifica`
--
ALTER TABLE `classifica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `squadra` (`squadra`);

--
-- Indici per le tabelle `partita`
--
ALTER TABLE `partita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `squadra_casa` (`squadra_casa`),
  ADD KEY `squadra_ospite` (`squadra_ospite`);

--
-- Indici per le tabelle `squadra`
--
ALTER TABLE `squadra`
  ADD PRIMARY KEY (`id`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `classifica`
--
ALTER TABLE `classifica`
  ADD CONSTRAINT `classifica_ibfk_1` FOREIGN KEY (`squadra`) REFERENCES `squadra` (`id`);

--
-- Limiti per la tabella `partita`
--
ALTER TABLE `partita`
  ADD CONSTRAINT `partita_ibfk_1` FOREIGN KEY (`squadra_casa`) REFERENCES `squadra` (`id`),
  ADD CONSTRAINT `partita_ibfk_2` FOREIGN KEY (`squadra_ospite`) REFERENCES `squadra` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
