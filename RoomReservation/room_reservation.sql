-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 11:20 AM
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
-- Database: `room_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `city_id`, `province_id`) VALUES
(1, 25, 2),
(2, 25, 2),
(3, 25, 2),
(4, 25, 2),
(5, 25, 2),
(7, 12, 1),
(10, 18, 1),
(11, 17, 1),
(12, 17, 1),
(14, 24, 1),
(15, 13, 1),
(16, 32, 2);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `province_id`) VALUES
(1, 'Abuyug', 1),
(2, 'Alangalang', 1),
(3, 'Albuera', 1),
(4, 'Babatngon', 1),
(5, 'Barauen', 1),
(6, 'Barugo', 1),
(7, 'Bato', 1),
(8, 'Baybay', 1),
(9, 'Calubian', 1),
(10, 'Capoocan', 1),
(11, 'Carigara', 1),
(12, 'Dagami', 1),
(13, 'Dulag', 1),
(14, 'Hilongos', 1),
(15, 'Hindang', 1),
(16, 'Inopacan', 1),
(17, 'Isabel', 1),
(18, 'Jaro', 1),
(19, 'Javier', 1),
(20, 'Julita', 1),
(21, 'Kanaga', 1),
(22, 'Lapaz', 1),
(23, 'Tacloban', 1),
(24, 'Palo', 1),
(25, 'Borongan', 2),
(26, 'Guiuan', 2),
(27, 'Giporlos', 2),
(28, 'Jipapad', 2),
(29, 'Lawaan', 2),
(30, 'Quinapondan', 2),
(31, 'Llorente', 2),
(32, 'Dolores', 2),
(33, 'San Julian', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `phoneNum` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `phoneNum`, `email`) VALUES
(1, 123, '123@gmail.com'),
(2, 123, '123@gmail.com'),
(3, 123, 'kuzen1234411@gmail.com'),
(4, 123, 'inobelaneso@gmail.com'),
(5, 123, '123@gmail.com'),
(6, 123, '123@gmail.com'),
(7, 123, '123@gmail.com'),
(8, 123, '123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `usertype_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `usertype_id`) VALUES
(1, 'admin', 'admin', 1),
(14, '123', '123', 2),
(15, 'Yuji_0x', '123', 2);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `login_id` int(11) DEFAULT NULL,
  `fname` varchar(250) DEFAULT NULL,
  `lname` varchar(250) DEFAULT NULL,
  `mname` varchar(250) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `login_id`, `fname`, `lname`, `mname`, `address_id`, `gender_id`, `bday`, `contact_id`) VALUES
(7, 14, 'daN', 'Brando', 'D', 15, 1, '2024-12-12', 7),
(8, 15, 'Yuji', 'Kaisen', 'J', 16, 3, '2024-12-12', 8);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(1, 'Leyte'),
(2, 'Eastern Samar');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `review` varchar(250) DEFAULT NULL,
  `login_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `img` blob DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `open_in` time DEFAULT NULL,
  `close_in` time DEFAULT NULL,
  `room_floor_id` int(11) DEFAULT NULL,
  `room_type_id` int(11) DEFAULT NULL,
  `room_status_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `img`, `description`, `open_in`, `close_in`, `room_floor_id`, `room_type_id`, `room_status_id`, `price`) VALUES
(39, '2', 0x6173736574732f726f6f6d732f322e6a7067, 'asdasd', '05:51:00', '06:51:00', 1, 3, 1, 200),
(41, '4', 0x6173736574732f726f6f6d732f342e706e67, 'asdasd', '16:03:00', '16:05:00', 1, 1, 1, 20),
(42, 'Room 1', 0x6173736574732f726f6f6d732f526f6f6d20312e706e67, 'Room 1 ine', '17:47:00', '09:51:00', 4, 5, 1, 100),
(43, 'Room 2', 0x6173736574732f726f6f6d732f526f6f6d20322e706e67, 'Room 2 ine', '17:51:00', '06:51:00', 1, 2, 1, 20),
(44, 'room2343243', 0x6173736574732f726f6f6d732f726f6f6d323334333234332e706e67, 'gfhffvhfctbrfrhytju', '06:00:00', '18:54:00', 1, 1, 1, 200);

-- --------------------------------------------------------

--
-- Table structure for table `room_feature`
--

CREATE TABLE `room_feature` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_feature`
--

INSERT INTO `room_feature` (`id`, `name`) VALUES
(1, 'Wi-Fi Access'),
(2, 'Pool Table'),
(3, 'Mood Lights'),
(4, 'AC/Temp. Control'),
(5, 'Fridge'),
(6, 'Lounge'),
(7, 'Video Ent. T/V');

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `id` int(11) NOT NULL,
  `rooms_id` int(11) DEFAULT NULL,
  `room_feature_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`id`, `rooms_id`, `room_feature_id`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 2, 4),
(4, 2, 5),
(5, 3, 3),
(6, 3, 5),
(7, 3, 6),
(27, 5, 1),
(28, 5, 2),
(29, 5, 3),
(30, 5, 4),
(31, 5, 5),
(32, 5, 6),
(34, 6, 1),
(35, 6, 2),
(36, 6, 3),
(37, 6, 4),
(38, 6, 5),
(39, 6, 6),
(52, 9, 1),
(53, 10, 5),
(54, 10, 6),
(55, 11, 1),
(56, 12, 2),
(57, 12, 6),
(58, 13, 2),
(119, 16, 1),
(163, 18, 1),
(164, 18, 6),
(170, 15, 1),
(171, 15, 2),
(172, 15, 5),
(183, 14, 1),
(184, 14, 2),
(185, 14, 3),
(186, 14, 4),
(187, 14, 5),
(200, 17, 2),
(201, 17, 6),
(202, 19, 5),
(203, 20, 2),
(204, 20, 6),
(205, 21, 1),
(206, 21, 2),
(207, 21, 3),
(208, 21, 4),
(209, 21, 6),
(210, 22, 1),
(212, 24, 1),
(222, 23, 1),
(223, 23, 3),
(224, 23, 6),
(225, 25, 1),
(226, 26, 1),
(227, 26, 4),
(228, 27, 1),
(229, 27, 4),
(230, 28, 1),
(231, 28, 3),
(232, 28, 4),
(233, 28, 5),
(234, 29, 2),
(235, 29, 6),
(236, 29, 7),
(237, 30, 2),
(238, 31, 1),
(239, 31, 5),
(240, 32, 2),
(241, 33, 2),
(242, 33, 7),
(243, 38, 1),
(244, 38, 2),
(245, 38, 4),
(246, 39, 1),
(247, 39, 4),
(248, 39, 6),
(249, 40, 1),
(250, 41, 1),
(251, 42, 1),
(252, 42, 3),
(253, 42, 6),
(254, 43, 1),
(255, 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_floor`
--

CREATE TABLE `room_floor` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_floor`
--

INSERT INTO `room_floor` (`id`, `name`) VALUES
(1, 'First Floor: A'),
(2, 'Second Floor: B'),
(3, 'Third Floor: C'),
(4, 'Fourth Floor: D'),
(5, 'VIP Floor: E');

-- --------------------------------------------------------

--
-- Table structure for table `room_status`
--

CREATE TABLE `room_status` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_status`
--

INSERT INTO `room_status` (`id`, `name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`id`, `name`) VALUES
(1, 'Single Room'),
(2, 'Double Room'),
(3, 'Twin Room'),
(4, 'Triple Room'),
(5, 'Suite'),
(6, 'Deluxe Room'),
(7, 'Family Room');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usertype_id` (`usertype_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_id` (`login_id`),
  ADD KEY `gender_id` (`gender_id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `profile_ibfk_1` (`address_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_id` (`login_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_floor_id` (`room_floor_id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `room_status_id` (`room_status_id`);

--
-- Indexes for table `room_feature`
--
ALTER TABLE `room_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_feature_id` (`room_feature_id`);

--
-- Indexes for table `room_floor`
--
ALTER TABLE `room_floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_status`
--
ALTER TABLE `room_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `room_feature`
--
ALTER TABLE `room_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `room_floor`
--
ALTER TABLE `room_floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_status`
--
ALTER TABLE `room_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`usertype_id`) REFERENCES `usertype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_3` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_4` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `review` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`room_floor_id`) REFERENCES `room_floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_ibfk_3` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_ibfk_4` FOREIGN KEY (`room_status_id`) REFERENCES `room_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
