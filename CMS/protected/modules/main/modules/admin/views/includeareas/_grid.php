<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'include-area-grid',
    'enableHistory'=>true,
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        'code',
        array(
            'name' => 'section.title',
            'header'=>Yii::t('app', 'Sections'),
            'filter'=>Section::getListData(),
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'delete'=>array('visible'=>'Yii::app()->user->checkAccess("deleteModel", array("model"=>$data))'),
                'update'=>array('visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'),
                'view'=>array('visible'=>'Yii::app()->user->checkAccess("readModel", array("model"=>$data))'),
            ),
        ),
    ),
)); ?>
