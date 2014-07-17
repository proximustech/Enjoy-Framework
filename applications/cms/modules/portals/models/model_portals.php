<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/cms/modules/portals/models/table_portals.php";

//require_once "applications/cms/modules/---/models/model_---.php";


class portalsModel extends modelBase {

    var $tables="portals";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_portals();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=new ---Model($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Portales",
        );
        
//        $this->foreignKeys = array (
//            "---_id" => array(
//                "model"=>&$---Model,
//                "keyField"=>"theOthertableName.idPossibly",
//                "dataField"=>"another Field of the foreign table with data",
//             ),
//        );

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
                  "mod"=>"sections",
                    "act"=>"index",
                    "keyField"=>"portals_id",
                    "label"=>array(
                        "es_es" =>"Secciones",
                    ),
                ),              
            ),
        );

    }
    
}