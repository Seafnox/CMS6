<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Permissions')=>array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
array('label'=>Yii::t('app', 'Manage'),'url'=>array('index')),
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
$.fn.yiiGridView.update('permission-grid', {
    data: data
});
return false;
});
");

Yii::app()->clientScript->registerScript('group-delete', "


$('.to-delete').on('click', function(e){


bootbox.confirm('".Yii::t('app', 'A you shure?')."', function(conf){


if(conf) {

var qs = $('#permission-form').serialize();

var url = '".Yii::app()->createUrl($this->uniqueId."/groupdelete")."';

$.post(url, qs, function(response) {
$.fn.yiiGridView.update('permission-grid');
});

}

})



e.preventDefault();


});



");



?>

<h1><?php echo Yii::t('app', 'Manage'); ?> <?php echo Yii::t('app', 'Permissions'); ?></h1>

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

<form id="permission-form">

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
<div class="form-actions form-inline">
    <a class="btn btn-danger to-delete" href="#">Удалить</a>
</div>

</form>