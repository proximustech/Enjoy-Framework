<?php

require_once 'lib/enjoyClassBase/validatorBase.php';

class baseModel {

    var $dataRep;
    var $tables;
    var $foreignKeys=array();
    var $dependents=array();
    var $subModels=array();
    var $config;
    var $fieldsConfig;
    var $primaryKey;
    var $result = array();
    var $label=array();

    function __construct($dataRep, $config) {
        $this->dataRep = $dataRep;
        $this->config = &$config;
    }

    function fethLimited($options=array()) {
        
        $options["additional"][]="LIMIT 0,".$this->config["helpers"]["crud_listMaxLines"];
        return $this->fetch($options);
    
    }
    
    function insertRecord() {
        
        $validator= new validatorBase($this->config, $this->fieldsConfig,$this->primaryKey);
        $register=array();
        
        foreach ($this->fieldsConfig as $field => $configSection) {
            if ($field != $this->primaryKey and substr($field, 0,5)!="enjoy" ) {
                if (key_exists($this->tables.'_'.$field, $_REQUEST)) {
                    $register[$field]=$_REQUEST[$this->tables.'_'.$field];
                    $options["fields"][]=$field;
                    $options["values"][0][]="'".$_REQUEST[$this->tables.'_'.$field]."'";
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
        $newPrimaryKey=$this->getLastInsertId();
        
        foreach ($this->subModels as $subModelEnry => $subModelConfig) {
    
            $subModel=&$subModelConfig['model'];
            $linkerField=$subModelConfig['linkerField'];
            $linkedField=$subModelConfig['linkedField'];
            $linkedDataField=$subModelConfig['linkedDataField'];
            $type=$subModelConfig['type'];
            
            if (!isset($_REQUEST[$this->tables.'_'.$linkerField])) {
                $_REQUEST[$subModel->tables.'_'.$linkedField]=$newPrimaryKey;
            }
            else{
                $_REQUEST[$subModel->tables.'_'.$linkedField]=$_REQUEST[$this->tables.'_'.$linkerField];
            }
            
            
            $linkedDataFieldVar=$_REQUEST[$subModel->tables.'_'.$linkedDataField];
            
            if (is_array($linkedDataFieldVar)) {
                foreach ($linkedDataFieldVar as $linkedDataFieldValue) {
                    $_REQUEST[$subModel->tables.'_'.$linkedDataField]=$linkedDataFieldValue;
                    $subModel->insertRecord();
                }
            }elseif($linkedDataFieldVar!=''){
                $subModel->insertRecord();
            }
            
        }
    
    }
    
    function getLastInsertId() {
        
        $sql = "SELECT LAST_INSERT_ID() AS lastId";

        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]["lastId"];    
    }
    
    function insert($options) {

        list($fieldsSql, $valuesSql) = $this->getInsertConf($options);
        
        $sql = "INSERT INTO $this->tables $fieldsSql VALUES $valuesSql";

        $query = $this->dataRep->prepare($sql);
        $query->execute();
    }

    function fetchRecord() {

        $primaryKeyValue = $_REQUEST[$this->tables.'_'.$this->primaryKey];

        $options["where"][] = "$this->tables.$this->primaryKey='$primaryKeyValue'";
        $resultArray = $this->fetch($options);
        $register = $resultArray["results"][0];
        return $register;
    }
    
    function fetchFkRecord() {

        $primaryKeyValue = $_REQUEST[$this->tables.'_'.$this->primaryKey];
        $fkField = $_REQUEST['fkField'];
        
        $options["fields"][] = $fkField;
        $options["where"][] = "$this->tables.$this->primaryKey='$primaryKeyValue'";
        
        $resultArray = $this->fetch($options);
        $register = $resultArray["results"][0];        
        $fkValue=$register[$fkField];
        
        $fkModel=$this->foreignKeys[$fkField]['model'];

//        $options["fields"][] = '*';
        unset($options);
        $options["where"][] = "$fkModel->tables.$fkModel->primaryKey='$fkValue'";
        $resultArray = $fkModel->fetch($options);
        $register = $resultArray["results"][0];
        return $register;
    }

    function deleteRecord() {

        $options["where"][] = "$this->primaryKey='".$_REQUEST[$this->tables.'_'.$this->primaryKey]."'";
        $this->delete($options);
        unset($options);
        
        foreach ($this->subModels as $subModelEnry => $subModelConfig) {
    
            $subModel=&$subModelConfig['model'];
            $linkerField=$subModelConfig['linkerField'];
            $linkedField=$subModelConfig['linkedField'];
            
            $options["where"][] = "{$subModel->tables}.$linkedField='{$_REQUEST[$this->tables.'_'.$linkerField]}'";
            $subModel->delete($options);
            
        }        
        
    }

    function updateRecord() {
        
        $validator= new validatorBase($this->config, $this->fieldsConfig,$this->primaryKey);
        $register=array();        

        foreach ($this->fieldsConfig as $field => $configSection) {
            if ($field != $this->primaryKey and substr($field, 0,5)!="enjoy") {
                $value = $_REQUEST[$this->tables.'_'.$field];
                $register[$field]=$value;
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
                

        $options["where"][] = "$this->primaryKey='".$_REQUEST[$this->tables.'_'.$this->primaryKey]."'";
        $this->update($options);
        unset($options);
        foreach ($this->subModels as $subModelEnry => $subModelConfig) {
    
            $subModel=&$subModelConfig['model'];
            $linkerField=$subModelConfig['linkerField'];
            $linkedField=$subModelConfig['linkedField'];
            $linkedDataField=$subModelConfig['linkedDataField'];
            $type=$subModelConfig['type'];
            
            $_REQUEST[$subModel->tables.'_'.$linkedField]=$_REQUEST[$this->tables.'_'.$linkerField];
            
            $linkedDataFieldVar=$_REQUEST[$subModel->tables.'_'.$linkedDataField];
            
            $options["where"][] = "{$subModel->tables}.$linkedField='{$_REQUEST[$this->tables.'_'.$linkerField]}'";
            $subModel->delete($options);
            if (is_array($linkedDataFieldVar)) {
                foreach ($linkedDataFieldVar as $linkedDataFieldValue) {
                    $_REQUEST[$subModel->tables.'_'.$linkedDataField]=$linkedDataFieldValue;
                    $subModel->insertRecord();
                }
            }elseif($linkedDataFieldVar!=''){
                $subModel->insertRecord();
            }
            
        }        
        
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

    function fetch($options = array()) {
        
        $whereSql = "";
        $additionalSql = "";
        
        $relatedTables=array();
        $relatedFields=array();
        $relatedOptions=array();
        $relatedTables[]=$this->tables;
        
        foreach ($this->fieldsConfig as $field => $configSection) {

            $addField=false;
            
            if (substr($field, 0,5)!="enjoy") {
                
                if (key_exists('fields', $options)) {
                    if (in_array($field, $options['fields'])) {
                        $addField=true;
                    }
                }
                else{
                        $addField=true;
                }
                
                //Quede solo para referencia de uso de eval
//                if (key_exists('modelRelationConfig', $this->fieldsConfig[$field]["definition"])) {
//
//                        $modelRelationConfig = $this->fieldsConfig[$field]["definition"]['modelRelationConfig'];
//                        if (substr($modelRelationConfig,0,5)=='model'){
//                            eval("\$modelRelationConfig=\$this->".$modelRelationConfig);
//
//                            require_once "applications/{$this->config['flow']['app']}/modules/{$modelRelationConfig['module']}/models/model_{$modelRelationConfig['model']}.php";
//
//                            eval("\$relatedModel_{$modelRelationConfig['model']}= new {$modelRelationConfig['model']}Model(\$this->dataRep,\$this->config);");
//                            eval("\${$modelRelationConfig['model']}_tables=\$relatedModel_{$modelRelationConfig['model']}->tables ;");
//                            eval("\$relatedTables[]=\${$modelRelationConfig['model']}_tables;");
//
//                            eval("\$relatedOptions['where'][] =\"{$this->tables}.$field=\${$modelRelationConfig['model']}_tables.{\$relatedModel_{$modelRelationConfig['model']}->primaryKey}\";");
//                            eval("\$relatedFields[]=\"\${$modelRelationConfig['model']}_tables.{\$modelRelationConfig['field']} AS $field\";");
//                            $addField=false;
//                        }
//                }
                
                if (key_exists($field, $this->foreignKeys)) {
                    
                    $fkKeyField = $this->foreignKeys[$field]['keyField'];
                    $fkDataField = $this->foreignKeys[$field]['dataField'];
                    $fkModel = &$this->foreignKeys[$field]['model'];

                    $fkRelatedTables=$this->getRelatedTables($fkModel);
                    
                    foreach ($fkRelatedTables as $fkRelatedTable) {
                        $relatedTables[]=$fkRelatedTable;
                    }
                    
                    $fkRelatedConditions=$this->getRelatedConditions($this->tables.'.'.$field,$fkModel,$fkKeyField);
                    
                    foreach ($fkRelatedConditions as $fkRelatedCondition) {
                        $relatedOptions['where'][]=$fkRelatedCondition;
                    }                    
                    
                    
                    if (substr($fkDataField,0,1)=='_') { //It is a computed field
                        $fkDataField=substr($fkDataField, 1);
                        $relatedFields[]="$fkDataField AS $field";
                    }
                    else{
                        if ($addField)
                        $relatedFields[]="{$fkModel->tables}.$fkDataField AS $field";
                    }
                    
                    $addField=false;
                    
                }
            }
            
            if ($addField and $this->config['flow']['act']!='dataCall') {
                $relatedFields[]=$this->tables.'.'.$field;
            }
            
        }
        
         if (key_exists('fields', $options)) {
             
             foreach ($options['fields'] as $optionField) {
               if (substr($optionField, 0, 1) == '_') { //It is a computed field
                   $optionField = substr($optionField, 1);
                   $relatedFields[] = "$optionField";
               }
    
            }
             
        }
        
        if (count($options)) {
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
        }

        $tables=implode(',',$relatedTables);
        
        $options['fields']=$relatedFields;
        
        if (key_exists('where', $relatedOptions)) {
            foreach ($relatedOptions['where'] as $relatedCondition) {
                $options['where'][]=$relatedCondition;
            }
    
        }
        
        list($whereSql, $additionalSql, $fields) = $this->getSqlConf($options);
        
        $sql = "SELECT $fields FROM $tables $whereSql $additionalSql";

//        echo $sql;
        
        try {
                $query = $this->dataRep->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
//            echo $sql;
            echo $exc->getTraceAsString();
        }


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
    
//    protected function modelRelation($module,$model,$field,$id='') {
//        
//        return array(
//            'module'=>"$module",
//            'model'=>"$model",
//            'field'=>"$field",
//            'id'=>"$id",
//        );
//    
//    }
    
    function getRelatedTables(&$fkModel) {
        $relatedTables=array();
        $relatedTables[]=$fkModel->tables;
        
        foreach ($fkModel->foreignKeys as $foreignKey) {
            
            foreach ($fkModel->getRelatedTables($foreignKey['model']) as $fkRelatedTable) {
                $relatedTables[]=$fkRelatedTable;
            }
            
        }     
        
        return $relatedTables;
    }
    
    function getRelatedConditions($field,&$fkModel,$fkKeyField) {
        $relatedConditions=array();
        $relatedConditions[]="$field=$fkKeyField";
        
        foreach ($fkModel->foreignKeys as $foreignKey => $foreignKeyConfig ) {
            
            foreach ($fkModel->getRelatedConditions($fkModel->tables.'.'.$foreignKey,$foreignKeyConfig['model'],$foreignKeyConfig['keyField']) as $relatedCondition) {
                $relatedConditions[]=$relatedCondition;
            }
            
        }         
     
        
        return $relatedConditions;
        
    }
    
    
    function getFieldData($keyField,$dataField) {

        if (key_exists($dataField, $this->foreignKeys)) {
            
            $fkKeyField = $this->foreignKeys[$dataField]['keyField'];
            $fkDataField = $this->foreignKeys[$dataField]['dataField'];
            
            $fkModel = &$this->foreignKeys[$dataField]['model'];
            $results=$fkModel->getFieldData($fkKeyField,$fkDataField);
            return $results;
            
            
        } else {

            if (substr($dataField, 0, 1) == '_') { //It is a computed field
                $dataField = substr($dataField, 1);
            }            
            
            $options["fields"][] = "_$keyField AS relationId";
            $options["fields"][] = "_$dataField AS relationField";

            $resultData=$this->fetch($options);
            $resultData['label']=$this->fieldsConfig[$dataField]["definition"]["label"][$this->config["base"]["language"]];
            
            return $resultData;
        }
    }
    
}

?>
