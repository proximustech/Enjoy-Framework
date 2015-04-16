<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

    var $pbmFlow=array();
    
    function __conscruct($config) {
        parent::__construct($config);
        
        $this->bpmFlow=array(
            "initialState"=>"pendienteXagendar",
            "states"=>array(
                "pendienteXagendar"=>array(
                    "label"=>array(
                        "es_es"=>"Pendiente por agendar",
                    ),
                    "actions"=>array(
                        "agendar"=>array(
                            "label"=>array(
                                "es_es"=>"Solicitar",
                            ),
                        ),
                        "cancelarAgendamiento"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Agendamiento",
                            ),
                        ),
                    )
                ),
                "agendado"=>array(
                    "label"=>array(
                        "es_es"=>"Agendado",
                    ),
                    "actions"=>array(
                    ),
                ),
                "agendamientoCancelado"=>array(
                    "label"=>array(
                        "es_es"=>"Agendamiento Cancelado",
                    ),
                    "actions"=>array(
                    ),
                ),
            ),
        );
    }
    
    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function agendarAction() {
        $resultArray=array(
            "result"=>"agendado",
        );
        $this->resultData["output"]=json_encode($resultArray);
    }
    function cancelarAgendamientoAction() {
        $resultArray=array(
            "result"=>"agendamientoCancelado",
        );
        $this->resultData["output"]=json_encode($resultArray);        
    }    

}