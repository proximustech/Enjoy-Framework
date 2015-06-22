<?php

require_once "lib/dataRepositories/mysqlDataRep.php";

class hormigaDataRep extends dataRep {

    function __construct() {
        
        $this->host	= "localhost";
        $this->dbname 	= "hormiga";
        $this->username = "root";
        $this->password = "samsung";        
        
    }

}