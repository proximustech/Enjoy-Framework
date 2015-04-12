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
    
    function calendarList() {

        $sql=" 
            SELECT
                id,
                scheduling,
                DATE_FORMAT(event,'%m/%d/%Y %H:%i'),
                '01/01/1970 00:00',
                0,
                0,# All day
                0,
                10, # Color 0:12
                1, # Always on
                '-' AS location, #Location
                '' AS last
            FROM
                schedule

        ";

        $this->dataRep->pdo->exec("SET CHARACTER SET UTF8");
        $this->dataRep->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        $this->dataRep->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_NUM);
        return $results;
    }
    
}