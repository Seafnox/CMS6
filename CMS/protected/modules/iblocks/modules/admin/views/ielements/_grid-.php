<?php

$columns = array(
    array(
        'header'=>CHtml::checkBox("all_items", null, array("onClick"=>"$(this).parents('table').find('input:checkbox').prop('checked', $(this).prop('checked'))")),
        'type'=>'raw',
        'value'=>'CHtml::checkBox("items[]", null, array("value"=>$data->id, "id"=>"items_".$data->id))',
    ),
    'id',
    array(
        "type" => 'raw',
        "name" => 'author_id',
        "value" => 'is_object($data->author)?$data->author->username." (".$data->author_id.")":"(".$data->author_id.")"'
    ),
    'mtime'
);

$iblock = $model->getIblock();

$props = $iblock->properties;

foreach($props AS $prop) {

    if( empty($prop->show_in_list) ) continue;

    $col = array();

    if(!empty($prop->list_code)) {

        eval("\$col=".$prop->list_code.";");

    } elseif(!empty($prop->name) AND empty($prop->editable)) {

        $col = $prop->name;

    }


    if(!empty($prop->editable)) { // Поле разрешено к редактированию в гриде

        $source = null;

        $type = "text";

        if(!empty($prop->data_code)) {
            eval("\$src=".$prop->data_code.";");

            foreach($src AS $key=>$val)
                $source[] = array("value"=>$key, "text"=>$val);

            $type="select";

        }

        $eCol = array(
                'class' => 'editable.EditableColumn',
                'name' => $prop->name,
                'editable' => array( //editable section
                    'type' => $type,
                    'url' => $this->createUrl('/iblocks/admin/ielements/edit', array("model"=>$this->model_class)),
                    'placement' => 'left',
                    'source'=> $source
            )
        );

        $col = array_merge($col, $eCol);


    }

    $columns[] = $col;



}

// Кнопки

$columns[] = array(

    'class'=>'bootstrap.widgets.TbButtonColumn',
    'template'=>'{view}{update}',
    'htmlOptions'=>array('width'=>90),
    'buttons'=>array
    (
        'view' => array
        (
            'label'=>Yii::t('app', 'View'),
            'icon'=>'eye-open',
            'url'=>'Yii::app()->createUrl("iblocks/admin/ielements/view", array("id"=>$data->id, "model"=>"'.$this->model_class.'"))',
        ),
        'update' => array
        (
            'label'=>Yii::t('app', 'Update'),
            'icon'=>'pencil',
            'url'=>'Yii::app()->createUrl("iblocks/admin/ielements/update", array("id"=>$data->id, "model"=>"'.$this->model_class.'"))',
        ),

    ),

);
?>

<?

$this->widget('bootstrap.widgets.TbGridView',array(
    'type'=>'striped bordered condensed',
    'id'=>'ielements-grid',
    'afterAjaxUpdate' => 'function() { $("body").trigger("content-updated"); }',
    'enableHistory' => true,
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>$columns
)); ?>