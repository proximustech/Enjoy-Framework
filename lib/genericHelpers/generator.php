<?php

/**
 * Extended by the specific helper, specifyes the skeleton of a helper control
 */
class helper {

    var $defaultConfigArray=[];
    var $incomingConfigArray;
    var $incomingDataArray;
    var $configArray=[]; //The final config used to generate the control
    
    var $tagProperties; //string form
    var $scriptProperties; //string form

    
    function __construct($incomingConfigArray,$incomingDataArray) {
        $this->incomingConfigArray=$incomingConfigArray;
        $this->incomingDataArray=$incomingDataArray;
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
        $this->tagProperties='';
        foreach ($this->configArray["tag"] as $key => $value) {
            if ($key != "value") {
                if ($value=="") {
                    $this->tagProperties.=" $key ";
                }
                else{
                    $this->tagProperties.=" $key=\"$value\" ";
                }
            }
        }
    }
    
    
    /**
     * Conforms the script configuration into a string
     */
    
    function parseScriptProperties() {
        $this->scriptProperties='';
        foreach ($this->configArray["script"] as $key => $value) {
            
            #if $value starts with "s_" means that it is javascript code and not just a javascript value
            if ($value != "true" and $value != "false" and !is_numeric($value) and substr($value,0,2) != 's_') {
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

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        $this->defaultConfigArray["control"]['password']="false";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
        
        if ($this->configArray["control"]['password']=="true") {
            $type="password";
        }
        else{
            $type="text";
        }
        
        
        $code="
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <input class='eui_textBox' type='$type' id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
            </td></tr></table>
        ";
        
        return $code;
    }

}

class checkBoxControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
        
        $code="
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <input type='checkbox' id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
            </td></tr></table>
        ";
        
        return $code;
    }

}

class fileControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
        
        $code="
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <input type='file' id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}' {$this->tagProperties}>
            </td></tr></table>
        ";
        
        return $code;
    }

}

class textAreaControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
        
        $code="
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <textarea id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}' {$this->tagProperties}>$value</textarea>
            </td></tr></table>
        ";
        
        return $code;
    }

}

class radioControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
        
        $code="
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <input type='radio' name='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
            </td></tr></table>
        ";
        
        return $code;
    }

}

class xControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        $this->defaultConfigArray["control"]["tag"]="div";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
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

    
    function getCode($uiJson,$dataArray) {
        $code=json_decode($uiJson,true);
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
        return $this->getElementCode($code,$dataArray);
    }
    
    /**
     * Returns the HTML and JavaScript code converted from the JSON
     * @param String $elementCode in JSON format
     * @return String
     */
    
    function getElementCode($elementCode,$dataArray) {
        
        $finalCode="";
        foreach ($elementCode as $key => $data) {
            
            $originalKey=$key;
            $keyArray=explode("_", $key);
            if (count($keyArray) > 1) {
                $key=$keyArray[1];//Removing the numeric index and underscore of repeated controls in the same level
            }
            
            if (class_exists($key)){  //checks if $configVar is not an element property but an element control.
                
                $elementControlName=$key;
                if (isset($dataArray[$originalKey])) {
                    $controlDataArray=$dataArray[$key];
                }
                else $controlDataArray = array();
                
                $elementControl= new $elementControlName($data,$controlDataArray);
                
                $finalCode.=$elementControl->getStartCode();
                
                if (is_array($data["value"])) { //means that the property value has elements inside
                    $value=$this->getElementCode($data["value"],$controlDataArray);
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