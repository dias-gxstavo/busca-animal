-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2024 às 04:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `busca_animal`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anuncios`
--

CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome_animal` varchar(50) NOT NULL,
  `especie` varchar(30) NOT NULL,
  `raca` varchar(50) NOT NULL,
  `idade` int(11) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `data_perdido` date NOT NULL,
  `endereco` varchar(180) NOT NULL,
  `contato` varchar(50) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anuncios`
--

INSERT INTO `anuncios` (`id`, `usuario_id`, `nome_animal`, `especie`, `raca`, `idade`, `cor`, `descricao`, `data_perdido`, `endereco`, `contato`, `imagem`, `data_criacao`) VALUES
(36, 42, 'Kiki', 'cachorro', 'Yorkshire', 1, 'Marrom', '', '2024-11-25', 'Rua Da Consolação, São Paulo - São Paulo, 01302-001, Brazil', '21992922764', 'istockphoto-1503385646-612x612.jpg', '2024-11-25 12:39:49'),
(37, 42, 'Belinha', 'cachorro', 'Yorkshire', 7, 'Marrom', '', '2024-11-19', 'Rua Jorge Lossio, Rio de Janeiro, Rio de Janeiro 20521, Brazil', '21992922764', 'phpThumb_generated_thumbnail.jpeg', '2024-11-26 02:01:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `nome` text NOT NULL,
  `email` varchar(256) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `is_admin`, `nome`, `email`, `senha`, `telefone`, `data_cadastro`) VALUES
(42, 1, 'Gustavo Dias', 'gustavodiashug9@gmail.com', '$2y$10$FcZAmSmDPgCa4Eupuw0gvecb83LUKyaL1suoXeiH.D84FIP/wyvRW', '21885947642', '2024-11-13 18:42:48'),
(45, 1, 'admin', 'projetobusca.animal@gmail.com', '$2y$10$gIO2dfNJhSAYRbbuQdUSduHbvBpijtR2dLMizE4KAiFo7k/Ol7SZe', '(21) 88475-642', '2024-11-23 22:02:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
