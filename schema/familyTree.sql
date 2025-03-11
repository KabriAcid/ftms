-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ftms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `family_id`, `event_title`, `event_description`, `event_date`, `event_time`, `created_at`) VALUES
(2, 1, 'Voluptatem Laudanti', 'Sapiente temporibus', '2005-05-24', '07:17:00', '2025-03-10 04:27:07'),
(3, 0, 'Ad tempora dignissim', 'Est adipisci in plac', '2014-09-20', '03:51:00', '2025-03-10 06:46:33'),
(4, 4, 'Eos et possimus ad', 'Dolor libero quia et', '2019-11-05', '05:28:00', '2025-03-10 10:46:47'),
(5, 4, 'Quidem et ut et pari', 'Illo Nam expedita no', '1988-07-29', '18:29:00', '2025-03-10 10:48:46'),
(6, 1, 'Aute corrupti expli', 'Dolor ea tempor eos', '1996-08-14', '11:21:00', '2025-03-11 15:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` int(11) NOT NULL,
  `family_code` varchar(50) NOT NULL,
  `family_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `family_code`, `family_name`, `created_at`) VALUES
(1, 'ARAB-2868', 'Arab', '2025-03-11 15:16:54'),
(2, 'KABR-6046', 'Kabri', '2025-03-11 15:48:22'),
(3, 'ABDU-5093', 'Abdullahi', '2025-03-11 15:50:58'),
(4, 'ABDU-7595', 'Abdullahi', '2025-03-11 15:54:18'),
(5, 'KABR-2649', 'Kabri', '2025-03-11 16:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `family_code` varchar(9) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `relationship` enum('Father','Mother','Son','Daughter','Brother','Sister','Uncle','Aunt','Nephew','Niece','Cousin') NOT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'N/A',
  `role` enum('Admin','User') NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/user.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `family_id`, `family_code`, `first_name`, `last_name`, `gender`, `relationship`, `birth_date`, `email`, `password`, `phone`, `address`, `role`, `profile_picture`, `created_at`, `status`) VALUES
(1, 1, 'ARAB-2868', 'Leslie', 'Stafford', 'Male', 'Sister', '1977-03-17', 'wucuke@mailinator.com', '$2y$10$wFq4jv2qWruO/bg8./PGge3YAPYIfoPoxPHtwCozuyxDLVeMei4GO', '08071383906', 'At perspiciatis quo', 'Admin', 'uploads/67d054609a541.jpg', '2025-03-11 15:17:58', 1),
(6, 4, 'ABDU-7595', 'Abdullahi', 'Kabri', 'Male', 'Father', '2014-06-03', 'kabriacid01@gmail.com', '$2y$10$1cv.S9xcbZScgUco8ezdde1vBP8OruHAA8hIBnJ526VUR5964Ni/u', '07037943396', 'Inec Office, Sabon Gari Jalingo,', 'Admin', 'uploads/67d05df899368.jpg', '2025-03-11 15:59:26', 1),
(7, 4, 'ABDU-7595', 'Herman', 'Kirby', 'Female', 'Nephew', '2025-01-23', 'kove@mailinator.com', '$2y$10$PwV7AbPeslCk7oUELKkMpeHheK33opP3QlqnaYRKF36yGwuCPwHOu', '08073748292', 'Ducimus numquam fug', 'User', 'uploads/user.png', '2025-03-11 16:00:05', 0),
(8, 4, 'ABDU-7595', 'Owen', 'Carter', 'Female', 'Aunt', '1993-01-15', 'qyrytaha@mailinator.com', '$2y$10$45UcnV3/LWcNweP/Z9ByJuZXTUujyWP0o7XR9G02HNw9lT2wlLxx6', '08045149268', 'Similique labore vol', 'User', 'uploads/user.png', '2025-03-11 16:01:08', 1),
(9, 4, 'ABDU-7595', 'Maris', 'Downs', 'Male', 'Father', '1983-10-30', 'qybibico@mailinator.com', '$2y$10$2nIMRO0nAi4LeQEiKkPCYOOGkz0ockzFKdG5MZaQjIHIGjeFvJzSC', '08036424651', 'In do id et autem c', 'User', 'uploads/user.png', '2025-03-11 16:01:56', 1),
(10, 5, 'KABR-2649', 'Chantale', 'Gardner', 'Male', 'Mother', '1983-06-07', 'wycasavori@mailinator.com', '$2y$10$DLCdvg2.4SdOPlXXyJD93.FOWv2aCDHZmcFyN1lxCi2fEIQrpAPFa', '08016223418', 'Elit expedita corru', 'Admin', 'uploads/user.png', '2025-03-11 16:04:50', 1),
(11, 5, 'KABR-2649', 'Hannah', 'Norton', 'Male', 'Nephew', '2006-11-10', 'jyxas@mailinator.com', '$2y$10$0icGE.DlkEDq2997C.mLoOKZqbHSBCTctZW1KJJlAGaUS8WN.Gz86', '08075823306', 'Tempora aspernatur d', 'User', 'uploads/user.png', '2025-03-11 16:06:02', 1),
(12, 5, 'KABR-2649', 'Ivan', 'Leach', 'Female', 'Aunt', '1981-01-31', 'zodyjuly@mailinator.com', '$2y$10$.NMflrOpIvxf0bxmaA/bHuC9Xp6kAgwl9FbLCzklXNF9E16BV2Nai', '08004974858', 'Ut occaecat dolorum ', 'User', 'uploads/user.png', '2025-03-11 16:06:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `related_member_id` int(11) NOT NULL,
  `relationship` enum('Parent','Child','Spouse') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`id`, `member_id`, `related_member_id`, `relationship`, `created_at`) VALUES
(1, 1, 2, 'Child', '2025-03-05 13:02:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `family_code` (`family_code`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
