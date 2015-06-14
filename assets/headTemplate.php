        <?php  $kendoLanguage=substr($language,0,2).'-'.strtoupper(substr($language,-2)) ?>

        <!--<meta http-equiv="content-type" content="text/html; charset=UTF-8">-->
        <!--<meta charset="utf-8">-->  <!-- makes accents work bad-->

        <link href="assets/css/enjoy/helpers.css" rel="stylesheet">

        <script src="assets/js/jquery/jquery-1.7.1.min.js"></script>
        
        <link href="assets/js/jquery/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="assets/js/jquery/plugins/bootstrap/bootstrap-theme.min.css" rel="stylesheet">
        <script src="assets/js/jquery/plugins/bootstrap/bootstrap.min.js"></script>        
        
        <script src="assets/js/jquery/plugins/jqueryui/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/jqueryui/jquery-ui.css" />

        <script src="assets/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script src="assets/js/jquery/plugins/timepicker/jquery-ui-sliderAccess.js"></script>
        <script src="assets/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.css"></script>

        <script src="assets/js/jquery/plugins/combobox/combobox.js"></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/combobox/combobox.css">

        <link type="text/css" href="assets/js/jquery/plugins/michael-multiselect/css/ui.multiselect.css" rel="stylesheet" />
        <script type="text/javascript" src="assets/js/jquery/plugins/michael-multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
        <script type="text/javascript" src="assets/js/jquery/plugins/michael-multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="assets/js/jquery/plugins/michael-multiselect/js/ui.multiselect.js"></script>


        <script src="assets/js/jquery/plugins/dataTables/media/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/dataTables/media/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="assets/js/jquery/plugins/dataTables/media/css/jquery.dataTables_themeroller.css" />        
        
        <!--KendoUi Set-->

        <link rel="stylesheet" href="assets/js/jquery/plugins/kendoui/styles/kendo.common.min.css" />
        <link rel="stylesheet" href="assets/js/jquery/plugins/kendoui/styles/kendo.default.min.css" />

        <script src="assets/js/jquery/plugins/kendoui/js/kendo.core.min.js"></script>
        <script src="assets/js/jquery/plugins/kendoui/js/kendo.ui.core.min.js"></script>
        <script src="assets/js/jquery/plugins/kendoui/js/cultures/kendo.culture.<?php echo $kendoLanguage; ?>.min.js"></script>
        
        
        <script src="assets/js/enjoy/e_common.js"></script>
        
        <script>
            $(document).ready(function() {
                <?php  if($enjoyHelper=="kendoui"):  ?>
                    kendo.culture("<?php  echo $kendoLanguage  ?>");
                <?php  endif;  ?>
            });
        </script>
  
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
                $(".crudTable").dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "oLanguage": {
                        "sUrl": "assets/js/jquery/plugins/dataTables/languages/<?php  echo $language  ?>.txt"
                    }
                });
                $("body").css({"visibility":"visible"}); //show body only when it is fully loaded
                $("body").hide(0).delay(300).fadeIn(80); //Default Fade In
                
                $( "#crudForm" ).submit(
                    function( event ) {

                        $("#crudForm").each(
                            function(){
                                var elements=$(this).find('.eui_textBox.number');
                                
                                for (var i=0;i< elements.length;i++){
//                                    var value=elements[i].value.replace(",","");
                                    var value=elements[i].value.replace(/,/g, '');;
                                    elements[i].value=value;
                                }
                               
                            }
                        );                    

                        //event.preventDefault();
                        //$( "#crudForm" ).submit();
                    }
                );                
                
            });        
        </script>          