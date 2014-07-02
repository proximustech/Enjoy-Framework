<?php

require_once 'lib/dataRepositories/interfaces.php';

class enjoyAdminDataRep implements dataRep_Interface {

    var $instance=null;
    var $host;
    var $dbname;
    var $username;
    var $password;    
    
    function __construct() {
        
        $this->host	= 'localhost';
        $this->dbname 	= 'enjoy_admin';
        $this->username = '';
        $this->password = '';        
        
    }

    function getInstance() {

        $this->instance = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
        $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $this->instance;
        
    }
    
    function close() {
        $this->instance = null;
    }

    public function dbExists($dataBase=null) {
        
        if ($dataBase == null) $dataBase=$this->dbname;
        
        $sql="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='$dataBase'";
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($results)) {
            return true;
        }
        else return false;
        
    }

    public function __destruct() {
        $this->close();
    }

}