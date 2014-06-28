<?php

class table_projects {

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
            "project" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Proyecto",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "details" => array(
                "definition" => array(
                    "type" => "string",
//                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Detalles",
                    ),
                    "widget" => "textarea",
                ),
            ),
        );
    }        
}   