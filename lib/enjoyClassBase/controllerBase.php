<?php

$enjoyHelper=$config['base']['enjoyHelper'];
require_once "lib/languages/$language.php"; //Exposes base_lenguage() for this file and for the helper file
require_once "lib/enjoyHelpers/$enjoyHelper.php"; //Brings crud() among other helpers


$moduleModelFile=$modelsDir."model_$mod.php";// Brings "moduleName"Model()
if (file_exists($moduleModelFile)) {
    require_once $moduleModelFile;
}

$appDataRepFile=$applicationDataRepDir."app_dataRep.php"; //Brings app_dataRep()
if (file_exists($appDataRepFile)) {
    require_once $appDataRepFile;
}
 
class controllerBase {

    var $resultData=array();
    var $config;
    //var $directories=array();

    function __construct($config) {
        $this->config=&$config;
    }
    
//    function __destruct() {
//        $this->dataRepObject->close();
//    }
    
    function run($act) {
        $this->resultData["useLayout"] = true;
        $this->resultData["view"] = $act; //Default View
        $action=$act."Action";
        $this->$action();    
    }
    
    function indexAction() {
    }
    
    function crudAction($model,$dataRep) {

        $crud = new crud($model);
        $lang=$this->config["base"]["language"];
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $showCrudList = true;
        
        if (key_exists("crud", $_REQUEST)) {
            if ($_REQUEST["crud"] == "createForm") {
                $this->resultData["output"]["label"] = $model->label[$lang]." - ".$this->baseAppTranslation['add'];
                $this->resultData["output"]["crud"] = $crud->getForm();
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "editForm") {
                $register = $model->fetchRecord();
                $this->resultData["output"]["label"] = $model->label[$lang]." - ".$this->baseAppTranslation['edit'];
                $this->resultData["output"]["crud"] = $crud->getForm($register);
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "editFkForm") {
                $fkModel=$model->foreignKeys[$_REQUEST['fkField']]['model'];
                $fkCrud = new crud($fkModel);
                $fkRegister = $model->fetchFkRecord();
                $this->resultData["output"]["label"] = $fkModel->label[$lang]." - ".$this->baseAppTranslation['edit'];
                $this->resultData["output"]["crud"] = $fkCrud->getForm($fkRegister);
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "update") {
                $model->updateRecord();
            } elseif ($_REQUEST["crud"] == "fkUpdate") {
                $fkModel=$model->foreignKeys[$_REQUEST['fkField']]['model'];
                $fkModel->updateRecord();
            } elseif ($_REQUEST["crud"] == "insert") {
                $model->insertRecord();
            } elseif ($_REQUEST["crud"] == "delete") {
                $model->deleteRecord();
            }
        }

        if ($showCrudList) {
            if (key_exists("keyField", $_REQUEST)) {
                $options['where'][]=$_REQUEST['keyField']."='{$_REQUEST['keyValue']}'";
                $this->resultData["output"]["label"] = $model->label[$lang]." ".$this->baseAppTranslation['of']." ".$_REQUEST['keyLabel']." (".$_REQUEST['modelLabel'].")";
                $resultData = $model->fethLimited($options);
            }
            else {
                $resultData = $model->fethLimited();
                $this->resultData["output"]["label"] = $model->label[$lang];
            }
            $this->resultData["output"]["crud"] = $crud->listData($resultData, $resultData["totalRegisters"]);
        }
        
        return 'ok';
    }
    
    function dataCallAction() {
     
        $resultData=$this->model->dataCall();
        $this->resultData['output']=json_encode($resultData);
        
    }    
    
}

?>
