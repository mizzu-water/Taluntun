-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2026 at 05:11 PM
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
-- Database: `riasec_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment_results`
--

CREATE TABLE `assessment_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`scores`)),
  `holland_code` varchar(10) NOT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessment_results`
--

INSERT INTO `assessment_results` (`id`, `user_id`, `scores`, `holland_code`, `taken_at`) VALUES
(3, 8, '{\"R\":49,\"I\":48,\"A\":50,\"S\":49,\"E\":44,\"C\":47}', 'ARS', '2026-10-01 05:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `profile_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `map_query` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`, `short_name`, `type`, `profile_url`, `image_url`, `address`, `latitude`, `longitude`, `map_query`) VALUES
(1, 'De La Salle University - Dasmariñas', 'DLSU-D', 'Private Sectarian', 'dlsu-profile.html', 'https://images.unsplash.com/photo-1607237138185-eedd9c632b0b?auto=format&fit=crop&w=600&q=80', NULL, NULL, NULL, NULL),
(2, 'Technological University of the Philippines', 'TUP', 'Public State U', 'tup-profile.html', 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80', NULL, NULL, NULL, NULL),
(3, 'Cavite State University', 'CvSU', 'Public State U', 'cvsu-profile.html', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=600&q=80', NULL, NULL, NULL, NULL),
(4, 'Emilio Aguinaldo College - Cavite', 'EAC-C', 'Private', 'eac-profile.html', 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80', NULL, NULL, NULL, NULL),
(5, 'National College of Science and Technology', 'NCST', 'Private', 'ncst-profile.html', 'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=600&q=80', NULL, NULL, NULL, NULL),
(6, 'Philippine Christian University', 'PCU', 'Private Sectarian', 'pcu-profile.html', 'https://images.unsplash.com/photo-1627556704302-624286467c65?auto=format&fit=crop&w=600&q=80', 'Sampaloc 1, Dasmariñas City, Cavite', NULL, NULL, 'Philippine Christian University Dasmarinas'),
(7, 'FEAPITSAT', 'FEAPITSAT', 'Private', 'school-profile?id=FEAPITSAT', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'FEAPITSAT, Dasmariñas, Cavite'),
(8, 'PHINMA St. Jude College Dasmariñas', 'PHINMA', 'Private', 'school-profile?id=PHINMA', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'PHINMA St. Jude College Dasmariñas, Dasmariñas, Cavite'),
(9, 'STI College', 'STI', 'Private', 'school-profile?id=STI', 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'STI College, Dasmariñas, Cavite'),
(10, 'Kolehiyo ng Lungsod ng Dasmariñas', 'KLD', 'Public', 'school-profile?id=KLD', 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'Kolehiyo ng Lungsod ng Dasmariñas, Dasmariñas, Cavite'),
(11, 'National University', 'NU', 'Private', 'school-profile?id=NU', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'National University, Dasmariñas, Cavite'),
(12, 'PNTC Colleges', 'PNTC', 'Private', 'school-profile?id=PNTC', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80', 'Dasmariñas City, Cavite', NULL, NULL, 'PNTC Colleges, Dasmariñas, Cavite');

-- --------------------------------------------------------

--
-- Table structure for table `college_degrees`
--

CREATE TABLE `college_degrees` (
  `college_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_degrees`
--

INSERT INTO `college_degrees` (`college_id`, `degree_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(1, 9),
(1, 10),
(1, 12),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 26),
(1, 27),
(1, 34),
(1, 35),
(1, 36),
(1, 41),
(1, 42),
(1, 43),
(1, 47),
(1, 48),
(2, 14),
(2, 15),
(2, 18),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(3, 1),
(3, 2),
(3, 4),
(3, 5),
(3, 6),
(3, 8),
(3, 9),
(3, 10),
(3, 12),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 26),
(3, 27),
(3, 28),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 46),
(3, 48),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 32),
(4, 33),
(4, 34),
(4, 35),
(4, 36),
(4, 37),
(4, 38),
(4, 39),
(4, 40),
(4, 44),
(4, 45),
(4, 48),
(5, 1),
(5, 2),
(5, 5),
(5, 6),
(5, 8),
(5, 9),
(5, 10),
(5, 15),
(5, 16),
(5, 17),
(5, 19),
(5, 35),
(5, 36),
(5, 37),
(6, 1),
(6, 2),
(6, 9),
(6, 10),
(6, 27),
(6, 34),
(6, 41),
(6, 42),
(6, 43),
(6, 44),
(6, 45),
(6, 46),
(7, 1),
(7, 15),
(7, 35),
(7, 36),
(7, 37),
(8, 1),
(8, 2),
(8, 15),
(8, 27),
(8, 28),
(8, 31),
(8, 32),
(8, 34),
(8, 35),
(8, 40),
(9, 1),
(9, 2),
(9, 3),
(9, 15),
(9, 16),
(9, 18),
(9, 35),
(9, 36),
(10, 1),
(10, 2),
(10, 5),
(10, 9),
(10, 10),
(10, 15),
(10, 34),
(10, 46),
(11, 1),
(11, 2),
(11, 15),
(11, 16),
(11, 19),
(11, 34),
(11, 35),
(11, 36),
(11, 41),
(11, 47),
(12, 1),
(12, 10),
(12, 15),
(12, 35),
(12, 38),
(12, 39),
(12, 40);

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `holland_code` varchar(10) DEFAULT NULL,
  `campuses_count` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `dasma_availability` varchar(50) DEFAULT 'Available in Dasma'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `title`, `description`, `holland_code`, `campuses_count`, `category`, `dasma_availability`) VALUES
(1, 'BS Business Administration (Marketing, Financial Management, HRM, Operations)', 'A degree program in BS Business Administration (Marketing, Financial Management, HRM, Operations) under the category of Business and management.', 'ESC', NULL, 'Business and management', 'Available in Dasma'),
(2, 'BS Accountancy', 'A degree program in BS Accountancy under the category of Business and management.', 'CE', NULL, 'Business and management', 'Available in Dasma'),
(3, 'BS Accounting Technology', 'A degree program in BS Accounting Technology under the category of Business and management.', 'CE', NULL, 'Business and management', 'Available in Dasma'),
(4, 'BS Management Accounting', 'A degree program in BS Management Accounting under the category of Business and management.', 'CE', NULL, 'Business and management', 'Available in Dasma'),
(5, 'BS Entrepreneurship', 'A degree program in BS Entrepreneurship under the category of Business and management.', 'E', NULL, 'Business and management', 'Available in Dasma'),
(6, 'BS Office Administration', 'A degree program in BS Office Administration under the category of Business and management.', 'C', NULL, 'Business and management', 'Available in Dasma'),
(7, 'BS Real Estate Management', 'A degree program in BS Real Estate Management under the category of Business and management.', 'EC', NULL, 'Business and management', 'Not Available in Dasma'),
(8, 'BS Customs Administration', 'A degree program in BS Customs Administration under the category of Business and management.', 'CE', NULL, 'Business and management', 'Available in Dasma'),
(9, 'Bachelor of Elementary Education (BEEd)', 'A degree program in Bachelor of Elementary Education (BEEd) under the category of Education.', 'S', NULL, 'Education', 'Available in Dasma'),
(10, 'Bachelor of Secondary Education (BSEd)', 'A degree program in Bachelor of Secondary Education (BSEd) under the category of Education.', 'S', NULL, 'Education', 'Available in Dasma'),
(11, 'Bachelor of Early Childhood Education', 'A degree program in Bachelor of Early Childhood Education under the category of Education.', 'S', NULL, 'Education', 'Not Available in Dasma'),
(12, 'Bachelor of Physical Education', 'A degree program in Bachelor of Physical Education under the category of Education.', 'SR', NULL, 'Education', 'Available in Dasma'),
(13, 'Bachelor of Special Needs Education', 'A degree program in Bachelor of Special Needs Education under the category of Education.', 'S', NULL, 'Education', 'Not Available in Dasma'),
(14, 'Bachelor of Technology and Livelihood Education', 'A degree program in Bachelor of Technology and Livelihood Education under the category of Education.', 'RS', NULL, 'Education', 'Available in Dasma'),
(15, 'BS Information Technology', 'A degree program in BS Information Technology under the category of IT and computing.', 'IC', NULL, 'IT and computing', 'Available in Dasma'),
(16, 'BS Computer Science', 'A degree program in BS Computer Science under the category of IT and computing.', 'IR', NULL, 'IT and computing', 'Available in Dasma'),
(17, 'BS Information Systems', 'A degree program in BS Information Systems under the category of IT and computing.', 'IC', NULL, 'IT and computing', 'Available in Dasma'),
(18, 'BS Computer Engineering', 'A degree program in BS Computer Engineering under the category of IT and computing.', 'RI', NULL, 'IT and computing', 'Available in Dasma'),
(19, 'BS Entertainment and Multimedia Computing', 'A degree program in BS Entertainment and Multimedia Computing under the category of IT and computing.', 'AI', NULL, 'IT and computing', 'Available in Dasma'),
(20, 'BS Civil Engineering', 'A degree program in BS Civil Engineering under the category of Engineering and architecture.', 'RI', NULL, 'Engineering and architecture', 'Available in Dasma'),
(21, 'BS Electrical Engineering', 'A degree program in BS Electrical Engineering under the category of Engineering and architecture.', 'RI', NULL, 'Engineering and architecture', 'Available in Dasma'),
(22, 'BS Mechanical Engineering', 'A degree program in BS Mechanical Engineering under the category of Engineering and architecture.', 'RI', NULL, 'Engineering and architecture', 'Available in Dasma'),
(23, 'BS Electronics Engineering', 'A degree program in BS Electronics Engineering under the category of Engineering and architecture.', 'RI', NULL, 'Engineering and architecture', 'Available in Dasma'),
(24, 'BS Industrial Engineering', 'A degree program in BS Industrial Engineering under the category of Engineering and architecture.', 'IE', NULL, 'Engineering and architecture', 'Available in Dasma'),
(25, 'BS Chemical Engineering', 'A degree program in BS Chemical Engineering under the category of Engineering and architecture.', 'IR', NULL, 'Engineering and architecture', 'Not Available in Dasma'),
(26, 'BS Architecture', 'A degree program in BS Architecture under the category of Engineering and architecture.', 'AR', NULL, 'Engineering and architecture', 'Available in Dasma'),
(27, 'BS Nursing', 'A degree program in BS Nursing under the category of Health and medical.', 'SI', NULL, 'Health and medical', 'Available in Dasma'),
(28, 'BS Midwifery', 'A degree program in BS Midwifery under the category of Health and medical.', 'S', NULL, 'Health and medical', 'Available in Dasma'),
(29, 'BS Pharmacy', 'A degree program in BS Pharmacy under the category of Health and medical.', 'IS', NULL, 'Health and medical', 'Available in Dasma'),
(30, 'BS Physical Therapy', 'A degree program in BS Physical Therapy under the category of Health and medical.', 'SR', NULL, 'Health and medical', 'Available in Dasma'),
(31, 'BS Medical Technology', 'A degree program in BS Medical Technology under the category of Health and medical.', 'IR', NULL, 'Health and medical', 'Available in Dasma'),
(32, 'BS Radiologic Technology', 'A degree program in BS Radiologic Technology under the category of Health and medical.', 'IR', NULL, 'Health and medical', 'Available in Dasma'),
(33, 'BS Nutrition and Dietetics', 'A degree program in BS Nutrition and Dietetics under the category of Health and medical.', 'SI', NULL, 'Health and medical', 'Available in Dasma'),
(34, 'BS Psychology', 'A degree program in BS Psychology under the category of Health and medical.', 'SI', NULL, 'Health and medical', 'Available in Dasma'),
(35, 'BS Hospitality Management', 'A degree program in BS Hospitality Management under the category of Hospitality and tourism.', 'ES', NULL, 'Hospitality and tourism', 'Available in Dasma'),
(36, 'BS Tourism Management', 'A degree program in BS Tourism Management under the category of Hospitality and tourism.', 'ES', NULL, 'Hospitality and tourism', 'Available in Dasma'),
(37, 'BS Hotel and Restaurant Management', 'A degree program in BS Hotel and Restaurant Management under the category of Hospitality and tourism.', 'ES', NULL, 'Hospitality and tourism', 'Available in Dasma'),
(38, 'BS Marine Transportation', 'A degree program in BS Marine Transportation under the category of Maritime and transport.', 'RE', NULL, 'Maritime and transport', 'Available in Dasma'),
(39, 'BS Marine Engineering', 'A degree program in BS Marine Engineering under the category of Maritime and transport.', 'RI', NULL, 'Maritime and transport', 'Available in Dasma'),
(40, 'BS Criminology', 'A degree program in BS Criminology under the category of Maritime and transport.', 'RE', NULL, 'Maritime and transport', 'Available in Dasma'),
(41, 'AB Communication', 'A degree program in AB Communication under the category of Arts, social sciences and communication.', 'A', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(42, 'AB Political Science', 'A degree program in AB Political Science under the category of Arts, social sciences and communication.', 'SE', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(43, 'AB English', 'A degree program in AB English under the category of Arts, social sciences and communication.', 'A', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(44, 'BS Social Work', 'A degree program in BS Social Work under the category of Arts, social sciences and communication.', 'S', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(45, 'AB Journalism', 'A degree program in AB Journalism under the category of Arts, social sciences and communication.', 'A', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(46, 'BS Public Administration', 'A degree program in BS Public Administration under the category of Arts, social sciences and communication.', 'EC', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(47, 'Bachelor of Multimedia Arts', 'A degree program in Bachelor of Multimedia Arts under the category of Arts, social sciences and communication.', 'A', NULL, 'Arts, social sciences and communication', 'Available in Dasma'),
(48, 'BS Biology', 'A degree program in BS Biology under the category of Sciences and agriculture.', 'I', NULL, 'Sciences and agriculture', 'Available in Dasma'),
(49, 'BS Agriculture', 'A degree program in BS Agriculture under the category of Sciences and agriculture.', 'R', NULL, 'Sciences and agriculture', 'Not Available in Dasma'),
(50, 'BS Fisheries', 'A degree program in BS Fisheries under the category of Sciences and agriculture.', 'R', NULL, 'Sciences and agriculture', 'Not Available in Dasma');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('shs','college','professional') DEFAULT 'shs',
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(64) DEFAULT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `user_type`, `is_verified`, `verification_token`, `verification_code`, `token_expires_at`, `created_at`) VALUES
(5, 'Agent Test', 'watercity159@gmail.com', '$2y$10$09O2IJRyFdLY7VIL7OxSTeJ7t/uCIBpQwLxAIbF.4m7/umR0GyWM.', 'shs', 0, 'f346f27ea1a26a30859f4017467f94c446e718c546b58bcc32e4292254e4e452', '925939', '2026-09-27 03:56:01', '2026-09-26 13:41:01'),
(8, 'Mark Carbaquel', 'mcarbaquel11@gmail.com', '$2y$10$VZKSdeLh2I1UXl4QnJGuFOoKQATDJKJW6QLOmCBSCOylw.nEAHSzS', 'shs', 1, NULL, NULL, NULL, '2026-10-01 04:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_saved_colleges`
--

CREATE TABLE `user_saved_colleges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `college_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_saved_colleges`
--

INSERT INTO `user_saved_colleges` (`id`, `user_id`, `college_id`, `saved_at`) VALUES
(3, 8, 5, '2026-10-01 04:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_saved_degrees`
--

CREATE TABLE `user_saved_degrees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessment_results`
--
ALTER TABLE `assessment_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college_degrees`
--
ALTER TABLE `college_degrees`
  ADD PRIMARY KEY (`college_id`,`degree_id`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_saved_colleges`
--
ALTER TABLE `user_saved_colleges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`college_id`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `user_saved_degrees`
--
ALTER TABLE `user_saved_degrees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`degree_id`),
  ADD KEY `degree_id` (`degree_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessment_results`
--
ALTER TABLE `assessment_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_saved_colleges`
--
ALTER TABLE `user_saved_colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_saved_degrees`
--
ALTER TABLE `user_saved_degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment_results`
--
ALTER TABLE `assessment_results`
  ADD CONSTRAINT `assessment_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_saved_colleges`
--
ALTER TABLE `user_saved_colleges`
  ADD CONSTRAINT `user_saved_colleges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_saved_colleges_ibfk_2` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_saved_degrees`
--
ALTER TABLE `user_saved_degrees`
  ADD CONSTRAINT `user_saved_degrees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_saved_degrees_ibfk_2` FOREIGN KEY (`degree_id`) REFERENCES `degrees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
