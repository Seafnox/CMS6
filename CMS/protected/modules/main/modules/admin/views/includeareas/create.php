<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Include Areas')=>array('index'),
	Yii::t('app', 'Create'),
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index'));

$this->menu=$buttons;

?>

<h1><?php echo Yii::t('app', 'Create'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'section_id'=>$section_id)); ?>