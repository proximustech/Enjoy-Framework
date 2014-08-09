<?php

class table_articles {

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
            "title" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Titulo",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "topics_id" => array(
                "definition" => array(
                    "type" => "number",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Portal - Seccion - Tema",
                    ),
                    //"widget" => "textarea",
                ),
            ),            
            "body" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Cuerpo",
                    ),
                    "widget" => "textarea",
                ),
            ),
            "active" => array(
                "definition" => array(
                    "type" => "bool",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Activo",
                    ),
                    //"widget" => "textarea",
                ),
            ),
        );
    }        
}   