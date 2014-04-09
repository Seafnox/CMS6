<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iblocks-form',
	'enableAjaxValidation'=>true,
)); ?>

<?


$adminC =  array_merge( array(""=>"по умолчанию"), Iblocks::getAdminControllers() );



?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'type_id', CHtml::listData(Itypes::model()->findAll(array("order"=>"title asc")), "id", "title"), array('class'=>'span5'))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>255, 'disabled'=>($model->isNewRecord)?false:true))."</div>"; ?>

        <?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'backend_controller', $adminC, array('class'=>'span5'))."</div>"; ?>
       
        <?php echo "<div class='row control-group'>".$form->textFieldRow($model,'fronted_controller',array('class'=>'span5', 'maxlength'=>32))."</div>"; ?>
       
         <?php echo "<div class='row control-group'>".$form->textFieldRow($model,'fronted_action',array('class'=>'span5', 'placeholder'=>Yii::t('app', 'Action for site') ,'maxlength'=>32))."</div>"; ?>


<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'relations',array('class'=>'span5'))."</div>"; ?>

<pre>

    // В формате JSON

    {"код связи 1": "имя связи 1", "код связи 2": "имя связи 2"}

</pre>


<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'tabs',array('class'=>'span5'))."</div>"; ?>

<pre>

    // В формате JSON

    {"код вкладки 1": "имя вкладки 1", "код вкладки 2": "имя вкладки 2"}

</pre>

<?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'active')."</div>"; ?>


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
