-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Jan-2020 às 17:35
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `database_evea`
--
CREATE DATABASE IF NOT EXISTS `database_evea` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `database_evea`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_events`
--

CREATE TABLE IF NOT EXISTS `tb_events` (
  `event_id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `colaborator` int(2) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `place` int(1) NOT NULL,
  `event_comment` text DEFAULT NULL,
  `company` varchar(100) NOT NULL,
  `responsible` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `client_comment` text DEFAULT NULL,
  `type` varchar(2) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `tb_events_ibfk_1` (`colaborator`),
  KEY `tb_events_ibfk_2` (`place`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_events`
--

INSERT INTO `tb_events` (`event_id`, `title`, `colaborator`, `start`, `end`, `place`, `event_comment`, `company`, `responsible`, `phone`, `email`, `client_comment`, `type`) VALUES
(27, 'Evento X', 1, '2020-01-13 08:00:00', '2020-01-13 22:00:00', 4, 'nenhuma.', 'Empresa', 'Cliente', '', 'email@email.com', 'nenhuma', 'tc');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_places`
--

CREATE TABLE IF NOT EXISTS `tb_places` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `place` varchar(80) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_places`
--

INSERT INTO `tb_places` (`id`, `place`, `active`) VALUES
(1, 'Convenções', 1),
(2, 'Convenções II', 1),
(3, 'Mario de Mari', 1),
(4, 'Átrio II', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `profile` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`id`, `name`, `profile`, `email`, `password`) VALUES
(1, 'Adriano Lima de Souza', 8, 'surerloki3379@gmail.com', '$2y$10$w5Hxobb4gN1wwC00NZ6e8.knG8yJj0q0eqQulP4aFFbYcSQYc/5iC'),
(3, 'Gabriely Schleider', 8, 'gabrielyschleider@outlook.com', '$2y$10$w5Hxobb4gN1wwC00NZ6e8.knG8yJj0q0eqQulP4aFFbYcSQYc/5iC');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_events`
--
ALTER TABLE `tb_events`
  ADD CONSTRAINT `tb_events_ibfk_1` FOREIGN KEY (`colaborator`) REFERENCES `tb_users` (`id`),
  ADD CONSTRAINT `tb_events_ibfk_2` FOREIGN KEY (`place`) REFERENCES `tb_places` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
