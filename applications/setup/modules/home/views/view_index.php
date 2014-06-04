<style>
    .error{ color: red;font-size: large }
</style>

<div style="border-style: solid;border-radius: 5px;width: 200px">
<span style="font-weight: bolder">Enjoy</span> Installation Services<br>
</div>
<br>
Messages:<br>
____________________________________<br>
<ul>
<?php foreach ($messages as $message ): ?>
    <li><?php  echo $message  ?></li>
<?php endforeach ?>
</ul>
<br>
<br>
Applications to Install:<br>
<span style="font-size: small">( Those with "setup.php" structure in the root of the application directory and with No "installed" file. )<br></span>
____________________________________<br>
<ul>
<?php foreach ($setUpApps as $appInfo ): ?>
    <?php  
        list($app,$result)=$appInfo;
        list($installed,$resultText)=$result;  
        if ($installed) {
            $installed='<span>true</span>';
        }
        else $installed='<span class="error" >false</span>';
    
    ?>
    <li><?php echo $app; ?>: Installed (<?php echo $installed ; ?>) - <?php echo $resultText; ?></li>
<?php endforeach ?>
</ul>