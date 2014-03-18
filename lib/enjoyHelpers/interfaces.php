<?php

interface navigator_Interface
{
    function __construct($config);
    public function action($act,$label,&$parametersArray=array());
}
interface table_Interface
{
    function __construct(&$model);
    public function get($results,$headers,$additionalFiledsConfig=null);
}

interface crud_Interface
{
    function __construct($model);
    public function getForm($register = null);
    public function listData($results,$limit=0);
}

?>
