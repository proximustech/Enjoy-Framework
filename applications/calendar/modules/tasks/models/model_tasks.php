<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/calendar/modules/tasks/models/table_tasks.php";

require_once "applications/calendar/modules/projects/models/model_projects.php";


class tasksModel extends modelBase {

    var $tables="tasks";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_tasks();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $projectsModel=new projectsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Tareas",
        );
        
        $this->foreignKeys = array (
            "projects_id" => array(
                "model"=>&$projectsModel,
                "keyField"=>"projects.id",
                "dataField"=>"project",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$projectsModel ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

//        $this->dependents=array(
//            "id"=>array(
//                "mod"=>"someModule",
//                "act"=>"index",
//                "keyField"=>"field of the dependent table that references here",
//                "label"=>array(
//                    "es_es" =>"DependentCaption",
//                ),
//            ),
//        );

    }
    
}