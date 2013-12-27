<?php

//Application Configuration

$config=array(
    "base"=>array(
        "enjoyHelper"=>"jqueryui",
        "language"=>"es_es",
        "defaultModule"=>"home",
        "defaultAction"=>"index",
        
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
            "salud"=>array(
                "apps"=>array(
                    "enjoyAdmin",
                ),

            ),
            
        ),
        "topMenuConfig"=>array(
            "es_es"=> array(
                //Initial Menus
                "Enjoy"=>array(
                    //submenu => desktop
                    "Herramientas Administrativas"=>"enjoyAdminTools",
                    "Programas de Salud"=>"salud",
                ),
            ),
            
        ),
        
    ),
    
)

?>
