<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php

$permFilter = array(

    0 => Yii::t('app', 'No'),
    1 => Yii::t('app', 'Yes'),

);

?>


<div class="row-fluid">
		<div class="span3"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

        <div class="span3"><?php echo $form->dropDownListRow($model,'role', $model->getRoles(), array('class'=>'span12')); ?></div>

        <div class="span3"><?php echo $form->textFieldRow($model,'model',array('class'=>'span12','maxlength'=>32)); ?></div>

        <div class="span3"><?php echo $form->textFieldRow($model,'constraint',array('class'=>'span12','maxlength'=>255)); ?></div>

</div>

<div class="row-fluid">
    <div class="span3"><?php echo $form->dropDownListRow($model,'create', $permFilter, array('class'=>'span12', 'prompt'=>'')); ?></div>
    <div class="span3"><?php echo $form->dropDownListRow($model,'read', $permFilter, array('class'=>'span12', 'prompt'=>'')); ?></div>
    <div class="span3"><?php echo $form->dropDownListRow($model,'update', $permFilter, array('class'=>'span12', 'prompt'=>'')); ?></div>
    <div class="span3"><?php echo $form->dropDownListRow($model,'delete', $permFilter, array('class'=>'span12', 'prompt'=>'')); ?></div>
</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('app', 'Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
