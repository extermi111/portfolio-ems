-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Maj 2018, 21:12
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ems`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kartoteki`
--

CREATE TABLE `kartoteki` (
  `LP` int(11) NOT NULL,
  `Pacjent` int(11) NOT NULL,
  `Medyk` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Miejsce_zdarzenia` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Okolicznosci` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Rozpoznanie` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Leczenie` varchar(500) COLLATE utf8mb4_polish_ci NOT NULL,
  `Uwagi` varchar(1000) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ludzie`
--

CREATE TABLE `ludzie` (
  `LP` int(11) NOT NULL,
  `Name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Birthday` date NOT NULL,
  `Sex` int(1) NOT NULL,
  `Dead` int(1) NOT NULL DEFAULT '0',
  `Admin` int(11) NOT NULL DEFAULT '0',
  `Password` varchar(2000) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ludzie`
--

INSERT INTO `ludzie` (`LP`, `Name`, `Birthday`, `Sex`, `Dead`, `Admin`, `Password`) VALUES
(0, 'MasterAdmin', '0000-00-00', 0, 1, 100, '*E2FD454ECC95E41E95345F743D3FCCE9507060B9');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kartoteki`
--
ALTER TABLE `kartoteki`
  ADD PRIMARY KEY (`LP`),
  ADD KEY `Pacjent` (`Pacjent`),
  ADD KEY `Medyk` (`Medyk`);

--
-- Indeksy dla tabeli `ludzie`
--
ALTER TABLE `ludzie`
  ADD PRIMARY KEY (`LP`),
  ADD KEY `INDEX` (`LP`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `kartoteki`
--
ALTER TABLE `kartoteki`
  MODIFY `LP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `ludzie`
--
ALTER TABLE `ludzie`
  MODIFY `LP` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `kartoteki`
--
ALTER TABLE `kartoteki`
  ADD CONSTRAINT `kartoteki_ibfk_1` FOREIGN KEY (`Pacjent`) REFERENCES `ludzie` (`LP`),
  ADD CONSTRAINT `kartoteki_ibfk_2` FOREIGN KEY (`Medyk`) REFERENCES `ludzie` (`LP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
