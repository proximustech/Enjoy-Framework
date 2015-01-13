<?php

class containerControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        
        //$this->defaultConfigArray["tag"]["varName"]="unset";
        //$this->defaultConfigArray["script"]["active"]="false";
        
        parent::__construct($incomingConfigArray);
        
    }  
    
    public function getStartCode() {
       
        $code="         
        <div id='{$this->configArray["control"]['name']}' {$this->tagProperties}>
        ";

        return $code;
    }    

    public function getInnerCode($value) {
        
        $code=" $value ";
        return $code;
    }

    public function getEndCode() {
        return "</div>";
    }
}

class grouperControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        
        $this->defaultConfigArray["tag"]["varName"]="unset";
        
        //$this->defaultConfigArray["script"]["active"]="false"; //To be closed by default
        $this->defaultConfigArray["script"]["collapsible"]="true";
        $this->defaultConfigArray["script"]["animate"]="false";
        $this->defaultConfigArray["script"]["heightStyle"]="content";
        
        parent::__construct($incomingConfigArray);
        
    }  
    
    public function getStartCode() {
       
        $code="         
        <script>
        $(function() {
            $( '#{$this->configArray["control"]['name']}' ).accordion({{$this->scriptProperties}});
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

class labelControl extends helper {
    
    public function getStartCode() {
        return "<label {$this->tagProperties}>";
    }    

    public function getInnerCode($value) {
        return $this->configArray["control"]["value"];
    }

    public function getEndCode() {
        return "</label>";
    }
}


?>
