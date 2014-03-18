<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/applications/models/table_applications.php";


class applicationsModel extends baseModel {

    var $tables="applications";
    var $label=array();

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_applications();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $this->label=array(
            "es_es"=>"Aplicaciones",
        );  
    }
    
//    function dataCall() {
//        
//        
//        if (key_exists('field', $_REQUEST)) {
//
//            $relationField = $_REQUEST['field'];
//            $options["fields"][] = "{$this->primaryKey} AS relationId";
//            $options["fields"][] = "$relationField AS relationField";
//        }
//        if (key_exists('id', $_REQUEST)) {
//            $relationId = $_REQUEST['id'];
//            
//            if ($relationId != '') {
//                $options["where"][] = "$this->primaryKey='$relationId'";
//            }
//            
//
//        }
//
//        return $this->fetch($options);
//        
//    }
    
}

?>
