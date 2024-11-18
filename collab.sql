-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 09:01 PM
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
(26, 'pwsKeYXHdYi0oakyqC8y', 49, 'admin'),
(27, 'AaJpqLmvYmDAhJDWkhsl', 49, 'edit'),
(29, 'HyrqVaeZ7GvolI4qbmJE', 49, 'edit'),
(30, 'HyrqVaeZ7GvolI4qbmJE', 138, 'edit'),
(31, 'pwsKeYXHdYi0oakyqC8y', 138, 'admin'),
(32, 'AaJpqLmvYmDAhJDWkhsl', 138, 'admin'),
(33, 'ZkjVBJpOZLk3MAfvp97S', 137, 'admin'),
(34, 'ZkjVBJpOZLk3MAfvp97S', 138, 'edit'),
(35, 'pwsKeYXHdYi0oakyqC8y', 137, 'edit'),
(38, 'dgp2puotn1NPuZoV8TQS', 145, 'admin'),
(39, 'ZkjVBJpOZLk3MAfvp97S', 145, 'admin');

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
('dgp2puotn1NPuZoV8TQS', 49, 'Cordel', 'Cordel Moderno website', 'IMG-670c49c79f22a8.96766741.png', '2024-10-13 22:29:27'),
('AaJpqLmvYmDAhJDWkhsl', 96, 'Testing', '', 'default.png', '2024-10-19 02:45:51'),
('AaJpqLmvYmDAhJDWkhsl', 97, 'a', '', 'default.png', '2024-10-19 02:49:12'),
('ZkjVBJpOZLk3MAfvp97S', 99, 'Testing', 'aa', 'default.png', '2024-10-20 01:10:00'),
('dgp2puotn1NPuZoV8TQS', 137, 'Lake Tahoe', 'The lake tahoe project', 'IMG-6733516fa029e6.15734261.png', '2024-11-12 13:00:31'),
('dgp2puotn1NPuZoV8TQS', 138, 'Tindog', 'The tinder app for your dog', 'IMG-67338eb74d8c36.12412766.png', '2024-11-12 13:00:51'),
('Px0mjHz9qAOJo6e58Fcs', 145, 'Teste 2', 'teste', 'IMG-673b9c56d4e6b2.61752536.png', '2024-11-18 19:57:17');

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
(41, 49, 'Teste'),
(42, 49, 'Não vai Não vai'),
(56, 137, 'Por fazer'),
(57, 137, 'Em progresso'),
(58, 137, 'Concluído'),
(59, 138, 'Iniciar'),
(60, 138, 'Em progresso'),
(61, 138, 'Concluído'),
(71, 49, 'Testando'),
(85, 145, 'Iniciar'),
(86, 145, 'Em progresso');

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
(26, 41, 49, 'dgp2puotn1NPuZoV8TQS', 'Fluxograma adição de cordeis', 'Criar fluxograma para planejamento da funcionalidade de adicionar novos cordeis'),
(28, 41, 49, 'pwsKeYXHdYi0oakyqC8y', 'testando', 'haoisdhajdpoas'),
(30, 61, 138, 'dgp2puotn1NPuZoV8TQS', 'Criar design do website para iniciar projeto', 'Criar um layout dinâmico e inovador para o site com cores chamativas e ótima usabilidade.'),
(31, 60, 138, 'HyrqVaeZ7GvolI4qbmJE', 'Criar fluxograma do website', 'Preparar fluxograma para realizar todo o planejamento do início do projeto.'),
(32, 60, 138, 'pwsKeYXHdYi0oakyqC8y', 'Preparar telas inicias', 'Criar as telas iniciais do website seguindo os padrões estabelecidos na etapa de design.'),
(33, 59, 138, 'ZkjVBJpOZLk3MAfvp97S', 'Criar lógica para entrada de dados', 'Preparar o código do backend para lidar com as informações enviadas pelo usuário com segurança.'),
(34, 59, 138, 'AaJpqLmvYmDAhJDWkhsl', 'Criar banco de dados', 'Criar o banco de dados com todas as tabelas e conexões necessárias para o funcionamento da página.'),
(35, 56, 137, NULL, 'Teste', ''),
(39, 85, 145, 'dgp2puotn1NPuZoV8TQS', 'Teste novo nome', 'Descrição tarefa de teste\r\n'),
(40, 86, 145, 'ZkjVBJpOZLk3MAfvp97S', 'testando2', '');

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
(18, 'dgp2puotn1NPuZoV8TQS', 'Saulbez', 'saull2504@gmail.com', '$2y$10$L7O8ejQNUT1GQbFlVaZjRuLhtojq8hHKgeFrySwtXX6nntuz0140u', 'IMG-673b9b07c56d48.83204011.jpg'),
(19, '4I05X0gxS1RJt4Tn21es', 'Letícia', 'leticia@gmail.com', '$2y$10$VCedq8fw56.1RwXnQJsAve9dhzHHR7NW9e0rj/zN53wv97wGZZO.K', 'user.png'),
(20, 'HyrqVaeZ7GvolI4qbmJE', 'Gilber', 'gilbertobezerrab@gmail.com', '$2y$10$CDHn/Zl3PH1bzx76bOE.MOYttBj63Jp4u5b43AE9aZc3jCYJZd4bG', 'IMG-673b9b664f1939.42761850.png'),
(21, 'pwsKeYXHdYi0oakyqC8y', 'Claudia', 'claudia@gmail.com', '$2y$10$53qv.aTpSj97sGpKw2iejOMxQkvX2PALIaj1GnFFYRkzZ4bc6yQNu', 'IMG-673b9b405d9357.88669637.png'),
(22, '9kFkMqlc0PYdb2O4gsn7', 'Adasd', 'asdasd@asdad.cs', '$2y$10$cACJ.XKv71I331YFZUCg/OSjL0K6fl7NaWYKxCzrY8IiUc0UaYq02', 'user.png'),
(23, 'QUCHl4qjR0miMfVwJX3z', 'Teste', 'saul@firezap.pro', '$2y$10$8nT6apU/tV7hHN3gwiTg4OB5xv9/dE8XzAxTcQCsGY9jOZxeZIh4.', 'user.png'),
(24, 'jkHKlWHPG1QEzcZchDsI', 'Teste2', 'teste2@gmail.com', '$2y$10$6fULutFcSeywZITiXiboDeHBETQKcAGC3VS7G/g8rXzyJBjBSFDQa', 'user.png'),
(25, 'AaJpqLmvYmDAhJDWkhsl', 'Simone', 'simone@gmail.com', '$2y$10$5JXyD60I8LwP0S2BP6m7EOZWnpbuESO0g4fG75M.f/q16qbA/nhwC', 'IMG-672d286ae55c78.00835830.jpg'),
(26, 'ZkjVBJpOZLk3MAfvp97S', 'Ruan', 'ruan@gmail.com', '$2y$10$Tm98q/OHYGBSUQNI/H2buOw73OYQfM0BjC4YWifzoM6Sr6S7TyfTy', 'IMG-673b9b291e8d66.85647861.png'),
(30, 'jSVHjSPbP8Iwxuvl5PAA', 'Adasd', 'asdasd@asdad.csd', '$2y$10$Lg9P9ZIkML2IFgiIvvDN1eTyrIW60aoihTccHJh3kPVzyxDo5UTim', 'user.png'),
(40, 'INZbmMD34HEDFfYeSsWa', 'Darnley', 'darnley@gmail.com', '$2y$10$uDjVuBgsu1LFf1S8N2zJ8OxVZLYX8hlBR2Y1qSzCRFYF3P8HmOyiu', 'user.png'),
(42, '2hiY95YdcmSHo3h7MKfs', 'Testando', 'testando@gmail.com', '$2y$10$I/d6DSykt7PxSLz4y4SExecDvTuzmfX/WXyEt6QHpF13/NKMU8xzC', 'user.png'),
(44, 'vNnMJmszDtwJ6lXgnc3m', 'Teste3', 'teste3@gmail.com', '$2y$10$dzGsdmGfelL3BLLstPb85egDfmV2om.Pyrh2SttXErz8U.37j3rGm', 'user.png'),
(45, 'pp93wrSDsekMnzpA7Imc', 'Teste4', 'teste4@gmail.com', '$2y$10$isxmdjTev2e7CFrGH5BOreXKt3ipHQEHrwVr4WEnw388ELrtKAYVK', 'user.png'),
(46, 'EVVzgGNINiOHkToeyVeX', 'Teste', 'teste10@gmail.com', '$2y$10$bvFUF6mhaYyTPUEZR/RdT.qi7TVhwiu1SOKhAse3DRUuLuquYKn7m', 'user.png'),
(48, 'Px0mjHz9qAOJo6e58Fcs', 'teste', 'teste1111@gmail.com', '$2y$10$8pfzDIxT1D4pCjVDkC9xTO9QndoRTHeQyOc63ZMW.tczgc7/6ajTO', 'IMG-673b9cc6a4a137.67000713.jpg');

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
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
