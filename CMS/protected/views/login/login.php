
<div class="well" style="width: 450px; margin: 0 auto;">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions' => array(
        'class'=>'form-horizontal'
    )
)); ?>


	<div class="row control-group">

        <?php echo $form->labelEx($model,'username', array('class'=>'control-label')); ?>

        <div class="controls">
            <?php echo $form->textField($model,'username'); ?>
		    <?php echo $form->error($model,'username'); ?>
        </div>

    </div>

	<div class="row control-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <div class="controls">
		    <?php echo $form->passwordField($model,'password'); ?>
		    <?php echo $form->error($model,'password'); ?>
        </div>
	</div>

	<div class="checkbox row control-group">
        <div class="controls">
            <?php echo $form->checkBox($model,'rememberMe'); ?>
		    <?php echo $form->label($model,'rememberMe'); ?>
		    <?php echo $form->error($model,'rememberMe'); ?>
        </div>
	</div>

    <div class="row control-group">
         <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                 'buttonType'=>'submit',
                 'type'=>'primary',
                 'label'=>Yii::t("app", "Login"),
                 )); ?>
         </div>
    </div>


<?php $this->endWidget(); ?>
</div><!-- form -->
