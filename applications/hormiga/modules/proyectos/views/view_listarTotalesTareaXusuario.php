<table class="niceTable" style="width: 100%">

    <?php
        echo "<tr><td>&nbsp <div id='graficaTareas_{$_REQUEST['user']}'></div>&nbsp</td></tr>";
    ?>
    
    <script>
        var currentProyectDataColumns=[];
    </script>
    
    <?php foreach( $totales AS $total): ?>
        <script>
            currentProyectDataColumns.push([<?php echo "'{$total["tarea"]}',{$total["total_horas"]}" ?>]);
        </script>
    <?php endforeach; ?>
    <script>
        var <?php echo "graficaTareas_{$_REQUEST['user']}" ?> = c3.generate({
          bindto: '#<?php echo "graficaTareas_{$_REQUEST['user']}" ?>',
          data: {
            columns: currentProyectDataColumns,
            type: 'bar',
          },
          axis: {
            x: {
              type: 'categorized'
            }
          },
          bar: {
            width: {
              ratio: 0.3,
            },
          }
        });

    </script>

</table>