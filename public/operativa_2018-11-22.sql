# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.21)
# Base de datos: operativa
# Tiempo de Generación: 2018-11-22 22:10:35 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puesto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `puesto`, `estado`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Admin','admin@gmail.com','123456','Admin','A','','2018-10-12 14:58:44','2018-10-12 14:58:46');

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla anomalias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `anomalias`;

CREATE TABLE `anomalias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Volcado de tabla delegacion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `delegacion`;

CREATE TABLE `delegacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `delegacion` WRITE;
/*!40000 ALTER TABLE `delegacion` DISABLE KEYS */;

INSERT INTO `delegacion` (`id`, `nombre`, `created_at`, `updated_at`)
VALUES
	(1,'ATLANTICO NORTE',NULL,NULL),
	(2,'ATLANTICO SUR',NULL,NULL);

/*!40000 ALTER TABLE `delegacion` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla entidades_pagos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `entidades_pagos`;

CREATE TABLE `entidades_pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Volcado de tabla labores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `labores`;

CREATE TABLE `labores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `labores` WRITE;
/*!40000 ALTER TABLE `labores` DISABLE KEYS */;

INSERT INTO `labores` (`id`, `nombre`, `created_at`, `updated_at`)
VALUES
	(1,'SuperAdmin',NULL,NULL);

/*!40000 ALTER TABLE `labores` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla observaciones_rapidas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `observaciones_rapidas`;

CREATE TABLE `observaciones_rapidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Volcado de tabla resultados
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resultados`;

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Volcado de tabla tipo_usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipo_usuario`;

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;

INSERT INTO `tipo_usuario` (`id`, `nombre`, `created_at`, `updated_at`)
VALUES
	(1,'administrador',NULL,NULL),
	(2,'coordinador',NULL,NULL),
	(3,'auxiliar',NULL,NULL),
	(4,'operativo',NULL,NULL);

/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `contrasena` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sesion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `labor_id` int(11) DEFAULT NULL,
  `delegacion_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_tipo_usuario1` (`tipo_id`),
  KEY `fk_usuarios_labor_id` (`labor_id`),
  KEY `fk_usuarios_delegacion_id` (`delegacion_id`),
  CONSTRAINT `fk_usuarios_delegacion_id` FOREIGN KEY (`delegacion_id`) REFERENCES `delegacion` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_labor_id` FOREIGN KEY (`labor_id`) REFERENCES `labores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_tipo_id` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='0=no_activado,1=activo';

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`id`, `nickname`, `nombre`, `tipo_id`, `contrasena`, `sesion`, `email`, `estado`, `labor_id`, `delegacion_id`, `created_at`, `updated_at`)
VALUES
	(1,'admin','Hersenwig Ricov',1,'827ccb0eea8a706c4c34a16891f84e7b',NULL,'',1,1,1,NULL,NULL);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
