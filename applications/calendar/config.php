<?php

//Application Configuration

$config=array(
    "base"=>array(
        "appTitle"=>array(
            "es_es"=>"Calendario",
        ),
        "appIcon"=>"assets/images/icons/calendar.png",
        "enjoyHelper"=>"jqueryui",
        "language"=>"es_es",
        "defaultModule"=>"schedule",
        "defaultAction"=>"index",
        "errorLog"=>true,
        "debug"=>true,
        "useAuthentication"=>true, //Defines if the application use permissions schema
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50",
        "crud_encryptPrimaryKeys"=>true,
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Proyectos" => "index.php?app=calendar&mod=projects",
            "Tareas" => "index.php?app=calendar&mod=tasks",
            "Agendamientos" => "index.php?app=calendar&mod=schedule",
        ),

        
    ),
    
)

?>
