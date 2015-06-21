<?php

//Application Configuration

$config=array(
    "base"=>array(
        "appTitle"=>array(
            "es_es"=>"Put a Title Here",
        ),
        "appIcon"=>"assets/images/icons/icon_32_computer.png",
        "enjoyHelper"=>"jqueryui",
        "language"=>"es_es",
        "defaultModule"=>"",
        "defaultAction"=>"index",
        "errorLog"=>false,
        "debug"=>false,
        "useAuthentication"=>true, //Defines if the application use permissions schema
        "publicActions"=>array( //In concordance with useAuthentication = true when some action modules does not require authentication
            //"module"=>array("action",),
        ),         
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50000",
        "crud_encryptPrimaryKeys"=>true,
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Module Title" => "index.php?app=appName&mod=modName",
        ),
    ),
)

?>