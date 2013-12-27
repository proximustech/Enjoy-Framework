<?php

class table_module {

    var $primaryKey = "id";
    var $fieldsConfig;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "type" => "number",
                    "label" => array(
                        "es_es" => "Serial",
                    ),                    
                ),
            ),
            "name" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "string",
                    "default" => "rol",
                    "label" => array(
                        "es_es" => "Rol",
                    ),
                ),
            ),
        );
    }

}

?>
