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
