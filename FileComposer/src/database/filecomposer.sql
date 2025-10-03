-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 04 oct. 2025 à 00:11
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
-- Base de données : `filecomposer`
--

-- --------------------------------------------------------

--
-- Structure de la table `dir_linked`
--

CREATE TABLE `dir_linked` (
  `id` int(11) NOT NULL,
  `dir_name` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dir_linked`
--

INSERT INTO `dir_linked` (`id`, `dir_name`, `table_name`, `created_at`) VALUES
(16, 'img', 'users', '2025-10-02 22:50:46');

-- --------------------------------------------------------

--
-- Structure de la table `dir_linked_columns`
--

CREATE TABLE `dir_linked_columns` (
  `id` int(11) NOT NULL,
  `dir_linked_id` int(11) NOT NULL,
  `column_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dir_linked_columns`
--

INSERT INTO `dir_linked_columns` (`id`, `dir_linked_id`, `column_name`, `created_at`) VALUES
(16, 16, 'picture', '2025-10-02 22:50:46');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dir_linked`
--
ALTER TABLE `dir_linked`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dir_name` (`dir_name`,`table_name`),
  ADD UNIQUE KEY `dir_name_2` (`dir_name`),
  ADD KEY `idx_dir_name` (`dir_name`),
  ADD KEY `idx_table_name` (`table_name`);

--
-- Index pour la table `dir_linked_columns`
--
ALTER TABLE `dir_linked_columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dir_linked` (`dir_linked_id`),
  ADD KEY `idx_column_name` (`column_name`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dir_linked`
--
ALTER TABLE `dir_linked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `dir_linked_columns`
--
ALTER TABLE `dir_linked_columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dir_linked_columns`
--
ALTER TABLE `dir_linked_columns`
  ADD CONSTRAINT `fk_dir_linked` FOREIGN KEY (`dir_linked_id`) REFERENCES `dir_linked` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
