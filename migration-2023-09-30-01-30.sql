-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : sam. 30 sep. 2023 à 02:23
-- Version du serveur :  8.0.33
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `digital_api_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `log_users`
--

CREATE TABLE `log_users` (
                             `id` int NOT NULL,
                             `action_name` varchar(255) NOT NULL,
                             `action_code` varchar(255) NOT NULL,
                             `status` varchar(255) DEFAULT NULL,
                             `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                             `url` text,
                             `method` varchar(255) DEFAULT NULL,
                             `ips` text,
                             `user_agent` varchar(255) DEFAULT NULL,
                             `request_data` longtext,
                             `table_name` varchar(255) DEFAULT NULL,
                             `table_id` int DEFAULT NULL,
                             `user_admin_id` int DEFAULT NULL,
                             `user_admin_email` varchar(255) DEFAULT NULL,
                             `user_partner_id` int DEFAULT NULL,
                             `user_partner_role_name` varchar(255) DEFAULT NULL,
                             `user_partner_role_id` int DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                             `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parteners_actions`
--

CREATE TABLE `parteners_actions` (
                                     `id` int NOT NULL,
                                     `name` varchar(255) NOT NULL,
                                     `code` varchar(255) NOT NULL,
                                     `state` enum('ACTIVED','INACTIVED','DELETED') NOT NULL DEFAULT 'ACTIVED',
                                     `created_at` datetime NOT NULL,
                                     `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parteners_actions_roles`
--

CREATE TABLE `parteners_actions_roles` (
                                           `id` int NOT NULL,
                                           `state` enum('ACTIVED','INACTIVED','DELETED') NOT NULL DEFAULT 'ACTIVED',
                                           `parteners_roles_id` int NOT NULL,
                                           `parteners_actions_id` int NOT NULL,
                                           `parteners_id` int NOT NULL,
                                           `created_at` datetime NOT NULL,
                                           `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parteners_roles`
--

CREATE TABLE `parteners_roles` (
                                   `id` int NOT NULL,
                                   `name` varchar(255) NOT NULL,
                                   `code` varchar(255) NOT NULL,
                                   `parteners_id` int NOT NULL,
                                   `state` enum('ACTIVED','INACTIVED','DELETED') NOT NULL DEFAULT 'ACTIVED',
                                   `created_at` datetime NOT NULL,
                                   `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parteners_users`
--

CREATE TABLE `parteners_users` (
                                   `id` int NOT NULL,
                                   `created_at` datetime NOT NULL,
                                   `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                                   `state` enum('ACTIVED','INACTIVED','DELETED') NOT NULL DEFAULT 'ACTIVED',
                                   `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                                   `last_name` varchar(255) NOT NULL,
                                   `phone` varchar(255) NOT NULL,
                                   `email` varchar(255) NOT NULL,
                                   `parteners_id` int NOT NULL,
                                   `parteners_roles_id` int NOT NULL,
                                   `adress` longtext,
                                   `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                                   `first_connection` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Premier connexion , l’utilisateur doit changer son mot de passe',
                                   `password_expired` datetime DEFAULT NULL,
                                   `password_duration_day` int NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `log_users`
--
ALTER TABLE `log_users`
    ADD PRIMARY KEY (`id`),
  ADD KEY `table_name` (`table_name`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `user_admin_email` (`user_admin_email`),
  ADD KEY `user_partner_id` (`user_partner_id`),
  ADD KEY `user_partner_role_name` (`user_partner_role_name`),
  ADD KEY `user_partner_role_id` (`user_partner_role_id`),
  ADD KEY `action_name` (`action_name`),
  ADD KEY `action_code` (`action_code`);

--
-- Index pour la table `parteners_actions`
--
ALTER TABLE `parteners_actions`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD UNIQUE KEY `IDX_ced29c8015f38eaa5473c8b244` (`code`);

--
-- Index pour la table `parteners_actions_roles`
--
ALTER TABLE `parteners_actions_roles`
    ADD PRIMARY KEY (`id`),
  ADD KEY `parteners_roles_id` (`parteners_roles_id`),
  ADD KEY `parteners_actions_id` (`parteners_actions_id`),
  ADD KEY `parteners_id` (`parteners_id`);

--
-- Index pour la table `parteners_roles`
--
ALTER TABLE `parteners_roles`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`),
  ADD UNIQUE KEY `IDX_ced29c8015f38eaa5473c8b244` (`code`),
  ADD KEY `parteners_id` (`parteners_id`);

--
-- Index pour la table `parteners_users`
--
ALTER TABLE `parteners_users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_UNIQUE` (`phone`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `IDX_d0cef6e9693268015b0029cd1d` (`phone`),
  ADD UNIQUE KEY `IDX_0685affcb4991e9b37ff4eaf8c` (`email`),
  ADD KEY `parteners_id` (`parteners_id`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `parteners_roles_id` (`parteners_roles_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `log_users`
--
ALTER TABLE `log_users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners_actions`
--
ALTER TABLE `parteners_actions`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners_actions_roles`
--
ALTER TABLE `parteners_actions_roles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners_roles`
--
ALTER TABLE `parteners_roles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners_users`
--
ALTER TABLE `parteners_users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `parteners_actions_roles`
--
ALTER TABLE `parteners_actions_roles`
    ADD CONSTRAINT `parteners_actions_roles_ibfk_1` FOREIGN KEY (`parteners_actions_id`) REFERENCES `parteners_actions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `parteners_actions_roles_ibfk_2` FOREIGN KEY (`parteners_roles_id`) REFERENCES `parteners_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `parteners_actions_roles_ibfk_3` FOREIGN KEY (`parteners_id`) REFERENCES `parteners` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `parteners_roles`
--
ALTER TABLE `parteners_roles`
    ADD CONSTRAINT `parteners_roles_ibfk_1` FOREIGN KEY (`parteners_id`) REFERENCES `parteners` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `parteners_users`
--
ALTER TABLE `parteners_users`
    ADD CONSTRAINT `parteners_users_ibfk_1` FOREIGN KEY (`parteners_roles_id`) REFERENCES `parteners_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `parteners_users_ibfk_2` FOREIGN KEY (`parteners_id`) REFERENCES `parteners` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
