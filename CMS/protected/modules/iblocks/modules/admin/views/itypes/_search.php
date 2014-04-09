<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="row-fluid">
    <div class="span3"><?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?></div>

    <div class="span3"><?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?></div>
</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('app', 'Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
