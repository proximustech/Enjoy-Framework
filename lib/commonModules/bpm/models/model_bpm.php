<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "lib/commonModules/bpm/models/table_bpm.php";

class bpmModel extends modelBase {

    var $tables;
    var $bpmModel="someThing"; //To avoid infinite bpmLoading

    function __construct($dataRep, &$config,$bpmTables="") {
        $this->tables=$bpmTables.'_bpm';
        parent::__construct($dataRep, $config);
        $table=new table_bpm();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=$this->getModuleModelInstance("---");
                
        $this->label=array(
            "es_es"=>"Flujo de ".$_REQUEST['bpm_title'],
        );
    }
    
    function getData($processId) {
        
        $options['fields'][]='state';
        $options['where'][]='id_process='.$processId;
        $options['additional'][]='ORDER BY id DESC LIMIT 1';
        $resultArray = $this->fetch($options);
        if (count($resultArray['results'])) {
            $result['state'] = $resultArray["results"][0]['state'];        
        }
        else{
            $result['state'] = $this->config['bpmFlow']['initialState'];        
        }
        
        return $result;
    }
    
}