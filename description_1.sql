-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 01 juin 2024 à 13:43
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
-- Structure de la table `description`
--

CREATE TABLE `description` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `additional_info` text DEFAULT NULL,
  `num_rooms` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `num_floors` int(11) DEFAULT NULL,
  `image_carousel` text DEFAULT NULL,
  `square_meters` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `description`
--

INSERT INTO `description` (`id`, `property_id`, `additional_info`, `num_rooms`, `price`, `num_floors`, `image_carousel`, `square_meters`) VALUES
(1, 6, 'belle maisonnnnnnnnn', 4, 45000.00, 2, 'uploads/bureau1.jpg', 245.00),
(2, 6, 'belle maisonnnnnnnnn', 4, 45000.00, 2, 'uploads/bureau1.jpg', 245.00),
(3, 6, 'belle maisonnnnnnnnn', 4, 45000.00, 2, 'uploads/bureau1.jpg', 245.00),
(4, 7, 'cooool', 4, 345555.00, 2, '', 980.00),
(5, 8, '', 0, 0.00, 0, '', 0.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `description`
--
ALTER TABLE `description`
  ADD CONSTRAINT `description_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
