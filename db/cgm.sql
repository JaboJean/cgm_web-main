-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 09:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cgm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_phone` text NOT NULL,
  `admin_name` varchar(15) NOT NULL,
  `admin_password` text NOT NULL,
  `admin_token` text NOT NULL,
  `admin_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_email`, `admin_phone`, `admin_name`, `admin_password`, `admin_token`, `admin_status`) VALUES
(1, 'vierrashema@gmail.com', '0787493865', 'Shema', 'password', '9A39QvK07GuYP2TNGFra3ezrqJT8fCFG6llnM8F3gLbHsvTBkYiyOv5gSB4QChA6h2olGeT3rF1PkWYCDlfgo4x8Z4ISE2kCO91f8f7uwubNyt5MnN9vEv3fg5OHf42eVEaO4Dp1dlnAauapivkaDF7XK9SV3ivKJGrVdt1olXDtSehQq2n2XUFbXU3hxjElyRi8fMeXPBs7rIHFOmRzG6JIIrBSv7dPcM5I2r6hRVYEGMjFGkylV8SIOqYRp9q0jmAlW87xJ3BMwCrjoKqkHUi3GDkVCPU4wk7kLDBFnEv2Nn2YkYtYhLvPE62b78T63WyLdDt2Myo8JgRV6h92QZjW01R3tgpxkBSfop9BmBEHHxuSOFVLrWABNswyAbezuOsjCZT0OWOBroTTRQpnNSxAk6z9yW7dj6K5ugBxTkzRqrC7T9Lv5vPcAqytyV2VNuzY86mV5LnYkA8kQzRkRvt6t6wrFeIQNWIr9WD3DzoeVqSEIA4Y', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `request_type` varchar(255) DEFAULT NULL,
  `pediatrician` varchar(255) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` datetime NOT NULL,
  `request_status` varchar(255) DEFAULT 'Pending',
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `user_id`, `request_type`, `pediatrician`, `appointment_date`, `appointment_time`, `request_status`, `notes`) VALUES
(30, 101, 'Diagnosis', '102', '2024-08-01', '0000-00-00 00:00:00', 'Approved', ''),
(31, 101, 'Diagnosis', '102', '2024-08-02', '0000-00-00 00:00:00', 'Approved', ''),
(32, 101, 'Vaccination', '102', '2024-09-19', '0000-00-00 00:00:00', 'Approved', ''),
(33, 101, 'Diagnosis', '102', '2024-07-31', '0000-00-00 00:00:00', 'Approved', ''),
(34, 101, 'Vaccination', '102', '2024-08-08', '0000-00-00 00:00:00', 'Approved', ''),
(35, 104, 'Vaccination', '102', '2024-07-31', '0000-00-00 00:00:00', 'Approved', ''),
(36, 104, 'Diagnosis', '105', '2024-07-25', '0000-00-00 00:00:00', 'Approved', ''),
(37, 104, 'Diagnosis', '105', '2024-08-08', '0000-00-00 00:00:00', 'Approved', ''),
(38, 104, 'Diagnosis', '102', '2024-08-10', '0000-00-00 00:00:00', 'Approved', ''),
(39, 104, 'Vaccination', '105', '2024-10-09', '0000-00-00 00:00:00', 'Approved', ''),
(40, 104, 'Vaccination', '105', '2025-04-08', '0000-00-00 00:00:00', 'Approved', ''),
(41, 112, 'Diagnosis', '110', '2024-08-15', '0000-00-00 00:00:00', 'Pending', ''),
(42, 163, 'Diagnosis', '158', '2024-08-14', '0000-00-00 00:00:00', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `questionnaire_doc` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `title`, `description`, `questionnaire_doc`, `comment`) VALUES
(1, 'Test', 'Test', 'uploads/Cover_letter.pdf', 'Test Data'),
(9, 'New Test', 'Test me', 'uploads/Software Security Group F.pdf', 'Hello'),
(10, 'Word', 'word', 'uploads/Cover letter.docx', 'test'),
(11, 'sd', 'ff', 'uploads/coverletter.pdf', 'df'),
(12, 'sd', 'ff', 'uploads/coverletter.pdf', 'df'),
(13, ',,jjj', 'jjj', 'uploads/Software Security Group F.pdf', 'kk'),
(14, ',,jjj', 'jjj', 'uploads/Software Security Group F.pdf', 'kk'),
(15, 'Test', 'Test', 'uploads/Cover_letter.pdf', 'My test'),
(16, 'testr', 'rr', 'uploads/RWABUHUNGU Callixte.docx', 'wwww'),
(17, 'testr', 'rr', 'uploads/RWABUHUNGU Callixte.docx', 'wwww'),
(18, 'dsdd', 'sdds', 'uploads/Shema_CV_N.docx', 'ddd'),
(19, 'dsdd', 'sdds', 'uploads/Shema_CV_N.docx', 'ddd'),
(20, 'trtr', 'trt', 'uploads/Cover letter.docx', 'trrtt'),
(21, 'uploads/Cover letter.docx', 'sss', 'account/downloads/Cover letter.docx', 'ss'),
(22, 'sss', 'sss', 'account/downloads/Cover letter.docx', 'ss'),
(23, 'rre', 'rfed', 'account/downloads/Cover letter.docx', 'fdfd');

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `child_id` int(11) NOT NULL,
  `father_id` int(11) DEFAULT NULL,
  `mother_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `join_date` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `weight` text DEFAULT NULL,
  `birth_certificate` text DEFAULT NULL,
  `vaccinations` text NOT NULL,
  `last_updated` date DEFAULT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`child_id`, `father_id`, `mother_id`, `full_name`, `date_of_birth`, `join_date`, `gender`, `weight`, `birth_certificate`, `vaccinations`, `last_updated`, `status`) VALUES
(108, NULL, NULL, 'Akaliza Hope', '2021-07-06', '2024-08-12', 'Female', '20', '', '', '2024-08-12', 'Incomplete'),
(109, 153, 153, 'karangwa Joan', '2020-09-10', '2024-08-12', 'Male', '12', '', '', '2024-08-12', 'Incomplete'),
(110, 154, 155, 'Ingabire Lilian', '2020-07-09', '2024-08-12', 'Female', '20', 'f549a20866cd880ab8e61c36cbb2046113214041_coverletter.pdf', '', '2024-08-13', 'Incomplete'),
(111, 156, 157, 'Akarabo Beatrice ', '2020-12-30', '2024-08-19', 'Female', '12', 'c8cddb719c8a51c04d61c2967d0d58f8abcd447c_Cover letter.pdf', '', '2024-08-13', 'Incomplete'),
(112, 159, 160, 'fdg', '2024-08-01', '2024-07-29', 'Male', '18', '36819af6b7b102874599cb292c267e3a701032e8_Cover_letter.pdf', '', '2024-08-13', 'Incomplete'),
(113, 161, 162, 'Akarabo Bea', '2024-07-31', '2024-08-21', 'Male', '14', 'd5cdc299c8fe9c25f4695ce9d5e2ed6fee578023_Cover_letter.pdf', '', '2024-08-13', 'Complete'),
(114, 163, 164, 'Irakoze Belise', '2019-07-10', '2024-08-14', 'Female', '10', '6c0308f85345cac2bbab31a667f1e95860ec5824_Cover letter.pdf', '', '2024-08-14', 'Complete'),
(115, 165, 166, 'Akarabo Beatrice', '2019-05-09', '2024-08-14', 'Male', '18', '7c745b71b5603248164317595748efbe40263627_Cover_letter.pdf', '', '2024-08-14', 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `childnutritionlog`
--

CREATE TABLE `childnutritionlog` (
  `log_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `nutrition_id` int(11) DEFAULT NULL,
  `intake_amount` float DEFAULT NULL,
  `intake_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `child_growth`
--

CREATE TABLE `child_growth` (
  `child_growth_id` int(11) NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `health_info_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `picture` binary(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comparison`
--

CREATE TABLE `comparison` (
  `id` int(11) NOT NULL,
  `child_age` int(11) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `growth` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comparison`
--

INSERT INTO `comparison` (`id`, `child_age`, `weight`, `height`, `growth`) VALUES
(230, 24, 12, 85, NULL),
(231, 25, 12.2, 86, NULL),
(232, 26, 12.4, 87, NULL),
(233, 27, 12.6, 88, NULL),
(234, 28, 12.8, 89, NULL),
(235, 29, 13, 90, NULL),
(236, 30, 13.2, 91, NULL),
(237, 31, 13.4, 92, NULL),
(238, 32, 13.6, 93, NULL),
(239, 33, 13.8, 94, NULL),
(240, 34, 14, 95, NULL),
(241, 35, 14.2, 96, NULL),
(242, 36, 14.4, 97, NULL),
(243, 37, 14.6, 98, NULL),
(244, 38, 14.8, 99, NULL),
(245, 39, 15, 100, NULL),
(246, 40, 15.2, 101, NULL),
(247, 41, 15.4, 102, NULL),
(248, 42, 15.6, 103, NULL),
(249, 43, 15.8, 104, NULL),
(250, 44, 16, 105, NULL),
(251, 45, 16.2, 106, NULL),
(252, 46, 16.4, 107, NULL),
(253, 47, 16.6, 108, NULL),
(254, 48, 16.8, 109, NULL),
(255, 49, 17, 110, NULL),
(256, 50, 17.2, 111, NULL),
(257, 51, 17.4, 112, NULL),
(258, 52, 17.6, 113, NULL),
(259, 53, 17.8, 114, NULL),
(260, 54, 18, 115, NULL),
(261, 55, 18.2, 116, NULL),
(262, 56, 18.4, 117, NULL),
(263, 57, 18.6, 118, NULL),
(264, 58, 18.8, 119, NULL),
(265, 59, 19, 120, NULL),
(266, 60, 19.2, 121, NULL),
(267, 61, 19.4, 122, NULL),
(268, 62, 19.6, 123, NULL),
(269, 63, 19.8, 124, NULL),
(270, 64, 20, 125, NULL),
(271, 65, 20.2, 126, NULL),
(272, 66, 20.4, 127, NULL),
(273, 67, 20.6, 128, NULL),
(274, 68, 20.8, 129, NULL),
(275, 69, 21, 130, NULL),
(276, 70, 21.2, 131, NULL),
(277, 71, 21.4, 132, NULL),
(278, 72, 21.6, 133, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `health_info`
--

CREATE TABLE `health_info` (
  `health_info_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `basic_info` varchar(255) DEFAULT NULL,
  `height` decimal(10,0) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `bmi` decimal(10,0) DEFAULT NULL,
  `bmi_status` varchar(255) DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `health_info_doc` text DEFAULT NULL,
  `nutrition_info` varchar(255) DEFAULT NULL,
  `Condition` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_info`
--

INSERT INTO `health_info` (`health_info_id`, `child_id`, `basic_info`, `height`, `weight`, `bmi`, `bmi_status`, `record_date`, `health_info_doc`, `nutrition_info`, `Condition`) VALUES
(1, 88, NULL, 20, 33, 825, 'Obese', '2024-07-28', NULL, 'Micronu', 'Worst'),
(2, 89, NULL, 110, 12, 10, 'Underweight', '2024-07-30', NULL, 'Micronu', 'Worst'),
(3, 90, NULL, 20, 12, 300, 'Obese', '2024-07-31', NULL, 'Micro', 'Worst'),
(4, 91, NULL, 110, 42, 35, 'Obese', '2024-08-06', NULL, 'ddd', 'Worst'),
(5, 92, NULL, 100, 31, 31, 'Obese', '2024-08-06', NULL, 'ffd', 'Worst'),
(13, 99, NULL, 22, 33, 682, 'Obese', '2024-08-06', NULL, 'dff', 'Worst'),
(14, 100, NULL, 33, 3, 28, 'Overweight', '2024-08-06', NULL, 'ddd', 'Bad'),
(15, 102, NULL, 100, 20, 20, 'Normal weight', '2024-08-07', NULL, 'dsd', 'Good'),
(16, 101, NULL, 100, 25, 25, 'Overweight', '2024-08-10', NULL, 'Test', 'Bad'),
(17, 103, NULL, 102, 40, 38, 'Obese', '2024-08-10', NULL, 'Obese Food', 'Worst'),
(18, 104, NULL, 98, 12, 12, 'Underweight', '2024-08-10', NULL, 'Micro', 'Worst'),
(19, 0, NULL, 108, 15, 13, 'Underweight', '2024-08-13', NULL, 'ss', 'Worst'),
(20, 111, NULL, 33, 33, 303, 'Obese', '2024-08-13', 'coverletter.pdf', 'ddd', 'Worst'),
(21, 110, NULL, 33, 3, 28, 'Overweight', '2024-08-13', NULL, 'ddd', 'Bad'),
(22, 0, NULL, 34, 4, 35, 'Obese', '2024-08-13', '', 'ffd', 'Worst'),
(23, 0, NULL, 12, 2, 139, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(24, 0, NULL, 12, 2, 139, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(25, 0, NULL, 44, 4, 21, 'Normal weight', '2024-08-13', '', 'tet', 'Good'),
(26, 0, NULL, 66, 6, 14, 'Underweight', '2024-08-13', 'coverletter.pdf', 'test', 'Worst'),
(27, 0, NULL, 122, 88, 59, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(28, 112, NULL, 88, 88, 114, 'Obese', '2024-08-13', 'coverletter.pdf', 'hj', 'Worst'),
(29, 112, NULL, 11, 11, 909, 'Obese', '2024-08-13', '', 'testing', 'Worst'),
(30, 112, NULL, 56, 55, 175, 'Obese', '2024-08-13', '', 'testingjj', 'Worst'),
(31, 0, NULL, 88, 88, 114, 'Obese', '2024-08-13', '', 'yu', 'Worst'),
(32, 0, NULL, 22, 22, 0, '', '0000-00-00', 'Cover letter.pdf', 'ffd', ''),
(33, 0, NULL, 12, 22, 1528, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(34, 0, NULL, 12, 22, 1528, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(35, 0, NULL, 33, 33, 303, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(36, 0, NULL, 33, 33, 303, 'Obese', '2024-08-13', '', 'ddd', 'Worst'),
(37, 113, NULL, 22, 22, 455, 'Obese', '2024-08-13', 'Cover letter.pdf', 'ddd', 'Worst'),
(38, 114, NULL, 100, 14, 14, 'Underweight', '2024-08-14', 'coverletter.pdf', 'test', 'Worst'),
(39, 115, NULL, 12, 12, 833, 'Obese', '2024-08-14', NULL, 'ddd', 'Worst');

-- --------------------------------------------------------

--
-- Table structure for table `health_info_archive`
--

CREATE TABLE `health_info_archive` (
  `archive_id` int(11) NOT NULL,
  `health_info_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `basic_info` varchar(255) DEFAULT NULL,
  `height` decimal(10,0) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `bmi` decimal(10,0) DEFAULT NULL,
  `bmi_status` varchar(255) DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `health_info_doc` text DEFAULT NULL,
  `nutrition_info` varchar(255) DEFAULT NULL,
  `Condition` varchar(16) NOT NULL,
  `archive_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_info_archive`
--

INSERT INTO `health_info_archive` (`archive_id`, `health_info_id`, `child_id`, `basic_info`, `height`, `weight`, `bmi`, `bmi_status`, `record_date`, `health_info_doc`, `nutrition_info`, `Condition`, `archive_date`) VALUES
(1, 5, 92, 'Basic info for Jan', 90, 12, 15, 'Underweight', '2023-01-01', 'Doc for Jan', 'Needs more calories', 'Healthy', '2023-01-31'),
(2, 5, 92, 'Basic info for Feb', 92, 14, 16, 'Normal', '2023-02-01', 'Doc for Feb', 'Balanced diet', 'Healthy', '2023-02-28'),
(3, 5, 92, 'Basic info for Mar', 94, 16, 18, 'Normal', '2023-03-01', 'Doc for Mar', 'Balanced diet', 'Healthy', '2023-03-31'),
(4, 5, 92, 'Basic info for Apr', 96, 18, 20, 'Overweight', '2023-04-01', 'Doc for Apr', 'Monitor diet', 'Healthy', '2023-04-30'),
(5, 5, 92, 'Basic info for May', 98, 20, 21, 'Overweight', '2023-05-01', 'Doc for May', 'Monitor diet', 'Healthy', '2023-05-31'),
(6, 5, 92, 'Basic info for Jun', 100, 22, 22, 'Obese', '2023-06-01', 'Doc for Jun', 'Reduce calories', 'Healthy', '2023-06-30'),
(7, 5, 92, 'Basic info for Jul', 102, 24, 23, 'Obese', '2023-07-01', 'Doc for Jul', 'Reduce calories', 'Healthy', '2023-07-31'),
(8, 5, 92, 'Basic info for Aug', 104, 16, 15, 'Underweight', '2023-08-01', 'Doc for Aug', 'Needs more calories', 'Healthy', '2023-08-31'),
(9, 5, 92, 'Basic info for Sep', 106, 18, 16, 'Normal', '2023-09-01', 'Doc for Sep', 'Balanced diet', 'Healthy', '2023-09-30'),
(10, 5, 92, 'Basic info for Oct', 108, 20, 17, 'Normal', '2023-10-01', 'Doc for Oct', 'Balanced diet', 'Healthy', '2023-10-31'),
(11, 5, 92, 'Basic info for Nov', 110, 22, 18, 'Normal', '2023-11-01', 'Doc for Nov', 'Balanced diet', 'Healthy', '2023-11-30'),
(12, 5, 92, 'Basic info for Dec', 112, 24, 19, 'Overweight', '2023-12-01', 'Doc for Dec', 'Monitor diet', 'Healthy', '2023-12-31'),
(103, 1, 88, 'Basic Info January', 110, 10, 10, 'Underweight', '2024-01-15', 'doc_jan.pdf', 'Jan', 'Underweight', '2024-01-01'),
(104, 1, 88, 'Basic Info February', 115, 12, 12, 'Normal weight', '2024-02-15', 'doc_feb.pdf', 'Feb', 'Normal weight', '2024-02-01'),
(105, 1, 88, 'Basic Info March', 120, 14, 14, 'Overweight', '2024-03-15', 'doc_mar.pdf', 'Mar', 'Overweight', '2024-03-01'),
(106, 1, 88, 'Basic Info April', 125, 16, 16, 'Obese', '2024-04-15', 'doc_apr.pdf', 'Apr', 'Obese', '2024-04-01'),
(107, 1, 88, 'Basic Info May', 130, 18, 18, 'Obese', '2024-05-15', 'doc_may.pdf', 'May', 'Obese', '2024-05-01'),
(108, 1, 88, 'Basic Info June', 135, 20, 20, 'Obese', '2024-06-15', 'doc_jun.pdf', 'June', 'Obese', '2024-06-01'),
(109, 38, 114, NULL, 102, 18, 14, 'Normal Weight', '2024-06-02', NULL, NULL, 'Worst', '2024-06-02'),
(110, 38, 114, NULL, 105, 19, 18, 'Overweight', '2024-07-02', NULL, NULL, 'Bad', '2024-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `nutrition`
--

CREATE TABLE `nutrition` (
  `id` int(11) NOT NULL,
  `age_group` varchar(10) DEFAULT NULL,
  `bmi_category` varchar(20) DEFAULT NULL,
  `calories` varchar(20) DEFAULT NULL,
  `protein` varchar(10) DEFAULT NULL,
  `fat` varchar(20) DEFAULT NULL,
  `carbohydrates` varchar(20) DEFAULT NULL,
  `recipes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recipes`)),
  `meal_plans` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meal_plans`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition`
--

INSERT INTO `nutrition` (`id`, `age_group`, `bmi_category`, `calories`, `protein`, `fat`, `carbohydrates`, `recipes`, `meal_plans`) VALUES
(1, '1-3', 'Underweight', '1400-1600', '15g', '35-45g', '140g', '{\"recipes\":[{\"name\":\"Banana Smoothie\",\"ingredients\":[\"Banana\",\"Whole Milk\",\"Honey\"],\"instructions\":\"Blend banana, milk, and honey until smooth.\"},{\"name\":\"Peanut Butter Oatmeal\",\"ingredients\":[\"Oats\",\"Peanut Butter\",\"Milk\"],\"instructions\":\"Cook oats in milk and stir in peanut butter.\"},{\"name\":\"Pap (Maize Porridge)\",\"ingredients\":[\"Maize Meal\",\"Water\",\"Milk\",\"Sugar\"],\"instructions\":\"Cook maize meal in water, add milk and sugar to taste.\"}]}', '{\"meal_plans\":{\"Breakfast\":\"Oatmeal with banana and milk\",\"Lunch\":\"Peanut butter sandwich with apple slices\",\"Dinner\":\"Chicken stew with vegetables\",\"Snacks\":[\"Yogurt with berries\",\"Cheese and crackers\"]}}'),
(2, '1-3', 'Underweight', '1400-1600', '15g', '35-45g', '140g', '[{\"name\":\"Banana Smoothie\",\"ingredients\":[\"Banana\",\"Whole Milk\",\"Honey\"],\"instructions\":\"Blend banana, milk, and honey until smooth.\"},{\"name\":\"Peanut Butter Oatmeal\",\"ingredients\":[\"Oats\",\"Peanut Butter\",\"Milk\"],\"instructions\":\"Cook oats in milk and stir in peanut butter.\"},{\"name\":\"Pap (Maize Porridge)\",\"ingredients\":[\"Maize Meal\",\"Water\",\"Milk\",\"Sugar\"],\"instructions\":\"Cook maize meal in water, add milk and sugar to taste.\"}]', '{\"Breakfast\":\"Oatmeal with banana and milk\",\"Lunch\":\"Peanut butter sandwich with apple slices\",\"Dinner\":\"Chicken stew with vegetables\",\"Snacks\":[\"Yogurt with berries\",\"Cheese and crackers\"]}'),
(3, '1-3', 'Normal weight', '1000-1400', '13g', '30-40g', '130g', '[{\"name\":\"Apple Slices with Peanut Butter\",\"ingredients\":[\"Apple\",\"Peanut Butter\"],\"instructions\":\"Slice the apple and spread peanut butter on each slice.\"},{\"name\":\"Cheese and Crackers\",\"ingredients\":[\"Cheese\",\"Whole Grain Crackers\"],\"instructions\":\"Serve cheese slices with whole grain crackers.\"},{\"name\":\"Baked Sweet Potato\",\"ingredients\":[\"Sweet Potato\",\"Butter\",\"Honey\"],\"instructions\":\"Bake sweet potato and top with butter and honey.\"}]', '{\"Breakfast\":\"Whole grain cereal with milk\",\"Lunch\":\"Turkey and cheese sandwich with carrot sticks\",\"Dinner\":\"Spaghetti with tomato sauce and a side salad\",\"Snacks\":[\"Apple slices with peanut butter\",\"Yogurt with granola\"]}'),
(4, '4-8', 'Underweight', '1800-2000', '20g', '50-60g', '160g', '[{\"name\":\"Yogurt and Fruit Parfait\",\"ingredients\":[\"Greek Yogurt\",\"Granola\",\"Mixed Berries\"],\"instructions\":\"Layer yogurt, granola, and berries in a cup.\"},{\"name\":\"Chicken and Veggie Wrap\",\"ingredients\":[\"Whole Wheat Tortilla\",\"Chicken Breast\",\"Mixed Vegetables\"],\"instructions\":\"Fill the tortilla with chicken and vegetables, then wrap.\"},{\"name\":\"Jollof Rice\",\"ingredients\":[\"Rice\",\"Tomatoes\",\"Onions\",\"Peppers\",\"Chicken\"],\"instructions\":\"Cook rice with tomatoes, onions, peppers, and chicken.\"}]', '{\"Breakfast\":\"Scrambled eggs with toast and fruit\",\"Lunch\":\"Chicken and veggie wrap\",\"Dinner\":\"Grilled fish with quinoa and vegetables\",\"Snacks\":[\"Smoothie with yogurt and fruit\",\"Trail mix\"]}'),
(5, '4-8', 'Normal weight', '1200-1800', '19g', '40-55g', '130g', '[{\"name\":\"Veggie Wrap\",\"ingredients\":[\"Whole Wheat Tortilla\",\"Hummus\",\"Cucumber\",\"Carrots\",\"Lettuce\"],\"instructions\":\"Spread hummus on the tortilla, add veggies, and wrap.\"},{\"name\":\"Yogurt Parfait\",\"ingredients\":[\"Greek Yogurt\",\"Granola\",\"Mixed Berries\"],\"instructions\":\"Layer yogurt, granola, and berries in a cup.\"},{\"name\":\"Ugali with Sukuma Wiki\",\"ingredients\":[\"Maize Flour\",\"Water\",\"Kale\",\"Onions\",\"Tomatoes\"],\"instructions\":\"Cook maize flour into a stiff porridge (ugali) and serve with kale cooked with onions and tomatoes.\"}]', '{\"Breakfast\":\"Yogurt parfait with granola and berries\",\"Lunch\":\"Veggie wrap with hummus\",\"Dinner\":\"Stir-fried tofu with brown rice and vegetables\",\"Snacks\":[\"Fruit salad\",\"Cheese and crackers\"]}'),
(6, '1-3', 'Overweight', '900-1100', '13g', '25-35g', '120g', '[{\"name\":\"Blueberry Smoothie\",\"ingredients\":[\"Blueberries\",\"Yogurt\",\"Honey\"],\"instructions\":\"Blend blueberries, yogurt, and honey until smooth.\"},{\"name\":\"Vegetable Omelette\",\"ingredients\":[\"Eggs\",\"Mixed Vegetables\",\"Cheese\"],\"instructions\":\"Whisk eggs, pour over mixed vegetables in a pan, add cheese, and cook until set.\"},{\"name\":\"Pasta with Tomato Sauce\",\"ingredients\":[\"Pasta\",\"Tomato Sauce\",\"Parmesan Cheese\"],\"instructions\":\"Cook pasta, toss with tomato sauce, and sprinkle with Parmesan cheese.\"}]', '{\"Breakfast\":\"Cereal with milk and fruit\",\"Lunch\":\"Grilled cheese sandwich with vegetable sticks\",\"Dinner\":\"Baked chicken with sweet potato and green beans\",\"Snacks\":[\"Smoothie with yogurt and fruit\",\"Vegetable sticks with hummus\"]}'),
(7, '1-3', 'Obese', '800-1000', '13g', '20-30g', '110g', '[{\"name\":\"Mango Lassi\",\"ingredients\":[\"Mango\",\"Yogurt\",\"Cardamom\"],\"instructions\":\"Blend mango, yogurt, and cardamom until smooth.\"},{\"name\":\"Quinoa Salad\",\"ingredients\":[\"Quinoa\",\"Mixed Vegetables\",\"Lemon Dressing\"],\"instructions\":\"Cook quinoa, toss with mixed vegetables, and drizzle with lemon dressing.\"},{\"name\":\"Grilled Chicken with Steamed Vegetables\",\"ingredients\":[\"Chicken Breast\",\"Mixed Vegetables\",\"Olive Oil\"],\"instructions\":\"Grill chicken breast, serve with steamed vegetables drizzled with olive oil.\"}]', '{\"Breakfast\":\"Fruit smoothie with yogurt\",\"Lunch\":\"Turkey wrap with whole grain tortilla\",\"Dinner\":\"Salmon with quinoa and roasted vegetables\",\"Snacks\":[\"Greek yogurt with berries\",\"Mixed nuts\"]}'),
(8, '4-8', 'Overweight', '1100-1400', '19g', '35-50g', '120g', '[{\"name\":\"Fruit and Yogurt Bowl\",\"ingredients\":[\"Greek Yogurt\",\"Mixed Berries\",\"Granola\"],\"instructions\":\"Layer Greek yogurt, mixed berries, and granola in a bowl.\"},{\"name\":\"Turkey and Avocado Wrap\",\"ingredients\":[\"Whole Wheat Tortilla\",\"Turkey Breast\",\"Avocado\",\"Lettuce\"],\"instructions\":\"Fill tortilla with turkey, avocado, and lettuce, then wrap.\"},{\"name\":\"Vegetable Stir-Fry with Brown Rice\",\"ingredients\":[\"Mixed Vegetables\",\"Brown Rice\",\"Soy Sauce\"],\"instructions\":\"Stir-fry mixed vegetables, serve with brown rice and soy sauce.\"}]', '{\"Breakfast\":\"Smoothie with yogurt and fruit\",\"Lunch\":\"Turkey and avocado wrap\",\"Dinner\":\"Vegetable stir-fry with brown rice\",\"Snacks\":[\"Yogurt with berries\",\"Trail mix\"]}'),
(9, '4-8', 'Obese', '1000-1300', '19g', '30-45g', '110g', '[{\"name\":\"Chia Seed Pudding\",\"ingredients\":[\"Chia Seeds\",\"Almond Milk\",\"Honey\"],\"instructions\":\"Mix chia seeds with almond milk and honey, let sit until thickened.\"},{\"name\":\"Turkey and Vegetable Skewers\",\"ingredients\":[\"Turkey Breast\",\"Bell Peppers\",\"Onions\",\"Zucchini\"],\"instructions\":\"Thread turkey, bell peppers, onions, and zucchini onto skewers, grill until cooked through.\"},{\"name\":\"Quinoa Stuffed Bell Peppers\",\"ingredients\":[\"Quinoa\",\"Bell Peppers\",\"Black Beans\",\"Corn\",\"Tomato Sauce\"],\"instructions\":\"Cook quinoa, mix with black beans, corn, and tomato sauce, stuff into bell peppers and bake.\"}]', '{\"Breakfast\":\"Chia seed pudding with almond milk\",\"Lunch\":\"Turkey and vegetable skewers\",\"Dinner\":\"Quinoa stuffed bell peppers\",\"Snacks\":[\"Greek yogurt with fruit\",\"Mixed nuts\"]}'),
(10, '1-3', 'Underweight', '1400-1600', '15g', '35-45g', '140g', '[{\"name\":\"Banana Smoothie\",\"ingredients\":[\"Banana\",\"Whole Milk\",\"Honey\"],\"instructions\":\"Blend banana, milk, and honey until smooth.\"},{\"name\":\"Peanut Butter Oatmeal\",\"ingredients\":[\"Oats\",\"Peanut Butter\",\"Milk\"],\"instructions\":\"Cook oats in milk and stir in peanut butter.\"},{\"name\":\"Pap (Maize Porridge)\",\"ingredients\":[\"Maize Meal\",\"Water\",\"Milk\",\"Sugar\"],\"instructions\":\"Cook maize meal in water, add milk and sugar to taste.\"}]', '{\"Breakfast\":\"Oatmeal with banana and milk\",\"Lunch\":\"Peanut butter sandwich with apple slices\",\"Dinner\":\"Chicken stew with vegetables\",\"Snacks\":[\"Yogurt with berries\",\"Cheese and crackers\"]}'),
(38, '3-4', 'Underweight', '11', '222', NULL, NULL, NULL, '{\"plan\":\"Avocado\"}'),
(39, '1-3', 'Underweight', '222', '22', NULL, NULL, NULL, '{\"plan\":\"Fish\"}'),
(40, '3-4', 'Underweight', '233', '223', NULL, NULL, NULL, '{\"plan\":\"test meal\"}'),
(41, '', '', '', '', NULL, NULL, NULL, '{\"plan\":null}'),
(42, '', '', '', '', NULL, NULL, NULL, '{\"plan\":null}'),
(43, '', '', '', '', NULL, NULL, NULL, '{\"plan\":null}'),
(44, '', '', '', '', NULL, NULL, NULL, '{\"plan\":null}'),
(45, '1-3', 'Underweight', '22', '555', NULL, NULL, NULL, '{\"plan\":\"My meal\"}'),
(46, '3-4', 'Normal weight', '233', '333', NULL, NULL, NULL, '{\"plan\":\"Annette meal\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` text DEFAULT NULL,
  `nid` varchar(16) DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `phone`, `email`, `password`, `nid`, `gender`, `role`, `token`, `status`) VALUES
(153, 'Murangwa', 'Felix', '0787493843', 'vierrashema@gmail.com', 'fede185a3aa1a6c363354d0ee89a0993baf58e12', '', 'Male', 'Parent', '69a2d8bbbab1fd008908199c26d1d4697244cd30', 'Incomplete'),
(154, 'Mugabo', 'Patrick', '0783293865', 'vierrashema@gmail.com', 'be98fbb5fef1a2a7ce8be317fcbce6b1912024c3', '', 'Female', 'Parent', 'c3bd165688da5edd823629a31c8fe933680fd108', 'Incomplete'),
(155, 'Akarabo', 'Divine', '07874912835', 'vierra1998s@gmail.com', 'be98fbb5fef1a2a7ce8be317fcbce6b1912024c3', '', 'Female', 'Parent', 'c3bd165688da5edd823629a31c8fe933680fd108', 'Incomplete'),
(156, 'Kalisa', 'Jean', '0787493865', 'vierrashema@gmail.com', '772082eb47a71ed249818a9c135bf6f15c16e0d2', '', 'Female', 'Parent', '6c3ed1d27b8a822a66dba5180837cda77c5e445f', 'Incomplete'),
(157, 'Isimbi', 'Carine', '0787489865', 'vierra1998s@gmail.com', '772082eb47a71ed249818a9c135bf6f15c16e0d2', '', 'Female', 'Parent', '6c3ed1d27b8a822a66dba5180837cda77c5e445f', 'Incomplete'),
(159, 'fdxfgd', '', '0787493865', 'vierrashema@gmail.com', 'e2d07b1d6cd4179ae1c3846696a16cd8bdc955cf', '', 'Male', 'Parent', '10f7dc04dbe355103c12bdec4a37afa9ce91099c', 'Incomplete'),
(160, 'fdg', '', '0787489865', 'vierra1998s@gmail.com', 'e2d07b1d6cd4179ae1c3846696a16cd8bdc955cf', '', 'Male', 'Parent', '10f7dc04dbe355103c12bdec4a37afa9ce91099c', 'Incomplete'),
(161, 'Kalisa', 'JC', '0787493865', 'vierrashema@gmail.com', 'ceadf1477c311cc88d28067c4bbc5cfc5bf22387', '', 'Male', 'Parent', '2fcbeb757401d9de839b16edb8c1251e882f25a9', 'Incomplete'),
(162, 'Isimbi', 'Chance', '0787489865', 'vierra1998s@gmail.com', 'ceadf1477c311cc88d28067c4bbc5cfc5bf22387', '', 'Male', 'Parent', '2fcbeb757401d9de839b16edb8c1251e882f25a9', 'Incomplete'),
(163, 'Muhoza', 'Fred', '0787302346', 'vierrashema@gmail.com', 'ab0a3877027e5536ceb6b1fef6a9ee550ee4689e', '', 'Female', 'Parent', 'dabc56a51f6294ad62b3b0c485e605f3bdd63ccd', 'Incomplete'),
(164, 'Uwineza', 'Nadine', '0788903299', 'vierra1998s@gmail.com', 'ab0a3877027e5536ceb6b1fef6a9ee550ee4689e', '', 'Female', 'Parent', 'dabc56a51f6294ad62b3b0c485e605f3bdd63ccd', 'Incomplete'),
(165, 'Kalisa', 'Jeangdfg', '0787493865', 'vierrashema@gmail.com', '85ca51916e72aafad09b20409bbc43d538f4d791', '', 'Male', 'Parent', '02b9caa2e1f8015b83c7fdc24dd9dd59b32e3f2e', 'Incomplete'),
(166, 'Isimbi', 'Chance', '0787489865', 'vierra1998s@gmail.com', '85ca51916e72aafad09b20409bbc43d538f4d791', '', 'Male', 'Parent', '02b9caa2e1f8015b83c7fdc24dd9dd59b32e3f2e', 'Incomplete');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `fk_father_user` (`father_id`),
  ADD KEY `fk_mother_user` (`mother_id`);

--
-- Indexes for table `childnutritionlog`
--
ALTER TABLE `childnutritionlog`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `child_growth`
--
ALTER TABLE `child_growth`
  ADD PRIMARY KEY (`child_growth_id`);

--
-- Indexes for table `comparison`
--
ALTER TABLE `comparison`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_info`
--
ALTER TABLE `health_info`
  ADD PRIMARY KEY (`health_info_id`);

--
-- Indexes for table `health_info_archive`
--
ALTER TABLE `health_info_archive`
  ADD PRIMARY KEY (`archive_id`),
  ADD KEY `health_info_id` (`health_info_id`);

--
-- Indexes for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `childnutritionlog`
--
ALTER TABLE `childnutritionlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comparison`
--
ALTER TABLE `comparison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `health_info`
--
ALTER TABLE `health_info`
  MODIFY `health_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `health_info_archive`
--
ALTER TABLE `health_info_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `child`
--
ALTER TABLE `child`
  ADD CONSTRAINT `fk_father_user` FOREIGN KEY (`father_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mother_user` FOREIGN KEY (`mother_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `health_info_archive`
--
ALTER TABLE `health_info_archive`
  ADD CONSTRAINT `health_info_archive_ibfk_1` FOREIGN KEY (`health_info_id`) REFERENCES `health_info` (`health_info_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
