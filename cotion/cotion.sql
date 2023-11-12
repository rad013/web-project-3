-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 08:41 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cotion`
--

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `leader_name` varchar(255) NOT NULL,
  `leader_gender` enum('Male','Female','Other') NOT NULL,
  `leader_dob` date NOT NULL,
  `leader_phone_number` varchar(20) NOT NULL,
  `leader_address` text NOT NULL,
  `leader_institution` varchar(255) NOT NULL,
  `competition_branch` enum('UI/UX','IT-Case') NOT NULL,
  `leader_id_card` varchar(255) NOT NULL,
  `member1_name` varchar(255) DEFAULT NULL,
  `member1_gender` enum('Male','Female','Other') DEFAULT NULL,
  `member1_dob` date DEFAULT NULL,
  `member1_phone_number` varchar(20) DEFAULT NULL,
  `member1_address` text DEFAULT NULL,
  `member1_institution` varchar(255) DEFAULT NULL,
  `member1_email` varchar(255) DEFAULT NULL,
  `member1_id_card` varchar(255) DEFAULT NULL,
  `member2_name` varchar(255) DEFAULT NULL,
  `member2_gender` enum('Male','Female','Other') DEFAULT NULL,
  `member2_dob` date DEFAULT NULL,
  `member2_phone_number` varchar(20) DEFAULT NULL,
  `member2_address` text DEFAULT NULL,
  `member2_institution` varchar(255) DEFAULT NULL,
  `member2_email` varchar(255) DEFAULT NULL,
  `member2_id_card` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
