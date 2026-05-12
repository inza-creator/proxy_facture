-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 12 mai 2026 à 09:25
-- Version du serveur : 9.1.0
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `proxy_facture_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `bon_commandes`
--

DROP TABLE IF EXISTS `bon_commandes`;
CREATE TABLE IF NOT EXISTS `bon_commandes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `demande_id` bigint UNSIGNED NOT NULL,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_reception` date NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reçu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bon_commandes_demande_id_foreign` (`demande_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bon_commandes`
--

INSERT INTO `bon_commandes` (`id`, `demande_id`, `client`, `fichier`, `date_reception`, `statut`, `created_at`, `updated_at`) VALUES
(1, 1, 'STANDARD CHARTERED BANK', '1772441778.pdf', '2026-03-02', 'reçu', '2026-03-02 08:56:18', '2026-03-02 08:56:18'),
(2, 2, 'BRIDGE BANK CI', '1772529363.jpg', '2026-03-03', 'reçu', '2026-03-03 09:16:03', '2026-03-03 09:16:03'),
(3, 4, 'ACCESS BANK CI', '1774871104.jpg', '2026-03-30', 'annulé', '2026-03-30 11:45:04', '2026-03-30 11:46:47'),
(4, 5, 'BGFI-CENTRAFRIQUE', '1775821575.jpg', '2026-04-10', 'reçu', '2026-04-10 11:46:15', '2026-04-10 11:46:15');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

DROP TABLE IF EXISTS `contrats`;
CREATE TABLE IF NOT EXISTS `contrats` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `projet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_signature` date NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contrats`
--

INSERT INTO `contrats` (`id`, `client`, `projet`, `date_signature`, `document`, `avenant`, `created_at`, `updated_at`) VALUES
(1, 'STANDARD CHARTERED BANK', 'Module Clearing', '2026-03-02', '1772457593.png', 'test', '2026-03-02 13:19:53', '2026-03-02 13:19:53'),
(2, 'ACCESS BANK CI', 'Test', '2026-04-01', '1774873915.jpg', 'test', '2026-03-30 12:31:55', '2026-03-30 12:31:55');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

DROP TABLE IF EXISTS `demandes`;
CREATE TABLE IF NOT EXISTS `demandes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_demande` date NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id`, `client`, `email`, `contact`, `objet`, `description`, `date_demande`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'STANDARD CHARTERED BANK', NULL, NULL, 'Module Clearing', 'test', '2026-03-02', 'acceptée', '2026-03-02 08:49:51', '2026-03-02 08:49:51'),
(2, 'BRIDGE BANK CI', NULL, NULL, 'Solution Eclearing', 'Nous avons besoin de votre solution clearing', '2026-03-03', 'en cours d\'analyse', '2026-03-03 09:15:17', '2026-03-05 14:58:06'),
(3, 'ECOBANK CI', 'ecobankci@gmail.com', '+225 0908090565', 'test', 'test', '2026-03-05', 'en attente', '2026-03-05 14:57:51', '2026-03-05 14:57:51'),
(4, 'ACCESS BANK CI', 'accessbank@ci.net', '+225 0907080390', 'TEST', 'TEST', '2026-03-31', 'acceptée', '2026-03-30 11:44:41', '2026-03-30 11:46:20'),
(5, 'BGFI-CENTRAFRIQUE', 'bgfi@centrafrique.com', '+224 040500679', 'TEST', 'Besoin de :\r\nCRISK\r\nSCAN WEB\r\nDOMIEX \r\nRTGS RETOUR', '2026-04-10', 'en attente', '2026-04-10 11:45:09', '2026-04-10 11:45:09');

-- --------------------------------------------------------

--
-- Structure de la table `domaines`
--

DROP TABLE IF EXISTS `domaines`;
CREATE TABLE IF NOT EXISTS `domaines` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `domaines`
--

INSERT INTO `domaines` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'Bancaire', '2026-03-11 09:17:30', '2026-03-11 09:17:30');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bon_commande_id` bigint UNSIGNED NOT NULL,
  `numero_facture` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `tva` decimal(10,2) DEFAULT NULL,
  `type_facture` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_facture` date NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'impayée',
  `condition_paiement` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `factures_bon_commande_id_foreign` (`bon_commande_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `bon_commande_id`, `numero_facture`, `client`, `objet`, `montant`, `tva`, `type_facture`, `date_facture`, `statut`, `condition_paiement`, `created_at`, `updated_at`) VALUES
(1, 1, 'FAC-20260302-613', 'STANDARD CHARTERD BANK', 'Module Clearing', 2000000.00, 3.00, 'proforma', '2026-03-02', 'envoyé', NULL, '2026-03-02 09:02:58', '2026-03-30 12:11:27'),
(2, 2, 'FAC-20260303-709', 'BRIDGE BANK CI', 'Solution Eclearing', 3000000.00, 1.00, 'proforma', '2026-03-03', 'impayée', NULL, '2026-03-03 09:16:58', '2026-03-03 09:16:58'),
(3, 2, 'FAC-20260305-630', 'ECOBANK CI', 'test', 4000000.00, NULL, 'definitive', '2026-03-05', 'impayée', '40 % à la demande 60 % à la livraison', '2026-03-05 15:17:52', '2026-03-05 15:17:52'),
(4, 3, 'FAC-20260330-550', 'ACCESS BANK CI', 'test', 13000000.00, NULL, 'definitive', '2026-03-30', 'payée', '50 % à la commande 50 % à la livraison', '2026-03-30 11:45:44', '2026-03-30 11:47:43'),
(5, 2, 'FAC-20260410-361', 'BRIDGE BANK CI', 'Eclearing ; Scan Web', 8000000.00, NULL, 'proforma', '2026-04-10', 'non envoyé', '50 % à la commande 50 % à la livraison', '2026-04-10 11:08:59', '2026-04-10 11:08:59'),
(6, 4, 'FAC-20260410-633', 'BGFI-CENTRAFRIQUE', 'CRISK ; DOMIEX ; SCAN WEB ; RTGS RETOUR', 15000000.00, NULL, 'definitive', '2026-04-10', 'payée', '40 % à la demande 60 % à la livraison', '2026-04-10 11:47:58', '2026-04-10 11:48:34');

-- --------------------------------------------------------

--
-- Structure de la table `facture_lignes`
--

DROP TABLE IF EXISTS `facture_lignes`;
CREATE TABLE IF NOT EXISTS `facture_lignes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `facture_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` decimal(12,2) NOT NULL,
  `prix_unitaire` decimal(15,2) NOT NULL,
  `montant_ht` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `facture_lignes_facture_id_foreign` (`facture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture_lignes`
--

INSERT INTO `facture_lignes` (`id`, `facture_id`, `description`, `quantite`, `prix_unitaire`, `montant_ht`, `created_at`, `updated_at`) VALUES
(1, 1, 'Module Clearing', 1.00, 2000000.00, 2000000.00, '2026-04-10 11:05:32', '2026-04-10 11:05:32'),
(2, 2, 'Solution Eclearing', 1.00, 3000000.00, 3000000.00, '2026-04-10 11:05:32', '2026-04-10 11:05:32'),
(3, 3, 'test', 1.00, 4000000.00, 4000000.00, '2026-04-10 11:05:32', '2026-04-10 11:05:32'),
(4, 4, 'test', 1.00, 13000000.00, 13000000.00, '2026-04-10 11:05:32', '2026-04-10 11:05:32'),
(5, 5, 'Eclearing', 1.00, 5000000.00, 5000000.00, '2026-04-10 11:08:59', '2026-04-10 11:08:59'),
(6, 5, 'Scan Web', 1.00, 3000000.00, 3000000.00, '2026-04-10 11:08:59', '2026-04-10 11:08:59'),
(7, 6, 'CRISK', 1.00, 3000000.00, 3000000.00, '2026-04-10 11:47:58', '2026-04-10 11:47:58'),
(8, 6, 'DOMIEX', 1.00, 2000000.00, 2000000.00, '2026-04-10 11:47:58', '2026-04-10 11:47:58'),
(9, 6, 'SCAN WEB', 1.00, 3000000.00, 3000000.00, '2026-04-10 11:47:58', '2026-04-10 11:47:58'),
(10, 6, 'RTGS RETOUR', 1.00, 7000000.00, 7000000.00, '2026-04-10 11:47:58', '2026-04-10 11:47:58');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_02_084118_create_demandes_table', 2),
(5, '2026_03_02_085137_create_bon_commandes_table', 3),
(6, '2026_03_02_085743_create_factures_table', 4),
(7, '2026_03_02_131448_create_contrats_table', 5),
(8, '2026_03_03_085853_create_parametres_table', 6),
(9, '2026_03_03_092436_create_relances_table', 7),
(10, '2026_03_05_145442_add_email_and_contact_to_demandes_table', 8),
(11, '2026_03_05_150533_add_statut_to_bon_commandes_table', 9),
(12, '2026_03_05_151440_add_condition_paiement_to_factures_table', 10),
(13, '2026_03_05_155148_create_notifications_table', 11),
(14, '2026_03_05_155217_replace_niveau_by_motif_in_relances_table', 11),
(15, '2026_03_05_160357_add_statut_to_relances_table', 12),
(16, '2026_03_10_100000_create_services_table', 13),
(17, '2026_03_10_100001_create_domaines_table', 13),
(18, '2026_04_10_000001_create_facture_lignes_and_migrate_factures', 14);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('6c81b6e6-6557-4879-96b0-aa1dcf50dfb8', 'App\\Notifications\\RelanceReminderNotification', 'App\\Models\\User', 1, '{\"type\":\"relance_reminder\",\"relance_id\":2,\"date_relance\":\"2026-03-05\",\"motif_relance\":\"Rappel \\u00e9ch\\u00e9ance\",\"commentaire\":\"Paiement de licence pour RTGS\",\"facture_numero\":\"FAC-20260305-630\",\"facture_client\":\"ECOBANK CI\",\"message\":\"Rappel : Rappel \\u00e9ch\\u00e9ance \\u2013 FAC-20260305-630 (ECOBANK CI)\"}', '2026-03-05 15:57:47', '2026-03-05 15:57:33', '2026-03-05 15:57:47'),
('690b000c-0871-4099-9707-80d09a44d09d', 'App\\Notifications\\RelanceReminderNotification', 'App\\Models\\User', 1, '{\"type\":\"relance_reminder\",\"relance_id\":3,\"date_relance\":\"2026-03-06\",\"motif_relance\":\"Rappel \\u00e9ch\\u00e9ance\",\"commentaire\":\"Test\",\"facture_numero\":\"FAC-20260303-709\",\"facture_client\":\"BRIDGE BANK CI\",\"message\":\"Rappel : Rappel \\u00e9ch\\u00e9ance \\u2013 FAC-20260303-709 (BRIDGE BANK CI)\"}', '2026-03-10 10:13:54', '2026-03-05 16:09:15', '2026-03-10 10:13:54'),
('da11bdac-42e6-4e5d-b54a-6ed42ec4d06a', 'App\\Notifications\\RelanceReminderNotification', 'App\\Models\\User', 1, '{\"type\":\"relance_reminder\",\"relance_id\":4,\"date_relance\":\"2026-03-30\",\"motif_relance\":\"TEST\",\"commentaire\":\"TEST\",\"facture_numero\":\"FAC-20260330-550\",\"facture_client\":\"ACCESS BANK CI\",\"message\":\"Rappel : TEST \\u2013 FAC-20260330-550 (ACCESS BANK CI)\"}', '2026-03-30 11:47:07', '2026-03-30 11:46:04', '2026-03-30 11:47:07'),
('f64ccf4d-f8bf-4ffd-8c9f-8a0d90725292', 'App\\Notifications\\RelanceReminderNotification', 'App\\Models\\User', 4, '{\"type\":\"relance_reminder\",\"relance_id\":5,\"date_relance\":\"2026-04-10\",\"motif_relance\":\"Lic App\",\"commentaire\":\"TEST\",\"facture_numero\":\"FAC-20260410-633\",\"facture_client\":\"BGFI-CENTRAFRIQUE\",\"message\":\"Rappel : Lic App \\u2013 FAC-20260410-633 (BGFI-CENTRAFRIQUE)\"}', '2026-04-10 11:49:19', '2026-04-10 11:48:59', '2026-04-10 11:49:19');

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

DROP TABLE IF EXISTS `parametres`;
CREATE TABLE IF NOT EXISTS `parametres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conditions_paiement` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parametres`
--

INSERT INTO `parametres` (`id`, `nom_entreprise`, `logo`, `adresse`, `telephone`, `email`, `conditions_paiement`, `created_at`, `updated_at`) VALUES
(1, 'Proxyma-technologies', 'logos/kwUINvkcVuaBS9omNYDzDoPA42gKqJ2F0PXCDHP0.png', 'Cocody, 7e tranche', '+225 0101222324', 'proxyma-technologies@gmail.net', '50% à la commande \r\n50% à la livraison', '2026-03-03 09:05:03', '2026-03-03 09:05:03');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `relances`
--

DROP TABLE IF EXISTS `relances`;
CREATE TABLE IF NOT EXISTS `relances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `facture_id` bigint UNSIGNED NOT NULL,
  `date_relance` date NOT NULL,
  `motif_relance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Non lu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relances_facture_id_foreign` (`facture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `relances`
--

INSERT INTO `relances` (`id`, `facture_id`, `date_relance`, `motif_relance`, `commentaire`, `statut`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-03-01', 'Relance 2', 'paiement de licence', 'Non lu', '2026-03-03 09:49:08', '2026-03-03 09:49:08'),
(2, 3, '2026-03-05', 'Rappel échéance', 'Paiement de licence pour RTGS', 'Lu', '2026-03-05 15:57:33', '2026-03-05 16:06:17'),
(3, 2, '2026-03-06', 'Rappel échéance', 'Test', 'Non lu', '2026-03-05 16:09:15', '2026-03-05 16:09:15'),
(4, 4, '2026-03-30', 'TEST', 'TEST', 'Lu', '2026-03-30 11:46:04', '2026-03-30 11:47:20'),
(5, 6, '2026-04-10', 'Lic App', 'TEST', 'Lu', '2026-04-10 11:48:59', '2026-04-10 11:49:05');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `libelle`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Astra_RTGS', 'test', '2026-03-11 09:17:07', '2026-03-11 09:17:07');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('r4pi2bIOl1HlYS373TUXSfaJjTxnJgTwIQ7FN1HC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1NvSXhBQ0xDUjU3VnBxMDdxS0RjSmE0bXZua1p1T3dSSkZXRXdWUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3Jnb3QtcGFzc3dvcmQiO3M6NToicm91dGUiO3M6MTY6InBhc3N3b3JkLnJlcXVlc3QiO319', 1773137568),
('DDjRWKdKEooamS3e1Tp7vpx1kpfmsfIzPZE5RQEn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYVhBaWdPOWlhU2Nwamp3MHdwNU01Ujk4dzRMTVNNblVISEx5QzJBUyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ZhY3R1cmVzL3BkZi8xIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1772737514);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$egGefJ3/sy0HkA6ifxcD4.d0ktMGvRLJysDXG3/PwHUp.m5x4l2xq', 'TlhqCiMSREbpsU4B4nKGrF8RR9u3yab8Y9n9JUjBgC9aSaFq6V6pKK2iO490', '2026-03-02 08:21:29', '2026-03-02 08:21:29'),
(2, 'Test User', 'test@example.com', '2026-03-10 10:11:03', '$2y$12$Qnl6PL9Ugj8TrR.LQS/vJ.jGkiTxF6tgXOHXB4dXwTOZBU/x.9yDS', '6UklHSPDp4', '2026-03-10 10:11:04', '2026-03-10 10:11:04'),
(3, 'inza', 'inza@gmail.com', NULL, '$2y$12$NzEDRrQQWtq9EkrZojCl0.MCDwyQG7cKtEgcuZ78LevUH2UdJpOsy', NULL, '2026-03-17 09:12:49', '2026-03-17 09:12:49'),
(4, 'INZA SORO', 'soroinza1234@gmail.com', NULL, '$2y$12$gtZFN//YnkoSDi95QgQ8SuIVvYMXmlRPvlWNdBLtlGRewawsHtU3W', NULL, '2026-04-10 11:41:37', '2026-04-10 11:41:37');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
