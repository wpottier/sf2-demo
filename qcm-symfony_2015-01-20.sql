# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Hôte: 127.0.0.1 (MySQL 5.6.22)
# Base de données: qcm-symfony
# Temps de génération: 2015-01-20 09:31:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table participations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `participations`;

CREATE TABLE `participations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `qcm_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `participation_started_at` datetime DEFAULT NULL,
  `participation_ended_at` datetime DEFAULT NULL,
  `participation_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FDC6C6E828222D87` (`participation_key`),
  KEY `IDX_FDC6C6E8A76ED395` (`user_id`),
  KEY `IDX_FDC6C6E8FF6241A6` (`qcm_id`),
  CONSTRAINT `FK_FDC6C6E8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FDC6C6E8FF6241A6` FOREIGN KEY (`qcm_id`) REFERENCES `qcms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `participations` WRITE;
/*!40000 ALTER TABLE `participations` DISABLE KEYS */;

INSERT INTO `participations` (`id`, `user_id`, `qcm_id`, `created_at`, `updated_at`, `participation_started_at`, `participation_ended_at`, `participation_key`)
VALUES
	(1,1,1,'2015-01-19 23:16:06','2015-01-19 23:16:06',NULL,NULL,'b9f898bc54c02ffde521d9b5b7acf71022262f14');

/*!40000 ALTER TABLE `participations` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table qcms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qcms`;

CREATE TABLE `qcms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `qcms` WRITE;
/*!40000 ALTER TABLE `qcms` DISABLE KEYS */;

INSERT INTO `qcms` (`id`, `title`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'Test Symfony2','Test sur Symfony2','2015-01-19 23:10:15','2015-01-19 23:10:15');

/*!40000 ALTER TABLE `qcms` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table qcms_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qcms_questions`;

CREATE TABLE `qcms_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qcm_id` int(11) NOT NULL,
  `sentence` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `explanation` longtext COLLATE utf8_unicode_ci,
  `position` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E01559CEFF6241A6` (`qcm_id`),
  CONSTRAINT `FK_E01559CEFF6241A6` FOREIGN KEY (`qcm_id`) REFERENCES `qcms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `qcms_questions` WRITE;
/*!40000 ALTER TABLE `qcms_questions` DISABLE KEYS */;

INSERT INTO `qcms_questions` (`id`, `qcm_id`, `sentence`, `explanation`, `position`, `created_at`, `updated_at`)
VALUES
	(1,1,'Quelle est la commande permettant d\'administrer une application Symfony2 en ligne de commande ?',NULL,0,'2015-01-19 23:31:18','2015-01-19 23:31:18'),
	(2,1,'Composer est:',NULL,1,'2015-01-19 23:32:46','2015-01-19 23:32:46'),
	(3,1,'A quoi sert l\'objet Response ?',NULL,2,'2015-01-19 23:33:00','2015-01-19 23:33:00'),
	(4,1,'Comment effectuer le rendu d\'un formulaire ?',NULL,3,'2015-01-19 23:33:41','2015-01-19 23:33:41'),
	(5,1,'Sur quel design pattern est conçu Symfony2 ?',NULL,4,'2015-01-19 23:34:03','2015-01-19 23:34:03');

/*!40000 ALTER TABLE `qcms_questions` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table qcms_questions_answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qcms_questions_answers`;

CREATE TABLE `qcms_questions_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_86368AED1E27F6BF` (`question_id`),
  CONSTRAINT `FK_86368AED1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `qcms_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `qcms_questions_answers` WRITE;
/*!40000 ALTER TABLE `qcms_questions_answers` DISABLE KEYS */;

INSERT INTO `qcms_questions_answers` (`id`, `question_id`, `answer`, `position`, `is_correct`, `created_at`, `updated_at`)
VALUES
	(1,1,'./symfony2',0,0,'2015-01-19 23:31:48','2015-01-19 23:31:48'),
	(2,1,'./symfony',1,0,'2015-01-19 23:31:48','2015-01-19 23:31:48'),
	(3,1,'./drush',2,0,'2015-01-19 23:31:48','2015-01-19 23:31:48'),
	(4,1,'php app/console',3,1,'2015-01-19 23:31:48','2015-01-19 23:31:48'),
	(5,2,'Un IDE',0,0,'2015-01-19 23:34:28','2015-01-19 23:34:28'),
	(6,2,'Un outil d\'envoi d\'email',1,0,'2015-01-19 23:34:28','2015-01-19 23:34:28'),
	(7,2,'Une bibliothèque de gestion de dépendances pour PHP',2,1,'2015-01-19 23:34:28','2015-01-19 23:34:28'),
	(8,2,'Un bundle Symfony2',3,0,'2015-01-19 23:34:28','2015-01-19 23:34:28'),
	(9,3,'A envoyer des messages d\'erreur',0,0,'2015-01-19 23:35:35','2015-01-19 23:35:35'),
	(10,3,'Représente la réponse dans son ensemble',1,1,'2015-01-19 23:35:35','2015-01-19 23:35:35'),
	(11,3,'A générer des templates',2,0,'2015-01-19 23:35:35','2015-01-19 23:35:35'),
	(12,3,'A encapsuler les mails',3,0,'2015-01-19 23:35:35','2015-01-19 23:35:35'),
	(13,4,'{{ render(form) }}',0,0,'2015-01-19 23:37:01','2015-01-19 23:37:01'),
	(14,4,'{{ $form->render() }}',1,0,'2015-01-19 23:37:01','2015-01-19 23:37:01'),
	(15,4,'{% form_widget(form) %}',2,0,'2015-01-19 23:37:01','2015-01-19 23:37:01'),
	(16,4,'{{ form_widget(form) }}',3,1,'2015-01-19 23:37:01','2015-01-19 23:37:01'),
	(17,5,'REST',0,0,'2015-01-19 23:37:13','2015-01-19 23:37:13'),
	(18,5,'MVC',1,1,'2015-01-19 23:37:13','2015-01-19 23:37:13'),
	(19,5,'MVVC',2,0,'2015-01-19 23:37:13','2015-01-19 23:37:13'),
	(20,5,'MVP',3,0,'2015-01-19 23:37:13','2015-01-19 23:37:13');

/*!40000 ALTER TABLE `qcms_questions_answers` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `name`, `password`, `salt`, `roles`, `created_at`, `updated_at`)
VALUES
	(1,'wpottier@clever-age.com','John Doe','jkUS2fMyYfbiMaQgH5cRZ814ynxHeoAmigYwKL0Pdd0CEQ1iHIr9mkORgrQuiANOEcqIqdLqGQpyGP//fSyEcw==','7936d751c7fba419f3e31688e051a67d','[\"ROLE_USER\"]','2015-01-19 22:53:42','2015-01-19 22:53:42');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
