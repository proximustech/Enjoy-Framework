<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

    function __construct(&$config) {
       
        $this->bpmFlow=array(
            "bpmModel"=>"tareas",
            "initialState"=>"pendiente",
            "defaultInfo"=>array(),
            "states"=>array( //The diferent states that the process can have
                "pendiente"=>array(
                    "label"=>array(
                        "es_es"=>"Pendiente",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "activar"=>array(
                            "label"=>array(
                                "es_es"=>"Activar",
                            ),
                            "results"=>array("activado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Tarea",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),
                    )
                ),
                "activado"=>array(
                    "label"=>array(
                        "es_es"=>"Activado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "pausar"=>array(
                            "label"=>array(
                                "es_es"=>"Pausar",
                            ),
                            "results"=>array("pausado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Tarea",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),
                        "finalizar"=>array(
                            "label"=>array(
                                "es_es"=>"Finalizar",
                            ),
                            "results"=>array("finalizado"),//array of possible result states
                        ),
                    )
                ),
                "finalizado"=>array(
                    "label"=>array(
                        "es_es"=>"Finalizado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "encolar"=>array(
                            "label"=>array(
                                "es_es"=>"Marcar como Pendiente",
                            ),
                            "results"=>array("pendiente"),//array of possible result states
                        ),                        
                    ),
                ),                
                "pausado"=>array(
                    "label"=>array(
                        "es_es"=>"Pausado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "activar"=>array(
                            "label"=>array(
                                "es_es"=>"Despausar",
                            ),
                            "results"=>array("activado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Tarea",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),                        
                    ),
                ),                
                "cancelado"=>array(
                    "label"=>array(
                        "es_es"=>"Cancelado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "encolar"=>array(
                            "label"=>array(
                                "es_es"=>"Marcar como Pendiente",
                            ),
                            "results"=>array("pendiente"),//array of possible result states
                        ),
                    ),
                ),                
            ),
        );
        
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