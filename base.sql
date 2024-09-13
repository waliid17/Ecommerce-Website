-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 sep. 2024 à 18:34
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
  `id_ad` int NOT NULL AUTO_INCREMENT,
  `nom_ad` varchar(30) NOT NULL,
  `email_ad` varchar(30) NOT NULL,
  `pwd_ad` varchar(30) NOT NULL,
  PRIMARY KEY (`id_ad`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_ad`, `nom_ad`, `email_ad`, `pwd_ad`) VALUES
(1, 'walid', 'walidkheloufi@gmail.com', 'walid123');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `nom_cat`) VALUES
(1, 'Electroportatif'),
(2, 'Outillage à main'),
(3, 'Chantier'),
(4, 'Sécurité'),
(5, 'Jardin');

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
  `telephone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `activation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `prenom`, `nom`, `email`, `mot_de_passe`, `telephone`, `adresse`, `activation`) VALUES
(193, 'pnono', 'ahmed', 'senouciahmed@gmail.com', 'pnono123', '0540363847', 'cheraga', 0),
(1, 'chaouki', 'beddiar', 'chaouki@gmail.com', 'walid123', '0540363847', 'cheraga', 1),
(192, 'walid', 'khelouffi', 'walidkheloufi00@gmail.com', 'walid123', '0540363847', 'cheraga', 1),
(194, 'yaya', 'abdulahhhh', 'abdellahyahianafa@gmail.com', 'yaya123456', '0540363847', 'cheraga', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int NOT NULL AUTO_INCREMENT,
  `date_com` date DEFAULT NULL,
  `statut` enum('En attente','Confirmée','Expédiée','Livrée','Annulée') NOT NULL,
  `id_wilaya` int DEFAULT NULL,
  `adr_Liv` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_com`),
  KEY `fk_id_wilaya` (`id_wilaya`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int NOT NULL AUTO_INCREMENT,
  `url_marque` varchar(255) DEFAULT NULL,
  `nom_marque` varchar(30) NOT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `url_marque`, `nom_marque`) VALUES
(7, 'images/logo7.png', 'BEETRO'),
(6, 'images/logo6.png', 'HOTECHE'),
(5, 'images/logo5.png', 'CROWN'),
(4, 'images/logo4.png', 'TOLSEN'),
(3, 'images/logo3.png', 'BODA'),
(2, 'images/logo2.png', 'HONESTPRO'),
(1, 'uploads/logo1.png', 'YATO');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `ID_Msg` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Sjt_Msg` varchar(50) DEFAULT NULL,
  `Ctn_Msg` text,
  `Date_Msg` timestamp NULL DEFAULT NULL,
  `id_client` int NOT NULL,
  PRIMARY KEY (`ID_Msg`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id_cat` int NOT NULL,
  `id_marque` int DEFAULT NULL,
  PRIMARY KEY (`id_outil`),
  KEY `fk_outil_categorie` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `outil`
--

INSERT INTO `outil` (`id_outil`, `nom`, `description`, `ancien_prix`, `prix_actuel`, `image`, `id_cat`, `id_marque`) VALUES
(7, 'CLE CROIX', 'CLE CROIX 1/2″ 17*19*21 TOPTUL', 3900.00, 3600.00, 'AEAL1616.jpeg', 1, 5),
(6, 'CLE A GRIFE', '• Mâchoire mobile forgée avec de l’acier au carbone de haute qualité• Emballage : étiquette volante avec boîte de dessin', 1650.00, 1200.00, 'YT2490.jpeg', 1, 1),
(2, 'Bouloneuse', 'Puissance : 550 W max. couple : 300N.m Vitesse à vide : 0-3200min', 13700.00, 12500.00, 'YAE2388.jpeg', 1, 4),
(3, 'CLE A CHOC ', 'CLE A CHOC PNEUMATIQUE 1/4 YATO', 17500.00, 16900.00, 'YT09511.jpeg', 1, 1),
(5, 'CLE A CLIQUET', '• CrV• Chromé, finition satinée• Emballage : cintre en plastique avec étiquette de couleur', 1800.00, 1300.00, '15243.jpeg', 2, 4),
(4, 'PONCEUSE', 'PONCEUSE POLISSEUSE PNEUMATIQUE YATO', 12700.00, 11500.00, 'YAE2229.jpeg', 2, 4),
(1, 'Batterie', 'Tension 20V Temps de charge 1h Capacité 2.0Ah', 5000.00, 4800.00, 'YAE2375B.jpeg', 2, 2),
(8, 'CLE MIXTE 6', 'Toptul AAEB0606 Clé mixte standard 15° 6mmCaractéristiques :Matériau en acier au chrome vanadiumPerformances de couple élevées jusqu à plus de 1,6 fois comme ANSI &amp;amp;amp;amp; Norme DINQualité professionnelle pour une durabilité et une résistance à la corrosion maximalesSpécifications :Finition : Satin ChromeTaille : 6 mmLongueur : 109 mm', 1500.00, 1200.00, 'AAEB0606.jpeg', 2, 3),
(9, 'AIRLESS MBRN', 'AIRLESS MBRN 3000W 5L/MIN HONESTPRO', 68000.00, 65000.00, 'YAE4701.jpeg', 3, 4),
(10, 'BLOC AIRLESS', 'BLOC AIRLESS4707 HONESTPRO', 8900.00, 8300.00, 'YAE4811.jpeg', 3, 2),
(11, 'BUSE', 'Modèle de buse de pulvérisation : 417 Modèles applicables : YAE4701/YAE4705/YAE4706', 1800.00, 1300.00, 'YAE4832.jpeg', 3, 3),
(12, 'CAROTTEUSE', 'Puissance : 3200W max. diamètre de perçage : 230 mm Vitesse à vide : 700 min', 73500.00, 70000.00, 'YAE2733.jpeg', 3, 1),
(13, 'BOUTE 45', '• Approbation CE • Matériau : PVC • Embout en acier et semelle intercalaire en acier • Haut niveau de résistance à l huile, aux acides et aux alcalis, 100 % imperméable • Semelle de chaussure Desliching • Emballage : poly-sac avec étiquette de couleur', 2700.00, 2100.00, '45120-600x600.jpeg', 4, 4),
(14, 'CASQUE ANTIBRUIT', '• Approuvé CE et ANSI • Suspension à alignement automatique, ajuste facilement les manchons sur le bandeau pour un ajustement rapide • Le coussin rempli de mousse souple offre une bonne étanchéité pour une protection contre les bruits nocifs • SNR : 26 dB, NRR=21 dB • Emballage : cintre en papier', 1000.00, 900.00, '45083.jpeg', 4, 2),
(15, 'CEINTURE', '• Panneaux avant effilés pour plus de confort lors de la flexion • Larges bretelles élastiques réglables • Baleines internes pour un soutien supplémentaire • Emballage : double blister', 2800.00, 2000.00, '45244.jpeg', 4, 3),
(16, 'LUNETTE DE SOUDAGE', 'LUNETTE DE SOUDAGE AUTO HOTECHE', 3500.00, 3000.00, '439005.jpeg', 4, 7),
(17, 'FOURCHE DE JARDIN', '• Acier à outils spécial forgé • Revêtement en poudre noire • Longueur totale : 310 mm • Épaisseur : 2,5 mm • Poignée en plastique à deux composants • Emballage : étiquette volante', 650.00, 600.00, '57506.jpeg', 5, 4),
(18, 'TONDEUSE A MOUTON', 'Puissance : 500W 13 dents vitesse : 2800min', 13500.00, 12500.00, 'YAE2398.jpeg', 5, 1),
(19, 'DEBROUSSAILLEUSE', 'Cylindrée : 43cc Ralenti : 6500min Puissance moteur : 1.25kW', 18500.00, 17000.00, 'YAE0972.jpeg', 5, 2),
(20, 'RATEAU DE JARDIN', '• Acier à outils spécial forgé • Revêtement en poudre noire • Longueur totale : 285 mm • Diamètre de la tige principale : 8 mm • Poignée en plastique à deux composants • Emballage : à suspendre balise', 650.00, 500.00, '57504.jpeg', 5, 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `wilaya`
--

INSERT INTO `wilaya` (`id_wilaya`, `wilaya`, `delivery_price`) VALUES
(104, 'Aïn Témouchent', 900.00),
(103, 'Naâma', 800.00),
(102, 'Aïn Defla', 650.00),
(101, 'Mila', 650.00),
(100, 'Tipaza', 550.00),
(99, 'Souk Ahras', 600.00),
(98, 'Khenchela', 650.00),
(97, 'El Oued', 800.00),
(95, 'Tindouf', 900.00),
(96, 'Tissemsilt', 700.00),
(94, 'El Tarf', 600.00),
(93, 'Boumerdès', 600.00),
(92, 'Bordj Bou Arréridj', 650.00),
(91, 'Illizi', 900.00),
(90, 'El Bayadh', 800.00),
(89, 'Oran', 700.00),
(88, 'Ouargla', 800.00),
(87, 'Mascara', 700.00),
(86, 'M’Sila', 700.00),
(85, 'Mostaganem', 650.00),
(84, 'Médéa', 600.00),
(83, 'Constantine', 600.00),
(82, 'Guelma', 600.00),
(81, 'Annaba', 600.00),
(80, 'Sidi Bel Abbès', 700.00),
(79, 'Skikda', 650.00),
(78, 'Saïda', 700.00),
(77, 'Sétif', 650.00),
(76, 'Jijel', 650.00),
(75, 'Djelfa', 700.00),
(74, 'Algiers', 500.00),
(73, 'Tizi Ouzou', 600.00),
(72, 'Tiaret', 700.00),
(71, 'Tlemcen', 700.00),
(70, 'Tébessa', 650.00),
(69, 'Tamanrasset', 900.00),
(68, 'Bouira', 600.00),
(67, 'Blida', 500.00),
(66, 'Béchar', 750.00),
(65, 'Biskra', 700.00),
(64, 'Béjaïa', 650.00),
(63, 'Batna', 650.00),
(62, 'Oum El Bouaghi', 650.00),
(61, 'Laghouat', 700.00),
(60, 'Chlef', 650.00),
(59, 'Adrar', 800.00),
(105, 'Ghardaïa', 800.00),
(106, 'Relizane', 700.00),
(107, 'Timimoun', 850.00),
(108, 'Bordj Badji Mokhtar', 900.00),
(109, 'Ouled Djellal', 700.00),
(110, 'Béni Abbès', 850.00),
(111, 'In Salah', 900.00),
(112, 'In Guezzam', 900.00),
(113, 'Touggourt', 800.00),
(114, 'Djanet', 900.00),
(115, 'El M’Ghair', 700.00),
(116, 'El Meniaa', 800.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
