<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Ielements')=>array('index', 'model'=>$this->model_class),
	$model->id,
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array_merge( array('index'), $this->buildActionUrlParams() ) );

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array_merge( array('create', 'model'=>$this->model_class), $this->buildActionUrlParams() ) );

if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Update'),'url'=>array_merge( array('update','id'=>$model->id), $this->buildActionUrlParams() ) );

if(Yii::app()->user->checkAccess('deletedel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array_merge( array('delete','id'=>$model->id), $this->buildActionUrlParams() ),'confirm'=>'Are you sure you want to delete this item?'));

$this->menu=$buttons;
?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

<?

$attributes = array('id');

$iblock = $model->getIblock();

$props = $iblock->properties;

foreach($props AS $prop) {

    if( empty($prop->show_in_view) ) continue;

    if(!empty($prop->view_code)) {

        eval("\$col=".$prop->view_code.";");
        $attributes[] = $col;

    } elseif(!empty($prop->name)) {

        $col = $prop->name;
        $attributes[] = $col;
    }



}


$rels = $iblock->getViewRelations();


?>



<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>$attributes
)); ?>


<?php

$buttons = array();

foreach($rels AS $k=>$v) {

    $buttons[] = array(

        "label" => $v["label"],
        "url" => Yii::app()->createUrl("/iblocks/admin/ielements", array("model"=>$v["model_class"], $v["model_class"]=>array($v["model_attr"]=>$model->id), "extend"=>array($v["model_attr"])))

    );

}

$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons'=>$buttons
));


?>