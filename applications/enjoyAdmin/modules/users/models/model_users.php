<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once "applications/enjoyAdmin/modules/users/models/table_users.php";
require_once 'applications/enjoyAdmin/modules/roles/models/model_roles.php';

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
        
        $rolesModel = new rolesModel($dataRep, $config);

        $this->foreignKeys = array (
            "id_role" => array(
                "model"=>&$rolesModel,
                "keyField"=>'roles.id',
//                "dataField"=>"name",
                "dataField"=>"_CONCAT(roles.id,'-',roles.name)",
             ),
        );
        
    }
    
    function savePassword($userId,$encodedPassword) {
        
        $sql = "UPDATE $this->tables SET password='$encodedPassword' WHERE id=$userId";
        $query = $this->dataRep->prepare($sql);
        $query->execute();
    }
    
}

?>
