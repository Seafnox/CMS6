<?php

// JS для ajax сортировки данных
$js_sort =<<< EOD
function(event) {
    var url = $(this).attr('href');
    $.get(url, function(response) {
       $.fn.yiiGridView.update('property-grid');
    });
    event.preventDefault();
}
EOD;

$this->widget('bootstrap.widgets.TbGridView',array(
    'type'=>'striped bordered condensed',
    'enableHistory'=>true,
    'id'=>'property-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        'name',
        'tab',
        'type',
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
                    /*'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',*/
                    'icon'=>'arrow-up',
                    'url'=>'Yii::app()->createUrl("admin/iblocks/iproperty/up", array("id"=>$data->id, "iblock_id"=>'.$iblock_id.'))',
                    'click'=>$js_sort
                ),
                'down' => array
                (
                    'label'=>Yii::t('app', 'Down'),
                    /*'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',*/
                    'icon'=>'arrow-down',
                    'url'=>'Yii::app()->createUrl("admin/iblocks/iproperty/down", array("id"=>$data->id, "iblock_id"=>'.$iblock_id.'))',
                    'click'=>$js_sort
                ),
            ),
        ),
    ),
)); ?>