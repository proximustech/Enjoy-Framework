<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

/*
    function __construct(&$config) {
       
        $this->bpmFlow=array(
            "initialState"=>"someState",
            "defaultInfo"=>array(),
            "states"=>array( //The diferent states that the process can have
                "state1"=>array(
                    "label"=>array(
                        "es_es"=>"",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "action1"=>array(
                            "label"=>array(
                                "es_es"=>"",
                            ),
                            "results"=>array(""),//array of possible result states
                        ),
                    )
                ),
            ),
        );
        
        parent::__construct($config);
    }

*/
    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }

}