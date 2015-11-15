        <?php  $kendoLanguage=substr($language,0,2).'-'.strtoupper(substr($language,-2)) ?>

        <!--<meta http-equiv="content-type" content="text/html; charset=UTF-8">-->
        <!--<meta charset="utf-8">-->  <!-- makes accents work bad-->

        <link href="assets/css/enjoy/helpers.css" rel="stylesheet">
        <link href="assets/css/enjoy/generic.css" rel="stylesheet">

        <!--<script src="assets/js/jquery/jquery-1.7.1.min.js"></script>-->
        <script src="assets/js/jquery/jquery-1.9.1.js"></script>
        
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
        <script src="assets/js/jquery/plugins/dataTables/extras/TableTools/media/js/ZeroClipboard.js" /></script>
        <script src="assets/js/jquery/plugins/dataTables/extras/TableTools/media/js/TableTools.js" /></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/dataTables/extras/TableTools/media/css/TableTools.css" />        
        <script src="assets/js/jquery/plugins/dataTables/extras/ColReorder/media/js/ColReorder.js" /></script>
        <link rel="stylesheet" href="assets/js/jquery/plugins/dataTables/extras/ColReorder/media/css/ColReorder.css" />        
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.0/css/responsive.jqueryui.min.css" />        
        
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
                    },
                    "sDom": 'R<"H"lTfr>t<"F"ip>',
                    "oTableTools": {
                        "sSwfPath": "assets/js/jquery/plugins/dataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends": "print",
					"sButtonText": "Ver solo datos"
				},
				{
					"sExtends":    "collection",
					"sButtonText": "Descargar",
					"aButtons":    [ 
                                            {
                                                    "sExtends": "csv",
                                                    "sButtonText": "en csv"
                                            },                                            
                                            {
                                                    "sExtends": "pdf",
                                                    "sButtonText": "en pdf"
                                            },                                            
                                            {
                                                    "sExtends": "copy",
                                                    "sButtonText": "al Portapapeles"
                                            },                                            
                                        ]
				}                                
			]                
                    },      
                });           
                $("body").css({"visibility":"visible"}); //show body only when it is fully loaded
                $("body").hide(0).delay(300).fadeIn(180); //Default Fade In (Warning: this line makes datatables export data buttons inoperant if configured without aButtons)
                
                $( "#crudForm" ).submit(
                    function( event ) {
                        $("#crudForm").each(
                            function(){
                                var elements=$(this).find('.eui_textBox.number');
                                
                                for (var i=0;i< elements.length;i++){
                                    var value=elements[i].value.replace(/,/g, '');;
                                    elements[i].value=value;
                                }
                               
                            }
                        );

                        if (typeof validateCrudSubmit == 'function') {
                             if (!validateCrudSubmit()){event.preventDefault();};
                        }
                    }
                );               
                
            });        
        </script>          