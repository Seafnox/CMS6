<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Iblocks')=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'code',
                'backend_controller',
                'fronted_controller',
                'fronted_action',
                  array(
                    'label'=>Yii::t('app', 'Active'),
                    'type'=>'raw',
                    'value'=>($model->active==1)?Yii::t('app', 'Yes'):Yii::t('app', 'No'),
                ),
	),
)); ?>
