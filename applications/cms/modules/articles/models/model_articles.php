<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/cms/modules/articles/models/table_articles.php";

require_once "applications/cms/modules/topics/models/model_topics.php";


class articlesModel extends modelBase {

    var $tables="articles";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_articles();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $topicsModel=new topicsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Articulos",
        );
        
        $this->foreignKeys = array (
            "topics_id" => array(
                "model"=>&$topicsModel,
                "keyField"=>"topics.id",
                "dataField"=>"_concat(portals.portal,'_',sections.section,'_',topics.topic)",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$topicsModel ,
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
    
    function getArticles() {
        
        $options["where"][]="portals.portal='{$_REQUEST['portal']}'";
        $options["where"][]="sections.section='{$_REQUEST['section']}'";
        $options["where"][]="topics.topic='{$_REQUEST['topic']}'";
        
        $options['config']['set']='utf8'; // To avoid errors in the json encoding
        
        return $this->fetch($options);
        
    }
    
}