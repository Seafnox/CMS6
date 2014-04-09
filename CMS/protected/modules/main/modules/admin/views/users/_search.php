<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row-fluid">

	<div class="span4"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'username',array('class'=>'span12')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'email',array('class'=>'span12')); ?></div>

</div>

<div class="row-fluid">

    <div class="span4"><?php echo $form->textFieldRow($model,'role',array('class'=>'span12')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'phone',array('class'=>'span12')); ?></div>

</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
                        'type'=>'primary',
			'label'=> Yii::t('app', 'Advanced Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
