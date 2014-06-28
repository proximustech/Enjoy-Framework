<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/calendar/modules/schedule/models/table_schedule.php";

//require_once "enjoyAdmin/users/modules/users/models/model_users.php";


class scheduleModel extends modelBase {

    var $tables="schedule";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_schedule();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
//        $usersModel=new usersModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Agendamientos",
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