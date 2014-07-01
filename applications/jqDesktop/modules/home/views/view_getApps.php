<div data-role="page" id="mainMenu" data-theme="a" ><!-- dialog-->
    <div id="content" class="ui-content" role="main">
        <div data-role="header">
            <a data-icon="back" href="index.php?app=jqDesktop&mod=home&act=index" > &nbsp; </a>
            <h1><?php echo $header; ?></h1>
        </div><!-- /header -->            
        
        <?php foreach ($desktopConfig['apps'] as $appName => $appConfig):   ?>
        <a class="ui-btn" href="index.php?app=jqDesktop&mod=home&act=getAppMenu&desktopName=<?php echo $desktop; ?>&appName=<?php echo $appName ?>" >
            <img src="<?php echo $appConfig['base']['appIcon'] ?>" /><br>
            <?php echo $appConfig['base']['appTitle'][$appConfig['base']['language']] ?>
        </a>
        <?php endforeach;   ?>
        
    </div>
</div>   
