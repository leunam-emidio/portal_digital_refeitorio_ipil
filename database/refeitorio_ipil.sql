-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Maio-2026 às 19:45
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
-- Banco de dados: `refeitorio_ipil`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuration`
--

CREATE TABLE `configuration` (
  `nome_refeitorio` varchar(20) NOT NULL,
  `descricao_refeitorio` text NOT NULL,
  `boas_vinda` varchar(30) NOT NULL,
  `titulo_index` varchar(50) NOT NULL,
  `descricao_index` text NOT NULL,
  `titulo_home` varchar(50) NOT NULL,
  `descricao_home` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `configuration`
--

INSERT INTO `configuration` (`nome_refeitorio`, `descricao_refeitorio`, `boas_vinda`, `titulo_index`, `descricao_index`, `titulo_home`, `descricao_home`) VALUES
('Refeitório IPIL', 'Um ambiente acolhedor e nutritivo para estudantes, com menu pensado para o bem-estar diário.', 'Bem-vindo ao cardápio digital', 'Descubra o almoço do dia com praticidade e sabor.', 'O Portal Digital do Refeitório IPIL traz a lista de pratos do dia, informações de categorias e a experiência intuitiva para acompanhar seu cardápio escolar.', 'Explore o cardápio e compartilhe suas experiências', 'Como usuário logado, você pode curtir pratos, deixar feedbacks e ver comentários de outros estudantes sobre o refeitório.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `comentary` varchar(255) NOT NULL,
  `liked` tinyint(1) NOT NULL DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `id_user`, `id_menu`, `comentary`, `liked`, `create_at`) VALUES
(1, 2, 1, 'estava incrivel', 1, '2026-05-16 02:49:15'),
(2, 2, 3, 'gostei muito', 1, '2026-05-16 02:49:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` enum('Prato Principal','Acompanhamento','Sobremesa','Bebida') NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `weekdays` enum('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado') NOT NULL,
  `tip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id`, `name`, `category`, `description`, `status`, `image`, `likes`, `weekdays`, `tip`) VALUES
(1, 'Arroz com Feijão', 'Prato Principal', 'Clássico nutritivo, combinação perfeita para o almoço do refeitório.', 'active', 'jsnv', 20, 'Domingo', 'Conforto caseiro'),
(2, 'Salada Tropical', 'Acompanhamento', 'Verduras frescas com toque cítrico para equilibrar a refeição.', 'active', 'sff', 0, 'Domingo', ''),
(3, 'Gelatina de Frutas', 'Sobremesa', 'Doce leve e colorido para fechar a refeição com suavidade.', 'active', 'stgs', 0, 'Domingo', ''),
(4, 'Suco Natural', 'Bebida', 'Bebida fresca preparada com frutas da estação.', 'active', 'imgs/uploads/suco-natural.jpg', 14, 'Domingo', 'bom'),
(5, 'Massa ao Molho', 'Prato Principal', 'Massa saborosa com molho caseiro e ervas aromáticas.', 'active', 'imgs/uploads/massa-ao-molho.jpg', 2000, 'Domingo', 'Conforto caseiro'),
(8, 'suco de limão', 'Bebida', 'jknvj nFJKCN SÇDFKV', 'active', 'imgs/uploads/suco-de-lim-ao.jpg', 0, 'Terça-feira', 'Conforto caseiro'),
(9, '<script>alert(\'Hey\')</script>', 'Prato Principal', 'jfanc jancka  kmfck', 'active', 'imgs/uploads/script-alert-hey-script.jpg', 0, 'Segunda-feira', 'bom');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `create_at`) VALUES
(1, 'Dev', 'dev@gmail.com', '$2y$10$BFZjADZzqiZ9kR5OlTuYue1wWXjJZK1uPoWJyq1v75um1ZlqYRqTe', 'admin', 'active', '2026-05-16 02:28:00'),
(2, 'fafa', 'fafa@gmail.com', '$2y$10$BFZjADZzqiZ9kR5OlTuYue1wWXjJZK1uPoWJyq1v75um1ZlqYRqTe', 'user', 'active', '2026-05-16 02:28:55'),
(3, 'fefe', 'fefe@gmail.com', '$2y$10$JIAnxSa9SEoJWRm0GjqkM.3mJ3HowB5HBGICo.nhmbsvH9JvcSB6i', 'user', 'active', '2026-05-19 20:55:44'),
(4, 'fifi', 'fifi@gmail.com', '$2y$10$yyYTcKe.TjY7XM.hj9p9N.Y.xIobRWvpPl019SaZAhzVGmdj3yw3q', 'user', 'active', '2026-05-19 20:57:15'),
(5, 'fofo', 'fofo@gmail.com', '$2y$10$FbC6EEcdRAvNzLu0NFXfXOmnHMnPEeewu7cxnZC.JXi.DabqG2Nq2', 'user', 'active', '2026-05-19 20:57:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Índices para tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
