<?php

//Application Configuration

$config=array(
    "base"=>array(
        "appTitle"=>array(
            "es_es"=>"CMS",
        ),
        "appIcon"=>"assets/images/icons/icon_32_network.png",
        "crudHelper"=>"generic",
        "enjoyHelper"=>"kendoui",
        "language"=>"es_es",
        "defaultModule"=>"",
        "defaultAction"=>"index",
        "errorLog"=>false,
        "debug"=>true,
        "useAuthentication"=>true, //Defines if the application use permissions schema
        "publicActions"=>array( //In concordance with useAuthentication = true when some action modules does not require authentication
            "articles"=>array("get","index"),
        ),         
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50000",
        "crud_encryptPrimaryKeys"=>false,
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Portales" => "index.php?app=cms&mod=portals",
            "Secciones" => "index.php?app=cms&mod=sections",
            "Temas" => "index.php?app=cms&mod=topics",
            "Articulos" => "index.php?app=cms&mod=articles",
        ),
    ),
)

?>