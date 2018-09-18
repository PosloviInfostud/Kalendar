-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Sep 18, 2018 at 02:25 PM
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
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Atila', 'atila@email.com', 'this message', '2018-09-18 13:51:17'),
(2, 'Atila', 'atila@email.com', 'this message', '2018-09-18 13:55:24'),
(3, 'Atila', 'atila@email.com', 'another message', '2018-09-18 14:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `created_at`) VALUES
(1, 'This is the first blog post', 'Icing sweet roll chupa chups sugar plum toffee sweet. Danish wafer jelly donut. Cake tart caramels cake candy croissant candy chocolate cake candy canes. Donut powder cake carrot cake biscuit lemon drops sweet roll pie. Jelly beans gummies icing icing biscuit. Chocolate cake jujubes ice cream cookie topping sugar plum toffee bear claw. Lemon drops tart cupcake marshmallow sugar plum ice cream tiramisu bear claw. Gingerbread cupcake chocolate bar candy canes danish toffee tootsie roll. Croissant marzipan pie danish topping cotton candy.\r\n\r\nMarshmallow sweet marzipan pudding liquorice liquorice halvah pudding. Cupcake candy ice cream pie wafer halvah gummi bears fruitcake. Pastry danish chocolate cake. Oat cake cake icing gummies bonbon muffin dessert. Danish lollipop chocolate. Toffee tiramisu caramels cake bonbon jelly-o. Gummies macaroon biscuit chocolate cake sesame snaps cheesecake cupcake. Pastry ice cream sugar plum chupa chups. Soufflé gummies candy canes jelly-o halvah candy fruitcake. Icing brownie cookie.\r\n\r\nGingerbread brownie gingerbread ice cream. Pastry gingerbread sugar plum liquorice. Halvah sweet roll marzipan donut candy canes biscuit croissant oat cake jelly-o. Topping gingerbread macaroon fruitcake sweet carrot cake. Oat cake jujubes topping chupa chups macaroon marzipan cheesecake chupa chups sesame snaps. Lollipop fruitcake candy canes brownie carrot cake lollipop. Chocolate apple pie muffin lollipop candy sweet roll jelly-o. Bear claw soufflé croissant.\r\n\r\nSweet roll bear claw dessert sugar plum chupa chups tootsie roll muffin pie sweet. Wafer gummi bears cake apple pie soufflé. Jujubes chocolate sweet gingerbread brownie. Gingerbread jelly-o donut gummi bears soufflé sesame snaps caramels muffin gummi bears. Marzipan candy candy canes macaroon topping gummi bears. Cotton candy cheesecake macaroon chocolate tart cake topping cupcake. Danish pastry muffin soufflé candy dragée. Pastry tootsie roll halvah muffin halvah gingerbread jelly gummies jelly-o. Lemon drops caramels bear claw brownie apple pie gummies cheesecake. Croissant powder powder donut gingerbread.\r\n\r\nFruitcake sesame snaps biscuit sweet roll chocolate gingerbread powder carrot cake. Croissant soufflé jujubes jelly. Jelly beans halvah halvah. Gingerbread lollipop icing. Muffin lollipop caramels brownie ice cream danish sweet. Chocolate jelly-o biscuit pudding sweet roll.', 'Atila', '2018-09-13 13:30:16'),
(2, 'This is the second post', 'Icing sweet roll chupa chups sugar plum toffee sweet. Danish wafer jelly donut. Cake tart caramels cake candy croissant candy chocolate cake candy canes. Donut powder cake carrot cake biscuit lemon drops sweet roll pie. Jelly beans gummies icing icing biscuit. Chocolate cake jujubes ice cream cookie topping sugar plum toffee bear claw. Lemon drops tart cupcake marshmallow sugar plum ice cream tiramisu bear claw. Gingerbread cupcake chocolate bar candy canes danish toffee tootsie roll. Croissant marzipan pie danish topping cotton candy.\r\n\r\nMarshmallow sweet marzipan pudding liquorice liquorice halvah pudding. Cupcake candy ice cream pie wafer halvah gummi bears fruitcake. Pastry danish chocolate cake. Oat cake cake icing gummies bonbon muffin dessert. Danish lollipop chocolate. Toffee tiramisu caramels cake bonbon jelly-o. Gummies macaroon biscuit chocolate cake sesame snaps cheesecake cupcake. Pastry ice cream sugar plum chupa chups. Soufflé gummies candy canes jelly-o halvah candy fruitcake. Icing brownie cookie.\r\n\r\nGingerbread brownie gingerbread ice cream. Pastry gingerbread sugar plum liquorice. Halvah sweet roll marzipan donut candy canes biscuit croissant oat cake jelly-o. Topping gingerbread macaroon fruitcake sweet carrot cake. Oat cake jujubes topping chupa chups macaroon marzipan cheesecake chupa chups sesame snaps. Lollipop fruitcake candy canes brownie carrot cake lollipop. Chocolate apple pie muffin lollipop candy sweet roll jelly-o. Bear claw soufflé croissant.\r\n\r\nSweet roll bear claw dessert sugar plum chupa chups tootsie roll muffin pie sweet. Wafer gummi bears cake apple pie soufflé. Jujubes chocolate sweet gingerbread brownie. Gingerbread jelly-o donut gummi bears soufflé sesame snaps caramels muffin gummi bears. Marzipan candy candy canes macaroon topping gummi bears. Cotton candy cheesecake macaroon chocolate tart cake topping cupcake. Danish pastry muffin soufflé candy dragée. Pastry tootsie roll halvah muffin halvah gingerbread jelly gummies jelly-o. Lemon drops caramels bear claw brownie apple pie gummies cheesecake. Croissant powder powder donut gingerbread.\r\n\r\nFruitcake sesame snaps biscuit sweet roll chocolate gingerbread powder carrot cake. Croissant soufflé jujubes jelly. Jelly beans halvah halvah. Gingerbread lollipop icing. Muffin lollipop caramels brownie ice cream danish sweet. Chocolate jelly-o biscuit pudding sweet roll.', 'Miki', '2018-09-13 13:30:16'),
(3, 'This is the third blog post dddccc', 'Icing sweet roll chupa chups sugar plum toffee sweet. Danish wafer jelly donut. Cake tart caramels cake candy croissant candy chocolate cake candy canes. Donut powder cake carrot cake biscuit lemon drops sweet roll pie. Jelly beans gummies icing icing biscuit. Chocolate cake jujubes ice cream cookie topping sugar plum toffee bear claw. Lemon drops tart cupcake marshmallow sugar plum ice cream tiramisu bear claw. Gingerbread cupcake chocolate bar candy canes danish toffee tootsie roll. Croissant marzipan pie danish topping cotton candy.\r\n\r\nMarshmallow sweet marzipan pudding liquorice liquorice halvah pudding. Cupcake candy ice cream pie wafer halvah gummi bears fruitcake. Pastry danish chocolate cake. Oat cake cake icing gummies bonbon muffin dessert. Danish lollipop chocolate. Toffee tiramisu caramels cake bonbon jelly-o. Gummies macaroon biscuit chocolate cake sesame snaps cheesecake cupcake. Pastry ice cream sugar plum chupa chups. Soufflé gummies candy canes jelly-o halvah candy fruitcake. Icing brownie cookie.\r\n\r\nGingerbread brownie gingerbread ice cream. Pastry gingerbread sugar plum liquorice. Halvah sweet roll marzipan donut candy canes biscuit croissant oat cake jelly-o. Topping gingerbread macaroon fruitcake sweet carrot cake. Oat cake jujubes topping chupa chups macaroon marzipan cheesecake chupa chups sesame snaps. Lollipop fruitcake candy canes brownie carrot cake lollipop. Chocolate apple pie muffin lollipop candy sweet roll jelly-o. Bear claw soufflé croissant.\r\n\r\nSweet roll bear claw dessert sugar plum chupa chups tootsie roll muffin pie sweet. Wafer gummi bears cake apple pie soufflé. Jujubes chocolate sweet gingerbread brownie. Gingerbread jelly-o donut gummi bears soufflé sesame snaps caramels muffin gummi bears. Marzipan candy candy canes macaroon topping gummi bears. Cotton candy cheesecake macaroon chocolate tart cake topping cupcake. Danish pastry muffin soufflé candy dragée. Pastry tootsie roll halvah muffin halvah gingerbread jelly gummies jelly-o. Lemon drops caramels bear claw brownie apple pie gummies cheesecake. Croissant powder powder donut gingerbread.', 'Luka', '2018-09-13 13:30:41'),
(4, 'Fourth blog post', 'Some text goes here...', '', '2018-09-13 14:09:31'),
(9, 'This is another text', 'some text goes here', '', '2018-09-14 09:24:09'),
(10, 'This is my updated title', 'this is my body', '', '2018-09-14 09:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 9, 1),
(4, 9, 3),
(5, 9, 6),
(9, 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'one'),
(2, 'two'),
(3, 'three'),
(4, 'four'),
(5, 'five'),
(6, 'six');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
