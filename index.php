<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

//Application Controller

require_once "applications/appServerConfig.php"; //Expose variable $config

$app=$appServerConfig["base"]["defaultApp"];
if (key_exists("app", $_GET)) {
    $app=$_GET["app"];
}

require_once "applications/$app/config.php"; //Expose variable $config

$mod=$config["base"]["defaultModule"];
$act=$config["base"]["defaultAction"];


if (key_exists("mod", $_GET)) {
    $mod=$_GET["mod"];
}
if (key_exists("act", $_GET)) {
    $act=$_GET["act"];
}

$config["flow"]["app"]=$app;
$config["flow"]["mod"]=$mod;
$config["flow"]["act"]=$act;
$language=$config["base"]["language"];

require_once 'dataRep/appServer_dataRep.php';

$modelsDir="applications/$app/modules/$mod/models/";
$viewsDir="applications/$app/modules/$mod/views/";
$controllersDir="applications/$app/modules/$mod/";

$applicationsServerDataRepDir="dataRep/";
$applicationDataRepDir="applications/$app/dataRep/";
$moduleDataRepDir="applications/$app/modules/$mod/dataRep/";

//$directories["models"]=$modelsDir;
//$directories["views"]=$viewsDir;
//$directories["controllers"]=$controllersDir;
//$directories["applicationDataRepDir"]=$applicationDataRepDir;

require_once $controllersDir."controller_$mod.php";

$modController = new modController($config);
//$modController->directories=$directories;
$modController->run($act);

//Expose the data Output Array as variables for the view

if (key_exists("output", $modController->resultData)) {
    
    foreach ($modController->resultData["output"] as $outputVarName =>$outputVarValue) {
        //Although $outputVarValue is not used, it is necesary for the correct use of $outputVarName
        $$outputVarName = &$modController->resultData["output"][$outputVarName];
    }
    
}

$view=$modController->resultData["view"];
require_once $viewsDir."view_$view.php";

?>
