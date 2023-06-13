-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Jun-2023 às 06:19
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `confins`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `cor` varchar(7) COLLATE utf8_bin NOT NULL,
  `limite` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `id_usuario`, `nome`, `cor`, `limite`) VALUES
(2, 2, 'Transporte', '#db8585', 0),
(3, 2, 'AlimentaÃ§Ã£o', '#d297d3', 0),
(4, 2, 'Estudos', '#d79056', 0),
(5, 2, 'SaÃºde', '#93b5ec', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` float NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `gastos`
--

INSERT INTO `gastos` (`id`, `id_usuario`, `data`, `valor`, `categoria`) VALUES
(1, 2, '2023-05-04 20:43:09', 200, 2),
(2, 2, '2023-06-04 20:43:43', 20, 2),
(3, 2, '2023-06-04 20:44:17', 200, 2),
(4, 2, '2023-06-04 20:45:39', 49.99, 3),
(5, 2, '2023-06-08 15:01:08', 100, 2),
(7, 2, '2023-06-08 16:17:01', 1000, 2),
(8, 2, '2023-06-08 16:17:16', 2000, 3),
(9, 2, '2023-06-11 15:48:55', 200, 2),
(10, 2, '2023-06-11 15:49:04', 200, 2),
(11, 2, '2023-05-11 17:49:33', 0.05, 2),
(12, 2, '2023-06-11 21:56:47', 0.16, 3),
(13, 2, '2023-06-11 21:57:42', 5, 2),
(14, 2, '2023-06-13 00:21:15', 5000, 4),
(15, 2, '2023-06-13 00:21:49', 250, 5),
(16, 2, '2023-05-19 00:00:00', 2500, 2),
(17, 2, '2023-05-19 00:00:00', 2500, 2),
(18, 2, '2023-04-19 00:00:00', 2900, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `receitas`
--

INSERT INTO `receitas` (`id`, `valor`, `id_usuario`, `data`) VALUES
(1, 500, 2, '2023-06-11 22:40:53'),
(4, 100.5, 2, '2023-06-11 23:22:56'),
(5, 2500, 2, '2023-05-10 00:00:00'),
(6, 3000, 2, '2023-04-21 00:00:00'),
(7, 2500, 2, '2023-05-10 00:00:00'),
(8, 3000, 2, '2023-04-21 00:00:00'),
(9, 2790, 2, '2023-03-21 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `senha` varchar(65) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`) VALUES
(2, 'Enzo', '46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
