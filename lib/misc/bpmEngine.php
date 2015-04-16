<?php

class bpm {
    
    private $bpmName=null;
    private $bpmFlow=array();
    private $bpmModel=array();
    private $bpmState=null;
    private $processId=null;
    
    public function __construct($bpmName,$bpmFlow,$bpmModel,$processId) {
        $this->bpmName=$bpmName;
        $this->bpmFlow=$bpmFlow;
        $this->bpmModel=$bpmModel;
        $this->processId=$processId;
    }
    

}

?>
