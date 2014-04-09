<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Itypes')=>array('index'),
	Yii::t('app', 'Create'),
);

$this->menu=array(
array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('app', 'Create'); ?> <?php echo Yii::t('app', 'Itypes'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>