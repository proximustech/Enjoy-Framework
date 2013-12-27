<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends controllerBase {

    function index() {
        $this->crud();
    }

}

?>
