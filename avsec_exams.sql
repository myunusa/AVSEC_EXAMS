-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 10:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avsec_exams`
--

-- --------------------------------------------------------

--
-- Table structure for table `der435`
--

CREATE TABLE `der435` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `id` int(11) NOT NULL,
  `e_code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `no_question` varchar(50) NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`id`, `e_code`, `name`, `no_question`, `duration`) VALUES
(1, 'SCS102', 'Security Safety I', '100', '01:00:00'),
(16, 'DER435', 'Rferrtrdd', '70', '00:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `scs102`
--

CREATE TABLE `scs102` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scs102`
--

INSERT INTO `scs102` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `image`) VALUES
(1, 'ghtnehhr jgjfjdd djfhhfejj jjjfj djgj', 'gghgjfj', 'yre', 'no', 'ghdd', 'no', 'SCS102Z2.jpg'),
(2, 'tyghg gtgff ffffj hjgfhf dddf', 'yes confirm', 'no nhdd fgddrv jg', 'frewqq gghu jjffg', 'gdtv hgjk gff', 'yes confirm', '');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `nimc_no` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `nimc_no`, `name`, `phone_no`, `dob`, `gender`, `image`) VALUES
(1, '12345678906', 'sulaiman musa yunusa', '', '1999-07-27', 'Male', '12345656564.png'),
(7, '12345643267', 'Syu/frtf-sd', '08076766543', '2000-02-24', 'Male', '12345643267.png');

-- --------------------------------------------------------

--
-- Table structure for table `student_exam`
--

CREATE TABLE `student_exam` (
  `id` int(11) NOT NULL,
  `nimc_no` varchar(50) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `exam_type` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_time` time NOT NULL,
  `exam_status` varchar(50) NOT NULL,
  `exam_score` varchar(50) NOT NULL,
  `percent` varchar(50) NOT NULL,
  `exam_remark` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_exam`
--

INSERT INTO `student_exam` (`id`, `nimc_no`, `exam_id`, `exam_type`, `exam_date`, `exam_time`, `exam_status`, `exam_score`, `percent`, `exam_remark`) VALUES
(2, '12345678906', 'SCS10248UWY', 'SCS102', '2025-09-03', '00:01:00', 'Not written', '0', '0%', 'Fail');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role` enum('Admin','Staff') NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `added_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role`, `name`, `username`, `password`, `added_by`) VALUES
(1, 'Admin', 'sulaiman musa', 'myunusa', '1234567', 'ICT'),
(4, 'Staff', 'Fatuuaa', 'fvvv', '123456', 'myunusa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `der435`
--
ALTER TABLE `der435`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `e_code` (`e_code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `scs102`
--
ALTER TABLE `scs102`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nimc_no` (`nimc_no`);

--
-- Indexes for table `student_exam`
--
ALTER TABLE `student_exam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_id` (`exam_id`),
  ADD KEY `nimc_no` (`nimc_no`),
  ADD KEY `exam_type` (`exam_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `der435`
--
ALTER TABLE `der435`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `scs102`
--
ALTER TABLE `scs102`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_exam`
--
ALTER TABLE `student_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_exam`
--
ALTER TABLE `student_exam`
  ADD CONSTRAINT `student_exam_ibfk_1` FOREIGN KEY (`nimc_no`) REFERENCES `student` (`nimc_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_exam_ibfk_2` FOREIGN KEY (`exam_type`) REFERENCES `exam_type` (`e_code`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
