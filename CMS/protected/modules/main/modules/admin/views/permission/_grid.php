<?php

$permFilter = array(

    0 => Yii::t('app', 'No'),
    1 => Yii::t('app', 'Yes'),

);

$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'permission-grid',
'enableHistory'=>true,
'type'=>'striped bordered condensed',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
array(
'class'=>'CCheckBoxColumn', // Checkboxes
'selectableRows'=>2,        // Allow multiple selections
'checkBoxHtmlOptions'=>array(
'name'=>'items[]'
)
),
		'id',
	    array(
            'name'=>'role',
            'filter'=>$model->getRoles()
        ),
		'model',
		array(
            'name'=>'create',
            'filter'=>$permFilter
        ),
        array(
		    'name'=>'read',
            'filter'=>$permFilter
        ),
        array(
		    'name'=>'update',
            'filter'=>$permFilter
        ),
        array(
		    'name'=>'delete',
            'filter'=>$permFilter
        ),
		/*
		'constraint',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{view}{update}',
),
),
)); ?>
