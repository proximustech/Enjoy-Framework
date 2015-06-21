<?php

class table_avances {

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
                "viewsPresence"=>array("createForm","editForm","editFkForm"),
            ),
            "fecha_inicio" => array(
                "definition" => array(
                    "type" => "dateTime",
                    "options"=>array("required"),
                    "default" => date("Y-m-d H:i:s"),
                    "label" => array(
                        "es_es" => "Fecha de Inicio",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "duracion_minutos" => array(
                "definition" => array(
                    "type" => "number",
                    //"options"=>array("required"),
                    "default" => "0",
                    "label" => array(
                        "es_es" => "Duraci&oactue;n en Minutos",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "comentarios" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Comentarios",
                    ),
                    "widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "id_tareas" => array(
                "definition" => array(
                    "type" => "number",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Tarea",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "id_usuarios" => array(
                "definition" => array(
                    "type" => "number",
                    //"options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Usuario",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
        );
    }        
}   