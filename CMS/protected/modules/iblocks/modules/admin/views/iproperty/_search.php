<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php echo $form->hiddenField($model,'iblock_id',array('class'=>'span12')); ?>

<div class="row-fluid">

	<div class="span6"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

    <div class="span6"><?php echo $form->textFieldRow($model,'title',array('class'=>'span12','maxlength'=>255)); ?></div>

</div>

<div class="row-fluid">

    <div class="span6"><?php echo $form->textFieldRow($model,'name',array('class'=>'span12','maxlength'=>255)); ?></div>

    <div class="span6"><?php echo $form->textFieldRow($model,'field',array('class'=>'span12','maxlength'=>64)); ?></div>

</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
                        'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
