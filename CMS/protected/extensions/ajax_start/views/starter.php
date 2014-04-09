<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'primary',
    'label' => $label,
    'block' => true,
    'htmlOptions' => array("id" => $buttonId)
));
?>
<br/>
<?php $this->widget('bootstrap.widgets.TbProgress', array(
    'type' => 'info', // 'info', 'success' or 'danger'
    'percent' => 0, // the progress
    'striped' => true,
    'animated' => true,
    'htmlOptions' => array("id" => $progressId)
)); ?>

<div class="alert" id="<?= $labelId ?>" style="display: none;"></div>

