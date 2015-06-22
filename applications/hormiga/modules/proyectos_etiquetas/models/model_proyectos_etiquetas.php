<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/proyectos_etiquetas/models/table_proyectos_etiquetas.php";

class proyectos_etiquetasModel extends modelBase {

    var $tables="proyectos_etiquetas";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_proyectos_etiquetas();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $proyectosModel=$this->getModuleModelInstance("proyectos");
        $etiquetasModel=$this->getModuleModelInstance("etiquetas");
                
        $this->label=array(
            "es_es"=>"Proyectos-Etiquetas",
        );
        
        $this->foreignKeys = array (
            "id_proyectos" => array(
                "model"=>&$proyectosModel,
                "keyField"=>"proyectos.id",
                "dataField"=>"proyecto",
             ),
            "id_etiquetas" => array(
                "model"=>&$etiquetasModel,
                "keyField"=>"etiquetas.id",
                "dataField"=>"_CONCAT(tipo_etiquetas.tipo_etiqueta,'_',etiquetas.etiqueta)",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$proyectosModel ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

//        $this->dependents=array(
//            "id"=>array(
//                0=>array(
//                  "mod"=>"someModule",
//                    "act"=>"index",
//                    "keyField"=>"field of the dependent table that references here",
//                    "label"=>array(
//                        "es_es" =>"DependentCaption",
//                    ),
//                ),              
//            ),
//        );

    }
    
}