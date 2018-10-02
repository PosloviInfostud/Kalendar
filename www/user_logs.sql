-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 02, 2018 at 01:01 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
