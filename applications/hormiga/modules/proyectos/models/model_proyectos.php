<?php

//Model Class

require_once "lib/enjoyClassBase/modelBase.php";
require_once "applications/hormiga/modules/proyectos/models/table_proyectos.php";

class proyectosModel extends modelBase {

    var $tables="proyectos";

    function __construct($dataRep, &$config,&$incomingModels=array()) {
        parent::__construct($dataRep, $config,$incomingModels);
        $table=new table_proyectos();
        $this->fieldsConfig=$table->fieldsConfig;
        $this->primaryKey=$table->primaryKey;
        
        $proyectos_etiquetasModel=$this->getModuleModelInstance("proyectos_etiquetas");
        $usuarios_proyectosModel=$this->getModuleModelInstance("usuarios_proyectos");
                
        $this->label=array(
            "es_es"=>"Proyectos",
        );
        
//        $this->foreignKeys = array (
//            "id_proyectos_etiquetas" => array(
//                "model"=>&$proyectos_etiquetasModel,
//                "keyField"=>"theOthertableName.idPossibly",
//                "dataField"=>"another Field of the foreign table with data",
//             ),
//        );

        $this->subModels=array( //For many to many relations for example
            0=>array(
                "model"=>&$proyectos_etiquetasModel ,
                "linkerField"=>$this->primaryKey,
                "linkedField"=>"id_proyectos",
                "linkedDataField"=>"id_etiquetas",
                "type"=>"multiple",
            ),
            1=>array(
                "model"=>&$usuarios_proyectosModel ,
                "linkerField"=>$this->primaryKey,
                "linkedField"=>"id_proyectos",
                "linkedDataField"=>"id_users",
                "type"=>"multiple",
            ),
        );

        $this->dependents=array(
            "id"=>array(
                0=>array(
                  "mod"=>"tareas",
                    "act"=>"index",
                    "keyField"=>"id_proyectos",
                    "label"=>array(
                        "es_es" =>"Tareas",
                    ),
                ),              
                1=>array(
                  "mod"=>"usuarios_proyectos",
                    "act"=>"index",
                    "keyField"=>"id_proyectos",
                    "label"=>array(
                        "es_es" =>"Usuarios",
                    ),
                ),              
            ),
        );

    }
    function avancesXUsuario($estado) {
        
        $sql="
            select 
                    enjoy_admin.users.user_name,
                    hormiga.proyectos.proyecto,
                    hormiga.tareas.tarea,
                    hormiga.avances.fecha_inicio,
                    hormiga.avances.avance
            from 
                    enjoy_admin.users
                    JOIN hormiga.usuarios_proyectos ON enjoy_admin.users.id=hormiga.usuarios_proyectos.id_users
                    JOIN hormiga.proyectos ON hormiga.proyectos.id=hormiga.usuarios_proyectos.id_proyectos
                    JOIN hormiga.tareas ON hormiga.tareas.id_proyectos=hormiga.proyectos.id
                    JOIN hormiga.avances ON hormiga.tareas.id=hormiga.avances.id_tareas
            WHERE
                    hormiga.proyectos.id IN (

                            SELECT 
                                    id_process
                            FROM 
                                    proyectos_bpm
                            WHERE 
                                    id IN(
                                            SELECT MAX(id)
                                            FROM proyectos_bpm
                                            GROUP BY id_process
                                    ) 
                                    AND state = '$estado'	

                    )            

        ";
        
//        $this->dataRep->pdo->exec("SET CHARACTER SET UTF8");
//        $this->dataRep->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
//        $this->dataRep->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    
}