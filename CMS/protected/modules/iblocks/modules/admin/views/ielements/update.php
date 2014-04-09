<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Ielements')=>array('index', 'model'=>$this->model_class),
	$model->id=>array('view','id'=>$model->id, 'model'=>$this->model_class),
	'Update',
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array_merge( array('index'),  $this->buildActionUrlParams() ) );

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=> array_merge( array('create'),  $this->buildActionUrlParams() ) );

if(Yii::app()->user->checkAccess('readModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'View'),'url'=>array_merge( array('view','id'=>$model->id), $this->buildActionUrlParams() ) );

$this->menu=$buttons;
?>

<h1><?php echo Yii::t('app', 'Update'); ?>  #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>