-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2026 at 04:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT '',
  `street` varchar(255) DEFAULT '',
  `suite` varchar(100) DEFAULT '',
  `zipcode` varchar(20) DEFAULT '',
  `phone` varchar(50) DEFAULT '',
  `website` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `city`, `street`, `suite`, `zipcode`, `phone`, `website`, `created_at`) VALUES
(1, 'Leanne Graham', 'Bret', 'Sincere@april.biz', 'Gwenborough', 'Kulas Light', 'Apt. 556', '92998-3874', '1-770-736-8031 x56442', 'hildegard.org', '2026-08-27 02:13:57'),
(2, 'Ervin Howell', 'Antonette', 'Shanna@melissa.tv', 'Wisokyburgh', 'Victor Plains', 'Suite 879', '90566-7771', '010-692-6593 x09125', 'anastasia.net', '2026-08-27 02:13:57'),
(3, 'Clementine Bauch', 'Samantha', 'Nathan@yesenia.net', 'McKenziehaven', 'Douglas Extension', 'Suite 847', '59590-4157', '1-463-123-4447', 'ramiro.info', '2026-08-27 02:13:57'),
(4, 'Patricia Lebsack', 'Karianne', 'Julianne.OConner@kory.org', 'South Elvis', 'Hoeger Mall', 'Apt. 692', '53919-4257', '493-170-9623 x156', 'kale.biz', '2026-08-27 02:13:57'),
(6, 'Mrs. Dennis Schulist', 'Leopoldo_Corkery', 'Karley_Dach@jasper.info', 'South Christy', 'Norberto Crossing', 'Apt. 950', '23505-1337', '1-477-935-8478 x6430', 'ola.org', '2026-08-27 02:13:57'),
(7, 'Kurtis Weissnat', 'Elwyn.Skiles', 'Telly.Hoeger@billy.biz', 'Howemouth', 'Rex Trail', 'Suite 280', '58804-1099', '210.067.6132', 'elvis.io', '2026-08-27 02:13:57'),
(8, 'Nicholas Runolfsdottir V', 'Maxime_Nienow', 'Sherwood@rosamond.me', 'Aliyaview', 'Ellsworth Summit', 'Suite 729', '45169', '586.493.6943 x140', 'jacynthe.com', '2026-08-27 02:13:57'),
(9, 'Glenna Reichert', 'Delphine', 'Chaim_McDermott@dana.io', 'Bartholomebury', 'Dayna Park', 'Suite 449', '76495-3109', '(775)976-6794 x41206', 'conrad.com', '2026-08-27 02:13:57'),
(10, 'Clementina DuBuque', 'Moriah.Stanton', 'Rey.Padberg@karina.biz', 'Lebsackbury', 'Kattie Turnpike', 'Suite 198', '31428-2261', '024-648-3804', 'ambrose.net', '2026-08-27 02:13:57'),
(11, 'Joko', 'jokonumber', 'jokoperkoso@gmail.com', 'Ponorogo', 'sawoo', '', '', '082375656187', 'joko.com', '2026-08-27 02:13:57'),
(13, 'Agus Putra Mahardika', 'aguSHTer', 'xrplagusputramahardika@gmail.com', 'Pacitan', 'Tahunan', '', '', '082375656187', 'proclean.my.id', '2026-08-27 02:13:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
