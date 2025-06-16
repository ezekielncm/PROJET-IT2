-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 14 juin 2025 à 16:37
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `urbanhome`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

DROP TABLE IF EXISTS `achat`;
CREATE TABLE IF NOT EXISTS `achat` (
  `id_achat` int NOT NULL AUTO_INCREMENT,
  `id_bailleur` int NOT NULL,
  `id_propriete` int NOT NULL,
  `id_client` int NOT NULL,
  `id_agent` int NOT NULL,
  `date_achat` date NOT NULL,
  PRIMARY KEY (`id_achat`),
  UNIQUE KEY `id_propriete` (`id_propriete`),
  KEY `id_client` (`id_client`),
  KEY `id_agent` (`id_agent`),
  KEY `id_bailleur` (`id_bailleur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id_achat`, `id_bailleur`, `id_propriete`, `id_client`, `id_agent`, `date_achat`) VALUES
(1, 3, 1, 1, 2, '2025-06-13'),
(2, 0, 16, 1, 0, '2025-06-13');

-- --------------------------------------------------------

--
-- Structure de la table `affectation`
--

DROP TABLE IF EXISTS `affectation`;
CREATE TABLE IF NOT EXISTS `affectation` (
  `id_affectation` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_agent` int NOT NULL,
  `date_affectationn` int NOT NULL,
  PRIMARY KEY (`id_affectation`),
  KEY `id_client` (`id_client`),
  KEY `id_agent` (`id_agent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `id_agent` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_agent`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id_agent`, `nom`, `prenom`, `username`, `telephone`, `mot_de_passe`) VALUES
(1, 'tapsoba', 'Landry', 'TL', '56789090', '$2y$10$ZiOpmW24KRAiosLTM/WP8.N8oZItWzsQHFnD9I0RBQm8vRB5fqI5K'),
(2, 'Ouedraogo', 'Ousmane', 'ousmane', '00010203', '1234'),
(3, 'Ilboudo', 'Samir', '', '00010203', '1234'),
(4, 'BALIA', 'ALAIAOL', '', '77809090', '123456789'),
(5, 'OUEDRAOGO', 'ALEX', '', '26789090', '2002020'),
(6, 'OUEDRAOGO', 'ismael', '', '96789090', '2002020');

-- --------------------------------------------------------

--
-- Structure de la table `bailleur`
--

DROP TABLE IF EXISTS `bailleur`;
CREATE TABLE IF NOT EXISTS `bailleur` (
  `id_bailleur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `raison_social` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_bailleur`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `bailleur`
--

INSERT INTO `bailleur` (`id_bailleur`, `nom`, `prenom`, `raison_social`, `adresse`, `email`, `telephone`, `mot_de_passe`) VALUES
(6, 'Nacoulma', 'Ezekiel', 'Aa', 'mnacoulmaezekiel@gmail.com', 'mnacoulmaezekiel@gmail.com', '+22662070058', '$2y$10$X2GWCSgewBKRbu684YNYoO7KBXsMzh8Gcz/ISQUx7Fw/RWB.x66GK'),
(2, 'BA', 'YOUSSSAHOU', 'DJEBA TRAVEL', 'SECTEIUR,58', 'youssahouba.djeba@gmail.com', '64981938', '$2y$10$paLKpLrKSqZEvnQiHf2Kf.nB.vCfZZlZnixuHeFRudW8KhzTIV91u'),
(4, 'WW', 'WWW', 'balimaismael@gmail.com', '', '23232323', '2', '2W'),
(3, 'BIYO', 'Cheick Omar Yob', 'CKPROD', 'secteur 51,karpala', 'Yobibah7295@gmail.com', '54806093', '$2y$10$heAhEL88FuQz2KNSS3V7AOLsZLeIomGOKEVF4qv2w6xxX72fmvpWm');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `id_agent` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`),
  KEY `id_agent` (`id_agent`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `id_agent`, `nom`, `prenom`, `adresse`, `email`, `telephone`, `mot_de_passe`) VALUES
(1, 2, 'BA', 'Cheick Omar Yobi', 'SECTEIUR,58', 'Yobibah7295@gmail.com', '54806093', '$2y$10$ZiOpmW24KRAiosLTM/WP8.N8oZItWzsQHFnD9I0RBQm8vRB5fqI5K'),
(2, 1, 'PODA', 'STEVE', 'TANGHIN', 'stevepoda04@gmail.com', '09897867', '$2y$10$fCNme/s21OCKwxXH4LBKP.VCAhuIk7rRhS.ToikB9X71.TEP0nrCK'),
(3, 3, 'OUE', 'RACHIDA', '-', 'Oue1345@gmail.com', '123456789', '$2y$10$S6NCudYgi.JNYcXwCkluFu97oSSRlmjJiPw0a47GccbxQtZsD5Gle'),
(4, 4, 'Nacoulma', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', 'mnacoulmaezekiel@gmail.com', '+22662070058', '$2y$10$7pwErmPEn0FxpGptn9HOT.2YlClRc9mG0h8rzJEOnFsC7F.KTPawW');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favoris` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_propiete` int NOT NULL,
  `date_ajout` int NOT NULL,
  PRIMARY KEY (`id_favoris`),
  KEY `id_client` (`id_client`),
  KEY `id_propiete` (`id_propiete`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id_favoris`, `id_client`, `id_propiete`, `date_ajout`) VALUES
(15, 6, 1, 2025),
(23, 4, 13, 2025),
(22, 1, 16, 2025),
(21, 1, 11, 2025),
(19, 1, 1, 2025),
(18, 7, 1, 2025),
(20, 1, 13, 2025),
(24, 2, 16, 2025);

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id_location` int NOT NULL,
  `id_bailleur` int NOT NULL,
  `id_propriete` int NOT NULL,
  `id_client` int NOT NULL,
  `id_agent` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_location` date NOT NULL,
  PRIMARY KEY (`id_location`),
  KEY `id_propriete` (`id_propriete`),
  KEY `id_client` (`id_client`),
  KEY `id_agent` (`id_agent`),
  KEY `id_bailleur` (`id_bailleur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `locations`
--

INSERT INTO `locations` (`id_location`, `id_bailleur`, `id_propriete`, `id_client`, `id_agent`, `date_debut`, `date_fin`, `date_location`) VALUES
(1, 3, 1, 1, 3, '2025-06-10', '2025-06-30', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `id_manager` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_manager`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_bailleur` int NOT NULL,
  `date_message` date NOT NULL,
  `heur_message` time NOT NULL,
  `message_client` text CHARACTER SET utf8mb4  NOT NULL,
  `message_bailleur` text NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_client` (`id_client`),
  KEY `id_bailleur` (`id_bailleur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `id_client`, `id_bailleur`, `date_message`, `heur_message`, `message_client`, `message_bailleur`) VALUES
(1, 1, 2, '2025-06-12', '11:46:37', 'Bonjour', '');

-- --------------------------------------------------------

--
-- Structure de la table `messages_bailleur`
--

DROP TABLE IF EXISTS `messages_bailleur`;
CREATE TABLE IF NOT EXISTS `messages_bailleur` (
  `id_msg_bailleur` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_bailleur` int NOT NULL,
  `date_message_bailleur` date NOT NULL,
  `heur_message_bailleur` time NOT NULL,
  `message_bailleur` text NOT NULL,
  `id_msg_client` int NOT NULL,
  PRIMARY KEY (`id_msg_bailleur`),
  KEY `id_client` (`id_client`,`id_bailleur`),
  KEY `id_client_2` (`id_client`),
  KEY `id_msg_client` (`id_msg_client`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `messages_bailleur`
--

INSERT INTO `messages_bailleur` (`id_msg_bailleur`, `id_client`, `id_bailleur`, `date_message_bailleur`, `heur_message_bailleur`, `message_bailleur`, `id_msg_client`) VALUES
(1, 1, 3, '2025-06-12', '11:46:30', 'Comment aller vous', 0),
(2, 1, 3, '2025-06-12', '21:43:30', 'pareille que puis-je faire pour vous', 0),
(3, 1, 3, '2025-06-12', '21:43:30', '', 0),
(4, 1, 3, '2025-06-12', '23:39:41', '', 0),
(5, 1, 3, '2025-06-12', '23:45:42', '', 0),
(6, 1, 3, '2025-06-13', '00:37:16', 'ok ces un tst', 0),
(7, 1, 3, '2025-06-13', '00:38:11', 'merci', 0),
(8, 1, 3, '2025-06-13', '13:41:36', '', 0),
(9, 1, 3, '2025-06-13', '13:42:21', 'cest comment', 0),
(10, 1, 3, '2025-06-13', '16:28:15', 'bien merci', 0),
(11, 4, 3, '2025-06-14', '07:52:49', '', 0),
(12, 4, 3, '2025-06-14', '07:58:28', 'Salut', 0),
(13, 4, 3, '2025-06-14', '07:58:41', 'Rdv', 0),
(14, 2, 3, '2025-06-14', '10:03:20', '', 0),
(15, 1, 3, '2025-06-14', '11:49:57', 'd', 0),
(16, 1, 3, '2025-06-14', '11:50:07', 'maiga', 0),
(17, 4, 3, '2025-06-14', '11:50:58', 'wp', 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages_client`
--

DROP TABLE IF EXISTS `messages_client`;
CREATE TABLE IF NOT EXISTS `messages_client` (
  `id_msg_client` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_bailleur` int NOT NULL,
  `date_message_client` date NOT NULL,
  `heur_message_client` time NOT NULL,
  `message_client` text NOT NULL,
  `id_msg_bailleur` int NOT NULL,
  PRIMARY KEY (`id_msg_client`),
  KEY `id_client` (`id_client`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_msg_bailleur` (`id_msg_bailleur`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `messages_client`
--

INSERT INTO `messages_client` (`id_msg_client`, `id_client`, `id_bailleur`, `date_message_client`, `heur_message_client`, `message_client`, `id_msg_bailleur`) VALUES
(1, 1, 3, '2025-06-12', '11:43:30', 'Bonjour', 1),
(2, 1, 3, '2025-06-12', '21:42:30', 'Bien et chez vous?', 2),
(3, 1, 3, '2025-06-12', '22:34:07', 'ok', 0),
(4, 1, 3, '2025-06-12', '22:34:21', 'mais', 0),
(5, 1, 3, '2025-06-12', '22:43:31', 'salut', 0),
(6, 1, 3, '2025-06-12', '23:45:55', 'test', 0),
(7, 1, 3, '2025-06-12', '23:45:58', 'retest', 0),
(8, 1, 3, '2025-06-12', '23:46:01', 'ok', 0),
(9, 1, 3, '2025-06-13', '00:37:52', 'daccord pas de soucis', 0),
(10, 1, 3, '2025-06-13', '00:38:31', 'what?', 0),
(11, 1, 0, '2025-06-13', '13:41:40', 'ok', 0),
(12, 1, 0, '2025-06-13', '13:41:48', 'ok ces un tst', 0),
(13, 1, 3, '2025-06-13', '13:42:02', 'bjr', 0),
(14, 1, 3, '2025-06-13', '16:28:01', 'tres bien et chez vous?', 0),
(15, 2, 3, '2025-06-14', '10:03:33', 'yo', 0),
(16, 1, 3, '2025-06-14', '11:47:57', 'YO', 0);

-- --------------------------------------------------------

--
-- Structure de la table `moyen_paiement`
--

DROP TABLE IF EXISTS `moyen_paiement`;
CREATE TABLE IF NOT EXISTS `moyen_paiement` (
  `id_moyen_paiement` int NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id_moyen_paiement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `moyen_paiement`
--

INSERT INTO `moyen_paiement` (`id_moyen_paiement`, `Libelle`) VALUES
(1, 'espece'),
(2, 'paiement mobile'),
(3, 'cheque'),
(4, 'credit');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_agent` int NOT NULL,
  `id_propriete` int NOT NULL,
  `id_moyen_paiement` int NOT NULL,
  `id_bailleur` int NOT NULL,
  `montant` float NOT NULL,
  `date_paiement` date NOT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_client` (`id_client`),
  KEY `id_propriete` (`id_propriete`),
  KEY `id_type_paiement` (`id_moyen_paiement`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_moyen_paiement` (`id_moyen_paiement`),
  KEY `id_agent` (`id_agent`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id_paiement`, `id_client`, `id_agent`, `id_propriete`, `id_moyen_paiement`, `id_bailleur`, `montant`, `date_paiement`) VALUES
(9, 1, 2, 1, 1, 3, 2000000, '2025-06-13');

-- --------------------------------------------------------

--
-- Structure de la table `propriete`
--

DROP TABLE IF EXISTS `propriete`;
CREATE TABLE IF NOT EXISTS `propriete` (
  `id_propiete` int NOT NULL AUTO_INCREMENT,
  `id_type` int NOT NULL,
  `etat` varchar(255) CHARACTER SET utf8mb4  NOT NULL,
  `opt` varchar(255) CHARACTER SET utf8mb4  NOT NULL,
  `situation_geo` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `id_bailleur` int NOT NULL,
  `id_agent` int NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id_propiete`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_type` (`id_type`),
  KEY `id_agent` (`id_agent`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `propriete`
--

INSERT INTO `propriete` (`id_propiete`, `id_type`, `etat`, `opt`, `situation_geo`, `prix`, `image1`, `image2`, `image3`, `descriptions`, `id_bailleur`, `id_agent`, `date_ajout`) VALUES
(1, 1, 'vendu', 'Vente', 'Rue 34.01, Zone Résidentielle, Ouaga 2000, Ouagadougou, Burkina Faso', 139750000, 'img_682f3b20bbabf9.57215270.jpg', 'img_682f3b20bbc429.15579442.jpg', 'img_682f3b20bbd758.89170264.jpg', 'À vendre – Charmante maison mitoyenne 4 pièces – Quartier calme et recherché\n\nSituée dans un environnement paisible à proximité des écoles, commerces et transports, cette belle maison mitoyenne de 90 m² offre un cadre de vie idéal pour une famille.\n\nAu rez-de-chaussée, vous découvrirez une pièce de vie lumineuse avec salon et salle à manger ouverte sur une cuisine moderne équipée. À l’étage, trois chambres confortables, une salle de bains et des rangements bien pensés.\n\nVous profiterez également d’un jardin privatif sans vis-à-vis, parfait pour vos moments de détente, ainsi que d’un garage attenant.\n\n✅ Double vitrage\n✅ Chauffage central\n✅ Aucun travaux à prévoir', 3, 1, '2025-05-01'),
(13, 1, 'libre', 'location', 'SECTEUR 03, bobo', 290000, 'img_68345dfa2a9db7.58016120.jpg', 'img_68345dfa2b4b02.81050686.jpg', 'img_68345dfa2c2979.64371237.webp', 'un studio de 3 m2 /. n c', 3, 2, '2025-05-26'),
(11, 4, 'libre', 'location', 'ouaga', 23000, 'img_68330e660444c2.78964167.jpg', 'img_68330e6604e867.30638116.jpg', 'img_68330e66095c20.82209209.jpg', 'dddd', 3, 2, '2025-05-25'),
(16, 3, 'libre', 'Vente', 'newyork city,new jersey', 20000000000, 'img_68496e4a926dc3.84968399.jpg', 'img_68496e4a92bae3.31382663.jpg', 'img_68496e4a92de50.11246691.jpg', 'eej wenfwv wensdv  vn', 3, 2, '2025-06-11');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `id_rdv` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `id_propriete` int DEFAULT NULL,
  `id_bailleur` int NOT NULL,
  `date_rdv` date DEFAULT NULL,
  `heur_rdv` time NOT NULL,
  `id_statut` int DEFAULT NULL,
  `descriptions` text NOT NULL,
  PRIMARY KEY (`id_rdv`),
  KEY `id_client` (`id_client`),
  KEY `id_propriete` (`id_propriete`),
  KEY `id_statut` (`id_statut`),
  KEY `id_bailleur` (`id_bailleur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id_rdv`, `id_client`, `id_propriete`, `id_bailleur`, `date_rdv`, `heur_rdv`, `id_statut`, `descriptions`) VALUES
(1, 1, 16, 3, '2025-12-12', '09:00:00', 2, 'ok'),
(2, 1, 1, 2, '2025-09-23', '16:30:00', 1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `statut_rendezvous`
--

DROP TABLE IF EXISTS `statut_rendezvous`;
CREATE TABLE IF NOT EXISTS `statut_rendezvous` (
  `id_statut` int NOT NULL AUTO_INCREMENT,
  `statut` varchar(20) NOT NULL,
  PRIMARY KEY (`id_statut`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `statut_rendezvous`
--

INSERT INTO `statut_rendezvous` (`id_statut`, `statut`) VALUES
(1, 'En Attente'),
(2, 'Confirme'),
(4, 'reporter'),
(5, 'Annuler');

-- --------------------------------------------------------

--
-- Structure de la table `type_paiement`
--

DROP TABLE IF EXISTS `type_paiement`;
CREATE TABLE IF NOT EXISTS `type_paiement` (
  `id_type_paiement` int NOT NULL AUTO_INCREMENT,
  `id_moyen_paiement` int NOT NULL,
  PRIMARY KEY (`id_type_paiement`),
  KEY `id_moyen_paiement` (`id_moyen_paiement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Structure de la table `type_propriete`
--

DROP TABLE IF EXISTS `type_propriete`;
CREATE TABLE IF NOT EXISTS `type_propriete` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `type_propriete`
--

INSERT INTO `type_propriete` (`id_type`, `libelle`) VALUES
(1, 'Maison mitoyenne'),
(2, 'Appartement'),
(3, 'Villa'),
(4, 'Studio'),
(5, 'Duplex');

-- --------------------------------------------------------

--
-- Structure de la table `validezlocation`
--

DROP TABLE IF EXISTS `validezlocation`;
CREATE TABLE IF NOT EXISTS `validezlocation` (
  `id_validationLocation` int NOT NULL AUTO_INCREMENT,
  `libelle` enum('Valide','Annule','Attende') CHARACTER SET utf8mb4  NOT NULL,
  PRIMARY KEY (`id_validationLocation`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `validezlocation`
--

INSERT INTO `validezlocation` (`id_validationLocation`, `libelle`) VALUES
(1, 'Valide'),
(2, 'Annule'),
(3, 'Attende');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
