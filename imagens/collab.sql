-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 09:38 PM
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
(20, 'ZkjVBJpOZLk3MAfvp97S', 46, 'admin'),
(24, 'AaJpqLmvYmDAhJDWkhsl', 49, 'admin');

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
('ZkjVBJpOZLk3MAfvp97S', 99, 'Testing', 'aa', 'default.png', '2024-10-20 01:10:00'),
('dgp2puotn1NPuZoV8TQS', 101, 'Mais um teste', 'Mine sem mods', 'IMG-672ee7d4db0fd9.18160159.jpg', '2024-10-30 23:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `step_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `step_title` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`step_id`, `project_id`, `step_title`) VALUES
(1, 96, 'Testando'),
(8, 96, 'Teste 2'),
(9, 96, 'Teste 3'),
(12, 48, 'Teste 1'),
(17, 48, 'Teste 2'),
(18, 48, 'Teste 3'),
(19, 48, 'Teste 3'),
(20, 46, 'Testando'),
(21, 98, 'Desenvolvimento'),
(22, 98, 'QA'),
(23, 98, 'Financeiro'),
(24, 98, 'Teste'),
(40, 101, 'Testando'),
(41, 49, 'Teste'),
(42, 49, 'Vai dar certo'),
(43, 49, 'Testando'),
(44, 49, 'Teste 3'),
(55, 49, 'Nova etapa');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `responsible_id` varchar(20) DEFAULT NULL,
  `task_name` varchar(55) NOT NULL,
  `task_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `step_id`, `project_id`, `responsible_id`, `task_name`, `task_description`) VALUES
(3, 43, 49, NULL, 'Mais uma', 'Teste'),
(9, 17, 48, NULL, 'Mais uma', 'Primeira task'),
(21, 42, 49, NULL, 'Primeira', 'adasd'),
(23, 41, 49, 'dgp2puotn1NPuZoV8TQS', 'Primeira', ''),
(25, 41, 49, NULL, 'Teste', 'teste');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `session_id` varchar(20) NOT NULL,
  `username` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `profile_image` varchar(55) DEFAULT 'user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `session_id`, `username`, `email`, `user_password`, `profile_image`) VALUES
(12, 'default', 'default', 'phpadmin@default.com', 'phpadmindefault', 'user.png'),
(18, 'dgp2puotn1NPuZoV8TQS', 'Saulbez', 'saull2504@gmail.com', '$2y$10$L7O8ejQNUT1GQbFlVaZjRuLhtojq8hHKgeFrySwtXX6nntuz0140u', 'IMG-6732670dae3b58.29923144.jpg'),
(19, '4I05X0gxS1RJt4Tn21es', 'Letícia', 'leticia@gmail.com', '$2y$10$VCedq8fw56.1RwXnQJsAve9dhzHHR7NW9e0rj/zN53wv97wGZZO.K', 'user.png'),
(20, 'HyrqVaeZ7GvolI4qbmJE', 'Gilber', 'gilbertobezerrab@gmail.com', '$2y$10$CDHn/Zl3PH1bzx76bOE.MOYttBj63Jp4u5b43AE9aZc3jCYJZd4bG', 'user.png'),
(21, 'pwsKeYXHdYi0oakyqC8y', 'Claudia', 'claudia@gmail.com', '$2y$10$53qv.aTpSj97sGpKw2iejOMxQkvX2PALIaj1GnFFYRkzZ4bc6yQNu', 'user.png'),
(22, '9kFkMqlc0PYdb2O4gsn7', 'Adasd', 'asdasd@asdad.cs', '$2y$10$cACJ.XKv71I331YFZUCg/OSjL0K6fl7NaWYKxCzrY8IiUc0UaYq02', 'user.png'),
(23, 'QUCHl4qjR0miMfVwJX3z', 'Teste', 'saul@firezap.pro', '$2y$10$8nT6apU/tV7hHN3gwiTg4OB5xv9/dE8XzAxTcQCsGY9jOZxeZIh4.', 'user.png'),
(24, 'jkHKlWHPG1QEzcZchDsI', 'Teste2', 'teste2@gmail.com', '$2y$10$6fULutFcSeywZITiXiboDeHBETQKcAGC3VS7G/g8rXzyJBjBSFDQa', 'user.png'),
(25, 'AaJpqLmvYmDAhJDWkhsl', 'Simone', 'simone@gmail.com', '$2y$10$5JXyD60I8LwP0S2BP6m7EOZWnpbuESO0g4fG75M.f/q16qbA/nhwC', 'IMG-672d286ae55c78.00835830.jpg'),
(26, 'ZkjVBJpOZLk3MAfvp97S', 'Ruan', 'ruan@gmail.com', '$2y$10$Tm98q/OHYGBSUQNI/H2buOw73OYQfM0BjC4YWifzoM6Sr6S7TyfTy', 'user.png'),
(30, 'jSVHjSPbP8Iwxuvl5PAA', 'Adasd', 'asdasd@asdad.csd', '$2y$10$Lg9P9ZIkML2IFgiIvvDN1eTyrIW60aoihTccHJh3kPVzyxDo5UTim', 'user.png'),
(40, 'INZbmMD34HEDFfYeSsWa', 'Darnley', 'darnley@gmail.com', '$2y$10$uDjVuBgsu1LFf1S8N2zJ8OxVZLYX8hlBR2Y1qSzCRFYF3P8HmOyiu', 'user.png'),
(42, '2hiY95YdcmSHo3h7MKfs', 'Testando', 'testando@gmail.com', '$2y$10$I/d6DSykt7PxSLz4y4SExecDvTuzmfX/WXyEt6QHpF13/NKMU8xzC', 'user.png'),
(44, 'vNnMJmszDtwJ6lXgnc3m', 'Teste3', 'teste3@gmail.com', '$2y$10$dzGsdmGfelL3BLLstPb85egDfmV2om.Pyrh2SttXErz8U.37j3rGm', 'user.png'),
(45, 'pp93wrSDsekMnzpA7Imc', 'Teste4', 'teste4@gmail.com', '$2y$10$isxmdjTev2e7CFrGH5BOreXKt3ipHQEHrwVr4WEnw388ELrtKAYVK', 'user.png'),
(46, 'EVVzgGNINiOHkToeyVeX', 'Teste', 'teste10@gmail.com', '$2y$10$bvFUF6mhaYyTPUEZR/RdT.qi7TVhwiu1SOKhAse3DRUuLuquYKn7m', 'user.png');

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
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `steps_ibfk_1` (`project_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `tasks_ibfk_1` (`step_id`),
  ADD KEY `tasks_ibfk_2` (`project_id`),
  ADD KEY `tasks_ibfk_3` (`responsible_id`);

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
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `users` (`session_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `users` (`session_id`);

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`step_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
