<?php

require_once "./applications/calendar/dataRep/app_dataRep.php"; //Brings app_dataRep()

class enjoyAdminSetup {

    var $dataRep;
    var $appServerConfig;
    
    function __construct($config) {
        $this->appServerConfig=$config;
    }
    
    function run() {
        
        $dataRepObject = new calendarDataRep();
        
        try {
            $this->dataRep = $dataRepObject->getInstance();
        } catch (Exception $exc) {
            return array(false,"Error accessing the Data Base {$dataRepObject->dbname} - ".$exc->getMessage());
        }

        try {
            $this->populateDb();
        } catch (Exception $exc) {
           return array(false,'Error populating the Data Base. '.$exc->getMessage());
        }

        return array(true,'ok.');
    }
    
    function populateDb() {
        
        #Structure
        
        $sql="
            CREATE TABLE IF NOT EXISTS `projects` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `project` varchar(50) NOT NULL DEFAULT '0',
              `details` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


            CREATE TABLE IF NOT EXISTS `schedule` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `scheduling` varchar(250) NOT NULL DEFAULT '0',
              `details` text NOT NULL,
              `event` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `tasks` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `task` varchar(250) NOT NULL DEFAULT '0',
              `details` text NOT NULL,
              `projects_id` bigint(20) NOT NULL,
              `state` varchar(50) DEFAULT NULL,
              `priority` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ";
        
        $query = $this->dataRep->prepare($sql);
        $query->execute();
    
    }

}

?>
