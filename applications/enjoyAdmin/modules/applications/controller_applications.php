<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends controllerBase {
    
    function indexAction() {

        $dataRepObject = new app_dataRep();
        $dataRep = $dataRepObject->getInstance();
        $model = new applicationsModel($dataRep, $this->config);       
        $this->crudAction($model,$dataRep);
        $dataRepObject->close();
        
    }
    
}

?>
