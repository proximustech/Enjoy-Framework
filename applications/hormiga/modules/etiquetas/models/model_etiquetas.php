<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/etiquetas/models/table_etiquetas.php";

class etiquetasModel extends modelBase {

    var $tables="etiquetas";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_etiquetas();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $tipo_etiquetasModel=$this->getModuleModelInstance("tipo_etiquetas");
                
        $this->label=array(
            "es_es"=>"Etiquetas",
        );
        
        $this->foreignKeys = array (
            "id_tipo_etiquetas" => array(
                "model"=>&$tipo_etiquetasModel,
                "keyField"=>"tipo_etiquetas.id",
                "dataField"=>"tipo_etiqueta",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$tipo_etiquetasModel ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"proyectos",
                    "act"=>"index",
                    "keyField"=>"proyectos_etiquetas.id_etiquetas",
                    "label"=>array(
                        "es_es" =>"Proyectos",
                    ),
                ),              
            ),
        );

    }
    
}