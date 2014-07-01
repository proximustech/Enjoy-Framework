<!DOCTYPE html>
<html>
    
    <!--LAYOUT FOR THE MOBILE VERSION. THE DESKTOP VERSION USES NOT LAYOUT-->
    
    <head>

	<link rel="stylesheet" href="assets/js/jquery/plugins/jquerymobile/jquery.mobile-1.4.2.min.css">
	<script src="assets/js/jquery/jquery-1.7.1.min.js"></script>
	<script src="assets/js/jquery/plugins/jquerymobile/jquery.mobile-1.4.2.min.js"></script>      
        
        <script>
     
            function logout(){
                window.open('index.php?app=jqDesktop&mod=home&act=logout', '_self');
            }             
            
        </script>
    </head>
    <body id="body">
        <?php  require_once $viewFile;  ?>     
    </body>
</html>