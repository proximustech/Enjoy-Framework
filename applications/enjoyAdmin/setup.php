<?php

require_once "./applications/enjoyAdmin/dataRep/app_dataRep.php"; //Brings app_dataRep()
require_once 'lib/enjoyClassBase/identification.php';

class enjoyAdminSetup {

    var $dataRep;
    var $appServerConfig;
    
    function __construct($config) {
        $this->appServerConfig=$config;
    }
    
    function run() {
        
        $adminUserError="Error: The ['appServerConfig']['base']['adminUser'] setting in appServerConfig.php MUST BE set with any string and SHOULD NOT BE empty.";
        
        if (!isset($this->appServerConfig['base']['adminUser'])) {
            return array(false,$adminUserError);
        }
        else if ($this->appServerConfig['base']['adminUser']=='') {
            return array(false,$adminUserError);
        }
        
        $dataRepObject = new enjoyAdminDataRep();
        
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
        
        $e_dbIdentifier=new e_dbIdentifier($this->dataRep,$this->appServerConfig);
        $e_user = new e_user($e_dbIdentifier, $this->appServerConfig);
        $userData['user']=$this->appServerConfig['base']['adminUser'];
        $e_user->profile($userData);           
        
        $info=array();
        $info['modifiedStamp']=time();
        $e_user->saveInfo($info);        


        return array(true,'ok. To login in to the jqDesktop application, use for both user and password: '.$this->appServerConfig['base']['adminUser']);
    }
    
    function populateDb() {
        
        #Structure
        
        $sql="

            CREATE TABLE IF NOT EXISTS `applications` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `name` varchar(64) NOT NULL,
              `test` varchar(64) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `components` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `id_app` smallint(6) NOT NULL,
              `name` varchar(2048) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `modules` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `id_app` int(10) DEFAULT NULL,
              `name` varchar(50) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `roles` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `roles_applications` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `id_role` bigint(20) NOT NULL,
              `id_app` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `roles_applications_components` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `id_role_app` int(10) DEFAULT NULL,
              `id_component` int(10) DEFAULT NULL,
              `permission` tinyint(4) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='module permissions';

            CREATE TABLE IF NOT EXISTS `roles_applications_modules` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `id_role_app` int(10) NOT NULL,
              `id_module` int(10) NOT NULL,
              `permission` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='module permissions';

            CREATE TABLE IF NOT EXISTS `users` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `id_role` int(11) NOT NULL,
              `user_name` varchar(64) NOT NULL,
              `password` varchar(64) NOT NULL,
              `active` int(10) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_name` (`user_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        ";
        
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        
        ###################Data

        
        $e_dbIdentifier=new e_dbIdentifier($this->dataRep,$this->appServerConfig);
        $adminPassword = $e_dbIdentifier->encodePassword($this->appServerConfig['base']['adminUser']); //Example: user "admin", password "admin"
        
        $sql="
            INSERT INTO `roles` ( `name`) 
                VALUES ('Administrator');
        ";
            
        $query = $this->dataRep->prepare($sql);
        $query->execute();
    
        $sql="
            INSERT INTO `users` ( `user_name`, `password`, `active`, `id_role`) 
                VALUES ('{$this->appServerConfig['base']['adminUser']}', '$adminPassword', 1,1);
        ";
            
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        
        $sql="
            INSERT INTO `applications` ( `name`) 
                VALUES ('enjoyAdmin');
        ";
            
        $query = $this->dataRep->prepare($sql);
        $query->execute();
    
        $sql="
            INSERT INTO 
                `modules` (`id_app`, `name`) 
            VALUES
                (1, 'users'),
                (1, 'roles'),
                (1, 'applications'),
                (1, 'roles_applications'),
                (1, 'modules'),
                (1, 'components'),
                (1, 'roles_applications_components'),
                (1, 'roles_applications_modules')
        ";
            
        $query = $this->dataRep->prepare($sql);
        $query->execute();
    
    }

}

?>
