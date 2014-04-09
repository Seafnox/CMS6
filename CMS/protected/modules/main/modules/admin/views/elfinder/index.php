<?php
    $this->breadcrumbs=array(
        Yii::t('app', 'File manager')
    );
?>

<h1><?=Yii::t('app', 'File manager')?></h1>
<?php

$this->widget('ext.elfinder.ElFinderWidget', array(
        'connectorRoute' => 'main/admin/elfinder/connector',
    )
);

?>