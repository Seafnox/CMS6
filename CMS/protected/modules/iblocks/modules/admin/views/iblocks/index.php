<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Iblocks')=>array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){

    var data = $(this).serialize();

    if(window.history.pushState)
        window.history.pushState({}, '', '?'+data);

	$.fn.yiiGridView.update('Iblocks-grid', {
		data: data
	});

	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage'); ?></h1>

<p>
Вы можете использовать следующие операторы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) в начале поискового запроса для уточнения вашего запроса.
</p>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?$this->renderPartial("_grid", array("model"=>$model))?>
