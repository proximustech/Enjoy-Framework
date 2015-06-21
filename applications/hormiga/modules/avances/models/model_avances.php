<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/avances/models/table_avances.php";

class avancesModel extends modelBase {

    var $tables="avances";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_avances();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $tareasModel=$this->getModuleModelInstance("tareas");
                
        $this->label=array(
            "es_es"=>"Avances",
        );
        
        $this->foreignKeys = array (
            "id_tareas" => array(
                "model"=>&$tareasModel,
                "keyField"=>"tareas.id",
                "dataField"=>"_CONCAT(proyectos.proyecto,'_',tareas.tarea)",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$tareasModel ,
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