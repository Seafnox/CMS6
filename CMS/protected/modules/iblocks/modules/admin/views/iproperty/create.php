<?php
$this->breadcrumbs=array(
	Yii::t('app', 'IProperties')=>array('index', 'iblock_id'=>$_GET["iblock_id"]),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index', 'iblock_id'=>$_GET["iblock_id"])),
);
?>

<h1><?php echo Yii::t('app', 'Create'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>