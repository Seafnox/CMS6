<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Permissions')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
	array('label'=>Yii::t('app', 'View'),'url'=>array('view','id'=>$model->id)),
	);
	?>

	<h1><?php echo Yii::t('app', 'Update'); ?> <?php echo Yii::t('app', 'Permission'); ?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>