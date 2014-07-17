<?php

class table_sections {

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
            "portals_id" => array(
                "definition" => array(
                    "type" => "number",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Portal",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "section" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Seccion",
                    ),
                    //"widget" => "textarea",
                ),
            ),
        );
    }        
}   