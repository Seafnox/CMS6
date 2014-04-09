<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Templates')=>array('index'),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('app', 'Create'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>