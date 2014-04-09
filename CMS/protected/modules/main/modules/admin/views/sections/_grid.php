<?php

// Грид категорий

// JS для ajax сортировки данных
$js_sort = <<< EOD
function(event) {
    var url = $(this).attr('href');
    $.get(url, function(response) {
       $.fn.yiiGridView.update('section-grid');
    });
    event.preventDefault();
}
EOD;

$buttons = array
(

    'update'=>array('visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'),
    'view'=>array('visible'=>'Yii::app()->user->checkAccess("readModel", array("model"=>$data))'),
    'enter' => array
    (
        'label' => Yii::t('app', 'Enter'),
        'icon' => 'share-alt',
        'url' => 'Yii::app()->createUrl("/main/admin/sections/", array("parent_id"=>$data->id))',
    )
);

$template = '{enter}{view}{update}';

if($parent_id != 0) {

    $buttons['up'] = array
    (
        'label' => Yii::t('app', 'Up'),
        'icon' => 'arrow-up',
        'url' => 'Yii::app()->createUrl("/main/admin/sections/up", array("id"=>$data->id))',
        'click' => $js_sort,
        'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'
    );

    $buttons['down'] = array
    (
        'label' => Yii::t('app', 'Down'),
        'icon' => 'arrow-down',
        'url' => 'Yii::app()->createUrl("/main/admin/sections/down", array("id"=>$data->id))',
        'click' => $js_sort,
        'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'
    );

    $template = '{up}{down}'.$template;


}

$this->widget('bootstrap.widgets.TbGridView', array(

    'id' => 'section-grid',
    'enableHistory'=>true,
    'type'=>'striped bordered condensed',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'class'=>'CCheckBoxColumn', // Checkboxes
            'selectableRows'=>2,        // Allow multiple selections
            'checkBoxHtmlOptions'=>array(
                'name'=>'items[]'
            ),
            'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data)) || Yii::app()->user->checkAccess("deleteModel", array("model"=>$data))'
        ),
        'id',
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, Yii::app()->getUrlManager()->createUrl("/main/admin/sections/", array("parent_id"=>$data->id)));',
        ),

        array(
            'name' => 'author.username',
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'header' => Yii::t('app', 'Author'),
        ),

        array(
            'header' => Yii::t('app', 'Link'),
            'filter' => '',
            'value' => '$data->getUrl()',
        ),


        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('width' => 100),
            'template' => $template,
            'buttons' => $buttons
        ),
    ),
)); ?>
