<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'itypes-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>

	<div class="control-group row"><?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?></div>


<?php

        $request = Yii::app()->request;

        $ret = $request->getParam("returnUrl");

        $returnUrl = !empty($ret)?$ret:$request->getUrlReferrer();

        echo CHtml::hiddenField('returnUrl', $returnUrl);

        echo CHtml::hiddenField('apply', 0);

    ?>

<div class="form-actions fixed-form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
    )); ?>
&nbsp;<?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'label' => Yii::t('app', 'Apply'),
                'htmlOptions' => array(
                    'onClick' => '$("#apply").val(1)'
                )
            ));
           ?>
&nbsp;<?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'url' => $returnUrl,
                'label' => Yii::t('app', 'Cancel'),
            ));
            ?>

</div>

<?php $this->endWidget(); ?>
