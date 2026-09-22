-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 okt 2025 om 13:06
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clanbase`
--

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `competitions`
--

CREATE TABLE `competitions` (
  `competition_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('tournament','ladder') NOT NULL,
  `game` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `competitions`
--

INSERT INTO `competitions` (`competition_id`, `name`, `description`, `type`, `game`, `created_by`, `start_date`, `end_date`) VALUES
(1, 'Winter Showdown', 'Jaarlijkse wintercompetitie voor alle shooters.', 'tournament', 'Call of Duty', NULL, '2025-12-01', '2025-12-31'),
(2, 'Spring Cup', 'Seizoenscompetitie voor beginnende teams.', 'tournament', 'CS:GO', NULL, '2026-03-01', '2026-03-30'),
(3, 'Battlefield Bash', 'Competitie voor Battlefield fans', 'tournament', 'Battlefield', NULL, '2025-11-01', '2025-11-30'),
(4, 'Overwatch Open', 'Open toernooi voor Overwatch spelers', 'tournament', 'Overwatch', NULL, '2025-12-05', '2025-12-20'),
(5, 'R6 Siege Series', 'Rainbow Six Siege ladder', 'ladder', 'Rainbow Six Siege', NULL, '2026-01-01', '2026-03-01'),
(6, 'WoW Arena Cup', 'World of Warcraft arena competitie', 'tournament', 'World of Warcraft', NULL, '2026-02-01', '2026-02-28'),
(7, 'LoL Spring Clash', 'League of Legends toernooi', 'tournament', 'League of Legends', NULL, '2026-03-01', '2026-03-30'),
(8, 'Dota 2 Invitational', 'Dota 2 spelers ontmoeten elkaar', 'tournament', 'Dota 2', NULL, '2026-04-01', '2026-04-30'),
(9, 'Fortnite Frenzy', 'Fortnite competitie voor streamers', 'tournament', 'Fortnite', NULL, '2026-05-01', '2026-05-31'),
(10, 'Apex Legends Arena', 'Apex Legends ladder competitie', 'ladder', 'Apex Legends', NULL, '2026-06-01', '2026-06-30');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `forum_posts`
--

CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `thread_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 3, 'Gebruik altijd earphones om beter te horen waar de vijand is!', '2025-10-13 12:56:21'),
(2, 1, 6, 'Goede tip! En vergeet niet om de spray control te oefenen.', '2025-10-14 12:56:21'),
(3, 2, 4, 'League of Legends heeft een toxic community, maar ik blijf spelen 😅', '2025-10-15 12:56:21');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `forum_threads`
--

CREATE TABLE `forum_threads` (
  `thread_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `forum_threads`
--

INSERT INTO `forum_threads` (`thread_id`, `title`, `created_by`, `created_at`) VALUES
(1, 'Tips voor CS:GO beginners', 6, '2025-10-12 12:56:10'),
(2, 'Welke game heeft de beste community?', 4, '2025-10-14 12:56:10');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `friends`
--

CREATE TABLE `friends` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `friends`
--

INSERT INTO `friends` (`user_id`, `friend_id`, `status`, `created_at`) VALUES
(1, 8, 'accepted', '2025-10-13 12:00:00'),
(2, 3, 'rejected', '2025-10-14 09:40:00'),
(3, 4, 'accepted', '2025-10-10 14:22:00'),
(4, 7, 'accepted', '2025-10-11 15:10:00'),
(5, 3, 'accepted', '2025-10-16 16:55:00'),
(6, 3, 'pending', '2025-10-12 18:30:00'),
(7, 8, 'pending', '2025-10-15 10:20:00');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `matches`
--

CREATE TABLE `matches` (
  `match_id` int(11) NOT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `team1_id` int(11) DEFAULT NULL,
  `team2_id` int(11) DEFAULT NULL,
  `user1_id` int(11) DEFAULT NULL,
  `user2_id` int(11) DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `played_at` datetime DEFAULT NULL,
  `status` enum('scheduled','completed','confirmed') DEFAULT 'scheduled',
  `winner_team_id` int(11) DEFAULT NULL,
  `winner_user_id` int(11) DEFAULT NULL,
  `score_team1` int(11) DEFAULT 0,
  `score_team2` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `matches`
--

INSERT INTO `matches` (`match_id`, `competition_id`, `team1_id`, `team2_id`, `user1_id`, `user2_id`, `scheduled_at`, `played_at`, `status`, `winner_team_id`, `winner_user_id`, `score_team1`, `score_team2`) VALUES
(1, 1, 1, 2, NULL, NULL, '2025-12-05 18:00:00', '2025-12-05 19:30:00', 'completed', 1, NULL, 16, 12),
(2, 3, 3, 1, NULL, NULL, '2025-11-03 20:00:00', '2025-11-03 21:10:00', 'completed', 3, NULL, 13, 9),
(3, 5, 2, 3, NULL, NULL, '2026-01-05 17:00:00', NULL, 'scheduled', NULL, NULL, 0, 0),
(4, 9, NULL, NULL, 7, 6, '2026-05-03 18:00:00', NULL, 'scheduled', NULL, NULL, 0, 0);

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `content`, `sent_at`) VALUES
(1, 3, 4, 'Hey, wil je een scrim plannen voor morgen?', '2025-10-17 10:56:42'),
(2, 4, 3, 'Ja, laten we 19:00 doen!', '2025-10-17 11:56:42');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`team_id`, `name`, `description`, `created_by`) VALUES
(1, 'Team Alpha', 'Elite FPS gamers', 3),
(2, 'The Valkyries', 'All-female eSports team', 4),
(3, 'Shadow Clan', 'Hardcore MOBA players', 8);

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `team_members`
--

CREATE TABLE `team_members` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('leader','member') DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `team_members`
--

INSERT INTO `team_members` (`team_id`, `user_id`, `role`) VALUES
(1, 3, 'leader'),
(1, 6, 'member'),
(2, 4, 'leader'),
(2, 7, 'member'),
(3, 1, 'member'),
(3, 8, 'leader');

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `game_preferences` text DEFAULT NULL,
  `role` enum('player','admin') DEFAULT 'player'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `name`, `birth_date`, `game_preferences`, `role`) VALUES
(1, 'admin', 'qwerty@gmail.com', '$2y$10$0U/a9SdjELpQzIYyneNj1.zv6MZT0WXWZHPeP6lb0tPPw0o/47gli', 'kelly', '2001-07-28', '', 'admin'),
(2, 'adbi', 'qwertyuio@gmail.com', '$2y$10$0U/a9SdjELpQzIYyneNj1.zv6MZT0WXWZHPeP6lb0tPPw0o/47gli', 'adbi\r\n', '2000-11-22', 'CS:GO,Call of Duty,Battlefield,Overwatch,Rainbow Six Siege,World of Warcraft,League of Legends,Dota 2,Fortnite,Apex Legends', 'player'),
(3, 'shadowfox', 'shadow@gmail.com', '$2y$10$randomhash1', 'Liam Vries', '2002-04-12', 'Call of Duty,CS:GO,Battlefield', 'player'),
(4, 'valkyrie', 'valkyrie@gmail.com', '$2y$10$randomhash2', 'Nora Janssen', '1999-09-09', 'Overwatch,League of Legends,Dota 2', 'player'),
(5, 'adminmaster', 'admin@gmail.com', '$2y$10$randomhash3', 'Admin Master', '1990-01-01', NULL, 'admin'),
(6, 'sn1per', 'sniper@gmail.com', '$2y$10$randomhash4', 'Rik Smits', '2003-02-22', 'CS:GO,Call of Duty', 'player'),
(7, 'storm', 'storm@gmail.com', '$2y$10$randomhash5', 'Tessa Storm', '2001-11-03', 'Fortnite,Apex Legends', 'player'),
(8, 'dragonx', 'dragonx@gmail.com', '$2y$10$randomhash6', 'Kai de Groot', '2004-06-14', 'Dota 2,League of Legends', 'player');

-- --------------------------------------------------------
-- Indexen en constraints blijven hetzelfde zoals eerder

-- --------------------------------------------------------
-- Tabel voor spelersstatistieken
--

CREATE TABLE `user_statistics` (
    `user_id` int(11) NOT NULL,
    `matches_played` int(11) NOT NULL DEFAULT 0,
    `matches_won` int(11) NOT NULL DEFAULT 0,
    `matches_lost` int(11) NOT NULL DEFAULT 0,
    `total_score` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Trigger om statistics bij te werken bij een nieuwe match
--

DELIMITER //
CREATE TRIGGER `after_match_update_statistics`
AFTER UPDATE ON `matches`
FOR EACH ROW
BEGIN
    IF NEW.status = 'completed' THEN
        -- Update team players
        IF NEW.user1_id IS NOT NULL THEN
            INSERT INTO user_statistics (user_id, matches_played, matches_won, matches_lost, total_score)
            VALUES (NEW.user1_id, 1, IF(NEW.winner_user_id = NEW.user1_id, 1, 0), IF(NEW.winner_user_id = NEW.user1_id, 0, 1), NEW.score_team1)
            ON DUPLICATE KEY UPDATE 
                matches_played = matches_played + 1,
                matches_won = matches_won + IF(NEW.winner_user_id = NEW.user1_id, 1, 0),
                matches_lost = matches_lost + IF(NEW.winner_user_id = NEW.user1_id, 0, 1),
                total_score = total_score + NEW.score_team1;
        END IF;

        IF NEW.user2_id IS NOT NULL THEN
            INSERT INTO user_statistics (user_id, matches_played, matches_won, matches_lost, total_score)
            VALUES (NEW.user2_id, 1, IF(NEW.winner_user_id = NEW.user2_id, 1, 0), IF(NEW.winner_user_id = NEW.user2_id, 0, 1), NEW.score_team2)
            ON DUPLICATE KEY UPDATE 
                matches_played = matches_played + 1,
                matches_won = matches_won + IF(NEW.winner_user_id = NEW.user2_id, 1, 0),
                matches_lost = matches_lost + IF(NEW.winner_user_id = NEW.user2_id, 0, 1),
                total_score = total_score + NEW.score_team2;
        END IF;
    END IF;
END;
//
DELIMITER ;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
