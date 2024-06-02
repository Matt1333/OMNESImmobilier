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
-- Structure de la table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` int(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `adress` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `Etat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `properties`
--

INSERT INTO `properties` (`id`, `type`, `name`, `number`, `city`, `description`, `adress`, `image`, `video`, `Etat`) VALUES
(6, 'Appartement a louer', 'Appartement vue mer', 45, 'Marseille', 'appartement près du vieux port avec vue sur mer', 'Avenue du refuge', 'uploads/appartement2.jpg', 'aucune', 'vendu'),
(7, 'Appartement a louer', 'appartement haussmanien', 11, 'Paris', 'appartement haussmanien au dernier etage avec ascenseur', 'Avenue de la Bourdonnais', 'uploads/appartement1.jpg', 'aucune', 'vendu'),
(8, 'Immobilier_residentiel', 'maison moderne', 41, 'Clamart', 'Une description courte pour une maison moderne pourrait être :\r\n\r\n\"Conçue pour allier élégance contemporaine et confort luxueux, cette maison moderne offre un style architectural épuré et des espaces lumineux. Avec ses lignes épurées, ses matériaux haut de gamme et ses équipements dernier cri, cette propriété incarne le summum du design moderne et de la vie urbaine sophistiquée.\"', 'Rue deut', 'uploads/maison1.jpg', 'aucune', 'En vente'),
(9, 'Immobilier_residentiel', 'Maison familiale avec piscine', 134, 'Limours', 'Maison en banlieue parisienne près des transport pour rallier Paris, maison avec piscine parfait pour se détendre en été', ' rue de l aigle', 'uploads/maison4.jpg', 'aucune', 'En vente'),
(10, 'Immobilier_residentiel', 'maison résidentiel avec sauna', 13, 'Marseille', 'tres beau sauna', '13 avenue victor hugo', 'uploads/maison7.png', 'aucune', 'vendu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
