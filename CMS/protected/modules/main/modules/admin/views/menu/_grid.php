<?php

if ($parent_id != 0) {

// JS для ajax сортировки данных

    $js_sort = <<< EOD
        function(event) {
            var url = $(this).attr('href');
            $.get(url, function(response) {
                $.fn.yiiGridView.update('menu-grid');
            });
        event.preventDefault();
        }
EOD;


    $buttons = array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'htmlOptions' => array('width' => 100),
        'template' => '{up}{down}{view}{update}{delete}',
        'buttons' => array
        (
            'up' => array
            (
                'label' => Yii::t('app', 'Up'),
                'icon' => 'arrow-up',
                'url' => 'Yii::app()->createUrl("/main/admin/menu/up/", array("id"=>$data->id))',
                'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))',
                'click' => $js_sort
            ),
            'down' => array
            (
                'label' => Yii::t('app', 'Down'),
                'icon' => 'arrow-down',
                'url' => 'Yii::app()->createUrl("/main/admin/menu/down", array("id"=>$data->id))',
                'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))',
                'click' => $js_sort
            ),
            'update'=>array(
                'visible'=>'Yii::app()->user->checkAccess("updateModel", array("model"=>$data))'
            ),
            'view'=> array(
                'visible'=>'Yii::app()->user->checkAccess("readModel", array("model"=>$data))'
            ),
            'delete'=> array(
                'visible'=>'Yii::app()->user->checkAccess("deleteModel", array("model"=>$data))'
            ),
        ),
    );

} else {

    $buttons = array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
    );

}

$editableUrl = $this->createUrl('/main/admin/menu/edit');

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'menu-grid',
    'enableHistory'=>true,
    'type'=>'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => '"<a href=\"".Yii::app()->createUrl("/main/admin/menu/", array("parent_id"=>$data->id))."\">".$data->title."</a>"'
        ),
        'code',
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name' =>  'link',
            'editable' => array( //editable section
                'type' => 'text',
                'url' => $editableUrl,
                'placement' => 'left',
            )
        ),
        array(
            "name" => "section.title",
            "header" => Yii::t("app", "Section")
        ),
        array(
            'name' => 'active',
            'type' => 'raw',
            'filter' => '',
            'value' => '$data->active?Yii::t("app", "Yes"):Yii::t("app", "No")'
        ),
        $buttons
    ),
));
?>