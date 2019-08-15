<?php
if (isset($registers)) {
    $uig=new uiGenerator();
    $selectData="<option value='' ></option>";
    foreach ($registers as $register) {
        $selectData.="<option value={$register[$valueField]} >{$register[$labelField]}</option>";
    }
    $uiArray["selectControl"]["value"]=$selectData;
    $uiJson='{"selectControl":{"globalize":"false","name":"'.$controlName.'","caption":"'.$controlLabel.'","autoComplete":"true","t_onchange":"'.$controlName.'_onchange();"}}';
    echo $uig->getCode($uiJson,$uiArray);
}
?>