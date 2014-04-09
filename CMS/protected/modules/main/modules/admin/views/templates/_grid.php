<?php

// JS для ajax сортировки данных
$js_sort =<<< EOD
function(event) {
    var url = $(this).attr('href');
    $.get(url, function(response) {
       $.fn.yiiGridView.update('template-grid');
    });
    event.preventDefault();
}
EOD;


$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'template-grid',
    'enableHistory'=>true,
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        array(
            'name' => 'code',
            'type' => 'html',
            'value' => 'CHtml::link($data->code, Yii::app()->getUrlManager()->createUrl("/main/admin/templates/editfile/", array("id"=>$data->id)));',
        ),
        'cond',
        'sort',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('width'=>100),
            'template'=>'{up}{down}{view}{update}{delete}',
            'buttons'=>array
            (
                'up' => array
                (
                    'label'=>Yii::t('app', 'Up'),
                    'icon'=>'arrow-up',
                    'url'=>'Yii::app()->createUrl("/main/admin/templates/up/", array("id"=>$data->id))',
                    'click'=>$js_sort
                ),
                'down' => array
                (
                    'label'=>Yii::t('app', 'Down'),
                    'icon'=>'arrow-down',
                    'url'=>'Yii::app()->createUrl("/main/admin/templates/down/", array("id"=>$data->id))',
                    'click'=>$js_sort
                ),
            ),
        ),
    ),
)); ?>