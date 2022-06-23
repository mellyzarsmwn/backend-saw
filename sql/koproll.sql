-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2021 at 06:24 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koproll`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `salary` decimal(15,2) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `position` varchar(250) NOT NULL,
  `domisili` text NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1: active, 2: nonactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary_report`
--

CREATE TABLE `salary_report` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `salary` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary_report_detail`
--

CREATE TABLE `salary_report_detail` (
  `id` int(11) NOT NULL,
  `salary_report_id` int(11) NOT NULL,
  `salary_type_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `installment` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary_type`
--

CREATE TABLE `salary_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1: active, 2: nonactive',
  `type` tinyint(2) NOT NULL COMMENT '1: increase, 2: decrease',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(250) NOT NULL,
  `access` tinyint(2) NOT NULL COMMENT '1: ketua, 2: wakil, 3: bendahara, 4: admin',
  `status` tinyint(2) NOT NULL COMMENT '1: active, 2: nonactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `access`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$AMWjHF02ANmQMnyp2CNM9OT0BtSp8qvECx3tdRVrBmRhEwy71RroS', 4, 1, '2021-07-08 14:39:17', '2021-09-29 15:01:28', NULL),
(11, 'Riska', 'riska@gmail.com', '$2y$10$eebmvCTfeGhFIkmCDKS0pe8mkbO9gGsEpPbglk7zIPKFeZ8tqTOnW', 3, 1, '2021-09-29 10:18:13', '2021-09-29 10:18:13', NULL),
(12, 'Heri Padli', 'heri@gmail.com', '$2y$10$sEtu6WF9873jReh9Lf65VO0WSXXgXi10C3Jsepnab1R/lOJfzxnY.', 1, 1, '2021-09-29 10:21:11', '2021-09-29 10:21:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_report`
--
ALTER TABLE `salary_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_report_fk_employee_id` (`employee_id`) USING BTREE,
  ADD KEY `salary_report_fk_users_id` (`user_id`) USING BTREE;

--
-- Indexes for table `salary_report_detail`
--
ALTER TABLE `salary_report_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_report_detail_fk_salary_report_id` (`salary_report_id`),
  ADD KEY `salary_report_detail_fk_salary_type_id` (`salary_type_id`);

--
-- Indexes for table `salary_type`
--
ALTER TABLE `salary_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `salary_report`
--
ALTER TABLE `salary_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `salary_report_detail`
--
ALTER TABLE `salary_report_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `salary_type`
--
ALTER TABLE `salary_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `salary_report`
--
ALTER TABLE `salary_report`
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `salary_report_detail`
--
ALTER TABLE `salary_report_detail`
  ADD CONSTRAINT `salary_report_detail_fk_salary_report_id` FOREIGN KEY (`salary_report_id`) REFERENCES `salary_report` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salary_report_detail_fk_salary_type_id` FOREIGN KEY (`salary_type_id`) REFERENCES `salary_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
