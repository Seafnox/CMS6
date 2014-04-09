<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
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
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if (++$count == 7) {
        echo "\t\t/*\n";
    }
    echo "\t\t'" . $column->name . "',\n";
}
if ($count >= 7) {
    echo "\t\t*/\n";
}
?>
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{view}{update}',
),
),
)); ?>
