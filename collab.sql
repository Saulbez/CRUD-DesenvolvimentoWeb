-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 02:24 PM
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
-- Database: `collab`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `session_id` varchar(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `permission_type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `session_id`, `project_id`, `permission_type`) VALUES
(1, 'AaJpqLmvYmDAhJDWkhsl', 46, 'edit'),
(5, 'AaJpqLmvYmDAhJDWkhsl', 49, 'admin'),
(7, 'AaJpqLmvYmDAhJDWkhsl', 48, 'edit'),
(9, 'HyrqVaeZ7GvolI4qbmJE', 46, 'edit'),
(12, 'HyrqVaeZ7GvolI4qbmJE', 48, 'edit'),
(14, 'HyrqVaeZ7GvolI4qbmJE', 49, 'edit'),
(16, 'ZkjVBJpOZLk3MAfvp97S', 98, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `session_id` varchar(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_name` varchar(55) NOT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_image` varchar(55) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`session_id`, `project_id`, `project_name`, `project_description`, `project_image`, `data_criacao`) VALUES
('default', 1, 'default', 'default', 'default.png', '2024-10-08 18:17:17'),
('dgp2puotn1NPuZoV8TQS', 46, 'Lake Tahoe', 'Lake Tahoe website', 'IMG-670c498b1abbf0.60603498.png', '2024-10-13 22:28:27'),
('dgp2puotn1NPuZoV8TQS', 48, 'Android', 'Um resumo da história do android', 'IMG-670c49b38c6414.30760097.png', '2024-10-13 22:29:07'),
('dgp2puotn1NPuZoV8TQS', 49, 'Cordel', 'Cordel Moderno website', 'IMG-670c49c79f22a8.96766741.png', '2024-10-13 22:29:27'),
('AaJpqLmvYmDAhJDWkhsl', 96, 'Testing', '', 'default.png', '2024-10-19 02:45:51'),
('AaJpqLmvYmDAhJDWkhsl', 97, 'a', '', 'default.png', '2024-10-19 02:49:12'),
('dgp2puotn1NPuZoV8TQS', 98, 'Palworld', 'Cópia de pokemon com fortnite', 'default.png', '2024-10-20 01:03:07'),
('ZkjVBJpOZLk3MAfvp97S', 99, 'Testing', 'aa', 'default.png', '2024-10-20 01:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `session_id` varchar(20) NOT NULL,
  `username` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `session_id`, `username`, `email`, `user_password`) VALUES
(12, 'default', 'default', 'phpadmin@default.com', 'phpadmindefault'),
(18, 'dgp2puotn1NPuZoV8TQS', 'Saulbez', 'saull2504@gmail.com', '$2y$10$D6gfdwypSsKW9oClTComkO2UgjgV7HScMuZo65Lyz4AMGAPDJeuWW'),
(19, '4I05X0gxS1RJt4Tn21es', 'Letícia', 'leticia@gmail.com', '$2y$10$VCedq8fw56.1RwXnQJsAve9dhzHHR7NW9e0rj/zN53wv97wGZZO.K'),
(20, 'HyrqVaeZ7GvolI4qbmJE', 'Gilber', 'gilbertobezerrab@gmail.com', '$2y$10$CDHn/Zl3PH1bzx76bOE.MOYttBj63Jp4u5b43AE9aZc3jCYJZd4bG'),
(21, 'pwsKeYXHdYi0oakyqC8y', 'Claudia', 'claudia@gmail.com', '$2y$10$53qv.aTpSj97sGpKw2iejOMxQkvX2PALIaj1GnFFYRkzZ4bc6yQNu'),
(22, '9kFkMqlc0PYdb2O4gsn7', 'Adasd', 'asdasd@asdad.cs', '$2y$10$cACJ.XKv71I331YFZUCg/OSjL0K6fl7NaWYKxCzrY8IiUc0UaYq02'),
(23, 'QUCHl4qjR0miMfVwJX3z', 'Teste', 'saul@firezap.pro', '$2y$10$8nT6apU/tV7hHN3gwiTg4OB5xv9/dE8XzAxTcQCsGY9jOZxeZIh4.'),
(24, 'jkHKlWHPG1QEzcZchDsI', 'Teste2', 'teste2@gmail.com', '$2y$10$6fULutFcSeywZITiXiboDeHBETQKcAGC3VS7G/g8rXzyJBjBSFDQa'),
(25, 'AaJpqLmvYmDAhJDWkhsl', 'Simone', 'simone@gmail.com', '$2y$10$BBoFNukXdEWNAffthBkpMeTmM.9ED5zy7ImPBQoI.gytC.GQx/Zm6'),
(26, 'ZkjVBJpOZLk3MAfvp97S', 'Ruan', 'ruan@gmail.com', '$2y$10$Tm98q/OHYGBSUQNI/H2buOw73OYQfM0BjC4YWifzoM6Sr6S7TyfTy'),
(30, 'jSVHjSPbP8Iwxuvl5PAA', 'Adasd', 'asdasd@asdad.csd', '$2y$10$Lg9P9ZIkML2IFgiIvvDN1eTyrIW60aoihTccHJh3kPVzyxDo5UTim');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `uk_permissions_user_project` (`session_id`,`project_id`),
  ADD KEY `idx_permissions_user_project` (`session_id`,`project_id`),
  ADD KEY `idx_permissions_session_id` (`session_id`),
  ADD KEY `idx_permissions_project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `users` (`session_id`),
  ADD CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `users` (`session_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
