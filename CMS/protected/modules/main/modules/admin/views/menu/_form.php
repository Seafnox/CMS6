<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'menu-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

	<?php

    if($parent_id == 0)
        echo "<div class='row control-group'>".$form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>32))."</div>";
    else
        echo $form->hiddenField($model,'code');

    ?>

    <?if($parent_id != 0):?>

	    <?php echo "<div class='row control-group'>".$form->textFieldRow($model,'link',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

	    <?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'target', $model->getTargets(), array('class'=>'span5'))."</div>"; ?>

    <?endif;?>

	<?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'active')."</div>"; ?>

	<?php

    if($parent_id == 0)
        echo "<div class='row control-group'>".$form->dropDownListRow($model,'section_id', Section::getListData(), array('class'=>'span5', 'prompt'=>''))."</div>";
    else
        echo $form->hiddenField($model,'section_id');
    ?>

    <?php

        $request = Yii::app()->request;

        $ret = $request->getParam("returnUrl");

        $returnUrl = !empty($ret)?$ret:$request->getUrlReferrer();

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
