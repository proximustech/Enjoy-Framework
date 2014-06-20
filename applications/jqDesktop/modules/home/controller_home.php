<?php

//Module Controller Class

$enjoyHelper=$config['base']['enjoyHelper'];
require_once "lib/enjoyHelpers/$enjoyHelper.php"; //Brings crud() among other helpers
require_once 'lib/enjoyClassBase/controllerBase.php';
require_once 'lib/enjoyClassBase/identification.php';

class modController extends controllerBase {

    var $resultData=array();
    var $config;
    //var $directories=array();

    
    function run($act) {
        
        session_start();
        if ($_SESSION["status"] != 'in' and $act!='checkLogin'){
            $act="login";
        }        
        parent::run($act);
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
        
        $e_dbIdentifier=new e_dbIdentifier($this->dataRep,$this->config["appServerConfig"]);
        $e_user= new e_user($e_dbIdentifier, $this->config["appServerConfig"]);
        $e_user->profile($_POST);
        $e_user->check();
        
        if ($e_user->valid) {

            session_start();
            $_SESSION["user"] = $_POST['user'] ;
            $_SESSION["status"] = 'in' ;
            
            $userInfo=$e_user->getInfo();
            $userInfo['lastLoginStamp']=time();
            
            list($modulesPrivileges,$componentsPrivileges)=$this->baseModel->getPrivileges($_POST['user']);
            $privileges=array();
            foreach ($modulesPrivileges as $privilege) {
                $privileges[$privilege['app']][$privilege['module']]=$privilege['permission'];
            }
            foreach ($componentsPrivileges as $privilege) {
                $privileges[$privilege['app']][$privilege['component']]=$privilege['permission'];
            }

            $userInfo['role']=$privilege['role'];
            $userInfo['privileges']=$privileges;
            $e_user->saveInfo($userInfo);
            $_SESSION["userInfo"]=$userInfo;
            
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
        
        if ($this->config['appServerConfig']['base']['adminUser']==$_SESSION['user']) {
            $isAdmin=true;
        } else $isAdmin=false;
        
        
        $this->resultData["output"]["isAdmin"]=$isAdmin;
        $this->resultData["output"]["privileges"]=$_SESSION['userInfo']['privileges'];
        $this->resultData["output"]["desktopConfig"]=$desktopConfig;
        
    }
    
    function getBottomBarAction() {
        
        $this->getDesktopAction();
        
    }
    
}

?>