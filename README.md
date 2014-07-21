AdsBundle
=========

Manejo de campañas 

TRIGGER ADS
###############################################
DELIMITER |

CREATE TRIGGER campaign_real_stats_trigger AFTER INSERT ON campaign_real_log 
FOR EACH ROW
BEGIN
    UPDATE campaign_real_stats as s SET s.views = s.views+1, s.weight = s.weight-1 WHERE s.campaign_id = NEW.campaign_id;
END
|

DELIMITER ;

###############################################
SELECT * FROM INFORMATION_SCHEMA.TRIGGERS;
DROP TRIGGER campaign_real_stats_trigger;


-CRONES.
###############################################

1- success:ads:init
Este cron se encarga de inicializar la tabla de anuncios activos del dia. Debera correr todos los dias a las 00:00

2- success:ads:syncro
Este cron se encarga de actualizar todas las estadisticas del dia. Ajustar el valor segun el sistema.
Puede correr 1, 2, o las veces que se quiera por dia.


-COLA DE ANUNCIOS
###############################################
-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-07-2014 a las 19:10:53
-- Versión del servidor: 5.5.34-0ubuntu0.13.04.1
-- Versión de PHP: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `agrotema_success`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign_real_log`
--

CREATE TABLE IF NOT EXISTS `campaign_real_log` (
  `campaign_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `ip` char(64) NOT NULL,
  `processed_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Disparadores `campaign_real_log`
--
DROP TRIGGER IF EXISTS `campaign_real_stats_trigger`;
DELIMITER //
CREATE TRIGGER `campaign_real_stats_trigger` AFTER INSERT ON `campaign_real_log`
 FOR EACH ROW BEGIN
    UPDATE campaign_real_stats as s SET s.views = s.views+1, s.weight = s.weight-1 WHERE s.campaign_id = NEW.campaign_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign_real_stats`
--

CREATE TABLE IF NOT EXISTS `campaign_real_stats` (
  `campaign_id` int(11) NOT NULL,
  `views` smallint(6) NOT NULL,
  `max_views` smallint(6) NOT NULL,
  `weight` float NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;