-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 18 juin 2025 à 19:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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

CREATE TABLE `achat` (
  `id_achat` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_achat` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id_achat`, `id_bailleur`, `id_propriete`, `id_client`, `id_agent`, `date_achat`) VALUES
(1, 3, 1, 1, 2, '2025-06-13'),
(2, 0, 16, 1, 0, '2025-06-13');

-- --------------------------------------------------------

--
-- Structure de la table `achet`
--

CREATE TABLE `achet` (
  `id_achat` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_achat` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `affectation`
--

CREATE TABLE `affectation` (
  `id_affectation` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_affectationn` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `id_agent` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `bailleur` (
  `id_bailleur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `raison_social` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `id_agent`, `nom`, `prenom`, `adresse`, `email`, `telephone`, `mot_de_passe`) VALUES
(1, 2, 'BA', 'Cheick Omar Yobi', 'SECTEIUR,58', 'Yobibah7295@gmail.com', '54806093', '$2y$10$ZiOpmW24KRAiosLTM/WP8.N8oZItWzsQHFnD9I0RBQm8vRB5fqI5K'),
(2, 1, 'PODA', 'STEVE', 'TANGHIN', 'stevepoda04@gmail.com', '09897867', '$2y$10$fCNme/s21OCKwxXH4LBKP.VCAhuIk7rRhS.ToikB9X71.TEP0nrCK'),
(3, 3, 'OUE', 'RACHIDA', '-', 'Oue1345@gmail.com', '123456789', '$2y$10$S6NCudYgi.JNYcXwCkluFu97oSSRlmjJiPw0a47GccbxQtZsD5Gle'),
(4, 4, 'Nacoulma', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', 'mnacoulmaezekiel@gmail.com', '+22662070058', '$2y$10$7pwErmPEn0FxpGptn9HOT.2YlClRc9mG0h8rzJEOnFsC7F.KTPawW'),
(5, 5, 'NACOULMA', 'Ezekiel', 'Rue 19.25', 'mnacoulmaezekiel@gmail.com', '+22607478318', '$2y$10$0Eckx8Hv5KJzGG7DxMwCkeN0Aju9MQcKzyLbYVTDSL4/3pBOT9766'),
(6, 6, 'NACOULMA', 'Ezekiel', 'Rue 19.25', 'mnacoulmaezekiel@gmail.com', '07478318', '$2y$10$G2e787ozNVBz/HEGtlK2tebvjPgJCNs12ownKovw2KtqRLBxjTwBO');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_favoris` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_propiete` int(11) NOT NULL,
  `date_ajout` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, 2, 16, 2025),
(25, 5, 13, 2025),
(26, 5, 16, 2025),
(27, 5, 18, 2025),
(28, 6, 16, 2025);

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id_location` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_location` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `locations`
--

INSERT INTO `locations` (`id_location`, `id_bailleur`, `id_propriete`, `id_client`, `id_agent`, `date_debut`, `date_fin`, `date_location`) VALUES
(1, 3, 1, 1, 3, '2025-06-10', '2025-06-30', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `manager`
--

CREATE TABLE `manager` (
  `id_manager` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `manager`
--

INSERT INTO `manager` (`id_manager`, `nom`, `prenom`, `email`, `password`) VALUES
(1, 'NACOULMA', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', '$2y$10$nnzBLcBQiEDnwM9TwtnOj.Lu9qacnOPfgf/QJYIZBOj/FCnjvR0GW'),
(2, 'Shadow', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', '$2y$10$Im2GhezktUejuf6N/Y3M9eT/Ty3Zew6nftPlUd/g5JsVrA5VMAZTa'),
(3, 'Shadow', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', '$2y$10$CNs.nphREsqIXbpZPBgiXuJEK.1FNozHpVHahmV8/uN.f6kbkQCsW'),
(4, 'Shadow', 'Ezekiel', 'mnacoulmaezekiel@gmail.com', '$2y$10$rC4uhO/NeYe0p6hF9ySXpeMpVRejyxk/la7yjLayH1DOwZXz3YNea');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `date_message` date NOT NULL,
  `heur_message` time NOT NULL,
  `message_client` text NOT NULL,
  `message_bailleur` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `id_client`, `id_bailleur`, `date_message`, `heur_message`, `message_client`, `message_bailleur`) VALUES
(1, 1, 2, '2025-06-12', '11:46:37', 'Bonjour', '');

-- --------------------------------------------------------

--
-- Structure de la table `messages_bailleur`
--

CREATE TABLE `messages_bailleur` (
  `id_msg_bailleur` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `date_message_bailleur` date NOT NULL,
  `heur_message_bailleur` time NOT NULL,
  `message_bailleur` text NOT NULL,
  `id_msg_client` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(17, 4, 3, '2025-06-14', '11:50:58', 'wp', 0),
(18, 5, 3, '2025-06-16', '10:39:04', '', 0),
(19, 5, 6, '2025-06-16', '20:44:56', '', 0),
(20, 5, 3, '2025-06-16', '20:45:35', '', 0),
(21, 6, 6, '2025-06-18', '11:10:36', '', 0),
(22, 6, 3, '2025-06-18', '17:11:03', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages_client`
--

CREATE TABLE `messages_client` (
  `id_msg_client` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `date_message_client` date NOT NULL,
  `heur_message_client` time NOT NULL,
  `message_client` text NOT NULL,
  `id_msg_bailleur` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(16, 1, 3, '2025-06-14', '11:47:57', 'YO', 0),
(17, 5, 3, '2025-06-16', '10:39:18', 'salut', 0),
(18, 5, 3, '2025-06-16', '10:39:30', 'dernier prix', 0),
(19, 5, 0, '2025-06-16', '20:45:09', 'salut', 0),
(20, 5, 0, '2025-06-16', '20:45:15', 'salut', 0),
(21, 5, 6, '2025-06-16', '20:45:21', 'salut', 0),
(22, 5, 6, '2025-06-16', '20:45:25', 'dernier prix', 0),
(23, 5, 6, '2025-06-16', '20:45:50', 'salut', 0),
(24, 6, 0, '2025-06-18', '11:10:46', 'interessant', 0),
(25, 6, 0, '2025-06-18', '11:10:53', 'interessant', 0),
(26, 6, 0, '2025-06-18', '11:10:58', 'interessant', 0),
(27, 6, 6, '2025-06-18', '11:11:13', 'interessant', 0),
(28, 6, 6, '2025-06-18', '11:11:19', 'dernier prix\\', 0);

-- --------------------------------------------------------

--
-- Structure de la table `moyen_paiement`
--

CREATE TABLE `moyen_paiement` (
  `id_moyen_paiement` int(11) NOT NULL,
  `Libelle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `paiement` (
  `id_paiement` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  `id_moyen_paiement` int(11) NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `montant` float NOT NULL,
  `date_paiement` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id_paiement`, `id_client`, `id_agent`, `id_propriete`, `id_moyen_paiement`, `id_bailleur`, `montant`, `date_paiement`) VALUES
(9, 1, 2, 1, 1, 3, 2000000, '2025-06-13');

-- --------------------------------------------------------

--
-- Structure de la table `propriete`
--

CREATE TABLE `propriete` (
  `id_propiete` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `opt` varchar(255) NOT NULL,
  `situation_geo` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `id_bailleur` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date_ajout` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `propriete`
--

INSERT INTO `propriete` (`id_propiete`, `id_type`, `etat`, `opt`, `situation_geo`, `prix`, `image1`, `image2`, `image3`, `descriptions`, `id_bailleur`, `id_agent`, `date_ajout`) VALUES
(1, 1, 'vendu', 'Vente', 'Rue 34.01, Zone Résidentielle, Ouaga 2000, Ouagadougou, Burkina Faso', 139750000, 'img_682f3b20bbabf9.57215270.jpg', 'img_682f3b20bbc429.15579442.jpg', 'img_682f3b20bbd758.89170264.jpg', 'À vendre – Charmante maison mitoyenne 4 pièces – Quartier calme et recherché\n\nSituée dans un environnement paisible à proximité des écoles, commerces et transports, cette belle maison mitoyenne de 90 m² offre un cadre de vie idéal pour une famille.\n\nAu rez-de-chaussée, vous découvrirez une pièce de vie lumineuse avec salon et salle à manger ouverte sur une cuisine moderne équipée. À l’étage, trois chambres confortables, une salle de bains et des rangements bien pensés.\n\nVous profiterez également d’un jardin privatif sans vis-à-vis, parfait pour vos moments de détente, ainsi que d’un garage attenant.\n\n✅ Double vitrage\n✅ Chauffage central\n✅ Aucun travaux à prévoir', 3, 1, '2025-05-01'),
(13, 1, 'libre', 'location', 'SECTEUR 03, bobo', 290000, 'img_68345dfa2a9db7.58016120.jpg', 'img_68345dfa2b4b02.81050686.jpg', 'img_68345dfa2c2979.64371237.webp', 'un studio de 3 m2 /. n c', 3, 2, '2025-05-26'),
(11, 4, 'libre', 'location', 'ouaga', 23000, 'img_68330e660444c2.78964167.jpg', 'img_68330e6604e867.30638116.jpg', 'img_68330e66095c20.82209209.jpg', 'dddd', 3, 2, '2025-05-25'),
(16, 3, 'libre', 'Vente', 'newyork city,new jersey', 20000000000, 'img_68496e4a926dc3.84968399.jpg', 'img_68496e4a92bae3.31382663.jpg', 'img_68496e4a92de50.11246691.jpg', 'eej wenfwv wensdv  vn', 3, 2, '2025-06-11'),
(18, 4, 'libre', 'vente', 'Rue 19.25', 25, 'img_684fc6d72ffbf3.54709237.jpg', 'img_684fc6d7303788.92010329.jpg', 'img_684fc6d7306613.29861535.jpg', 'eze', 6, 2, '2025-06-16'),
(19, 2, 'libre', 'vente', 'Rue 19.25', 25345, 'img_6852f81c5d6a59.67027829.jpg', 'img_6852f81c5dc645.47771900.jpg', 'img_6852f81c5df987.96422256.jpg', 'it2', 6, 2, '2025-06-18');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id_rdv` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_propriete` int(11) DEFAULT NULL,
  `id_bailleur` int(11) NOT NULL,
  `date_rdv` date DEFAULT NULL,
  `heur_rdv` time NOT NULL,
  `id_statut` int(11) DEFAULT NULL,
  `descriptions` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `statut_rendezvous` (
  `id_statut` int(11) NOT NULL,
  `statut` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `type_paiement` (
  `id_type_paiement` int(11) NOT NULL,
  `id_moyen_paiement` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_propriete`
--

CREATE TABLE `type_propriete` (
  `id_type` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `validezlocation` (
  `id_validationLocation` int(11) NOT NULL,
  `libelle` enum('Valide','Annule','Attende') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `validezlocation`
--

INSERT INTO `validezlocation` (`id_validationLocation`, `libelle`) VALUES
(1, 'Valide'),
(2, 'Annule'),
(3, 'Attende');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id_achat`),
  ADD UNIQUE KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_agent` (`id_agent`),
  ADD KEY `id_bailleur` (`id_bailleur`);

--
-- Index pour la table `achet`
--
ALTER TABLE `achet`
  ADD PRIMARY KEY (`id_achat`),
  ADD UNIQUE KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `affectation`
--
ALTER TABLE `affectation`
  ADD PRIMARY KEY (`id_affectation`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id_agent`);

--
-- Index pour la table `bailleur`
--
ALTER TABLE `bailleur`
  ADD PRIMARY KEY (`id_bailleur`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id_favoris`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_propiete` (`id_propiete`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id_location`),
  ADD KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_agent` (`id_agent`),
  ADD KEY `id_bailleur` (`id_bailleur`);

--
-- Index pour la table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id_manager`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_bailleur` (`id_bailleur`);

--
-- Index pour la table `messages_bailleur`
--
ALTER TABLE `messages_bailleur`
  ADD PRIMARY KEY (`id_msg_bailleur`),
  ADD KEY `id_client` (`id_client`,`id_bailleur`),
  ADD KEY `id_client_2` (`id_client`),
  ADD KEY `id_msg_client` (`id_msg_client`);

--
-- Index pour la table `messages_client`
--
ALTER TABLE `messages_client`
  ADD PRIMARY KEY (`id_msg_client`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_bailleur` (`id_bailleur`),
  ADD KEY `id_msg_bailleur` (`id_msg_bailleur`);

--
-- Index pour la table `moyen_paiement`
--
ALTER TABLE `moyen_paiement`
  ADD PRIMARY KEY (`id_moyen_paiement`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_type_paiement` (`id_moyen_paiement`),
  ADD KEY `id_bailleur` (`id_bailleur`),
  ADD KEY `id_moyen_paiement` (`id_moyen_paiement`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `propriete`
--
ALTER TABLE `propriete`
  ADD PRIMARY KEY (`id_propiete`),
  ADD KEY `id_bailleur` (`id_bailleur`),
  ADD KEY `id_type` (`id_type`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`id_rdv`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_propriete` (`id_propriete`),
  ADD KEY `id_statut` (`id_statut`),
  ADD KEY `id_bailleur` (`id_bailleur`);

--
-- Index pour la table `statut_rendezvous`
--
ALTER TABLE `statut_rendezvous`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `type_paiement`
--
ALTER TABLE `type_paiement`
  ADD PRIMARY KEY (`id_type_paiement`),
  ADD KEY `id_moyen_paiement` (`id_moyen_paiement`);

--
-- Index pour la table `type_propriete`
--
ALTER TABLE `type_propriete`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `validezlocation`
--
ALTER TABLE `validezlocation`
  ADD PRIMARY KEY (`id_validationLocation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id_achat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `achet`
--
ALTER TABLE `achet`
  MODIFY `id_achat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `affectation`
--
ALTER TABLE `affectation`
  MODIFY `id_affectation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `id_agent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `bailleur`
--
ALTER TABLE `bailleur`
  MODIFY `id_bailleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id_favoris` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `manager`
--
ALTER TABLE `manager`
  MODIFY `id_manager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `messages_bailleur`
--
ALTER TABLE `messages_bailleur`
  MODIFY `id_msg_bailleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `messages_client`
--
ALTER TABLE `messages_client`
  MODIFY `id_msg_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `moyen_paiement`
--
ALTER TABLE `moyen_paiement`
  MODIFY `id_moyen_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `propriete`
--
ALTER TABLE `propriete`
  MODIFY `id_propiete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id_rdv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `statut_rendezvous`
--
ALTER TABLE `statut_rendezvous`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `type_paiement`
--
ALTER TABLE `type_paiement`
  MODIFY `id_type_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_propriete`
--
ALTER TABLE `type_propriete`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `validezlocation`
--
ALTER TABLE `validezlocation`
  MODIFY `id_validationLocation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
