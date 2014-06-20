<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles_applications_modules/models/table_roles_applications_modules.php";

require_once "applications/enjoyAdmin/modules/roles_applications/models/model_roles_applications.php";
require_once "applications/enjoyAdmin/modules/modules/models/model_modules.php";


class roles_applications_modulesModel extends modelBase {

    var $tables="roles_applications_modules";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_roles_applications_modules();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $roles_applicationsModel=new roles_applicationsModel($dataRep,$config);
        $modulesModel=new modulesModel($dataRep,$config);

        $this->label=array(
            "es_es"=>'Permisos de Modulos',
        );
        
        $this->foreignKeys = array(
            "id_role_app" => array(
                "model"=>&$roles_applicationsModel,
                "keyField"=>'roles_applications.id',
                "dataField"=>"_CONCAT(roles.name,'-',applications.name)",
             ),
            "id_module" => array(
                "model"=>&$modulesModel,
                "keyField"=>'modules.id',
                "dataField"=>"name",
             ),
            
        );
        
    }
    
}

?>
