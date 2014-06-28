<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/calendar/modules/projects/models/table_projects.php";


class projectsModel extends modelBase {

    var $tables="projects";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_projects();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
                
        $this->label=array(
            "es_es"=>"Proyectos",
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

                    "mod"=>"tasks",
                    "act"=>"index",
                    "keyField"=>"projects_id",
                    "label"=>array(
                        "es_es" =>"Tareas",
                    ),
                    
                ),
            ),
        );

    }
    
}