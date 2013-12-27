<?php

interface navigator_Interface
{
    function __construct($config);
    public function action($act,$label,&$parametersArray=array());
}
interface table_Interface
{
    function __construct($config);
    public function get($results,$headers,$additionalFiledsConfig=null);
}

interface crud_Interface
{
    function __construct($config,$fieldsConfig);
    public function getForm($primaryKey, $register = null);
    public function listData($primaryKey,$results,$limit=0);
}

?>
