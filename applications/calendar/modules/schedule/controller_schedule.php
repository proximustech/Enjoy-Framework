<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function calendarListAction() {
        
        if ($this->config['permission']['list']) {
            $events=$this->baseModel->calendarList();
            $finalResult['events']=$events;
            $finalResult['issort']=true;
    //        $finalResult['start']=date('m/d/Y H:i');
    //        $finalResult['end']=date('m/d/Y H:i');
            $finalResult['error']=null;
            $this->resultData['output']=json_encode($finalResult);
        }
        
    }

}