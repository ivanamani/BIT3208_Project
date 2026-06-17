-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 09:36 PM
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
-- Database: `sea_of_games_week6`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_at`, `image`) VALUES
(1, 'Saints Row 3', 'Saints Row: The Third is an open-world action-adventure game developed by Volition and published by THQ. Players take control of the leader of the Saints gang as they expand their influence in the city of Steelport while battling rival gangs and a powerful organization known as the Syndicate. The game is known for its over-the-top action, extensive character customization, humorous storyline, and a wide variety of vehicles, weapons, and activities that encourage chaotic and creative gameplay.', 2000.00, 69, '2026-06-04 06:35:07', 'saints_row.png'),
(2, 'Batman Arkham Asylum', 'Batman: Arkham Asylum is an action-adventure game where players take on the role of Batman as he battles the Joker and other notorious villains after a takeover of Arkham Asylum. The game combines combat, stealth, detective gameplay, and exploration within a dark and immersive setting inspired by the Batman universe.', 900.00, 87, '2026-06-04 07:21:14', 'batman.png'),
(3, 'Need For Speed:Most Wanted (2005)', '*Need for Speed: Most Wanted (2005)* is an open-world racing game developed by EA Black Box and published by [Electronic Arts](https://www.ea.com?utm_source=chatgpt.com). Players take on the role of a street racer who must climb the infamous Blacklist, a ranking of the city\'s top racers, to reclaim a stolen car and earn respect. The game combines intense arcade-style racing, extensive vehicle customization, and high-speed police pursuits. Set in the fictional city of Rockport, it features a variety of race modes, challenging opponents, and a memorable story, making it one of the most popular entries in the *Need for Speed* series.', 70.00, 78, '2026-06-17 16:49:51', 'NFS.png'),
(4, 'GTA FIVE', 'Grand Theft Auto V is an open-world action-adventure game developed by Rockstar North and published by Rockstar Games. Set in the fictional state of San Andreas, the game follows three protagonists—Michael De Santa, Franklin Clinton, and Trevor Philips—as they navigate crime, heists, and personal conflicts. Players can explore the vast city of Los Santos and its surrounding countryside, taking part in missions, side activities, racing, and online multiplayer. Its detailed world, engaging story, and freedom of gameplay have made it one of the best-selling video games of all time.', 100.00, 100, '2026-06-17 19:24:24', 'GTA5.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'Admin_P123'),
(2, 'Ivan Amani', 'ivanamani@gmail.com\r\n', '12345678'),
(3, 'Eunice', 'eunice@gmail.com', 'EuniceBinLaden123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
