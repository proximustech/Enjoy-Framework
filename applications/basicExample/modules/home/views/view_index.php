<!--Plain Html and PHP example-->

<ul>
<?php foreach ($persons as $person):?>
    
    <li><?php echo $person['name'].' - '.$person['phone'];$names.=$person["name"].","; ?></li>
    
<?php endforeach; ?>
</ul>


<!--Enjoy helpers example-->

<?php

$enjoyHelper="kendoui";
$enjoyHelper="jqueryui";

require_once './lib/genericHelpers/generator.php'; 
$uig=new uiGenerator();

$var="<br>";

$jsonUi='
{
    "grouperControl":{
        "name":"container1",
        "caption":"Information",
        "expanded":"true",
        "value":{
            "xControl":{"tag":"label","value":"Click Below"},
            "grouperControl":{
                "name":"container2",
                "caption":"More Information",
                "expanded":"false",
                "value":{
                    "xControl":{"tag":"label","value":"'.$names.'"}
                }
            },
            "2_xControl":{"value":"<br>"},
            "textBoxControl":{"name":"text2","caption":"Data 1","value":"Hello","t_disabled":"true"},
            "2_textBoxControl":{"name":"text1","caption":"Data 2","value":"Every body"}
        }
    }
}';
echo $uig->getCode($jsonUi);

?>