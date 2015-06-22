<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/tipo_etiquetas/models/table_tipo_etiquetas.php";

class tipo_etiquetasModel extends modelBase {

    var $tables="tipo_etiquetas";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_tipo_etiquetas();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=$this->getModuleModelInstance("---");
                
        $this->label=array(
            "es_es"=>"Tipo de Etiquetas",
        );
        
//        $this->foreignKeys = array (
//            "id_---" => array(
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
                  "mod"=>"etiquetas",
                    "act"=>"index",
                    "keyField"=>"id_tipo_etiquetas",
                    "label"=>array(
                        "es_es" =>"Etiquetas",
                    ),
                ),              
            ),
        );

    }
    
}