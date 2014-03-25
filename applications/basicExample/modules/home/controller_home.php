<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';
require_once 'applications/basicExample/modules/home/models/model_home.php';

class modController extends controllerBase {

    function indexAction() {
        $model = new homeModel();
        $this->resultData["output"]["salutations"]=$model->getSalutations();
    }
    

}

?>
