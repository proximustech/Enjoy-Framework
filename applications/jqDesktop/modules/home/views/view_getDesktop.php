<?php

function showTreeMenu($menuArray,$appName) {
    
    foreach ($menuArray as $menu =>$target) {
        
        if (is_array($target)) {
            echo "<li><span class='folder'>$menu</span><ul>";
            showTreeMenu($target,$appName);
            echo "</ul></li>";
        }
        else{
              echo "<li><a href='#!' onclick=\"loadIframeContent('$target','window_main_$appName')\"><span class='file'>$menu</span></a></li>";
        }
        
    }
    
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

                    showTreeMenu($appConfig['menu'][$appConfig['base']['language']],$appName);
                    
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