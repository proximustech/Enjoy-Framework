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
            "Acceso" => array(
                "Usuarios" => "index.php?app=enjoyAdmin&mod=users",
                "Roles" => "index.php?app=enjoyAdmin&mod=roles",
                "Aplicaciones" => "index.php?app=enjoyAdmin&mod=applications",
                "Roles y Aplicaciones" => "index.php?app=enjoyAdmin&mod=roles_applications",
                "Modulos de Aplicaciones" => "index.php?app=enjoyAdmin&mod=modules",
                "Componentes" => "index.php?app=enjoyAdmin&mod=components",
                "Permisos de Modulos" => "index.php?app=enjoyAdmin&mod=roles_applications_modules",
                "Permisos de Componentes" => "index.php?app=enjoyAdmin&mod=roles_applications_components",
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
