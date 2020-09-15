-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 16 Σεπ 2020 στις 01:22:18
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
  `timestampMs` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Δείκτες `activity`
--
DELIMITER $$
CREATE TRIGGER `activity_trigger` BEFORE INSERT ON `activity` FOR EACH ROW BEGIN
DECLARE max_DataID INT;
DECLARE max_locationID INT;
DECLARE max_activityID INT;
DECLARE condt INT;
SELECT MAX(dataID) INTO max_DataID FROM locations
WHERE userID =NEW.userID ;
SET NEW.dataID=max_DataID;
SELECT MAX(locationID) INTO max_locationID FROM locations
WHERE userID =NEW.userID AND dataID=NEW.dataID;
SET NEW.locationID=max_locationID;
SELECT COUNT(*) INTO condt FROM activity WHERE userID =NEW.userID AND dataID=NEW.dataID AND locationID=NEW.locationID;
SET max_activityID=0;
IF(condt>0) THEN
SELECT MAX(activityID) INTO max_activityID FROM activity
WHERE userID =NEW.userID AND dataID=NEW.dataID AND locationID=NEW.locationID;
SET NEW.activityID=max_activityID+1;
ELSE
SET NEW.activityID=1;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `eco`
--

CREATE TABLE `eco` (
  `userID` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `ecoscore` int(3) DEFAULT 0,
  `eco_num` int(11) DEFAULT 0,
  `act_num` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `locations`
--

CREATE TABLE `locations` (
  `userID` varchar(255) NOT NULL,
  `dataID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `timestampMs` datetime NOT NULL,
  `latitude` double(25,20) NOT NULL,
  `longitude` double(25,20) NOT NULL,
  `velocity` int(11) DEFAULT 0,
  `accuracy` int(11) DEFAULT 0,
  `heading` int(11) DEFAULT 0,
  `altitude` int(11) DEFAULT 0,
  `verticalAccuracy` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Δείκτες `locations`
--
DELIMITER $$
CREATE TRIGGER `locations_trigger` BEFORE INSERT ON `locations` FOR EACH ROW BEGIN
DECLARE max_DataID INT;
DECLARE max_locationID INT;
DECLARE condt INT;
SELECT MAX(dataID) INTO max_DataID FROM map_data
WHERE userID =NEW.userID ;
SET NEW.dataID=max_DataID;
SELECT COUNT(*) INTO condt FROM locations WHERE userID =NEW.userID AND dataID=NEW.dataID ;
SET max_locationID=0;
IF(condt>0) THEN
SELECT MAX(locationID) INTO max_locationID FROM locations
WHERE userID =NEW.userID AND dataID=NEW.dataID ;
SET NEW.locationID=max_locationID+1;
ELSE
SET NEW.locationID=1;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `logs`
--

CREATE TABLE `logs` (
  `userID` varchar(255) NOT NULL,
  `logDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `logs`
--

INSERT INTO `logs` (`userID`, `logDate`) VALUES
('MicLgAvKdOUgqG/vi9EbCxna9F1dgfINGVuu4vX8f90=', '2020-08-31 22:10:59'),
('MicLgAvKdOUgqG/vi9EbCxna9F1dgfINGVuu4vX8f90=', '2020-08-31 22:26:51'),
('MicLgAvKdOUgqG/vi9EbCxna9F1dgfINGVuu4vX8f90=', '2020-09-02 17:45:52'),
('MicLgAvKdOUgqG/vi9EbCxna9F1dgfINGVuu4vX8f90=', '2020-09-04 14:59:50'),
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', '2020-09-15 03:26:56'),
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', '2020-09-15 03:46:02'),
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', '2020-09-15 15:47:48'),
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', '2020-09-15 17:19:33'),
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', '2020-09-15 18:11:23'),
('ffhaNzwEFkJQV9ievOEevvlNCbaAjYdamj2Yc4tPriA=', '2020-09-16 00:32:51'),
('ffhaNzwEFkJQV9ievOEevvlNCbaAjYdamj2Yc4tPriA=', '2020-09-16 00:34:02');

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

--
-- Δείκτες `map_data`
--
DELIMITER $$
CREATE TRIGGER `map_data_trigger` BEFORE INSERT ON `map_data` FOR EACH ROW BEGIN
DECLARE max_DataID INT;
DECLARE condt INT;
SELECT COUNT(*) INTO condt FROM map_data WHERE userID =NEW.userID ;
SET max_DataID=0;
IF(condt>0) THEN
SELECT MAX(dataID) INTO max_DataID FROM map_data
WHERE userID =NEW.userID ;
SET NEW.dataID=max_DataID+1;
ELSE
SET NEW.dataID=1;
END IF;
END
$$
DELIMITER ;

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
  `activityType` enum('IN_VEHICLE','EXITING_VEHICLE','IN_RAIL_VEHICLE','IN_ROAD_VEHICLE','IN_TWO_WHEELER_VEHICLE','IN_FOUR_WHEELER_VEHICLE','IN_CAR','IN_BUS','ON_BICYCLE','ON_FOOT','RUNNING','STILL','TILTING','UNKNOWN','WALKING') DEFAULT 'UNKNOWN',
  `confidence` int(3) NOT NULL DEFAULT 0,
  `timestampMs` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Δείκτες `sub_activity`
--
DELIMITER $$
CREATE TRIGGER `eco_sub_activity_trigger` AFTER INSERT ON `sub_activity` FOR EACH ROW BEGIN
DECLARE act_sum INT(11);
DECLARE eco_act_sum INT(11);
DECLARE act_type ENUM('IN_VEHICLE','EXITING_VEHICLE','IN_RAIL_VEHICLE','IN_ROAD_VEHICLE','IN_TWO_WHEELER_VEHICLE','IN_FOUR_WHEELER_VEHICLE','IN_CAR','IN_BUS','ON_BICYCLE','ON_FOOT','RUNNING','STILL','TILTING','UNKNOWN','WALKING');
DECLARE Y_M_temp VARCHAR(255);
DECLARE date_temp VARCHAR(255);
DECLARE condt INT(1);
DECLARE date_sum DATE;
SELECT NEW.activityType INTO act_type;
SELECT DATE_FORMAT(NEW.timestampMs, '%Y-%m') INTO Y_M_temp;
SELECT CONCAT(Y_M_temp, '-01') INTO date_temp;
SELECT STR_TO_DATE(date_temp,'%Y-%m-%d') INTO date_sum;
SELECT COUNT(*) INTO condt FROM eco WHERE userID =NEW.userID AND activity_date =date_sum;
IF(condt>0) THEN
SELECT eco_num INTO eco_act_sum FROM eco WHERE userID =NEW.userID AND activity_date =date_sum;
SELECT act_num INTO act_sum FROM eco WHERE userID =NEW.userID AND activity_date =date_sum;
UPDATE eco SET ecoscore=((eco_act_sum/(act_sum+1))*100), act_num=act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
IF (act_type LIKE "IN_RAIL%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "IN_BUS%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "ON BICYCLE%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "ON_FOOT%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "RUNNING%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "STILL%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "WALKING%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
ELSEIF (act_type LIKE "EXITING_VEHICLE%") THEN
UPDATE eco SET ecoscore=(((eco_act_sum+1)/(act_sum+1))*100), eco_num=eco_act_sum+1 WHERE userID =NEW.userID AND activity_date =date_sum;
END IF;
ELSE
IF (act_type LIKE "IN_RAIL%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "IN_BUS%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "ON BICYCLE%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "ON_FOOT%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "RUNNING%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "STILL%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "WALKING%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSEIF (act_type LIKE "EXITING_VEHICLE%") THEN
INSERT INTO eco VALUES(NEW.userID, date_sum, 100, 1, 1);
ELSE
INSERT INTO eco VALUES(NEW.userID, date_sum, 0, 0, 1);
END IF;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sub_activity_trigger` BEFORE INSERT ON `sub_activity` FOR EACH ROW BEGIN
DECLARE max_DataID INT;
DECLARE max_locationID INT;
DECLARE max_activityID INT;
DECLARE max_sub_activityID INT;
DECLARE condt INT;
SELECT MAX(dataID) INTO max_DataID FROM activity
WHERE userID =NEW.userID ;
SET NEW.dataID=max_DataID;
SELECT MAX(locationID) INTO max_locationID FROM activity
WHERE userID = NEW.userID AND dataID = NEW.dataID ;
SET NEW.locationID=max_locationID;
SELECT MAX(activityID) INTO max_activityID FROM activity
WHERE userID =NEW.userID AND dataID = NEW.dataID AND locationID = NEW.locationID;
SET NEW.activityID=max_activityID;
SELECT COUNT(*) INTO condt FROM sub_activity WHERE userID =NEW.userID AND dataID=NEW.dataID AND locationID=NEW.locationID AND activityID=NEW.activityID ;
SET max_sub_activityID=0;
IF(condt>0) THEN
SELECT MAX(sub_activityID) INTO max_sub_activityID FROM sub_activity
WHERE userID =NEW.userID AND dataID=NEW.dataID AND locationID=NEW.locationID AND activityID=NEW.activityID ;
SET NEW.sub_activityID=max_sub_activityID+1;
ELSE
SET NEW.sub_activityID=1;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `userID` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `iv` varbinary(8000) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `verified_user` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`userID`, `username`, `fname`, `lname`, `password`, `iv`, `email`, `token`, `reg_date`, `role`, `verified_user`) VALUES
('+vPIA44j9UWmyvweHczZ1gXOx1gouUjda6T8QCl52Ps=', 'panos', 'panagiotis', 'stauropoulos', '$2y$10$1QfJ/SSmOLicJrlXTMN9cOmcaouJD6Ujp/fhHCie9Qium1dt26vPu', 0xb1bbae38608e58ba7d6e67cc2d9b17be, 'stauropan@gmail.com', 'ebc098f8af0d218094a3e437925cbdd79340ecd7b63c9692c6a27c543da283b7fca730961234fdea1e09d0e9428f69bb9241', '2020-09-02 20:17:49', 'user', 'yes'),
('ffhaNzwEFkJQV9ievOEevvlNCbaAjYdamj2Yc4tPriA=', 'vazaios', 'Stelios', 'Vazaios', '$2y$10$jTJeKJEbsOlK4VXHWZ1IP.eoPjZsyC2pwvXL5MvU6HEWkFoaNGGdS', 0xa591f4981e13dc59f82dec4cac40f5e9, 'sveagle555@gmail.com', '672de0f10a90bcc5b32e1e4e5163ca153fede1611c2afc87259f5074655c0bf34ebbc164af08281129bb480e4cb2870fbe2a', '2020-09-16 00:32:31', 'user', 'yes'),
('MicLgAvKdOUgqG/vi9EbCxna9F1dgfINGVuu4vX8f90=', 'admin', 'Stelios', 'Vazaios', '$2y$10$K9yzlYA7dmQTTR8KY0kUVOz2cj7hppjy8ghpM/jOxDNYcWkrT8AHa', 0xbf4b396223b7c34cd0ed0b06c051ac5c, 'vazeagle@gmail.com', '3ae8bf7ecb32a627e63ca9cfcc1947ee0a372aa23883063377ca90c43ad5c4e26f7431118a7a510deec0214ae111cbd87b0b', '2020-08-31 22:08:17', 'admin', 'yes');

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
  ADD PRIMARY KEY (`userID`,`activity_date`);

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
  ADD CONSTRAINT `eco_to_map` FOREIGN KEY (`userID`) REFERENCES `map_data` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
