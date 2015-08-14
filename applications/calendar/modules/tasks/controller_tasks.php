<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {
    
    function __construct(&$config) {
       
        $this->bpmFlow=array(
            "initialState"=>"pendienteXagendar",
            "defaultInfo"=>array(),
            "states"=>array(
                "pendienteXagendar"=>array(
                    "label"=>array(
                        "es_es"=>"Sin Asignar no joda !!",
                    ),
                    "actions"=>array(
                        "agendar"=>array(
                            "label"=>array(
                                "es_es"=>"Asignar",
                            ),
                            "results"=>array('agendado'),
                        ),
                        "noAgendar"=>array(
                            "label"=>array(
                                "es_es"=>"No Agendar",
                            ),
                            "results"=>array('agendamientoCancelado'),
                            "roles"=>array('invitado'),
                        ),
                    )
                ),
                "agendado"=>array(
                    "label"=>array(
                        "es_es"=>"Asignado",
                    ),
                    "actions"=>array(
                        "desAgendar"=>array(
                            "label"=>array(
                                "es_es"=>"Dar de baja la asignacion",
                            ),
                            "results"=>array('desAgendado'),
                        ),                        
                    ),
                ),
                "agendamientoCancelado"=>array(
                    "label"=>array(
                        "es_es"=>"Agendamiento Cancelado",
                    ),
                    "actions"=>array(
                    ),
                ),
                "desAgendado"=>array(
                    "label"=>array(
                        "es_es"=>"Asignamiento dado de baja",
                    ),
                    "actions"=>array(
                    ),
                ),
            ),
        );
        
        parent::__construct($config);
    }
    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function agendarAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function desAgendarAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function noAgendarAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }    
}