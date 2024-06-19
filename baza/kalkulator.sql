-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Cze 2024, 22:41
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kalkulator`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `calculations`
--

CREATE TABLE `calculations` (
  `id` int(11) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `distance` float NOT NULL,
  `calculation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `calculations`
--

INSERT INTO `calculations` (`id`, `user_address`, `distance`, `calculation_date`) VALUES
(1, '30-612', 5244.11, '2024-06-16 10:44:48'),
(2, 'Witosa 21/81', 111665, '2024-06-16 10:49:22'),
(3, 'pawia 7 kraków', 193.007, '2024-06-16 11:00:04'),
(4, 'pawia 7 kraków', 193.007, '2024-06-16 11:01:59'),
(5, 'starowiślną 1 kraków', 1004.98, '2024-06-16 11:02:19'),
(6, 'warszawa domaniewska', 246445, '2024-06-16 11:05:05'),
(7, 'spytkowice ', 31935.9, '2024-06-16 11:07:34'),
(8, 'wadowicka 143 34-116 spytkowice', 33127, '2024-06-16 11:07:57'),
(9, 'wysłouchów 29 kraków', 6675.43, '2024-06-16 11:36:36'),
(10, 'wysłouchów 29 kraków', 6675.43, '2024-06-16 11:37:49'),
(11, 'katowice ul. witosa 21', 72616.5, '2024-06-16 11:42:37'),
(12, 'łódź pawia', 194213, '2024-06-16 13:53:22'),
(13, 'wadowicka 143 34-116 spytkowice', 33127, '2024-06-16 15:58:02'),
(14, 'starowiślna 1 kraków', 1004.98, '2024-06-16 16:00:50'),
(15, 'Witosa 21 kraków', 6342.74, '2024-06-18 19:32:18'),
(16, 'Witosa 21/81 krakó polska', 6342.74, '2024-06-18 19:38:54');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `headquarters`
--

CREATE TABLE `headquarters` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `headquarters`
--

INSERT INTO `headquarters` (`id`, `address`) VALUES
(1, 'Shoper, ul. Pawia 5, 31-154 Kraków, Polska');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `calculations`
--
ALTER TABLE `calculations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `headquarters`
--
ALTER TABLE `headquarters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `calculations`
--
ALTER TABLE `calculations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `headquarters`
--
ALTER TABLE `headquarters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
