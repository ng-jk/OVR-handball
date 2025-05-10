-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 04:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ovrhandball`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventofficials`
--

CREATE TABLE `eventofficials` (
  `eventOfficialID` int(255) NOT NULL,
  `eventID` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventpartners`
--

CREATE TABLE `eventpartners` (
  `eventPartnerID` int(255) NOT NULL,
  `eventID` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `hyperlink` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventplayers`
--

CREATE TABLE `eventplayers` (
  `eventPlayerID` int(255) NOT NULL,
  `eventTeamID` int(255) DEFAULT NULL,
  `playerID` int(255) DEFAULT NULL,
  `jerseyCode` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `rank` int(255) DEFAULT NULL,
  `goal` int(255) DEFAULT NULL,
  `goalSaved` int(255) DEFAULT NULL,
  `yellowCard` int(255) DEFAULT NULL,
  `redCard` int(255) DEFAULT NULL,
  `blueCard` int(255) DEFAULT NULL,
  `2m1` int(255) DEFAULT NULL,
  `2m2` int(255) DEFAULT NULL,
  `2m3` int(255) DEFAULT NULL,
  `game` int(255) DEFAULT NULL,
  `play` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventID` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `series` int(255) DEFAULT NULL,
  `rules` varchar(255) DEFAULT NULL,
  `candidateNum` int(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `hall` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `age` int(255) DEFAULT NULL,
  `winner` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventteams`
--

CREATE TABLE `eventteams` (
  `eventTeamID` int(255) NOT NULL,
  `teamID` int(255) DEFAULT NULL,
  `eventID` int(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `seed` int(255) DEFAULT NULL,
  `point` int(255) DEFAULT NULL,
  `win` int(255) DEFAULT NULL,
  `tied` int(255) DEFAULT NULL,
  `lost` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `matchID` int(255) NOT NULL,
  `eventID` int(255) DEFAULT NULL,
  `hall` varchar(255) DEFAULT NULL,
  `dateTime` datetime DEFAULT NULL,
  `spectator` int(255) DEFAULT NULL,
  `matchNo` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `winner` int(255) DEFAULT NULL,
  `round` int(255) DEFAULT NULL,
  `halftimeStart` time DEFAULT '00:00:00',
  `halftimeEnd` time DEFAULT '00:00:00',
  `endOfGame` time DEFAULT '00:00:00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matchofficials`
--

CREATE TABLE `matchofficials` (
  `matchOfficialID` int(255) NOT NULL,
  `matchID` int(255) NOT NULL,
  `eventOfficialID` int(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matchplayers`
--

CREATE TABLE `matchplayers` (
  `matchPlayerID` int(255) NOT NULL,
  `matchTeamID` int(255) DEFAULT NULL,
  `eventPlayerID` int(255) DEFAULT NULL,
  `matchGoal` int(255) DEFAULT 0,
  `matchShot` int(255) DEFAULT 0,
  `matchSave` int(255) DEFAULT 0,
  `isStartingLineUp` tinyint(1) DEFAULT NULL,
  `totalPerformanceTime` time DEFAULT '00:00:00',
  `assist` int(255) DEFAULT 0,
  `passClearChance` int(255) DEFAULT 0,
  `recieve7m` int(255) DEFAULT 0,
  `commit7m` int(255) DEFAULT 0,
  `recieve2min` int(255) DEFAULT 0,
  `steal` int(255) DEFAULT 0,
  `block` int(255) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matchteams`
--

CREATE TABLE `matchteams` (
  `matchTeamID` int(255) NOT NULL,
  `eventTeamID` int(255) DEFAULT NULL,
  `matchID` int(255) DEFAULT NULL,
  `halftime` int(255) DEFAULT 0,
  `endOfPlaying` int(255) DEFAULT 0,
  `overtime1` int(255) DEFAULT 0,
  `overtime2` int(255) DEFAULT 0,
  `afterPenaltyThrow` int(255) DEFAULT 0,
  `teamTimeout1` time DEFAULT '00:00:00',
  `teamTimeout2` time DEFAULT '00:00:00',
  `teamTimeout3` time DEFAULT '00:00:00',
  `pointInMatch` int(255) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(567, '2025-03-15-021042', 'App\\Database\\Migrations\\CreateTeamTable', 'default', 'App', 1746796057, 1),
(568, '2025-03-15-021121', 'App\\Database\\Migrations\\CreatePlayerTable', 'default', 'App', 1746796057, 1),
(569, '2025-03-15-021146', 'App\\Database\\Migrations\\CreateTeamOfficialTable', 'default', 'App', 1746796057, 1),
(570, '2025-03-15-021247', 'App\\Database\\Migrations\\CreateEventTable', 'default', 'App', 1746796057, 1),
(571, '2025-03-15-021325', 'App\\Database\\Migrations\\CreateEventTeamTable', 'default', 'App', 1746796057, 1),
(572, '2025-03-15-021425', 'App\\Database\\Migrations\\CreateEventPlayer', 'default', 'App', 1746796057, 1),
(573, '2025-03-15-021443', 'App\\Database\\Migrations\\CreateMatchTable', 'default', 'App', 1746796057, 1),
(574, '2025-03-15-021508', 'App\\Database\\Migrations\\CreateMatchTeamTable', 'default', 'App', 1746796057, 1),
(575, '2025-03-15-021557', 'App\\Database\\Migrations\\CreateMatchPlayerTable', 'default', 'App', 1746796057, 1),
(576, '2025-03-15-021645', 'App\\Database\\Migrations\\CreatePenalityTable', 'default', 'App', 1746796057, 1),
(577, '2025-03-15-021703', 'App\\Database\\Migrations\\CreateSaveTable', 'default', 'App', 1746796057, 1),
(578, '2025-03-15-021721', 'App\\Database\\Migrations\\CreateShotTable', 'default', 'App', 1746796057, 1),
(579, '2025-03-15-021750', 'App\\Database\\Migrations\\CreateEventOfficialTable', 'default', 'App', 1746796057, 1),
(580, '2025-03-15-021815', 'App\\Database\\Migrations\\CreateMatchOfficial', 'default', 'App', 1746796057, 1),
(581, '2025-03-17-035241', 'App\\Database\\Migrations\\CreateEventPartnerTable', 'default', 'App', 1746796057, 1),
(582, '2025-03-17-064506', 'App\\Database\\Migrations\\CreateUserTable', 'default', 'App', 1746796057, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `penaltyID` int(255) NOT NULL,
  `matchPlayerID` int(255) DEFAULT NULL,
  `penaltyType` varchar(255) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `period` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playerID` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `teamID` int(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saves`
--

CREATE TABLE `saves` (
  `saveID` int(255) NOT NULL,
  `matchPlayerID` int(255) DEFAULT NULL,
  `isSaved` tinyint(1) DEFAULT NULL,
  `saveType` varchar(255) DEFAULT NULL,
  `period` int(10) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shots`
--

CREATE TABLE `shots` (
  `shotID` int(255) NOT NULL,
  `matchPlayerID` int(10) DEFAULT NULL,
  `shotType` varchar(255) DEFAULT NULL,
  `goalType` varchar(255) DEFAULT NULL,
  `destType` varchar(255) DEFAULT NULL,
  `throwPosition` varchar(255) DEFAULT NULL,
  `period` int(255) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `defenseNum` int(255) DEFAULT NULL,
  `attackNum` int(255) DEFAULT NULL,
  `goalkeeperID` int(255) DEFAULT NULL,
  `isGoalKeeperOut` tinyint(1) NOT NULL,
  `speed` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teamofficials`
--

CREATE TABLE `teamofficials` (
  `officialID` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `teamID` int(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `teamID` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `teamInfo` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `dateFounded` date DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`) VALUES
(1, 'tester', '$2y$10$HOPJfwkeQNKfzMQxQNUlYO6UnaJe3bcLxYDQt12WyY9jkMy4ZhJDu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eventofficials`
--
ALTER TABLE `eventofficials`
  ADD PRIMARY KEY (`eventOfficialID`),
  ADD KEY `eventOfficials_eventID_foreign` (`eventID`);

--
-- Indexes for table `eventpartners`
--
ALTER TABLE `eventpartners`
  ADD PRIMARY KEY (`eventPartnerID`),
  ADD KEY `eventPartners_eventID_foreign` (`eventID`);

--
-- Indexes for table `eventplayers`
--
ALTER TABLE `eventplayers`
  ADD PRIMARY KEY (`eventPlayerID`),
  ADD KEY `eventPlayers_eventTeamID_foreign` (`eventTeamID`),
  ADD KEY `eventPlayers_playerID_foreign` (`playerID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `eventteams`
--
ALTER TABLE `eventteams`
  ADD PRIMARY KEY (`eventTeamID`),
  ADD KEY `eventTeams_eventID_foreign` (`eventID`),
  ADD KEY `eventTeams_teamID_foreign` (`teamID`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`matchID`),
  ADD KEY `matches_eventID_foreign` (`eventID`);

--
-- Indexes for table `matchofficials`
--
ALTER TABLE `matchofficials`
  ADD PRIMARY KEY (`matchOfficialID`),
  ADD KEY `matchOfficials_matchID_foreign` (`matchID`),
  ADD KEY `matchOfficials_eventOfficialID_foreign` (`eventOfficialID`);

--
-- Indexes for table `matchplayers`
--
ALTER TABLE `matchplayers`
  ADD PRIMARY KEY (`matchPlayerID`),
  ADD KEY `matchPlayers_matchTeamID_foreign` (`matchTeamID`),
  ADD KEY `matchPlayers_eventPlayerID_foreign` (`eventPlayerID`);

--
-- Indexes for table `matchteams`
--
ALTER TABLE `matchteams`
  ADD PRIMARY KEY (`matchTeamID`),
  ADD KEY `matchTeams_matchID_foreign` (`matchID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`penaltyID`),
  ADD KEY `penalties_matchPlayerID_foreign` (`matchPlayerID`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`playerID`),
  ADD KEY `players_teamID_foreign` (`teamID`);

--
-- Indexes for table `saves`
--
ALTER TABLE `saves`
  ADD PRIMARY KEY (`saveID`),
  ADD KEY `saves_matchPlayerID_foreign` (`matchPlayerID`);

--
-- Indexes for table `shots`
--
ALTER TABLE `shots`
  ADD PRIMARY KEY (`shotID`),
  ADD KEY `shots_matchPlayerID_foreign` (`matchPlayerID`);

--
-- Indexes for table `teamofficials`
--
ALTER TABLE `teamofficials`
  ADD PRIMARY KEY (`officialID`),
  ADD KEY `teamOfficials_teamID_foreign` (`teamID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`teamID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eventofficials`
--
ALTER TABLE `eventofficials`
  MODIFY `eventOfficialID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventpartners`
--
ALTER TABLE `eventpartners`
  MODIFY `eventPartnerID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventplayers`
--
ALTER TABLE `eventplayers`
  MODIFY `eventPlayerID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventteams`
--
ALTER TABLE `eventteams`
  MODIFY `eventTeamID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `matchID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matchofficials`
--
ALTER TABLE `matchofficials`
  MODIFY `matchOfficialID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matchplayers`
--
ALTER TABLE `matchplayers`
  MODIFY `matchPlayerID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matchteams`
--
ALTER TABLE `matchteams`
  MODIFY `matchTeamID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=583;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `penaltyID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `playerID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saves`
--
ALTER TABLE `saves`
  MODIFY `saveID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shots`
--
ALTER TABLE `shots`
  MODIFY `shotID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teamofficials`
--
ALTER TABLE `teamofficials`
  MODIFY `officialID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `teamID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventofficials`
--
ALTER TABLE `eventofficials`
  ADD CONSTRAINT `eventOfficials_eventID_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `eventpartners`
--
ALTER TABLE `eventpartners`
  ADD CONSTRAINT `eventPartners_eventID_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `eventplayers`
--
ALTER TABLE `eventplayers`
  ADD CONSTRAINT `eventPlayers_eventTeamID_foreign` FOREIGN KEY (`eventTeamID`) REFERENCES `eventteams` (`eventTeamID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `eventPlayers_playerID_foreign` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `eventteams`
--
ALTER TABLE `eventteams`
  ADD CONSTRAINT `eventTeams_eventID_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `eventTeams_teamID_foreign` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_eventID_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `matchofficials`
--
ALTER TABLE `matchofficials`
  ADD CONSTRAINT `matchOfficials_eventOfficialID_foreign` FOREIGN KEY (`eventOfficialID`) REFERENCES `eventofficials` (`eventOfficialID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matchOfficials_matchID_foreign` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`) ON UPDATE CASCADE;

--
-- Constraints for table `matchplayers`
--
ALTER TABLE `matchplayers`
  ADD CONSTRAINT `matchPlayers_eventPlayerID_foreign` FOREIGN KEY (`eventPlayerID`) REFERENCES `eventplayers` (`eventPlayerID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matchPlayers_matchTeamID_foreign` FOREIGN KEY (`matchTeamID`) REFERENCES `matchteams` (`matchTeamID`) ON UPDATE CASCADE;

--
-- Constraints for table `matchteams`
--
ALTER TABLE `matchteams`
  ADD CONSTRAINT `matchTeams_matchID_foreign` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`) ON UPDATE CASCADE;

--
-- Constraints for table `penalties`
--
ALTER TABLE `penalties`
  ADD CONSTRAINT `penalties_matchPlayerID_foreign` FOREIGN KEY (`matchPlayerID`) REFERENCES `matchplayers` (`matchPlayerID`) ON UPDATE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_teamID_foreign` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `saves`
--
ALTER TABLE `saves`
  ADD CONSTRAINT `saves_matchPlayerID_foreign` FOREIGN KEY (`matchPlayerID`) REFERENCES `matchplayers` (`matchPlayerID`) ON UPDATE CASCADE;

--
-- Constraints for table `shots`
--
ALTER TABLE `shots`
  ADD CONSTRAINT `shots_matchPlayerID_foreign` FOREIGN KEY (`matchPlayerID`) REFERENCES `matchplayers` (`matchPlayerID`) ON UPDATE CASCADE;

--
-- Constraints for table `teamofficials`
--
ALTER TABLE `teamofficials`
  ADD CONSTRAINT `teamOfficials_teamID_foreign` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
