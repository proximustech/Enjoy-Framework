<br>
<br>
<span class="eui_note blue" style="font-size: large;">&nbsp;&nbsp;<?php echo $_REQUEST["year"] ."-".$_REQUEST["month"]; ?></span>
<br>
<br>
<center>
    <table class="niceTable" width="85%">

    <?php
    $lastTotalUser="";
    $totalHours=0;
    ?>
    <script>
        var currentUserDataColumns=[];
    </script>
    <?php
    $registersCounter=0;
    foreach ($totales as $total) {

        $registersCounter++;
        if ($total["user_name"] != $lastTotalUser) {
           
            if ($lastTotalUser != "") {
                $previousRegisterCounter=$registersCounter-1;
                echo "<tr><th style='text-align: right'>Total</th><td>$totalHours</td></tr>";
                echo "<tr><td style='width:50%'><div id='grafica_$previousRegisterCounter'></div></td><td style='width:50%'><div id='divGraficaTareas_{$total["user_name"]}'></div>&nbsp</td></tr>";                
                $totalHours=0;
                ?>
                <script>
                    var <?php echo "grafica_$previousRegisterCounter" ?> = c3.generate({
                      bindto: '#<?php echo "grafica_$previousRegisterCounter" ?>',
                      data: {
                        columns: currentUserDataColumns,
                        type: 'bar',
                        onclick: function (d, element) { showTasksGraph(d.name,"<?php echo $total["user_name"]; ?>","<?php echo "divGraficaTareas_{$total["user_name"]}"; ?>"); },                        
                      },
                      axis: {
                        x: {
                          type: 'categorized'
                        }
                      },
                      bar: {
                        width: {
                          ratio: 0.3,
                          //max: 30
                        },
                      }
                    });
                    
                    var currentUserDataColumns=[];
                </script>
                <?php                 
                
            }
            
            echo "<tr><th colspan=2><center>{$total["user_name"]}</center></th></tr>";
            echo "<tr><th>Proyecto</th><th>Horas</th></tr>";
            $lastTotalUser = $total["user_name"];
        }
        
        ?>
        <script>
            currentUserDataColumns.push([<?php echo "'{$total["proyecto"]}',{$total["total_horas"]}" ?>]);
        </script>
        <?php        

        echo "<tr><td>{$total["proyecto"]}</td><td>{$total["total_horas"]}</td></tr>";
        $totalHours+=$total["total_horas"];

    }
    echo "<tr><th style='text-align: right'>Total</th><td>$totalHours</td></tr>";
    echo "<tr><td style='width:50%'><div id='grafica_$registersCounter'></div></td><td style='width:50%'><div id='divGraficaTareas_{$total["user_name"]}'></div>&nbsp</td></tr>";                
    ?>

    <script>
        var lastChart = c3.generate({
          bindto: '#<?php echo "grafica_$registersCounter" ?>',
          data: {
            columns: currentUserDataColumns,
            type: 'bar',
            onclick: function (d, element) { showTasksGraph(d.name,"<?php echo $total["user_name"]; ?>","<?php echo "divGraficaTareas_{$total["user_name"]}"; ?>"); },
            //onclick: function (d, element) { console.log("onclick", d, element); },
            //onmouseover: function (d) { console.log("onmouseover", d); },
            //onmouseout: function (d) { console.log("onmouseout", d); }
          },
          axis: {
            x: {
              type: 'categorized'
            }
          },
          bar: {
            width: {
              ratio: 0.3,
              //max: 30
            },
          }
        });
        
        function showTasksGraph(id,user,div){
            loadAjaxContent("index.php?app=hormiga&mod=proyectos&act=listarTotalesTareaXusuario&user="+user+"&proyecto="+id+'&year='+$("#year").val()+'&month='+$("#month").val(),div)
        }
        
    </script>
    </table>
</center>