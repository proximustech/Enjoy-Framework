<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';
require_once $modelsDir."table_$mod.php";

class moduleModel extends modelBase {

    var $tables="roles";

    function __construct($dataRep, $config) {
        parent::__construct($dataRep, $config);
        $table=new table_module();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
    }
    
}

?>
