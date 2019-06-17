-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 27 mai 2019 à 15:48
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `market`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(10) NOT NULL DEFAULT '0',
  `nom` varchar(255) DEFAULT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_avis_parent` int(100) DEFAULT '0',
  `id_admin_reponse` int(100) DEFAULT NULL COMMENT 'id de l''administrateur ayant repondu',
  `reponse_admin_contenu` text,
  `date_reponse` datetime DEFAULT NULL,
  `page_accueil` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `id_client`, `nom`, `prenoms`, `email`, `contenu`, `localisation`, `id_produit`, `date_creation`, `date_modification`, `id_avis_parent`, `id_admin_reponse`, `reponse_admin_contenu`, `date_reponse`, `page_accueil`) VALUES
(1, 0, 'Koffi', 'Luc', 'koffi.luc@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cocody, angre', 1, '2018-11-08 00:00:00', '2018-11-08 00:00:00', 0, NULL, NULL, NULL, 1),
(2, 0, 'Kone', 'hamed', 'hamed85@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cocody, riviera II', 4, '2018-11-08 00:00:00', '2018-11-08 00:00:00', 0, NULL, NULL, NULL, 1),
(3, 0, 'YAO', 'Elodie', 'elodie225@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cocody, riviera II', 3, '2018-11-08 00:00:00', '2018-11-08 00:00:00', 0, NULL, NULL, NULL, 1),
(4, 0, 'ATTIA', 'paulin', 'paulingris@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Divo, bada', 2, '2018-11-08 00:00:00', '2018-11-08 00:00:00', 0, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories_produits`
--

DROP TABLE IF EXISTS `categories_produits`;
CREATE TABLE IF NOT EXISTS `categories_produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `statut` int(1) DEFAULT '1',
  `image` varchar(255) DEFAULT NULL COMMENT 'lien de limage genere a partire du md5 de la date dajout/modif de limage',
  `icon` varchar(100) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories_produits`
--

INSERT INTO `categories_produits` (`id`, `nom`, `token`, `statut`, `image`, `icon`, `date_creation`, `date_modification`) VALUES
(1, 'légume', 'jjhshgfcbcjhj45ss', 1, 'jjhshgfcbcjhj45ss', 'vegetable', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'boucherie', 'jjhshgfcbcjhj45hhd', 1, 'jjhshgfcbcjhj45hhd', 'chicken', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'cremerie', 'jjhshgfcbcjhj4koi22', 1, 'jjhshgfcbcjhj4koi22', 'oil', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(4, 'poissonnerie', 'jfhcdstgsdhgfcbcjhj45ss', 1, 'jfhcdstgsdhgfcbcjhj45ss', 'fish', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(5, 'fruit', 'kbsedeadbcjhj45ss', 1, 'kbsedeadbcjhj45ss', 'fruit', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(6, 'céréale', 'jhergdvherjd', 1, 'jhergdvherjd', 'seed-bag', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(7, 'féculent', 'ergeverjkvfer', 1, 'ergeverjkvfer', 'potatoes', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(8, 'produit dérivé', 'dscfvrgher258451zdrcc', 1, 'dscfvrgher258451zdrcc', 'rice', '2018-11-02 00:00:00', '2018-11-02 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `tel` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sexe` int(1) NOT NULL,
  `statut` int(1) NOT NULL,
  `image` varchar(255) DEFAULT NULL COMMENT 'lien de limage genere a partire du md5 de la date dajout/modif de limage',
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `token`, `nom`, `prenoms`, `tel`, `email`, `password`, `sexe`, `statut`, `image`, `date_creation`, `date_modification`) VALUES
(1, 'chsdbcbsbhsd5222', 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 1, 'chsdbcbsbhsd5222', '2018-12-03 15:00:00', '2019-04-28 18:12:22'),
(2, 'fvevjhdfvj585csd', 'boss', 'boss', '01010102', 'boss@boss.ci', 'test1234', 0, 0, 'fvevjhdfvj585csd', '2018-12-03 00:00:00', '2018-12-03 00:00:00'),
(6, 'CLI2019010003MKT', 'test', 'testeur', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-01-01 23:52:26', '2019-01-01 23:52:26');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `id_client` int(10) NOT NULL,
  `statut` int(1) NOT NULL COMMENT '0=en attente ; 1=livré ; 2=annulé ; 3=en cours de livraison; 4=rejeté',
  `montant_ht` float NOT NULL,
  `frais_livraison` float NOT NULL,
  `montant_total` float NOT NULL,
  `id_livraison_destination` int(11) NOT NULL,
  `motif_rejet` text,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `token`, `id_client`, `statut`, `montant_ht`, `frais_livraison`, `montant_total`, `id_livraison_destination`, `motif_rejet`, `date_creation`, `date_modification`, `date_livraison`) VALUES
(14, 'CMD2019040007MKT', 1, 2, 6500, 500, 7000, 1, NULL, '2019-04-22 19:06:01', '2019-04-28 18:21:16', NULL),
(7, 'CMD2019030005MKT', 1, 4, 300, 500, 800, 1, NULL, '2019-03-31 01:58:02', '2019-03-31 01:58:02', NULL),
(8, 'CMD2019030006MKT', 1, 1, 300, 500, 800, 1, NULL, '2019-03-31 02:02:50', '2019-03-31 02:02:50', NULL),
(9, 'CMD2019040007MKT', 1, 2, 1100, 500, 1600, 1, NULL, '2019-04-03 08:52:06', '2019-04-28 18:21:16', NULL),
(10, 'CMD2019040008MKT', 1, 1, 1800, 500, 2300, 1, NULL, '2019-04-19 10:31:31', '2019-04-27 15:19:58', NULL),
(11, 'CMD2019040009MKT', 1, 2, 1800, 500, 2300, 1, NULL, '2019-04-06 10:39:02', '2019-04-06 10:39:02', NULL),
(12, 'CMD2019040010MKT', 1, 0, 1800, 500, 2300, 1, NULL, '2019-04-21 10:56:29', '2019-04-06 10:56:29', NULL),
(15, 'CMD2019050008MKT', 1, 0, 1000, 500, 1500, 1, NULL, '2019-04-23 08:39:56', '2019-05-18 08:39:56', NULL),
(16, 'CMD2019050009MKT', 1, 0, 1100, 1500, 2600, 4, NULL, '2019-04-24 08:40:52', '2019-05-18 08:40:52', NULL),
(17, 'CMD2019050010MKT', 1, 0, 1000, 500, 1500, 1, NULL, '2019-04-24 08:41:15', '2019-05-18 08:41:15', NULL),
(18, 'CMD2019050011MKT', 1, 3, 6100, 500, 6600, 1, NULL, '2019-04-24 08:41:42', '2019-05-18 08:41:42', NULL),
(19, 'CMD2019050012MKT', 1, 0, 1100, 1000, 2100, 3, NULL, '2019-04-25 08:42:27', '2019-05-18 08:42:27', NULL),
(20, 'CMD2019050013MKT', 1, 0, 1500, 500, 2000, 1, NULL, '2019-04-26 08:43:39', '2019-05-18 08:43:39', NULL),
(21, 'CMD2019050014MKT', 1, 0, 1000, 500, 1500, 1, NULL, '2019-04-27 08:44:00', '2019-05-18 08:44:00', NULL),
(22, 'CMD2019050015MKT', 1, 0, 6000, 500, 6500, 1, NULL, '2019-04-28 08:44:15', '2019-05-18 08:44:15', NULL),
(23, 'CMD2019050016MKT', 1, 0, 600, 500, 1100, 1, NULL, '2019-04-29 08:44:33', '2019-05-18 08:44:33', NULL),
(24, 'CMD2019050017MKT', 1, 0, 600, 500, 1100, 1, NULL, '2019-04-30 08:45:16', '2019-05-18 08:45:16', NULL),
(25, 'CMD2019050018MKT', 1, 0, 8100, 1500, 9600, 4, NULL, '2019-05-01 08:46:05', '2019-05-18 08:46:05', NULL),
(26, 'CMD2019050019MKT', 1, 0, 2100, 500, 2600, 1, NULL, '2019-05-02 08:46:25', '2019-05-18 08:46:25', NULL),
(27, 'CMD2019050020MKT', 1, 0, 1100, 500, 1600, 1, NULL, '2019-05-03 08:46:56', '2019-05-18 08:46:56', NULL),
(28, 'CMD2019050021MKT', 1, 0, 2600, 500, 3100, 1, NULL, '2019-05-04 08:47:32', '2019-05-18 08:47:32', NULL),
(29, 'CMD2019050022MKT', 1, 0, 6600, 1000, 7600, 3, NULL, '2019-05-05 08:47:59', '2019-05-18 08:47:59', NULL),
(30, 'CMD2019050023MKT', 1, 0, 1700, 500, 2200, 1, NULL, '2019-05-06 08:48:18', '2019-05-18 08:48:18', NULL),
(31, 'CMD2019050024MKT', 1, 0, 8000, 500, 8500, 1, NULL, '2019-05-06 08:48:50', '2019-05-18 08:48:50', NULL),
(32, 'CMD2019050025MKT', 1, 0, 2100, 500, 2600, 1, NULL, '2019-05-06 08:49:07', '2019-05-18 08:49:07', NULL),
(33, 'CMD2019050026MKT', 1, 0, 2000, 500, 2500, 1, NULL, '2019-05-07 08:50:28', '2019-05-18 08:50:28', NULL),
(34, 'CMD2019050027MKT', 1, 0, 2200, 1500, 3700, 4, NULL, '2019-05-08 08:51:08', '2019-05-18 08:51:08', NULL),
(35, 'CMD2019050028MKT', 1, 0, 2700, 500, 3200, 1, NULL, '2019-05-09 08:52:18', '2019-05-18 08:52:18', NULL),
(36, 'CMD2019050029MKT', 1, 0, 5500, 1000, 6500, 2, NULL, '2019-05-23 08:52:42', '2019-05-18 08:52:42', NULL),
(37, 'CMD2019050030MKT', 1, 0, 1000, 500, 1500, 1, NULL, '2019-05-23 08:53:09', '2019-05-18 08:53:09', NULL),
(38, 'CMD2019050031MKT', 1, 0, 6500, 1500, 8000, 4, NULL, '2019-05-23 08:54:01', '2019-05-18 08:54:01', NULL),
(39, 'CMD2019050032MKT', 1, 0, 5100, 500, 5600, 1, NULL, '2019-05-24 08:55:02', '2019-05-18 08:55:02', NULL),
(40, 'CMD2019050033MKT', 1, 0, 1200, 500, 1700, 1, NULL, '2019-05-25 08:57:09', '2019-05-18 08:57:09', NULL),
(41, 'CMD2019050034MKT', 1, 0, 6600, 500, 7100, 1, NULL, '2019-05-25 08:57:31', '2019-05-18 08:57:31', NULL),
(42, 'CMD2019050035MKT', 1, 0, 15000, 500, 15500, 1, NULL, '2019-05-25 09:00:05', '2019-05-18 09:00:05', NULL),
(43, 'CMD2019050036MKT', 1, 0, 1500, 1000, 2500, 2, NULL, '2019-05-26 09:01:01', '2019-05-18 09:01:01', NULL),
(44, 'CMD2019050037MKT', 1, 1, 1100, 500, 1600, 1, NULL, '2019-05-26 09:01:34', '2019-05-18 09:01:34', NULL),
(45, 'CMD2019050038MKT', 1, 1, 2600, 500, 3100, 1, NULL, '2019-05-26 09:02:40', '2019-05-18 09:02:40', NULL),
(46, 'CMD2019050039MKT', 1, 1, 3100, 500, 3600, 1, NULL, '2019-05-26 09:03:10', '2019-05-18 09:03:10', NULL),
(47, 'CMD2019050040MKT', 1, 0, 6600, 500, 7100, 1, NULL, '2019-05-26 09:03:30', '2019-05-18 09:03:30', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commandes_produits`
--

DROP TABLE IF EXISTS `commandes_produits`;
CREATE TABLE IF NOT EXISTS `commandes_produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_commande` int(10) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `quantite` int(10) NOT NULL,
  `qtte_unitaire` int(11) DEFAULT NULL,
  `prix_qtte_unitaire` float DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes_produits`
--

INSERT INTO `commandes_produits` (`id`, `id_commande`, `id_produit`, `quantite`, `qtte_unitaire`, `prix_qtte_unitaire`, `date_creation`, `date_modification`) VALUES
(14, 7, 2, 1, 3, 100, '2019-03-31 01:58:02', '2019-03-31 01:58:02'),
(15, 7, 8, 1, 3, 100, '2019-03-31 01:58:02', '2019-03-31 01:58:02'),
(16, 8, 2, 1, 3, 100, '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
(17, 8, 8, 1, 3, 500, '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
(18, 9, 2, 1, 3, 600, '2019-04-03 08:52:06', '2019-04-03 08:52:06'),
(19, 9, 1, 1, 5, 400, '2019-04-03 08:52:06', '2019-04-03 08:52:06'),
(20, 9, 7, 1, 1, 150, '2019-04-03 08:52:06', '2019-04-03 08:52:06'),
(21, 10, 3, 1, 3, 250, '2019-04-06 10:31:31', '2019-04-06 10:31:31'),
(22, 10, 2, 2, 3, 350, '2019-04-06 10:31:31', '2019-04-06 10:31:31'),
(23, 11, 3, 1, 3, 450, '2019-04-06 10:39:02', '2019-04-06 10:39:02'),
(24, 11, 2, 2, 3, 900, '2019-04-06 10:39:03', '2019-04-06 10:39:03'),
(25, 12, 3, 1, 3, 900, '2019-04-06 10:56:29', '2019-04-06 10:56:29'),
(26, 12, 2, 2, 3, 200, '2019-04-06 10:56:29', '2019-04-06 10:56:29'),
(29, 14, 1, 1, 5, 500, '2019-04-22 19:06:01', '2019-04-22 19:06:01'),
(30, 14, 5, 1, 1, 5000, '2019-04-22 19:06:01', '2019-04-22 19:06:01'),
(31, 14, 6, 1, 1, 1000, '2019-04-22 19:06:01', '2019-04-22 19:06:01'),
(32, 15, 7, 1, 1, 500, '2019-05-18 08:39:57', '2019-05-18 08:39:57'),
(33, 15, 1, 1, 5, 500, '2019-05-18 08:39:57', '2019-05-18 08:39:57'),
(34, 16, 7, 2, 1, 500, '2019-05-18 08:40:52', '2019-05-18 08:40:52'),
(35, 16, 2, 1, 3, 100, '2019-05-18 08:40:52', '2019-05-18 08:40:52'),
(36, 17, 1, 1, 5, 500, '2019-05-18 08:41:15', '2019-05-18 08:41:15'),
(37, 17, 7, 1, 1, 500, '2019-05-18 08:41:15', '2019-05-18 08:41:15'),
(38, 18, 5, 1, 1, 5000, '2019-05-18 08:41:42', '2019-05-18 08:41:42'),
(39, 18, 6, 1, 1, 1000, '2019-05-18 08:41:42', '2019-05-18 08:41:42'),
(40, 18, 2, 1, 3, 100, '2019-05-18 08:41:42', '2019-05-18 08:41:42'),
(41, 19, 7, 1, 1, 500, '2019-05-18 08:42:27', '2019-05-18 08:42:27'),
(42, 19, 2, 1, 3, 100, '2019-05-18 08:42:27', '2019-05-18 08:42:27'),
(43, 19, 1, 1, 5, 500, '2019-05-18 08:42:27', '2019-05-18 08:42:27'),
(44, 20, 6, 1, 1, 1000, '2019-05-18 08:43:39', '2019-05-18 08:43:39'),
(45, 20, 7, 1, 1, 500, '2019-05-18 08:43:39', '2019-05-18 08:43:39'),
(46, 21, 7, 2, 1, 500, '2019-05-18 08:44:00', '2019-05-18 08:44:00'),
(47, 22, 6, 1, 1, 1000, '2019-05-18 08:44:15', '2019-05-18 08:44:15'),
(48, 22, 5, 1, 1, 5000, '2019-05-18 08:44:15', '2019-05-18 08:44:15'),
(49, 23, 1, 1, 5, 500, '2019-05-18 08:44:33', '2019-05-18 08:44:33'),
(50, 23, 2, 1, 3, 100, '2019-05-18 08:44:33', '2019-05-18 08:44:33'),
(51, 24, 7, 1, 1, 500, '2019-05-18 08:45:16', '2019-05-18 08:45:16'),
(52, 24, 2, 1, 3, 100, '2019-05-18 08:45:16', '2019-05-18 08:45:16'),
(53, 25, 6, 1, 1, 1000, '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(54, 25, 3, 1, 3, 1600, '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(55, 25, 7, 1, 1, 500, '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(56, 25, 5, 1, 1, 5000, '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(57, 26, 7, 1, 1, 500, '2019-05-18 08:46:25', '2019-05-18 08:46:25'),
(58, 26, 3, 1, 3, 1600, '2019-05-18 08:46:25', '2019-05-18 08:46:25'),
(59, 27, 6, 1, 1, 1000, '2019-05-18 08:46:56', '2019-05-18 08:46:56'),
(60, 27, 2, 1, 3, 100, '2019-05-18 08:46:56', '2019-05-18 08:46:56'),
(61, 28, 7, 1, 1, 500, '2019-05-18 08:47:32', '2019-05-18 08:47:32'),
(62, 28, 1, 1, 5, 500, '2019-05-18 08:47:32', '2019-05-18 08:47:32'),
(63, 28, 3, 1, 3, 1600, '2019-05-18 08:47:32', '2019-05-18 08:47:32'),
(64, 29, 5, 1, 1, 5000, '2019-05-18 08:47:59', '2019-05-18 08:47:59'),
(65, 29, 3, 1, 3, 1600, '2019-05-18 08:47:59', '2019-05-18 08:47:59'),
(66, 30, 2, 1, 3, 100, '2019-05-18 08:48:18', '2019-05-18 08:48:18'),
(67, 30, 3, 1, 3, 1600, '2019-05-18 08:48:18', '2019-05-18 08:48:18'),
(68, 31, 1, 1, 5, 500, '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(69, 31, 7, 1, 1, 500, '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(70, 31, 5, 1, 1, 5000, '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(71, 31, 6, 2, 1, 1000, '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(72, 32, 3, 1, 3, 1600, '2019-05-18 08:49:07', '2019-05-18 08:49:07'),
(73, 32, 7, 1, 1, 500, '2019-05-18 08:49:07', '2019-05-18 08:49:07'),
(74, 33, 7, 4, 1, 500, '2019-05-18 08:50:28', '2019-05-18 08:50:28'),
(75, 34, 2, 1, 3, 100, '2019-05-18 08:51:08', '2019-05-18 08:51:08'),
(76, 34, 7, 1, 1, 500, '2019-05-18 08:51:08', '2019-05-18 08:51:08'),
(77, 34, 3, 1, 3, 1600, '2019-05-18 08:51:08', '2019-05-18 08:51:08'),
(78, 35, 4, 1, 1, 1000, '2019-05-18 08:52:18', '2019-05-18 08:52:18'),
(79, 35, 2, 1, 3, 100, '2019-05-18 08:52:18', '2019-05-18 08:52:18'),
(80, 35, 3, 1, 3, 1600, '2019-05-18 08:52:18', '2019-05-18 08:52:18'),
(81, 36, 5, 1, 1, 5000, '2019-05-18 08:52:42', '2019-05-18 08:52:42'),
(82, 36, 7, 1, 1, 500, '2019-05-18 08:52:42', '2019-05-18 08:52:42'),
(83, 37, 1, 1, 5, 500, '2019-05-18 08:53:09', '2019-05-18 08:53:09'),
(84, 37, 7, 1, 1, 500, '2019-05-18 08:53:09', '2019-05-18 08:53:09'),
(85, 38, 7, 1, 1, 500, '2019-05-18 08:54:01', '2019-05-18 08:54:01'),
(86, 38, 6, 1, 1, 1000, '2019-05-18 08:54:01', '2019-05-18 08:54:01'),
(87, 38, 5, 1, 1, 5000, '2019-05-18 08:54:01', '2019-05-18 08:54:01'),
(88, 39, 2, 1, 3, 100, '2019-05-18 08:55:02', '2019-05-18 08:55:02'),
(89, 39, 5, 1, 1, 5000, '2019-05-18 08:55:02', '2019-05-18 08:55:02'),
(90, 40, 8, 1, 3, 200, '2019-05-18 08:57:09', '2019-05-18 08:57:09'),
(91, 40, 4, 1, 1, 1000, '2019-05-18 08:57:09', '2019-05-18 08:57:09'),
(92, 41, 5, 1, 1, 5000, '2019-05-18 08:57:31', '2019-05-18 08:57:31'),
(93, 41, 3, 1, 3, 1600, '2019-05-18 08:57:31', '2019-05-18 08:57:31'),
(94, 42, 5, 3, 1, 5000, '2019-05-18 09:00:05', '2019-05-18 09:00:05'),
(95, 43, 6, 1, 1, 1000, '2019-05-18 09:01:02', '2019-05-18 09:01:02'),
(96, 43, 7, 1, 1, 500, '2019-05-18 09:01:02', '2019-05-18 09:01:02'),
(97, 44, 1, 1, 5, 500, '2019-05-18 09:01:34', '2019-05-18 09:01:34'),
(98, 44, 7, 1, 1, 500, '2019-05-18 09:01:34', '2019-05-18 09:01:34'),
(99, 44, 2, 1, 3, 100, '2019-05-18 09:01:34', '2019-05-18 09:01:34'),
(100, 45, 3, 1, 3, 1600, '2019-05-18 09:02:40', '2019-05-18 09:02:40'),
(101, 45, 6, 1, 1, 1000, '2019-05-18 09:02:40', '2019-05-18 09:02:40'),
(102, 46, 3, 1, 3, 1600, '2019-05-18 09:03:10', '2019-05-18 09:03:10'),
(103, 46, 6, 1, 1, 1000, '2019-05-18 09:03:10', '2019-05-18 09:03:10'),
(104, 46, 1, 1, 5, 500, '2019-05-18 09:03:10', '2019-05-18 09:03:10'),
(105, 47, 5, 1, 1, 5000, '2019-05-18 09:03:30', '2019-05-18 09:03:30'),
(106, 47, 3, 1, 3, 1600, '2019-05-18 09:03:30', '2019-05-18 09:03:30');

-- --------------------------------------------------------

--
-- Structure de la table `livraison_destinations`
--

DROP TABLE IF EXISTS `livraison_destinations`;
CREATE TABLE IF NOT EXISTS `livraison_destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `commune` varchar(255) NOT NULL,
  `frais` float NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livraison_destinations`
--

INSERT INTO `livraison_destinations` (`id`, `token`, `commune`, `frais`, `date_creation`, `date_modification`) VALUES
(1, 'hfhfhcdsjlll55d', 'cocody', 500, '2019-01-13 08:12:00', '2019-01-13 08:12:00'),
(2, 'nhcfqsffsbxhx', 'bingerville', 1000, '2019-01-13 08:12:00', '2019-01-13 08:12:00'),
(3, 'kdkckcdk15d4', 'Adjamé', 1000, '2018-11-01 00:00:00', '2018-12-05 00:00:00'),
(4, 'mooc45dddcddd', 'Yopougon', 1500, '2018-12-05 00:00:00', '2018-12-05 00:00:00'),
(5, 'mongsfsfccxxx', 'Marcory', 2000, '2018-12-05 00:00:00', '2018-12-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL DEFAULT '0',
  `nom_prenoms` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `id_client`, `nom_prenoms`, `email`, `objet`, `contenu`, `date_creation`, `date_modification`) VALUES
(1, 1, 'Oumar Check', 'check.oumar@test.ci', 'TEST', 'TEST', '2019-01-27 20:18:18', '2019-01-27 20:18:18'),
(2, 0, 'Romeo Kesso', 'test@test.ci', 'TEST', 'POPO', '2019-01-27 20:19:15', '2019-01-27 20:19:15'),
(3, 0, 'Romeo testeur', 'test@test.ci', ' ', 'La belle Nadi ChouChou !', '2019-01-27 20:20:14', '2019-01-27 20:20:14'),
(4, 0, 'test', 'test@test.ci', 'TEST', 'TESTEUR', '2019-05-03 08:08:36', '2019-05-03 08:08:36');

-- --------------------------------------------------------

--
-- Structure de la table `paniers_promo`
--

DROP TABLE IF EXISTS `paniers_promo`;
CREATE TABLE IF NOT EXISTS `paniers_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `description` text,
  `prix_panier` float NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `paniers_promo_produits`
--

DROP TABLE IF EXISTS `paniers_promo_produits`;
CREATE TABLE IF NOT EXISTS `paniers_promo_produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_panier` int(5) DEFAULT NULL,
  `id_produit` int(10) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `description` text,
  `token` varchar(255) DEFAULT NULL,
  `stock` int(10) NOT NULL DEFAULT '0',
  `id_categorie_produit` int(10) DEFAULT NULL,
  `id_unite` int(5) DEFAULT NULL COMMENT 'permet de dire si le produit se vend en litre, en kg, en metre ou en nombre',
  `quantite_unitaire` float DEFAULT NULL COMMENT 'en quelle quatité le produit est vendu. Par Ex 3xorange/100F',
  `prix_quantite_unitaire` float DEFAULT NULL,
  `id_taille` int(1) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `statut` int(1) NOT NULL DEFAULT '0' COMMENT '1=actif, 0=non_actif',
  `image` varchar(255) DEFAULT NULL COMMENT 'lien de limage genere a partire du md5 de la date dajout/modif de limage',
  `page_accueil` int(1) NOT NULL DEFAULT '0' COMMENT '1=peut etre presenté sur la page d''accueil, 0=a ne pas presenter sur la page d''accueil',
  `nouveau` int(1) NOT NULL DEFAULT '0' COMMENT '1=nouveau produit, 0=ancien',
  `promo` int(1) NOT NULL DEFAULT '0' COMMENT '1=en promo, 0=pas de promo',
  `pourcentage_promo` float NOT NULL DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `token`, `stock`, `id_categorie_produit`, `id_unite`, `quantite_unitaire`, `prix_quantite_unitaire`, `id_taille`, `slug`, `statut`, `image`, `page_accueil`, `nouveau`, `promo`, `pourcentage_promo`, `date_creation`, `date_modification`) VALUES
(1, 'tomate', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'aaaaaaaaa123', 55, 1, 3, 5, 500, 2, 'tomate-moyen-legume-aaaaaaaaa123', 1, 'aaaaaaaaa123', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-04-28 18:21:16'),
(2, 'carotte', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'bbbbbbbbbbb589', 97, 1, 3, 3, 100, 4, 'carotte-moyen-bbbbbbbbbbb589', 1, 'bbbbbbbbbbb589', 1, 1, 0, 0, '2018-11-01 00:00:00', '2019-04-27 15:19:58'),
(3, 'carpe', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'cccccccccccc256', 82, 4, 3, 3, 2000, 4, 'carpe-poissonnerie-cccccccccccc256', 1, 'cccccccccccc256', 1, 1, 1, 20, '2018-11-01 00:00:00', '2019-04-27 15:19:58'),
(4, 'crevette', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ddddddddddddd585', 498, 4, 1, 1, 1000, 4, 'crevette-poissonnerie-ddddddddddddd585', 1, 'ddddddddddddd585', 1, 0, 0, 0, '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(5, 'poule pondeuse', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'zsfjchjzesg5555aaa', 88, 2, 3, 1, 5000, 4, 'poule-pondeuse-boucherie-zsfjchjzesg5555aaa', 1, 'zsfjchjzesg5555aaa', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-04-28 18:21:16'),
(6, 'oignon', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'qdsfgersdgrd552000', 390, 1, 1, 1, 1000, 4, 'oignon-legume-qdsfgersdgrd552000', 1, 'qdsfgersdgrd552000', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-04-28 18:21:16'),
(7, 'chou', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mmmmmmmmmmm255', 475, 1, 3, 1, 500, 4, 'chou-legume-mmmmmmmmmmm255', 1, 'mmmmmmmmmmm255', 1, 0, 0, 0, '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(8, 'orange', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'xsdrfghhnk25hhh', 94, 5, 3, 3, 200, 4, 'orange-fruits-xsdrfghhnk25hhh', 1, 'xsdrfghhnk25hhh', 1, 0, 0, 0, '2018-11-01 00:00:00', '2018-11-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

DROP TABLE IF EXISTS `publicites`;
CREATE TABLE IF NOT EXISTS `publicites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(2) NOT NULL,
  `entreprise` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL COMMENT 'lien de limage genere a partire du md5 de la date dajout/modif de limage',
  `duree` int(10) NOT NULL COMMENT 'en jour',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `publicites`
--

INSERT INTO `publicites` (`id`, `position`, `entreprise`, `token`, `date_creation`, `date_modification`, `statut`, `image`, `duree`) VALUES
(1, 1, 'fanta', 'fdhfhdgdgdh555', '2018-11-08 08:16:17', '2018-11-08 08:16:17', 1, NULL, 30),
(2, 1, 'coca', 'qdtdtggdgdh444', '2018-11-08 08:16:17', '2018-11-08 08:16:17', 0, NULL, 30),
(3, 2, 'aromate', 'kckkchghxqs552', '2018-11-13 00:00:00', '2018-11-13 00:00:00', 1, NULL, 30),
(4, 3, 'kingkash', 'mljhtgrdfygutjjj', '2018-11-14 00:00:00', '2018-11-20 00:00:00', 1, NULL, 60);

-- --------------------------------------------------------

--
-- Structure de la table `shipping_infos`
--

DROP TABLE IF EXISTS `shipping_infos`;
CREATE TABLE IF NOT EXISTS `shipping_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(100) NOT NULL,
  `id_commande` int(100) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_destination` int(100) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `shipping_infos`
--

INSERT INTO `shipping_infos` (`id`, `id_client`, `id_commande`, `nom`, `prenoms`, `tel`, `email`, `id_destination`, `quartier`, `description`, `date_creation`, `date_modification`) VALUES
(1, 1, 7, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'petro                                        ', '2019-03-31 01:58:02', '2019-03-31 01:58:02'),
(2, 1, 8, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'petro                                        ', '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
(3, 1, 9, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'zfczeqdazeqxd', '2019-04-03 08:52:06', '2019-04-03 08:52:06'),
(4, 1, 10, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'ETST TEST', '2019-04-06 10:31:31', '2019-04-06 10:31:31'),
(5, 1, 11, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'TEST TEST', '2019-04-06 10:39:03', '2019-04-06 10:39:03'),
(6, 1, 12, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', 'TEST TEST', '2019-04-06 10:56:29', '2019-04-06 10:56:29'),
(8, 1, 14, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', 'Boulangerie Jerusalem', '2019-04-22 19:06:01', '2019-04-22 19:06:01'),
(9, 1, 15, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '                                        ', '2019-05-18 08:39:57', '2019-05-18 08:39:57'),
(10, 1, 16, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'niango', '                                        ', '2019-05-18 08:40:52', '2019-05-18 08:40:52'),
(11, 1, 17, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yegetdg', '                                        ', '2019-05-18 08:41:15', '2019-05-18 08:41:15'),
(12, 1, 18, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '                                        ', '2019-05-18 08:41:42', '2019-05-18 08:41:42'),
(13, 1, 19, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 3, 'rhtyjt', '                                        ', '2019-05-18 08:42:27', '2019-05-18 08:42:27'),
(14, 1, 20, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yuiul', '                                        ', '2019-05-18 08:43:39', '2019-05-18 08:43:39'),
(15, 1, 21, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'rtyukil', '                                        ', '2019-05-18 08:44:00', '2019-05-18 08:44:00'),
(16, 1, 22, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'zegryui', '                                        ', '2019-05-18 08:44:15', '2019-05-18 08:44:15'),
(17, 1, 23, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ertyuio', '                                        ', '2019-05-18 08:44:33', '2019-05-18 08:44:33'),
(18, 1, 24, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ujtyhtht', 'gjktrgjhrfbgjdfv', '2019-05-18 08:45:16', '2019-05-18 08:45:16'),
(19, 1, 25, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'Niangon', '                                        ', '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(20, 1, 26, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'jkliukyuthr', '                                        ', '2019-05-18 08:46:25', '2019-05-18 08:46:25'),
(21, 1, 27, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '                                        ', '2019-05-18 08:46:56', '2019-05-18 08:46:56'),
(22, 1, 28, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '                                        ', '2019-05-18 08:47:32', '2019-05-18 08:47:32'),
(23, 1, 29, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 3, 'loiubhb', '                                        ', '2019-05-18 08:47:59', '2019-05-18 08:47:59'),
(24, 1, 30, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '                                        ', '2019-05-18 08:48:18', '2019-05-18 08:48:18'),
(25, 1, 31, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '                                        ', '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(26, 1, 32, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yegetdg', '                                        ', '2019-05-18 08:49:07', '2019-05-18 08:49:07'),
(27, 1, 33, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '                                        ', '2019-05-18 08:50:28', '2019-05-18 08:50:28'),
(28, 1, 34, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'niango', '                                        ', '2019-05-18 08:51:08', '2019-05-18 08:51:08'),
(29, 1, 35, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ghyugfdfgfh', '                                        ', '2019-05-18 08:52:18', '2019-05-18 08:52:18'),
(30, 1, 36, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 2, 'iouyht', '                                        ', '2019-05-18 08:52:42', '2019-05-18 08:52:42'),
(31, 1, 37, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '                                        ', '2019-05-18 08:53:09', '2019-05-18 08:53:09'),
(32, 1, 38, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'Niangon', '                                        ', '2019-05-18 08:54:01', '2019-05-18 08:54:01'),
(33, 1, 39, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '                                        ', '2019-05-18 08:55:02', '2019-05-18 08:55:02'),
(34, 1, 40, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '                                        ', '2019-05-18 08:57:09', '2019-05-18 08:57:09'),
(35, 1, 41, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '                                        ', '2019-05-18 08:57:31', '2019-05-18 08:57:31'),
(36, 1, 42, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '                                        ', '2019-05-18 09:00:05', '2019-05-18 09:00:05'),
(37, 1, 43, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 2, 'yegetdg', '                                        ', '2019-05-18 09:01:02', '2019-05-18 09:01:02'),
(38, 1, 44, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '                                        ', '2019-05-18 09:01:34', '2019-05-18 09:01:34'),
(39, 1, 45, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '                                        ', '2019-05-18 09:02:40', '2019-05-18 09:02:40'),
(40, 1, 46, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '                                        ', '2019-05-18 09:03:10', '2019-05-18 09:03:10'),
(41, 1, 47, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '                                        ', '2019-05-18 09:03:30', '2019-05-18 09:03:30');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(100) DEFAULT NULL,
  `quantite_initiale` int(100) DEFAULT NULL,
  `quantite_reserve` int(100) DEFAULT NULL,
  `quantite_paye` int(100) DEFAULT NULL,
  `quantite_resta,te` int(100) DEFAULT NULL,
  `statut` int(1) DEFAULT NULL COMMENT '1=en cours; 0=epuise',
  `id_fournisseur` int(100) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tailles`
--

DROP TABLE IF EXISTS `tailles`;
CREATE TABLE IF NOT EXISTS `tailles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tailles`
--

INSERT INTO `tailles` (`id`, `nom`) VALUES
(1, 'petite'),
(2, 'moyenne'),
(3, 'grande'),
(4, 'normale'),
(5, 'NA');

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

DROP TABLE IF EXISTS `unites`;
CREATE TABLE IF NOT EXISTS `unites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `symbole` varchar(5) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `libelle`, `symbole`, `date_creation`, `date_modification`) VALUES
(1, 'kilogramme', 'Kg', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'litre', 'L', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'nombre', 'NA', '2018-11-01 00:00:00', '2018-11-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `tel` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `statut` int(1) NOT NULL,
  `image` varchar(255) DEFAULT NULL COMMENT 'lien de limage genere a partire du md5 de la date dajout/modif de limage',
  `id_profil` int(5) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `token`, `nom`, `prenoms`, `tel`, `email`, `password`, `statut`, `image`, `id_profil`, `date_creation`, `date_modification`) VALUES
(1, 'chsdbcbsbhsd5222', 'Admin', 'Boss', '09841171', 'admin@market.com', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 'chsdbcbsbhsd5222', 1, '2019-05-08 00:00:00', '2019-05-01 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
