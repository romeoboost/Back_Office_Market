-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 01 juil. 2019 à 17:22
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories_produits`
--

INSERT INTO `categories_produits` (`id`, `nom`, `token`, `statut`, `image`, `icon`, `date_creation`, `date_modification`) VALUES
(1, 'légume', 'jjhshgfcbcjhj45ss', 1, 'jjhshgfcbcjhj45ss', 'vegetable', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'boucherie', 'jjhshgfcbcjhj45hhd', 1, 'jjhshgfcbcjhj45hhd', 'chicken', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'cremerie', 'jjhshgfcbcjhj4koi22', 1, 'jjhshgfcbcjhj4koi22', 'oil', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(4, 'poissonnerie', 'jfhcdstgsdhgfcbcjhj45ss', 1, 'jfhcdstgsdhgfcbcjhj45ss', 'fish', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(5, 'fruit', 'kbsedeadbcjhj45ss', 1, 'kbsedeadbcjhj45ss', 'fruit', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(6, 'Céréales', 'jhergdvherjd', 1, '650b2de60935fb31340be95a729072e6', 'seed-bag', '2018-11-01 00:00:00', '2019-06-23 15:20:58'),
(7, 'féculent', 'ergeverjkvfer', 1, 'ergeverjkvfer', 'potatoes', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(8, 'produit dérivé', 'dscfvrgher258451zdrcc', 1, 'dscfvrgher258451zdrcc', 'rice', '2018-11-02 00:00:00', '2018-11-02 00:00:00'),
(13, 'Crustacés', 'CTP2019060009AM', 0, 'f797cd6ce7e5186a96482e1e99d9a35c', 'fruit', '2019-06-23 18:12:35', '2019-06-23 18:12:35'),
(14, 'TEST', 'CTP2019060010AM', 1, '650b2de60935fb31340be95a729072e6', 'seed-bag', '2018-11-01 00:00:00', '2019-06-23 15:20:58'),
(15, 'TEST 2350', 'CTP2019060011AM', 1, 'ergeverjkvfer', 'potatoes', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(16, 'TEST bibine', 'CTP2019060012AM', 1, 'dscfvrgher258451zdrcc', 'rice', '2018-11-02 00:00:00', '2018-11-02 00:00:00'),
(17, 'Alcool', 'CTP2019060013AM', 0, 'f797cd6ce7e5186a96482e1e99d9a35c', 'fruit', '2019-06-23 18:12:35', '2019-06-23 18:12:35'),
(18, 'TEST', 'CTP2019060018AM', 0, 'f18ecb7faff47e319b555211f07d8fd3', 'oil', '2019-06-30 11:21:30', '2019-06-30 11:21:30');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `token`, `nom`, `prenoms`, `tel`, `email`, `password`, `sexe`, `statut`, `image`, `date_creation`, `date_modification`) VALUES
(1, 'CLI2019010001MKT', 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 1, 'chsdbcbsbhsd5222', '2018-12-03 15:00:00', '2019-04-28 18:12:22'),
(2, 'CLI2019010002MKT', 'boss', 'boss', '01010102', 'boss@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 0, 0, 'fvevjhdfvj585csd', '2018-12-03 00:00:00', '2018-12-03 00:00:00'),
(6, 'CLI2019010003MKT', 'test', 'testeur', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-01-01 23:52:26', '2019-01-01 23:52:26'),
(7, 'CLI2019010004MKT', 'TEST', 'BOBI', '01010102', 'test4@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 0, 'CLI2019010004MKT', '2019-06-03 00:00:00', '2019-06-03 00:00:00'),
(8, 'CLI2019010005MKT', 'MERLIN', 'MAGICIEN', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-06-05 00:00:00', '2019-06-05 00:00:00'),
(9, 'CLI2019010006MKT', 'AMINA', 'DIALO', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-04-01 23:52:26', '2019-04-01 23:52:26'),
(10, 'CLI2019010007MKT', 'TEST', 'Bobi', '01010102', 'bobi@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 1, 'CLI2019010008MKT', '2019-06-03 00:00:00', '2019-06-27 00:54:36'),
(11, 'CLI2019010008MKT', 'MATHIEU', 'BIBO', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 0, NULL, '2019-06-05 00:00:00', '2019-06-26 23:56:40'),
(13, 'CLI2019010010MKT', 'titan', 'pere', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 1, 1, NULL, '2019-04-01 23:52:26', '2019-04-01 23:52:26'),
(14, 'CLI2019010011MKT', 'ali', 'fere', '01010102', 'ali@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 0, 'CLI2019010008MKT', '2019-06-03 00:00:00', '2019-06-03 00:00:00'),
(15, 'CLI2019010012MKT', 'EDWIGE', 'Bile', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-06-05 00:00:00', '2019-06-05 00:00:00');

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
  `id_livreur` int(20) DEFAULT NULL,
  `id_utilisateur` int(20) DEFAULT NULL,
  `motif_rejet` text,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `token`, `id_client`, `statut`, `montant_ht`, `frais_livraison`, `montant_total`, `id_livraison_destination`, `id_livreur`, `id_utilisateur`, `motif_rejet`, `date_creation`, `date_modification`, `date_livraison`) VALUES
(14, 'CMD2019040007MKT', 1, 2, 6500, 500, 7000, 1, NULL, 0, NULL, '2019-04-22 19:06:01', '2019-04-28 18:21:16', NULL),
(7, 'CMD2019030005MKT', 1, 4, 300, 500, 800, 1, NULL, 0, NULL, '2019-03-31 01:58:02', '2019-03-31 01:58:02', NULL),
(8, 'CMD2019030006MKT', 1, 1, 300, 500, 800, 1, 2, 0, NULL, '2019-03-31 02:02:50', '2019-03-31 02:02:50', NULL),
(9, 'CMD2019040007MKT', 1, 2, 1100, 500, 1600, 1, NULL, 0, NULL, '2019-04-03 08:52:06', '2019-04-28 18:21:16', NULL),
(10, 'CMD2019040008MKT', 1, 1, 1800, 500, 2300, 1, 2, 1, NULL, '2019-04-19 10:31:31', '2019-04-27 15:19:58', NULL),
(11, 'CMD2019040009MKT', 1, 2, 1800, 500, 2300, 1, NULL, 0, NULL, '2019-04-06 10:39:02', '2019-04-06 10:39:02', NULL),
(12, 'CMD2019040010MKT', 1, 4, 1800, 500, 2300, 1, NULL, 1, NULL, '2019-04-21 10:56:29', '2019-06-07 20:11:06', NULL),
(15, 'CMD2019050008MKT', 1, 3, 1000, 500, 1500, 1, 3, 1, NULL, '2019-04-23 08:39:56', '2019-06-08 09:34:09', NULL),
(16, 'CMD2019050009MKT', 1, 3, 1100, 1500, 2600, 4, 3, 0, NULL, '2019-04-24 08:40:52', '2019-06-06 17:56:25', NULL),
(17, 'CMD2019050010MKT', 1, 3, 1000, 500, 1500, 1, 1, 0, NULL, '2019-04-24 08:41:15', '2019-06-06 16:28:18', NULL),
(18, 'CMD2019050011MKT', 1, 3, 6100, 500, 6600, 1, 1, 0, NULL, '2019-04-24 08:41:42', '2019-05-18 08:41:42', NULL),
(19, 'CMD2019050012MKT', 1, 3, 1100, 1000, 2100, 3, 2, 0, NULL, '2019-04-25 08:42:27', '2019-06-06 16:10:33', NULL),
(20, 'CMD2019050013MKT', 1, 4, 1500, 500, 2000, 1, NULL, 1, NULL, '2019-04-26 08:43:39', '2019-06-07 20:11:18', NULL),
(21, 'CMD2019050014MKT', 1, 0, 1000, 500, 1500, 1, NULL, 0, NULL, '2019-04-27 08:44:00', '2019-05-18 08:44:00', NULL),
(22, 'CMD2019050015MKT', 1, 0, 6000, 500, 6500, 1, NULL, 0, NULL, '2019-04-28 08:44:15', '2019-05-18 08:44:15', NULL),
(23, 'CMD2019050016MKT', 1, 3, 600, 500, 1100, 1, 2, 1, NULL, '2019-04-29 08:44:33', '2019-06-06 20:37:24', NULL),
(25, 'CMD2019050018MKT', 1, 0, 8100, 1500, 9600, 4, NULL, 0, NULL, '2019-05-01 08:46:05', '2019-05-18 08:46:05', NULL),
(26, 'CMD2019050019MKT', 1, 0, 2100, 500, 2600, 1, NULL, 0, NULL, '2019-05-02 08:46:25', '2019-05-18 08:46:25', NULL),
(27, 'CMD2019050020MKT', 1, 3, 1100, 500, 1600, 1, 2, 0, NULL, '2019-05-03 08:46:56', '2019-06-06 16:34:48', NULL),
(28, 'CMD2019050021MKT', 1, 3, 2600, 500, 3100, 1, 2, 0, NULL, '2019-05-04 08:47:32', '2019-06-06 08:33:06', NULL),
(29, 'CMD2019050022MKT', 1, 3, 6600, 1000, 7600, 3, 2, 0, NULL, '2019-05-05 08:47:59', '2019-06-06 16:51:36', NULL),
(30, 'CMD2019050023MKT', 1, 0, 1700, 500, 2200, 1, 2, 1, NULL, '2019-05-06 08:48:18', '2019-06-08 08:10:51', NULL),
(32, 'CMD2019050025MKT', 1, 3, 2100, 500, 2600, 1, 1, 1, NULL, '2019-05-06 08:49:07', '2019-06-06 22:53:24', NULL),
(33, 'CMD2019050026MKT', 1, 0, 2000, 500, 2500, 1, 2, 1, NULL, '2019-05-07 08:50:28', '2019-06-08 08:09:22', NULL),
(34, 'CMD2019050027MKT', 1, 4, 2200, 1500, 3700, 4, 1, 1, 'TEST', '2019-05-08 08:51:08', '2019-06-08 19:43:13', NULL),
(35, 'CMD2019050028MKT', 1, 0, 2700, 500, 3200, 1, NULL, 0, NULL, '2019-05-09 08:52:18', '2019-05-18 08:52:18', NULL),
(36, 'CMD2019050029MKT', 1, 4, 5500, 1000, 6500, 2, 3, 1, 'je sais pas', '2019-05-23 08:52:42', '2019-06-08 19:41:12', NULL),
(37, 'CMD2019050030MKT', 1, 0, 1000, 500, 1500, 1, 3, 1, NULL, '2019-05-23 08:53:09', '2019-06-06 22:53:41', NULL),
(40, 'CMD2019050033MKT', 1, 0, 1200, 500, 1700, 1, 3, 1, NULL, '2019-05-25 08:57:09', '2019-06-06 22:48:26', NULL),
(41, 'CMD2019050034MKT', 1, 3, 6600, 500, 7100, 1, 3, 1, 'Tu ne me plais pas du tout.', '2019-05-25 08:57:31', '2019-06-19 12:11:38', NULL),
(45, 'CMD2019050038MKT', 1, 1, 2600, 500, 3100, 1, 2, 0, NULL, '2019-05-26 09:02:40', '2019-05-18 09:02:40', NULL),
(46, 'CMD2019050039MKT', 1, 1, 3100, 500, 3600, 1, 1, 0, NULL, '2019-05-26 09:03:10', '2019-05-18 09:03:10', NULL),
(47, 'CMD2019050040MKT', 1, 0, 6600, 500, 7100, 1, 3, 1, NULL, '2019-05-26 09:03:30', '2019-06-08 08:26:40', NULL);

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
(15, 7, 7, 1, 3, 100, '2019-03-31 01:58:02', '2019-03-31 01:58:02'),
(16, 8, 2, 1, 3, 100, '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
(17, 8, 7, 1, 3, 500, '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
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
(90, 40, 7, 1, 3, 200, '2019-05-18 08:57:09', '2019-05-18 08:57:09'),
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
-- Structure de la table `fournisseurs`
--

DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `token`, `nom`, `tel`, `email`, `date_creation`, `date_modification`) VALUES
(1, 'FNS20190001AM', 'KONE Abou', '09841171', NULL, '2019-06-18 08:42:17', '2019-06-18 08:42:17'),
(2, 'FNS20190002AM', 'Gueu manou', '59791682', NULL, '2019-06-18 08:42:17', '2019-06-18 08:42:17'),
(4, 'FNS2019060004AM', 'Vié Coulibaly', '04523685', 'test@fournisseur.som', '2019-06-30 14:21:11', '2019-06-30 15:01:26'),
(5, 'FNS2019060005AM', 'Kouakou édouard', '57525654', 'edouard@fournisseur.som', '2019-06-30 14:23:28', '2019-06-30 14:23:28');

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
-- Structure de la table `livreurs`
--

DROP TABLE IF EXISTS `livreurs`;
CREATE TABLE IF NOT EXISTS `livreurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livreurs`
--

INSERT INTO `livreurs` (`id`, `nom`, `prenoms`, `tel`, `date_creation`, `date_modification`, `email`) VALUES
(1, 'DHL', 'Ibrahim', '08091011', '2019-06-02 11:25:40', '2019-06-02 11:25:40', 'ibrahim.kone@dhl.com'),
(2, 'CR Service', 'kesso', '07080502', '2019-06-02 11:25:40', '2019-06-02 11:25:40', 'kesso.dev@cr-service.com'),
(3, 'CR SERVICE', 'Bernard', '65626364', '2019-05-03 11:25:40', '2019-05-03 11:25:40', 'bernard.livreur@cr-service.com');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `token`, `stock`, `id_categorie_produit`, `id_unite`, `quantite_unitaire`, `prix_quantite_unitaire`, `id_taille`, `slug`, `statut`, `image`, `page_accueil`, `nouveau`, `promo`, `pourcentage_promo`, `date_creation`, `date_modification`) VALUES
(1, 'Tomate', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'aaaaaaaaa123', 100, 1, 3, 5, 500, 2, 'Tomate-légume-aaaaaaaaa123', 1, '1f1254b42cb27debac63fdd769f4cac2', 1, 0, 1, 10, '2018-11-01 00:00:00', '2019-06-30 11:09:44'),
(2, 'Carotte Grand', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'bbbbbbbbbbb589', 140, 1, 3, 3, 100, 4, 'Carotte Grand-légume-bbbbbbbbbbb589', 1, '5b7d767338c627979d3fcbc66508098b', 1, 1, 1, 10, '2018-11-01 00:00:00', '2019-06-30 11:12:24'),
(3, 'Carpe', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'cccccccccccc256', 85, 4, 3, 3, 2000, 4, 'Carpe-poissonnerie-cccccccccccc256', 1, 'a0cfb5517cadec0fc259734038cf6495', 1, 1, 1, 20, '2018-11-01 00:00:00', '2019-06-30 11:10:06'),
(4, 'Crevette', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ddddddddddddd585', 558, 4, 1, 1, 1000, 4, 'Crevette-poissonnerie-ddddddddddddd585', 1, 'da84b7ca2bb73e4ccbdb0db14eca1f5e', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-30 11:07:55'),
(5, 'Poule pondeuse', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'zsfjchjzesg5555aaa', 140, 2, 3, 1, 5000, 4, 'Poule pondeuse-boucherie-zsfjchjzesg5555aaa', 1, 'd9ad969f1f25a7d69cfeaf84e6b7fa37', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-19 14:38:29'),
(6, 'Oignon', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'qdsfgersdgrd552000', 400, 1, 1, 1, 1000, 4, 'Oignon-légume-qdsfgersdgrd552000', 1, 'b17c6696aa1d8c8635f5b4bf1b0f720c', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-29 17:34:43'),
(7, 'Chou', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mmmmmmmmmmm255', 571, 1, 3, 1, 500, 4, 'Chou-légume-mmmmmmmmmmm255', 1, '4184b4d29624086be3b3c42d59ec20c2', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-07-01 04:35:07'),
(8, 'Orange', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'xsdrfghhnk25hhh', 94, 5, 3, 3, 200, 4, 'Orange-fruit-xsdrfghhnk25hhh', 1, 'd3ac81a903ce60b5d588e70b292a3284', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-19 14:09:44'),
(9, 'Mangue', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600015AM', 94, 5, 3, 3, 200, 4, 'Mangue-fruit-PR20190600015AM', 1, '9a8b48d6e46a07df1513c6effab132c9', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-19 14:20:24'),
(10, 'Banane Douce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600016AM', 680, 5, 3, 3, 200, 4, 'Banane Douce-fruit-PR20190600016AM', 0, '3bc1d6826ee416ece7aa8377e3d19b17', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-29 21:11:44'),
(11, 'Piment Rouge', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600013AM', 394, 1, 1, 5, 100, 4, 'Piment Rouge-légume-PR20190600013AMPiment-Rouge-légume-PR20190600013AM', 0, 'qdsfgersdgrd552000', 1, 0, 0, 0, '2018-11-01 00:00:00', '2019-06-21 13:40:55'),
(12, 'Machoiron', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600011AM', 500, 4, 3, 3, 2000, 4, 'Machoiron-poissonnerie-PR20190600011AM', 1, '07ac97d1054258cb3077d85364f09174', 1, 1, 1, 20, '2018-11-01 00:00:00', '2019-06-30 11:10:30'),
(14, 'Piment', 'Tres bon piment', 'PDT2019060013MKT', 0, 1, 3, 20, 200, NULL, 'Piment-légume-PDT2019060013MKT', 1, '735decffc15cdbaf879be219a94cff5e', 0, 0, 0, 0, '2019-06-17 09:36:41', '2019-06-19 16:17:50'),
(15, 'Gombo', 'TEST', 'PDT2019060014MKT', 90, 1, 3, 5, 150, NULL, 'Gombo-légume-PDT2019060014MKT', 0, 'f8aa12ef265bfcc76c76725bc206339f', 0, 0, 0, 0, '2019-06-17 09:40:46', '2019-06-30 11:12:06'),
(17, 'Pommes de terre', 'TEST', 'PDT2019060015AM', 290, 7, 1, 1, 1500, NULL, 'Pommes de terre-féculent-PDT2019060015AM', 1, '96f9f25f1837a0e92cc6b4cb3ef5a586', 0, 0, 0, 0, '2019-06-19 21:39:03', '2019-06-29 17:32:47'),
(19, 'Obergine', 'TEST', 'PDT2019060016AM', 0, 1, 3, 3, 1000, NULL, 'Obergine-légume-PDT2019060016AMObergine-légume-PDT2019060016AM', 0, '61b4380d1d7efae4df2f6ba1da114946', 0, 0, 0, 0, '2019-06-29 14:28:22', '2019-06-29 14:28:22');

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
  `token` varchar(50) NOT NULL,
  `quantite_initiale` int(100) DEFAULT NULL,
  `montant` float NOT NULL,
  `frais_livraison` float NOT NULL DEFAULT '0',
  `montant_ttc` float NOT NULL DEFAULT '0',
  `statut` int(1) DEFAULT NULL COMMENT '1=en cours; 0=epuise',
  `id_fournisseur` int(100) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `id_produit`, `token`, `quantite_initiale`, `montant`, `frais_livraison`, `montant_ttc`, `statut`, `id_fournisseur`, `date_creation`, `date_modification`) VALUES
(1, 5, 'STK20190001AM', 10, 25000, 500, 25500, 1, 2, '2019-06-12 06:23:34', '2019-06-29 17:35:31'),
(11, 12, 'STK2019060011AM', 450, 45000, 0, 45000, NULL, 2, '2019-06-30 11:10:30', '2019-06-30 11:10:30'),
(3, 1, 'STK2019060003AM', 1000, 20000, 500, 20500, NULL, 2, '2019-06-29 01:35:36', '2019-06-29 21:39:48'),
(6, 1, 'STK2019060004AM', 250, 2000, 0, 2000, NULL, 1, '2019-06-29 20:40:57', '2019-06-29 20:40:57'),
(12, 15, 'STK2019060012AM', 90, 68700, 300, 69000, NULL, 2, '2019-06-30 11:12:06', '2019-06-30 11:12:06'),
(10, 4, 'STK2019060010AM', 60, 52000, 1450, 60000, NULL, 1, '2019-06-30 11:07:55', '2019-06-30 11:07:55'),
(13, 2, 'STK2019060013AM', 40, 5200, 0, 5200, NULL, 1, '2019-06-30 11:12:24', '2019-06-30 11:12:24'),
(14, 7, 'STK2019070014AM', 90, 18000, 500, 18500, NULL, 5, '2019-07-01 04:35:07', '2019-07-01 04:35:07');

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
  `token` varchar(20) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `symbole` varchar(5) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `token`, `libelle`, `symbole`, `date_creation`, `date_modification`) VALUES
(1, 'nfggggggd14', 'kilogramme', 'Kg', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'mpongzfs4522', 'litre', 'L', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'gdsfhsjhs0155', 'nombre', 'NA', '2018-11-01 00:00:00', '2018-11-01 00:00:00');

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
