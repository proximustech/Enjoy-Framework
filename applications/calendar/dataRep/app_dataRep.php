<?php

require_once "lib/dataRepositories/mysqlDataRep.php";

class calendarDataRep extends dataRep {

    function __construct() {
        
        $this->host	= "localhost";
        $this->dbname 	= "enjoy_calendar";
        $this->username = "";
        $this->password = "";        
        
    }

}