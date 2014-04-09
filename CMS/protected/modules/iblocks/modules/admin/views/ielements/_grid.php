<?php

$columns = array(

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
                'class' => 'bootstrap.widgets.TbEditableColumn',
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
            'url'=>'Yii::app()->createUrl("iblocks/admin/ielements/view", array_merge( array("id"=>$data->id),  Yii::app()->controller->buildActionUrlParams() ) )',
            'visible'=>'Yii::app()->user->checkAccess("readModel", array("model"=>$data))'
        ),
        'update' => array
        (
            'label'=>Yii::t('app', 'Update'),
            'icon'=>'pencil',
            'url'=>'Yii::app()->createUrl("iblocks/admin/ielements/update", array_merge( array("id"=>$data->id), Yii::app()->controller->buildActionUrlParams() ) )',
            'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'
        ),

    ),

);
?>

<?

$this->widget('bootstrap.widgets.TbExtendedGridView',array(
    'type'=>'striped bordered condensed',
    'id'=>'ielements-grid',
    'afterAjaxUpdate' => 'function() { $("body").trigger("content-updated"); }',
    'enableHistory' => true,
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'columns'=>$columns,

)); ?>