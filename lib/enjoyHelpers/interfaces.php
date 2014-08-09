<?php

interface navigator_Interface
{
    /**
     * Creates Application navigators
     * @param type $config general Config
     */
    function __construct($config);
    /**
     * Creates links
     * @param string $act Action
     * @param string $label
     * @param array $parametersArray
     */
    public function action($act,$label,&$parametersArray=array());
}
interface table_Interface
{
    /**
     * Creates Tables
     * @param model $model
     */
    function __construct(&$model);
    /**
     * Generates the table
     * @param array $results registers
     * @param array $headers
     * @param array $additionalFiledsConfig Edit, Delete, etc.
     */
    public function get($results,$headers,$additionalFiledsConfig=null);
}

interface messages_Interface
{
    public function errorMessage($message);
    public function operationStatus($message,$okOperation);
}
interface crud_Interface
{
    /**
     * Generates crud views
     * @param model $model
     */
    function __construct($model);
    /**
     * Displays a form
     * @param array $register
     */
    public function getForm($register = null);
    /**
     * Displays a list of registers
     * @param array $results
     * @param int $limit
     */
    public function listData($results,$limit=0);
}

?>
