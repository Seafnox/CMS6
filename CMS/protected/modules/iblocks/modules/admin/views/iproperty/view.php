<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Property')=>array('index', 'iblock_id'=>$model->iblock_id),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index', 'iblock_id'=>$model->iblock_id)),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create', 'iblock_id'=>$model->iblock_id)),
	array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'iblock_id',
		'title',
		'name',
		'field',
		'data_code',
		'list_code',
		array(
                'label'=>Yii::t('app', 'Show In List'),
                'type'=>'raw',
                'value'=>($model->show_in_list==1)?Yii::t('app', 'Yes'):Yii::t('app', 'No'),    
                 ),
                 'type',
	),
)); ?>
