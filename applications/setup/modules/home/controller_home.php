<?php

//Module Controller Class
require_once 'lib/enjoyClassBase/controllerBase.php';

class modController extends controllerBase {

    function indexAction() {
        
        $messages=array();
        
        $hashTextError="Error: The ['appServerConfig']['encryption']['hashText'] setting in applications/appServerConfig.php MUST BE set with any long string and SHOULD NOT BE empty.";
        if (isset($this->config['appServerConfig']['encryption']['hashText'])) {
            if ($this->config['appServerConfig']['encryption']['hashText']!='') {
                if (!file_exists($this->config['appServerConfig']['base']['controlPath'])) {
                    $this->createControlDirectories();
                    $messages[]="Control Directories Created";
                }

                $setUpApps=$this->setupApplications();
                $this->resultData["output"]["setUpApps"]=$setUpApps;

            } else $messages[]=$hashTextError;
     
        }
        else $messages[]=$hashTextError;
        
        $this->resultData["output"]["messages"]=$messages;
    }
    
    
    function createControlDirectories() {
        
        mkdir($this->config['appServerConfig']['base']['controlPath']);

        if ($this->config['appServerConfig']['base']['platform']=='windows')
            $directorySeparator="\\";
        else
            $directorySeparator="/";

        $controlDirectories=array('users','errorLog','files');
        foreach ($controlDirectories as $directory) {

            mkdir($this->config['appServerConfig']['base']['controlPath'].$directorySeparator.$directory);

        }    
    }
    
    function setupApplications() {
        
        $setUpApps=array();
        foreach ($this->config['appServerConfig']['apps'] as $app) {
            
            if (file_exists("./applications/$app/setup.php")) {
                if (!file_exists("./applications/$app/installed")) {
                
                    require_once "./applications/$app/setup.php";
                    $className=$app."Setup";
                    $setup=new $className($this->config['appServerConfig']);
                    $result=$setup->run();
                    list($installed,$resultText)=$result;
                    
                    if ($installed) {
                        $handle = fopen("./applications/$app/installed", "a+");
                        fwrite($handle,"If this file exists, application Setup WON'T be executed.\n");
                        fclose($handle);
                    }
                    
                    
                    $setUpApps[]=array($app,$result);
                    unset($setup);
                
                }
                
            }
    
        }
        
        return $setUpApps;
    
    }

}

?>
