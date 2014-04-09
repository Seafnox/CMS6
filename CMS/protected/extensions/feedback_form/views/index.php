<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => $form_id.'_dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => $title,
        'autoOpen' => false,
        'width' => $width,
        'height' => $height,
    ),
));
?>

<?  $this->render("_form", array("model"=>$model, "action"=>$action, "form_id"=>$form_id)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>