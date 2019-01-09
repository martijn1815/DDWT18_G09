-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 09, 2019 at 04:46 PM
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

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`user_id`, `language`) VALUES
(5, 'dutch'),
(5, 'english'),
(5, 'french'),
(6, 'dutch'),
(6, 'english'),
(7, 'dutch'),
(7, 'english'),
(9, 'dutch'),
(10, 'dutch'),
(11, 'dutch'),
(11, 'english'),
(12, 'dutch'),
(12, 'english'),
(12, 'german'),
(13, 'dutch'),
(13, 'english');

-- --------------------------------------------------------

--
-- Table structure for table `opt_in`
--

CREATE TABLE `opt_in` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `message` varchar(256) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `opt_in`
--

INSERT INTO `opt_in` (`id`, `tenant_id`, `owner_id`, `room_id`, `message`, `date`) VALUES
(11, 12, 13, 12, 'Hallo sir, \r\nI would like to rent this room.', '2019-01-09');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `room_title` varchar(256) NOT NULL,
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

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `owner_id`, `room_title`, `size_m2`, `zip`, `street`, `city`, `description`, `type`, `available_from`, `available_till`, `furnished`, `price`, `services_including`) VALUES
(12, 13, 'Room in Groningen', 21, '9713WD', 'Tjerk Bolhuisstraat 5', 'Groningen', 'A perfect room for a university student.', 'studenthouse', '2019-09-01', '2020-08-31', 'no', 350, 'yes');

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
  `phone_number` int(15) NOT NULL,
  `email` varchar(256) NOT NULL,
  `biography` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `role` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `profession` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `zip`, `street`, `city`, `phone_number`, `email`, `biography`, `date_of_birth`, `role`, `gender`, `profession`) VALUES
(12, 'John Jansen', '$2y$10$aqxHBLTGCzsqr3q5yc4n5OPX8EHaW97XVcNK7kHXLjZomxn8EkCpi', 'John', 'Jansen', '9714Bp', 'Eyssoniusstraat 3', 'Groningen', 612345678, 'John.jansen@example.com', 'My hobbies are swimming, reading and traveling.', '1995-07-06', 'tenant', 'male', 'Bedrijfskunde'),
(13, 'Ronald510', '$2y$10$aRrj1amfoBho4JF1z3qLe.3r94YYXhkIqxOXkmfeNJ5xu3M8EO7d.', 'Ronald', 'stoffers', '9731CD', 'P. Waijerstraat 53', 'groningen', 612345678, 'stoffers1903@example.com', 'I am searching for a good student for my room.', '1975-01-23', 'owner', 'male', 'visser');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `opt_in`
--
ALTER TABLE `opt_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `room_id` (`room_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `opt_in`
--
ALTER TABLE `opt_in`
  ADD CONSTRAINT `opt_in_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `opt_in_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
