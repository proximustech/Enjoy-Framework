<?php

function showTreeMenu($menuArray,$appName) {
    
    global $isAdmin;
    global $privileges;


    $finalResult="";
    foreach ($menuArray as $menu =>$target) {
        
        if (is_array($target)) {
            $tempResult=showTreeMenu($target,$appName);
            if ($tempResult != "") {
                //$finalResult.= "<li><span class='folder'>$menu</span><ul>";
                $finalResult.= $tempResult;
                //$finalResult.= "</ul></li>";
            }
        }
        else{
            $showLink=true;
            if (strtolower(substr($target,0,5))=='index') { // is a link inside enjoy
                $showLink=false;
                $okApp=false;
                $urlArray=explode('?', $target);
                $parameters=$urlArray[1];
                $parametersArray=explode('&', $parameters);
                
                foreach ($parametersArray as $parameter) {
                    $parameterArray=explode('=', $parameter);
                    $name=$parameterArray[0];
                    $value=$parameterArray[1];
                    
                    if ($name=='app') {
                        if (key_exists($value, $privileges)) { // if the application is registered inside the user privileges
                            $okApp=true;
                        }
                    }
                    
                }
                
                //No matter the order of the parameters. thats why I repeat the foreach
                if ($okApp) {
                    foreach ($parametersArray as $parameter) {
                        $parameterArray = explode('=', $parameter);
                        $name = $parameterArray[0];
                        $value = $parameterArray[1];

                        if ($name == 'mod') {
                            if (key_exists($value, $privileges[$appName])) { // if the module is registered inside the user privileges of the application
                                $showLink=true;
                                
                            }
                        }
                    }
                }
                
            }
            if ($showLink or $isAdmin) {
                $finalResult.= "<a class='ui-btn' href='$target' rel='external' >$menu</a>";
            }
            
        }
        
    }
    
    return $finalResult;
    
}
$appConfig=$desktopConfig['apps'][$app];
$header=$appConfig['base']['appTitle'][$language];
$iconSource=$appConfig['base']['appIcon'];
?>
<div data-role="page" id="mainMenu" data-theme="a" >
    <div id="content" class="ui-content" role="main">
        <div data-role="header">
            <a data-icon="back" href="index.php?app=jqDesktop&mod=home&act=getApps&desktopName=<?php echo $desktop; ?>"  >&nbsp;</a>
            <h1><img src="<?php echo $iconSource ?>" />&nbsp;&nbsp;<?php echo $header; ?></h1>
        </div><!-- /header -->          
        
        <?php echo showTreeMenu($appConfig['menu'][$appConfig['base']['language']],$app);?>
        
    </div>
</div>   
