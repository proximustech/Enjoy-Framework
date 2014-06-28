<?php

class table_schedule {

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
            "scheduling" => array(
                "definition" => array(
                    "type" => "string",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Agendamiento",
                    ),
                    //"widget" => "textarea",
                ),
            ),
            "event" => array(
                "definition" => array(
                    "type" => "dateTime",
                    "options"=>array("required"),
                    "default" => "",
                    "label" => array(
                        "es_es" => "Evento",
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
        );
    }        
}   