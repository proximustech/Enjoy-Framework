<?php

class table_users {

    var $primaryKey = "id";
    var $fieldsConfig;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "options"=>array(),
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Serial",
                    ),                    
                ),
            ),
            
            "user_name" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "string",
//                    "widget" => "text",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Usuario",
                    ),
                ),
            ),
        );
    }
}

?>
