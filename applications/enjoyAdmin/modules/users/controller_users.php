<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';
require_once 'lib/enjoyClassBase/identification.php';

class modController extends controllerBase {

    function indexAction() {

        $e_dbIdentifier=new e_dbIdentifier($this->dataRep,$this->config["appServerConfig"]);
        $e_user = new e_user($e_dbIdentifier, $this->config["appServerConfig"]);
        
        
        if ($_REQUEST["crud"] == "remove" or $_REQUEST["crud"] == "change") {
            $options['fields'][]='user_name';
            
            if ($this->config["helpers"]['crud_encryptPrimaryKeys']) {
                session_start();
            } else $userId=$_REQUEST['users_id'];
            
            $userId=$_REQUEST['users_id'];
            
            $options['where'][]='users.id='.$userId;
            $userInfo=$this->baseModel->fetch($options);
            $oldUserName=$userInfo['results'][0]['user_name'];
            
            $userNameChanged=false;
            if ($_REQUEST["crud"] == "change") {
                if ($oldUserName != $_REQUEST['users_user_name']) {
                    $userNameChanged=true;
                }
            }
            
        }
        
        if ($_REQUEST['users_password']=='') {
            unset($_REQUEST['users_password']); //Avoid saving password if empty
        }
        
        $crudResult=$this->crud($this->baseModel,$this->dataRep);
        
        if ($crudResult=='ok') {
            if ($_REQUEST["crud"] == "add" or $_REQUEST["crud"] == "change" ) {

                if ($_REQUEST["crud"] == "add") {
                    $userId=$this->baseModel->dataRep->getLastInsertId();
                }
                else{
                    $userId=$_REQUEST['users_id'];
                }
                
                if ( key_exists('users_password', $_REQUEST)) {
                    $encodedPassword = $e_dbIdentifier->encodePassword($_REQUEST['users_password']);
                    $this->baseModel->savePassword($userId, $encodedPassword);
                }                
                
                $_REQUEST['user']=$_REQUEST['users_user_name'];
                $e_user->profile($_REQUEST);            

                $info=array();
                $info['modifiedStamp']=time();
                $e_user->saveInfo($info);
                
            }
            if($_REQUEST["crud"] == "remove" or $_REQUEST["crud"] == "change") {
                
                if ($_REQUEST["crud"] == "remove" or $userNameChanged) {
                    $_REQUEST['user']=$oldUserName;
                    $e_user->profile($_REQUEST);            
                    $e_user->removeControlFile();
                }
                
            }
        }
        
    }

}

?>
