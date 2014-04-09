<?php
$this->breadcrumbs=array(
	 Yii::t('app', 'Users')=>array('admin'),
	$model->id,
);

$buttons = array();

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app','Create'),'url'=>array('create'));

if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app','Update'),'url'=>array('update','id'=>$model->id));

if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app','Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app','List'),'url'=>array('index'));

$this->menu=$buttons;

?>

<h1><?php echo Yii::t('app', 'View');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'email',
        'role',
        'name',
        array(
             'name'=>'image',
             'type'=>'raw',
             'value'=>'<a href="'.$model->getFirstFileRelPath().'"><img src="'.ImageResizer::r($model->getFirstFilePath(), 100).'" /></a>'
        ),
        'phone',
         array(
               'name' => 'text',
                'type' => 'raw',
         ),
	),
)); ?>
