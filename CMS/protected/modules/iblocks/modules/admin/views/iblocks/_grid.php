<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'type'=>'striped bordered condensed',
    'enableHistory'=>true,
    'id'=>'Iblocks-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        'code',
        array(
            'header'=>Yii::t('app', 'Model'),
            'type'=>'raw',
            'value'=>'Iblocks::getModelName($data->code)'
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('width'=>100),
            'template'=>'{props}{view}{update}{delete}',
            'buttons'=>array
            (
                'props' => array
                (
                    'label'=>Yii::t('app', 'Properties'),
                    /*'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',*/
                    'icon'=>'wrench',
                    'url'=>'Yii::app()->createUrl("iblocks/admin/iproperty", array("iblock_id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>