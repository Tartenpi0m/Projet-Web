-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 10 mai 2021 à 20:11
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet-web`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `identifiant`, `pass`) VALUES
(1, 'root', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(8, 'Beaute'),
(6, 'Cuisine'),
(7, 'Maison');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `carte_num` bigint(20) NOT NULL DEFAULT '0',
  `carte_cvv` int(11) NOT NULL DEFAULT '0',
  `carte_date` char(7) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `identifiant`, `pass`, `carte_num`, `carte_cvv`, `carte_date`) VALUES
(26, 'user', 'password', 4587536521452365, 125, '125');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` int(10) UNSIGNED NOT NULL,
  `quantite` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_client`, `quantite`) VALUES
(49, 26, 9);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) DEFAULT 'Inconnu',
  `description` tinytext,
  `image_addr` varchar(200) DEFAULT NULL,
  `prix` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `categorie` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  KEY `fk_categorie` (`categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `image_addr`, `prix`, `categorie`) VALUES
(14, 'verre', 'verre d\'eau transparent solide', './imagesArticles/verre.jpg', 85, 6),
(15, 'chaise', 'chaise en bois', './imagesArticles/chaise.jpg', 15, 7),
(16, 'tabouret', 'blanc', './imagesArticles/tabouret.jpg', 5, 7),
(18, 'assiettes', 'assiettes blanches ouverte ', './imagesArticles/assiettes.jpeg', 20, 6),
(19, 'plat', 'plat ouvert blanc', './imagesArticles/plat.jpg', 20, 6),
(20, 'rideaux', 'rideaux de tissu épais couleur rose pale de 80cm * 120cm', './imagesArticles/rideaux.jpg', 30, 7),
(21, 'parfum', 'parfum de marque Séphora  floral agréable pour l\'été ', './imagesArticles/parfum.jpg', 70, 8),
(23, 'creme', 'creme hydratante de jour ', './imagesArticles/creme.jpg', 30, 8),
(24, 'lipstick', 'rouge à levre mat ', './imagesArticles/lipstick.png', 40, 8),
(29, 'parfum1', 'parfum sucré', './imagesArticles/parfum1.jpg', 75, 8);

-- --------------------------------------------------------

--
-- Structure de la table `produit_commande`
--

DROP TABLE IF EXISTS `produit_commande`;
CREATE TABLE IF NOT EXISTS `produit_commande` (
  `id_produit` int(10) UNSIGNED NOT NULL,
  `id_commande` int(10) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_id_produit` (`id_produit`),
  KEY `fk_id_commande` (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit_commande`
--

INSERT INTO `produit_commande` (`id_produit`, `id_commande`, `id`) VALUES
(29, 49, 118),
(16, 49, 119),
(21, 49, 120),
(20, 49, 121),
(20, 49, 122),
(24, 49, 123),
(24, 49, 124),
(23, 49, 125),
(29, 49, 126);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
