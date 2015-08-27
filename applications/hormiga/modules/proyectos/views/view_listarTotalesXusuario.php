<br>
<br>
<span class="eui_note blue" style="font-size: large;">&nbsp;&nbsp;<?php echo $_REQUEST["year"] ."-".$_REQUEST["month"]; ?></span>
<br>
<center>
    <table class="niceTable" width="45%">

    <?php
    $lastTotalUser="";
    $totalHours=0;
    foreach ($totales as $total) {

        $registersCounter++;
        if ($total["user_name"] != $lastTotalUser) {
            
            if ($lastTotalUser != "") {
                echo "<tr><th>Total Horas:</th><td>$totalHours</td></tr>";
                $totalHours=0;
            }
            
            echo "<tr><td colspan=2>&nbsp</td></tr>";
            echo "<tr><th colspan=2><center>{$total["user_name"]}</center></th></tr>";
            echo "<tr><th>Proyecto</th><th>Horas</th></tr>";
            $lastTotalUser = $total["user_name"];
        }

        echo "<tr><td>{$total["proyecto"]}</td><td>{$total["total_horas"]}</td></tr>";
        $totalHours+=$total["total_horas"];

    }
    echo "<tr><th style='text-align: right'>Total</th><td>$totalHours</td></tr>";
    ?>

    </table>
</center>