<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Property')=>array('index', 'iblock_id'=>$model->iblock_id),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index', 'iblock_id'=>$model->iblock_id)),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create', 'iblock_id'=>$model->iblock_id)),
	array('label'=>Yii::t('app', 'View'),'url'=>array('view','id'=>$model->id )),
);
?>

<h1><?php echo Yii::t('app', 'Update'); ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>