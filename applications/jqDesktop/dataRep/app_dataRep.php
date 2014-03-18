<?php

class app_dataRep {

    var $instance;
    
    function __construct() {
        
    }

    function getInstance() {

        $host		= 'localhost';
        $dbname 	= 'enjoy';
        $username 	= 'root';
        $password 	= 'samsung';
        
        $this->instance = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $username, $password);
        $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $this->instance;
        
    }
    
    function close() {
    }

}