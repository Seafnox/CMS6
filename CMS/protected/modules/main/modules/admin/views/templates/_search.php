<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row-fluid">

	<div class="span4"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'title',array('class'=>'span12','maxlength'=>128)); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'code',array('class'=>'span12','maxlength'=>128)); ?></div>

</div>

<div class="row-fluid">
    <div class="span4"><?php echo $form->textFieldRow($model,'cond',array('class'=>'span12','maxlength'=>255)); ?></div>

    <div class="span4"><?php echo $form->dropDownListRow($model,'cond_type', Template::$cond_types, array('class'=>'span12')); ?></div>
</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
                        'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
