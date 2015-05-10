<?php

require_once "lib/dataRepositories/mysqlDataRep.php";

class enjoyAdminDataRep extends dataRep {
  
    function __construct() {
        
        $this->host	= 'localhost';
        $this->dbname 	= 'enjoy_admin';
        $this->username = '';
        $this->password = '';        
        
    }
}