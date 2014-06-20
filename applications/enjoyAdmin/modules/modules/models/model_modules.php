<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/modules/models/table_modules.php";

require_once "applications/enjoyAdmin/modules/applications/models/model_applications.php";


class modulesModel extends modelBase {

    var $tables="modules";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_modules();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $applicationsModel=new applicationsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Modulos",
        );
        
        $this->foreignKeys = array (
            "id_app" => array(
                "model"=>&$applicationsModel,
                "keyField"=>'applications.id',
                "dataField"=>"name",
             ),
        );
        
    }
    
}

?>
