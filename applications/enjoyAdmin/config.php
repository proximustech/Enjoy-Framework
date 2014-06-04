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
        "errorLog"=>true,
        "debug"=>true,
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50",
        "crud_encryptPrimaryKeys"=>true,
        
    ),
    "custom"=>array(
        "controlPath"=>"control/",
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Registro" => array(
                "Usuarios" => "index.php?app=enjoyAdmin&mod=users",
                "Roles" => "index.php?app=enjoyAdmin&mod=roles",
                "Aplicaciones" => "index.php?app=enjoyAdmin&mod=applications",
            ),
            "Sitios" => array(
                "Asterisk" => array(
                    "Digium" => "http://www.digium.com/",
                ),
            ),
        ),

        
    ),
    
)

?>
