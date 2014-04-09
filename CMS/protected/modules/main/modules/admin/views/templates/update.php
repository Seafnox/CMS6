<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Templates')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
	array('label'=>Yii::t('app', 'View'),'url'=>array('view','id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('app', 'Update'); ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>