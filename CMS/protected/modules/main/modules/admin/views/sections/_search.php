<?
$users = User::model()->findAll();

$authors_list = CHtml::listdata($users,'id','username', 'role');
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="row row-fluid">

	<div class="span4"><?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'title',array('class'=>'span12','maxlength'=>255)); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'code',array('class'=>'span12','maxlength'=>255)); ?></div>

</div>

<div class="row row-fluid">

    <div class="span4"><?php echo $form->dropDownListRow($model,'author_id', $authors_list, array('class'=>'span12', 'prompt'=>'')); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'controller',array('class'=>'span12','maxlength'=>128)); ?></div>

    <div class="span4"><?php echo $form->textFieldRow($model,'action',array('class'=>'span12','maxlength'=>128)); ?></div>

</div>

<div class="row row-fluid">

    <div class="span4"><?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'active')."</div>"; ?></div>

</div>

    <div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
                        'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
