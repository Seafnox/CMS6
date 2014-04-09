<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row-fluid">

	<div class="span3"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

    <div class="span3"><?php echo $form->dropDownListRow($model,'type_id', CHtml::listData(Itypes::model()->findAll(array("order"=>"title asc")), "id", "title"), array('class'=>'span12', 'prompt'=>'')) ?></div>

    <div class="span3"><?php echo $form->textFieldRow($model,'title',array('class'=>'span12','maxlength'=>255)); ?></div>

    <div class="span3"><?php echo $form->textFieldRow($model,'code',array('class'=>'span12','maxlength'=>255)); ?></div>

</div>
<div class="row-fluid">

    <div class="span3"><?php echo $form->textFieldRow($model,'backend_controller',array('class'=>'span12','maxlength'=>32)); ?></div>

    <div class="span3"><?php echo $form->textFieldRow($model,'fronted_controller',array('class'=>'span12','maxlength'=>32)); ?></div>

    <div class="span3"><?php echo $form->textFieldRow($model,'fronted_action',array('class'=>'span12','maxlength'=>32)); ?></div>

</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
                        'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
