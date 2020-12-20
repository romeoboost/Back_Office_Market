-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 20 déc. 2020 à 21:01
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
-- Base de données :  `cisse_soft`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `id_client` int(10) NOT NULL DEFAULT '0',
  `nom` varchar(255) DEFAULT NULL,
  `prenoms` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `id_produit` int(10) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_avis_parent` int(100) DEFAULT '0',
  `id_admin_reponse` int(100) DEFAULT NULL COMMENT 'id de l''administrateur ayant repondu',
  `reponse_admin_contenu` text,
  `date_reponse` datetime DEFAULT NULL,
  `page_accueil` int(1) NOT NULL DEFAULT '0',
  `statut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `token`, `id_client`, `nom`, `prenoms`, `email`, `contenu`, `localisation`, `id_produit`, `date_creation`, `date_modification`, `id_avis_parent`, `id_admin_reponse`, `reponse_admin_contenu`, `date_reponse`, `page_accueil`, `statut`) VALUES
(2, 'mpogffzs800144', 0, 'Kone', 'hamed', 'hamed85@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cocody, riviera II', 4, '2018-11-08 00:00:00', '2018-11-08 00:00:00', 0, NULL, NULL, NULL, 1, 0),
(3, 'loagxfqx4xh', 0, 'YAO', 'Elodie', 'elodie225@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cocody, riviera II', 3, '2018-11-08 00:00:00', '2019-09-19 23:21:53', 0, 1, 'Je sais pas quoi dire mais ce qui est sure c\'est que ça marche.', '2019-09-14 21:21:49', 1, 1),
(4, 'azedsgb5815czsd', 0, 'ATTIA', 'paulin', 'paulingris@test.ci', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Divo, bada', 2, '2018-11-08 00:00:00', '2019-09-19 23:24:41', 0, 1, 'Merci de nous avoir contacter. Nous prenoms en compte votre remarque et vous revenons.', '2019-09-14 02:13:34', 1, 1),
(6, 'AVS2019090006AM', 0, 'juizerv', '', 'erjsyuvc@hcghs.ci', 'Consultez nos spécialistes pour obtenir de l’aide concernant une commande, une personnalisation ou des conseils de conception.', NULL, 2, '2019-09-25 01:02:28', '2019-09-25 01:05:19', 0, 1, 'nzcghcg jcztgctc chzchgcqsc', '2019-09-25 01:05:19', 0, 1);

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
(1, 'Moteur', 'jjhshgfcbcjhj45ss', 1, 'jjhshgfcbcjhj45ss', 'vegetable', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'Motopompe', 'jjhshgfcbcjhj45hhd', 1, 'jjhshgfcbcjhj45hhd', 'chicken', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'Courroie', 'jjhshgfcbcjhj4koi22', 1, 'jjhshgfcbcjhj4koi22', 'oil', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(4, 'Moulin', 'jfhcdstgsdhgfcbcjhj45ss', 1, 'jfhcdstgsdhgfcbcjhj45ss', 'fish', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(5, 'Kolo', 'kbsedeadbcjhj45ss', 1, 'kbsedeadbcjhj45ss', 'fruit', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(6, 'Dynamo', 'jhergdvherjd', 1, '650b2de60935fb31340be95a729072e6', 'seed-bag', '2018-11-01 00:00:00', '2019-06-23 15:20:58'),
(7, 'Piston', 'ergeverjkvfer', 1, 'ergeverjkvfer', 'potatoes', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
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
  `date_password_reinit` datetime DEFAULT NULL,
  `token_password_reinit` varchar(255) DEFAULT NULL,
  `reponse_envoi_email` text,
  `token_password_reinit_status` int(1) DEFAULT '0' COMMENT '0=NON, 1=OUI, 3=ENCOURE',
  `is_password_reinit` int(1) DEFAULT '0' COMMENT '0=NON, 1=OUI, 3=ENCOURE',
  `date_token_reinit_password` datetime DEFAULT NULL,
  `type_client` int(1) DEFAULT NULL COMMENT '0=detaillant, 1=demi gros, 2=grossiste, 3=exchange',
  `solde_avant` float DEFAULT '0',
  `solde_apres` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `token`, `nom`, `prenoms`, `tel`, `email`, `password`, `sexe`, `statut`, `image`, `date_creation`, `date_modification`, `date_password_reinit`, `token_password_reinit`, `reponse_envoi_email`, `token_password_reinit_status`, `is_password_reinit`, `date_token_reinit_password`, `type_client`, `solde_avant`, `solde_apres`) VALUES
(1, 'CLI2019010001MKT', 'EDI', 'Moussa', '01010101', 'test.test@test.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 1, 'chsdbcbsbhsd5222', '2018-12-03 15:00:00', '2019-04-28 18:12:22', NULL, NULL, NULL, 0, 0, NULL, 1, 0, 0),
(2, 'CLI2019010002MKT', 'boss', 'boss', '01010102', 'boss@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 0, 0, 'fvevjhdfvj585csd', '2018-12-03 00:00:00', '2018-12-03 00:00:00', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0),
(6, 'CLI2019010003MKT', 'test', 'testeur', '01040507', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-01-01 23:52:26', '2019-01-01 23:52:26', NULL, NULL, NULL, 0, 0, NULL, 3, 0, 0),
(7, 'CLI2019010004MKT', 'TEST', 'BOBI', '01010103', 'test4@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 0, 'CLI2019010004MKT', '2019-06-03 00:00:00', '2019-06-03 00:00:00', NULL, NULL, NULL, 0, 0, NULL, 1, 0, 0),
(8, 'CLI2019010005MKT', 'MERLIN', 'MAGICIEN', '01040508', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-06-05 00:00:00', '2019-06-05 00:00:00', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0),
(9, 'CLI2019010006MKT', 'AMINA', 'DIALO', '01040509', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-04-01 23:52:26', '2019-04-01 23:52:26', NULL, NULL, NULL, 0, 0, NULL, 2, 0, 0),
(10, 'CLI2019010007MKT', 'TEST', 'Bobi', '01010110', 'bobi@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 1, 'CLI2019010008MKT', '2019-06-03 00:00:00', '2019-06-27 00:54:36', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0),
(11, 'CLI2019010008MKT', 'MATHIEU', 'BIBO', '01040511', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 0, NULL, '2019-06-05 00:00:00', '2019-06-26 23:56:40', NULL, NULL, NULL, 0, 0, NULL, 2, 0, -235),
(19, 'CLI2020030051MKT', 'KESSO', 'Romeo', '01202020', 'romkesso92@gmail.com', '6146f8317c1f87828fe04a5e0d0318c0', 0, 1, NULL, '2020-03-08 22:31:42', '2020-05-25 18:03:02', '2020-05-18 18:23:28', '772f366eef5862bb9ec2aaf781b777914c70b381d6872f4b514c4b41ee10e145', '1', 3, 3, '2020-05-25 18:02:49', 0, 0, 0),
(13, 'CLI2019010010MKT', 'titan', 'pere', '01040512', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 1, 1, NULL, '2019-04-01 23:52:26', '2019-04-01 23:52:26', NULL, NULL, NULL, 0, 0, NULL, 1, 0, 0),
(14, 'CLI2019010011MKT', 'ali', 'fere', '01010113', 'ali@boss.ci', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 0, 'CLI2019010008MKT', '2019-06-03 00:00:00', '2019-06-03 00:00:00', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0),
(15, 'CLI2019010012MKT', 'EDWIGE', 'Bile', '01040514', ' ', '16d7a4fca7442dda3ad93c9a726597e4', 0, 1, NULL, '2019-06-05 00:00:00', '2019-06-05 00:00:00', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0),
(23, 'CLI2020120013CS', 'Abou', 'Traore', '07070808', '', NULL, 1, 1, NULL, '2020-12-20 11:45:34', '2020-12-20 11:45:34', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `id_client` int(10) NOT NULL,
  `statut` int(1) NOT NULL COMMENT '0=en attente ; 1=livré ; 2=annulé ; 3=en cours de livraison; 4=rejeté; 5=payer a credit;7=Validé; 9=payer totalement; 8=payer partiellement',
  `montant_ht` float NOT NULL,
  `frais_livraison` float NOT NULL,
  `montant_total` float NOT NULL,
  `montant_reduction` float DEFAULT NULL COMMENT 'se montant est celui renseigner par le valideur, peut etre une reduction',
  `reste_a_payer` int(11) NOT NULL,
  `id_livraison_destination` int(11) NOT NULL,
  `id_livreur` int(20) DEFAULT NULL,
  `id_utilisateur` int(20) DEFAULT NULL,
  `motif_rejet` text,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `token`, `id_client`, `statut`, `montant_ht`, `frais_livraison`, `montant_total`, `montant_reduction`, `reste_a_payer`, `id_livraison_destination`, `id_livreur`, `id_utilisateur`, `motif_rejet`, `date_creation`, `date_modification`, `date_livraison`) VALUES
(14, 'CMD2019040007MKT', 1, 2, 6500, 500, 7000, 6500, 7000, 1, NULL, 0, NULL, '2019-04-22 19:06:01', '2019-04-28 18:21:16', NULL),
(7, 'CMD2019030005MKT', 1, 4, 300, 500, 800, 300, 800, 1, NULL, 0, NULL, '2019-03-31 01:58:02', '2019-03-31 01:58:02', NULL),
(8, 'CMD2019030006MKT', 1, 1, 300, 500, 800, 300, 800, 1, 2, 0, NULL, '2019-03-31 02:02:50', '2019-03-31 02:02:50', NULL),
(9, 'CMD2019040007MKT', 1, 2, 1100, 500, 1600, 1100, 1600, 1, NULL, 0, NULL, '2019-04-03 08:52:06', '2019-04-28 18:21:16', NULL),
(10, 'CMD2019040008MKT', 1, 1, 1800, 500, 2300, 1800, 2300, 1, 2, 1, NULL, '2019-04-19 10:31:31', '2019-04-27 15:19:58', NULL),
(11, 'CMD2019040009MKT', 1, 2, 1800, 500, 2300, 1800, 2300, 1, NULL, 0, NULL, '2019-04-06 10:39:02', '2019-04-06 10:39:02', NULL),
(12, 'CMD2019040010MKT', 1, 4, 1800, 500, 2300, 1800, 2300, 1, NULL, 1, NULL, '2019-04-21 10:56:29', '2019-06-07 20:11:06', NULL),
(15, 'CMD2019050008MKT', 1, 3, 1000, 500, 1500, 1000, 1500, 1, 3, 1, NULL, '2019-04-23 08:39:56', '2019-06-08 09:34:09', NULL),
(16, 'CMD2019050009MKT', 1, 3, 1100, 1500, 2600, 1100, 2600, 4, 3, 0, NULL, '2019-04-24 08:40:52', '2019-06-06 17:56:25', NULL),
(17, 'CMD2019050010MKT', 1, 3, 1000, 500, 1500, 1000, 1500, 1, 1, 0, NULL, '2019-04-24 08:41:15', '2019-06-06 16:28:18', NULL),
(18, 'CMD2019050011MKT', 1, 3, 6100, 500, 6600, 6100, 6600, 1, 1, 0, NULL, '2019-04-24 08:41:42', '2019-05-18 08:41:42', NULL),
(19, 'CMD2019050012MKT', 1, 3, 1100, 1000, 2100, 1100, 2100, 3, 2, 0, NULL, '2019-04-25 08:42:27', '2019-06-06 16:10:33', NULL),
(20, 'CMD2019050013MKT', 1, 4, 1500, 500, 2000, 1500, 2000, 1, NULL, 1, NULL, '2019-04-26 08:43:39', '2019-06-07 20:11:18', NULL),
(21, 'CMD2019050014MKT', 1, 0, 1000, 500, 1500, 1000, 1500, 1, NULL, 0, NULL, '2019-04-27 08:44:00', '2019-05-18 08:44:00', NULL),
(22, 'CMD2019050015MKT', 1, 0, 6000, 500, 6500, 6000, 6500, 1, NULL, 0, NULL, '2019-04-28 08:44:15', '2019-05-18 08:44:15', NULL),
(23, 'CMD2019050016MKT', 1, 3, 600, 500, 1100, 600, 1100, 1, 2, 1, NULL, '2019-04-29 08:44:33', '2019-06-06 20:37:24', NULL),
(25, 'CMD2019050018MKT', 1, 0, 8100, 1500, 9600, 8100, 9600, 4, NULL, 0, NULL, '2019-05-01 08:46:05', '2019-05-18 08:46:05', NULL),
(26, 'CMD2019050019MKT', 1, 0, 2100, 500, 2600, 2100, 2600, 1, NULL, 0, NULL, '2019-05-02 08:46:25', '2019-05-18 08:46:25', NULL),
(27, 'CMD2019050020MKT', 1, 3, 1100, 500, 1600, 1100, 1600, 1, 2, 0, NULL, '2019-05-03 08:46:56', '2019-06-06 16:34:48', NULL),
(28, 'CMD2019050021MKT', 1, 3, 2600, 500, 3100, 2600, 3100, 1, 2, 0, NULL, '2019-05-04 08:47:32', '2019-06-06 08:33:06', NULL),
(29, 'CMD2019050022MKT', 1, 3, 6600, 1000, 7600, 6600, 7600, 3, 2, 0, NULL, '2019-05-05 08:47:59', '2019-06-06 16:51:36', NULL),
(30, 'CMD2019050023MKT', 1, 0, 1700, 500, 2200, 1700, 2200, 1, 2, 1, NULL, '2019-05-06 08:48:18', '2019-06-08 08:10:51', NULL),
(48, 'CMD2019070048MKT', 1, 3, 3200, 500, 3700, 3200, 3700, 1, 2, 1, NULL, '2019-07-19 23:53:57', '2020-01-08 17:59:22', NULL),
(32, 'CMD2019050025MKT', 1, 3, 2100, 500, 2600, 2100, 2600, 1, 1, 1, NULL, '2019-05-06 08:49:07', '2019-06-06 22:53:24', NULL),
(33, 'CMD2019050026MKT', 1, 0, 2000, 500, 2500, 2000, 2500, 1, 2, 1, NULL, '2019-05-07 08:50:28', '2019-06-08 08:09:22', NULL),
(34, 'CMD2019050027MKT', 1, 4, 2200, 1500, 3700, 2200, 3700, 4, 1, 1, 'TEST', '2019-05-08 08:51:08', '2019-06-08 19:43:13', NULL),
(35, 'CMD2019050028MKT', 1, 0, 2700, 500, 3200, 2700, 3200, 1, NULL, 0, NULL, '2019-05-09 08:52:18', '2019-05-18 08:52:18', NULL),
(36, 'CMD2019050029MKT', 1, 4, 5500, 1000, 6500, 5500, 6500, 2, 3, 1, 'je sais pas', '2019-05-23 08:52:42', '2019-06-08 19:41:12', NULL),
(37, 'CMD2019050030MKT', 1, 0, 1000, 500, 1500, 1000, 1500, 1, 3, 1, NULL, '2019-05-23 08:53:09', '2019-06-06 22:53:41', NULL),
(40, 'CMD2019050033MKT', 1, 0, 1200, 500, 1700, 1200, 1700, 1, 3, 1, NULL, '2019-05-25 08:57:09', '2019-06-06 22:48:26', NULL),
(41, 'CMD2019050034MKT', 1, 1, 6600, 500, 7100, 6600, 7100, 1, 3, 1, 'Tu ne me plais pas du tout.', '2019-05-25 08:57:31', '2020-01-08 17:27:10', '2020-01-08 17:27:10'),
(45, 'CMD2019050038MKT', 1, 3, 2600, 500, 3100, 2600, 3100, 1, 3, 1, NULL, '2019-05-26 09:02:40', '2020-01-08 18:32:29', '2020-01-08 18:32:11'),
(46, 'CMD2019050039MKT', 1, 3, 3100, 500, 3600, 3100, 3600, 1, 6, 1, NULL, '2019-05-26 09:03:10', '2020-01-08 18:01:04', '2020-01-08 18:00:07'),
(47, 'CMD2019050040MKT', 1, 0, 7485, 500, 8833, 7485, 8833, 1, 3, 1, NULL, '2019-05-26 09:03:30', '2020-12-19 17:34:10', NULL),
(51, 'MKT2020030051AM', 1, 0, 1835, 500, 2335, 1835, 2335, 1, NULL, NULL, NULL, '2020-03-12 00:35:33', '2020-03-12 00:35:33', NULL),
(52, 'MKT2020030052AM', 1, 0, 145, 500, 645, 145, 645, 1, NULL, NULL, NULL, '2020-03-12 00:37:31', '2020-03-12 00:37:31', NULL),
(53, 'MKT2020030053AM', 1, 7, 245, 500, 236, 200, 236, 1, NULL, 1, NULL, '2020-03-12 00:55:07', '2020-12-20 01:27:39', NULL),
(54, 'MKT2020030054AM', 1, 7, 445, 500, 526, 400, 526, 1, NULL, 1, NULL, '2020-03-12 00:58:22', '2020-12-20 01:17:30', NULL),
(55, 'CMD2020120055MKT', 14, 7, 240, 500, 740, 240, 740, 5, NULL, 1, NULL, '2020-12-14 05:30:20', '2020-12-19 12:58:13', NULL),
(56, 'CMD2020120056MKT', 11, 8, 235, 500, 735, 235, 235, 5, NULL, 1, NULL, '2020-12-18 21:20:11', '2020-12-20 20:07:24', NULL),
(57, 'CMD2020120057MKT', 19, 0, 100, 500, 600, NULL, 600, 5, NULL, 1, NULL, '2020-12-20 10:41:10', '2020-12-20 10:41:10', NULL);

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
  `qtte_unitaire` float DEFAULT NULL,
  `prix_qtte_unitaire` float DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

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
(107, 48, 12, 1, 3, 1600, '2019-07-19 23:53:57', '2019-07-19 23:53:57'),
(108, 48, 3, 1, 3, 1600, '2019-07-19 23:53:57', '2019-07-19 23:53:57'),
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
(125, 47, 28, 1, 1, 145, '2020-12-19 17:22:37', '2020-12-19 17:24:11'),
(126, 47, 2, 3, 1, 100, '2020-12-19 17:26:19', '2020-12-19 17:34:10'),
(131, 53, 11, 1, 1, 100, '2020-12-20 01:27:06', '2020-12-20 01:27:06'),
(130, 54, 15, 2, 1, 150, '2020-12-19 23:07:47', '2020-12-20 00:56:20'),
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
(113, 51, 2, 1, 3, 90, '2020-03-12 00:35:33', '2020-03-12 00:35:33'),
(114, 51, 12, 1, 3, 1600, '2020-03-12 00:35:33', '2020-03-12 00:35:33'),
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
(106, 47, 3, 1, 3, 1600, '2019-05-18 09:03:30', '2019-05-18 09:03:30'),
(115, 51, 28, 1, 2, 145, '2020-03-12 00:35:33', '2020-03-12 00:35:33'),
(116, 52, 28, 1, 2, 145, '2020-03-12 00:37:31', '2020-03-12 00:37:31'),
(117, 53, 28, 1, 1.5, 145, '2020-03-12 00:55:07', '2020-03-12 00:55:07'),
(129, 54, 28, 1, 1, 145, '2020-12-19 23:05:48', '2020-12-20 00:56:20'),
(119, 55, 2, 1, 1, 90, '2020-12-14 05:30:20', '2020-12-14 05:30:20'),
(120, 55, 15, 1, 1, 150, '2020-12-14 05:30:20', '2020-12-14 05:30:20'),
(121, 55, 2, 2, 1, 90, '2020-12-18 10:55:10', '2020-12-18 10:55:10'),
(122, 55, 11, 1, 1, 100, '2020-12-18 10:55:10', '2020-12-18 10:55:10'),
(123, 56, 2, 1, 1, 90, '2020-12-18 21:20:11', '2020-12-18 21:20:11'),
(124, 56, 28, 1, 1, 145, '2020-12-18 21:20:11', '2020-12-18 21:20:11'),
(132, 57, 11, 1, 1, 100, '2020-12-20 10:41:10', '2020-12-20 10:41:10');

-- --------------------------------------------------------

--
-- Structure de la table `exchanges`
--

DROP TABLE IF EXISTS `exchanges`;
CREATE TABLE IF NOT EXISTS `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
-- Structure de la table `frais_livraison`
--

DROP TABLE IF EXISTS `frais_livraison`;
CREATE TABLE IF NOT EXISTS `frais_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `frais` float NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `frais_livraison`
--

INSERT INTO `frais_livraison` (`id`, `token`, `libelle`, `min`, `max`, `frais`, `date_creation`, `date_modification`) VALUES
(1, 'FLV2019070001AM', NULL, 0, 5000, 500, '2019-07-18 07:00:17', '2019-07-23 09:24:47'),
(2, 'FLV2019070002AM', NULL, 10001, 15000, 1000, '2019-07-18 07:00:17', '2019-07-23 09:23:30'),
(3, 'FLV2019070003AM', NULL, 20001, 30000, 1500, '2019-07-18 07:00:17', '2019-07-18 07:00:17'),
(4, 'FLV2019070004AM', NULL, 30001, 500000, 2000, '2019-07-18 07:00:17', '2019-07-24 05:14:23'),
(6, 'FLV2019070006AM', NULL, 5001, 10000, 700, '2019-07-23 09:25:18', '2019-07-23 09:25:18'),
(7, 'FLV2019070007AM', NULL, 15001, 20000, 1200, '2019-07-23 09:26:25', '2019-07-23 09:26:25'),
(8, 'FLV2019070008AM', NULL, 500001, 1000000, 3000, '2019-07-24 05:14:57', '2019-07-24 05:18:09');

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
  `statut` int(1) NOT NULL,
  `longitude` double NOT NULL,
  `lagitude` double NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livraison_destinations`
--

INSERT INTO `livraison_destinations` (`id`, `token`, `commune`, `frais`, `statut`, `longitude`, `lagitude`, `date_creation`, `date_modification`) VALUES
(1, 'hfhfhcdsjlll55d', 'cocody', 500, 1, 0, 0, '2019-01-13 08:12:00', '2019-01-13 08:12:00'),
(2, 'nhcfqsffsbxhx', 'bingerville', 1000, 1, 0, 0, '2019-01-13 08:12:00', '2019-01-13 08:12:00'),
(3, 'kdkckcdk15d4', 'Adjamé', 1000, 0, 0, 0, '2018-11-01 00:00:00', '2018-12-05 00:00:00'),
(4, 'mooc45dddcddd', 'Yopougon', 1500, 1, 0, 0, '2018-12-05 00:00:00', '2019-12-08 22:36:36'),
(5, 'mongsfsfccxxx', 'Yamoussoukro', 500, 0, 0, 0, '2018-12-05 00:00:00', '2018-12-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `livreurs`
--

DROP TABLE IF EXISTS `livreurs`;
CREATE TABLE IF NOT EXISTS `livreurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livreurs`
--

INSERT INTO `livreurs` (`id`, `token`, `nom`, `prenoms`, `tel`, `date_creation`, `date_modification`, `email`) VALUES
(1, 'LVR201900001AM', 'DHL', 'Ibrahim', '08091011', '2019-06-02 11:25:40', '2019-06-02 11:25:40', 'ibrahim.kone@dhl.com'),
(2, 'LVR201900002AM', 'CR Service', 'kesso', '07080502', '2019-06-02 11:25:40', '2019-06-02 11:25:40', 'kesso.dev@cr-service.com'),
(3, 'LVR201900003AM', 'CR SERVICE', 'Bernard', '65626364', '2019-05-03 11:25:40', '2019-05-03 11:25:40', 'bernard.livreur@cr-service.com'),
(4, 'LVR2019070004AM', 'TEST', 'TEST', '01040705', '2019-07-03 18:46:47', '2019-07-03 19:33:37', ''),
(5, 'LVR2019070005AM', 'yao', 'eudoxy', '01050608', '2019-07-03 18:50:01', '2019-07-03 18:50:01', 'test@amarket.com'),
(6, 'LVR2019070006AM', 'ahmed', 'terrain', '01052555', '2019-07-03 18:51:55', '2019-07-03 19:32:26', '');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `id_client` int(11) NOT NULL DEFAULT '0',
  `nom_prenoms` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_admin_reponse` int(100) DEFAULT NULL,
  `reponse_admin_contenu` text,
  `date_reponse` datetime DEFAULT NULL,
  `statut` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `token`, `id_client`, `nom_prenoms`, `email`, `objet`, `contenu`, `date_creation`, `date_modification`, `id_admin_reponse`, `reponse_admin_contenu`, `date_reponse`, `statut`) VALUES
(1, 'MSG201901001MKT', 1, 'Oumar Check', 'romkesso92@gmail.com', 'Re: TEST', 'TEST', '2019-01-27 20:18:18', '2019-10-29 00:36:23', 1, 'Mon Push à moi même !<br><br>\r\n                                                    <hr>\r\n                                                    <div style=\"background-color: #c7d0d0; padding: 5px;\">\r\n                                                        <p>\r\n                                                                                                                        <strong>De:</strong> MAGASSOUBA Oumar Check Premier [ check.oumar@test.ci ] <br>\r\n                                                            <strong>Date:</strong>  27-01-2019 20:18 ‎‎<br>\r\n                                                            <strong>À:</strong>  AFROMART                                                        </p>\r\n                                                        <p>\r\n                                                            TEST                                                        </p>\r\n                                                    </div>', '2019-10-29 00:36:23', 1),
(2, 'MSG201901002MKT', 0, 'Romeo Kesso', 'test@test.ci', 'TEST', 'POPO', '2019-01-27 20:19:15', '2019-01-27 20:19:15', NULL, NULL, NULL, 0),
(3, 'MSG201901003MKT', 0, 'Romeo testeur', 'romeo.kesso@ngser.com', 'Re: SANS OBJET', 'La belle Nadi ChouChou !', '2019-01-27 20:20:14', '2019-10-29 00:30:02', 1, '<br>Qu\'est ce que tu en dis ? <span style=\"font-weight: bold; background-color: rgb(255, 0, 0);\">c\'est propre ?</span><br>\r\n                                                    <hr>\r\n                                                    <div style=\"background-color: #c7d0d0;padding: 5px;\">\r\n                                                        <p>\r\n                                                                                                                        <strong>De:</strong> Romeo testeur [ test@test.ci ] <br>\r\n                                                            <strong>Date:</strong>  27-01-2019 20:20 ‎‎<br>\r\n                                                            <strong>À:</strong>  AFROMART                                                        </p>\r\n                                                        <p>\r\n                                                            La belle Nadi ChouChou !                                                        </p>\r\n                                                    </div>', '2019-10-29 00:30:02', 1);

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
  `stock` float NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `token`, `stock`, `id_categorie_produit`, `id_unite`, `quantite_unitaire`, `prix_quantite_unitaire`, `id_taille`, `slug`, `statut`, `image`, `page_accueil`, `nouveau`, `promo`, `pourcentage_promo`, `date_creation`, `date_modification`) VALUES
(1, 'Moteur 1115', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'aaaaaaaaa123', 100, 1, 3, 1, 500, 2, 'Moteur-1115-Moteur-aaaaaaaaa123', 1, '4cc1ca10d94b789ecd6c5a0d2b19b183', 1, 0, 1, 10, '2018-11-01 00:00:00', '2020-12-20 20:40:12'),
(2, 'Moteur 1110', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br />\r\n<br />\r\nsed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'bbbbbbbbbbb589', 132, 1, 3, 1, 100, 4, 'Moteur-1110-Moteur-bbbbbbbbbbb589', 1, '7e1aac9f4cc70f3c54b4effde79582a6', 1, 1, 1, 10, '2018-11-01 00:00:00', '2020-12-20 20:30:23'),
(3, 'Moulin 3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'cccccccccccc256', 82, 4, 3, 1, 200000, 4, 'Moulin-3-Moulin-cccccccccccc256', 1, 'd3991a55e90be3cada3d994b48ac7605', 1, 1, 1, 20, '2018-11-01 00:00:00', '2020-12-20 20:55:22'),
(4, 'PISTON 1115', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ddddddddddddd585', 558, 7, 3, 1, 1000, 4, 'PISTON-1115-Piston-ddddddddddddd585', 1, '34949973f1357c74e19013936972ba6f', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:52:35'),
(5, 'Aigle 180', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'zsfjchjzesg5555aaa', 140, 2, 3, 1, 5000, 4, 'Aigle-180-Motopompe-zsfjchjzesg5555aaa', 1, '674c693cb571cf45ec99b034e2017840', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:51:23'),
(6, 'Moteur 1105', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'qdsfgersdgrd552000', 400, 1, 3, 1, 1000, 4, 'Moteur-1105-Moteur-qdsfgersdgrd552000', 1, '671c32740e9df0aad217c78e48f8781d', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:52:57'),
(7, 'Moteur 5000', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'mmmmmmmmmmm255', 571, 1, 3, 1, 500, 4, 'Moteur-5000-Moteur-mmmmmmmmmmm255', 1, '0deb7256350f800a9b81f4a50255d236', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:39:23'),
(8, 'Moulin Diesel', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'xsdrfghhnk25hhh', 94, 4, 3, 1, 200, 4, 'Moulin-Diesel-Moulin-xsdrfghhnk25hhh', 1, '5fecef2ec32aa4d6047b120c6214d946', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:48:31'),
(9, 'Moulin 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600015AM', 94, 4, 3, 1, 200, 4, 'Moulin-2-Moulin-PR20190600015AM', 1, 'aab9429615df0289e5ccd0ccd0c2b623', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:49:12'),
(10, 'Segment', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600016AM', 680, 5, 3, 1, 200, 4, 'Segment-Kolo-PR20190600016AM', 0, '14f8f4c8875ca504eccdee4f2590fea9', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:42:48'),
(11, 'Moteur 6000', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600013AM', 388, 1, 3, 1, 100, 4, 'Moteur-6000-Moteur-PR20190600013AM', 0, '9f5171b7a2e0b2433c2c3df53fa65967', 1, 0, 0, 0, '2018-11-01 00:00:00', '2020-12-20 20:32:23'),
(12, 'Dynamo', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'PR20190600011AM', 494, 6, 3, 1, 2000, 4, 'Dynamo-Dynamo-PR20190600011AM', 1, '53693047f49521a797ca8fdc8feab7c9', 1, 1, 1, 20, '2018-11-01 00:00:00', '2020-12-20 20:56:00'),
(14, 'Moteur 7000', 'Tres bon piment', 'PDT2019060013MKT', 0, 1, 3, 1, 200, NULL, 'Moteur-7000-Moteur-PDT2019060013MKT', 1, 'a81ef056485bb9cc53281b7fc3fb76fd', 0, 0, 0, 0, '2019-06-17 09:36:41', '2020-12-20 20:39:42'),
(15, 'Moteur 8000', 'TEST', 'PDT2019060014MKT', 86, 1, 3, 1, 150, NULL, 'Moteur-8000-Moteur-PDT2019060014MKT', 0, '581f50dce612eaa5cb6cc42b9205e9b4', 0, 0, 0, 0, '2019-06-17 09:40:46', '2020-12-20 20:34:55'),
(17, 'PISTON 1110', 'TEST', 'PDT2019060015AM', 290, 7, 3, 1, 1500, NULL, 'PISTON-1110-Piston-PDT2019060015AM', 1, '1086c95a7b45aff083bf5fcb04e9e6f7', 0, 0, 0, 0, '2019-06-19 21:39:03', '2020-12-20 20:54:04'),
(21, 'Moteur 8500', 'GHHG', 'PDT2019120022AM', 0, 1, 3, 1, 140, NULL, 'Moteur-8500-Moteur-PDT2019120022AM', 1, 'a951a71927e82f0aab9d75c8a96cbabb', 1, 0, 0, 0, '2019-12-08 17:56:19', '2020-12-20 20:40:48'),
(23, 'Moto Pompe 2', 'Tres Bon', 'PDT2020020024AM', 0, 2, 3, 1, 150, NULL, 'Moto-Pompe-2-Motopompe-PDT2020020024AM', 1, 'f2bdc3519bfb5e5899199940469d01a4', 0, 0, 0, 0, '2020-02-05 08:04:17', '2020-12-20 20:45:10'),
(25, 'Moto Pompe EG 100', 'YETS', 'PDT2020020026AM', 0, 2, 3, 1, 140, NULL, 'Moto-Pompe-EG-100-Motopompe-PDT2020020026AM', 1, '968e82a16ab4e4441aa2994e168c34c7', 0, 0, 0, 0, '2020-02-05 08:15:30', '2020-12-20 20:44:38'),
(27, 'Aigle 100', 'TEST', 'PDT2020030028AM', 0, 2, 3, 1, 600, NULL, 'Aigle-100-Motopompe-PDT2020030028AM', 1, '0c6feb8900fe3f1557d1ec5817272f8b', 0, 0, 0, 0, '2020-03-12 00:20:48', '2020-12-20 20:49:54'),
(28, 'Courroie 1115', 'GTETE', 'PDT2020030029AM', 17, 3, 3, 1, 145, NULL, 'Courroie-1115-Courroie-PDT2020030029AM', 1, '6bddb49aafa5887b7e60ff3b1925df82', 0, 0, 0, 0, '2020-03-12 00:23:38', '2020-12-20 20:21:54'),
(29, 'Courroie 1110', 'TEST', 'PDT2020030030AM', 0, 3, 3, 1, 1400, NULL, 'Courroie-1110-Courroie-PDT2020030030AM', 0, 'df45380ff3ac1ea6ebba111451dc4912', 0, 0, 0, 0, '2020-03-12 01:00:49', '2020-12-20 20:54:35'),
(30, 'MOULIN', 'TEST', 'PDT2020030031AM', 0, 4, 3, 1, 60040, NULL, 'MOULIN-Moulin-PDT2020030031AM', 1, '98aad7f9ed64e8fa8602f6524d2029b7', 1, 0, 0, 0, '2020-03-12 01:03:59', '2020-12-20 20:50:36'),
(31, 'Courroie 1110', 'GGG', 'PDT2020030032AM', 0, 3, 3, 1, 140, NULL, 'Courroie-1110-Courroie-PDT2020030032AM', 0, 'de973af7bc12fb35e1bb0518eca8f5a5', 1, 0, 0, 0, '2020-03-12 01:05:44', '2020-12-20 20:27:54');

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
  `duree` int(10) DEFAULT NULL COMMENT 'en jour',
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `publicites`
--

INSERT INTO `publicites` (`id`, `position`, `entreprise`, `token`, `date_creation`, `date_modification`, `statut`, `image`, `duree`, `date_debut`, `date_fin`) VALUES
(1, 1, 'fanta', 'fdhfhdgdgdh555', '2018-11-08 08:16:17', '2019-12-08 19:05:41', 1, 'fdhfhdgdgdh555', 30, '2019-08-19 00:00:00', '2020-07-07 23:59:59'),
(2, 1, 'coca', 'qdtdtggdgdh444', '2018-11-08 08:16:17', '2019-12-08 18:35:32', 1, 'qdtdtggdgdh444', 30, '2019-08-19 00:00:00', '2020-03-12 23:59:59'),
(3, 2, 'aromate', 'kckkchghxqs552', '2018-11-13 00:00:00', '2019-12-08 19:06:09', 1, 'kckkchghxqs552', 30, '2019-08-13 00:00:00', '2020-08-06 23:59:59'),
(4, 3, 'kingkash', 'mljhtgrdfygutjjj', '2018-11-14 00:00:00', '2019-12-08 19:05:10', 1, 'mljhtgrdfygutjjj', 60, '2019-08-05 00:00:00', '2020-05-20 23:59:59'),
(5, 1, 'UNIWAX', 'PUB2019090005AM', '2019-09-08 14:00:32', '2019-09-08 14:00:32', 0, '2ec4b5ee10939307cf53d1c9c7302a83', NULL, '2019-09-07 00:00:00', '2019-09-11 23:59:59'),
(6, 1, 'UNIWAX II', 'PUB2019090006AM', '2019-09-08 14:01:50', '2019-09-09 22:53:13', 0, 'e8856302d0318cb4b0246c271cbb7624', NULL, '2019-09-12 00:00:00', '2019-09-20 23:59:59'),
(8, 3, 'gvblm', 'PUB2019090008AM', '2019-09-10 07:58:55', '2019-12-08 18:36:08', 1, 'a90d023f074e7661eda98d199392647d', NULL, '2019-09-10 00:00:00', '2020-05-14 23:59:59'),
(9, 3, 'JUKIO', 'PUB2019090009AM', '2019-09-10 07:59:28', '2019-09-10 07:59:28', 0, '548b2a756f4a5abd184991a22ddfb1e3', NULL, '2019-09-12 00:00:00', '2019-09-13 23:59:59'),
(10, 2, 'MOPI', 'PUB2019090010AM', '2019-09-10 08:00:06', '2019-09-10 08:00:06', 0, 'e2081583c9dd437a137df63de96c9f83', NULL, '2019-09-12 00:00:00', '2019-09-26 23:59:59'),
(11, 2, 'HYGG', 'PUB2019090011AM', '2019-09-10 08:00:41', '2019-12-08 18:55:29', 0, 'cafeae5a55622e28d8e5d9a05727454a', NULL, '2019-09-11 00:00:00', '2020-04-18 23:59:59'),
(12, 1, 'JYGF', 'PUB2019090012AM', '2019-09-10 08:01:19', '2019-09-10 08:01:19', 0, '6af0761f5a7a6c878da4e4bf38a37924', NULL, '2019-05-26 00:00:00', '2019-09-22 23:59:59');

-- --------------------------------------------------------

--
-- Structure de la table `rapide_commandes`
--

DROP TABLE IF EXISTS `rapide_commandes`;
CREATE TABLE IF NOT EXISTS `rapide_commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `id_client` int(10) NOT NULL,
  `statut` int(1) NOT NULL COMMENT '0=en attente ; 1=livré ; 2=annulé ; 3=en cours de livraison; 4=rejeté',
  `montant_ht` float DEFAULT NULL,
  `frais_livraison` float DEFAULT NULL,
  `montant_total` float DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `description_commande` text,
  `id_livraison_destination` int(11) NOT NULL,
  `id_livreur` int(20) DEFAULT NULL,
  `id_utilisateur` int(20) DEFAULT NULL,
  `motif_rejet` text,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rapide_commandes`
--

INSERT INTO `rapide_commandes` (`id`, `token`, `id_client`, `statut`, `montant_ht`, `frais_livraison`, `montant_total`, `image_link`, `description_commande`, `id_livraison_destination`, `id_livreur`, `id_utilisateur`, `motif_rejet`, `date_creation`, `date_modification`, `date_livraison`) VALUES
(2, 'QCD2019120002AM', 0, 3, 10000, 700, 10700, '', 'zcsduchgsdu', 4, 3, 1, 'TEST', '2019-12-17 14:59:47', '2020-01-08 18:39:17', NULL),
(3, 'QCD2019120003AM', 0, 0, 25, 500, 525, '', 'zcsduchgsdu', 4, 1, 1, NULL, '2019-12-17 15:02:57', '2020-01-08 18:56:44', '2020-01-08 18:33:09'),
(4, 'QCD2019120004AM', 0, 3, 13, 500, 513, '', 'piments 50\r\noignon 1200', 4, 3, 1, NULL, '2019-12-17 15:04:27', '2020-01-08 18:53:21', '2020-01-08 18:37:49'),
(5, 'QCD2019120005AM', 0, 0, 1, 500, 501, '', 'poulet 2500 F', 3, 3, 1, 'TES TEST', '2019-12-17 15:06:40', '2020-01-08 18:14:53', NULL),
(6, 'QCD2020010006AM', 0, 0, 0, 0, 0, 'f8544fee995477d1069d2ecb150634b2', '', 1, NULL, NULL, NULL, '2020-01-12 22:02:29', '2020-01-12 22:02:29', NULL),
(7, 'QCD2020010007AM', 0, 3, 11000, 1000, 12000, 'f621d1ac42b4268cf9611e8092399cee', '', 1, 6, 1, NULL, '2020-01-12 22:04:25', '2020-01-12 23:29:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `shipping_infos`
--

DROP TABLE IF EXISTS `shipping_infos`;
CREATE TABLE IF NOT EXISTS `shipping_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(100) NOT NULL,
  `id_commande` int(100) DEFAULT NULL,
  `id_commande_rapide` int(100) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenoms` varchar(255) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_destination` int(100) NOT NULL,
  `quartier` varchar(255) DEFAULT NULL,
  `lagitude` varchar(255) NOT NULL DEFAULT '0',
  `longitude` varchar(255) NOT NULL DEFAULT '0',
  `description` text,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `shipping_infos`
--

INSERT INTO `shipping_infos` (`id`, `id_client`, `id_commande`, `id_commande_rapide`, `nom`, `prenoms`, `tel`, `email`, `id_destination`, `quartier`, `lagitude`, `longitude`, `description`, `date_creation`, `date_modification`) VALUES
(1, 1, 7, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'petro                                        ', '2019-03-31 01:58:02', '2019-03-31 01:58:02'),
(2, 1, 8, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'petro                                        ', '2019-03-31 02:02:50', '2019-03-31 02:02:50'),
(3, 1, 9, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'zfczeqdazeqxd', '2019-04-03 08:52:06', '2019-04-03 08:52:06'),
(4, 1, 10, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'ETST TEST', '2019-04-06 10:31:31', '2019-04-06 10:31:31'),
(5, 1, 11, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'TEST TEST', '2019-04-06 10:39:03', '2019-04-06 10:39:03'),
(6, 1, 12, NULL, 'Oumar', 'Check', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', 'TEST TEST', '2019-04-06 10:56:29', '2019-04-06 10:56:29'),
(8, 1, 14, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '', '', 'Boulangerie Jerusalem', '2019-04-22 19:06:01', '2019-04-22 19:06:01'),
(9, 1, 15, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '', '', '                                        ', '2019-05-18 08:39:57', '2019-05-18 08:39:57'),
(10, 1, 16, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'niango', '', '', '                                        ', '2019-05-18 08:40:52', '2019-05-18 08:40:52'),
(11, 1, 17, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yegetdg', '', '', '                                        ', '2019-05-18 08:41:15', '2019-05-18 08:41:15'),
(12, 1, 18, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '', '', '                                        ', '2019-05-18 08:41:42', '2019-05-18 08:41:42'),
(13, 1, 19, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 3, 'rhtyjt', '', '', '                                        ', '2019-05-18 08:42:27', '2019-05-18 08:42:27'),
(14, 1, 20, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yuiul', '', '', '                                        ', '2019-05-18 08:43:39', '2019-05-18 08:43:39'),
(15, 1, 21, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'rtyukil', '', '', '                                        ', '2019-05-18 08:44:00', '2019-05-18 08:44:00'),
(16, 1, 22, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'zegryui', '', '', '                                        ', '2019-05-18 08:44:15', '2019-05-18 08:44:15'),
(17, 1, 23, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ertyuio', '', '', '                                        ', '2019-05-18 08:44:33', '2019-05-18 08:44:33'),
(18, 1, 24, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ujtyhtht', '', '', 'gjktrgjhrfbgjdfv', '2019-05-18 08:45:16', '2019-05-18 08:45:16'),
(19, 1, 25, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'Niangon', '', '', '                                        ', '2019-05-18 08:46:05', '2019-05-18 08:46:05'),
(20, 1, 26, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'jkliukyuthr', '', '', '                                        ', '2019-05-18 08:46:25', '2019-05-18 08:46:25'),
(21, 1, 27, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', '                                        ', '2019-05-18 08:46:56', '2019-05-18 08:46:56'),
(22, 1, 28, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', '                                        ', '2019-05-18 08:47:32', '2019-05-18 08:47:32'),
(23, 1, 29, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 3, 'loiubhb', '', '', '                                        ', '2019-05-18 08:47:59', '2019-05-18 08:47:59'),
(24, 1, 30, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', '                                        ', '2019-05-18 08:48:18', '2019-05-18 08:48:18'),
(25, 1, 31, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '', '', '                                        ', '2019-05-18 08:48:50', '2019-05-18 08:48:50'),
(26, 1, 32, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'yegetdg', '', '', '                                        ', '2019-05-18 08:49:07', '2019-05-18 08:49:07'),
(27, 1, 33, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', '                                        ', '2019-05-18 08:50:28', '2019-05-18 08:50:28'),
(28, 1, 34, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'niango', '', '', '                                        ', '2019-05-18 08:51:08', '2019-05-18 08:51:08'),
(29, 1, 35, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'ghyugfdfgfh', '', '', '                                        ', '2019-05-18 08:52:18', '2019-05-18 08:52:18'),
(30, 1, 36, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 2, 'iouyht', '', '', '                                        ', '2019-05-18 08:52:42', '2019-05-18 08:52:42'),
(31, 1, 37, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '', '', '                                        ', '2019-05-18 08:53:09', '2019-05-18 08:53:09'),
(32, 1, 38, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'Niangon', '', '', '                                        ', '2019-05-18 08:54:01', '2019-05-18 08:54:01'),
(33, 1, 39, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '', '', '                                        ', '2019-05-18 08:55:02', '2019-05-18 08:55:02'),
(34, 1, 40, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '', '', '                                        ', '2019-05-18 08:57:09', '2019-05-18 08:57:09'),
(35, 1, 41, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'angres', '', '', '                                        ', '2019-05-18 08:57:31', '2019-05-18 08:57:31'),
(36, 1, 42, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'loiubhb', '', '', '                                        ', '2019-05-18 09:00:05', '2019-05-18 09:00:05'),
(37, 1, 43, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 2, 'yegetdg', '', '', '                                        ', '2019-05-18 09:01:02', '2019-05-18 09:01:02'),
(38, 1, 44, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'riviera', '', '', '                                        ', '2019-05-18 09:01:34', '2019-05-18 09:01:34'),
(39, 1, 45, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '', '', '                                        ', '2019-05-18 09:02:40', '2019-05-18 09:02:40'),
(40, 1, 46, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '', '', '                                        ', '2019-05-18 09:03:10', '2019-05-18 09:03:10'),
(41, 1, 47, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Niangon', '', '', '                                        ', '2019-05-18 09:03:30', '2019-05-18 09:03:30'),
(42, 1, 48, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'blokauss', '', '', 'TEST', '2019-07-19 23:53:57', '2019-07-19 23:53:57'),
(43, 1, 49, 1, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Genie 2000 FAYA, Abidjan, Côte d\'Ivoire', '5.3728208', '-3.9362088000000313', 'TESTST', '2019-12-11 07:53:08', '2019-12-11 07:53:08'),
(44, 1, 50, 2, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 4, 'Commissariat de police 22 ieme Arrondissement, Boulevard des Martyrs, Abidjan, Côte d\'Ivoire', '5.398477699999999', '-3.991317400000071', 'A Angré', '2019-12-11 08:21:16', '2019-12-11 08:21:16'),
(45, 0, NULL, 3, 'test', 'etsts', '0244444', 'ghedcf', 4, 'Texas Grillz, Abidjan, Côte d\'Ivoire', '-3.9769608999999946', '5.3485508', '2019-12-17 15:02:57', '2019-12-17 15:02:57', '2019-12-17 15:02:57'),
(46, 0, NULL, 4, 'test', 'etsts', '0244444', 'ghedcf', 4, 'Texas Grillz, Abidjan, Côte d\'Ivoire', '-3.9769608999999946', '5.3485508', 'TEST VITE VIRE', '2019-12-17 15:04:27', '2019-12-17 15:04:27'),
(47, 0, NULL, 5, 'romeo', 'oulai', '01038387', 'romeo.kesso@ngser.com', 3, '220 logement, C 37, Abidjan, Côte d\'Ivoire', '-4.018034400000033', '5.344662', 'BIEN', '2019-12-17 15:06:40', '2019-12-17 15:06:40'),
(48, 0, NULL, 6, 'TEST', 'ROMEO', '20122536', 'test@image.com', 1, 'Angré, Abidjan, Côte d\'Ivoire', '-3.9827405', '5.3862285', 'TEST', '2020-01-12 22:02:29', '2020-01-12 22:02:29'),
(49, 0, NULL, 7, 'TEST', 'ROMEO', '20122536', 'test@image.com', 1, 'Angré, Abidjan, Côte d\'Ivoire', '-3.9827405', '5.3862285', 'TEST', '2020-01-12 22:04:25', '2020-01-12 22:04:25'),
(50, 1, 51, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Cocody, Abidjan, Côte d\'Ivoire', '5.3602164', '-3.967437099999999', 'TEST', '2020-03-12 00:35:33', '2020-03-12 00:35:33'),
(51, 1, 52, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Yopougon Maroc, Abidjan, Côte d\'Ivoire', '5.339066100000001', '-4.1004971', 'TEST', '2020-03-12 00:37:31', '2020-03-12 00:37:31'),
(52, 1, 53, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Plateau, Abidjan, Côte d\'Ivoire', '5.323318', '-4.0235718', 'TEST', '2020-03-12 00:55:07', '2020-03-12 00:55:07'),
(53, 1, 54, NULL, 'MAGASSOUBA', 'Oumar Check Premier', '01010101', 'check.oumar@test.ci', 1, 'Daloa, Côte d\'Ivoire', '6.8883341', '-6.439688800000001', 'TEST', '2020-03-12 00:58:22', '2020-03-12 00:58:22'),
(54, 14, 55, NULL, 'ali', 'fere', '01010113', 'ali@boss.ci', 5, 'YAKRO', '0', '0', 'YAKRO', '2020-12-14 05:30:20', '2020-12-14 05:30:20'),
(55, 7, 55, NULL, 'TEST', 'BOBI', '01010103', 'test4@boss.ci', 5, 'YAKRO', '0', '0', 'YAKRO', '2020-12-18 10:55:10', '2020-12-18 10:55:10'),
(56, 11, 56, NULL, 'MATHIEU', 'BIBO', '01040511', ' ', 5, 'YAKRO', '0', '0', 'YAKRO', '2020-12-18 21:20:11', '2020-12-18 21:20:11'),
(57, 19, 57, NULL, 'KESSO', 'Romeo', '01202020', 'romkesso92@gmail.com', 5, 'YAKRO', '0', '0', 'YAKRO', '2020-12-20 10:41:10', '2020-12-20 10:41:10');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

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
(14, 7, 'STK2019070014AM', 90, 18000, 500, 18500, NULL, 5, '2019-07-01 04:35:07', '2019-07-01 04:35:07'),
(15, 28, 'STK2020030015AM', 25, 1000000, 0, 1000000, NULL, 1, '2020-03-12 00:34:01', '2020-03-12 00:34:01');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `token`, `libelle`, `symbole`, `date_creation`, `date_modification`) VALUES
(1, 'nfggggggd14', 'kilogramme', 'Kg', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(2, 'mpongzfs4522', 'litre', 'L', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(3, 'gdsfhsjhs0155', 'nombre', 'NA', '2018-11-01 00:00:00', '2018-11-01 00:00:00'),
(4, 'UM2019070004AM', 'Hectare', 'Ha', '2019-07-04 05:05:07', '2019-07-04 05:05:07'),
(5, 'UM2019070005AM', 'metre carré', 'M²', '2019-07-04 05:09:33', '2019-07-04 05:09:33');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `token`, `nom`, `prenoms`, `tel`, `email`, `password`, `statut`, `image`, `id_profil`, `date_creation`, `date_modification`) VALUES
(1, 'chsdbcbsbhsd5222', 'Admin', 'Boss', '09841171', 'admin@market.com', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 'chsdbcbsbhsd5222', 1, '2019-05-08 00:00:00', '2019-12-09 00:59:38'),
(2, 'chsdbcbsbhfhd562121', 'Admin', 'Boss', '09841171', 'admin@cissesoft.com', 'f5b8569f25528d10c56fe9808b0aa9e3', 1, 'chsdbcbsbhsd5222', 1, '2019-05-08 00:00:00', '2019-12-09 00:59:38');

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

DROP TABLE IF EXISTS `versements`;
CREATE TABLE IF NOT EXISTS `versements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `type_paiement` int(1) DEFAULT NULL COMMENT '0=espece ; 1=solde',
  `montant_a_payer` float NOT NULL,
  `montant_verser` float NOT NULL,
  `reste` float NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `versements`
--

INSERT INTO `versements` (`id`, `token`, `id_commande`, `id_client`, `type_paiement`, `montant_a_payer`, `montant_verser`, `reste`, `date_creation`, `date_modification`) VALUES
(7, 'CF2020120007VS', 56, 11, 0, 735, 500, 235, '2020-12-20 20:07:24', '2020-12-20 20:07:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
