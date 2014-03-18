<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends baseController {

    function indexAction() {
        $dataRepObject = new app_dataRep();
        $dataRep = $dataRepObject->getInstance();
        $model = new rolesModel($dataRep, $this->config);       
        $this->crudAction($model,$dataRep);
        $dataRepObject->close();
    }
    
//    function dataCall() {
//        $dataRepObject = new app_dataRep();
//        $dataRep = $dataRepObject->getInstance();
//        $model = new rolesModel($dataRep, $this->config);       
//        $dataRepObject->close();
//        
//        $resultData=$model->dataCall();
//              
//        $this->resultData['output']=json_encode($resultData);
//        
//    }

}

?>
