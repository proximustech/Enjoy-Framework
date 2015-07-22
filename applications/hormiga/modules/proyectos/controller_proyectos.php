<?php
        
//Module Controller Class
require_once "lib/enjoyClassBase/controllerBase.php";

class modController extends controllerBase {


    function __construct(&$config) {
       
        $this->bpmFlow=array(
            "bpmModel"=>"proyectos",
            "initialState"=>"pendiente",
            "defaultInfo"=>array(),
            "states"=>array( //The diferent states that the process can have
                "pendiente"=>array(
                    "label"=>array(
                        "es_es"=>"Pendiente",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "activar"=>array(
                            "label"=>array(
                                "es_es"=>"Activar",
                            ),
                            "results"=>array("activado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Proyecto",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),
                    )
                ),
                "activado"=>array(
                    "label"=>array(
                        "es_es"=>"Activado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "pausar"=>array(
                            "label"=>array(
                                "es_es"=>"Pausar",
                            ),
                            "results"=>array("pausado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Proyecto",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),
                        "finalizar"=>array(
                            "label"=>array(
                                "es_es"=>"Finalizar",
                            ),
                            "results"=>array("finalizado"),//array of possible result states
                        ),
                    )
                ),
                "finalizado"=>array(
                    "label"=>array(
                        "es_es"=>"Finalizado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "encolar"=>array(
                            "label"=>array(
                                "es_es"=>"Marcar como Pendiente",
                            ),
                            "results"=>array("pendiente"),//array of possible result states
                        ),                        
                    ),
                ),                
                "pausado"=>array(
                    "label"=>array(
                        "es_es"=>"Pausado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "activar"=>array(
                            "label"=>array(
                                "es_es"=>"Despausar",
                            ),
                            "results"=>array("activado"),//array of possible result states
                        ),
                        "cancelar"=>array(
                            "label"=>array(
                                "es_es"=>"Cancelar Proyecto",
                            ),
                            "results"=>array("cancelado"),//array of possible result states
                        ),                        
                    ),
                ),                
                "cancelado"=>array(
                    "label"=>array(
                        "es_es"=>"Cancelado",
                    ),
                    "actions"=>array( //This actions must be defined as controller actions
                        "encolar"=>array(
                            "label"=>array(
                                "es_es"=>"Marcar como Pendiente",
                            ),
                            "results"=>array("pendiente"),//array of possible result states
                        ),
                    ),
                ),                
            ),
        );
        
        parent::__construct($config);
    }

    /*
     * Acciones BPM
     */
    function indexAction() {
        $this->crud($this->baseModel,$this->dataRep);
    }
    function encolarAction() {
        $this->indexAction();
    }
    function activarAction() {
        $this->indexAction();
    }
    function pausarAction() {
        $this->indexAction();
    }
    function finalizarAction() {
        $this->indexAction();
    }
    function cancelarAction() {
        $this->indexAction();
    }
    
    
    /*
     * Otras acciones
     */
    
    function listarAvancesXtareaAction() {
        $this->resultData['useLayout']=false;
        
        $options=array();
        $options['fields'][]="proyectos.proyecto";
        $options['fields'][]="tareas.tarea";
        $options['where'][]="tareas.id=".$_REQUEST['idTarea'];
        $tareasModel=$this->baseModel->getModuleModelInstance("tareas");
        $tareasResult=$tareasModel->fetch($options);
        
        $this->resultData['output']['titulo']=$tareasResult['results'][0]['proyecto']." -> ".$tareasResult['results'][0]['tarea'];
        $this->resultData['output']['avances']=$this->baseModel->avancesXtarea($_REQUEST['idTarea']);
    }
    function listarAvancesXUsuarioAction() {
        $estado=$_REQUEST['filtroEstadoBpm'];
        $this->resultData['output']['avances']=$this->baseModel->avancesXUsuario($estado);
        $this->resultData['output']['stateLabel']=$this->bpmFlow['states'][$estado]['label'][$this->config["base"]["language"]];
    }
    
    function informeGeneralAction() {
        
        $estado=$_REQUEST['filtroEstadoBpm'];
        $proyectos=$this->baseModel->proyectosXbpm($estado);
        
        $etiquetasProyectos=array();
        $usuariosProyectos=array();
        $etiquetasTareas=array();
        $usuariosTareas=array();
        foreach ($proyectos as $proyecto) {
            foreach ($this->baseModel->usuariosXproyecto($proyecto['id']) as $usuario) {
                if (!in_array($usuario['user_name'], $usuariosProyectos[$proyecto['id']])) {
                    $usuariosProyectos[$proyecto['id']][]=$usuario['user_name'];
                    
                }
                foreach ($this->baseModel->usuariosXtarea($proyecto['id_tarea']) as $usuarioTarea) {
                    if (!in_array($usuarioTarea['user_name'], $usuariosTareas[$proyecto['id_tarea']])) {
                        $usuariosTareas[$proyecto['id_tarea']][]=$usuarioTarea['user_name'];
                    }
                }
            }
            foreach ($this->baseModel->etiquetasXproyecto($proyecto['id']) as $etiqueta) {
                if (!in_array($etiqueta['etiqueta'], $etiquetasProyectos[$proyecto['id']])) {
                    $etiquetasProyectos[$proyecto['id']][]=$etiqueta['etiqueta'];
                }
            }
            
        }
        
        $this->resultData['output']['usuariosProyectos']=$usuariosProyectos;
        $this->resultData['output']['etiquetasProyectos']=$etiquetasProyectos;
        $this->resultData['output']['usuariosTareas']=$usuariosTareas;
        $this->resultData['output']['proyectos']=$proyectos;
        $this->resultData['output']['stateLabel']=$this->bpmFlow['states'][$estado]['label'][$this->config["base"]["language"]];
    }
    
}