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
            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`applications`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`applications` (
              `id` INT(10) NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(254) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `name` (`name` ASC))
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`components`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`components` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `id_app` INT(10) NOT NULL,
              `name` VARCHAR(254) NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_components_applications1_idx` (`id_app` ASC),
              CONSTRAINT `fk_components_applications1`
                FOREIGN KEY (`id_app`)
                REFERENCES `enjoy_admin`.`applications` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`modules`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`modules` (
              `id` INT(10) NOT NULL AUTO_INCREMENT,
              `id_app` INT(10) NULL DEFAULT NULL,
              `name` VARCHAR(254) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `name` (`name` ASC),
              INDEX `fk_modules_applications1_idx` (`id_app` ASC),
              CONSTRAINT `fk_modules_applications1`
                FOREIGN KEY (`id_app`)
                REFERENCES `enjoy_admin`.`applications` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`roles`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`roles` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(254) NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `name` (`name` ASC))
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`roles_applications`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`roles_applications` (
              `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
              `id_role` INT NOT NULL,
              `id_app` INT(10) NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_roles_applications_applications1_idx` (`id_app` ASC),
              INDEX `fk_roles_applications_roles1_idx` (`id_role` ASC),
              CONSTRAINT `fk_roles_applications_applications1`
                FOREIGN KEY (`id_app`)
                REFERENCES `enjoy_admin`.`applications` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_roles_applications_roles1`
                FOREIGN KEY (`id_role`)
                REFERENCES `enjoy_admin`.`roles` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`roles_applications_components`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`roles_applications_components` (
              `id` INT(10) NOT NULL AUTO_INCREMENT,
              `id_role_app` BIGINT(20) NOT NULL,
              `id_component` INT NOT NULL,
              `permission` TINYINT(4) NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_roles_applications_components_roles_applications1_idx` (`id_role_app` ASC),
              INDEX `fk_roles_applications_components_components1_idx` (`id_component` ASC),
              CONSTRAINT `fk_roles_applications_components_roles_applications1`
                FOREIGN KEY (`id_role_app`)
                REFERENCES `enjoy_admin`.`roles_applications` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_roles_applications_components_components1`
                FOREIGN KEY (`id_component`)
                REFERENCES `enjoy_admin`.`components` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB
            COMMENT = ' /* comment truncated */ /*module permissions*/'
            ROW_FORMAT = COMPACT;


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`roles_applications_modules`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`roles_applications_modules` (
              `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
              `id_role_app` BIGINT(20) NOT NULL,
              `id_module` INT(10) NOT NULL,
              `permission` TEXT NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_roles_applications_modules_roles_applications1_idx` (`id_role_app` ASC),
              INDEX `fk_roles_applications_modules_modules1_idx` (`id_module` ASC),
              CONSTRAINT `fk_roles_applications_modules_roles_applications1`
                FOREIGN KEY (`id_role_app`)
                REFERENCES `enjoy_admin`.`roles_applications` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_roles_applications_modules_modules1`
                FOREIGN KEY (`id_module`)
                REFERENCES `enjoy_admin`.`modules` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB
            COMMENT = ' /* comment truncated */ /*module permissions*/';


            -- -----------------------------------------------------
            -- Table `enjoy_admin`.`users`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `enjoy_admin`.`users` (
              `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
              `id_role` INT NOT NULL,
              `user_name` VARCHAR(254) NOT NULL,
              `password` VARCHAR(254) NOT NULL,
              `active` TINYINT NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `user_name` (`user_name` ASC),
              INDEX `fk_users_roles_idx` (`id_role` ASC),
              CONSTRAINT `fk_users_roles`
                FOREIGN KEY (`id_role`)
                REFERENCES `enjoy_admin`.`roles` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;

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
