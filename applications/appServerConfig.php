<?php

//Application Server Configuration

$appServerConfig=array(
    "base"=>array(
        "defaultApp"=>"jqDesktop",
        "controlPath"=>"z:\\enjoyControl\\", //Location of various control file like user data
        "platform"=>"windows", //windows,unix
        "errorLog"=>true,
        "debug"=>true,
        "adminUser"=>'admin', # full privileged user
    ),
    "encryption"=>array(
//        "hashText"=>'hello world', # Must be unique in every enjoy installation
        "hashText"=>'lkjashdfkjhasdfjhasdfksjdfh', # Must be unique in every enjoy installation
    ),
    "apps"=>array(
        "setup",
        "basicExample",
        "jqDesktop",
        "enjoyAdmin",
        "eos",
    ),
   
)

?>
