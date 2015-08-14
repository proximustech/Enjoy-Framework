<?php $idContenedorPrincipal=time(); ?>
<span id="<?php echo $idContenedorPrincipal ?>">

<table>
<tr>
    <td><span style="font-size: xx-large;">&nbsp;&nbsp;Registro de Avances&nbsp;&nbsp;</span></td>
    <td><iframe src="index.php?app=hormiga&mod=avances&act=renovarSesion" width='250' height='60'></iframe></td>
</tr>
</table>
<br>

<?php

$uig=new uiGenerator();

$selectData="<option value='' ></option>";
foreach ($tareas as $tarea) {
    $selectData.="<option value={$tarea['id_tarea']} >{$tarea['proyecto']} --> {$tarea['tarea']}</option>";
}
$uiArray["selectControl"]["value"]=$selectData;

$uiJson='{
        "selectControl":{"name":"tarea","caption":"Tarea:","autoComplete":"true","t_onchange":"habilitarInicio()"},
        "textAreaControl":{"name":"descripcionInicio","caption":"Descripci&oacute;n de Inicio:","t_onkeypress":"habilitarInicio()"},
        "xControl":{"name":"iniciar","value":"Iniciar","tag":"button","t_class":"eui_button","t_disabled":"","t_onclick":"iniciar()"},
        "1_textAreaControl":{"name":"descripcionFin","caption":"Descripci&oacute;n de Finalizaci&oacute;n:","t_disabled":""},
        "1_xControl":{"name":"finalizar","value":"Finalizar","tag":"button","t_class":"eui_button","t_disabled":"","t_onclick":"finalizar()"}
}';

echo $uig->getCode($uiJson,$uiArray);

?>

<script>
    
    function habilitarInicio(){

        if($("#tarea").val() !== "" && $("#descripcionInicio").val()){
            $("#iniciar").prop('disabled', false);
            
        }

    }
    
    function iniciar(){
        
        var tareaControl = $("#tarea").data("kendoComboBox");
        tareaControl.enable(false);
        $("#descripcionInicio").prop('disabled', true);
        
        $("#descripcionFin").prop('disabled', false);
        $("#iniciar").prop('disabled', true);
        $("#finalizar").prop('disabled', false);
        
        
        loadAjaxContent('index.php?app=hormiga&mod=avances&act=iniciarAvance&idTarea='+$("#tarea").val()+'&avance='+$("#descripcionInicio").val(),'');

    }
    
    function finalizar(){
        
        loadAjaxContent('index.php?app=hormiga&mod=avances&act=finalizarAvance&idTarea='+$("#tarea").val()+'&avance='+$("#descripcionFin").val(),'<?php echo $idContenedorPrincipal ?>');

    }
    
</script>
</span>
