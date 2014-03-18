<?php  

    $viewLanguage=array(
        "es_es"=>array(
            "quit"=>"Salir",
        ),
        
    )

?>
<html lang="en">

    <head>
        
        <script src="assets/js/jquery/jquery-1.7.1.min.js"></script>
        <script src="assets/js/jquery/ui/jquery-ui.js"></script>
        <link rel="stylesheet" href="assets/js/jquery/themes/redmond/jquery-ui.css" />

        <script type="text/javascript" src="assets/js/jquery/plugins/w2ui/w2ui-1.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/js/jquery/plugins/w2ui/w2ui-1.3.min.css" />
        
        <script src="assets/js/jquery/plugins/treeview/jquery.treeview.js" type="text/javascript"></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/treeview/jquery.treeview.css" />

        <script src="assets/js/jquery/plugins/desktop/jquery.desktop.js"></script>
        <link rel="stylesheet" href="assets/css/reset.css" />
        <link rel="stylesheet" href="assets/css/desktop.css" />
        
        <!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/css/ie.css" />
        <![endif]-->        

        <script>

            var actualDesktop='';
            var desktopsContents = new Object;
            var barContents = new Object;

            function loadIframeContent(url,container){
                
                $('#'+container).html("<iframe id='iframe_"+container+"' style='width:100%;height:100%' />");
                document.getElementById('iframe_'+container).src = url
            } 



            function desktopChange(name){
                
                if ( actualDesktop != '' ) {
                    desktopsContents[actualDesktop]=$('#desktop').html();
                    barContents[actualDesktop]=$('#bar_bottom').html();
                }
                if ((name in desktopsContents)) {
                    actualDesktop=name;
                    $('#desktop').html(desktopsContents[name]);
                    $('#bar_bottom').html(barContents[name]);
                }
                else{
                    actualDesktop=name;
                    $.ajax({
                        url: "index.php",
                        type: "GET",
                        data:  {
                            app:'jqDesktop',
                            mod:'home',
                            act:'getDesktop',
                            desktopName: name , 
                        } ,
                        dataType: "html" ,

                    }).done( function( result ) { 
                        $('#desktop').html(result);
                    });            
                    $.ajax({
                        url: "index.php",
                        type: "GET",
                        data:  {
                            app:'jqDesktop',
                            mod:'home',
                            act:'getBottomBar',
                            desktopName: name , 
                        } ,
                        dataType: "html" ,

                    }).done( function( result ) { 
                        $('#bar_bottom').html(result);
                    });    
                }
                
                //Hide Top Menu
                $('a.active, tr.active').removeClass('active');
                $('ul.menu').hide();
            
            }

        </script>        

    </head>

    <body style="background-image: url('assets/images/misc/wallpaper.jpg')">

        <div class="abs" id="wrapper">
            <div class="abs" id="bar_top">
                <ul>
                <?php foreach ($topMenuConfig as $menu => $notUsted):?>
                
                    <li>
                        <a class="menu_trigger" href="#"><?php  echo $menu  ?></a>
                        <ul class="menu">
                            
                            <?php foreach ($topMenuConfig[$menu] as $subMenu => $targetDesktop): ?>
                            <li>
                                <a href="#" onclick="desktopChange('<?php echo $targetDesktop  ?>')"><?php echo $subMenu   ?></a>
                            </li>
                            <?php endforeach; ?>
                            <li>
                                <hr>
                            </li>
                            <li>
                                <a href="#" onclick="window.open('index.php?app=jqDesktop&mod=home&act=logout', '_self');"  ><?php  echo $viewLanguage[$language]['quit'] ?></a>
                            </li>
                        </ul>
                    </li>
                
                <?php endforeach; ?>
                </ul>                
            </div>
            <div class="abs" id="desktop">
            </div>
            <div class="abs" id="bar_bottom">
            </div>
        </div>     
     
    </body>

</html>