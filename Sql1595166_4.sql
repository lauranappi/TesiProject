-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 31.11.39.66
-- Creato il: Dic 17, 2023 alle 21:08
-- Versione del server: 5.7.35-38-log
-- Versione PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sql1595166_4`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appello`
--

CREATE TABLE `appello` (
  `idAppello` int(10) NOT NULL,
  `idCorso` int(10) DEFAULT NULL,
  `nappello` tinyint(2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `oraInizio` time DEFAULT NULL,
  `oraFine` time DEFAULT NULL,
  `dataDef` date DEFAULT NULL,
  `oraInizioDef` time DEFAULT NULL,
  `oraFineDef` time DEFAULT NULL,
  `matDocente` int(11) DEFAULT NULL,
  `aula` varchar(30) DEFAULT NULL,
  `tipoAula` varchar(20) DEFAULT NULL,
  `scritto` tinyint(1) NOT NULL DEFAULT '0',
  `orale` tinyint(1) NOT NULL DEFAULT '0',
  `posti` int(4) DEFAULT NULL,
  `sessione` varchar(10) NOT NULL,
  `note` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `appello`
--

INSERT INTO `appello` (`idAppello`, `idCorso`, `nappello`, `data`, `oraInizio`, `oraFine`, `dataDef`, `oraInizioDef`, `oraFineDef`, `matDocente`, `aula`, `tipoAula`, `scritto`, `orale`, `posti`, `sessione`, `note`) VALUES
(178, 1, 1, '2022-07-21', '12:21:00', '13:21:00', '2022-07-12', '16:34:00', '17:34:00', 1, '1', 'Normale', 1, 0, 300, 'Estiva', ''),
(179, 1, 2, '2022-07-20', '12:22:00', '13:22:00', '2022-07-21', '15:35:00', '17:35:00', 1, '2', 'Linguistica', 0, 1, 300, 'Estiva', ''),
(185, 2, 1, '2022-07-21', '13:00:00', '14:00:00', '2022-09-12', '18:16:00', '19:16:00', 1, '1', 'Normale', 1, 0, 123, 'Autunnale', 'note eventuali'),
(191, 0, 1, '2022-09-12', '08:28:00', '09:28:00', NULL, NULL, NULL, 0, NULL, 'Informatica', 1, 0, 298, 'Autunnale', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `aule`
--

CREATE TABLE `aule` (
  `nomeAula` varchar(30) NOT NULL,
  `tipoAula` varchar(30) NOT NULL,
  `posti` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `aule`
--

INSERT INTO `aule` (`nomeAula`, `tipoAula`, `posti`) VALUES
('-', '', 0),
('1', 'Normale', 746),
('2', 'Linguistica', 654);

-- --------------------------------------------------------

--
-- Struttura della tabella `corso`
--

CREATE TABLE `corso` (
  `codCorso` int(10) NOT NULL,
  `nomeCorso` varchar(70) NOT NULL,
  `anno` int(4) NOT NULL,
  `semestre` int(1) NOT NULL,
  `corsodiLaurea` varchar(30) NOT NULL,
  `dipartimento` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`codCorso`, `nomeCorso`, `anno`, `semestre`, `corsodiLaurea`, `dipartimento`) VALUES
(0, 'Sviluppo software di applicazioni informatiche', 1, 2, 'ICT', 'CPS'),
(1, 'Introduzione alle reti informatiche', 1, 1, 'ICT', 'CPS'),
(2, 'Javascript', 3, 1, 'ICT', 'CPS'),
(3, 'Future internet', 3, 1, 'ICT', 'CPS');

-- --------------------------------------------------------

--
-- Struttura della tabella `insegna`
--

CREATE TABLE `insegna` (
  `codCorso` int(10) NOT NULL,
  `matricola` int(11) NOT NULL,
  `CFU` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `insegna`
--

INSERT INTO `insegna` (`codCorso`, `matricola`, `CFU`) VALUES
(1, 1, 6),
(2, 1, 9),
(0, 0, 0),
(3, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `sessioni`
--

CREATE TABLE `sessioni` (
  `idSes` int(10) NOT NULL,
  `nomeSes` varchar(10) NOT NULL,
  `numAppelli` int(1) NOT NULL,
  `inizio` date NOT NULL,
  `fine` date NOT NULL,
  `dipartimento` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sessioni`
--

INSERT INTO `sessioni` (`idSes`, `nomeSes`, `numAppelli`, `inizio`, `fine`, `dipartimento`) VALUES
(0, 'Invernale', 2, '2023-09-13', '2023-09-28', 'GIU'),
(1, 'Invernale', 3, '2022-09-13', '2022-09-28', 'CPS'),
(2, 'Estiva', 2, '2022-05-30', '2022-07-30', 'CPS'),
(3, 'Autunnale', 1, '2022-09-01', '2022-09-17', 'CPS');

-- --------------------------------------------------------

--
-- Struttura della tabella `VECCHIOdocente`
--

CREATE TABLE `VECCHIOdocente` (
  `matricola` int(11) NOT NULL,
  `cognome` varchar(11) NOT NULL,
  `nomeDoc` varchar(11) NOT NULL,
  `dipartimento` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `VECCHIOdocente`
--

INSERT INTO `VECCHIOdocente` (`matricola`, `cognome`, `nomeDoc`, `dipartimento`, `email`) VALUES
(0, 'Console', 'Luca', 'CPS', 'l.console@unito.it'),
(1, 'Gena', 'Cristina', 'CPS', 'c.gena@unito.it');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appello`
--
ALTER TABLE `appello`
  ADD PRIMARY KEY (`idAppello`),
  ADD KEY `matDocente` (`matDocente`),
  ADD KEY `idCorso` (`idCorso`),
  ADD KEY `appello_ibfk_3` (`aula`);

--
-- Indici per le tabelle `aule`
--
ALTER TABLE `aule`
  ADD PRIMARY KEY (`nomeAula`);

--
-- Indici per le tabelle `corso`
--
ALTER TABLE `corso`
  ADD PRIMARY KEY (`codCorso`);

--
-- Indici per le tabelle `insegna`
--
ALTER TABLE `insegna`
  ADD KEY `codCorso` (`codCorso`),
  ADD KEY `matricola` (`matricola`);

--
-- Indici per le tabelle `sessioni`
--
ALTER TABLE `sessioni`
  ADD PRIMARY KEY (`idSes`);

--
-- Indici per le tabelle `VECCHIOdocente`
--
ALTER TABLE `VECCHIOdocente`
  ADD PRIMARY KEY (`matricola`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appello`
--
ALTER TABLE `appello`
  MODIFY `idAppello` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appello`
--
ALTER TABLE `appello`
  ADD CONSTRAINT `appello_ibfk_1` FOREIGN KEY (`matDocente`) REFERENCES `VECCHIOdocente` (`matricola`),
  ADD CONSTRAINT `appello_ibfk_2` FOREIGN KEY (`idCorso`) REFERENCES `corso` (`codCorso`),
  ADD CONSTRAINT `appello_ibfk_3` FOREIGN KEY (`aula`) REFERENCES `aule` (`nomeAula`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limiti per la tabella `insegna`
--
ALTER TABLE `insegna`
  ADD CONSTRAINT `insegna_ibfk_1` FOREIGN KEY (`codCorso`) REFERENCES `corso` (`codCorso`),
  ADD CONSTRAINT `insegna_ibfk_2` FOREIGN KEY (`matricola`) REFERENCES `VECCHIOdocente` (`matricola`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
