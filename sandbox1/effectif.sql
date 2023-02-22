-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 fév. 2023 à 19:03
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lsmc`
--

-- --------------------------------------------------------

--
-- Structure de la table `effectif`
--

CREATE TABLE `effectif` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `effectif`
--

INSERT INTO `effectif` (`id`, `pseudo`, `email`, `password`, `ip`, `date_inscription`, `token`) VALUES
(2, 'agassiwong', 'agassi.wong.pro@gmail.com', '$2y$12$IusJbw79Ogns9OiibfR59O4u8v.one.E/1C1uPh73i8WnTvcXH1o.', '::1', '2023-02-22 00:08:10', 'cfe4765b400743637889fd45c9e61de1083c6b055567aa9925a653bd5920817f3a95dd913019c403d93860c930dfe08a3860a1d285d9cb6dea49e873d0486a8e');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `effectif`
--
ALTER TABLE `effectif`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `effectif`
--
ALTER TABLE `effectif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;