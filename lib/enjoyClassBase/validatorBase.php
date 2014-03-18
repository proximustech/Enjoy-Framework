<?php

class validatorBase {

    var $config;
    var $fieldsConfig;
    var $validations;
    var $baseAppTranslation;
    var $primaryKey;
    var $appLang;

    function __construct($config, $fieldsConfig,$primaryKey) {
        $this->config = &$config;
        $this->fieldsConfig = &$fieldsConfig;
        $this->primaryKey = &$primaryKey;
        
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $this->appLang = $this->config["base"]["language"];
    }

    function validateField($field, $value) {

        $options = $this->fieldsConfig[$field]["definition"]["options"];
        $type = $this->fieldsConfig[$field]["definition"]["type"];
        $label = $this->fieldsConfig[$field]["definition"]["label"][$this->appLang];
        $validationMessage=$label." ".$this->baseAppTranslation["fieldValidation"]." ";
        
        if (in_array("required", $options) and $value=="") {
            $validationMessage=$label." ".$this->baseAppTranslation["required"];
            return $validationMessage;
        }
        
        switch ($type) {
            case "number":
                $validationMessage.=$this->baseAppTranslation["numericTypeValidation"];
                if (is_numeric($value)) {
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

    function validateFields($register) {

        foreach ($this->fieldsConfig as $field => $config) {
            
            if (substr($field, 0,5)!="enjoy" and $field != $this->primaryKey) {
    
                $validationResult = $this->validateField($field, $register[$field]);

                if ($validationResult !== true) {
                    return $validationResult;
                }
            }
            
        }
        
        return true;
    }

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