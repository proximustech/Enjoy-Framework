<?php

require_once "./applications/hormiga/dataRep/app_dataRep.php"; //Brings app_dataRep()

class hormigaSetup {

    var $dataRep;
    var $appServerConfig;
    
    function __construct($config) {
        $this->appServerConfig=$config;
    }
    
    function run() {
        
        $this->dataRep = new hormigaDataRep();
        
        try {
            $this->dataRep->getInstance();
        } catch (Exception $exc) {
            return array(false,"Error accessing the Data Base {$dataRepObject->dbname} - ".$exc->getMessage());
        }

        try {
            $this->populateDb();
        } catch (Exception $exc) {
           return array(false,"Error populating the Data Base. ".$exc->getMessage());
        }

        return array(true,"ok.");
    }
    
    function populateDb() {
        
        #Structure
        
        $sql="

        -- Volcando estructura para tabla hormiga.avances
        CREATE TABLE IF NOT EXISTS `avances` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `fecha_inicio` datetime DEFAULT NULL,
          `duracion_minutos` int(11) DEFAULT NULL,
          `avance` text,
          `id_tareas` int(11) DEFAULT NULL,
          `user_name` varchar(254) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_avances_tareas1_idx` (`id_tareas`),
          CONSTRAINT `fk_avances_tareas1` FOREIGN KEY (`id_tareas`) REFERENCES `tareas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Avances de cada una de las tareas';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.etiquetas
        CREATE TABLE IF NOT EXISTS `etiquetas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `etiqueta` varchar(254) DEFAULT NULL,
          `id_tipo_etiquetas` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_etiquetas_tipo_etiquetas_idx` (`id_tipo_etiquetas`),
          CONSTRAINT `fk_etiquetas_tipo_etiquetas` FOREIGN KEY (`id_tipo_etiquetas`) REFERENCES `tipo_etiquetas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Permite Agrupar los Proyectos bajo varios criterios cualitativos';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.proyectos
        CREATE TABLE IF NOT EXISTS `proyectos` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `proyecto` varchar(254) DEFAULT NULL,
          `prioridad` int(11) DEFAULT NULL,
          `fecha_registro` date NOT NULL,
          `fecha_inicio` date DEFAULT NULL,
          `fecha_fin` date DEFAULT NULL,
          `comentarios` text,
          PRIMARY KEY (`id`),
          UNIQUE KEY `proyecto` (`proyecto`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Los estados del proyecto se manejan a traves de bpm';


        -- Volcando estructura para tabla hormiga.proyectos_bpm
        CREATE TABLE IF NOT EXISTS `proyectos_bpm` (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `user` varchar(254) DEFAULT NULL,
          `id_process` bigint(20) DEFAULT NULL,
          `state` varchar(254) DEFAULT NULL,
          `date` datetime DEFAULT NULL,
          `info` varchar(254) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.proyectos_etiquetas
        CREATE TABLE IF NOT EXISTS `proyectos_etiquetas` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `id_proyectos` int(11) DEFAULT NULL,
          `id_etiquetas` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_proyectos_etiquetas_proyectos1_idx` (`id_proyectos`),
          KEY `fk_proyectos_etiquetas_etiquetas1_idx` (`id_etiquetas`),
          CONSTRAINT `fk_proyectos_etiquetas_etiquetas1` FOREIGN KEY (`id_etiquetas`) REFERENCES `etiquetas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `fk_proyectos_etiquetas_proyectos1` FOREIGN KEY (`id_proyectos`) REFERENCES `proyectos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relacion varios a varios entre proyectos y etiquetas';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.proyectos_etiquetas_tareas
        CREATE TABLE IF NOT EXISTS `proyectos_etiquetas_tareas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_proyectos_etiquetas` bigint(20) unsigned NOT NULL,
          `id_tareas` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_proyectos_etiquetas_tareas_proyectos_etiquetas1_idx` (`id_proyectos_etiquetas`),
          KEY `fk_proyectos_etiquetas_tareas_tareas1_idx` (`id_tareas`),
          CONSTRAINT `fk_proyectos_etiquetas_tareas_proyectos_etiquetas1` FOREIGN KEY (`id_proyectos_etiquetas`) REFERENCES `proyectos_etiquetas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
          CONSTRAINT `fk_proyectos_etiquetas_tareas_tareas1` FOREIGN KEY (`id_tareas`) REFERENCES `tareas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.tareas
        CREATE TABLE IF NOT EXISTS `tareas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `tarea` varchar(254) DEFAULT NULL,
          `prioridad` int(11) DEFAULT NULL,
          `fecha_inicio` datetime DEFAULT NULL,
          `fecha_fin` datetime DEFAULT NULL,
          `comentarios` text,
          `id_proyectos` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_tareas_proyectos1_idx` (`id_proyectos`),
          CONSTRAINT `fk_tareas_proyectos1` FOREIGN KEY (`id_proyectos`) REFERENCES `proyectos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tareas de los proyectos. Su estado es controlado por bpm';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.tareas_bpm
        CREATE TABLE IF NOT EXISTS `tareas_bpm` (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `user` varchar(254) DEFAULT NULL,
          `id_process` bigint(20) DEFAULT NULL,
          `state` varchar(254) DEFAULT NULL,
          `date` datetime DEFAULT NULL,
          `info` varchar(254) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        -- La exportación de datos fue deseleccionada.

        -- Volcando estructura para tabla hormiga.tipo_etiquetas
        CREATE TABLE IF NOT EXISTS `tipo_etiquetas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `tipo_etiqueta` varchar(254) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Permite agrupar las etiquetas bajo un criterio cualitativo';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.usuarios_proyectos
        CREATE TABLE IF NOT EXISTS `usuarios_proyectos` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_users` int(11) DEFAULT NULL,
          `id_proyectos` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_usuarios_tareas_proyectos1_idx` (`id_proyectos`),
          CONSTRAINT `fk_usuarios_tareas_proyectos1` FOREIGN KEY (`id_proyectos`) REFERENCES `proyectos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='relacion varios a varios entre los usuarios y las tareas de los proyectos';

        -- La exportación de datos fue deseleccionada.


        -- Volcando estructura para tabla hormiga.usuarios_proyectos_tareas
        CREATE TABLE IF NOT EXISTS `usuarios_proyectos_tareas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_tareas` int(11) NOT NULL,
          `id_usuarios_proyectos` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_usuarios_proyectos_tareas_tareas1_idx` (`id_tareas`),
          KEY `fk_usuarios_proyectos_tareas_usuarios_proyectos1_idx` (`id_usuarios_proyectos`),
          CONSTRAINT `fk_usuarios_proyectos_tareas_tareas1` FOREIGN KEY (`id_tareas`) REFERENCES `tareas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
          CONSTRAINT `fk_usuarios_proyectos_tareas_usuarios_proyectos1` FOREIGN KEY (`id_usuarios_proyectos`) REFERENCES `usuarios_proyectos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
    
    }

}

?>