-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 31 août 2024 à 23:28
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `base`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `telephone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `prenom`, `nom`, `email`, `mot_de_passe`, `role`, `telephone`, `adresse`) VALUES
(186, 'chaouki', 'beddiar', 'chaouki@gmail.com', 'walid123', 'user', '0540363847', 'cheraga'),
(185, 'walid', 'kheloufi', 'walidkheloufi00@gmail.com', 'walid123', 'admin', '0540363847', 'cheraga');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int NOT NULL AUTO_INCREMENT,
  `date_com` date DEFAULT NULL,
  `statut` varchar(30) NOT NULL,
  `frais_livraison` decimal(7,2) DEFAULT '0.00',
  PRIMARY KEY (`id_com`)
) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_com`, `date_com`, `statut`, `frais_livraison`) VALUES
(164, '2024-09-01', 'Pending', NULL),
(163, '2024-09-01', 'pending', 0.00),
(162, '2024-09-01', 'pending', 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `conteniroutil`
--

DROP TABLE IF EXISTS `conteniroutil`;
CREATE TABLE IF NOT EXISTS `conteniroutil` (
  `id_com` int NOT NULL,
  `id_outil` int NOT NULL,
  `Qte_com` int DEFAULT NULL,
  PRIMARY KEY (`id_com`,`id_outil`),
  KEY `id_outil` (`id_outil`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `conteniroutil`
--

INSERT INTO `conteniroutil` (`id_com`, `id_outil`, `Qte_com`) VALUES
(163, 48, 1),
(162, 48, 1),
(161, 48, 1),
(160, 48, 1),
(159, 48, 1),
(158, 48, 1),
(157, 52, 1),
(156, 50, 9),
(156, 49, 1),
(156, 48, 3),
(154, 52, 1),
(154, 50, 1),
(154, 48, 1),
(155, 50, 1),
(155, 49, 1),
(155, 48, 1);

-- --------------------------------------------------------

--
-- Structure de la table `effectuer_com`
--

DROP TABLE IF EXISTS `effectuer_com`;
CREATE TABLE IF NOT EXISTS `effectuer_com` (
  `id_com` int NOT NULL,
  `id_client` int NOT NULL,
  PRIMARY KEY (`id_com`,`id_client`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `effectuer_com`
--

INSERT INTO `effectuer_com` (`id_com`, `id_client`) VALUES
(155, 186),
(156, 186),
(157, 186),
(158, 186),
(159, 186),
(160, 186),
(161, 186),
(162, 186),
(163, 186);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_img` int NOT NULL AUTO_INCREMENT,
  `url_img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_img`, `url_img`) VALUES
(33, 'images/logo7.png'),
(32, 'images/logo6.png'),
(31, 'images/logo5.png'),
(30, 'images/logo4.png'),
(29, 'images/logo3.png'),
(28, 'images/logo2.png'),
(43, 'uploads/logo1.png');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `sujet` varchar(50) DEFAULT NULL,
  `contenu` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `prenom`, `nom`, `phone`, `email`, `sujet`, `contenu`, `date`) VALUES
(73, 'walid', 'khelouffi', '0540363847', 'chaouki@gmail.com', 'dddd', 'dddddddddd', '2024-08-24 21:59:16'),
(71, 'walid', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggggggggggggg', '2024-08-24 21:43:02'),
(70, 'walid', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggggggggggggg', '2024-08-24 21:42:59'),
(69, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:37'),
(68, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:36'),
(67, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:34'),
(66, 'walid', 'khelouffi', '0540363847', 'chaoffffuki@gmail.com', 'dddd', 'wawawaa', '2024-08-21 19:49:54'),
(65, 'walid', 'khelouffi', '0540363847', 'chaoffffuki@gmail.com', 'dddd', 'wawawaa', '2024-08-21 19:49:53'),
(58, 'walid', 'khelouffi', '0540363847', 'walidkheloufi00@gmail.com', 'jfhjgshdgshdsdsds', 'hhh', '2024-08-21 11:22:03'),
(59, 'walid', 'khelouffi', '0540363847', 'walidkheloufi00@gmail.com', 'jfhjgshdgshdsdsds', 'hhh', '2024-08-21 11:22:06'),
(60, 'walid', 'khelouffi', '0540363847', 'walidkheloufi00@gmail.com', 'jfhjgshdgshdsdsds', 'hhh', '2024-08-21 11:22:07'),
(61, 'ahmed', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggg', '2024-08-21 11:22:46'),
(62, 'ahmed', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggg', '2024-08-21 11:22:48'),
(63, 'ahmed', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggg', '2024-08-21 11:22:49'),
(64, 'walid', 'khelouffi', '0540363847', 'chaoffffuki@gmail.com', 'dddd', 'wawawaa', '2024-08-21 19:49:46');

-- --------------------------------------------------------

--
-- Structure de la table `outil`
--

DROP TABLE IF EXISTS `outil`;
CREATE TABLE IF NOT EXISTS `outil` (
  `id_outil` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ancien_prix` decimal(7,2) NOT NULL,
  `prix_actuel` decimal(7,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `marque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_outil`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `outil`
--

INSERT INTO `outil` (`id_outil`, `nom`, `description`, `ancien_prix`, `prix_actuel`, `image`, `marque`) VALUES
(48, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, 'T825010R.jpeg', 'BODA'),
(49, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, '15118.jpeg', 'TOLSEN'),
(50, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, 'YT8823.jpeg', 'HONESTPRO'),
(52, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, 'YT2374.jpeg', 'BODA'),
(53, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 13200.00, 'YAE2375B (1).jpeg', 'BODA'),
(54, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 13200.00, '45244.jpeg', 'TOLSEN'),
(55, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 13200.00, '15141.jpeg', 'TOLSEN'),
(56, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 13200.00, '15138.jpeg', 'TOLSEN'),
(57, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 13200.00, '32060.jpeg', 'TOLSEN');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
