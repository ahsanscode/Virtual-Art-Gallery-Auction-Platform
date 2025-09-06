-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2025 at 11:10 AM
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
-- Database: `virtual_art_gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `status` enum('available','in_auction','sold') NOT NULL DEFAULT 'available',
  `starting_price` decimal(10,2) NOT NULL,
  `current_bid` decimal(10,2) DEFAULT NULL,
  `auction_start_time` datetime NOT NULL,
  `auction_end_time` datetime NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `final_sale_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('artist','buyer') DEFAULT 'buyer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `is_deleted`) VALUES
(6, 'AHSAN ULLAH', 'ahsanscode@gmail.com', '$2y$10$44NzkBiiRcOC/DWsaGQC4OtptDuUlnHd/0TgE9/GndkDSOZn5THBO', 'artist', '2025-09-05 11:07:56', 0),
(10, 'AHSAN ULLAHx', 'example@gmail.com', '$2y$10$O1lyfo3WHKLf3kythJRSgOQmMvrIIhvi5EI.zn1BHMTx9HHeRLZcK', 'buyer', '2025-09-05 19:52:35', 0),
(12, 'AHSAN ULLAH', 'ahsanscodex@gmail.com', '$2y$10$AEHXhg5i38P.w16V9pg5EO3euRrGj8UY83DTbIfsuyJqHouLATxni', 'buyer', '2025-09-05 20:54:10', 0),
(13, 'AHSAN ULLAH', 'repiliy790@marchub.com', '$2y$10$ZZWgY1Szpefoe7YgrR6vau35m/zskhmPL/A1trYiidj3WSob77hrW', 'artist', '2025-09-05 20:54:56', 0),
(14, 'AHSAN ULLAH', 'ahsan.ullah@g.bracu.ac.bd', '$2y$10$adXJRbgtDN1.IW9w.cmmwOEf1rDS4kHMy7B0n9QqhD6MQn9TslXvu', 'buyer', '2025-09-05 21:01:35', 0),
(15, 'AHSAN ULLAH', 'sdsds@gmail.com', '$2y$10$hCVGpVB.cuFBw0FuzrC5bugnFNX6o0vfevKy.WkzMIkcoFD.jMVTu', 'artist', '2025-09-05 21:19:36', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `buyer_id` (`buyer_id`);

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
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artworks`
--
ALTER TABLE `artworks`
  ADD CONSTRAINT `artworks_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `artworks_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
