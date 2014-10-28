<ul>
    
<?php foreach ($persons as $person):?>
    
    <li><?php echo $person['name'].' - '.$person['phone'] ?></li>
    
<?php endforeach; ?>
    
</ul>