<?php

class table_info_types {

    var $primaryKey = "id";
    var $fieldsConfig;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "type" => "number",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Serial",
                    ),
                    //"widget" => "textarea",
                ),
            ),
        );
    }        
}   