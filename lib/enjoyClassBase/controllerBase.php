<?php

require_once "lib/languages/$language.php"; //Exposes base_lenguage() for this file and for the helper file
require_once "lib/crudHelpers/$crudHelper.php"; //Brings crud() among other helpers
require_once 'lib/misc/encryption.php';


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
    var $dataRep=null;
    var $baseModel=null;
    var $ds; // directory separator
    //var $directories=array();

    var $bpmFlow=array();
    var $bpmModel=null;    
    
    var $encripter;   
    
    /**
     * Controller constructor
     * @param array $config General Config
     */
    
    function __construct(&$config) {
        $this->config=&$config;
        $this->encripter=new encryption($this->config["appServerConfig"]['encryption']['hashText'] . $_SESSION["userInfo"]['lastLoginStamp']);

        $dataRepName=$this->config['flow']['app'].'DataRep';
        
        if (class_exists($dataRepName)) {
            $baseModelClass=$this->config['flow']['mod'].'Model';
            if (class_exists($baseModelClass)) {
                $this->baseModel = new $baseModelClass(new $dataRepName(), $this->config);
                $this->decodeKeys($this->baseModel);
                if (count($this->bpmFlow)) {
                    $this->config['bpmFlow']=$this->bpmFlow;
                    $this->setBpmInfo();
                }
                
            }
        }
        
        if (substr(PHP_OS,0,1)=='W') {
            $this->ds="\\"; //Windows
        }
        else{
            $this->ds="/"; //Unix
        }
        
    }
    
    function __destruct() {
        $this->dataRep= null;
    }
    
    function bpmCallAction() {
        if (isset($_REQUEST['new_bpm_state'])) {
            $this->changeBpmStateProcess($bpmInfo);
            $this->resultData["output"]=json_encode($this->config['bpmData']);
        }
        else {
            $this->resultData["output"]["bpmResult"]=$this->config['bpmData'];
            $this->resultData["useLayout"]=false;
        }
        
    }
    
    function getBpmActionsAction() {
        
        $this->resultData["useLayout"]=false;
        $this->resultData["viewFile"]="lib/commonModules/bpm/views/view_getBpmActions.php";
        
        $recordArray=$this->baseModel->fetchRecord();
        foreach ($recordArray as $field => $value) {
            if ($field == $this->baseModel->primaryKey) {
                continue;
            }
            $this->resultData["output"]["firstFieldData"]=$value;
            $this->resultData["output"]["firstFieldLabel"]=$this->baseModel->fieldsConfig[$field]["definition"]["label"][$this->config["base"]["language"]];
            break;
        }

        $this->resultData["output"]["bpmFlow"]=$this->bpmFlow;
        $this->resultData["output"]["bpmData"]=$this->config['bpmData'];
        
        if ($this->config["helpers"]['crud_encryptPrimaryKeys']) {
            $primaryKey=$this->encripter->encode($_REQUEST[$this->baseModel->tables.'_'.$this->baseModel->primaryKey]);
        }
        else{
            $primaryKey=$_REQUEST[$this->baseModel->tables.'_'.$this->baseModel->primaryKey];
        }
        
        $this->resultData["output"]["primaryKeyParameter"]=$this->baseModel->tables.'_'.$this->baseModel->primaryKey.'='.$primaryKey;
        
    }
    
    
    function setBpmInfo() {
        
        $bpmResult=array();
        
        if (!isset($_REQUEST[$this->baseModel->tables.'_'.$this->baseModel->primaryKey])) {
            $dataArray=null;
            $state=null;
            $stateConfig=null;
        }
        else{
            $dataArray=$this->baseModel->bpmModel->getData($_REQUEST[$this->baseModel->tables.'_'.$this->baseModel->primaryKey]);
            $state=$dataArray['state'];
            $stateConfig=$this->bpmFlow['states'][$state];
        }
        
        $this->config['bpmData']=array();
        $this->config['bpmData']['state']=$state;
        $this->config['bpmData']['data']=$dataArray;
        $this->config['bpmData']['stateConfig']=$stateConfig;

    }
    
    
    function registerNewBpmState() {
        $_REQUEST[$this->baseModel->bpmModel->tables.'_user']=$_SESSION["user"];
        $_REQUEST[$this->baseModel->bpmModel->tables.'_id_process']=$_REQUEST[$this->baseModel->tables.'_'.$_REQUEST[$this->baseModel->primaryKey]];
        $_REQUEST[$this->baseModel->bpmModel->tables.'_state']=$_REQUEST['new_bpm_state'];
        $_REQUEST[$this->baseModel->bpmModel->tables.'_date']=date('Y-m-d H:i');
        $_REQUEST[$this->baseModel->bpmModel->tables.'_info']=$_REQUEST['bpm_info'];
        $this->baseModel->bpmModel->insertRecord();        
    }
    
    function changeBpmStateProcess($bpmInfo) {
        if (in_array($_REQUEST['new_bpm_state'], $bpmInfo['stateConfig']['actions'][$_REQUEST['act']]['results'])) {
            $this->registerNewBpmState();
            $this->config['bpmData']["operation"]='new_bpm_state';
            $this->config['bpmData']["result"]='ok';
            $this->config['bpmData']["new_bpm_state"]=$_REQUEST['new_bpm_state'];
        }
        else{
            $this->config['bpmData']["operation"]=$_REQUEST['new_bpm_state'];
            $this->config['bpmData']["result"]='error';
            $this->config['bpmData']["info"]='Unrecognized new state '.$_REQUEST['new_bpm_state'];
        }
    }
    
    /**
     * Handles the execution of actions
     * @param string $act Action
     */
    
    function run($act) {
        $this->resultData["useLayout"] = true;
        $this->resultData["view"] = $act; //Default View
        $action=$act."Action";
        $this->$action();    
    }

    /**
     * Just to have an action.
     */
    
    function indexAction() {
    }
    

    /**
     * Shows the table registers in dataBase
     * 
     * @param object $model
     * @param bool $showOperationStatus
     * @param bool $okOperation
     */
    
    
    function crudShowList($model,$showOperationStatus,$okOperation) {
        
        $messenger = new messages();
        $crud = new crud($model);        
        
        foreach ($this->baseModel->fieldsConfig as $field => $configSection) {
            if (isset($configSection['viewsPresence'])) {
                if (in_array('list', $configSection['viewsPresence']) or $field == $this->baseModel->primaryKey) {
                    $options['fields'][]=$field;
                }
            }            
            else $options['fields'][]=$field;
        }
        
        if (count($this->bpmFlow)) {
            $options['fields'][]="(SELECT {$this->baseModel->tables}_bpm.state FROM {$this->baseModel->tables}_bpm WHERE {$this->baseModel->tables}_bpm.id_process={$this->baseModel->tables}.{$this->baseModel->primaryKey} ORDER BY {$this->baseModel->tables}_bpm.id DESC LIMIT 1) AS bpm_state";
        }
        
        $options['config']['subModelRelations']=false;
        $lang=$this->config["base"]["language"];
        if (key_exists("keyField", $_REQUEST)) {
            $options['config']['dataFieldConversion']=true;
            $options['where'][]=$model->tables.'.'.$_REQUEST['keyField']."='{$_REQUEST['keyValue']}'";
            $this->resultData["output"]["label"] = $model->label[$lang]." ".$this->baseAppTranslation['of']." ".$_REQUEST['keyLabel']." (".$_REQUEST['modelLabel'].")";
            $resultData = $model->fethLimited($options);
        }
        else {
            $resultData = $model->fethLimited($options);
            $this->resultData["output"]["label"] = $model->label[$lang];
        }
        $this->resultData["output"]["crud"] = $crud->listData($resultData, $resultData["totalRegisters"]);

        if ($showOperationStatus) {

            if ($okOperation) {
                $message=$this->baseAppTranslation['okOperationTrue'];
            }
            else{
                $message=$this->baseAppTranslation['okOperationFalse'];
            }
            $operationStatusHtml=$messenger->operationStatus($message,$okOperation);
            $this->resultData["output"]["crud"]=$operationStatusHtml.$this->resultData["output"]["crud"];

        }        
        
    }

    
    /**
     * Decodes the table keys if they arrived encoded
     * @param object $model
     */
    
    function decodeKeys($model) {

        if ($this->config["helpers"]['crud_encryptPrimaryKeys']) {
            session_start();

            if (key_exists($model->tables . '_' . $model->primaryKey, $_REQUEST)) {
                $_REQUEST[$model->tables . '_' . $model->primaryKey] = $this->encripter->decode($_REQUEST[$model->tables . '_' . $model->primaryKey]);
            }
            if (key_exists('keyValue', $_REQUEST)) {
                $_REQUEST['keyValue'] = $this->encripter->decode($_REQUEST['keyValue']);
            }
        }        
        
    }
    
    
    /**
     * 
     * Returns the downloaded files path in the system and the array of file fileds in the table
     * 
     * @param object $model
     * @return array
     */
    
    function crudGetFileFields($model) {

        $fileFields=array();
        foreach ($model->fieldsConfig as $field => $fieldConfig) {

            if ($fieldConfig['definition']['type']=='file') {
                $fileFields[]=$field;
                $filesPath=$this->config['appServerConfig']['base']['controlPath']."files".$this->ds.$this->config['flow']['app'].$this->ds.$this->config['flow']['mod'].$this->ds.$field;
            }


        }
        
        return array($filesPath,$fileFields);
        
    }

    function crudCreateForm($model) {
        
        $crud = new crud($model);
        $lang=$this->config["base"]["language"];        
        
        $this->resultData["output"]["label"] = $model->label[$lang]." - ".$this->baseAppTranslation['add'];
        $this->resultData["output"]["crud"] = $crud->getForm();        
    }
    function crudDownLoadFile($model) {
        list($filesPath,$fileFields)=$this->crudGetFileFields($model);
        
        $register = $model->fetchRecord();
        $fileName=$register[$_REQUEST["fileField"]];
        $fileLocation=$filesPath.$this->ds.$_REQUEST[$model->tables.'_'.$model->primaryKey].'_'.$fileName;

        if (file_exists($fileLocation)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileLocation));
            ob_clean();
            flush();
            readfile($fileLocation);
            exit;
        }        
        
    }
    
    function crudEditForm($model) {
        
        $crud = new crud($model);
        $lang=$this->config["base"]["language"];        
        
        $options = array();
        $options['config']['dataFieldConversion'] = false;
        $register = $model->fetchRecord($options);
        $this->resultData["output"]["label"] = $model->label[$lang] . " - " . $this->baseAppTranslation['edit'];
        $this->resultData["output"]["crud"] = $crud->getForm($register);
    }
    
    function crudEditFkForm($model) {
        
        $lang=$this->config["base"]["language"];          
        
        $fkModel = $model->foreignKeys[$_REQUEST['fkField']]['model'];
        $fkCrud = new crud($fkModel);
        $fkRegister = $model->fetchFkRecord();
        $this->resultData["output"]["label"] = $fkModel->label[$lang] . " - " . $this->baseAppTranslation['edit'];
        $this->resultData["output"]["crud"] = $fkCrud->getForm($fkRegister);
    }
    
    function crudFieldFileControl($model) {
        
        list($filesPath,$fileFields)=$this->crudGetFileFields($model);
        
        if (count($fileFields)) {
            $register = $model->fetchRecord();
            foreach ($fileFields as $fileField) {

                //If no new file attached, mantein the previous one
                if ($_FILES[$model->tables . '_' . $fileField]['name'] == "" ) {
                    $_REQUEST[$model->tables . '_' . $fileField] = $register[$fileField];
                } else { //Save the attached file
                    if ($register[$fileField] != "") {//Erase the old file
                        $fileLocation = $filesPath . $this->ds . $_REQUEST[$model->tables . '_' . $model->primaryKey] . '_' . $register[$fileField];
                        unlink($fileLocation);  
                    }
                    $_REQUEST[$model->tables . '_' . $fileField] = $_FILES[$model->tables . '_' . $fileField]['name'];
                }
            }
        }
    }
    
    function crudFieldFileCreation($model) {
        
        
        list($filesPath,$fileFields)=$this->crudGetFileFields($model);
        
        if (count($fileFields)) {

            if (!file_exists($filesPath)) {
                mkdir($filesPath, 0770, TRUE);
            }

            foreach ($fileFields as $fileField) {

                if ($_FILES[$model->tables . '_' . $fileField]['name'] != "") {

                    $newFileLocation = $filesPath . $this->ds . $_REQUEST[$model->tables . '_' . $model->primaryKey] . '_' . $_FILES[$model->tables . '_' . $fileField]['name'];
                    move_uploaded_file($_FILES[$model->tables . '_' . $fileField]['tmp_name'], $newFileLocation);
                }
            }
        }
    }
    
    
    function crudFkChange($model) {

        $fkModel = $model->foreignKeys[$_REQUEST['fkField']]['model'];

        if ($this->config["helpers"]['crud_encryptPrimaryKeys']) {
            $_REQUEST[$fkModel->tables . '_' . $fkModel->primaryKey] = $this->encripter->decode($_REQUEST[$fkModel->tables . '_' . $fkModel->primaryKey]);
        }

        //Foreign Permission validation
        $security = new security();
        $fkModuleName = $fkModel->tables;

        if (key_exists($fkModuleName, $_SESSION['userInfo']['privileges'][$this->config['flow']['app']]) or $this->config['permission']['isAdmin']) {
            $fkModulePermissions = $_SESSION['userInfo']['privileges'][$this->config['flow']['app']][$fkModuleName];
            $fkChangePermission = $security->checkCrudPermission('C', $fkModulePermissions);
            if ($fkChangePermission or $this->config['permission']['isAdmin']) {

                $fkFileFields = array();
                foreach ($fkModel->fieldsConfig as $field => $fieldConfig) {

                    if ($fieldConfig['definition']['type'] == 'file') {
                        $fkFileFields[] = $field;
                    }

                    $fkFilesPath = $this->config['appServerConfig']['base']['controlPath'] . "files" . $this->ds . $this->config['flow']['app'] . $this->ds . $fkModuleName . $this->ds . $field;
                }


                if (count($fkFileFields)) {
                    $register = $fkModel->fetchRecord();
                    foreach ($fkFileFields as $fileField) {

                        if ($_FILES[$fkModel->tables . '_' . $fileField]['name'] != "" and $register[$fileField] != "") {
                            $fileLocation = $fkFilesPath . $this->ds . $_REQUEST[$fkModel->tables . '_' . $fkModel->primaryKey] . '_' . $register[$fileField];
                            unlink($fileLocation);
                            $_REQUEST[$fkModel->tables . '_' . $fileField] = $_FILES[$fkModel->tables . '_' . $fileField]['name'];
                        } elseif ($register[$fileField] != "") {
                            $_REQUEST[$fkModel->tables . '_' . $fileField] = $register[$fileField];
                        }
                    }
                }

                $okOperation = $fkModel->updateRecord();

                if (count($fkFileFields)) {

                    if (!file_exists($fkFilesPath)) {
                        mkdir($fkFilesPath, 0770, TRUE);
                    }

                    foreach ($fkFileFields as $fileField) {

                        if ($_FILES[$fkModel->tables . '_' . $fileField]['name'] != "") {

                            $newFileLocation = $fkFilesPath . $this->ds . $_REQUEST[$fkModel->tables . '_' . $fkModel->primaryKey] . '_' . $_FILES[$fkModel->tables . '_' . $fileField]['name'];
                            move_uploaded_file($_FILES[$fkModel->tables . '_' . $fileField]['tmp_name'], $newFileLocation);
                        }
                    }
                }
            }
        }
        
        return $okOperation;
    }
    
    function crudAdd($model) {
        $messenger = new messages();
        list($filesPath,$fileFields)=$this->crudGetFileFields($model);
        
        if (count($fileFields)) {
            foreach ($fileFields as $fileField) {
                $_REQUEST[$model->tables . '_' . $fileField] = $_FILES[$model->tables . '_' . $fileField]['name'];
            }
        }
        try {
            $okOperation = $model->insertRecord();
        } catch (Exception $exc) {
            $this->resultData["output"]["crud"] = $messenger->errorMessage($exc->getMessage());
            return "validation";
        }

        if (count($fileFields)) {

            if (!file_exists($filesPath)) {
                mkdir($filesPath, 0770, TRUE);
            }

            $newId = $this->baseModel->dataRep->getLastInsertId();
            foreach ($fileFields as $fileField) {
                $newFileLocation = $filesPath . $this->ds . $newId . '_' . $_FILES[$model->tables . '_' . $fileField]['name'];
                move_uploaded_file($_FILES[$model->tables . '_' . $fileField]['tmp_name'], $newFileLocation);
            }
        }
        
        return $okOperation;
    }
    
    
    function crudRemove($model) {
        list($filesPath,$fileFields)=$this->crudGetFileFields($model);
        
        if (count($fileFields)) {
            $register = $model->fetchRecord();
            foreach ($fileFields as $fileField) {
                $fileLocation = $filesPath . $this->ds . $_REQUEST[$model->tables . '_' . $model->primaryKey] . '_' . $register[$fileField];
                unlink($fileLocation);
            }
        }
        $okOperation = $model->deleteRecord();
        return $okOperation;
    }
    
    
    function crudChange($model) {
        
        $messenger = new messages();
        $this->crudFieldFileControl($model);

        try {
            $okOperation = $model->updateRecord();
        } catch (Exception $exc) {
            $this->resultData["output"]["crud"] = $messenger->errorMessage($exc->getMessage());
            return "validation";
        }

        $this->crudFieldFileCreation($model);
        return $okOperation;
    }
    
    
    /**
     * Handles the CRUD (Create Update Delete) for the specified Model
     * 
     * @param model $model
     * @param PDO $dataRep
     * @return string html of the crud result
     */
    
    function crud($model,$dataRep=null) {

        //Setting the view to the index in the case of an bpm action with out view
        if (!file_exists($this->config['viewsDir'].'view_'.$this->config['flow']['act'].'.php') and $this->config['bpmData']!=null) {
            $this->resultData['viewFile']=$this->config['viewsDir'].'view_index.php';
        }
        
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $showCrudList = true;
        $showOperationStatus = false;
        
        if (key_exists("crud", $_REQUEST)) {
           
            if ($_REQUEST["crud"] == "createForm") {
                $this->crudCreateForm($model);
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "downloadFile") {
                $this->crudDownLoadFile($model);
            } elseif ($_REQUEST["crud"] == "editForm") {
                $this->crudEditForm($model);
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "editFkForm") {
                $this->crudEditFkForm($model);
                $showCrudList = false;
            } elseif ($_REQUEST["crud"] == "change" and $this->config['permission']['change']) {
                $showOperationStatus = true;
                $okOperation=$this->crudChange($model);
            } elseif ($_REQUEST["crud"] == "fkChange") {
                $showOperationStatus = true;
                $okOperation=$this->crudFkChange($model);
            } elseif ($_REQUEST["crud"] == "add" and $this->config['permission']['add']) {
                $showOperationStatus = true;
                $okOperation=$this->crudAdd($model);
            } elseif ($_REQUEST["crud"] == "remove" and $this->config['permission']['remove']) {
                $showOperationStatus = true;
                $okOperation=$this->crudRemove($model);
            }
        }

        if ($okOperation === "validation") {
            return;
        }
        
        if ($showCrudList) {
            $this->crudShowList($model,$showOperationStatus,$okOperation);
        }
        
        return 'ok';
    }
    
    /**
     * Handles the INNER controller calls ( actually NOT used)
     */
    
    function dataCallAction() {
     
        $resultData=$this->model->dataCall();
        $this->resultData['output']=json_encode($resultData);
        
    }    
    
}

?>
