<?php

class table_roles_applications {

    var $primaryKey = null;
    var $fieldsConfig;

    function __construct() {

        $this->fieldsConfig = array(
            "id_role" => array(
                "definition" => array(
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "",
                    ),                    
                ),
            ),
            "id_app" => array(
                "definition" => array(
                    "options"=>array("required"),
                    "type" => "number",
                    "default" => "",
                    "label" => array(
                        "es_es" => "",
                    ),
                ),
            ),
        );
    }

}

?>
