<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

<div class="row row-fluid">

    <div class="span4"><?php echo $form->textFieldRow($model, 'id', array('class' => 'span12')); ?></div>

    <div
        class="span4"><?php echo $form->textFieldRow($model, 'title', array('class' => 'span12', 'maxlength' => 255)); ?></div>

    <div
        class="span4"><?php echo $form->textFieldRow($model, 'code', array('class' => 'span12', 'maxlength' => 32)); ?></div>

</div>

<div class="row row-fluid">
    <div
        class="span4"><?php echo $form->textFieldRow($model, 'link', array('class' => 'span12', 'maxlength' => 255)); ?></div>

    <div
        class="span4"><?php echo $form->dropDownListRow($model, 'section_id', Section::getListData(), array('class' => 'span12', 'prompt' => '')); ?></div>

</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('app', 'Search'),
    )); ?>
</div>

<?php $this->endWidget(); ?>
