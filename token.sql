-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 26, 2023 at 10:43 AM
-- Server version: 10.11.2-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `token`
--
CREATE DATABASE IF NOT EXISTS `token` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `token`;

-- --------------------------------------------------------

--
-- Table structure for table `meter`
--

CREATE TABLE `meter` (
  `id` int(10) UNSIGNED NOT NULL,
  `meter_id` varchar(50) NOT NULL,
  `meter_type` varchar(10) NOT NULL DEFAULT 'pre-paid',
  `meter_number` varchar(20) NOT NULL,
  `current_token` int(11) NOT NULL DEFAULT 0,
  `last_token` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meter`
--

INSERT INTO `meter` (`id`, `meter_id`, `meter_type`, `meter_number`, `current_token`, `last_token`, `created_at`) VALUES
(2, '4d9c29c6-fad50d43-a642a8bc-9a85ab03', 'pre-paid', '14235220192', 0, '2023-03-13 17:46:12', '2023-03-13 17:46:12'),
(3, '30b08cd8-e8d49e5f-cbd2ea82-aae4d553', 'pre-paid', '14235220193', 0, '2023-03-14 11:29:07', '2023-03-14 11:29:07'),
(4, '5cea3031-1341561a-82f00c65-42cfc3fe', 'post-paid', '14235220194', 0, '2023-03-14 11:37:03', '2023-03-14 11:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `payment_channel`
--

CREATE TABLE `payment_channel` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_channel`
--

INSERT INTO `payment_channel` (`id`, `type`, `account_number`, `created_at`) VALUES
(1, 'pre-paid', '888880', '2023-03-13 17:39:21'),
(3, 'post-paid', '888888', '2023-03-13 17:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `meter_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `transaction_id`, `amount`, `user_id`, `meter_id`, `created_at`) VALUES
(1, '68672bfb-0de41b33-888e51ab-b5e5bac9', 100, 2, 2, '2023-03-26 10:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `full_name`, `email`, `phone_number`, `password`, `created_at`, `last_updated`) VALUES
(1, '68672bfb-0de41b33-888e51ab-b5e5bac9', 'WANDABI GIDEON', 'wandabi@gmail.com', '712881672', '$2y$10$YlYk07NkHt/QwQdZyGVFyuxq55qjOWibhQH0beG4DdIjx4WsN00Nq', '2023-03-13 17:48:00', '2023-03-13 17:48:25'),
(2, '94201df4-930302a0-7d368d49-1d1707ef', 'LLOYD TONY', 'lloyd@gmail.com', '712345678', '$2y$10$vgFtjgWYr/8RTX9bdGIYCuYpbv/vjhD3kN5z5s2VjBSwasXuWIGZW', '2023-03-14 12:02:29', '2023-03-14 12:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_meter`
--

CREATE TABLE `user_meter` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `meter_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_meter`
--

INSERT INTO `user_meter` (`id`, `user_id`, `meter_id`, `created_at`) VALUES
(1, 1, 2, '2023-03-13 17:46:12'),
(2, 1, 3, '2023-03-14 11:29:07'),
(3, 1, 4, '2023-03-14 11:37:03'),
(4, 2, 2, '2023-03-14 12:06:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meter`
--
ALTER TABLE `meter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meter_id` (`meter_id`);

--
-- Indexes for table `payment_channel`
--
ALTER TABLE `payment_channel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `fk_transaction_user` (`user_id`),
  ADD KEY `fk_transaction_meter` (`meter_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_meter`
--
ALTER TABLE `user_meter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_meter_user` (`user_id`),
  ADD KEY `fk_user_meter_meter` (`meter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meter`
--
ALTER TABLE `meter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_channel`
--
ALTER TABLE `payment_channel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_meter`
--
ALTER TABLE `user_meter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_transaction_meter` FOREIGN KEY (`meter_id`) REFERENCES `meter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_meter`
--
ALTER TABLE `user_meter`
  ADD CONSTRAINT `fk_user_meter_meter` FOREIGN KEY (`meter_id`) REFERENCES `meter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_meter_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
