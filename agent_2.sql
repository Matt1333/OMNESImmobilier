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
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prénom` varchar(255) NOT NULL,
  `Telephone` varchar(20) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `CV` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `JourDispo` varchar(255) NOT NULL,
  `digicode` varchar(10) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `specialite` varchar(255) NOT NULL,
  `MDP` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`ID`, `Nom`, `Prénom`, `Telephone`, `Mail`, `CV`, `Photo`, `JourDispo`, `digicode`, `adresse`, `specialite`, `MDP`) VALUES
(2, 'Barcola', 'Bradley', '06 92 29 92 29', 'bradleybls@edu.ece.fr', 'cv_agent2.pdf', 'uploads/Agent2.jpg', 'Jeudi, Vendredi', '1129', '13 Rue Auteuil, 75016, Paris,France', 'Immobilier résidentiel', 'PSG'),
(3, 'Verratti', 'Marco', '07 78 98 06 00', 'marco.verratti@gmail.com', 'uploads/Dossier-reinscription-249888.pdf', 'uploads/Agent2.jpg', 'Lundi,Mardi,Mercredi,Vendredi,Samedi', '', '', 'Appartement à louer', 'NUM6'),
(5, 'Messi', 'Lionel', '0102030103', 'messi@edu.ece.fr', '', '', 'Lundi ', '', '', 'Appartement à louer', '1234'),
(6, 'Touvron', 'Erwan', '0783901950', 'erwan.touvron@gmail.com', '', '', 'Mardi,Jeudi, Vendredi', '', '', 'Immobilier résidentiel', 'Matt');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
