<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Include Areas')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index'));

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array('create'));

if(Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'View'),'url'=>array('view','id'=>$model->id));


$this->menu=$buttons;

?>

<h1><?php echo Yii::t('app', 'Update'); ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'section_id'=>$section_id)); ?>