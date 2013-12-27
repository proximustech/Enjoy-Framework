<?php

$enjoyHelper=$config['base']['enjoyHelper'];

require_once $modelsDir."model_$mod.php";// Brings moduleModel()
require_once $applicationDataRepDir."app_dataRep.php"; //Brings app_dataRep()
require_once "lib/enjoyHelpers/$enjoyHelper.php"; //Brings crud() among other helpers


class controllerBase {

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
    }
    
    function crud() {
        $dataRepObject = new app_dataRep();
        $dataRep = $dataRepObject->getInstance();
        $model = new moduleModel($dataRep, $this->config);
        $fieldsConfig = $model->fieldsConfig;
        $primaryKey = $model->primaryKey;
        $crud = new crud($this->config,$fieldsConfig);
        
        $showCrudList = true;

        if (key_exists("crud", $_GET)) {
            if ($_GET["crud"] == "createForm") {
                $this->resultData["output"]["crud"] = $crud->getForm($primaryKey);
                $showCrudList = false;
            } elseif ($_GET["crud"] == "editForm") {
                $user = $model->fetchRecord();
                $this->resultData["output"]["crud"] = $crud->getForm($primaryKey, $user);
                $showCrudList = false;
            } elseif ($_GET["crud"] == "insert") {
                $model->insertRecord();
            } elseif ($_GET["crud"] == "update") {
                $model->updateRecord();
            } elseif ($_GET["crud"] == "delete") {
                $model->deleteRecord();
            }
        }

        if ($showCrudList) {

            $usersData = $model->fethLimited();
            $this->resultData["output"]["crud"] = $crud->listData($primaryKey,$usersData["results"], $usersData["totalRegisters"]);
        }

        $dataRepObject->close();
    }
    
}

?>
