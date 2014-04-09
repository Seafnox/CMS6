<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Iproperty')=>array('index', 'iblock_id'=>$_GET["iblock_id"]),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index', 'iblock_id'=>$_GET["iblock_id"])),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create', 'iblock_id'=>$_GET["iblock_id"])),
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

	$.fn.yiiGridView.update('property-grid', {
		data: data
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage')." ".$iblock_title; ?></h1>

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

<?$this->renderPartial("_grid", array("model"=>$model, "iblock_id"=>$iblock_id))?>

<div class="alert">Для привязки инфоблока к категориям создайте в свойствах связь MANY_MANY с именем sections и привязкой к модели Section</div>
