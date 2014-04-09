<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Menu')=>array('index'),
	$model->title,
);

$buttons = array();

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array('create', "parent_id"=>$parent_id));

if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Update'),'url'=>array('update','id'=>$model->id));

if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index', "parent_id"=>$parent_id));

$this->menu=$buttons;

?>

<h1><?php echo Yii::t('app', 'View'); ?>  #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_bredcrumbs',array(
    'model'=>$model,
    'parent_id'=>$parent_id,
)); ?>


<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'code',
		'link',
		'target',
        array(
            'name' => 'active',
            'type' => 'raw',
            'value' => $model->active?Yii::t("app", "Yes"):Yii::t("app", "No")
        ),
        array(
            'name' => 'section.title',
            'label' => Yii::t('app', 'Section')
        ),
		array(
           'name' => 'author.username',
           'label' => Yii::t('app', 'Author')
        ),
	),
)); ?>
