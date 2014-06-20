<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles_applications/models/table_roles_applications.php";

require_once "applications/enjoyAdmin/modules/applications/models/model_applications.php";
require_once "applications/enjoyAdmin/modules/roles/models/model_roles.php";


class roles_applicationsModel extends modelBase {

    var $tables="roles_applications";
    var $label=array();
    var $subModels=array();

    function __construct($dataRep, $config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config);
        $table=new table_roles_applications();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $applicationsModel=new applicationsModel($dataRep,$config);
        
        if (key_exists('roles', $incomingModels)) { // Technique to avoid circular calls
            $rolesModel=&$incomingModels['roles'];
        }
        else{
            $outgoingModels = array(
                'roles_applications' => $this,
            );
            $rolesModel = new rolesModel($dataRep, $config, $outgoingModels);
        }        
        
                
        $this->label=array(
            "es_es"=>"Roles y Aplicaciones",
        );
        
        $this->foreignKeys = array (
            "id_app" => array(
                "model"=>&$applicationsModel,
                "keyField"=>'applications.id',
                "dataField"=>"name",
             ),
            "id_role" => array(
                "model"=>&$rolesModel,
                "keyField"=>'roles.id',
                "dataField"=>"name",
             ),
        );        
        
    }
    
}

?>
