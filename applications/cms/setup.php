<?php

require_once "./applications/cms/dataRep/app_dataRep.php"; //Brings app_dataRep()

class cmsSetup {

    var $dataRep;
    var $appServerConfig;
    
    function __construct($config) {
        $this->appServerConfig=$config;
    }
    
    function run() {
        
        $dataRepObject = new cmsDataRep();
        
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

            CREATE TABLE IF NOT EXISTS `enjoy_cms`.`portals` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `portal` VARCHAR(245) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `unique` (`portal` ASC))
            ENGINE = InnoDB;

            CREATE TABLE IF NOT EXISTS `enjoy_cms`.`sections` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `section` VARCHAR(245) NOT NULL,
              `portals_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `unique` (`section` ASC),
              INDEX `fk_sections_portals1_idx` (`portals_id` ASC),
              CONSTRAINT `fk_sections_portals1`
                FOREIGN KEY (`portals_id`)
                REFERENCES `enjoy_cms`.`portals` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)              
            ENGINE = InnoDB;


            CREATE TABLE IF NOT EXISTS `enjoy_cms`.`topics` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `topic` VARCHAR(245) NOT NULL,
              `sections_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `unique` (`topic` ASC),
              INDEX `fk_topics_sections1_idx` (`sections_id` ASC),
              CONSTRAINT `fk_topics_sections1`
                FOREIGN KEY (`sections_id`)
                REFERENCES `enjoy_cms`.`sections` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;

            CREATE TABLE IF NOT EXISTS `enjoy_cms`.`articles` (
              `id` BIGINT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(245) NOT NULL,
              `body` MEDIUMTEXT NOT NULL,
              `active` TINYINT(1) NOT NULL,
              `topics_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_articles_topics1_idx` (`topics_id` ASC),
              CONSTRAINT `fk_articles_topics1`
                FOREIGN KEY (`topics_id`)
                REFERENCES `enjoy_cms`.`topics` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
    
    }

}

?>