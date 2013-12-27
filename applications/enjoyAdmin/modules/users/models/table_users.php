<?php

class table_module {

    var $primaryKey = "id";
    var $fieldsConfig;
    var $registerConditions;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "options"=>array(),
                    "type" => "number",
                    "label" => array(
                        "es_es" => "Serial",
                    ),                    
                ),
            ),
            
            "user_name" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "string",
                    "default" => "usuario",
                    "label" => array(
                        "es_es" => "Usuario",
                    ),
                ),
            ),
            
            "password" => array(
                "definition" => array(
                    "options"=>array("password","required"),
                    "type" => "string",
                    "default" => date("Y-m-d"),
                    "label" => array(
                        "es_es" => "Clave",
                    ),                    
                ),
            ),

            "enjoy_registerConditions" => array(
                0 => array (
                    "field1"=>"user_name",
                    "field2"=>"password",
                    "comparison"=>"dif",
                    "label" => array(
                        "es_es" => "La clave debe ser diferente al nombre de usuario",
                    ),                            
                ),
            ),
        );
    }
}

?>
