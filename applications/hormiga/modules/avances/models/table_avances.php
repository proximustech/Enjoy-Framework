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
            "avance" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Avance",
                    ),
                    "widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "user_name" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Usuario",
                    ),
                    //"widget" => "textarea",
                ),
                "viewsPresence"=>array("list"),
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
                    "default" => "1",
                    "label" => array(
                        "es_es" => "Duraci&oacute;n en Minutos",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
        );
    }        
}   