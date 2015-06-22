<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/hormiga/modules/usuarios_proyectos/models/table_users.php";

class usersModel extends modelBase {

    var $tables="users";
    var $label=array();

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_users();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $this->label=array(
            "es_es"=>"Usuarios",
        );        
        
        
    }
    
    
}

?>
