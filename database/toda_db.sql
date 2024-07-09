-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2024 at 03:16 PM
-- Server version: 10.5.24-MariaDB-cll-lve
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `profile_img` varchar(250) DEFAULT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `birthdate` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `suspension` varchar(30) DEFAULT 'NO',
  `suspension_reason` varchar(255) DEFAULT NULL,
  `position` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `vercode` varchar(6) DEFAULT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `unique_id`, `profile_img`, `fname`, `lname`, `email`, `contact`, `birthdate`, `address`, `password`, `status`, `suspension`, `suspension_reason`, `position`, `type`, `vercode`, `date`) VALUES
(3, '72a49a98fefda382', '72a49a98fefda382-profile.php', 'Juanito', 'Natividad', 'admin@gmail.com', '09443456789', '1997-12-04', 'Samal, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, '*', 'admin', '681927', '2022-12-26'),
(67, '56238d489af6adde', '56238d489af6adde-profile.', 'Mina', 'Bugay', 'municipal@gmail.com', '09212345679', '1991-06-07', 'Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Municipality', 'municipality', NULL, '2024-01-16 11:48:33'),
(81, '3a1b6f51f40c7f45', NULL, 'Juan', 'Santos', 'trictoda+juan@gmail.com', '09212345659', '1991-02-04', 'Sapa, Sto. Domingo, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Operator', 'operator', NULL, '2024-04-22 14:16:44'),
(82, 'd69ab0840d474ff6', NULL, 'Michael', 'Ocampo', 'trictoda+michael@gmail.com', '09212345676', '1991-06-05', 'Juan, Sto. Domingo, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Operator', 'operator', NULL, '2024-04-22 14:17:28'),
(84, '2ec717856a823016', NULL, 'Antonio', 'Cruz', 'trictoda+antonio@gmail.com', '09987654321', '2024-04-11', 'Garcia, Ricarte, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', '', 'Rider', 'rider', NULL, '2024-04-22 14:27:19'),
(86, '52e22b62a1b756e2', '52e22b62a1b756e2-profile.jpg', 'Manuel', 'Gonzales', 'driver@gmail.com', '', '1996-07-12', 'Domingo, Balon Anito, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Rider', 'rider', NULL, '2024-04-22 14:35:42'),
(87, 'e77adf4bbf4a0e55', NULL, 'Pedro', 'Fernandez', 'trictoda+pedro@gmail.com', '09876543421', '1994-07-22', 'Ibaba, Bato-Bato, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Rider', 'rider', '126204', '2024-04-22 14:40:48'),
(88, 'dfe67bc941fd676b', 'dfe67bc941fd676b-profile.jpg', 'Miguel', 'Reyes', 'trictoda+miguel@gmail.com', '', '2001-07-17', 'Balon Anito, Mariveles, Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Passenger', 'passenger', '', '2024-04-22 14:49:21'),
(90, 'a8b73242b35705c9', NULL, 'Joshua', 'Manalo', 'trictoda+josh@gmail.com', '09637370417', '1996-04-02', NULL, '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Passenger', 'passenger', '', '2024-04-25 07:39:27'),
(91, '4e3f190567e02b80', NULL, 'Alvin', 'Aquino', 'trictoda+alvin@gmail.com', '096737370417', '2001-04-26', NULL, '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Passenger', 'passenger', '', '2024-04-25 12:25:57'),
(92, '5c27b32a4b7270ef', NULL, 'Joshua', 'Dela Cruz', 'trictoda+joshua@gmail.com', '0967370417', '1989-04-20', 'Garcia, Sisiman, Mariveles , Bataan', '21232f297a57a5a743894a0e4a801fc3', 'activated', 'NO', NULL, 'Rider', 'rider', NULL, '2024-04-25 12:28:04'),
(93, 'c4caaf01ce79d15e', 'c4caaf01ce79d15e-profile.jpg', 'Nikole', 'Bugay', 'trictoda+nikole@gmail.com', '', '2024-05-07', 'Sisiman, Mariveles, Bataan', '851e2ebe5761cd6e1de510c374edfe51', 'activated', 'NO', NULL, 'Passenger', 'passenger', '', '2024-05-07 09:35:25'),
(94, 'ea01c70077a41bf9', NULL, 'Gabriel', 'Quinto', 'trictoda+gabriel@gmail.com', '09637370714', '1971-05-09', 'Garcia, Sisiman, Mariveles , Bataan ', '851e2ebe5761cd6e1de510c374edfe51', 'activated', 'NO', NULL, 'Rider', 'rider', NULL, '2024-05-09 09:58:07'),
(95, '13a3baba4e559e4d', NULL, 'carlo', 'valencia', 'trictoda+carlo@gmail.com', '', NULL, NULL, 'b11a41147b21c2a016caac49c2130a63', 'activated', 'NO', NULL, 'Operator', 'operator', NULL, '2024-05-10 13:46:06'),
(96, '0e2d47388616f8bc', NULL, 'Archie', 'Cayabya ', 'trictoda@gmail.com', '09637370417', '1996-05-10', 'Garcia, Sisiman, Mariveles , Bataan', '851e2ebe5761cd6e1de510c374edfe51', 'pending', 'NO', NULL, 'Rider', 'rider', NULL, '2024-05-10 14:15:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `fname`, `lname`, `position`, `activity`, `status`, `date`) VALUES
(1, 'admin', 'admin', '*', 'You update your information.', 'OK', '2024-01-06 03:54:15'),
(2, 'Paulo', 'Paulo', 'Passenger', 'You update your information.', 'OK', '2024-01-16 01:11:50'),
(3, 'Alex', 'Alex', 'Operator', 'You update your information.', 'OK', '2024-02-03 06:53:31'),
(4, 'Alex', 'Alex', 'Operator', 'You update your information.', 'OK', '2024-02-03 06:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `driver_id` varchar(50) NOT NULL,
  `passenger_id` varchar(100) DEFAULT NULL,
  `current_location` varchar(250) NOT NULL,
  `driver_latitude` varchar(100) DEFAULT NULL,
  `driver_longitude` varchar(100) DEFAULT NULL,
  `passenger_origin` varchar(100) DEFAULT NULL,
  `passenger_destination` varchar(100) DEFAULT NULL,
  `passenger_notes` varchar(100) DEFAULT NULL,
  `distance` varchar(50) DEFAULT NULL,
  `estimated_fare` bigint(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `decline_note` varchar(250) DEFAULT NULL,
  `passenger_type` varchar(20) DEFAULT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `booking_id`, `driver_id`, `passenger_id`, `current_location`, `driver_latitude`, `driver_longitude`, `passenger_origin`, `passenger_destination`, `passenger_notes`, `distance`, `estimated_fare`, `status`, `decline_note`, `passenger_type`, `created_at`, `timestamp`) VALUES
(1, '38c7a67ad81a0baa', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'QF6X+7CH, Samal, Bataan, Philippines', '14.7604582', '120.4988095', 'QF6X+7CH, Samal, Bataan, Philippines', 'QFVG+PR Orani, Bataan, Philippines', 'Sa tapat ng tindahan ', '5.86 KM', 58, 'completed', NULL, 'Student', '2024-06-22 15:00:13', '2024-05-07 01:28:10'),
(2, 'c4e903cc952a736c', 'e77adf4bbf4a0e55', 'dfe67bc941fd676b', 'QG56+V54, Samal, Bataan, Philippines', '14.7589522', '120.5109304', 'QG56+V54, Samal, Bataan, Philippines', 'MGMQ+52 Balanga, Bataan, Philippines', 'Dito po ako sa tapat ng tindahan', '13.11 KM', 145, 'completed', NULL, 'Student', '2024-05-25 04:56:10', '2024-05-07 01:26:08'),
(3, 'b6ec19f8a291057b', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'QG56+V54, Samal, Bataan, Philippines', '14.7589452', '120.5109111', 'QG56+V54, Samal, Bataan, Philippines', 'QG8F+P3 Samal, Bataan, Philippines', '', '4.00 KM', 36, 'completed', NULL, 'Student', '2024-05-25 07:47:07', '2024-05-07 01:26:01'),
(4, 'aac0e31760d726b4', '2ec717856a823016', 'dfe67bc941fd676b', '1092 Henson, Angeles, 2009 Pampanga, Philippines', '15.1449853', '120.5887029', '1092 Henson, Angeles, 2009 Pampanga, Philippines', 'PGG7+GH Abucay, Bataan, Philippines', '', '66.94 KM', 791, 'completed', NULL, 'Student', '2024-05-25 09:28:36', '2024-05-07 01:25:58'),
(7, '247aa4654e4faec1', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'QG56+V54, Samal, Bataan, Philippines', '14.7589255', '120.5109492', 'QG56+V54, Samal, Bataan, Philippines', 'PGH7+HC Abucay, Bataan, Philippines', 'sa tapat ng tindahan', '5.46 KM', 53, 'completed', NULL, 'Student', '2024-05-25 12:38:16', '2024-05-07 01:25:53'),
(8, '79f8a816b8506df1', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'QG56+V54, Samal, Bataan, Philippines', '14.7589494', '120.510908', 'QG56+V54, Samal, Bataan, Philippines', 'QG9G+H9 Samal, Bataan, Philippines', '', '6.75 KM', 69, 'completed', NULL, 'Student', '2024-05-2 12:44:04', '2024-05-07 01:29:26'),
(10, '4d6598f26282641c', '5c27b32a4b7270ef', '4e3f190567e02b80', 'QF6X+7CH, Samal, Bataan, Philippines', '14.7604534', '120.4988166', 'QF6X+7CH, Samal, Bataan, Philippines', 'RGC8+53 Orani, Bataan, Philippines', '', '8.38 KM', 110, 'completed', NULL, 'Regular', '2024-05-08 10:32:32', '2024-05-08 02:32:32'),
(11, '7002700f831a7e36', 'e77adf4bbf4a0e55', NULL, '1092 Henson, Angeles, 2009 Pampanga, Philippines', '15.1449853', '120.5887029', NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, '2024-05-10 01:43:10'),
(13, 'd1fc30aebcaa72fa', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'QF6X+7CH, Samal, Bataan, Philippines', '14.7604619', '120.4988083', 'QF6X+7CH, Samal, Bataan, Philippines', 'QGP5+X5 Samal, Bataan, Philippines', '', '4.51 KM', 52, 'completed', NULL, 'Regular', '2024-06-03 13:48:41', '2024-06-03 05:48:41'),
(14, 'ea6ba66850e7675e', '2ec717856a823016', NULL, 'QF6X+7CH, Samal, Bataan, Philippines', '14.7604574', '120.4988143', NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, '2024-06-03 04:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `booking_verification`
--

CREATE TABLE `booking_verification` (
  `id` int(11) NOT NULL,
  `verification_id` varchar(50) NOT NULL,
  `id_type` varchar(50) DEFAULT NULL,
  `front_img` varchar(150) DEFAULT NULL,
  `back_img` varchar(150) DEFAULT NULL,
  `passenger_type` varchar(50) DEFAULT NULL,
  `verification_status` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_verification`
--

INSERT INTO `booking_verification` (`id`, `verification_id`, `id_type`, `front_img`, `back_img`, `passenger_type`, `verification_status`, `timestamp`) VALUES
(1, 'dfe67bc941fd676b', 'Philhealth ID', 'dfe67bc941fd676b-front.png', 'dfe67bc941fd676b-back.jpg', 'Regular', 'approved', '2024-06-03 04:02:52'),
(2, '1c1a635bab52a587', NULL, NULL, NULL, NULL, 'NO', '2024-04-24 23:32:39'),
(3, 'a8b73242b35705c9', 'Philhealth ID', 'a8b73242b35705c9-front.jpg', 'a8b73242b35705c9-back.png', 'Regular', 'approved', '2024-05-07 01:22:51'),
(5, 'c4caaf01ce79d15e', 'Passport', 'c4caaf01ce79d15e-front.jpg', 'c4caaf01ce79d15e-back.jpg', 'Regular', 'approved', '2024-05-10 05:44:37'),
(6, '4e3f190567e02b80', 'Passport', 'c4caaf01ce79d15e-front.jpg', 'c4caaf01ce79d15e-back.jpg', 'Regular', 'approved', '2024-05-08 02:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(30) NOT NULL,
  `driver_id` varchar(30) NOT NULL,
  `passenger_id` varchar(30) DEFAULT NULL,
  `message` varchar(100) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `seen` int(5) DEFAULT NULL,
  `created_at` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `booking_id`, `driver_id`, `passenger_id`, `message`, `sender`, `seen`, `created_at`, `timestamp`) VALUES
(1, 'c4e903cc952a736c', 'e77adf4bbf4a0e55', 'dfe67bc941fd676b', 'Saan na po kayo?', 'passenger', 1, '2024-04-25 04:54:11', '2024-04-24 20:54:21'),
(2, 'c4e903cc952a736c', 'e77adf4bbf4a0e55', 'dfe67bc941fd676b', 'Malapit na po', 'driver', 1, '2024-04-25 04:54:31', '2024-04-24 20:54:43'),
(3, '247aa4654e4faec1', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'malapit na po', 'driver', 1, '2024-04-25 12:34:01', '2024-04-25 04:34:12'),
(4, '247aa4654e4faec1', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'okay po', 'passenger', NULL, '2024-04-25 12:34:17', '2024-04-25 04:34:17'),
(5, '247aa4654e4faec1', '52e22b62a1b756e2', 'dfe67bc941fd676b', 'okay po', 'passenger', NULL, '2024-04-25 12:34:17', '2024-04-25 04:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `driver_ratings`
--

CREATE TABLE `driver_ratings` (
  `id` int(11) NOT NULL,
  `driver_id` varchar(20) DEFAULT NULL,
  `passenger_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `star` int(2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `datetime` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_ratings`
--

INSERT INTO `driver_ratings` (`id`, `driver_id`, `passenger_id`, `name`, `star`, `title`, `comment`, `datetime`, `timestamp`) VALUES
(1, '52e22b62a1b756e2', 'dfe67bc941fd676b', 'Miguel', 4, 'Good', 'Mabilis dumating at mabait.', '2024-05-03 15:00:42', '2024-05-07 01:31:28'),
(2, 'e77adf4bbf4a0e55', 'dfe67bc941fd676b', 'Miguel', 5, 'Good', 'Magaling at madaling kausap', '2024-05-05 04:57:14', '2024-05-07 01:31:22'),
(3, '52e22b62a1b756e2', 'dfe67bc941fd676b', 'Miguel', 4, 'Magaling', 'Good Driver', '2024-05-01 07:47:04', '2024-05-07 01:31:43'),
(4, '2ec717856a823016', 'dfe67bc941fd676b', 'Miguel', 3, 'Good', 'Good', '2024-05-02 09:29:09', '2024-05-07 01:31:47'),
(5, '52e22b62a1b756e2', 'dfe67bc941fd676b', 'Miguel', 5, 'Good', 'Good', '2024-05-06 12:44:37', '2024-05-07 01:31:57'),
(6, '5c27b32a4b7270ef', '4e3f190567e02b80', 'Alvin', 5, 'Very Good', 'Safe and very kind driver', '2024-05-08 10:33:18', '2024-05-08 02:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `contact` bigint(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `unique_id`, `name`, `relationship`, `email`, `contact`, `timestamp`) VALUES
(2, 'c4caaf01ce79d15e', 'Joshua Cruz', 'Father', 'trictoda+joshua@gmail.com', 987654321, '2024-05-07 01:35:25'),
(3, 'dfe67bc941fd676b', 'Dennis', 'Ramos', 'trictoda@gmail.com', 9637370417, '2024-05-09 12:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `fare_and_discount`
--

CREATE TABLE `fare_and_discount` (
  `id` int(11) NOT NULL,
  `first_kilometers` int(10) NOT NULL,
  `succeeding_kilometers` int(10) NOT NULL,
  `discount` int(10) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_and_discount`
--

INSERT INTO `fare_and_discount` (`id`, `first_kilometers`, `succeeding_kilometers`, `discount`, `datetime`) VALUES
(1, 15, 15, 20, '2024-04-11 02:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `fare_matrix`
--

CREATE TABLE `fare_matrix` (
  `id` int(11) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `fare` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_matrix`
--

INSERT INTO `fare_matrix` (`id`, `origin`, `destination`, `fare`, `timestamp`) VALUES
(5, 'Town Proper', 'Brgy. Ipag', '15.00', '2024-01-15 09:02:23'),
(6, 'Town Proper', 'Brgy. San Isidro', '15.00', '2024-01-15 09:02:23'),
(7, 'Town Proper', 'Brgy. Balon Anito', '15.00', '2024-01-15 09:02:23'),
(8, 'Town Proper', 'Porto Del Sol Gate', '16.00', '2024-01-15 09:02:23'),
(9, 'Town Proper', 'Porto Del Sol (Seashore)', '19.00', '2024-01-15 09:02:23'),
(10, 'Town Proper', 'Lower Biaan', '20.00', '2024-01-15 09:02:23'),
(11, 'Town Proper', 'AFAB Central Terminal', '15.00', '2024-01-15 09:02:23'),
(12, 'Town Proper', 'Baseco/Bato-Bato', '18.00', '2024-01-15 09:02:23'),
(13, 'Town Proper', 'Topside/Breakwater', '19.00', '2024-01-15 09:02:23'),
(14, 'Town Proper', 'Brgy. Sisiman', '19.00', '2024-01-15 09:02:23'),
(15, 'Town Proper', 'Baseco Country', '25.00', '2024-01-15 09:02:23'),
(16, 'Town Proper', 'Petron', '18.00', '2024-01-15 09:02:23'),
(17, 'Town Proper', 'Fiesta Communities', '20.00', '2024-01-15 09:02:23'),
(18, 'Town Proper', 'Trenta\'y Uno', '30.00', '2024-01-15 09:02:23'),
(19, 'Town Proper', 'Roving Unit (Minimum Fare)', '15.00', '2024-01-15 09:02:23'),
(20, 'East Cam Tech', 'Palengke', '15.00', '2024-01-15 09:04:02'),
(21, 'East Cam Tech', 'Lakandula', '15.00', '2024-01-15 09:04:02'),
(22, 'East Cam Tech', 'Ricarte', '20.00', '2024-01-15 09:04:02'),
(23, 'East Cam Tech', 'Barangay San Isidro', '20.00', '2024-01-15 09:04:02'),
(24, 'East Cam Tech', 'Barangay Ipag', '20.00', '2024-01-15 09:04:02'),
(25, 'East Cam Tech', 'Laya Lower and Upper', '20.00', '2024-01-15 09:04:02'),
(26, 'East Cam Tech', 'Sto. Domingo', '20.00', '2024-01-15 09:04:02'),
(27, 'East Cam Tech', 'Barangay Balon', '22.00', '2024-01-15 09:04:02'),
(28, 'East Cam Tech', 'Barangay Camaya Zone V & VI', '19.00', '2024-01-15 09:04:02'),
(29, 'East Cam Tech', 'Barangay Sisiman', '18.00', '2024-01-15 09:04:02'),
(30, 'East Cam Tech', 'Breakwater', '17.00', '2024-01-15 09:04:02'),
(31, 'East Cam Tech', 'Topside', '17.00', '2024-01-15 09:04:02'),
(32, 'East Cam Tech', 'Bato-Bato', '16.00', '2024-01-15 09:04:02'),
(33, 'East Cam Tech', 'Kanto ng Baseco', '15.00', '2024-01-15 09:04:02'),
(34, 'East Cam Tech', 'Baseco Country', '22.00', '2024-01-15 09:04:02'),
(35, 'East Cam Tech', 'Frienship', '25.00', '2024-01-15 09:04:02'),
(36, 'East Cam Tech', 'Palao Baseco', '25.00', '2024-01-15 09:04:02'),
(37, 'Essilor', 'Palengke', '15.00', '2024-01-15 09:04:53'),
(38, 'Essilor', 'Lakandula', '15.00', '2024-01-15 09:04:53'),
(39, 'Essilor', 'Ricarte', '15.00', '2024-01-15 09:04:53'),
(40, 'Essilor', 'Brgy.Ipag', '17.00', '2024-01-15 09:04:53'),
(41, 'Essilor', 'Brgy. San Isidro', '17.00', '2024-01-15 09:04:53'),
(42, 'Essilor', 'Laya Lower & Upper', '17.00', '2024-01-15 09:04:53'),
(43, 'Essilor', 'Sto. Domingo', '19.00', '2024-01-15 09:04:53'),
(44, 'Essilor', 'Barangay Balon Anito', '22.00', '2024-01-15 09:04:53'),
(45, 'Essilor', 'Barangay Camaya V & VI', '19.00', '2024-01-15 09:04:53'),
(46, 'Dunlop', 'Palengke', '15.00', '2024-01-15 09:05:58'),
(47, 'Dunlop', 'Lakandula', '15.00', '2024-01-15 09:05:58'),
(48, 'Dunlop', 'Ricarte', '17.00', '2024-01-15 09:05:58'),
(49, 'Dunlop', 'Barangay Ipag', '17.00', '2024-01-15 09:05:58'),
(50, 'Dunlop', 'Laya Lower & Upper', '17.00', '2024-01-15 09:05:58'),
(51, 'Dunlop', 'Sto. Domingo', '17.00', '2024-01-15 09:05:58'),
(52, 'Dunlop', 'Barangay Balon Anito', '22.00', '2024-01-15 09:05:58'),
(53, 'Dunlop', 'Barangay Camaya V & VI', '20.00', '2024-01-15 09:05:58'),
(55, 'Town Proper', 'Sisiman', '15', '2024-04-25 04:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `operator_drivers`
--

CREATE TABLE `operator_drivers` (
  `id` int(11) NOT NULL,
  `operator_id` varchar(50) NOT NULL,
  `driver_id` varchar(50) NOT NULL,
  `lisence_number` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator_drivers`
--

INSERT INTO `operator_drivers` (`id`, `operator_id`, `driver_id`, `lisence_number`, `created_at`, `timestamp`) VALUES
(13, 'd69ab0840d474ff6', 'eaba5f6e449d96b3', 'BNV6734', '2024-04-22 14:23:57', '2024-04-22 06:23:57'),
(14, 'd69ab0840d474ff6', '2ec717856a823016', 'VBN875', '2024-04-22 14:27:19', '2024-04-22 06:27:19'),
(15, '3a1b6f51f40c7f45', '0957d85be4e46ff3', 'NBM897', '2024-04-22 14:31:33', '2024-04-22 06:31:33'),
(16, 'd69ab0840d474ff6', '52e22b62a1b756e2', 'MNB989', '2024-04-22 14:35:42', '2024-04-22 06:35:42'),
(17, '3a1b6f51f40c7f45', 'e77adf4bbf4a0e55', 'NMN765', '2024-04-22 14:40:48', '2024-04-22 06:40:48'),
(18, 'd69ab0840d474ff6', '5c27b32a4b7270ef', 'VNG637', '2024-04-25 12:28:04', '2024-04-25 04:28:04'),
(19, 'd69ab0840d474ff6', 'ea01c70077a41bf9', 'BSJ738', '2024-05-09 09:58:07', '2024-05-09 02:01:34'),
(20, '3a1b6f51f40c7f45', '0e2d47388616f8bc', 'VSH636', '2024-05-10 14:15:30', '2024-05-10 06:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_id` text NOT NULL,
  `driver_id` varchar(50) NOT NULL,
  `passenger_id` varchar(50) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `report_by` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_id`, `driver_id`, `passenger_id`, `reason`, `report_by`, `created_at`, `timestamp`) VALUES
(1, '29db0e12cd8ad7dc', 'd655d07028ad7746', '1ee6560535af41c3', 'hindi dumating', 'passenger', '2024-04-22 13:36:19', '2024-04-22 05:36:19'),
(2, '433e75985318dd68', '2ec717856a823016', 'dfe67bc941fd676b', 'Walang dumating na driver', 'passenger', '2024-04-25 09:28:16', '2024-04-25 01:28:16'),
(3, 'df29786124166070', '5c27b32a4b7270ef', '4e3f190567e02b80', 'Disrespectful', 'driver', '2024-05-08 10:27:54', '2024-05-08 02:27:54'),
(4, 'fec35464b7807227', '5c27b32a4b7270ef', '4e3f190567e02b80', 'Reckless Driving', 'passenger', '2024-05-08 10:28:24', '2024-05-08 02:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `passenger_id` varchar(20) NOT NULL,
  `points` float NOT NULL,
  `date_earned` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `passenger_id`, `points`, `date_earned`, `timestamp`) VALUES
(1, 'dfe67bc941fd676b', 0.3, '2024-04-25 04:57:14', '2024-04-24 20:57:14'),
(2, 'dfe67bc941fd676b', 0.3, '2024-04-25 07:47:30', '2024-04-24 23:47:30'),
(3, 'dfe67bc941fd676b', 0.3, '2024-04-25 09:29:09', '2024-04-25 01:29:09'),
(4, 'dfe67bc941fd676b', 0.3, '2024-04-25 12:44:37', '2024-04-25 04:44:39'),
(5, '4e3f190567e02b80', 0.3, '2024-05-08 10:33:18', '2024-05-08 02:33:19');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `activity_id` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `position` varchar(30) NOT NULL,
  `activity` varchar(250) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `activity_id`, `fname`, `lname`, `position`, `activity`, `status`, `date`) VALUES
(0, '72a49a98fefda382', 'Admins', 'Account', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-08 09:32:52'),
(0, '72a49a98fefda382', 'Admin', 'Account', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-08 09:51:39'),
(0, '72a49a98fefda382', 'Admin', 'Account', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-08 09:51:56'),
(0, '52e22b62a1b756e2', 'Manuel', 'Gonzales', 'Rider', 'Update: Your information has been successfully modified.', 'OK', '2024-05-09 10:57:08'),
(0, 'dfe67bc941fd676b', 'Miguel', 'Reyes', 'Passenger', 'Update: Your information has been successfully modified.', 'OK', '2024-05-10 08:57:19'),
(0, 'dfe67bc941fd676b', 'Miguel', 'Reyes', 'Passenger', 'Update: Your information has been successfully modified.', 'OK', '2024-05-10 08:58:00'),
(0, 'c4caaf01ce79d15e', 'Nikole', 'Bugay', 'Passenger', 'Update: Your information has been successfully modified.', 'OK', '2024-05-10 09:01:24'),
(0, '56238d489af6adde', 'Mina', 'Bugay', 'Municipality', 'A passenger account has been approved for verification.', 'OK', '2024-05-10 13:44:37'),
(0, '72a49a98fefda382', 'Juanito', 'Natividad', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-15 19:12:39'),
(0, '72a49a98fefda382', 'Juanito', 'Natividad', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-15 19:17:56'),
(0, '72a49a98fefda382', 'Juanito', 'Natividad', '*', 'Update: Your information has been successfully modified.', 'OK', '2024-05-15 19:18:16');

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
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_verification`
--
ALTER TABLE `booking_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_ratings`
--
ALTER TABLE `driver_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fare_and_discount`
--
ALTER TABLE `fare_and_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fare_matrix`
--
ALTER TABLE `fare_matrix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operator_drivers`
--
ALTER TABLE `operator_drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `booking_verification`
--
ALTER TABLE `booking_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `driver_ratings`
--
ALTER TABLE `driver_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fare_and_discount`
--
ALTER TABLE `fare_and_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fare_matrix`
--
ALTER TABLE `fare_matrix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `operator_drivers`
--
ALTER TABLE `operator_drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rider_log`
--
ALTER TABLE `rider_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
