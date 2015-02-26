<?php

class grouperControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]["name"]="";
        $this->defaultConfigArray["control"]["caption"]="true";
        $this->defaultConfigArray["control"]["expanded"]="true";
        
        $this->defaultConfigArray["script"]["collapsible"]="true";
        $this->defaultConfigArray["script"]["animate"]="false";
        $this->defaultConfigArray["script"]["heightStyle"]="content";
        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getStartCode() {
       
        $expandedCode="";
        
        if ($this->configArray["control"]['expanded']=="false") {
            $expandedCode="active:false,"; //To be closed by default
        }          
        
        $code="         
        <script>
        $(function() {
            $( '#{$this->configArray["control"]['name']}' ).accordion({ $expandedCode {$this->scriptProperties}});
        });
        </script> 

        <div id='{$this->configArray["control"]['name']}' {$this->tagProperties}>
        ";

        return $code;
    }    

    public function getInnerCode($value) {
        
        $code=" 
        <h3>{$this->configArray["control"]['caption']}</h3>
	<div>
		<p>$value</p>
	</div>            
        ";
        
        return $code;
    }

    public function getEndCode() {
        return "</div>";
    }
}

class dateTimeControl extends helper {

    public function __construct($incomingConfigArray,$incomingDataArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["control"]["name"]="";
        $this->defaultConfigArray["control"]["caption"]="";
        $this->defaultConfigArray["control"]["captionWidth"]="100px";
        
        $this->defaultConfigArray["script"]["showOn"]="button";
        $this->defaultConfigArray["script"]["buttonImage"]="assets/images/icons/calendar.png";
        $this->defaultConfigArray["script"]["showOtherMonths"]="true";
        $this->defaultConfigArray["script"]["selectOtherMonths"]="true";
        $this->defaultConfigArray["script"]["showButtonPanel"]="true";
        $this->defaultConfigArray["script"]["changeYear"]="true";
        $this->defaultConfigArray["script"]["changeMonth"]="true";
        $this->defaultConfigArray["script"]["dateFormat"]="yy-mm-dd";
        $this->defaultConfigArray["script"]["timeFormat"]="HH:mm";

        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
       
       
        
        $code="
            
        <script>
            jQuery( 
                function( ) { 
                    $( '#{$this->configArray["control"]['name']}' ).datetimepicker({
                        {$this->scriptProperties}
                    });
                }
            );
        </script>

        <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
        <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
        </td>
        <td>
        <input class='eui_textBox' type='text' name='{$this->configArray["control"]['name']}' id='{$this->configArray["control"]['name']}' value='$value' readonly {$this->tagProperties}>
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
        
        $this->defaultConfigArray["script"]["showOn"]="button";
        $this->defaultConfigArray["script"]["buttonImage"]="assets/images/icons/calendar.png";
        $this->defaultConfigArray["script"]["showOtherMonths"]="true";
        $this->defaultConfigArray["script"]["selectOtherMonths"]="true";
        $this->defaultConfigArray["script"]["showButtonPanel"]="true";
        $this->defaultConfigArray["script"]["changeYear"]="true";
        $this->defaultConfigArray["script"]["changeMonth"]="true";
        $this->defaultConfigArray["script"]["dateFormat"]="yy-mm-dd";

        
        parent::__construct($incomingConfigArray,$incomingDataArray);
        
    }  
    
    public function getInnerCode($value) {
       
       
        
        $code="
            
        <script>
            jQuery( 
                function( ) { 
                    $( '#{$this->configArray["control"]['name']}' ).datepicker({
                        {$this->scriptProperties}
                    });
                }
            );
        </script>

        <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
        <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
        </td>
        <td>
        <input class='eui_textBox' type='text' name='{$this->configArray["control"]['name']}' id='{$this->configArray["control"]['name']}' value='$value' readonly {$this->tagProperties}>
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
            $control="multiselect";
            if (!isset($this->configArray['tag']['multiple'])) {
                $this->configArray['tag']['multiple']='multiple';
                $this->configArray['tag']['class']='multiselect';
                unset($this->configArray['tag']['style']);
                $this->parseTagProperties();
                $additionalNameText='[]';
            }            
        }
        else{

            $additionalNameText='';
            if ($this->configArray["control"]['autoComplete']=="true") {
                $control="combobox";
            }
            else{
                $control="selectmenu";
            }            
        }
        
        $code="
            <script>
                $(function() {
                    $('#{$this->configArray["control"]['name']}').$control();
                });
            </script>
            <table><tr><td style='width:{$this->configArray["control"]['captionWidth']}'>
            <label class='eui_label'>{$this->configArray["control"]['caption']}</label>
            </td>
            <td>
            <div class='ui-widget'>
            <select  id='{$this->configArray["control"]['name']}' name='{$this->configArray["control"]['name']}$additionalNameText' {$this->tagProperties}>
            
        ";

        return $code;
            
    }
    
    public function getInnerCode($value) {       
        return $this->incomingDataArray["value"];
    }
    
    public function getEndCode() {
     
        $code="</select></div></td></tr></table>";
        return $code;
        
    }

}

?>
