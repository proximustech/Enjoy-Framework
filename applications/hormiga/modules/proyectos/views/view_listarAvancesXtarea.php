<script>
$(document).ready(function() {
    $("#avances_tareas_table").dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sUrl": "assets/js/jquery/plugins/dataTables/languages/es_es.txt"
        }
    });    
});
</script>


<br/>
<span class="eui_note taupe">Avances por Tarea:&nbsp;&nbsp;<span style="font-weight: bolder"><?php echo $titulo; ?></span></span>
<br/>
<br/>

<table id='avances_tareas_table'>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Avance</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $avances AS $avance): ?>
        <tr>
            <td><?php echo $avance['user_name']; ?></td>
            <td><?php echo $avance['fecha_inicio']; ?></td>
            <td><?php echo $avance['avance']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>