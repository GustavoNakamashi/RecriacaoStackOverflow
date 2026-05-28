-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/05/2026 às 05:52
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
-- Banco de dados: `stackoverflow_fatec`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `desafios`
--

CREATE TABLE `desafios` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `dificuldade` varchar(20) DEFAULT 'Médio',
  `data_publicacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `desafios`
--

INSERT INTO `desafios` (`id`, `titulo`, `descricao`, `dificuldade`, `data_publicacao`) VALUES
(1, 'Inverter uma String', 'Escreva uma função que recebe uma string e retorna ela invertida.', 'Fácil', '2026-05-27 20:49:12'),
(2, 'Números Primos', 'Crie um programa que lista todos os números primos até 100.', 'Médio', '2026-05-27 20:49:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `conteudo` text NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `visualizacoes` int(11) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `titulo`, `conteudo`, `usuario_id`, `visualizacoes`, `data_criacao`) VALUES
(1, 'teste', 'teste', 4, 1, '2026-05-28 03:13:00'),
(2, 'teste', 'teste', 4, 20, '2026-05-28 03:13:02'),
(3, 'teste', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', 4, 16, '2026-05-28 03:24:53'),
(4, 'teste', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', 4, 8, '2026-05-28 03:33:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pergunta_tags`
--

CREATE TABLE `pergunta_tags` (
  `pergunta_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pergunta_tags`
--

INSERT INTO `pergunta_tags` (`pergunta_id`, `tag_id`) VALUES
(1, 5),
(2, 5),
(3, 3),
(4, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `autor_nome` varchar(100) DEFAULT NULL,
  `conteudo` text NOT NULL,
  `is_ia` tinyint(1) DEFAULT 0,
  `curtidas` int(11) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas`
--

INSERT INTO `respostas` (`id`, `pergunta_id`, `usuario_id`, `autor_nome`, `conteudo`, `is_ia`, `curtidas`, `data_criacao`) VALUES
(1, 4, NULL, 'Gustavo', 'Resposta Resposta Resposta Resposta Resposta', 0, 0, '2026-05-28 03:37:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_desafios`
--

CREATE TABLE `respostas_desafios` (
  `id` int(11) NOT NULL,
  `desafio_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `autor_nome` varchar(100) DEFAULT NULL,
  `solucao` text NOT NULL,
  `linguagem` varchar(50) DEFAULT 'texto',
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `avaliacao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_desafios`
--

INSERT INTO `respostas_desafios` (`id`, `desafio_id`, `usuario_id`, `autor_nome`, `solucao`, `linguagem`, `data_envio`, `avaliacao`) VALUES
(1, 1, NULL, 'aa', 'aaa', 'aa', '2026-05-28 02:13:27', NULL),
(2, 1, NULL, 'Gustavo', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Document</title>\r\n</head>\r\n<body>\r\n    <p> Resposta </p>\r\n</body>\r\n</html>', 'html', '2026-05-28 03:39:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(5, 'CSS'),
(4, 'HTML'),
(9, 'Java'),
(1, 'JavaScript'),
(7, 'Node.js'),
(3, 'PHP'),
(2, 'Python'),
(6, 'React'),
(8, 'SQL'),
(10, 'TypeScript');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `reputacao` int(11) DEFAULT 0,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `reputacao`, `data_cadastro`) VALUES
(1, 'Administrador', 'admin@stack.com', '0192023a7bbd73250516f069df18b500', 0, '2026-05-27 20:49:12'),
(2, 'João Silva', 'joao@email.com', 'e10adc3949ba59abbe56e057f20f883e', 0, '2026-05-27 20:49:12'),
(3, 'Maria Santos', 'maria@email.com', 'e10adc3949ba59abbe56e057f20f883e', 0, '2026-05-27 20:49:12'),
(4, 'Anônimo', 'anonimo@temp.com', '3d801aa532c1cec3ee82d87a99fdf63f', 0, '2026-05-28 03:13:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `desafios`
--
ALTER TABLE `desafios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `pergunta_tags`
--
ALTER TABLE `pergunta_tags`
  ADD PRIMARY KEY (`pergunta_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Índices de tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pergunta_id` (`pergunta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `respostas_desafios`
--
ALTER TABLE `respostas_desafios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desafio_id` (`desafio_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `desafios`
--
ALTER TABLE `desafios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `respostas_desafios`
--
ALTER TABLE `respostas_desafios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pergunta_tags`
--
ALTER TABLE `pergunta_tags`
  ADD CONSTRAINT `pergunta_tags_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pergunta_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `respostas_desafios`
--
ALTER TABLE `respostas_desafios`
  ADD CONSTRAINT `respostas_desafios_ibfk_1` FOREIGN KEY (`desafio_id`) REFERENCES `desafios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_desafios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
