<?php

class table_element_relations {

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
            "parent_id" => array(
                "definition" => array(
                    "type" => "number",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Padre",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "child_id" => array(
                "definition" => array(
                    "type" => "number",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Hijo",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "comment" => array(
                "definition" => array(
                    "type" => "string",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Comentario",
                    ),
                    "widget" => "textarea",
                ),
            ),
        );
    }        
}   