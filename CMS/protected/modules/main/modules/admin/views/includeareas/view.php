<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Include Areas')=>array('index'),
	$model->title,
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index'));

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array('create'));

if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id));

if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));

$this->menu=$buttons;
?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name' => 'section_id', 'value'=>!empty($model->section)?$model->section->title:null),
		'title',
		'code',
	),
)); ?>
