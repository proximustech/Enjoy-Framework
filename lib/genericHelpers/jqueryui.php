<?php

class grouperControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        
        //$this->defaultConfigArray["tag"]["varName"]="unset";
                
        $this->defaultConfigArray["script"]["collapsible"]="true";
        $this->defaultConfigArray["script"]["animate"]="false";
        $this->defaultConfigArray["script"]["heightStyle"]="content";
        
        parent::__construct($incomingConfigArray);
        
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


?>
