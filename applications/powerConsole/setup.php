<?php

require_once "./applications/powerConsole/dataRep/app_dataRep.php"; //Brings app_dataRep()

class powerConsoleSetup {

    var $dataRep;
    var $appServerConfig;
    
    function __construct($config) {
        $this->appServerConfig=$config;
    }
    
    function run() {
        
        $dataRepObject = new powerConsoleDataRep();
        
        try {
            $this->dataRep = $dataRepObject->getInstance();
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
            -- -----------------------------------------------------
            -- Table `power_console`.`info_types`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `power_console`.`info_types` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `info_type` VARCHAR(254) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `power_console`.`processes`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `power_console`.`processes` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `process` VARCHAR(254) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `power_console`.`messages`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `power_console`.`messages` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `id_info_types` INT NOT NULL,
              `id_processes` INT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_messages_info_types_idx` (`id_info_types` ASC),
              INDEX `fk_messages_processes1_idx` (`id_processes` ASC),
              CONSTRAINT `fk_messages_info_types`
                FOREIGN KEY (`id_info_types`)
                REFERENCES `power_console`.`info_types` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_messages_processes1`
                FOREIGN KEY (`id_processes`)
                REFERENCES `power_console`.`processes` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `power_console`.`workers`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `power_console`.`workers` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `worker` VARCHAR(254) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;


            -- -----------------------------------------------------
            -- Table `power_console`.`processes_workers`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `power_console`.`processes_workers` (
              `id_processes` INT NOT NULL,
              `id_workers` INT NOT NULL,
              INDEX `fk_processes_workers_processes1_idx` (`id_processes` ASC),
              INDEX `fk_processes_workers_workers1_idx` (`id_workers` ASC),
              CONSTRAINT `fk_processes_workers_processes1`
                FOREIGN KEY (`id_processes`)
                REFERENCES `power_console`.`processes` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_processes_workers_workers1`
                FOREIGN KEY (`id_workers`)
                REFERENCES `power_console`.`workers` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
    
    }

}

?>