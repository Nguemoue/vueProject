-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 13 juil. 2021 à 12:12
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `light`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `grade` varchar(255) COLLATE utf8_bin NOT NULL,
  `descrition` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `grade`, `descrition`, `user_id`) VALUES
(1, 'Reverant', 'reverent apotre qui delivre des démons', 1);

-- --------------------------------------------------------

--
-- Structure de la table `dailybreads`
--

CREATE TABLE `dailybreads` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `create_at` datetime NOT NULL,
  `extension` varchar(20) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `dailybreads`
--

INSERT INTO `dailybreads` (`id`, `titre`, `path`, `create_at`, `extension`, `description`, `nom`, `id_post`) VALUES
(1, 'jde', 'hd2021_07_09_14_13_51', '0000-00-00 00:00:00', 'jpg', 'jjdejj', 'hd', 1),
(2, 'jde', 'hd2021_07_09_14_17_34', '2021-07-09 13:17:34', 'jpg', 'jjdejj', 'hd', 1);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `extension` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `create_at`, `path`, `extension`, `id_post`) VALUES
(1, '2021-07-09 16:39:11', 'connect_page.png2021_07_09_17_39_11', 'png', 1),
(2, '2021-07-09 16:39:38', 'connect_page.png2021_07_09_17_39_38', 'png', 1),
(3, '2021-07-09 16:40:55', 'connect_page.png2021_07_09_17_40_55', 'png', 1),
(4, '2021-07-09 16:43:16', 'connect_page.png2021_07_09_17_43_16', 'png', 1),
(5, '2021-07-09 16:44:09', 'connect_page.png2021_07_09_17_44_09', 'png', 1),
(6, '2021-07-09 16:44:31', 'connect_page.png2021_07_09_17_44_31', 'png', 1),
(7, '2021-07-09 16:45:33', 'connect_page.png2021_07_09_17_45_33', 'png', 1),
(8, '2021-07-09 16:46:54', 'connect_page.png2021_07_09_17_46_54', 'png', 1),
(9, '2021-07-09 20:48:26', 'Teatchin12021_07_09_21_48_26', 'jpg', 1),
(10, '2021-07-11 22:19:42', 'ujejbd2021_07_11_23_19_42', 'jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `contenu` text COLLATE utf8_bin DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `id_send` int(11) DEFAULT NULL,
  `id_receive` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `extension` varchar(10) COLLATE utf8_bin NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `nom`, `extension`, `create_at`, `update_at`, `id_user`) VALUES
(1, 'Nguemoue2021_07_09_13_36_28', 'png', '2021-07-09 12:34:49', '2021-07-09 12:36:28', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id` int(11) NOT NULL,
  `contenu` text COLLATE utf8_bin DEFAULT NULL,
  `response_at` datetime DEFAULT NULL,
  `id_message` int(11) DEFAULT NULL,
  `id_repondeur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `age` int(10) UNSIGNED NOT NULL,
  `tel` varchar(255) COLLATE utf8_bin NOT NULL,
  `sexe` char(5) COLLATE utf8_bin NOT NULL,
  `ville` varchar(255) COLLATE utf8_bin NOT NULL,
  `pays` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `activate_at` datetime NOT NULL,
  `token` char(4) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `age`, `tel`, `sexe`, `ville`, `pays`, `password`, `create_at`, `activate_at`, `token`, `active`) VALUES
(1, 'Nguemoue', 'nguemoueluc@gmail.com', 14, '69876777', 'Homme', 'Bafoussam', 'Cameroun', 'cephasa123', '2021-07-09 12:34:49', '2021-07-09 12:35:13', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `create_at` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `categorie` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `extension` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_img` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `videos`
--

INSERT INTO `videos` (`id`, `nom`, `titre`, `description`, `create_at`, `id_admin`, `categorie`, `path`, `extension`, `id_img`) VALUES
(1, 'Nom', 'titre', 'agrandissez votre fois chrtienne chque jour qui passe', '0000-00-00 00:00:00', 1, 'Teatching', 'Nom2021_07_09_17_45_33', 'mp4', 7),
(2, 'Nom', 'titre', 'agrandissez votre fois chrtienne chque jour qui passe', '2021-07-09 16:46:54', 1, 'Teatching', 'Nom2021_07_09_17_46_54', 'mp4', 8),
(3, 'Teatchin1', 'ta', 'hjbfhjhjfr n iahecae ojfe fe ', '2021-07-09 20:48:26', 1, 'Teatching', 'Teatchin12021_07_09_21_48_26', 'mp4', 9),
(4, 'ujejbd', 'ujdje', 'jdebdedoe diehde dieohld aedbede', '2021-07-11 22:19:42', 1, 'Encounter', 'ujejbd2021_07_11_23_19_42', 'mp4', 10);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_id` (`user_id`);

--
-- Index pour la table `dailybreads`
--
ALTER TABLE `dailybreads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_post` (`id_post`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_send` (`id_send`),
  ADD KEY `fk_id_receive` (`id_receive`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`id_user`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_repondeur` (`id_repondeur`),
  ADD KEY `fk_id_message` (`id_message`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_email` (`email`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_img` (`id_img`),
  ADD KEY `fk_id_admin` (`id_admin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `dailybreads`
--
ALTER TABLE `dailybreads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `fk_admin_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `dailybreads`
--
ALTER TABLE `dailybreads`
  ADD CONSTRAINT `fk_id_post` FOREIGN KEY (`id_post`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_id_receive` FOREIGN KEY (`id_receive`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_id_send` FOREIGN KEY (`id_send`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_id_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `fk_repondeur` FOREIGN KEY (`id_repondeur`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id`),
  ADD CONSTRAINT `fk_id_img` FOREIGN KEY (`id_img`) REFERENCES `image` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
