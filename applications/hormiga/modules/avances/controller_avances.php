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
        
        $options=array();
        $options['showCrudList']=false;
        $this->crud($this->baseModel,$this->dataRep,$options);
    }
    
    function finalizarAvanceAction() {
        
        $options=array();
        $options["where"][]="(avances.duracion_minutos = 0 or avances.duracion_minutos IS NULL)";
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
        
        $this->resultData['useLayout']=false;
        $this->resultData['viewFile']="applications/hormiga/modules/avances/views/view_mostrarAgente.php";
        
        $options=array();
        $options['showCrudList']=false;
        $this->crud($this->baseModel,$this->dataRep,$options);
        $this->mostrarAgenteAction();
        
    }
    function utilidadesAction() {
        
    }

}