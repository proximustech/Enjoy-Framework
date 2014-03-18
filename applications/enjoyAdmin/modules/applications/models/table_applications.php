<?php

class table_applications {

    var $primaryKey = "id";
    var $fieldsConfig;
    var $registerConditions;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Serial",
                    ),                    
                ),
            ),
            "name" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "string",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Aplicacion",
                    ),
                ),
            ),
        );
    }

}

?>
