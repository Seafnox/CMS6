<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Itypes')=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('app','Are you sure you?'))),
);
?>

<h1><?php echo Yii::t('app', 'View'); ?> <?php echo Yii::t('app', 'Itypes'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'title',
),
)); ?>
