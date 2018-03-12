-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 12 mars 2018 à 09:58
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pokemon`
--

-- --------------------------------------------------------

--
-- Structure de la table `dresseur`
--

CREATE TABLE `dresseur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_licence` date NOT NULL,
  `arene_prefere` enum('Argenta','Azuria','Carmin-sur-Mer','Céladopole','Parmanie','Safrania','Cramois''Île','Jadielle') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dresseur`
--

INSERT INTO `dresseur` (`id`, `prenom`, `nom`, `adresse`, `email`, `date_licence`, `arene_prefere`) VALUES
(1, 'Sacha', 'Du Bourgpalette', '3e maison à droite au bord du village', 'jevaisdevenirmaitrepokemon@dresseur.com', '1996-02-27', 'Azuria'),
(2, 'Régis', 'Du Bourgpalette', 'Chateau du village', 'jesuislemeilleurmaitrepokemon@dresseur.com', '1996-02-27', 'Carmin-sur-Mer');

-- --------------------------------------------------------

--
-- Structure de la table `dresseur_pokemon`
--

CREATE TABLE `dresseur_pokemon` (
  `id_dresseur` int(11) NOT NULL,
  `id_pokemon` int(11) NOT NULL,
  `date_capture` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dresseur_pokemon`
--

INSERT INTO `dresseur_pokemon` (`id_dresseur`, `id_pokemon`, `date_capture`) VALUES
(1, 6, '2018-03-08'),
(2, 7, '2018-03-12'),
(2, 10, '2018-03-12');

-- --------------------------------------------------------

--
-- Structure de la table `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type` enum('plante','feu','électrique','eau','normal') NOT NULL,
  `pv` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `attaque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pokemons`
--

INSERT INTO `pokemons` (`id`, `nom`, `type`, `pv`, `defense`, `attaque`) VALUES
(6, 'bulbizarre', 'plante', 45, 49, 49),
(7, 'salamèche', 'feu', 39, 52, 43),
(8, 'pikachu', 'électrique', 35, 55, 40),
(9, 'rattata', 'normal', 30, 56, 35),
(10, 'carapuce', 'eau', 44, 48, 65);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dresseur`
--
ALTER TABLE `dresseur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `dresseur_pokemon`
--
ALTER TABLE `dresseur_pokemon`
  ADD PRIMARY KEY (`id_dresseur`,`id_pokemon`),
  ADD KEY `id_pokemon` (`id_pokemon`);

--
-- Index pour la table `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dresseur`
--
ALTER TABLE `dresseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dresseur_pokemon`
--
ALTER TABLE `dresseur_pokemon`
  ADD CONSTRAINT `dresseur_pokemon_ibfk_1` FOREIGN KEY (`id_dresseur`) REFERENCES `dresseur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dresseur_pokemon_ibfk_2` FOREIGN KEY (`id_pokemon`) REFERENCES `pokemons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
