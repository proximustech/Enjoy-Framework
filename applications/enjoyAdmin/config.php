<?php

//Application Configuration

$config=array(
    "base"=>array(
        "appTitle"=>array(
            "es_es"=>"Administraci&oacute;n de Enjoy",
        ),
        "appIcon"=>"assets/images/icons/icon_32_computer.png",
        "enjoyHelper"=>"jqueryui",
        "language"=>"es_es",
        "defaultModule"=>"users",
        "defaultAction"=>"index",
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50",
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Registro" => array(
                "Usuarios" => "",
                "Perfiles" => "",
            ),
        ),

        
    ),
    
)

?>
