<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles_applications_components/models/table_roles_applications_components.php";

require_once "applications/enjoyAdmin/modules/roles_applications/models/model_roles_applications.php";
require_once "applications/enjoyAdmin/modules/components/models/model_components.php";


class roles_applications_componentsModel extends modelBase {

    var $tables="roles_applications_components";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_roles_applications_components();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $roles_applicationsModel=new roles_applicationsModel($dataRep,$config);
        $componentsModel=new componentsModel($dataRep,$config);

        $this->label=array(
            "es_es"=>'Permisos de Componentes',
        );        
        
        $this->foreignKeys = array(
            "id_role_app" => array(
                "model"=>&$roles_applicationsModel,
                "keyField"=>'roles_applications.id',
                "dataField"=>"_CONCAT(roles.name,'-',applications.name)",
             ),
            "id_component" => array(
                "model"=>&$componentsModel,
                "keyField"=>'components.id',
                "dataField"=>"name",
             ),
            
        );
            
        
    }
    
    
}

?>
