<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Sections') => array('index'),
    Yii::t('app', 'Manage'),
);

$buttons = array();

if(Yii::app()->user->checkAccess('listModels', array("model"=>$model)))
    $buttons[] = array('label'=>Yii::t('app', 'List'),'url'=>array('index'));

if(Yii::app()->user->checkAccess('createModel', array("model"=>$model)))
    $buttons[] = array('label' => Yii::t('app', 'Create'), 'url' => array('create', 'parent_id' => $parent_id));

$this->menu = $buttons;

$cs = Yii::app()->clientScript;

$cs->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
    var data = $(this).serialize();

    if(window.history.pushState)
        window.history.pushState({}, '', '?'+data);

	$.fn.yiiGridView.update('section-grid', {
		data: data
	});
	return false;
});
");

$cs->registerScript('action-buttons', "

function getSectionSelectedIds() {

     var inps = $('#section-grid input[name=\"items[]\"]:checked');

     var items = [];

     inps.each(function(){

            items.push($(this).val());

     });

    return items;

}


$('.to-delete').on('click', function(e){


    if(confirm('".Yii::t('app', 'A you shure?')."')) {

        var qs = $('#sections-grid-form').serialize();

        var url = '".Yii::app()->createUrl("main/admin/sections/groupdelete")."';

        $.post(url, qs, function(response) {
            $.fn.yiiGridView.update('section-grid');
        });

    }

    e.preventDefault();


});

$('.section-replace').on('click', function(e){

    $('#replace-bl').toggle();

    if($('#replace-bl').css('display') != 'none') {

        $('#section-grid input[name=\"items[]\"], #all_items').prop('disabled', true);

        var items = getSectionSelectedIds();

        $.get('".Yii::app()->createUrl("main/admin/sections/sectionslisthtml")."', {items: items}, function(data) {

            $('#replaceIn').html(data);

        });


    } else {

        $('#section-grid input[name=\"items[]\"], #all_items').prop('disabled', false);

    }


    e.preventDefault();

});

$('.do-replace').on('click', function(e) {

    var items = getSectionSelectedIds();

    var section_id =  $('#replaceIn').val();

    $.get('".Yii::app()->createUrl("main/admin/sections/replace")."', {items: items, section_id: section_id}, function(data) {

           $.fn.yiiGridView.update('section-grid');

    });

     e.preventDefault();

});



");


?>

<h1><?php echo Yii::t('app', 'Manage'); ?></h1>


<?php $this->renderPartial('_sect_bredcrumbs', array(
    'model' => $model,
    'parent_id' => $parent_id,
)); ?>




<p>
    Вы можете использовать следующие операторы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) в начале поискового запроса для уточнения вашего запроса.
</p>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<form id="sections-grid-form">

    <?$this->renderPartial("_grid", array("model"=>$model, "dataProvider"=>$dataProvider, "parent_id"=>$parent_id))?>


</form>

    <div class="form-actions form-inline">

    <?if($model->hasDeleted($dataProvider->getDAta())):?>
        <a class="btn btn-danger to-delete" href="#">Удалить</a>
    <?endif;?>

    <?if($model->hasUpdated($dataProvider->getDAta())):?>
        <a class="btn section-replace">Перенести в категорию</a>

        <span id="replace-bl" style="display: none;">

            <?=CHtml::dropDownList("replaceIn", 0, array())?>

            <a class="btn btn-primary do-replace" href="#">Ok</a>

        </span>
    <?endif;?>

    </div>

