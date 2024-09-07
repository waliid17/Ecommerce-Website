-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 07 sep. 2024 à 14:44
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `statut` varchar(30) NOT NULL,
  `id_wilaya` int DEFAULT NULL,
  PRIMARY KEY (`id_com`),
  KEY `fk_id_wilaya` (`id_wilaya`)
) ENGINE=MyISAM AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_com`, `date_com`, `statut`, `id_wilaya`) VALUES
(309, '2024-09-06', 'pending', 98),
(308, '2024-09-06', 'pending', 100);

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
(309, 3, 2),
(309, 7, 1),
(308, 8, 2),
(307, 52, 2),
(307, 49, 3),
(307, 48, 1);

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
(307, 192),
(308, 192),
(309, 192);

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
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `prenom`, `nom`, `phone`, `email`, `sujet`, `contenu`, `date`) VALUES
(70, 'walid', 'beddiar', '0540363847', 'chaouki@gmail.com', 'jfhjgshdgshdsdsds', 'ggggggggggggg', '2024-08-24 21:42:59'),
(69, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:37'),
(68, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:36'),
(67, 'walid', 'beddiar', '0540363847', 'chaoukii@gmail.com', 'jfhjgshdgshdsdsds', 'gggggggg', '2024-08-21 19:50:34'),
(66, 'walid', 'khelouffi', '0540363847', 'chaoffffuki@gmail.com', 'dddd', 'wawawaa', '2024-08-21 19:49:54'),
(75, 'nabilll', 'boktab', '0540363847', 'walidkheloufi00@gmail.com', 'jfhjgshdgshdsdsdsd', 'ddddddddddddddddd', '2024-09-03 20:19:48');

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
  `id_cat` int NOT NULL,
  PRIMARY KEY (`id_outil`),
  KEY `fk_outil_categorie` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `outil`
--

INSERT INTO `outil` (`id_outil`, `nom`, `description`, `ancien_prix`, `prix_actuel`, `image`, `marque`, `id_cat`) VALUES
(7, 'CLE CROIX', 'CLE CROIX 1/2″ 17*19*21 TOPTUL', 3600.00, 3900.00, 'AEAL1616.jpeg', 'HONESTPRO', 2),
(6, 'CLE A GRIFE', '• Mâchoire mobile forgée avec de l’acier au carbone de haute qualité• Emballage : étiquette volante avec boîte de dessin', 1150.00, 1650.00, 'YT2490.jpeg', 'YATO', 2),
(2, 'Bouloneuse', 'Puissance : 550 W max. couple : 300N.m Vitesse à vide : 0-3200min', 13700.00, 12500.00, 'YAE2388.jpeg', 'BODA', 1),
(3, 'CLE A CHOC ', 'CLE A CHOC PNEUMATIQUE 1/4 YATO', 17500.00, 16900.00, 'YT09511.jpeg', 'YATO', 1),
(5, 'CLE A CLIQUET', '• CrV• Chromé, finition satinée• Emballage : cintre en plastique avec étiquette de couleur', 1200.00, 1800.00, '15243.jpeg', 'TOLSEN', 2),
(4, 'PONCEUSE', 'PONCEUSE POLISSEUSE PNEUMATIQUE YATO', 12700.00, 11500.00, 'YAE2229.jpeg', 'TOLSEN', 1),
(1, 'Batterie', 'Tension 20V Temps de charge 1h Capacité 2.0Ah', 5000.00, 4800.00, 'YAE2375B.jpeg', 'HONESTPRO', 1),
(8, 'CLE MIXTE 6', 'Toptul AAEB0606 Clé mixte standard 15° 6mmCaractéristiques :Matériau en acier au chrome vanadiumPerformances de couple élevées jusqu à plus de 1,6 fois comme ANSI &amp; Norme DINQualité professionnelle pour une durabilité et une résistance à la corrosion maximalesSpécifications :Finition : Satin ChromeTaille : 6 mmLongueur : 109 mm', 1200.00, 1500.00, 'AAEB0606.jpeg', 'BODA', 2),
(9, 'AIRLESS MBRN', 'AIRLESS MBRN 3000W 5L/MIN HONESTPRO', 65000.00, 68000.00, 'YAE4701.jpeg', 'TOLSEN', 3),
(10, 'BLOC AIRLESS', 'BLOC AIRLESS4707 HONESTPRO', 8300.00, 8900.00, 'YAE4811.jpeg', 'HONESTPRO', 3),
(11, 'BUSE', 'Modèle de buse de pulvérisation : 417 Modèles applicables : YAE4701/YAE4705/YAE4706', 1300.00, 1800.00, 'YAE4832.jpeg', 'BODA', 3),
(12, 'CAROTTEUSE', 'Puissance : 3200W max. diamètre de perçage : 230 mm Vitesse à vide : 700 min', 70000.00, 73500.00, 'YAE2733.jpeg', 'YATO', 3),
(13, 'BOUTE 45', '• Approbation CE • Matériau : PVC • Embout en acier et semelle intercalaire en acier • Haut niveau de résistance à l huile, aux acides et aux alcalis, 100 % imperméable • Semelle de chaussure Desliching • Emballage : poly-sac avec étiquette de couleur', 2100.00, 2700.00, '45120-600x600.jpeg', 'TOLSEN', 4),
(14, 'CASQUE ANTIBRUIT', '• Approuvé CE et ANSI • Suspension à alignement automatique, ajuste facilement les manchons sur le bandeau pour un ajustement rapide • Le coussin rempli de mousse souple offre une bonne étanchéité pour une protection contre les bruits nocifs • SNR : 26 dB, NRR=21 dB • Emballage : cintre en papier', 900.00, 1000.00, '45083.jpeg', 'HONESTPRO', 4),
(15, 'CEINTURE', '• Panneaux avant effilés pour plus de confort lors de la flexion • Larges bretelles élastiques réglables • Baleines internes pour un soutien supplémentaire • Emballage : double blister', 2000.00, 2800.00, '45244.jpeg', 'BODA', 4),
(16, 'LUNETTE DE SOUDAGE', 'LUNETTE DE SOUDAGE AUTO HOTECHE', 3000.00, 3500.00, '439005.jpeg', 'YATO', 4),
(17, 'FOURCHE DE JARDIN', '• Acier à outils spécial forgé • Revêtement en poudre noire • Longueur totale : 310 mm • Épaisseur : 2,5 mm • Poignée en plastique à deux composants • Emballage : étiquette volante', 600.00, 650.00, '57506.jpeg', 'TOLSEN', 5),
(18, 'TONDEUSE A MOUTON', 'Puissance : 500W 13 dents vitesse : 2800min', 12500.00, 13550.00, 'YAE2398.jpeg', 'YATO', 5),
(19, 'DEBROUSSAILLEUSE', 'Cylindrée : 43cc Ralenti : 6500min Puissance moteur : 1.25kW', 17000.00, 18500.00, 'YAE0972.jpeg', 'HONESTPRO', 5),
(20, 'RATEAU DE JARDIN', '• Acier à outils spécial forgé • Revêtement en poudre noire • Longueur totale : 285 mm • Diamètre de la tige principale : 8 mm • Poignée en plastique à deux composants • Emballage : à suspendre balise', 500.00, 650.00, '57504.jpeg', 'BODA', 5),
(21, 'AGRAFEUSE PNEUMATIQUE', '• Homologation CE • Convient aux agrafes : Agrafes à couronne 21Ga. 0.95*0.66mm : 6-16mm • Capacité du magasin : 120 pcs • Pression de fonctionnement : 60psi(0.4Mpa)-100psi(0.7Mpa) • Entrée d’air : 1/4″ • Filet poids : 0,8 kg • Idéal pour le rembourrage, l’assemblage d’armoires, la fabrication de meubles • Accessoires : 300 agrafes à couronne 2 clés hexagonales 1 pot d’huile 3 attaches rapides avec filetage mâle 1/4 ″ PT • Emballage : boîte de couleur', 6500.00, 7500.00, '73425.jpeg', 'TOLSEN', 2);

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
