<?php


ini_set('display_errors', '1');error_reporting(E_ALL);

/*
 * General Application Server Controller
 */


//TODO: Document the use of php.ini directives variables_order and request_order ( hot to POST over GET )


//Set initial defaults
require_once "applications/appServerConfig.php"; //Expose variable $appServerConfig

$app=$appServerConfig["base"]["defaultApp"];

if (isset($INNER)) {
    $app=$INNER["app"];
}
else{
    
    if (key_exists("app", $_REQUEST)) {
        $app=$_REQUEST["app"];
    }
}


require_once "applications/$app/config.php"; //Expose variable $config
$config["appServerConfig"]=$appServerConfig;

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


$config["flow"]["app"]=$app;
$config["flow"]["mod"]=$mod;
$config["flow"]["act"]=$act;
$language=$config["base"]["language"];


$modelsDir="applications/$app/modules/$mod/models/";
$viewsDir="applications/$app/modules/$mod/views/";
$controllersDir="applications/$app/modules/$mod/";

$applicationsServerDataRepDir="dataRep/";
$applicationDataRepDir="applications/$app/dataRep/";
$moduleDataRepDir="applications/$app/modules/$mod/dataRep/";


require_once 'dataRep/appServer_dataRep.php';

//$directories["models"]=$modelsDir;
//$directories["views"]=$viewsDir;
//$directories["controllers"]=$controllersDir;
//$directories["applicationDataRepDir"]=$applicationDataRepDir;


//Application Controller Execution
require_once $controllersDir."controller_$mod.php";

$modController = new modController($config);
//$modController->directories=$directories;
$modController->run($act);

//Data result handing

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
            $$outputVarName = &$modController->resultData["output"][$outputVarName];
        }
    }
    else {
        echo $modController->resultData["output"];
        exit(); //May be It is a Web Service
    }

}

if (file_exists($layoutFile) and $modController->resultData["useLayout"] and file_exists($viewFile) ) {
    require_once $layoutFile;
}        
elseif (file_exists($viewFile)) {
    require_once $viewFile;
}


?>
