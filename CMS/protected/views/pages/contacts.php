<?php

echo $model->text;

?>

<h2>Агентства члены РПН</h2>

<?php
$this->widget("ext.map_manager.MapCollectionWidget", array(
    
    "models"=>$orgs
    
));

?>


