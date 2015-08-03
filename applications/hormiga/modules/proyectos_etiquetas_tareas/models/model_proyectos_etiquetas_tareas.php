<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/proyectos_etiquetas_tareas/models/table_proyectos_etiquetas_tareas.php";

class proyectos_etiquetas_tareasModel extends modelBase {

    var $tables="proyectos_etiquetas_tareas";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_proyectos_etiquetas_tareas();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $tareasModel=$this->getModuleModelInstance("tareas");
        $proyectos_etiquetasModel=$this->getModuleModelInstance("proyectos_etiquetas");
                
        $this->label=array(
            "es_es"=>"Etiquetas de Tareas",
        );
        
        $this->foreignKeys = array (
            "id_tareas" => array(
                "model"=>&$tareasModel,
                "keyField"=>"tareas.id",
                "dataField"=>"tarea",
                "excludedTables"=>array("proyectos"),
             ),
            "id_proyectos_etiquetas" => array(
                "model"=>&$proyectos_etiquetasModel,
                "keyField"=>"proyectos_etiquetas.id",
                "dataField"=>"_CONCAT(tipo_etiquetas.tipo_etiqueta,'_',etiquetas.etiqueta)",
                "excludedTables"=>array("proyectos"),
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