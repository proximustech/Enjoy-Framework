<?php

require_once "lib/dataRepositories/interfaces.php";

class dataRep implements dataRep_Interface {

    var $pdo=null;
    var $host;
    var $port=5432;
    var $dbname;
    var $username;
    var $password;
    
    //var $uniqueErrorCode="1062";
    
    function __construct() {
        //The extender has to define in the __construct the connection parameters

        /*
         * Avoid the replacements PHP makes over parameters with points and other special caracters
         * First needed when using postgresql
         */
        
        function getRealRequest($sourceArray) {

            $tempArray = array();
            foreach ($sourceArray as $parameter => $value) {
                $parameter=str_replace("public_", "public.", $parameter);
                $tempArray[$parameter] = $value;
            }
            return $tempArray;
        }

        if (count($_GET)) {
            $_GET = getRealRequest($_GET);
        }
        if (count($_POST)) {
            $_POST=getRealRequest($_POST);
        }
        if (count($_REQUEST)) {
            $_REQUEST=getRealRequest($_REQUEST);
        }
        if (count($_FILES)) {
            $_FILES=getRealRequest($_FILES);
        }

    }

    function getInstance() {

        $this->pdo = new PDO("pgsql:host=" . $this->host .";port=" . $this->port. ";dbname=" . $this->dbname, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $this->pdo;
        
    }
    
    function close() {
        $this->pdo = null;
    }

    public function dbExists($dataBase=null) {
        
//        if ($dataBase == null) $dataBase=$this->dbname;
//
//        $sql="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='$dataBase'";
//        $query = $this->dataRep->prepare($sql);
//        $query->execute();
//        $results = $query->fetchAll(PDO::FETCH_ASSOC);
//
//        if (count($results)) {
//            return true;
//        }
//        else return false;
        
    }
    
    
    function getLastInsertId($sequence) {

        //SELECT currval('seq_name')

        $sequence=$sequence."_seq";
        return $this->pdo->lastInsertId($sequence);
        
    }    
    
    public function getFieldFromErrorMessage($errorCode,$errorMessage) {
//        $messageArray=explode(" ", $errorMessage);
//        $field="";
//        if ($errorCode==$this->uniqueErrorCode) {
//            $fieldData=trim($messageArray[count($messageArray)-1],"'");
//            $field=rtrim($fieldData,"_UNIQUE");
//        }
//
//        return $field;
        
    }

    public function __destruct() {
        $this->close();
    }


}