<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/roles/models/table_roles.php";

class rolesModel extends modelBase {

    var $tables="roles";

    function __construct($dataRep, $config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_roles();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $this->label=array(
            "es_es"=>"Roles",
        );
        
        $roles_applicationsModel=$this->getModuleModelInstance("roles_applications");
        
        $this->subModels=array(

            0=>array(
                "model"=>&$roles_applicationsModel ,
                "linkerField"=>$this->primaryKey,
                "linkedField"=>'id_role',
                "linkedDataField"=>'id_app',
                "type"=>'multiple',
            ),
        );
                
        
        
        $this->dependents=array(
            "id"=>array(
                
                0=>array(
    //                "selfCaptionField"=>"name",
    //                "model"=>&$usersModel,
    //                "modelFk"=>"role_id",
                    "mod"=>"users",
                    "act"=>"index",
                    "keyField"=>"id_role",
                    "label"=>array(
                        "es_es" =>"Usuarios",
                    ),
                    
                ),                
                
            ),
            
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
