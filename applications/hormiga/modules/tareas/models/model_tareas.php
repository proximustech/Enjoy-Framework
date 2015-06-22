<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/tareas/models/table_tareas.php";

class tareasModel extends modelBase {

    var $tables="tareas";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_tareas();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $proyectosModel=$this->getModuleModelInstance("proyectos");
                
        $this->label=array(
            "es_es"=>"Tareas",
        );
        
        $this->foreignKeys = array (
            "id_proyectos" => array(
                "model"=>&$proyectosModel,
                "keyField"=>"proyectos.id",
                "dataField"=>"proyecto",
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

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"avances",
                    "act"=>"index",
                    "keyField"=>"id_tareas",
                    "label"=>array(
                        "es_es" =>"Avances",
                    ),
                ),              
            ),
        );

    }
    
}