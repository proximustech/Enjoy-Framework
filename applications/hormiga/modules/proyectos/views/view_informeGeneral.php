<style> 
    .tarea{
        background-color: #0CF; 
        border-style: solid;
        border-radius: 10px;
        border-color: black;
        font-size: 15px;
        text-align: center;
        vertical-align: middle;
        padding: 3px
                
    }    
    .tarea.pendiente {
	background-color: white;
        color: black
    }	
    .tarea.activado {
	background-color: green;
        color: white
    }
    .tarea.finalizado {
	background-color: purple;
        color: white
    }
    .tarea.pausado {
	background-color: grey;
        color: white
    }
    .tarea.cancelado {
	background-color: brown;
        color: white
    }	
</style>

<span style="font-size: xx-large;">&nbsp;&nbsp;Vista de proyectos por Estado :<span style="font-weight: bolder"> <?php echo $stateLabel; ?></span></span>
<br/>
<script>
    function mostrarAvances(id_tarea){
        loadAjaxContent('index.php?app=hormiga&mod=proyectos&act=listarAvancesXtarea&idTarea='+id_tarea,'window');
        euiOpenWindow('window');
    }
</script>

<table class="crudTable">
    <thead>
        <tr>
            <th>-</th>
            <th>Prioridad<br>Proyecto</th>
            <th>Proyecto</th>
            <th>Comentarios<br>Proyecto</th>
            <th>Prioridad<br>Tarea</th>
            <th>Tarea</th>
            <th>Comentarios<br>Tarea</th>
            <th>Usuarios</th>
            <th>Etiquetas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $proyectos AS $proyecto): ?>
        <tr>
            <td><button class="eui_button" title="Avances" onclick="mostrarAvances(<?php echo $proyecto['id_tarea']; ?>)">A</button></td>
            <td><?php echo $proyecto['prioridad_proyecto']; ?></td>
            <td><b><?php echo $proyecto['proyecto']; ?></b></td>
            <td><?php echo $proyecto['comentarios_proyecto']; ?></td>
            <td><?php echo $proyecto['prioridad_tarea']; ?></td>
            <td>
                <b>
                    <?php 
                        if (!isset($tareasBpmLabelsArray[$proyecto['tarea_bpm_state']])) {
                            $proyecto['tarea_bpm_state']="pendiente";
                        }
                        echo $proyecto['tarea']."<br>"; 
                        echo "<div class='tarea {$proyecto['tarea_bpm_state']}'>{$tareasBpmLabelsArray[$proyecto['tarea_bpm_state']]}</div>";
                    ?>
                </b>
            </td>
            <td><?php echo $proyecto['comentarios_tarea']; ?></td>
            <td>
                <?php  
                    foreach ($usuariosProyectos[$proyecto['id']] as $usuario) {
                        if (in_array($usuario, $usuariosTareas[$proyecto['id_tarea']])) {
                            echo "<b>$usuario</b><br>";
                        }else{
                            echo "$usuario<br>";
                        }
                    }
                ?>
            </td>
            <td>
                <?php  
                    foreach ($etiquetasProyectos[$proyecto['id']] as $etiqueta) {
                        echo "$etiqueta<br>";
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!--Redefinir usando EUI-->

<script>
    $(document).ready(function(){
                $(".window").kendoWindow({
                    actions: ["Maximize","Close"],
                    draggable: true,
                    visible: false,
                    position: {
                        top: 100,
                        left: 100
                    },
//                    modal: true,
//                    height: "300px",
//                    width: "500px"
//                    pinned: false,
                    resizable: true,
                    title: "-",
                });

    });


</script>

<div class='window' id='window'></div>