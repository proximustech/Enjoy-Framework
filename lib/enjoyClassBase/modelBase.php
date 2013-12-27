<?php

require_once 'lib/enjoyClassBase/validatorBase.php';

class modelBase {

    var $dataRep;
    var $tables;
    var $config;
    var $fieldsConfig;
    var $primaryKey;
    var $result = array();

    function __construct($dataRep, $config) {
        $this->dataRep = $dataRep;
        $this->config = &$config;
    }

    function fethLimited() {
        
        $options["additional"][]="LIMIT 0,".$this->config["helpers"]["crud_listMaxLines"];
        return $this->fetch($options);
    
    }
    
    function insertRecord() {
        
        $validator= new validatorBase($this->config, $this->fieldsConfig,$this->primaryKey);
        $register=array();
        
        foreach ($this->fieldsConfig as $field => $configSection) {
            if ($field != $this->primaryKey and substr($field, 0,5)!="enjoy" ) {
                if (key_exists($field, $_GET)) {
                    $register[$field]=$_GET[$field];
                    $options["fields"][]=$field;
                    $options["values"][0][]="'".$_GET[$field]."'";
                }
            }
        }        
        
        $validationResult=$validator->validateFields($register);
        
        if ($validationResult!== true) {
            exit($validationResult);
        }
        
        $validationResult=$validator->validateRegister($register);
        
        if ($validationResult!== true) {
            exit($validationResult);
        }
        
        $this->insert($options);
    
    }        
    
    function insert($options) {

        list($fieldsSql, $valuesSql) = $this->getInsertConf($options);
        
        $sql = "INSERT INTO $this->tables $fieldsSql VALUES $valuesSql";

        $query = $this->dataRep->prepare($sql);
        $query->execute();
    }

    function fetchRecord() {

        $primaryKeyValue = $_GET[$this->primaryKey];

        $options["where"][] = "$this->primaryKey='$primaryKeyValue'";
        $resultArray = $this->fetch($options);
        $register = $resultArray["results"][0];
        return $register;
    }

    function deleteRecord() {

        $primaryKeyValue = $_GET[$this->primaryKey];

        $options["where"][] = "$this->primaryKey='$primaryKeyValue'";
        $this->delete($options);
    }

    function updateRecord() {
        
        $validator= new validatorBase($this->config, $this->fieldsConfig,$this->primaryKey);
        $register=array();        

        foreach ($this->fieldsConfig as $field => $configSection) {
            if ($field != $this->primaryKey and substr($field, 0,5)!="enjoy") {
                $register[$field]=$_GET[$field];
                $value = $_GET[$field];
                $options["set"][] = "$field='$value'";
            }
        }
        
        $validationResult=$validator->validateFields($register);
        
        if ($validationResult!== true) {
            exit($validationResult);
        }
        
        $validationResult=$validator->validateRegister($register);
        
        if ($validationResult!== true) {
            exit($validationResult);
        }
                

        $options["where"][] = "$this->primaryKey='".$_GET[$this->primaryKey]."'";
        $this->update($options);
    }

    function delete($options) {
        $whereSql = $this->getWhereConf($options);

        if ($whereSql != "") {
            $sql = "DELETE FROM $this->tables $whereSql";

            $query = $this->dataRep->prepare($sql);
            $query->execute();
        }
    }
    function update($options) {

        $whereSql = "";
        if ($options != null) {
            list($whereSql,$setSql) = $this->getSqlUpdateConf($options);
        }

        if ($setSql != "") {
            $sql = "UPDATE $this->tables SET $setSql $whereSql";

            $query = $this->dataRep->prepare($sql);
            $query->execute();
        }
    }

    function fetch($options = null) {

        if ($options != null) {
            list($whereSql, $additionalSql, $fields) = $this->getSqlConf($options);

            $getTotal = false;
            if (key_exists("additional", $options)) {
                foreach ($options["additional"] as $additionalComponent) {
                    if (substr(strtoupper($additionalComponent), 0, 5) == "LIMIT") {
                        $getTotal = true;
                        break;
                    }
                }
            }


            if ($getTotal) {
                $sql = "SELECT count(*) AS total FROM $this->tables $whereSql $additionalSql";

                $query = $this->dataRep->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                $resultArray["totalRegisters"] = $results[0]["total"];
            }
        } else {
            $whereSql = "";
            $additionalSql = "";
            $fields = "*";
        }

        $sql = "SELECT $fields FROM $this->tables $whereSql $additionalSql";

        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $resultArray["results"] = $results;

        return $resultArray;
    }

    protected function getWhereConf($options) {

        if (key_exists("where", $options)) {
            $whereSql = " WHERE ";
            $whereSql.= implode(" AND ", $options["where"]);
        } else {
            $whereSql = "";
        }

        return $whereSql;
    }

    protected function getSqlConf($options) {

        if (key_exists("where", $options)) {
            $whereSql = " WHERE ";
            $whereSql.= implode(" AND ", $options["where"]);
        } else {
            $whereSql = "";
        }
        if (key_exists("additional", $options)) {
            $additionalSql = implode(" ", $options["additional"]);
        } else {
            $additionalSql = "";
        }
        if (key_exists("fields", $options)) {
            $fields = implode(",", $options["fields"]);
        } else {
            $fields = "*";
        }

        return array($whereSql, $additionalSql, $fields);
    }
    protected function getSqlUpdateConf($options) {

        if (key_exists("where", $options)) {
            $whereSql = " WHERE ";
            $whereSql.= implode(" AND ", $options["where"]);
        } else {
            $whereSql = "";
        }
        if (key_exists("set", $options)) {
            $setSql = implode(",", $options["set"]);
        } else {
            $setSql = "";
        }

        return array($whereSql, $setSql);
    }

    protected function getInsertConf($options) {

        if (key_exists("fields", $options)) {
            $fieldsSql = "(";
            $fieldsSql.= implode(",", $options["fields"]);
            $fieldsSql.=")";
        } else {
            $fieldsSql = "";
        }
        if (key_exists("values", $options)) {
            foreach ($options["values"] as $valuesRow) {
                $valuesSql = "(";
                $valuesSql.= implode(",", $valuesRow);
                $valuesSql.=")";
            }
        } else {
            $valuesSql = "";
        }

        return array($fieldsSql, $valuesSql);
    }
    
}

?>
