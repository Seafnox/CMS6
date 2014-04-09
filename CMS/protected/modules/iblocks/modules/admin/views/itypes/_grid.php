<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'itypes-grid',
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
		'title',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{view}{update}',
),
),
)); ?>
