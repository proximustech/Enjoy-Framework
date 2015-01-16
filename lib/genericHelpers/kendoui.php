<?php

class grouperControl extends helper {

    public function __construct($incomingConfigArray) {
        
        //Particular properties definition
        
        //$this->defaultConfigArray["tag"]["varName"]="unset";
        $this->defaultConfigArray["script"]["expandMode"]="multiple";
        
        parent::__construct($incomingConfigArray);
        
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

?>
