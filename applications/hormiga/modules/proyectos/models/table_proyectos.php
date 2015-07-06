<?php

class table_proyectos {

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
            "proyecto" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Proyecto",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("createForm","editForm","editFkForm"),
            ),
            "prioridad" => array(
                "definition" => array(
                    "type" => "number",
                    "options"=>array("required"),
                    "default" => "30",
                    "dataSourceArray" => array(
                        "10" => "10-Alta",
                        "20" => "20-Media Alta",
                        "30" => "30-Media",
                        "40" => "40-Media Baja",
                        "50" => "50-Baja",
                    ),
                    "label" => array(
                        "es_es" => "Prioridad",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("createForm","editForm","editFkForm"),
            ),            
            "fecha_registro" => array(
                "definition" => array(
                    "type" => "date",
                    "options"=>array("required"),
                    "default" => date("Y-m-d"),
                    "label" => array(
                        "es_es" => "Fecha de Registro",
                    ),
                    //"widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
            "fecha_inicio" => array(
                "definition" => array(
                    "type" => "date",
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
                    "type" => "date",
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
                        "es_es" => "Comentarios",
                    ),
                    "widget" => "textarea",
                ),
                //"viewsPresence"=>array("list","createForm","editForm","editFkForm"),
            ),
        );
    }        
}   