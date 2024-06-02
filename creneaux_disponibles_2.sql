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
-- Structure de la table `creneaux_disponibles`
--

CREATE TABLE `creneaux_disponibles` (
  `id` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `jour_semaine` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `creneaux_disponibles`
--

INSERT INTO `creneaux_disponibles` (`id`, `agent_id`, `jour_semaine`, `heure_debut`, `heure_fin`) VALUES
(19, 6, 'Mardi', '11:00:00', '13:00:00'),
(25, 3, 'Mercredi', '14:00:00', '15:00:00'),
(26, 3, 'Vendredi', '20:10:00', '22:10:00'),
(27, 5, 'Lundi', '15:38:00', '17:40:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `creneaux_disponibles`
--
ALTER TABLE `creneaux_disponibles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agent` (`agent_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `creneaux_disponibles`
--
ALTER TABLE `creneaux_disponibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `creneaux_disponibles`
--
ALTER TABLE `creneaux_disponibles`
  ADD CONSTRAINT `fk_agent` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
