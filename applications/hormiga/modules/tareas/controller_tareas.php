<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

    function __construct(&$config) {
        $this->bpmFlow=require_once 'applications/hormiga/modules/tareas/bpm_tareas.php';
        parent::__construct($config);
    }
    
    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function encolarAction() {
        $this->indexAction();
    }
    function activarAction() {
        $this->indexAction();
    }
    function pausarAction() {
        $this->indexAction();
    }
    function finalizarAction() {
        $this->indexAction();
    }
    function cancelarAction() {
        $this->indexAction();
    }    

}