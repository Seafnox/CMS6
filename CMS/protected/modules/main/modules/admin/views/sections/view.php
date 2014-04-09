<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Sections')=>array('index'),
	$model->title,
);

$buttons = array();

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array('create', 'parent_id'=>$parent_id));

if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id));

if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index'));

$this->menu=$buttons;

?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

 <?php $this->renderPartial('_sect_bredcrumbs',array(
	'model'=>$model,
        'parent_id'=>$model->id,
)); ?>

<?

$parent_node = Section::model()->findByPk($model->parent_id);

$parent_title = !is_null($parent_node)?$parent_node->title:Yii::t('app', 'Root');

?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'code',
                array(
                    'label'=>Yii::t('app', 'Parent'),
                    'type'=>'raw',
                    'value'=>$parent_title,
                ),
		'image',
		array('name' => 'text', 'type'=>'raw'),
                array(
                    'label'=>Yii::t('app', 'Author'),
                    'type'=>'raw',
                    'value'=>$model->author->username,
                ),
		'controller',
		'action',
		'sort',
                array(
                    'label'=>Yii::t('app', 'Active'),
                    'type'=>'raw',
                    'value'=>($model->active==1)?Yii::t('app', 'Yes'):Yii::t('app', 'No'),
                ),
	),
)); ?>
