-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 02, 2018 at 01:00 PM
-- Server version: 8.0.12
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `res_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `modified_at` timestamp NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `res_items`
--

CREATE TABLE `res_items` (
  `id` int(11) NOT NULL,
  `res_type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `res_members`
--

CREATE TABLE `res_members` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `res_role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `notify` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `res_roles`
--

CREATE TABLE `res_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `res_roles`
--

INSERT INTO `res_roles` (`id`, `name`) VALUES
(1, 'editor'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `res_types`
--

CREATE TABLE `res_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_role_id` int(11) NOT NULL DEFAULT '2',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activation_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token_expiration_time` timestamp NULL DEFAULT NULL,
  `reset_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_key_exp` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_role_id`, `active`, `activation_key`, `token`, `token_expiration_time`, `reset_key`, `reset_key_exp`, `created_at`) VALUES
(2, 'Luka', 'lukamatkovicns@gmail.com', '$2y$10$cZwpq6cryI6a7kutLerTreivtMjUntR9QMf8ejHP8eUveVGzdIwYS', 2, 1, '', '9071789379ebb75c380df18a1d2813e8', '2018-10-04 11:59:03', NULL, NULL, '2018-10-01 13:20:07'),
(3, 'Second', 'test2@gmail.com', '$2y$10$Ip69RtLBwR/C.q/umDTcAOHATiA13xj4THUyArHYtLlSSlIuy7j4y', 2, 0, '110c33cd2128a15cb5fc4b91b017bd54', '', NULL, NULL, NULL, '2018-10-02 11:45:34'),
(4, 'Luka', 'lkmtkvc@gmail.com', '$2y$10$a1HBsEYl.dqqbN424IW89O3vrzFc9BbNYGNKayTfIhXh76mXIZV/2', 2, 0, '217d7a0231e5f83c96b1b13e3e3dfd08', '', NULL, NULL, NULL, '2018-10-02 12:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'L',
  `success` tinyint(1) NOT NULL DEFAULT '1',
  `log_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `email`, `log_type`, `success`, `log_description`, `ip_address`, `user_agent`, `log_time`) VALUES
(1, 'lkmtkvc@gmail.com', 'L', 0, 'not registered', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:40:25'),
(2, 'lukamatkovicns@gmail.com', 'L', 0, 'wrong password', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:43:32'),
(3, 'test2@gmail.com', 'L', 0, 'profile not yet activated', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:45:46'),
(4, 'lukamatkovicns@gmail.com', 'L', 1, NULL, '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:48:45'),
(5, 'lukamatkovicns@gmail.com', 'L', 0, 'wrong password', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0', '2018-10-02 11:50:36'),
(6, 'tutyuytu@mail.mail', 'L', 0, 'not registered', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0', '2018-10-02 11:52:23'),
(7, 'lukamatkovicns@gmail.com', 'L', 1, NULL, '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0', '2018-10-02 11:52:54'),
(8, 'lukamatkovicns@gmail.com', 'L', 0, 'wrong password', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:58:59'),
(9, 'lukamatkovicns@gmail.com', 'L', 1, NULL, '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 11:59:03'),
(10, '', 'R', 0, '<p>The Name field is required.</p>\n<p>You have not provided Email.</p>\n<p>The Password field is required.</p>\n<p>The Password Confirmation field is required.</p>\n', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 12:54:12'),
(11, 'lkmtkvc@gmail.com', 'R', 0, '<p>The Password Confirmation field does not match the Password field.</p>\n', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 12:57:49'),
(12, 'lkmtkvc@gmail.com', 'R', 1, NULL, '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 12:57:54'),
(13, '', 'L', 0, '<p>The E-Mail field is required.</p>\n<p>The Password field is required.</p>\n', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-10-02 12:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comments_reservations` (`res_id`),
  ADD KEY `FK_comments_users` (`user_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_logs_users` (`user_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reservations_users` (`user_id`),
  ADD KEY `FK_reservations_items` (`res_item_id`);

--
-- Indexes for table `res_items`
--
ALTER TABLE `res_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_items_types` (`res_type_id`);

--
-- Indexes for table `res_members`
--
ALTER TABLE `res_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_members_reservations` (`res_id`),
  ADD KEY `FK_members_users` (`user_id`),
  ADD KEY `FK_members_roles` (`res_role_id`);

--
-- Indexes for table `res_roles`
--
ALTER TABLE `res_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `res_types`
--
ALTER TABLE `res_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_roles` (`user_role_id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `res_items`
--
ALTER TABLE `res_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `res_members`
--
ALTER TABLE `res_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `res_roles`
--
ALTER TABLE `res_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `res_types`
--
ALTER TABLE `res_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comments_reservations` FOREIGN KEY (`res_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `FK_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_logs_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_reservations_items` FOREIGN KEY (`res_item_id`) REFERENCES `res_items` (`id`),
  ADD CONSTRAINT `FK_reservations_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `res_items`
--
ALTER TABLE `res_items`
  ADD CONSTRAINT `FK_items_types` FOREIGN KEY (`res_type_id`) REFERENCES `res_types` (`id`);

--
-- Constraints for table `res_members`
--
ALTER TABLE `res_members`
  ADD CONSTRAINT `FK_members_reservations` FOREIGN KEY (`res_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `FK_members_roles` FOREIGN KEY (`res_role_id`) REFERENCES `res_roles` (`id`),
  ADD CONSTRAINT `FK_members_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_roles` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
