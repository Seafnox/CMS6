<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Tools')
);
?>

<h1><?=Yii::t('app', 'Tools')?></h1>

<div class="span4">

<h2>Установка ролей</h2>

<?


$this->widget("ext.ajax_start.AjaxStartWidget", array(

    "url"=> Yii::app()->createUrl('main/admin/tools/installroles'),
    "label"=>"Установка"

));

?>


</div>

<hr style="clear: both;" />