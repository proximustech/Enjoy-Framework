<?php

/**
 * Extended by the specific helper, specifyes the skeleton of a helper control
 */
class helper {

    var $defaultConfigArray=[];
    var $incomingConfigArray;
    var $configArray=[]; //The final config used to generate the control
    
    var $tagProperties; //string form
    var $scriptProperties; //string form

    
    function __construct($incomingConfigArray) {
        $this->incomingConfigArray=$incomingConfigArray;
        $this->parseProperties();
        $this->confirmProperties();
        $this->parseScriptProperties();
        $this->parseTagProperties();
    }
    
    /**
     * Discriminates config properties between tag and script ones
     */
    
    public function parseProperties() {
        foreach ($this->incomingConfigArray as $key => $value) {
            if (substr($key,0,2)=="s_") {
                $this->configArray["script"][substr($key,2)]=$value;//deleting the precedig "s_"
            } 
            else if (substr($key,0,2)=="t_"){
                $this->configArray["tag"][substr($key,2)]=$value;
            }
            else{
                $this->configArray["control"][$key]=$value;
            }
        }
        unset ($this->incomingConfigArray);
    }
    
    

    /**
     * Mix the incoming control configuration with the default configuration
     */
    
    function confirmProperties() {
        //confirming defaults properties if not defined
        foreach ($this->defaultConfigArray as $configType => $configArray) {
            foreach ($configArray as $key => $value) {
                if (!isset($this->configArray[$configType][$key])) {
                    $this->configArray[$configType][$key]=$value;
                }
            }
        }
    }
    
    /**
     * Conforms the tag configuration into a string
     */
    
    public function parseTagProperties() {
        foreach ($this->configArray["tag"] as $key => $value) {
            if ($key != "value") {
                $this->tagProperties.=" $key='$value' ";
            }
        }
    }
    
    
    /**
     * Conforms the script configuration into a string
     */
    
    function parseScriptProperties() {
        
        foreach ($this->configArray["script"] as $key => $value) {
            if ($value != "true" and $value != "false" and !is_numeric($value)) {
                $value="'$value'";
            }
            
            $this->scriptProperties.=$key.":".$value.",";
        }        
        
    }
    
    /**
     * Returns the beging part of the control code
     * @return string
     */
    
    public function getStartCode() {
        return "";
    }

    /**
     * Returns the inner part of the control code
     * @return string
     */
    public function getInnerCode($value) {
        return "<!-- unknown Helper Element -->";
    }

    /**
     * Returns the last part of the control code
     * @return string
     */
    public function getEndCode() {
        return "";
    }



}

//Exposing the selected helper controls
require_once "lib/genericHelpers/{$enjoyHelper}.php";

class uiGenerator {

    function getCode($json) {
        $code=json_decode($json,true);
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                echo ' - JSON:Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - JSON:Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - JSON:Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - JSON:Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - JSON:Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:

            break;
        }
        return $this->getElementCode($code);
    }
    
    /**
     * Returns the HTML and JavaScript code converted from the JSON
     * @param String $elementCode in JSON format
     * @return String
     */
    
    function getElementCode($elementCode) {
        
        $finalCode="";
        foreach ($elementCode as $key => $data) {
            if (class_exists($key)){  //checks if $configVar is not an element property but an element control.
                
                $elementControlName=$key;
                $elementControl= new $elementControlName($data);
                
                $finalCode.=$elementControl->getStartCode();
                
                if (is_array($data["value"])) { //means that the property value has elements inside
                    $value=$this->getElementCode($data["value"]);
                }
                else{
                    $value=&$data["value"];
                }
                
                $finalCode.=$elementControl->getInnerCode($value);
                
                $finalCode.=$elementControl->getEndCode();
            }
            
        }
        return $finalCode;
        
    }

}

?>
