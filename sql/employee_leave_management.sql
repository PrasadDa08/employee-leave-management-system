-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 07, 2026 at 01:42 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_leave_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `activity` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `activity`, `created_at`) VALUES
(1, 1, 'Created new employee: Employee1', '2026-06-07 13:07:16'),
(2, 1, 'Updated employee: Employee1', '2026-06-07 13:08:12'),
(3, 1, 'Disabled user ID: 3', '2026-06-07 13:08:38'),
(4, 1, 'Disabled user ID: 3', '2026-06-07 13:08:48'),
(5, 1, 'Created new employee: Employee2', '2026-06-07 13:12:30'),
(6, 1, 'Created new employee: Employee3', '2026-06-07 13:13:48'),
(7, 1, 'Created new employee: Employee4', '2026-06-07 13:15:20'),
(8, 1, 'Created new employee: Employee5', '2026-06-07 13:16:06'),
(9, 1, 'Updated employee: Employee3', '2026-06-07 13:16:53'),
(10, 3, 'Applied leave request ID: 1', '2026-06-07 13:18:25'),
(11, 3, 'Applied leave request ID: 2', '2026-06-07 13:19:05'),
(12, 4, 'Applied leave request ID: 3', '2026-06-07 13:19:58'),
(13, 4, 'Applied leave request ID: 4', '2026-06-07 13:20:50'),
(14, 5, 'Applied leave request ID: 5', '2026-06-07 13:22:10'),
(15, 5, 'Applied leave request ID: 6', '2026-06-07 13:22:38'),
(16, 6, 'Applied leave request ID: 7', '2026-06-07 13:23:42'),
(17, 6, 'Applied leave request ID: 8', '2026-06-07 13:24:19'),
(18, 7, 'Applied leave request ID: 9', '2026-06-07 13:25:29'),
(19, 7, 'Applied leave request ID: 10', '2026-06-07 13:25:59'),
(20, 1, 'Disabled user ID: 3', '2026-06-07 13:26:14'),
(21, 1, 'Disabled user ID: 4', '2026-06-07 13:26:15'),
(22, 2, 'Approved leave request ID: 1', '2026-06-07 13:29:06'),
(23, 2, 'Approved leave request ID: 7', '2026-06-07 13:29:16'),
(24, 2, 'Rejected leave request ID: 5', '2026-06-07 13:29:32'),
(25, 2, 'Approved leave request ID: 6', '2026-06-07 13:29:38'),
(26, 2, 'Approved leave request ID: 9', '2026-06-07 13:29:50'),
(27, 2, 'Approved leave request ID: 8', '2026-06-07 13:29:55'),
(28, 2, 'Approved leave request ID: 3', '2026-06-07 13:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `joining_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `full_name`, `mobile`, `department`, `designation`, `joining_date`, `created_at`) VALUES
(1, 3, 'Employee1', '000000000', 'IT', 'SQL', '2026-06-01', '2026-06-07 13:07:16'),
(2, 4, 'Employee2', '11111111111', 'HR', 'Head HR', '2026-02-01', '2026-06-07 13:12:30'),
(3, 5, 'Employee3', '22222222222', 'Sales', 'Sales Executive', '2026-04-01', '2026-06-07 13:13:48'),
(4, 6, 'Employee4', '3333333333', 'Marketing', 'Digital Marketing Head', '2026-05-01', '2026-06-07 13:15:20'),
(5, 7, 'Employee5', '5555555555', 'IT', 'SDE1', '2026-06-01', '2026-06-07 13:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `leave_balances`
--

CREATE TABLE `leave_balances` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `leave_type_id` int NOT NULL,
  `available_days` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_balances`
--

INSERT INTO `leave_balances` (`id`, `employee_id`, `leave_type_id`, `available_days`) VALUES
(1, 1, 1, 9),
(2, 1, 2, 15),
(3, 1, 3, 10),
(4, 2, 1, 10),
(5, 2, 2, 15),
(6, 2, 3, 8),
(7, 3, 1, 10),
(8, 3, 2, 15),
(9, 3, 3, 1),
(10, 4, 1, 8),
(11, 4, 2, 7),
(12, 4, 3, 10),
(13, 5, 1, 10),
(14, 5, 2, 15),
(15, 5, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `leave_type_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected','') NOT NULL DEFAULT 'pending',
  `manager_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `approved_by` int DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type_id`, `start_date`, `end_date`, `total_days`, `reason`, `status`, `manager_remarks`, `approved_by`, `approved_at`, `created_at`) VALUES
(1, 1, 1, '2026-06-07', '2026-06-07', 1, 'Not feeling well.', 'approved', NULL, 2, '2026-06-07 18:59:06', '2026-06-07 13:18:25'),
(2, 1, 2, '2026-06-26', '2026-06-30', 5, 'Personal Reasons', 'pending', NULL, NULL, NULL, '2026-06-07 13:19:05'),
(3, 2, 3, '2026-06-09', '2026-06-10', 2, 'Going out of station', 'approved', NULL, 2, '2026-06-07 19:00:02', '2026-06-07 13:19:58'),
(4, 2, 2, '2026-06-13', '2026-06-15', 3, 'Need to attend a marriage function', 'pending', NULL, NULL, NULL, '2026-06-07 13:20:50'),
(5, 3, 2, '2026-06-24', '2026-06-26', 3, 'Need some relaxation time.', 'rejected', 'Project Deadlines', 2, '2026-06-07 18:59:32', '2026-06-07 13:22:10'),
(6, 3, 3, '2026-06-30', '2026-07-08', 9, 'Going hometown.', 'approved', NULL, 2, '2026-06-07 18:59:38', '2026-06-07 13:22:38'),
(7, 4, 1, '2026-06-07', '2026-06-08', 2, 'Not feeling well.', 'approved', NULL, 2, '2026-06-07 18:59:16', '2026-06-07 13:23:42'),
(8, 4, 2, '2026-07-08', '2026-07-15', 8, 'Need to attend a function.', 'approved', NULL, 2, '2026-06-07 18:59:55', '2026-06-07 13:24:19'),
(9, 5, 3, '2026-06-08', '2026-06-11', 4, 'Family Vacation', 'approved', NULL, 2, '2026-06-07 18:59:50', '2026-06-07 13:25:29'),
(10, 5, 3, '2026-06-18', '2026-06-25', 8, 'Marriage function', 'pending', NULL, NULL, NULL, '2026-06-07 13:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int NOT NULL,
  `leave_name` varchar(100) NOT NULL,
  `default_allocation` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `leave_name`, `default_allocation`, `created_at`, `updated_at`) VALUES
(1, 'Sick Leave', 10, '2026-06-06 12:08:08', NULL),
(2, 'Casual Leave', 15, '2026-06-06 12:09:17', NULL),
(3, 'Earned Leave', 10, '2026-06-06 12:09:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','employee') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'admin@test.com', '$2y$10$ah/1.wEYQX1TNqF466uozuL7Sn.n1OFd9vlYQgrZVFEthNZ4bBAt2', 'admin', 'active', '2026-06-07 13:04:05'),
(2, 'manager@test.com', '$2y$10$0TjpmgUjfpzRSuy3/nb3l.egUcyxMRBTqv5MuHSrGhBqG1RUnHpQ.', 'manager', 'active', '2026-06-07 13:05:02'),
(3, 'emp1@test.com', '$2y$10$yg5rYJ8hc21KgCBu8l1U0esvgFrCwfjinBsCWJ2Nc5gcZm62nl5yi', 'employee', 'inactive', '2026-06-07 13:07:16'),
(4, 'emp2@test.com', '$2y$10$Y4K7Y4oAte./pwEpirGNsOhtyhzm1RgGoAQdc7G1zbUdJHN7ed3Kq', 'employee', 'inactive', '2026-06-07 13:12:30'),
(5, 'emp3@test.com', '$2y$10$DNOhZ1ThzDbislyM.iwO0eFSfWNCnedgrLintpa7KbDbliHzYIdpO', 'employee', 'active', '2026-06-07 13:13:48'),
(6, 'emp4@test.com', '$2y$10$SqhkW5zJxdkGAqA.SFfPQeGwDKLL4xWvr34BAueEmhLs8bOvMcW6m', 'employee', 'active', '2026-06-07 13:15:20'),
(7, 'emp5@test.com', '$2y$10$hZBPH9KSa6YvAwwYif7Tbu7jZ46ZeqnVJQ.0XoSVyCQjADuHCITde', 'employee', 'active', '2026-06-07 13:16:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_ibfk_1` (`user_id`);

--
-- Indexes for table `leave_balances`
--
ALTER TABLE `leave_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_balances_ibfk_1` (`employee_id`),
  ADD KEY `leave_balances_ibfk_2` (`leave_type_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_ibfk_1` (`employee_id`),
  ADD KEY `leave_requests_ibfk_2` (`leave_type_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_balances`
--
ALTER TABLE `leave_balances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_balances`
--
ALTER TABLE `leave_balances`
  ADD CONSTRAINT `leave_balances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_balances_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
