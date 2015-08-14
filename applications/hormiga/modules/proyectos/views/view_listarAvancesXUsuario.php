<span style="font-size: xx-large;">&nbsp;&nbsp;Avances por Usuario. Estado proyecto: <span style="font-weight: bolder"> <?php echo $stateLabel; ?></span></span>
<br/>

<table class="crudTable">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Proyecto</th>
            <th>Tarea</th>
            <th>Fecha</th>
            <th>Avance</th>
            <th>Minutos</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach( $avances AS $avance): ?>
        <tr>
            <td><?php echo $avance['user_name']; ?></td>
            <td><?php echo $avance['proyecto']; ?></td>
            <td><?php echo $avance['tarea']; ?></td>
            <td><?php echo $avance['fecha_inicio']; ?></td>
            <td><?php echo $avance['avance']; ?></td>
            <td><?php echo $avance['duracion_minutos']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>
