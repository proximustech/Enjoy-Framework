<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends controllerBase {

    function indexAction() {
        $this->crudAction($this->baseModel,$this->dataRep);
    }
    
//    function dataCall() {
//    
//        $resultData=$this->model->dataCall();
//        $this->resultData['output']=json_encode($resultData);
//        
//    }

}

?>
