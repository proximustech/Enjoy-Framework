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
        "useAuthentication"=>true, //Defines if the application use permissions schema
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50000",
        "crud_encryptPrimaryKeys"=>true,
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Roles" => "index.php?app=enjoyAdmin&mod=roles",
            "Usuarios" => "index.php?app=enjoyAdmin&mod=users",
            "Aplicaciones" => "index.php?app=enjoyAdmin&mod=applications",
            "Modulos de Aplicaciones" => "index.php?app=enjoyAdmin&mod=modules",
            "Permisos de Modulos" => "index.php?app=enjoyAdmin&mod=roles_applications_modules",
            "Componentes de Aplicaciones" => "index.php?app=enjoyAdmin&mod=components",
            "Permisos de Componentes" => "index.php?app=enjoyAdmin&mod=roles_applications_components",
            "Sitios Web" => array(
                "Enjoy" => "http://www.enjoyframework.com/",
            ),
        ),

        
    ),
    
)

?>
