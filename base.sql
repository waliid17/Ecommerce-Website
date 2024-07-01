-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 01 juil. 2024 à 02:22
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
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL,
  `nom_ad` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email_ad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mdp_ad` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prenom_ad` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email_ad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `prenom`, `nom`, `email`, `mot_de_passe`, `role`, `telephone`, `adresse`) VALUES
(11, 'walid', 'kheloufi', 'walidkheloufi00@gmail.com', 'walid123', 'admin', '0540363847', 'ouled fayet plato win ybi3o ldjadj'),
(57, 'dsds', 'gfgfgf', 'walidkheloufi00@gmail.com', 'wawawa', 'user', '0540363847', 'wawawawawa'),
(50, 'chaouki', 'beddiar', 'chaouki@gmail.com', 'walid123', 'user', '0540363847', 'cheraga');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int NOT NULL,
  `date_com` date DEFAULT NULL,
  PRIMARY KEY (`id_com`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `id_devis` int NOT NULL AUTO_INCREMENT,
  `date_devis` datetime NOT NULL,
  PRIMARY KEY (`id_devis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_img` int NOT NULL,
  `url_img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `prenom`, `nom`, `phone`, `email`, `sujet`, `contenu`, `date`) VALUES
(3, 'walid', 'kheloufi', '0540363847', 'walidkheloufi00@gmail.com', 'cle', 'kjfdskjhfdhfgddhjkfdhgfdf', '2024-06-29 21:43:41');

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
(51, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, '15138.jpeg', 'YATO'),
(28, 'CLE A CHOC', 'CLE A CHOC PNEUMATIQUE 1/4 YATO', 17900.00, 17800.00, '15118.jpeg', 'YATO'),
(32, 'BATTERIE', 'BATTERIE 20V 2000MAH HONESTPRO', 5000.00, 4800.00, 'YAE2375B (1).jpeg', 'HONESTPRO'),
(33, ' PERFORATEUR', ' PERFORATEUR 1050W BODA', 11000.00, 10500.00, 'H6-28.jpeg', 'BODA'),
(47, 'CLE A CHOC', '2IN1 PNEUMATIC TOLSEN', 15300.00, 12700.00, 'JEAB0216.jpeg', 'HONESTPRO'),
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
