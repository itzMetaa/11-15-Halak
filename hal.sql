-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3307
-- Létrehozás ideje: 2019. Nov 15. 09:49
-- Kiszolgáló verziója: 10.1.34-MariaDB
-- PHP verzió: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `halak`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hal`
--

CREATE TABLE `hal` (
  `hal_id` int(11) NOT NULL,
  `hal_nev` text COLLATE utf8_hungarian_ci NOT NULL,
  `hal_raktaron` int(11) NOT NULL DEFAULT '0',
  `hal_tilalom` tinyint(1) NOT NULL DEFAULT '0',
  `hal_utolso_fogas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `hal`
--

INSERT INTO `hal` (`hal_id`, `hal_nev`, `hal_raktaron`, `hal_tilalom`, `hal_utolso_fogas`) VALUES
(1, 'Pisztráng', 220, 0, '2002-01-02'),
(2, 'Harcsa', 6, 1, '2017-11-11'),
(3, 'Törpe uszonyos', 69, 0, '2006-04-11');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `hal`
--
ALTER TABLE `hal`
  ADD PRIMARY KEY (`hal_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `hal`
--
ALTER TABLE `hal`
  MODIFY `hal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
