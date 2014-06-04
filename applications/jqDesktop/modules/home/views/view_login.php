<?php  

    $viewLanguage=array(
        "es_es"=>array(
            "identification"=>"Identificaci&oacute;n",
            "user"=>"Usuario",
            "password"=>"Clave",
        ),
        
    );
            
            
    if ($act=='logout') {
        $beginWidthTransition=true;
        $backGround='whiteWallpaper.jpg';
    }
    else {$beginWidthTransition=false;$backGround='wallpaper.jpg';}

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8" /> 

        <script src="assets/js/jquery/jquery-1.7.1.min.js"></script>
        <script src="assets/js/jquery/ui/jquery-ui.js"></script>
        <link rel="stylesheet" href="assets/js/jquery/themes/redmond/jquery-ui.css" />

        <script type="text/javascript" src="assets/js/jquery/plugins/w2ui/w2ui-1.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/js/jquery/plugins/w2ui/w2ui-1.3.min.css" />

        <link rel="stylesheet" type="text/css" href="assets/css/login.css" />

        <style>
            .alert{
                color: red !important;
            }
        </style>

        <script>
            
            <?php if($beginWidthTransition): ?>
                
            $(document).ready(function(){
                $('body').css('background-image', 'url(assets/images/misc/wallpaper.jpg)');
            });
                
            <?php endif; ?>
            

            function submitLogin(){
                   $('body').css('background-image', 'url(assets/images/misc/whiteWallpaper.jpg)');
                     window.setTimeout( submitLogin1, 1000 );
            };

            function submitLogin1() {
                
                $.ajax({
                    url: "index.php?app=jqDesktop&mod=home&act=checkLogin",
                    type: "POST",
                    data: {
                        user: $('#user').val(),
                        password: $('#password').val(),
                    },
                    dataType: "html",
                }).done(function(result) {
                    
                    if (result == 'OK') {
                        window.open('index.php?app=jqDesktop&mod=home&act=index', '_self');
                    }
                    else {
                        
                        $('#message').html(result);
                        $('#user').val('');
                        $('#password').val('');
                        $('#message').addClass('alert');
                        
                        $('body').css('background-image', 'url(assets/images/misc/wallpaper.jpg)');                        
                        
                    }

                }).fail(function(result){
                });


            }

        </script>        

    </head>

    <body valign="middle" style="transition: background 1s linear;background-image: url('assets/images/misc/<?php echo $backGround ?>') ">

        <div id="wrapper">

            <div name="login-form" class="login-form">

                <div class="header">
                    <h1>Enjoy Application Server</h1>
                    <span id="message"><?php  echo $viewLanguage[$language]['identification'] ?></span>
                </div>

                <div class="content">
                    <input id="user" name="user" type="text" class="input username" placeholder="<?php  echo $viewLanguage[$language]['user'] ?>" />
                    <div class="user-icon"></div>
                    <input id="password" name="password" type="password" class="input password" placeholder="<?php  echo $viewLanguage[$language]['password'] ?>" />
                    <div class="pass-icon"></div>		
                </div>

                <div class="footer">
                    <button onclick="submitLogin()" class="button">Ingresar</button>
                    <!--<input type="submit" name="submit" value="Login" class="button" />-->
                </div>

            </div>

        </div>

    </body>

</html>