-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 01 juin 2024 à 13:42
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `maison`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Carte_bancaire` varchar(16) NOT NULL,
  `Expiration` date NOT NULL,
  `Code_securite` varchar(4) NOT NULL,
  `MDP` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`ID`, `Nom`, `Prenom`, `Mail`, `Telephone`, `Carte_bancaire`, `Expiration`, `Code_securite`, `MDP`) VALUES
(1, 'Davidson', 'Matt', 'matt.davidson@edu.ece.fr', '06 06 06 90 90', '1234983781930193', '2027-05-06', '1233', 'Erwan'),
(2, 'Dimaria', 'Angel', 'angel@edu.ece.fr', '0709192802', '1234123412341234', '0000-00-00', '1234', 'PSG11'),
(3, 'Ramos', 'Goncalo', 'Gramos@edu.ece.fr', '0902801820', '1234123412341222', '2025-02-12', '1239', 'PSG9'),
(4, 'Alejandro', 'Garnacho', 'GG@edu.ece.fr', '1001933993', '1I3I3II3', '2033-12-12', '1333', 'But');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
