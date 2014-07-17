<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/cms/modules/topics/models/table_topics.php";

require_once "applications/cms/modules/sections/models/model_sections.php";


class topicsModel extends modelBase {

    var $tables="topics";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_topics();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $sectionsModel=new sectionsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Temas",
        );
        
        $this->foreignKeys = array (
            "sections_id" => array(
                "model"=>&$sectionsModel,
                "keyField"=>"sections.id",
                "dataField"=>"_concat(portals.portal,'-',sections.section)",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$---Model ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"articles",
                    "act"=>"index",
                    "keyField"=>"topics_id",
                    "label"=>array(
                        "es_es" =>"Articulos",
                    ),
                ),              
            ),
        );

    }
    
}