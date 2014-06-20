<?php

function showTreeMenu($menuArray,$appName) {
    
    global $isAdmin;
    global $privileges;


    $finalResult="";
    foreach ($menuArray as $menu =>$target) {
        
        if (is_array($target)) {
            $tempResult=showTreeMenu($target,$appName);
            if ($tempResult != "") {
                $finalResult.= "<li><span class='folder'>$menu</span><ul>";
                $finalResult.= $tempResult;
                $finalResult.= "</ul></li>";
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
                $finalResult.= "<li><a href='#!' onclick=\"loadIframeContent('$target','window_main_$appName')\"><span class='file'>$menu</span></a></li>";
            }
            
        }
        
    }
    
    return $finalResult;
    
}


?>

<?php $iconX=20 ?>
<?php $iconY=20 ?>

<?php foreach ($desktopConfig['apps'] as $appName => $appConfig):   ?>

    <a class="abs icon" style="left:<?php echo $iconX ?>px;top:<?php echo $iconY ?>px;" href="#icon_dock_<?php echo $appName ?>">
      <img src="<?php echo $appConfig['base']['appIcon'] ?>" />
      <?php echo $appConfig['base']['appTitle'][$appConfig['base']['language']] ?>
    </a>

    <div id="window_<?php echo $appName ?>" class="abs window">
        <div class="abs window_inner">
            <div class="window_top">
                <span class="float_left">
                    <img src="<?php echo $appConfig['base']['appIcon'] ?>" style="height:50%;" />
                    <?php echo $appConfig['base']['appTitle'][$appConfig['base']['language']] ?>
                </span>
                <span class="float_right">
                    <a href="#" class="window_min"></a>
                    <a href="#" class="window_resize"></a>
                    <a href="#icon_dock_<?php echo $appName ?>" class="window_close"></a>
                </span>
            </div>
            <div class="abs window_content">
                <div class="window_aside" >
                    <script>
                        $(document).ready(function() {

                            $("#leftMenu_<?php echo $appName ?>").treeview({
                                persist: "location",
                                collapsed: true,
                                unique: false
                            });

                        });
                    </script>
                    <ul id="leftMenu_<?php echo $appName ?>" class="filetree" style="font-size: 14px">
                    <?php 

                    echo showTreeMenu($appConfig['menu'][$appConfig['base']['language']],$appName);
                    
                    ?>
                    </ul>
                </div>
                <div class="window_main" id="window_main_<?php echo $appName ?>">
                </div>
            </div>
            <div class="abs window_bottom">
                ***
            </div>
        </div>
        <span class="abs ui-resizable-handle ui-resizable-se"></span>
    </div>

    <?php //$iconX+=80; ?>
    <?php $iconY+=80; ?>

<?php endforeach;   ?>