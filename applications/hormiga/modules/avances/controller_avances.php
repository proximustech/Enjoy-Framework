<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {

/*
    function __construct(&$config) {
       
        $this->bpmFlow=array(
            "initialState"=>"someState",
            "defaultInfo"=>array(),
            "states"=>array( //The diferent states that the process can have
                "state1"=>array(
                    "label"=>array(
                        "es_es"=>"",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "action1"=>array(
                            "label"=>array(
                                "es_es"=>"",
                            ),
                            "results"=>array(""),//array of possible result states
                        ),
                    )
                ),
            ),
        );
        
        parent::__construct($config);
    }

*/
    function indexAction() {
        $_REQUEST["avances_user_name"]=$_SESSION['user'];
        $this->crud($this->baseModel,$this->dataRep);
    }
    
    function mostrarAgenteAction() {
        $this->resultData['output']['tareas']=$this->baseModel->traerTareasDisponibles();
    }
    
    function iniciarAvanceAction() {
        $_REQUEST["avances_user_name"]=$_SESSION['user'];
        $_REQUEST["avances_fecha_inicio"]=date("Y-m-d H:i");
        $_REQUEST["avances_duracion_minutos"]=0;
        $_REQUEST["avances_id_tareas"]=$_REQUEST["idTarea"];
        $_REQUEST["avances_avance"]=$_REQUEST["avance"];
        $_REQUEST["crud"]="add";
        
		$this->config['permission']['add']=true;
        
        $options=array();
        $options['showCrudList']=false;
        $this->crud($this->baseModel,$this->dataRep,$options);
    }
    
    function finalizarAvanceAction() {
        
        $options=array();
        $options["where"][]="(avances.duracion_minutos = 0 or avances.duracion_minutos IS NULL)";
        $options["where"][]="avances.user_name='".$_SESSION['user']."'";
        $options["additional"][]="ORDER BY id DESC LIMIT 1";
        $result=$this->baseModel->quickFetch("",$options);
        $avance=$result[0];
        
        $_REQUEST["avances_id"]=$avance['id'];
        $_REQUEST["avances_user_name"]=$_SESSION['user'];
        $_REQUEST["avances_fecha_inicio"]=$avance['fecha_inicio'];
        $_REQUEST["avances_duracion_minutos"]=ceil((strtotime(date("Y-m-d H:i")) - strtotime($avance['fecha_inicio']) ) / 60 );
        $_REQUEST["avances_id_tareas"]=$avance['id_tareas'];
        $_REQUEST["avances_avance"]=$avance['avance']." --> ".$_REQUEST["avance"];
        $_REQUEST["crud"]="change";
        
		$this->config['permission']['change']=true;
        
        $this->resultData['useLayout']=false;
        $this->resultData['viewFile']="applications/hormiga/modules/avances/views/view_mostrarAgente.php";
        
        $options=array();
        $options['showCrudList']=false;
        $this->crud($this->baseModel,$this->dataRep,$options);
        $this->mostrarAgenteAction();
        
    }

    function utilidadesAction() {
    }
    
    function renovarSesionAction() {

        $this->resultData['useLayout']=false;

        session_start(); //Para refrescar la sesion

        $options=array();

        $options["fields"][]="SUM(duracion_minutos) AS totalMinutos";
        $options["where"][]="avances.fecha_inicio > '".date("Y-m-d")." 00:00:00'";
        $options["where"][]="avances.duracion_minutos > 0";
	$options["where"][]="avances.user_name='".$_SESSION['user']."'";

        $result=$this->baseModel->quickFetch("",$options);
        $horasAcumuladasHoy=round((($result[0]['totalMinutos'])/60),1);

        $options=array();
        $options["where"][]="(avances.duracion_minutos = 0 or avances.duracion_minutos IS NULL)";
        $options["where"][]="avances.user_name='".$_SESSION['user']."'";
        $options["additional"][]="ORDER BY id DESC LIMIT 1";
        $result=$this->baseModel->quickFetch("",$options);
        $avancePendiente=$result[0];


	$this->resultData['output']['horasAcumuladasHoy']=$horasAcumuladasHoy;
        $this->resultData['output']['horasDelAvancePendiente']=round((strtotime(date("Y-m-d H:i")) - strtotime($avancePendiente['fecha_inicio']) ) / 3600,1 );


    }

}
