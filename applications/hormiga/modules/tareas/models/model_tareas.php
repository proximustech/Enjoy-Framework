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
        
        $proyectos_etiquetas_tareasModel=$this->getModuleModelInstance("proyectos_etiquetas_tareas");
        $usuarios_proyectos_tareasModel=$this->getModuleModelInstance("usuarios_proyectos_tareas");        
                
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

        $this->subModels=array( //For many to many relations for example
            0=>array(
                "model"=>&$usuarios_proyectos_tareasModel ,
                "linkerField"=>$this->primaryKey,
                "linkedField"=>"id_tareas",
                "linkedDataField"=>"id_usuarios_proyectos",
                "type"=>"multiple",
                "commonParentModule"=>"proyectos",
            ),
            1=>array(
                "model"=>&$proyectos_etiquetas_tareasModel ,
                "linkerField"=>$this->primaryKey,
                "linkedField"=>"id_tareas",
                "linkedDataField"=>"id_proyectos_etiquetas",
                "type"=>"multiple",
                "commonParentModule"=>"proyectos",
            ),
        );

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