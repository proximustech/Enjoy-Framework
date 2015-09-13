<br>
<br>
<span class="eui_note blue" style="font-size: large;">&nbsp;&nbsp;<?php echo $_REQUEST["year"] ."-".$_REQUEST["month"]; ?></span>
<br>
<center>
    <table class="niceTable" width="45%">

    <?php
    $lastTotalUser="";
    $totalHours=0;
    ?>
    <script>
        var currentUserDataColumns=[];
    </script>
    <?php
    foreach ($totales as $total) {

        $registersCounter++;
        if ($total["user_name"] != $lastTotalUser) {
           
            if ($lastTotalUser != "") {
                echo "<tr><th style='text-align: right'>Total</th><td>$totalHours</td></tr>";
                echo "<tr><td colspan=2>&nbsp <div id='grafica_{$total["user_name"]}'></div>  &nbsp</td></tr>";
                $totalHours=0;
                
                ?>
                <script>
                    var <?php echo "grafica_{$total["user_name"]}" ?> = c3.generate({
                      bindto: '#<?php echo "grafica_{$total["user_name"]}" ?>',
                      data: {
                        columns: currentUserDataColumns,
                        type: 'bar',
                        onclick: function (d, element) { console.log("onclick", d, element); },
                        onmouseover: function (d) { console.log("onmouseover", d); },
                        onmouseout: function (d) { console.log("onmouseout", d); }
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
    echo "<tr><td colspan=2>&nbsp <div id='grafica_{$total["user_name"]}'></div>  &nbsp</td></tr>";
    ?>

    <script>
        var <?php echo "grafica_{$total["user_name"]}" ?> = c3.generate({
          bindto: '#<?php echo "grafica_{$total["user_name"]}" ?>',
          data: {
            columns: currentUserDataColumns,
            type: 'bar',
            onclick: function (d, element) { console.log("onclick", d, element); },
            onmouseover: function (d) { console.log("onmouseover", d); },
            onmouseout: function (d) { console.log("onmouseout", d); }
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
    </script>
    </table>
</center>