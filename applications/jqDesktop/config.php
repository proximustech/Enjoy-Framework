<?php

//Application Configuration

$config=array(
    "base"=>array(
        "enjoyHelper"=>"jqueryui",
        "language"=>"es_es",
        "defaultModule"=>"home",
        "defaultAction"=>"login",
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50",
        
    ),
    "custom"=>array(
        "defaultDesktop"=>"enjoyAdminTools",
        "desktops"=>array(
            "enjoyAdminTools"=>array(
                "apps"=>array(
                    "enjoyAdmin",
                ),

            ),
            "userApps"=>array(
                "apps"=>array(
                    "calendar",
                ),

            ),
            
        ),
        "topMenuConfig"=>array(
            "es_es"=> array(
                //Initial Menus
                "Men&uacute; Principal"=>array(
                    //submenu => desktop
                    "Herramientas Administrativas"=>"enjoyAdminTools",
                    "Programas de Usuario"=>"userApps",

                ),
            ),
            
        ),
        
    ),
    
)

?>
