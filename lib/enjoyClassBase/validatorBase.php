<?php

class validatorBase {

    var $config;
    var $fieldsConfig;
    var $validations;
    var $baseAppTranslation;
    var $primaryKey;
    var $appLang;

    
    /**
     * Validates forms acording to a table definition
     * @param array $config general configuration
     * @param array $fieldsConfig table definition
     * @param string $primaryKey
     */
    
    function __construct($config, $fieldsConfig,$primaryKey) {
        $this->config = &$config;
        $this->fieldsConfig = &$fieldsConfig;
        $this->primaryKey = &$primaryKey;
        
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $this->appLang = $this->config["base"]["language"];
    }

    function validateField($field, $value) {

        if (is_array($value)) {
            return true; # Happends with submodels data
        }
        
        $options = $this->fieldsConfig[$field]["definition"]["options"];
        $type = $this->fieldsConfig[$field]["definition"]["type"];
        $label = $this->fieldsConfig[$field]["definition"]["label"][$this->appLang];
        $validationMessage=$label." ".$this->baseAppTranslation["fieldValidation"]." ";
        
        if (in_array("required", $options) and $value=="") {
            $validationMessage=$label." ".$this->baseAppTranslation["required"];
            return $validationMessage;
        }
        
        
        switch ($type) {
            case "file":
                return true;
                break;
            case "number":
                $validationMessage.=$this->baseAppTranslation["numericTypeValidation"];
                if (!is_nan($value)) {
                    return true;
                } else {
                    return $validationMessage;
                }
                break;
                
            case "date":
                $validationMessage.=$this->baseAppTranslation["dateTypeValidation"];
                //$format = $this->fieldsConfig[$field]["definition"]["format"];
                //$divisor=substr($format,1,1);//d-m-y, divisor = "-"
                $dateArray=explode("-", $value);
                
                $year=$dateArray[0];
                $month=$dateArray[1];
                $day=$dateArray[2];
                
                if (checkdate((int)$month,(int) $day,(int) $year)) {
                    return true;
                } else {
//                    return implode(',',$dateArray).$value;
                    return $validationMessage;
                }
                break;

            default:
                return true;
        }
    }

    
    /**
     * Validates each field of a register unless it is a fresh field ( fesh fields are used in subModels validations)
     * @param array $register
     * @return boolean
     */
    
    function validateFields($register,$freshFields=array()) {

        foreach ($this->fieldsConfig as $field => $config ) {
            
            if (substr($field, 0,5)!="enjoy" and $field != $this->primaryKey and !in_array($field,$freshFields)) {
    
                $validationResult = $this->validateField($field, $register[$field]);

                if ($validationResult !== true) {
                    return $validationResult;
                }
            }
            
        }
        
        return true;
    }

    
    /**
     * Validates a register relating the fields each other on the enjoy_registerConditions (table definition)
     * @param array $register
     * @return boolean
     */    
    function validateRegister($register) {

        if (key_exists("enjoy_registerConditions", $this->fieldsConfig)) {

            foreach ($this->fieldsConfig["enjoy_registerConditions"] as $conditionNumber => $conditionConfig) {
                $field1 = $conditionConfig["field1"];
                $field2 = $conditionConfig["field2"];
                $comparison = $conditionConfig["comparison"];
                $label = $conditionConfig["label"][$this->appLang];

                switch ($comparison) {
                    case "eq":
                        if ($register[$field1] == $register[$field2]) {
                            break;
                        } else {
                            return $label;
                        }
                        break;

                    case "low":
                        $type = $this->fieldsConfig[$field]["definition"]["type"];

                        if ($type == "number") {
                            if ($register[$field1] < $register[$field2]) {
                                break;
                            } else {
                                return $label;
                            }
                        }

                        if ($type == "string") {
                            if (strlen($register[$field1]) < strlen($register[$field2])) {
                                break;
                            } else {
                                return $label;
                            }
                        }

                        if ($type == "date") {
                            if (strtotime($register[$field1]) < strtotime($register[$field2])) {
                                break;
                            } else {
                                return $label;
                            }
                        }


                        break;

                    case "dif":
                        if ($register[$field1] != $register[$field2]) {
                            break;
                        } else {
                            return $label;
                        }
                        break;

                    default:
                        break;
                }
            }
            return true;
        }
        else{
            return true;
        }
    }

}