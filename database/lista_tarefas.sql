-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Maio-2026 às 01:26
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lista_tarefas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `create_at`) VALUES
(DEFAULT, 'Dev', 'dev@gmail.com', '$2y$10$BFZjADZzqiZ9kR5OlTuYue1wWXjJZK1uPoWJyq1v75um1ZlqYRqTe', 'admin', '2026-05-12 01:18:11'),
(DEFAULT, 'Fafa', 'fafa@gmail.com', '$2y$10$BFZjADZzqiZ9kR5OlTuYue1wWXjJZK1uPoWJyq1v75um1ZlqYRqTe', 'user', '2026-05-12 01:46:41'),


