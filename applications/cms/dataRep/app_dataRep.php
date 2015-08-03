<?php

require_once "lib/dataRepositories/mysqlDataRep.php";

class cmsDataRep extends dataRep {

    function __construct() {
        
        $this->host	= "localhost";
        $this->dbname 	= "enjoy_cms";
        $this->username = "";
        $this->password = "";        
        
    }

}