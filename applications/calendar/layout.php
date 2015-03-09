<html>
    <head>
        
        <?php require "assets/headTemplate.htm"; ?>

        <style>
            body td,th{
                font-size: 15px;
            }
            
            .crudTable tr:hover  {
                background-color: #00E7CA !important;
            }

        </style>
        
        <script>
            $(document).ready(function() {
                
                $("body").hide(0).delay(300).fadeIn(80); //Default Fade In
                
                $('.crudTable').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                        "sUrl": "assets/js/jquery/plugins/dataTables/languages/<?php  echo $language  ?>.txt"
                    }                    
                });
                
            } );
            
        </script>    
        
    </head>

    <body style="overflow: auto !important">
        <?php  require_once $viewFile;  ?>
    </body>
</html>