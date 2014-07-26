<?php

ini_set('display_errors', '0');error_reporting(~E_ALL);


/*
 * General Application Server Controller
 */

require_once 'lib/misc/security.php';
require_once 'lib/misc/error.php';


/*
 * Client Identification
 */

function getClient() {
    
    $client='desktop';
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    if (strpos($user_agent, 'iPhone') !== FALSE) {
        $client='mobile';
    }
    elseif (strpos($user_agent, 'iPad') !== FALSE) {
        $client='mobile';
    }
    elseif (strpos($user_agent, 'iPod') !== FALSE) {
        $client='mobile';
    }
    elseif (strpos($user_agent, 'Android') !== FALSE) {
        $client='mobile';
    }
    elseif (strpos($user_agent, 'Windows Phone') !== FALSE) {
        $client='mobile';
    }
    
    return $client;
    
}

/*
 * Error traping
 */

function exceptionHandler($exception) {
    
    global $config;
    
    $error=new error($config);
    $error->show("Uncaught exception", $exception);
}
function errorHandler($err_severity,$errno, $errstr, $errfile, $errline) {
    throw new Exception("$errno, $errstr, $errfile, $errline");
}
function shutdownHandler() {
    
    global $config;
    
    $error=error_get_last();
    $avoidedErrors=array(E_DEPRECATED,E_NOTICE,E_WARNING);
    
    if ( in_array($error['type'], $avoidedErrors) or $error == NULL) {
        return;
    }
    
    class shutDownExcpetion extends Exception{}
    $exception = new shutDownExcpetion(print_r($error,true));
    
    $error=new error($config);
    $error->show("shutting Down", $exception);
}

set_exception_handler('exceptionHandler');
set_error_handler('errorHandler',E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING );
register_shutdown_function('shutdownHandler',E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);


/*
 * Input Filtering
 */

$security= new security();

$_GET=$security->filter($_GET,true);
$_POST=$security->filter($_POST,true);
$_REQUEST=$security->filter($_REQUEST,true);
   
//TODO: Document the use of php.ini directives variables_order and request_order ( hot to POST over GET )

//Set initial flow defaults and config
require_once "applications/appServerConfig.php"; //Expose variable $appServerConfig

$app=$appServerConfig["base"]["defaultApp"];

if (key_exists("domains", $appServerConfig)) {
    if (key_exists($_SERVER['SERVER_NAME'], $appServerConfig["domains"])) {
        $app=$appServerConfig["domains"][$_SERVER['SERVER_NAME']];
    }
}

$config["appServerConfig"]=$appServerConfig;

if (isset($INNER)) {
    $app=$INNER["app"];
}
else{
    
    if (key_exists("app", $_REQUEST)) {
        $app=$_REQUEST["app"];
    }
}


if (!in_array($app, $config["appServerConfig"]['apps'])) {
    throw new Exception('Unrecognized Application.');
}

require_once "applications/$app/config.php"; //Expose variable $config
$config["appServerConfig"]=$appServerConfig; //Asigned becouse a new $config exists.

$mod=$config["base"]["defaultModule"];
$act=$config["base"]["defaultAction"];


if (isset($INNER)) {
    $mod=$INNER["mod"];
    $act=$INNER["act"];
}
else{

    if (key_exists("mod", $_REQUEST)) {
        $mod=$_REQUEST["mod"];
    }
    if (key_exists("act", $_REQUEST)) {
        $act=$_REQUEST["act"];
    }

}


$client=getClient();

$config["flow"]["app"]=$app;
$config["flow"]["mod"]=$mod;
$config["flow"]["act"]=$act;
$config["client"]=$client;

$language=$config["base"]["language"];


$modelsDir="applications/$app/modules/$mod/models/";
$viewsDir="applications/$app/modules/$mod/views/";
$controllersDir="applications/$app/modules/$mod/";

$applicationsServerDataRepDir="dataRep/";
$applicationDataRepDir="applications/$app/dataRep/";
$moduleDataRepDir="applications/$app/modules/$mod/dataRep/";


/*
 * Permissions set
 */

if (isset($config['base']['useAuthentication'])) {
    if ($config['base']['useAuthentication']) {
        session_start();
        if (isset($_SESSION['userInfo']['privileges'])) {
            if($_SESSION['user']==$config['appServerConfig']['base']['adminUser']){
                
                $config['permission']['isAdmin']=true;
                $config['permission']['list'] = true;
                $config['permission']['view'] = true;
                $config['permission']['add'] = true;
                $config['permission']['change'] = true;
                $config['permission']['remove'] = true;
            }
            else if (isset($_SESSION['userInfo']['privileges'][$app][$mod])) {
                $modulePermissions=$_SESSION['userInfo']['privileges'][$app][$mod];
                
                $config['permission']['isAdmin']=false;
                $config['permission']['list']=$security->checkCrudPermission('L', $modulePermissions);
                $config['permission']['view']=$security->checkCrudPermission('V', $modulePermissions);
                $config['permission']['add']=$security->checkCrudPermission('A', $modulePermissions);
                $config['permission']['change']=$security->checkCrudPermission('C', $modulePermissions);
                $config['permission']['remove']=$security->checkCrudPermission('R', $modulePermissions);
                
            }
        } else {
            
            $authError=true;
            if (key_exists('publicActions', $config['base'])) {
                if (key_exists($mod, $config['base']['publicActions'])) {
                    if (in_array($act, $config['base']['publicActions'][$mod])) {
                        $authError=false;
                    }
                }
                
            }
            
            if ($authError) {
                throw new Exception('Authentication error.');
            }
            
        }
    }
    else{
        $config['permission']['isAdmin']=true;
        $config['permission']['list'] = true;
        $config['permission']['view'] = true;
        $config['permission']['add'] = true;
        $config['permission']['change'] = true;
        $config['permission']['remove'] = true;        
    }
}



/*
 * Application Controller Execution
 */

require_once $controllersDir."controller_$mod.php";

$modController = new modController($config);
$modController->run($act);


/*
 * Data result handing
 */


$layoutFile="applications/$app/layout.php";

if (isset($modController->resultData["viewFile"])) {
    $viewFile=$modController->resultData["viewFile"];
}
else{
    $view=$modController->resultData["view"];
    $viewFile=$viewsDir."view_$view.php";    
}

if (key_exists("output", $modController->resultData)) {
    if (is_array($modController->resultData["output"])) {

        //Expose variables for the view
        foreach ($modController->resultData["output"] as $outputVarName =>$outputVarValue) {
            //Although $outputVarValue is not used, it is necesary for the correct use of $outputVarName
            
            if ($outputVarName != 'crud') {
                $modController->resultData["output"][$outputVarName]=$security->filter($modController->resultData["output"][$outputVarName]);
            }
            
            $$outputVarName = &$modController->resultData["output"][$outputVarName];
        }
    }
    else {
        echo $modController->resultData["output"];
        exit(); //May be It is a Web Service
    }

}

if (file_exists($layoutFile) and $modController->resultData["useLayout"] and file_exists($viewFile) ) {
    require_once $layoutFile; #Show layout wich should require the view
}        
elseif (file_exists($viewFile)) {
    require_once $viewFile; #just show the view
}


?>
