<?php

class table_roles_applications_components {

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
            "id_component" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Componente",
                    ),                    
                ),
            ),
            "permission" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "bool",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Permiso",
                    ),
                ),
            ),
        );
    }

}

?>
