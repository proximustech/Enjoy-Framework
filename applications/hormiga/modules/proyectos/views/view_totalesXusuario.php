<script>
    function generarListado(){
        loadAjaxContent('index.php?app=hormiga&mod=proyectos&act=listarTotalesXusuario&year='+$("#year").val()+'&month='+$("#month").val(),'totales');
    }
</script>


<span style="font-size: xx-large;">&nbsp;&nbsp;Reporte: Proyectos por Usuario</span>

<?php

$uig=new uiGenerator();

$yearSelectData="<option value='2015' >2015</option>";

$monthSelectData="<option value='1' >Enero</option>";
$monthSelectData.="<option value='2' >Febrero</option>";
$monthSelectData.="<option value='3' >Marzo</option>";
$monthSelectData.="<option value='4' >Abril</option>";
$monthSelectData.="<option value='5' >Mayo</option>";
$monthSelectData.="<option value='6' >Junio</option>";
$monthSelectData.="<option value='7' >Julio</option>";
$monthSelectData.="<option value='8' >Agosto</option>";
$monthSelectData.="<option value='9' >Septiembre</option>";
$monthSelectData.="<option value='10' >Octubre</option>";
$monthSelectData.="<option value='11' >Noviembre</option>";
$monthSelectData.="<option value='12' >Diciembre</option>";

$uiArray["selectControl"]["value"]=$yearSelectData;
$uiJson='{
    "selectControl":{"name":"year","caption":"A&nacute;o:","autoComplete":"false"}
}';
$yearSelector=$uig->getCode($uiJson,$uiArray);

$uiArray["selectControl"]["value"]=$monthSelectData;
$uiJson='{
    "selectControl":{"name":"month","caption":"Mes:","autoComplete":"false"}
}';
$monthSelector=$uig->getCode($uiJson,$uiArray);

?>

<table>
    <tr>
        <td>
            <?php echo $yearSelector; ?>
        </td>
        <td>
            <?php echo $monthSelector; ?>
        </td>
        <td>
            <button class="eui_button" onclick="generarListado()">Generar</button>
        </td>
    </tr>
</table>
<div id="totales"></div>