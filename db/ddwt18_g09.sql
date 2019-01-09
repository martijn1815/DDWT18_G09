-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 09, 2019 at 12:00 AM
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
(7, 'english');

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
(2, 5, 'test', 15, '0000aa', 'test 1', 'test', 'test', 'studenthouse', '2019-01-01', '2019-08-01', 'no', 350, 'no'),
(3, 5, 'test2', 15, '0000aa', 'test 2', 'test', 'test2', 'studenthouse', '2019-01-01', '2019-08-01', 'yes', 350, 'yes'),
(4, 5, 'test3', 18, '0000aa', 'test3', 'test', 'test3', 'ownershouse', '2018-01-01', '2019-01-01', 'no', 250, 'yes'),
(5, 5, 'test4', 13, '0000aa', 'test 4', 'test', 'test', 'ownershouse', '2018-01-01', '2019-01-01', 'yes', 150, 'no'),
(6, 5, 'test5', 3, '0000aa', 'test 5', 'test', 'test', 'studenthouse', '2018-01-01', '2019-01-01', 'no', 50, 'yes'),
(7, 5, 'test6', 5, '0000aa', 'test 6', 'test', 'test', 'studenthouse', '2018-01-01', '2019-01-01', 'yes', 50, 'no'),
(8, 5, 'test 01', 5, '0000aa', 'tes 01', 'test', 'test', 'studenthouse', '2018-01-01', '2019-01-01', 'no', 50, 'yes'),
(9, 7, 'test', 35, '9231GC', 'Johan ter schoeleweg 63', 'Surhuisterveen', 'test', 'studenthouse', '2018-10-22', '2019-10-22', 'yes', 320, 'yes');

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
(5, 'test', '$2y$10$mfMsKnPZFU46.Obv8IWyietb7LDQvvVyoI3QuoPSpAjpDzrGjo6d.', 'test', 'test', '0000aa', 'test 1', 'test', 645925691, 'test@test.test', 'test', '2000-11-11', 'tenant', 'male', 'test'),
(6, 'zoek', '$2y$10$Q/QMSatJaVZVxEjpRdp44OGOFBbQ10WZYIDiMOYZNS9AQ6ecC9Ufy', 'Mohammad', 'Issa', '9231GC', 'Johan ter schoeleweg 63', 'Surhuisterveen', 687959190, 'mhd.issa990@gmail.com', 'test', '1990-10-22', 'tenant', 'male', 'seller'),
(7, 'owner', '$2y$10$gM/xNu5eNsai56JtWsbAh.yZoEVLDZQjkfIGp9YcTq0LkYpjI28Ga', 'Mohammad', 'Issa', '9231GC', 'Johan ter schoeleweg 63', 'Surhuisterveen', 687959190, 'mhd.issa990@gmail.com', 'test', '1990-10-22', 'owner', 'male', 'seller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `opt_in`
--
ALTER TABLE `opt_in`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

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
