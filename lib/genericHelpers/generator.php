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

class textBoxControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        
        parent::__construct($incomingConfigArray);
        
    }  
    
    public function getStartCode() {
        
        $code="         
        <table>
        ";

        return $code;
    }    

    public function getInnerCode($value) {
        
        $code="
            <tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <input class='eui_textBox' type='text' id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
            </td></tr>
        ";
        
        return $code;
    }

    public function getEndCode() {
        return "</table>";
    }
}

class xControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        $this->defaultConfigArray["control"]["tag"]="div";
        
        parent::__construct($incomingConfigArray);
        
    }  
    
    public function getStartCode() {
        $idString="";
        $nameString="";
        
        if (isset($this->configArray["control"]['name'])) {
            $idString=" id='".$this->configArray["control"]['name']."' ";
            $nameString=" name='".$this->configArray["control"]['name']."' ";
        }
        
        $code="         
        <{$this->configArray["control"]['tag']} $idString $nameString class='eui_{$this->configArray["control"]['tag']}' {$this->tagProperties}>
        ";

        return $code;
    }    

    public function getInnerCode($value) {
        
        $code=" $value ";
        return $code;
    }

    public function getEndCode() {
        return "</{$this->configArray["control"]['tag']}>";
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
            
            if (substr($key,1,1)=="_") {
                $key=substr($key,2);//Removing the numeric index and underscore of repeated controls in the same level
            }
            
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