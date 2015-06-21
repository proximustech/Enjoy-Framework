<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/proyectos/models/table_proyectos.php";

class proyectosModel extends modelBase {

    var $tables="proyectos";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_proyectos();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=$this->getModuleModelInstance("---");
                
        $this->label=array(
            "es_es"=>"Proyectos",
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
                  "mod"=>"tareas",
                    "act"=>"index",
                    "keyField"=>"id_proyectos",
                    "label"=>array(
                        "es_es" =>"Tareas",
                    ),
                ),              
                0=>array(
                  "mod"=>"usuarios_proyectos",
                    "act"=>"index",
                    "keyField"=>"id_proyectos",
                    "label"=>array(
                        "es_es" =>"Usuarios",
                    ),
                ),              
            ),
        );

    }
    
}