<?php

class table_tareas {

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
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "tarea" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Tarea",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "fecha_inicio" => array(
                "definition" => array(
                    "type" => "dateTime",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Fecha de Inicio",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "fecha_fin" => array(
                "definition" => array(
                    "type" => "dateTime",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Fecha de Finalizaci&oacute;n",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "comentarios" => array(
                "definition" => array(
                    "type" => "string",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Serial",
                    ),
                    "widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "id_proyectos" => array(
                "definition" => array(
                    "type" => "number",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Proyecto",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
        );
    }        
}   