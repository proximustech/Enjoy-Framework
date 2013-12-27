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
               <div class="window_aside">
                    <ul id="browser" >
                            <li><span class="folder">Folder 1</span>
                                    <ul>
                                            <li><span class="file">Item 1.1</span></li>
                                    </ul>
                            </li>
                            <li><span class="folder">Folder 2</span>
                                    <ul>
                                            <li><span class="folder">Subfolder 2.1</span>
                                                    <ul id="folder21">
                                                            <li><span class="file">File 2.1.1</span></li>
                                                            <li><span class="file">File 2.1.2</span></li>
                                                    </ul>
                                            </li>
                                            <li><span class="file">File 2.2</span></li>
                                    </ul>
                            </li>
                            <li class="closed"><span class="folder">Folder 3 (closed at start)</span>
                                    <ul>
                                            <li><span class="file">File 3.1</span></li>
                                    </ul>
                            </li>
                            <li><span class="file">File 4</span></li>
                    </ul>                     
                    <script>
                        $('#browser').removeClass('abs');
                        $('#browser').addClass('filetree');
                    </script>
                    <?php 

//                    foreach ($appConfig['menu'][$appConfig['base']['language']] as $menu => $target){
//                        $lastItem=$target;
//                        while (is_array($lastItem)) {
//    
//                        }
//                        
//                    }

                    ?>

                </div>
                <div class="window_main">
                    MenuDisplayArea                 
                </div>
            </div>
            <div class="abs window_bottom">
                Button Message
            </div>
        </div>
        <span class="abs ui-resizable-handle ui-resizable-se"></span>
    </div>

    <?php //$iconX+=80; ?>
    <?php $iconY+=80; ?>

<?php endforeach;   ?>