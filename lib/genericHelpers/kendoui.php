<?php

class grouperControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]["name"]="";
        $this->defaultConfigArray["control"]["caption"]="true";
        $this->defaultConfigArray["control"]["expanded"]="true";
        
        $this->defaultConfigArray["script"]["expandMode"]="multiple";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getStartCode() {
        
        $expandedCode="";
        
        if ($this->configArray["control"]['expanded']=="true") {
            $expandedCode=" 
                var panelBar{$this->configArray["control"]['name']} = $('#{$this->configArray["control"]['name']}').data('kendoPanelBar');
                panelBar{$this->configArray["control"]['name']}.expand($('#{$this->configArray["control"]['name']}_item1'));    
            ";
        }
        
        $code="         
        <script>
        $(function() {
            $( '#{$this->configArray["control"]['name']}' ).kendoPanelBar({{$this->scriptProperties}});
            $expandedCode
        });
        </script> 

        <ul id='{$this->configArray["control"]['name']}' {$this->tagProperties}>
        ";

        return $code;
    }    

    public function getInnerCode($value) {
        
        $code=" 
            <li id='{$this->configArray["control"]['name']}_item1'>
                {$this->configArray["control"]['caption']}
                <div style='padding: 10px'>
                    $value
                </div>            
            </li>
        ";
        
        return $code;
    }

    public function getEndCode() {
        return "</ul>";
    }
}

class dateTimeControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]["name"]="";
        $this->defaultConfigArray["control"]["caption"]="";
        $this->defaultConfigArray["control"]["captionWidth"]="100px";
        
        $this->defaultConfigArray["script"]["format"]="yyyy-MM-dd HH:mm";        
        
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
       
       
        
        $code="
            
        <script>
            $(document).ready( 
                function( ) { 
                    $( '#{$this->configArray["control"]['name']}' ).kendoDateTimePicker({
                        {$this->scriptProperties}
                    }).attr('readonly', 'readonly');;
                }
            );
        </script>

        <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
        <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
        </td>
        <td>
        <input class='eui_textBox' type='text' name='{$this->configArray["control"]['name']}' id='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
        </td></tr></table>
        ";

        return $code;
    }    

}
class dateControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]["name"]="";
        $this->defaultConfigArray["control"]["caption"]="";
        $this->defaultConfigArray["control"]["captionWidth"]="100px";
        
        $this->defaultConfigArray["script"]["format"]="yyyy-MM-dd";        
        
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
       
       
        
        $code="
            
        <script>
            $(document).ready( 
                function( ) { 
                    $( '#{$this->configArray["control"]['name']}' ).kendoDatePicker({
                        {$this->scriptProperties}
                    }).attr('readonly', 'readonly');;
                }
            );
        </script>

        <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
        <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
        </td>
        <td>
        <input class='eui_textBox' type='text' name='{$this->configArray["control"]['name']}' id='{$this->configArray["control"]['name']}' value='$value' {$this->tagProperties}>
        </td></tr></table>
        ";

        return $code;
    }    

}

class selectControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]['name']="";
        $this->defaultConfigArray["control"]['caption']="";
        $this->defaultConfigArray["control"]['captionWidth']="100px";
        $this->defaultConfigArray["control"]['autoComplete']="true";
        $this->defaultConfigArray["control"]['multiple']="false";
        
        $this->defaultConfigArray["tag"]['style']="width:200px";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getStartCode() {
        
        
        if ($this->configArray["control"]['multiple']=="true") {
            
            $additionalNameText='[]';
            $control="kendoMultiSelect";
            $additionalDefinition=".data('kendoMultiSelect')";
            
            if (!isset($this->configArray['tag']['multiple'])) {
                $this->configArray['tag']['multiple']='multiple';
                $this->parseTagProperties();
            }
            if (!isset($this->configArray['script']['filter'])) {
                $this->configArray['script']['filter']='contains';
                $this->parseScriptProperties();
            }
        
        }
        else{
            $additionalNameText='';
            if ($this->configArray["control"]['autoComplete']=="true") {
                $control="kendoComboBox";
                if (!isset($this->configArray['script']['filter'])) {
                    $this->configArray['script']['filter']='contains';
                    $this->parseScriptProperties();
                }
            }
            else{
                $control="kendoDropDownList";
            }
            $additionalDefinition="";
        }
        
        $code="
            
            <script>
                $(function() {
                    $('#{$this->configArray["control"]['name']}').$control({{$this->scriptProperties}})$additionalDefinition;
                });
            </script>

            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <select  id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}$additionalNameText' {$this->tagProperties}>
            
        ";

        return $code;
            
    }
    
    public function getInnerCode($value) {       
        return $this->incomingDataArray["value"];
    }
    
    public function getEndCode() {
     
        $code="</select></td></tr></table>";
        return $code;
        
    }

}

?>
