<!--Plain Html and PHP example. Remove de hidden css property in the first div.-->
<div style="visibility: hidden">
    <ul>
    <?php foreach ($persons as $person):?>
        <?php $names[]=$person["name"]; ?>
        <li><?php echo $person['name'].' - '.$person['phone']; ?></li> 

    <?php endforeach; ?>
    </ul>
</div>


<!--Enjoy helpers example-->

<?php

$enjoyHelper="kendoui";
//$enjoyHelper="jqueryui";

require_once './lib/genericHelpers/generator.php'; 
$uig=new uiGenerator();

foreach ($names as $name) {
    $selectData.="<option value=$name >$name</option>";
}


$uiArray["grouperControl"]["selectControl"]["value"]=$selectData;

$uiJson='
{
    "grouperControl":{
        "name":"container1",
        "caption":"Controles",
        "expanded":"true",
        "value":{
            "selectControl":{"name":"select1","caption":"Select:","autoComplete":"false","t_style":"width: 200px"},
            "xControl":{"tag":"hr"},
            "dateTimeControl":{"name":"dateTime1","caption":"Fecha y Hora:"},
            "dateControl":{"name":"time1","caption":"Fecha:"},
            "1_xControl":{"tag":"span","value":"<br>"},
            "grouperControl":{
                "name":"container2",
                "caption":"M&aacute;s Controles",
                "expanded":"false",
                "value":{
                    "checkBoxControl":{"name":"checkBox1","caption":"Chequeo:","t_checked":"","value":"alfa"},
                    "radioControl":{"name":"radio1","caption":"Radio:","t_checked":"","value":"alfa"},
                    "efe_radioControl":{"name":"radio1","caption":"Radio B:","value":"beta"}                  
                }
            },
            "2_xControl":{"value":"<br>"},
            "textBoxControl":{"name":"text2","caption":"Data 1","value":"Hello","t_disabled":"true"},
            "2_textBoxControl":{"name":"text1","caption":"Data 2","value":"Every body"},
            "a_xControl":{"value":"ClickMe","tag":"button","t_onclick":"alert(\'Hola\')"}
        }
    }
}';
echo $uig->getCode($uiJson,$uiArray);

?>