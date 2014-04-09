<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'template-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>128))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'text',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>128))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'cond_type', Template::$cond_types, array('class'=>'span5'))."</div>"; ?>

        <div class='row control-group'>
        
        <?php echo $form->textFieldRow($model,'cond',array('class'=>'span5','maxlength'=>255)); ?>
        
        <p class="example_text">
           
            Пример для url адреса: <strong>/catalog/*</strong><br />
            
            Пример для PHP выражения: <strong>return $_GET['a'] == 1;</strong>
            
        </p>    
        
        </div>

<?php

    $request = Yii::app()->request;

    $ret = $request->getParam("returnUrl");

    $returnUrl = !empty($ret) ? $ret : $request->getUrlReferrer();

    echo CHtml::hiddenField('returnUrl', $returnUrl);

?>

<?php echo CHtml::hiddenField('apply', 0); ?>
        
	<div class="form-actions fixed-form-actions">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),
		)); ?>

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'label' => Yii::t('app', 'Apply'),
            'htmlOptions' => array(
                'onClick' => "$('#apply').val(1)",
            )
        ));
        ?>

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'link',
            'url' => $returnUrl,
            'label' => Yii::t('app', 'Cancel'),
        ));
        ?>

	</div>

<?php $this->endWidget(); ?>
