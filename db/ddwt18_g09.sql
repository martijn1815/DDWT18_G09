-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 02, 2019 at 04:41 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ddwt18_g09`
--
CREATE DATABASE IF NOT EXISTS `ddwt18_g09` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ddwt18_g09`;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `user_id` int(11) NOT NULL,
  `language` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opt_in`
--

CREATE TABLE `opt_in` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `message` varchar(256) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `size_m2` int(11) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `street` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(256) NOT NULL,
  `available_from` date NOT NULL,
  `available_till` date NOT NULL,
  `furnished` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `services_including` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `street` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `email` varchar(256) NOT NULL,
  `biography` text NOT NULL,
  `study/profession` varchar(256) NOT NULL,
  `date_of_birth` date NOT NULL,
  `role` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `opt_in`
--
ALTER TABLE `opt_in`
  ADD PRIMARY KEY (`id`,`tenant_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`,`owner_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `opt_in`
--
ALTER TABLE `opt_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `opt_in`
--
ALTER TABLE `opt_in`
  ADD CONSTRAINT `opt_in_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
