<h4>
    <div class="eui_note blue" style="width: 75%">
        <b><?php echo $firstFieldLabel; ?>: (<?php echo $bpmFlow['states'][$bpmData['state']]['label'][$language]; ?>)</b><br>
        <?php echo $firstFieldData; ?>
    </div>
</h4>    
<center>
    <hr>
    <?php
    
    $baseParameters=array(
        "app={$config["flow"]["app"]}",
        "mod={$config["flow"]["mod"]}",
        "crud=editForm",
        $primaryKeyParameter,
    );
        
    if (isset($keyFieldParameters)) {
        $baseParameters=array_merge($baseParameters,$keyFieldParameters);
    }
        
    $baseParametersString= implode("&", $baseParameters);
    $uig=new uiGenerator();

    foreach ($bpmData['stateConfig']['actions'] as $action => $actionConfig) {
        
        $hasActionPermission=0;
        foreach ($config['componentsData'] as $componentName =>$componentPermission) {
            if ($componentName=='bpm.*') {
                $hasActionPermission=$componentPermission;
            }
            elseif ($componentName=='bpm.'.$mod.'.*') {
                $hasActionPermission=$componentPermission;
            }
            elseif ($componentName=='bpm.'.$mod.'.'.$bpmData['state'].'.*') {
                $hasActionPermission=$componentPermission;
            }
            elseif ($componentName=='bpm.'.$mod.'.'.$bpmData['state'].'.'.$action) {
                $hasActionPermission=$componentPermission;
            }
        }
        
        if ($hasActionPermission) {
            $parametersString=$baseParametersString.'&'."act=$action";

            $uiJson='{
                "xControl":{
                    "tag":"button",
                    "value":"'.$actionConfig['label'][$language].'",
                    "t_style":"width:100%",
                    "t_class":"eui_button",
                    "t_onclick":"window.open(\'index.php?'.$parametersString.'\',\'_self\');"
                }
            }';
            echo $uig->getCode($uiJson,$uiArray)."<br>";
            
        }
        
    }
    ?>
</center>