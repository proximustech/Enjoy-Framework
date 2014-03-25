<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';
require_once 'lib/enjoyClassBase/identification.php';

class modController extends controllerBase {

    function indexAction() {

        $dataRepObject = new app_dataRep();
        $dataRep = $dataRepObject->getInstance();
        $model = new usersModel($dataRep, $this->config);       
        $crudResult=$this->crudAction($model,$dataRep);
        
        if ($_REQUEST["crud"] == "insert" or $_REQUEST["crud"] == "update" and $crudResult=='ok') {
            
            $e_user = new e_user(null, $this->config["appServerConfig"]); //If not authenticating, does not require identifier
            $_REQUEST['user']=$_REQUEST['users_user_name'];
            $e_user->profile($_REQUEST);            
            
            $info=array();
            $info['valid']=true;
            $e_user->saveInfo($info);
    
        }
        
        $dataRepObject->close();
    }

}

?>
