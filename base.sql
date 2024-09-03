-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 sep. 2024 à 16:05
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
  `activation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `prenom`, `nom`, `email`, `mot_de_passe`, `role`, `telephone`, `adresse`, `activation`) VALUES
(1, 'chaouki', 'beddiar', 'chaouki@gmail.com', 'walid123', 'user', '0540363847', 'cheraga', 1),
(192, 'walid', 'khelouffi', 'walidkheloufi00@gmail.com', 'walid123', 'admin', '0540363847', 'cheraga', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int NOT NULL AUTO_INCREMENT,
  `date_com` date DEFAULT NULL,
  `statut` varchar(30) NOT NULL,
  `id_wilaya` int DEFAULT NULL,
  PRIMARY KEY (`id_com`),
  KEY `fk_id_wilaya` (`id_wilaya`)
) ENGINE=MyISAM AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_com`, `date_com`, `statut`, `id_wilaya`) VALUES
(170, '2024-09-02', 'pending', 6),
(169, '2024-09-02', 'pending', 13),
(171, '2024-09-02', 'pending', 6),
(172, '2024-09-02', 'pending', 6),
(173, '2024-09-02', 'pending', 6),
(174, '2024-09-02', 'pending', 6),
(175, '2024-09-02', 'pending', 6),
(176, '2024-09-02', 'pending', 6),
(177, '2024-09-02', 'pending', 9),
(178, '2024-09-02', 'pending', 3);

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
(178, 49, 9),
(178, 48, 1),
(177, 48, 1),
(177, 52, 1),
(177, 50, 1),
(177, 49, 1),
(176, 52, 1),
(176, 49, 1),
(175, 52, 4),
(175, 48, 3),
(174, 52, 4),
(174, 48, 3),
(173, 52, 4),
(173, 48, 3),
(172, 52, 4),
(172, 48, 3),
(171, 52, 4),
(171, 48, 3),
(170, 52, 4),
(170, 48, 3),
(169, 49, 1),
(169, 48, 1);

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
(169, 186),
(170, 186),
(171, 186),
(172, 186),
(173, 186),
(174, 186),
(175, 186),
(176, 186),
(177, 186),
(178, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `prenom`, `nom`, `phone`, `email`, `sujet`, `contenu`, `date`) VALUES
(73, 'walid', 'khelouffi', '0540363847', 'chaouki@gmail.com', 'dddd', 'dddddddddd', '2024-08-24 21:59:16'),
(74, 'walid', 'khelouffi', '0540363847', 'chaouki@gmail.com', 'dddd', 'dddd', '2024-09-02 20:23:27'),
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

-- --------------------------------------------------------

--
-- Structure de la table `wilaya`
--

DROP TABLE IF EXISTS `wilaya`;
CREATE TABLE IF NOT EXISTS `wilaya` (
  `id_wilaya` int NOT NULL AUTO_INCREMENT,
  `wilaya` varchar(30) NOT NULL,
  `delivery_price` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id_wilaya`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `wilaya`
--

INSERT INTO `wilaya` (`id_wilaya`, `wilaya`, `delivery_price`) VALUES
(1, 'Adrar', 800.00),
(2, 'Chlef', 650.00),
(3, 'Laghouat', 700.00),
(4, 'Oum El Bouaghi', 650.00),
(5, 'Batna', 650.00),
(6, 'Béjaïa', 650.00),
(7, 'Biskra', 700.00),
(8, 'Béchar', 750.00),
(9, 'Blida', 500.00),
(10, 'Bouira', 600.00),
(11, 'Tamanrasset', 900.00),
(12, 'Tébessa', 650.00),
(13, 'Tlemcen', 700.00),
(14, 'Tiaret', 700.00),
(15, 'Tizi Ouzou', 600.00),
(16, 'Algiers', 500.00),
(17, 'Djelfa', 700.00),
(18, 'Jijel', 650.00),
(19, 'Sétif', 650.00),
(20, 'Saïda', 700.00),
(21, 'Skikda', 650.00),
(22, 'Sidi Bel Abbès', 700.00),
(23, 'Annaba', 600.00),
(24, 'Guelma', 600.00),
(25, 'Constantine', 600.00),
(26, 'Médéa', 600.00),
(27, 'Mostaganem', 650.00),
(28, 'M’Sila', 700.00),
(29, 'Mascara', 700.00),
(30, 'Ouargla', 800.00),
(31, 'Oran', 700.00),
(32, 'El Bayadh', 800.00),
(33, 'Illizi', 900.00),
(34, 'Bordj Bou Arréridj', 650.00),
(35, 'Boumerdès', 600.00),
(36, 'El Tarf', 600.00),
(37, 'Tindouf', 900.00),
(38, 'Tissemsilt', 700.00),
(39, 'El Oued', 800.00),
(40, 'Khenchela', 650.00),
(41, 'Souk Ahras', 600.00),
(42, 'Tipaza', 550.00),
(43, 'Mila', 650.00),
(44, 'Aïn Defla', 650.00),
(45, 'Naâma', 800.00),
(46, 'Aïn Témouchent', 700.00),
(47, 'Ghardaïa', 800.00),
(48, 'Relizane', 700.00),
(49, 'Timimoun', 850.00),
(50, 'Bordj Badji Mokhtar', 900.00),
(51, 'Ouled Djellal', 700.00),
(52, 'Béni Abbès', 850.00),
(53, 'In Salah', 900.00),
(54, 'In Guezzam', 900.00),
(55, 'Touggourt', 800.00),
(56, 'Djanet', 900.00),
(57, 'El M’Ghair', 700.00),
(58, 'El Meniaa', 800.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
