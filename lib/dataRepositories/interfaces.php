<?php

/**
 * Structures the interfaces for the data repositories
 */

interface dataRep_Interface
{
    function __construct();
    function __destruct();
    public function getInstance();
    public function dbExists($dataBase);
    public function close();
}

?>
