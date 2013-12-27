<?php

//Module Controller Class

$enjoyHelper=$config['base']['enjoyHelper'];
require_once "lib/enjoyHelpers/$enjoyHelper.php"; //Brings crud() among other helpers

class modController {

    var $resultData=array();
    var $config;
    //var $directories=array();

    function __construct($config) {
        $this->config=&$config;
    }
    
    function run($act) {
        $this->resultData["view"] = $act; //Default View
        $this->$act();
    }
    
    function index() {
        
        $this->resultData["output"]["topMenuConfig"] =$this->config['custom']['topMenuConfig'][$this->config['base']['language']];
        
    }
    
    function getDesktop() {
        
        $desktopConfig=array();
        foreach ($this->config['custom']['desktops'][$_GET['desktopName']]['apps'] as $desktopApp) {
            require_once "applications/$desktopApp/config.php"; //Expose variable $config
            $desktopConfig['apps'][$desktopApp]=$config;
            unset($config);
        }
        
        
        $this->resultData["output"]["desktopConfig"]=$desktopConfig;
        
    }
    
    function getBottomBar() {
        
        $this->getDesktop();
        
    }
    
}

?>