<a class="float_left" href="#" id="show_desktop" title="">
    <img src="assets/images/icons/icon_22_desktop.png" />
</a>
<ul id="dock">
<?php foreach ($desktopConfig['apps'] as $appName => $appConfig):   ?>

    <li id="icon_dock_<?php echo $appName ?>">
        <a href="#window_<?php echo $appName ?>">
            <img src="<?php echo $appConfig['base']['appIcon'] ?>" style="height:50%;" />
            <?php echo $appConfig['base']['appTitle'][$appConfig['base']['language']] ?>
        </a>
    </li>

<?php endforeach;   ?>
</ul>     