-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 11:32 AM
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
-- Database: `smart_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Name`, `Email`, `Password`) VALUES
(101312, 'jaga-2457', 'rudrajka@gmail.com', '$2y$10$VCVbFT6V/ZT/rLRV17fxO.GpuFkOQlcg58cqjOt2LbwLVCLbsVtvG'),
(174535, 'jaga-2457', 'jaga2320064444@gmail.com', '$2y$10$N8kkKPH1S5FUPKUgkkdXgOQbKhyIgyQJ8ZPoOMbxuomDd06dXknZe'),
(199104, 'jaga-2457', 's457998sss56@gmail.com', '$2y$10$QtYiWEOHVE/wSkGUYDaiy.hseQAuS/euub4Dck.FtddDhRVfpwvYu'),
(266780, 'jaga-2457', 'jahhhhh@gmail.com', '$2y$10$AE.eP43WctuMfW0WkGYWMuS3BGlV.MKfiPj8ekGPVsK2G5sO90sn6'),
(272727, 'jaga-2457', 'jaga232006@gmail.com', '$2y$10$tqAPf2665K37e9l/52qRVOTvxF6nX0BJL5LZyvo9zqN8b/faMgEzm'),
(374295, 'jaga-2457', 's45799856@gmail.com', '$2y$10$vQscVwKyP.jEMWNXqYQH2utJ80DekJ15UFcUiFhVdWkIx0PRhhR92'),
(396341, 'jaga-2457', 'jaga23245006@gmail.com', '$2y$10$I4qZ0pyFywy1slCDZQk94.NsSTufl4L6w/Sjv/ucj9NPvuEXFF5Re'),
(528431, 'lipu dadacc', 'jagahdn45aa4chj@outlook.com', '$2y$10$6HxT5Zk1e2I2mk2rpnuPbeaUYjN9ZJB7RwoQ66UOecdlpYN26U.cS'),
(575513, 'jaga-2457', 'msdh45oni@gmail.com', '$2y$10$TWJ08LyiVV9VuMOfw1uZ1u.1o9O0hm0EpQ9UNoxkIgfSS0CV5kw1m'),
(695765, 'ss', 'subhamkussssgiri21@gmail.com', '$2y$10$x9I6.EoEUte4msf1d2XDwema6MpVfJcg0eL8/joCcVQvI6rAHy1Sy'),
(718537, 'jaga-2457', 's457949856@gmail.com', '$2y$10$mFy0d4VE5pC2EdqJTsogt.K60h5QdFz5PHwD.qsr3HHWWYwUSuz.S'),
(896115, 'jaga-2457', 's45799dd856@gmail.com', '$2y$10$EcmKnB2TYKSh4fDMcqucBuM8g8MTViO3jQ/hQuOOxWsuj7f7GfIqW');

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `Ticket_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `authentication_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('successful','already_verified') NOT NULL,
  `Event_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`Ticket_ID`, `Name`, `authentication_id`, `datetime`, `status`, `Event_name`) VALUES
(511691, 'jaga-2457', 107768, '2025-03-11 14:37:06', 'successful', 'Ram navami'),
(646729, 'jaga-2457', 127229, '2025-03-11 14:36:34', 'successful', 'holi'),
(128549, 'jaga-2457', 137606, '2025-03-11 14:37:14', 'successful', 'holi'),
(225225, 'jaga-2457', 250763, '2025-03-11 14:01:57', 'successful', 'Ram navami'),
(265277, 'jaga-2457', 287194, '2025-03-11 16:36:05', 'successful', 'holi'),
(865412, 'jaga-2457', 320539, '2025-03-11 14:36:12', 'successful', 'Ram navami'),
(620276, 'jaga-2457', 479731, '2025-03-11 14:36:50', 'successful', 'holi'),
(545980, 'jaga-2457', 541169, '2025-03-11 13:57:37', 'already_verified', 'Ram navami'),
(545980, 'jaga-2457', 593257, '2025-03-11 14:01:42', 'already_verified', 'Ram navami'),
(586082, 'jaga-2457', 615677, '2025-03-11 14:36:58', 'successful', 'birthday'),
(741554, 'jaga-2457', 658089, '2025-03-11 14:36:23', 'successful', 'birthday'),
(711677, 'jaga-2457', 678828, '2025-03-11 17:09:50', 'already_verified', 'birthday'),
(111274, 'jaga-2457', 688177, '2025-03-11 14:37:22', 'successful', 'birthday'),
(633077, 'jaga-2457', 816758, '2025-03-11 14:36:43', 'successful', 'Ram navami'),
(111274, 'jaga-2457', 856792, '2025-03-11 14:37:28', 'already_verified', 'birthday'),
(225225, 'jaga-2457', 872101, '2025-03-11 14:02:30', 'already_verified', 'Ram navami'),
(265277, 'jaga-2457', 921967, '2025-03-11 16:37:31', 'already_verified', 'holi'),
(128549, 'jaga-2457', 971221, '2025-03-11 14:37:37', 'already_verified', 'holi'),
(276554, 'jaga-2457', 974774, '2025-03-12 05:24:39', 'successful', 'holi'),
(711677, 'jaga-2457', 976253, '2025-03-11 17:09:19', 'successful', 'birthday'),
(265277, 'jaga-2457', 979262, '2025-03-11 16:36:16', 'already_verified', 'holi');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Event_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Organizer_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_ID`, `Name`, `Date`, `Location`, `Organizer_ID`) VALUES
(15610, 'holi2', '2025-03-15', 'ww', 24577),
(37495, 'birthday', '2025-03-12', 'india', 24577),
(54256, 'jaga\'s birthday', '2025-03-11', 'india', 24577),
(69455, 'holi', '2025-03-15', 'odisha', 24577),
(95125, 'Ram navami', '2025-03-12', 'india', 24577);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `user_email` varchar(255) NOT NULL,
  `status` enum('approved','rejected','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`user_email`, `status`) VALUES
('jaga232006@gmail.com', ''),
('jaga2320064444@gmail.com', 'approved'),
('subhamkussssgiri21@gmail.com', 'approved'),
('jagahdn45aa4chj@outlook.com', 'approved'),
('s45799dd856@gmail.com', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Ticket_ID` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Qr_code` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `Transaction_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Ticket_ID`, `Event_ID`, `User_ID`, `Qr_code`, `status`, `Transaction_Date`) VALUES
(111274, 37495, 466028, 'qr/111274.png', '0', '2025-03-11 15:30:39'),
(128549, 69455, 466028, 'qr/128549.png', '0', '2025-03-11 15:31:55'),
(265277, 69455, 466028, 'qr/265277.png', '0', '2025-03-11 15:32:03'),
(276554, 69455, 466028, 'qr/276554.png', '0', '2025-03-27 00:00:00'),
(361835, 69455, 466028, 'qr/361835.png', '1', '2025-03-11 15:31:33'),
(511691, 95125, 466028, 'qr/511691.png', '0', '2025-03-11 15:31:45'),
(586082, 37495, 466028, 'qr/586082.png', '0', '2025-03-11 15:31:40'),
(620276, 69455, 466028, 'qr/620276.png', '0', '2025-03-11 15:30:46'),
(633077, 95125, 466028, 'qr/633077.png', '0', '2025-03-11 15:31:59'),
(646729, 69455, 466028, 'qr/646729.png', '0', '2025-03-11 15:32:07'),
(711677, 37495, 466028, 'qr/711677.png', '0', '2025-03-11 18:08:24'),
(741554, 37495, 466028, 'qr/741554.png', '0', '2025-03-11 15:31:50'),
(865412, 95125, 466028, 'qr/865412.png', '0', '2025-03-11 15:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Name`, `Email`, `Phone`, `Password`) VALUES
(202145, 'kk', 'kk454@gmail.com', '09861828508', '$2y$10$kB0PSHRSZhnIjzkCA5IyTeftDXg8Alu.2Pj7T7M0UIVSV.zUlFLAG'),
(252020, 'jaga', 'jp5366303@gmail.com', '9937386645', '$2y$10$EwHtCIAUvaC3zDr0E09b5e69nB8o2CP2b2d4t0WqM6ckupForK3g2'),
(362005, 'subham giri', 'jagahdn454chj@outlook.com', '9861828504', '$2y$10$x2Z5ENwmYaFw9Tgw5eZCtOYbQ8h2JNK7jnpCi2gtfPjZT9hRkKEli'),
(399180, 'Rudra', 'rudraa@gmail.com', '4545454545', '$2y$10$HD82V5EGyD9VzQizHjHWy.D6YTFJk7X6kvHk8zG5CyGEZ5YgfXQ4S'),
(466028, 'jaga-2457', 'jaga23200645@gmail.com', '4564561211', '$2y$10$aIsqfGh/kQIVeQRyp5xQyOFn/Ahhi1CQC/ldEaFo2rvxi3wJKMFOy'),
(886404, 'jaga-2457', 'jaga232006@gmail.com', '9861828508', '$2y$10$.9DThXu0PVOvpIsap4rWR.pQLXxQdkcFxKIMLms5UWj5M9mVZWnY.'),
(964192, 'dd', 'ddf@gmail.com', '09861828504', '$2y$10$o1kQEdQKqREz7T1ezCWxxOfcvV0923yicxlZgNTxUc2onmxXgW2c2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`authentication_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`Event_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Ticket_ID`),
  ADD KEY `Event_ID` (`Event_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=896116;

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `authentication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=979263;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `Event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99426;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Ticket_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=998779;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=964193;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
