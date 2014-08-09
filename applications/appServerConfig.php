<?php

//Application Server Configuration

$appServerConfig=array(
    "base"=>array(
        "defaultApp"=>"jqDesktop",
        "controlPath"=>"z:\\enjoyControl\\", //Full permissions location of various control file like user data and uploaded files
        "platform"=>"windows", //windows,unix
        "errorLog"=>true,
        "debug"=>true,
        "adminUser"=>'', # full privileged user
    ),
    "encryption"=>array(
        "hashText"=>'', # Must be unique in every enjoy installation
    ),
    "apps"=>array(
        "setup",
        "basicExample",
        "jqDesktop",
        "enjoyAdmin",
        "calendar",
        "cms",
    ),
    "domains"=>array( //To asociate domains with certain application
        //"domain"=>"application",
    ),
   
)

?>