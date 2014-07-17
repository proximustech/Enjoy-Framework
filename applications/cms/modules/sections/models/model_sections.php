<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/cms/modules/sections/models/table_sections.php";

require_once "applications/cms/modules/portals/models/model_portals.php";


class sectionsModel extends modelBase {

    var $tables="sections";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_sections();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $portalsModel=new portalsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Secciones",
        );
        
        $this->foreignKeys = array (
            "portals_id" => array(
                "model"=>&$portalsModel,
                "keyField"=>"portals.id",
                "dataField"=>"portal",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$portalsModel ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"topics",
                    "act"=>"index",
                    "keyField"=>"sections_id",
                    "label"=>array(
                        "es_es" =>"Temas",
                    ),
                ),              
            ),
        );

    }
    
}