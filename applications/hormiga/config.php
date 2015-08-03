<?php

//Application Configuration

$config=array(
    "base"=>array(
        "appTitle"=>array(
            "es_es"=>"Hormiga",
        ),
        "appIcon"=>"assets/images/icons/hormiga.png",
        "crudHelper"=>"generic",
        "enjoyHelper"=>"kendoui",
        "language"=>"es_es",
        "defaultModule"=>"",
        "defaultAction"=>"index",
        "errorLog"=>false,
        "debug"=>true,
        "useAuthentication"=>true, //Defines if the application use permissions schema
        "publicActions"=>array( //In concordance with useAuthentication = true when some action modules does not require authentication
            //"module"=>array("action",),
        ),         
        
    ),
    "helpers"=>array(
        "crud_listMaxLines"=>"50000",
        "crud_encryptPrimaryKeys"=>false,
        
    ),
    "menu"=>array(
        //language => menu// last item points to a url
        
        "es_es"=>array(
            "Configuraci&oacute;n"=>array(
                "Tipos de Etiquetas" => "index.php?app=hormiga&mod=tipo_etiquetas",
                "Etiquetas" => "index.php?app=hormiga&mod=etiquetas",
            ),
            "Visualizaciones" => array(
                "Proyectos por estado"=>array(
                    "Pendientes" => "index.php?app=hormiga&mod=proyectos&act=informeGeneral&filtroEstadoBpm=pendiente",
                    "Activos" => "index.php?app=hormiga&mod=proyectos&act=informeGeneral&filtroEstadoBpm=activado",
                    "Pausados" => "index.php?app=hormiga&mod=proyectos&act=informeGeneral&filtroEstadoBpm=pausado",
                    "Finalizados" => "index.php?app=hormiga&mod=proyectos&act=informeGeneral&filtroEstadoBpm=finalizado",
                    "Cancelados" => "index.php?app=hormiga&mod=proyectos&act=informeGeneral&filtroEstadoBpm=cancelado",
                ),            
                "Avances por Proyecto"=>array(
                    "Pendientes" => "index.php?app=hormiga&mod=proyectos&act=listarAvancesXUsuario&filtroEstadoBpm=pendiente",
                    "Activos" => "index.php?app=hormiga&mod=proyectos&act=listarAvancesXUsuario&filtroEstadoBpm=activado",
                    "Pausados" => "index.php?app=hormiga&mod=proyectos&act=listarAvancesXUsuario&filtroEstadoBpm=pausado",
                    "Finalizados" => "index.php?app=hormiga&mod=proyectos&act=listarAvancesXUsuario&filtroEstadoBpm=finalizado",
                    "Cancelados" => "index.php?app=hormiga&mod=proyectos&act=listarAvancesXUsuario&filtroEstadoBpm=cancelado",
                ),            
                
            ),
            
            
            "Proyectos" => "index.php?app=hormiga&mod=proyectos",
            "Utilidades" => "index.php?app=hormiga&mod=avances&act=utilidades",
        ),
    ),
)

?>