-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2023 at 03:31 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courier_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthdate` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `vehicle` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `position` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `vercode` varchar(6) DEFAULT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `fname`, `lname`, `email`, `birthdate`, `address`, `vehicle`, `password`, `status`, `position`, `type`, `vercode`, `date`) VALUES
(3, 'admin', 'Account', 'admin@gmail.com', '2023-06-06', 'Samal, Bataan', NULL, '21232f297a57a5a743894a0e4a801fc3', 'activated', '*', 'admin', '681927', '2022-12-26'),
(16, 'Michael', 'Ocampo', 'michael@gmail.com', '2023-01-23', 'Balanga, Bataan', 'Motor', '4401b2ca5941272d6e30e9e7d2f65f84', 'activated', 'Rider', 'rider', NULL, '2023-01-21'),
(17, 'Juan', 'Dela Cruz', 'juan@gmail.com', '2023-01-03', 'Mariveles, Bataan', 'Tricycle', '4401b2ca5941272d6e30e9e7d2f65f84', 'activated', 'Rider', 'rider', NULL, '2023-01-21'),
(22, 'Max', 'Gonzales', 'max@gmail.com', NULL, NULL, NULL, '4401b2ca5941272d6e30e9e7d2f65f84', 'activated', 'Rider', 'rider', NULL, '2023-01-25 18:40:46'),
(25, 'Jermaine', 'Magpoc', 'magpocemong@gmail.com', NULL, NULL, NULL, '4c79273eed3d095e55d1224f6524ae92', 'activated', 'Rider', 'rider', NULL, '2023-01-26 10:25:16'),
(26, 'Cherry', 'Collera', 'Cherry@gmail.com', NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', 'activated', 'Rider', 'rider', NULL, '2023-01-26 10:30:48'),
(34, 'Mikey', 'Juan', 'michaelabsierrafiles@gmail.com', NULL, NULL, NULL, 'c430b459391886050275498d10e4c944', 'pending', 'Administrator', 'admin', NULL, '2023-06-19 14:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `fname`, `lname`, `position`, `activity`, `status`, `date`) VALUES
(1, 'admin', 'test', '*', 'Test Activity Logs', 'VOID', '2023-01-23 05:04:40'),
(2, 'admin', 'test', '*', 'Activity Log cleard by admin.', 'VOID', '2023-01-23 06:55:13'),
(3, 'Michael', 'Ocampo', 'Rider', 'A parcel has been deleted.', 'VOID', '2023-01-23 06:55:13'),
(4, 'admin', 'tests', '*', 'Activity Log cleard by admin.', 'VOID', '2023-01-25 05:35:27'),
(5, 'admin', 'tests', '*', '* add Michael Dela Cruzas new Administrator.', 'VOID', '2023-01-25 05:35:27'),
(6, 'admin', 'tests', '*', 'Activity Log cleard by admin.', 'VOID', '2023-02-01 08:06:45'),
(7, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(8, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(9, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(10, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(11, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(12, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(13, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(14, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(15, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(16, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(17, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(18, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(19, 'admin', 'test', '*', 'A parcel has been deleted.', 'VOID', '2023-02-01 08:06:45'),
(20, 'admin', 'test', '*', 'Activity Log cleard by.', 'VOID', '2023-05-24 03:01:51'),
(21, 'admin', 'test', '*', 'A parcel with transaction number :24 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(22, 'admin', 'test', '*', 'A parcel with transaction number :5 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(23, 'admin', 'test', '*', 'A parcel with transaction number :3 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(24, 'admin', 'test', '*', 'A parcel with transaction number :2 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(25, 'admin', 'test', '*', 'A parcel with transaction number :758967559436456 has been added to Cherry Collera.', 'VOID', '2023-05-24 03:01:51'),
(26, 'admin', 'test', '*', 'A parcel with transaction number :3784568234 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(27, 'admin', 'test', '*', 'A parcel with transaction number :7435734753 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(28, 'admin', 'test', '*', 'A parcel with transaction number :23 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(29, 'admin', 'test', '*', 'A parcel with transaction number :4534534534 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(30, 'admin', 'test', '*', 'A parcel with transaction number :347865345 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(31, 'admin', 'test', '*', 'A parcel with transaction number :347865345 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(32, 'admin', 'test', '*', 'A parcel with transaction number :7777777 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(33, 'admin', 'test', '*', 'A parcel with transaction number :7777777 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(34, 'admin', 'test', '*', 'A parcel with transaction number :345435 has been added to Michael Ocampo.', 'VOID', '2023-05-24 03:01:51'),
(35, 'admin', 'test', '*', 'A parcel with transaction number :345435 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(36, 'admin', 'test', '*', 'A parcel with transaction number :345435 has been deleted.', 'VOID', '2023-05-24 03:01:51'),
(37, 'admin', 'test', '*', 'Activity Log cleard by.', 'VOID', '2023-06-17 05:49:19'),
(38, 'admin', 'test', '*', 'A parcel with transaction number :894567845 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(39, 'admin', 'test', '*', 'A parcel with transaction number :3245235324 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(40, 'admin', 'test', '*', 'A parcel with transaction number :2324 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(41, 'admin', 'test', '*', 'A parcel with transaction number :7899454 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(42, 'admin', 'test', '*', 'A parcel with transaction number :7899454 has been deleted.', 'VOID', '2023-06-17 05:49:19'),
(43, 'admin', 'test', '*', 'A parcel with transaction number :34234234 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(44, 'admin', 'test', '*', 'A parcel with transaction number :34234234 has been deleted.', 'VOID', '2023-06-17 05:49:19'),
(45, 'admin', 'test', '*', 'A parcel with transaction number :237846234 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(46, 'admin', 'test', '*', 'A parcel with transaction number :237846234 has been deleted.', 'VOID', '2023-06-17 05:49:19'),
(47, 'admin', 'test', '*', 'A parcel with transaction number :34234324 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(48, 'admin', 'test', '*', 'A parcel with transaction number :34234324 has been deleted.', 'VOID', '2023-06-17 05:49:19'),
(49, 'admin', 'test', '*', 'A parcel with transaction number :3453453434 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(50, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(51, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(52, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(53, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(54, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(55, 'admin', 'test', '*', 'A parcel with transaction number :3453453434 has been deleted.', 'VOID', '2023-06-17 05:49:19'),
(56, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(57, 'admin', 'admin', '*', 'You update your information.', 'VOID', '2023-06-17 05:49:19'),
(58, 'admin', 'test', '*', 'A parcel with transaction number :836657345 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(59, 'admin', 'test', '*', 'A parcel with transaction number :37847583754 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(60, 'admin', 'test', '*', 'A parcel with transaction number :4234234324 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(61, 'admin', 'test', '*', 'A parcel with transaction number :3423423423 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(62, 'admin', 'test', '*', 'A parcel with transaction number :23423446 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(63, 'admin', 'test', '*', 'A parcel with transaction number :37456234523 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(64, 'admin', 'test', '*', 'A parcel with transaction number :3423423 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(65, 'admin', 'test', '*', 'A parcel with transaction number :23423423 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(66, 'admin', 'test', '*', 'A parcel with transaction number :3874532523324 has been added to Michael Ocampo.', 'VOID', '2023-06-17 05:49:19'),
(67, 'admin', 'test', '*', 'Account Approved', 'VOID', '2023-06-17 05:49:19'),
(68, 'admin', 'test', '*', 'Account Approved', 'VOID', '2023-06-17 05:49:19'),
(69, 'admin', 'test', '*', 'Account Approved', 'VOID', '2023-06-17 05:49:19'),
(70, 'admin', 'test', '*', 'Activity Log cleard by.', 'OK', '2023-06-17 05:49:19'),
(71, 'admin', 'test', '*', 'Account Approved', 'OK', '2023-06-17 05:50:08'),
(72, 'admin', 'test', '*', 'Rider Account :  Approve by admin test', 'OK', '2023-06-17 05:57:01'),
(73, 'admin', 'test', '*', 'Rider Account : Juan LunaApprove by admin test', 'OK', '2023-06-17 05:58:46'),
(74, 'admin', 'admin', '*', 'You update your information.', 'OK', '2023-06-17 06:00:58'),
(75, 'admin', 'Account', '*', '* added Mikey Gonzales as new Administrator.', 'OK', '2023-06-19 06:15:45'),
(76, 'admin', 'Account', '*', '* added Mikey Juan as new Administrator.', 'OK', '2023-06-19 06:32:55'),
(77, 'admin', 'Account', '*', 'A parcel with transaction number :23435345 has been added to Michael Ocampo.', 'OK', '2023-06-21 02:41:28'),
(78, 'admin', 'Account', '*', 'A parcel with transaction number :23435345 has been deleted.', 'OK', '2023-06-21 02:41:51'),
(79, 'admin', 'Account', '*', 'A parcel with transaction number :3456345 has been added to Michael Ocampo.', 'OK', '2023-06-21 02:42:33'),
(80, '', '', '', 'A parcel with transaction number :7843657432534 has been added to Cherry Collera.', 'OK', '2023-06-21 07:59:24'),
(81, 'admin', 'Account', '*', 'A parcel with transaction number :423423423 has been added to Cherry Collera.', 'OK', '2023-06-21 08:00:43'),
(82, 'admin', 'Account', '*', 'A parcel with transaction number :423423423 has been deleted.', 'OK', '2023-06-21 08:00:58'),
(83, 'admin', 'Account', '*', 'A parcel with transaction number :7843657432534 has been deleted.', 'OK', '2023-06-21 08:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `destination` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `destination`) VALUES
(1, 'QF6X+7CH, Samal, Bataan, Philippines'),
(2, 'Calaguiman Elementary School, National Road, Samal, Bataan, Philippines'),
(3, 'Abucay Plaza, Abucay, Bataan, Philippines'),
(4, 'Balanga Plaza de Mayor, City of Balanga, Bataan, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `parcel`
--

CREATE TABLE `parcel` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL COMMENT 'unique identifier',
  `recipient` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `amount` int(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `deliver_date` varchar(20) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parcel`
--

INSERT INTO `parcel` (`id`, `transaction_id`, `email`, `recipient`, `address`, `amount`, `status`, `deliver_date`, `date`) VALUES
(5, '3423423', 'michael@gmail.com', 'Juan Luna', 'Mabatang, Abucay, Bataan,', 500, 'pending', NULL, '2023-06-13 09:14:03'),
(7, '3874532523324', 'michael@gmail.com', 'Juna Luna', 'Park Doña Francisca, City Of Balanga (Capital), Bataan, ', 706, 'pending', NULL, '2023-06-13 09:12:13'),
(9, '3456345', 'michael@gmail.com', 'Juan Carlos', ' Tuyo, City Of Balanga (Capital), Bataan', 455, 'pending', NULL, '2023-06-21 02:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `rider_log`
--

CREATE TABLE `rider_log` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity` varchar(355) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rider_log`
--

INSERT INTO `rider_log` (`id`, `email`, `activity`, `status`, `date`) VALUES
(1, '', 'A parcel with transaction number : 31 has been deleted to you.', 'NOTIF', '2023-05-24 02:56:27'),
(2, '', 'A parcel with transaction number : 345435 has been deleted to you.', 'NOTIF', '2023-05-24 02:56:53'),
(3, 'michael@gmail.com', 'A parcel with transaction number : 345435 has been deleted to you.', 'NOTIF', '2023-05-24 02:58:38'),
(4, 'michael@gmail.com', 'A parcel with transaction number : 345435 has been deleted to you.', 'NOTIF', '2023-05-24 03:00:08'),
(5, 'michael@gmail.com', 'A parcel with transaction number : 345435 has been deleted to you.', 'NOTIF', '2023-05-24 03:01:29'),
(6, 'michael@gmail.com', 'A parcel with transaction number : 894567845 has been added to you.', 'NOTIF', '2023-05-24 03:39:50'),
(7, '', 'A parcel with transaction number : 32 has been delivered', 'OK', '2023-05-24 03:40:14'),
(8, 'michael@gmail.com', 'A parcel with transaction number : 3245235324 has been added to you.', 'NOTIF', '2023-05-24 03:42:40'),
(9, 'michael@gmail.com', 'A parcel with transaction number : 3245235324 has been delivered.', 'OK', '2023-05-24 03:44:17'),
(10, 'michael@gmail.com', 'A parcel with transaction number : 2324 has been added to you.', 'NOTIF', '2023-05-24 03:45:22'),
(11, 'michael@gmail.com', 'A parcel with transaction number : 7899454 has been added to you.', 'NOTIF', '2023-06-01 02:58:27'),
(12, 'michael@gmail.com', 'A parcel with transaction number : 7899454 has been deleted to you.', 'NOTIF', '2023-06-01 02:59:21'),
(13, 'michael@gmail.com', 'A parcel with transaction number : 34234234 has been added to you.', 'NOTIF', '2023-06-01 03:00:11'),
(14, 'michael@gmail.com', 'A parcel with transaction number : 34234234 has been deleted to you.', 'NOTIF', '2023-06-01 03:01:24'),
(15, 'michael@gmail.com', 'A parcel with transaction number : 237846234 has been added to you.', 'NOTIF', '2023-06-01 03:01:56'),
(16, 'michael@gmail.com', 'A parcel with transaction number : 237846234 has been deleted to you.', 'NOTIF', '2023-06-01 03:02:58'),
(17, 'michael@gmail.com', 'A parcel with transaction number : 34234324 has been added to you.', 'NOTIF', '2023-06-01 03:03:33'),
(18, 'michael@gmail.com', 'A parcel with transaction number : 34234324 has been deleted to you.', 'NOTIF', '2023-06-01 05:28:55'),
(19, 'michael@gmail.com', 'A parcel with transaction number : 2324 has been delivered.', 'OK', '2023-06-02 06:36:07'),
(20, 'michael@gmail.com', 'A parcel with transaction number : 2324 has been mark as failed.', 'OK', '2023-06-03 02:57:29'),
(21, 'michael@gmail.com', 'A parcel with transaction number : 3453453434 has been added to you.', 'NOTIF', '2023-06-03 03:06:10'),
(22, '', 'You update your information.', 'OK', '2023-06-06 06:03:51'),
(23, 'michael@gmail.com', 'A parcel with transaction number : 3453453434 has been deleted to you.', 'NOTIF', '2023-06-08 08:44:11'),
(24, 'michael@gmail.com', 'A parcel with transaction number : 836657345 has been added to you.', 'NOTIF', '2023-06-10 08:37:07'),
(25, 'michael@gmail.com', 'A parcel with transaction number : 37847583754 has been added to you.', 'NOTIF', '2023-06-10 08:44:45'),
(26, 'michael@gmail.com', 'A parcel with transaction number : 4234234324 has been added to you.', 'NOTIF', '2023-06-10 09:13:14'),
(27, 'michael@gmail.com', 'A parcel with transaction number : 3423423423 has been added to you.', 'NOTIF', '2023-06-10 09:13:57'),
(28, 'michael@gmail.com', 'A parcel with transaction number : 23423446 has been added to you.', 'NOTIF', '2023-06-10 09:14:30'),
(29, 'michael@gmail.com', 'A parcel with transaction number : 37456234523 has been added to you.', 'NOTIF', '2023-06-13 02:18:08'),
(30, 'michael@gmail.com', 'A parcel with transaction number : 3423423 has been added to you.', 'NOTIF', '2023-06-13 02:20:10'),
(31, 'michael@gmail.com', 'A parcel with transaction number : 23423423 has been added to you.', 'NOTIF', '2023-06-13 02:33:49'),
(32, 'michael@gmail.com', 'A parcel with transaction number : 3874532523324 has been added to you.', 'NOTIF', '2023-06-13 09:12:13'),
(33, 'michael@gmail.com', 'A parcel with transaction number : 23435345 has been added to you.', 'NOTIF', '2023-06-21 02:41:28'),
(34, 'michael@gmail.com', 'A parcel with transaction number : 23435345 has been deleted to you.', 'NOTIF', '2023-06-21 02:41:51'),
(35, 'michael@gmail.com', 'A parcel with transaction number : 3456345 has been added to you.', 'NOTIF', '2023-06-21 02:42:33'),
(36, 'Cherry@gmail.com', 'A parcel with transaction number : 7843657432534 has been added to you.', 'NOTIF', '2023-06-21 07:59:24'),
(37, 'Cherry@gmail.com', 'A parcel with transaction number : 423423423 has been added to you.', 'NOTIF', '2023-06-21 08:00:43'),
(38, 'Cherry@gmail.com', 'A parcel with transaction number : 423423423 has been deleted to you.', 'NOTIF', '2023-06-21 08:00:58'),
(39, 'Cherry@gmail.com', 'A parcel with transaction number : 7843657432534 has been deleted to you.', 'NOTIF', '2023-06-21 08:01:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcel`
--
ALTER TABLE `parcel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_log`
--
ALTER TABLE `rider_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parcel`
--
ALTER TABLE `parcel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rider_log`
--
ALTER TABLE `rider_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
