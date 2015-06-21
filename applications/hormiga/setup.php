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


        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
    
    }

}

?>