<?php

class table_tasks {

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
            "task" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Tarea",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "projects_id" => array(
                "definition" => array(
                    "type" => "number",
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
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Detalles",
                    ),
                    "widget" => "textarea",
                ),
            ),
            "priority" => array(
                "definition" => array(
                    "type" => "string",
                    "dataSourceArray" => array(
                        "2"=>"Media",
                        "1"=>"Alta",
                        "3"=>"Baja",
                    ),
                    "label" => array(
                        "es_es" => "Prioridad",
                    ),
                ),
            ),
            "state" => array(
                "definition" => array(
                    "type" => "string",
                    "dataSourceArray" => array(
                        "1"=>"Pendiente",
                        "2"=>"Progreso",
                        "3"=>"Listo",
                    ),
                    "label" => array(
                        "es_es" => "Estado",
                    ),
                ),
            ),
        );
    }        
}   