<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/components/models/table_components.php";

require_once "applications/enjoyAdmin/modules/applications/models/model_applications.php";


class componentsModel extends modelBase {

    var $tables="components";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_components();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $applicationsModel=new applicationsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Componentes",
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
