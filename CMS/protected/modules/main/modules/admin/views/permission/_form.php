<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'permission-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>

	<div class="control-group row"><?php echo $form->dropDownListRow($model,'role', $model->getRoles(), array('class'=>'span5','maxlength'=>32)); ?></div>

    <div class="control-group row"><?php echo $form->textFieldRow($model,'model',array('class'=>'span5','maxlength'=>32)); ?></div>

<div class="row-fluid" style="max-width: 600px;">

	<div class="span3 control-group"><?php echo $form->checkBoxRow($model,'create',array('class'=>'span12')); ?></div>

    <div class="span3 control-group"><?php echo $form->checkBoxRow($model,'read',array('class'=>'span12')); ?></div>

    <div class="span3 control-group"><?php echo $form->checkBoxRow($model,'update',array('class'=>'span12')); ?></div>

    <div class="span3 control-group"><?php echo $form->checkBoxRow($model,'delete',array('class'=>'span12')); ?></div>


</div>

    <div class="control-group row"><?php echo $form->textFieldRow($model,'constraint',array('class'=>'span5','maxlength'=>255)); ?></div>

    <p class="muted">Дополнительное условие для sql запроса.</p>

<pre>
    // Пример транслируется в следующее условие ( t.author_id = 1 AND t.org_id = 2 ) OR ( t.id = 1 )
    return array(array("t.author_id"=>Yii::app()->user->id, "t.org_id"=>Yii::app()->user->org_id), array(t.id"=>Yii::app()->user->id));
</pre>

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
