<?php
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'enableHistory'=>true,
    'type'=>'striped bordered condensed',
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name'=>'image',
            'type'=>'raw',
            'value'=>'"<a href=".$data->getFirstFileRelPath()."><img src=".ImageResizer::r($data->getFirstFilePath(), 100)." /></a>"'
        ),
        'username',
        'email',
        'role',
        'name',
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
