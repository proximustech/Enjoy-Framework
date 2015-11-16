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
//                1=>array(
//                  "mod"=>"usuarios_proyectos",
//                    "act"=>"index",
//                    "keyField"=>"id_proyectos",
//                    "label"=>array(
//                        "es_es" =>"Usuarios",
//                    ),
//                ),              
            ),
        );

    }
    function avancesXtarea($idTarea) {
        
        $sql="
            select 
                    hormiga.avances.user_name,
                    hormiga.avances.fecha_inicio,
                    hormiga.avances.avance
            from 
                    hormiga.tareas
                    JOIN hormiga.avances ON hormiga.tareas.id=hormiga.avances.id_tareas
            WHERE
                    hormiga.tareas.id = $idTarea          

        ";
        
//        $this->dataRep->pdo->exec("SET CHARACTER SET UTF8");
//        $this->dataRep->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
//        $this->dataRep->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    function avancesXUsuario($estado) {
        
        $sql="
            select 
                    hormiga.avances.user_name,
                    hormiga.proyectos.proyecto,
                    hormiga.tareas.tarea,
                    hormiga.avances.fecha_inicio,
                    hormiga.avances.duracion_minutos,
                    hormiga.avances.avance
            from 
                    hormiga.proyectos
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
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    function etiquetasXproyecto($id_proyecto) {
        
        $sql="
            select 
                    etiquetas.id,
                    etiquetas.etiqueta
            from 
                    hormiga.etiquetas
                    JOIN hormiga.proyectos_etiquetas ON hormiga.etiquetas.id=hormiga.proyectos_etiquetas.id_etiquetas
                    JOIN hormiga.proyectos ON hormiga.proyectos.id=hormiga.proyectos_etiquetas.id_proyectos

            WHERE
                    hormiga.proyectos.id =$id_proyecto       

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    function usuariosXproyecto($id_proyecto) {
        
        $sql="
            select 
                    enjoy_admin.users.id,
                    enjoy_admin.users.user_name
            from 
                    enjoy_admin.users
                    JOIN hormiga.usuarios_proyectos ON enjoy_admin.users.id=hormiga.usuarios_proyectos.id_users
                    JOIN hormiga.proyectos ON hormiga.proyectos.id=hormiga.usuarios_proyectos.id_proyectos

            WHERE
                    hormiga.proyectos.id =$id_proyecto       

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    function usuariosXtarea($id_tarea) {
        
        $sql="
            select 
                    enjoy_admin.users.id,
                    enjoy_admin.users.user_name
            from 
                    enjoy_admin.users
                    JOIN hormiga.usuarios_proyectos ON enjoy_admin.users.id=hormiga.usuarios_proyectos.id_users
                    JOIN hormiga.usuarios_proyectos_tareas ON hormiga.usuarios_proyectos_tareas.id_usuarios_proyectos=hormiga.usuarios_proyectos.id
                    JOIN hormiga.tareas ON hormiga.usuarios_proyectos_tareas.id_tareas=hormiga.tareas.id

            WHERE
                    hormiga.tareas.id =$id_tarea

        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    
    function proyectosXbpm($estado) {
        
        $sql="
            SELECT 
                hormiga.proyectos.id,
                hormiga.proyectos.proyecto,
                hormiga.proyectos.prioridad AS prioridad_proyecto,
                hormiga.proyectos.comentarios AS comentarios_proyecto,
                hormiga.tareas.id AS id_tarea,
                hormiga.tareas.tarea,
                (SELECT tareas_bpm.state FROM tareas_bpm WHERE tareas_bpm.id_process=tareas.id ORDER BY tareas_bpm.id DESC LIMIT 1) AS tarea_bpm_state,
                hormiga.tareas.prioridad AS prioridad_tarea,
                hormiga.tareas.comentarios AS comentarios_tarea
            FROM 
                hormiga.proyectos
                JOIN hormiga.tareas ON hormiga.tareas.id_proyectos=hormiga.proyectos.id
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
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;        
        
    }
    
    function totalesXusuario() {
        $month=$_REQUEST["month"];
        $year=$_REQUEST["year"];
        
        if ($month==12) {
            $nextMonth=1;
            $nextYear=$year+1;
        }
        else{
            $nextMonth=$month + 1;
            $nextYear=$year;
        }
        
        
        $month=$_REQUEST["month"];
        
        $sql="
            SELECT 
                avances.user_name,
                proyectos.proyecto,
                ROUND(SUM(avances.duracion_minutos)/60,1) AS total_horas
            FROM 
                proyectos
                JOIN tareas ON tareas.id_proyectos=proyectos.id
                JOIN avances ON avances.id_tareas=tareas.id
            WHERE
                avances.fecha_inicio >= '$year-$month-01 00:00:00' AND
                avances.fecha_inicio < '$nextYear-$nextMonth-01 00:00:00'
            GROUP BY
                avances.user_name,proyectos.proyecto
            ORDER BY
                avances.user_name,proyectos.proyecto
        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;           
        
    }
    
    function totalesTareaXusuario() {
        
        $proyecto=$_REQUEST["proyecto"];
        $month=$_REQUEST["month"];
        $year=$_REQUEST["year"];
        
        if ($month==12) {
            $nextMonth=1;
            $nextYear=$year+1;
        }
        else{
            $nextMonth=$month + 1;
            $nextYear=$year;
        }
              
        $month=$_REQUEST["month"];
        
        $sql="
            SELECT 
                tareas.tarea,
                ROUND(SUM(avances.duracion_minutos)/60,1) AS total_horas
            FROM 
                proyectos
                JOIN tareas ON tareas.id_proyectos=proyectos.id
                JOIN avances ON avances.id_tareas=tareas.id
            WHERE
                avances.user_name= '{$_SESSION['user']}' AND
                proyectos.proyecto = '$proyecto' AND
                avances.fecha_inicio >= '$year-$month-01 00:00:00' AND
                avances.fecha_inicio < '$nextYear-$nextMonth-01 00:00:00'
            GROUP BY
                tareas.tarea
            ORDER BY
                tareas.tarea
        ";
        
        $query = $this->dataRep->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;           
        
    }
}
