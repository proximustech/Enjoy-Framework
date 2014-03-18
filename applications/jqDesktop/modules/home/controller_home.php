<?php

//Module Controller Class

$enjoyHelper=$config['base']['enjoyHelper'];
require_once "lib/enjoyHelpers/$enjoyHelper.php"; //Brings crud() among other helpers
require_once 'lib/enjoyClassBase/controllerBase.php';
require_once 'lib/enjoyClassBase/identification.php';

class modController extends baseController {

    var $resultData=array();
    var $config;
    //var $directories=array();

    
    function run($act) {
        
        session_start();

        if ($_SESSION["status"] != 'in' and $act!='checkLogin'){
            $act="login";
        }        
        
        parent::run($act);
        
//        $this->resultData["view"] = $act; //Default View
//        $action=$act."Action";
//        $this->$action();            
        
        $this->resultData["useLayout"] = false;
    }
    
    function loginAction() {
    }
    function logOutAction() {
        session_destroy();
        $this->resultData["view"]='login';
    }
    
    function checkLoginAction() {
        
        $result='Error.';
        
        $dataRepObject = new app_dataRep();
        $dataRep = $dataRepObject->getInstance();        
        
        $e_dbIdentifier=new e_dbIdentifier($dataRep);
        $e_user= new e_user($e_dbIdentifier, $this->config['custom']['controlPath']);
        $e_user->check($_POST);
        
        if ($e_user->valid) {

            session_start();
            $_SESSION["user"] = $_POST['user'] ;
            $_SESSION["status"] = 'in' ;

            $result='OK';
            
        }
        
        $this->resultData["output"]=$result;
    }    
    
    function indexAction() {
        
        $this->resultData["output"]["topMenuConfig"] =$this->config['custom']['topMenuConfig'][$this->config['base']['language']];
        
    }

    
    function getDesktopAction() {
        
        $desktopConfig=array();
        foreach ($this->config['custom']['desktops'][$_REQUEST['desktopName']]['apps'] as $desktopApp) {
            require_once "applications/$desktopApp/config.php"; //Expose variable $config
            $desktopConfig['apps'][$desktopApp]=$config;
            unset($config);
        }
        
        
        $this->resultData["output"]["desktopConfig"]=$desktopConfig;
        
    }
    
    function getBottomBarAction() {
        
        $this->getDesktopAction();
        
    }
    
}

?>