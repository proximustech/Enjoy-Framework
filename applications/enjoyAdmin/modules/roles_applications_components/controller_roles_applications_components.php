<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends controllerBase {

    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    

}

?>
