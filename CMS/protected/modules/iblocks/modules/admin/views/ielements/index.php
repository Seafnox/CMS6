<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Ielements')=>array('index', 'model'=>$this->model_class),
    Yii::t('app', 'Manage'),
);

$buttons = array();

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'Create'),'url'=>array_merge( array('create'), $this->buildActionUrlParams() ) );

$this->menu=$buttons;

$cs = Yii::app()->clientScript;

$cs->registerScript('search', "
$('.search-button').click(function(event){
	$('.search-form').toggle();
	event.preventDefault();
});
$('.search-form form').submit(function(event){
	$.fn.yiiGridView.update('ielements-grid', {
		data: $(this).serialize()
	});

    if(window.history.pushState)
	    window.history.pushState({}, 'Поиск', '/admin/iblocks/ielements/?'+$(this).serialize());

    event.preventDefault();

});
");


$cs->registerScript('action-buttons', "

$('.to-delete').on('click', function(e){


    bootbox.confirm('".Yii::t('app', 'A you shure?')."', function(conf){


    if(conf) {

        var qs = $('#ielements-grid-form').serialize();

        var url = '".Yii::app()->createUrl("iblocks/admin/ielements/groupdelete")."';

        $.post(url, qs, function(response) {
            $.fn.yiiGridView.update('ielements-grid');
        });

    }

  })



    e.preventDefault();


});

$('.link-section').on('click', function(e){


    if(confirm('".Yii::t('app', 'A you shure?')."')) {

        var qs = $('#ielements-grid-form').serialize();

        var id = $('#sections').val();

        var url = '".Yii::app()->createUrl("iblocks/admin/ielements/linksection")."?id='+id;

        $.post(url, qs, function(response) {
            $.fn.yiiGridView.update('ielements-grid');
        });

    }

    e.preventDefault();


});


$('.replace-section').on('click', function(e){


    if(confirm('".Yii::t('app', 'A you shure?')."')) {

        var qs = $('#ielements-grid-form').serialize();

        var id = $('#sections').val();

        var url = '".Yii::app()->createUrl("iblocks/admin/ielements/replacesection")."?id='+id;

        $.post(url, qs, function(response) {
            $.fn.yiiGridView.update('ielements-grid');
        });

    }

    e.preventDefault();


});


$('.section-control').on('click', function(e){

    $('#section-operations').toggle();

    e.preventDefault();

}).trigger('click');

");

?>

<h1><?php echo Yii::t('app', 'Manage'); ?>: <?php echo $model->getIblock()->title?></h1>
<p>
    Вы можете использовать следующие операторы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) в начале поискового запроса для уточнения вашего запроса.
</p>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search',array(
        'model'=>$model,
    ));
    ?>
</div><!-- search-form -->

<form id="ielements-grid-form">

    <?=CHtml::hiddenField("model", $this->model_class)?>


    <?$this->renderPartial("_grid", array("model"=>$model, "dataProvider"=>$dataProvider))?>

    <!-- Панель действий -->

    <div class="form-actions form-inline">


        <!--<label class="checkbox" for="all-selected"><?=CHtml::checkBox("all-selected")?> <?=Yii::t('app', 'For all')?></label>-->

        <?if($model->hasDeleted($dataProvider->getDAta())):?>

            <a class="btn btn-danger to-delete" href="#">Удалить</a>

        <?endif;?>


        <?php

        // Если используется привязка к категориям

        $relations = $model->relations();

        if($model->hasUpdated($dataProvider->getDAta()) AND isset($relations["sections"]) AND ( $prop = $model->getProp('sections') ) ):?>

            <a class="btn btn-primary section-control" href="#"><?=Yii::t('app', 'Sections')?></a>

            <div id="section-operations" style="display: inline-block;">

            <?

            $listData = array();


            if(!empty($prop->data_code))
                eval("\$listData = ".$prop->data_code.";");

            ?>

            <?=CHtml::dropDownList("sections", 0, $listData)?>
                <div class="btn-group">
                    <a class="btn link-section" href="#"><?=Yii::t('app', 'Add to section')?></a>

                    <a class="btn replace-section" href="#"><?=Yii::t('app', 'Replace to section')?></a>
                </div>
            </div>

        <? endif; ?>


    </div>

</form>
