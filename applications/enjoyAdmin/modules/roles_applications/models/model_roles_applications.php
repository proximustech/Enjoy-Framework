<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles_applications/models/table_roles_applications.php";

require_once "applications/enjoyAdmin/modules/applications/models/model_applications.php";


class roles_applicationsModel extends baseModel {

    var $tables="roles_applications";
    var $label=array();
    var $subModels=array();

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_roles_applications();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $applicationsModel=new applicationsModel($dataRep,$config);
                
        $this->label=array(
            "es_es"=>"Roles Aplicaciones",
        );
        
        $this->foreignKeys = array (
            "id_app" => array(
                "model"=>&$applicationsModel,
                "keyField"=>'applications.id',
//                "dataField"=>"name",
                "dataField"=>"name",
             ),
        );        
        
//        $this->subModels=array(
//            $this->primaryKey=>array(
//                "subModel"=>&$applicationsModel,
//                "linkedField"=>'applications.id',
//            ),
//        );
        
//        $this->dependents=array(
//            "id"=>array(
////                "selfCaptionField"=>"name",
////                "model"=>&$usersModel,
////                "modelFk"=>"role_id",
//                "mod"=>"users",
//                "act"=>"index",
//                "keyField"=>"role_id",
//                "label"=>array(
//                    "es_es" =>"Usuarios",
//                ),
//            ),
//            
//        );
        
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
