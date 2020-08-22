-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 22 Αυγ 2020 στις 20:16:27
-- Έκδοση διακομιστή: 10.4.14-MariaDB
-- Έκδοση PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `web_project`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `activity`
--

CREATE TABLE `activity` (
  `userID` varchar(255) NOT NULL,
  `dataID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `activityID` int(11) NOT NULL,
  `timestampMs` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `eco`
--

CREATE TABLE `eco` (
  `userID` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `ecoscore` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `history`
--

CREATE TABLE `history` (
  `userID` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `executed` enum('Yes','No') DEFAULT NULL,
  `type` enum('insert','update','delete') DEFAULT NULL,
  `tableName` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `locations`
--

CREATE TABLE `locations` (
  `userID` varchar(255) NOT NULL,
  `dataID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `timestampMs` bigint(20) NOT NULL,
  `latitudeE7` bigint(20) NOT NULL,
  `longitudeE7` bigint(20) NOT NULL,
  `velocity` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  `heading` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `logs`
--

CREATE TABLE `logs` (
  `userID` varchar(255) NOT NULL,
  `logDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `map_data`
--

CREATE TABLE `map_data` (
  `userID` varchar(255) NOT NULL,
  `dataID` int(11) NOT NULL,
  `uploadDate` datetime NOT NULL,
  `fileName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sub_activity`
--

CREATE TABLE `sub_activity` (
  `userID` varchar(255) NOT NULL,
  `dataID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `activityID` int(11) NOT NULL,
  `sub_activityID` int(11) NOT NULL,
  `activityType` enum('IN_VEHICLE','IN_RAIL_VEHICLE','IN_ROAD_VEHICLE','IN_TWO_WHEELER_VEHICLE','IN_FOUR_WHEELER_VEHICLE','IN_CAR','IN_BUS','ON_BICYCLE','ON_FOOT','RUNNING','STILL','TILTING','UNKNOWN','WALKING') DEFAULT 'UNKNOWN',
  `confidence` int(3) NOT NULL DEFAULT 0,
  `timestampMs` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `upload_num`
--

CREATE TABLE `upload_num` (
  `userID` varchar(255) NOT NULL,
  `data_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `userID` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `verified_user` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`userID`,`dataID`,`locationID`,`activityID`);

--
-- Ευρετήρια για πίνακα `eco`
--
ALTER TABLE `eco`
  ADD PRIMARY KEY (`userID`,`upload_date`);

--
-- Ευρετήρια για πίνακα `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`userID`,`dataID`,`locationID`);

--
-- Ευρετήρια για πίνακα `logs`
--
ALTER TABLE `logs`
  ADD KEY `usrlog` (`userID`);

--
-- Ευρετήρια για πίνακα `map_data`
--
ALTER TABLE `map_data`
  ADD PRIMARY KEY (`userID`,`dataID`);

--
-- Ευρετήρια για πίνακα `sub_activity`
--
ALTER TABLE `sub_activity`
  ADD PRIMARY KEY (`userID`,`dataID`,`locationID`,`activityID`,`sub_activityID`);

--
-- Ευρετήρια για πίνακα `upload_num`
--
ALTER TABLE `upload_num`
  ADD KEY `upInfo` (`userID`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `keytoloc` FOREIGN KEY (`userID`,`dataID`,`locationID`) REFERENCES `locations` (`userID`, `dataID`, `locationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `eco`
--
ALTER TABLE `eco`
  ADD CONSTRAINT `ecouser` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Περιορισμοί για πίνακα `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `usrIDtomapData` FOREIGN KEY (`userID`,`dataID`) REFERENCES `map_data` (`userID`, `dataID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `usrlog` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `map_data`
--
ALTER TABLE `map_data`
  ADD CONSTRAINT `usrdata` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `sub_activity`
--
ALTER TABLE `sub_activity`
  ADD CONSTRAINT `keytoActivity` FOREIGN KEY (`userID`,`dataID`,`locationID`,`activityID`) REFERENCES `activity` (`userID`, `dataID`, `locationID`, `activityID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `upload_num`
--
ALTER TABLE `upload_num`
  ADD CONSTRAINT `upInfo` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
