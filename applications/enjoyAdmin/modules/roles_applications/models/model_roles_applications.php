<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles_applications/models/table_roles_applications.php";

class roles_applicationsModel extends modelBase {

    var $tables="roles_applications";
    var $label=array();
    var $subModels=array();

    function __construct($dataRep, $config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_roles_applications();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $applicationsModel=$this->getModuleModelInstance("applications");
        $rolesModel=$this->getModuleModelInstance("roles");
        
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
