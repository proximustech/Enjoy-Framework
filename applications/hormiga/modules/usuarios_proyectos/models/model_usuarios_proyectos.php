<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/usuarios_proyectos/models/table_usuarios_proyectos.php";
require_once "applications/hormiga/modules/usuarios_proyectos/models/model_users.php";
require_once "applications/enjoyAdmin/dataRep/app_dataRep.php";
class usuarios_proyectosModel extends modelBase {

    var $tables="usuarios_proyectos";
    var $usersModel;

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_usuarios_proyectos();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        //$---Model=$this->getModuleModelInstance("---");
        $this->usersModel=new usersModel(new enjoyAdminDataRep(),$this->config);
        $proyectosModel=$this->getModuleModelInstance("proyectos");
        
        
        $this->label=array(
            "es_es"=>"Usuarios de Proyecto",
        );
        
        $this->foreignKeys = array (
            "id_users" => array(
                "model"=>&$this->usersModel,
                "keyField"=>"users.id",
                "dataField"=>"user_name",
             ),
            "id_proyectos" => array(
                "model"=>&$proyectosModel,
                "keyField"=>"proyectos.id",
                "dataField"=>"proyecto",
             ),
        );

//        $this->subModels=array( //For many to many relations for example
//            0=>array(
//                "model"=>&$usuariosModel ,
//                "linkerField"=>$this->primaryKey,
//                "linkedField"=>"external field that references this primary key",
//                "linkedDataField"=>"similar as a foreignKey dataField",
//                "type"=>"multiple",
//            ),
//        );

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"avances",
                    "act"=>"index",
                    "keyField"=>"id_usuarios_proyectos",
                    "label"=>array(
                        "es_es" =>"Avances",
                    ),
                ),              
            ),
        );

    }
    
}