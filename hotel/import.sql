-- Adminer 4.8.1 MySQL 8.0.28 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`) VALUES
(1,	'Toulouse'),
(2,	'Paris'),
(3,	'Bordeaux'),
(4,	'Lyon'),
(5,	'Montpellier'),
(6,	'Lille'),
(7,	'Nantes');

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220331182539',	'2022-03-31 20:30:43',	34);

DROP TABLE IF EXISTS `galerie`;
CREATE TABLE `galerie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E7D159054177093` (`room_id`),
  CONSTRAINT `FK_9E7D159054177093` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `galerie` (`id`, `room_id`, `name`) VALUES
(33,	25,	'c538eeb249abc7f5c7d092d5beaf4e78.jpg'),
(34,	25,	'7b965a66144716d8ed5a435989150241.jpg'),
(35,	26,	'3ae57e64e24a4018a82283e0c18e6a39.jpg'),
(36,	26,	'f0251f4046dee31741b15ff7c720d8fc.jpg');

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E01FBE6A54177093` (`room_id`),
  CONSTRAINT `FK_E01FBE6A54177093` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `liste`;
CREATE TABLE `liste` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `liste` (`id`, `name`, `city`, `phone`) VALUES
(1,	'Charles Rougon',	'Toulouse',	'612345678');

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datein` date NOT NULL,
  `dateout` date NOT NULL,
  `price` double DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reservation` (`id`, `datein`, `dateout`, `price`, `status`, `email`, `name`, `category`) VALUES
(48,	'2022-07-14',	'2022-07-21',	65,	'Rougon Charles',	'test@test.fr',	'Romance Room',	'Paris'),
(49,	'2022-04-20',	'2022-04-23',	65,	'Sofia Rougon',	'test@test.fr',	'Romance Room',	'Paris');

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `category_id` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datein` date DEFAULT NULL,
  `dateout` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `hotel_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_729F519B12469DE2` (`category_id`),
  KEY `IDX_729F519BA76ED395` (`user_id`),
  CONSTRAINT `FK_729F519B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_729F519BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `room` (`id`, `name`, `description`, `price`, `category_id`, `image`, `datein`, `dateout`, `status`, `email`, `user_id`, `hotel_id`) VALUES
(25,	'Romance Room',	'A very romantic room',	65,	2,	'073f5832393e7c333be34396adfff19d.jpg',	NULL,	NULL,	NULL,	NULL,	NULL,	11),
(26,	'Fancy room',	'A very fancy room',	75,	1,	'fc18f0ac141d6aa8a44cc7c4a126db68.jpg',	NULL,	NULL,	NULL,	NULL,	NULL,	11);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `name`, `lastname`) VALUES
(4,	'Admin',	'[\"ROLE_ADMIN\"]',	'$2y$13$aP2x.rca8wwjv4tbS0uY3.2p3rU/P38XrAA5tleNDcoIUNS9g6YUi',	'Carlos',	'Rougon'),
(9,	'carlos',	'[\"ROLE_MANAGER\"]',	'$2y$13$TyLMZDZr.oWTt0Hrs60zDe8I7DJf1dGSfmAUq/aBCeoy84NJ0/4OK',	'carlos',	'carlos'),
(11,	'ToulouseHotel',	'[\"ROLE_MANAGER\"]',	'$2y$13$rsmkTNFbAv2NRt7oQ6nrV.QKxTjlZT5RoyeX7TOcJPF5ULOYiLyMq',	'Toulouse',	'Manager'),
(12,	'roughost',	'[]',	'$2y$13$4Q.gZzAUnlAeStrHPTAQ1.O2ClfZhnPTuZWaIKNZQjKA5s3bzsiqi',	'Charles',	'Rougon');

-- 2022-04-20 14:39:14
