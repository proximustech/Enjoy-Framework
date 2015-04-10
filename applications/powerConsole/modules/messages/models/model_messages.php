<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/powerConsole/modules/messages/models/table_messages.php";

class messagesModel extends modelBase {

    var $tables="messages";

    function __construct($dataRep, $config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_messages();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=$this->getModuleModelInstance("---");
                
        $this->label=array(
            "es_es"=>"You Should set the label of the Module.",
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