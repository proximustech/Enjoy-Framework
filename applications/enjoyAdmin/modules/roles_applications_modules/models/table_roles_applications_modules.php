<?php

class table_roles_applications_modules {

    var $primaryKey = "id";
    var $fieldsConfig;

    function __construct() {

        $this->fieldsConfig = array(
            "id" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Serial",
                    ),                    
                ),
            ),
            "id_role_app" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Rol y Aplicacion",
                    ),                    
                ),
            ),
            "id_module" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Modulo",
                    ),                    
                ),
            ),
            "permission" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "dataSourceArray"=>array(
                        "LVACR"=>"List,View,Add,Change,Remove",
                        "LVAC"=>"List,View,Add,Change",
                        "LVA"=>"List,View,Add",
                        "LV"=>"List,View",
                        "L"=>"List",
                        "A"=>"Add",
                    ),
                    "type" => "string",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Permisos",
                    ),
                ),
            ),
        );
    }

}

?>
