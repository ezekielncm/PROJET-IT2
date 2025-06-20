-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 juin 2025 à 14:49
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

-- --------------------------------------------------------

--
-- Structure de la table `moyen_paiement`
--

CREATE TABLE `moyen_paiement` (
  `id_moyen_paiement` int(11) NOT NULL,
  `Libelle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `statut_rendezvous`
--

CREATE TABLE `statut_rendezvous` (
  `id_statut` int(11) NOT NULL,
  `statut` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `validezlocation`
--

CREATE TABLE `validezlocation` (
  `id_validationLocation` int(11) NOT NULL,
  `libelle` enum('Valide','Annule','Attende') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id_achat` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_agent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bailleur`
--
ALTER TABLE `bailleur`
  MODIFY `id_bailleur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id_favoris` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `manager`
--
ALTER TABLE `manager`
  MODIFY `id_manager` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_bailleur`
--
ALTER TABLE `messages_bailleur`
  MODIFY `id_msg_bailleur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_client`
--
ALTER TABLE `messages_client`
  MODIFY `id_msg_client` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `moyen_paiement`
--
ALTER TABLE `moyen_paiement`
  MODIFY `id_moyen_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `propriete`
--
ALTER TABLE `propriete`
  MODIFY `id_propiete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id_rdv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statut_rendezvous`
--
ALTER TABLE `statut_rendezvous`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_paiement`
--
ALTER TABLE `type_paiement`
  MODIFY `id_type_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_propriete`
--
ALTER TABLE `type_propriete`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `validezlocation`
--
ALTER TABLE `validezlocation`
  MODIFY `id_validationLocation` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
