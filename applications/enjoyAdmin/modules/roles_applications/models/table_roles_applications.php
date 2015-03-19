<?php

class table_roles_applications {

    var $primaryKey = 'id';
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
            "id_role" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Rol",
                    ),                    
                ),
            ),
            "id_app" => array(
                "definition" => array(
//                    "options"=>array("required"),
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "Aplicaci&oacute;n",
                    ),
                ),
            ),
        );
    }

}

?>
