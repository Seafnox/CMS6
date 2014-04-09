<?php 

$form_id = 'error-form';

$action = "/mailer/error";

        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>$form_id,
	'enableAjaxValidation'=>true,
        'action'=>$action
)); ?>
        
         <div id="<?=$form_id?>-otput" class="alert" style="display: none;">
    
         </div>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo "<div class='row-fluid control-group'>".$form->textFieldRow($model,'username',array('class'=>'span12'))."</div>"; ?>

        <?php echo "<div class='row-fluid control-group'>".$form->textFieldRow($model,'email',array('class'=>'span12'))."</div>"; ?>
        
        <?php echo "<div class='row-fluid control-group'>".$form->textAreaRow($model,'text',array('class'=>'span12'))."</div>"; ?>
        
	<div class="form-actions">
		<?php echo CHtml::ajaxSubmitButton('Обработать', $action, array(
                    
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'beforeSend' => 'function() {$("#'.$form_id.'-otput").show().removeClass("alert-error alert-success").text("Идет отправка...");}',
                                // Результат запроса записываем в элемент, найденный
                                // по CSS-селектору #output.
                                'success' => 'function(data) { 
                                                var cls = (data.status==1)?"alert-success":"alert-error"; 
                                                $("#'.$form_id.'-otput").removeClass("alert-error alert-success").addClass(cls).text(data.mess); 
                                                $("#'.$form_id.'").trigger("reset");
                                                setTimeout(function(){ $("#'.$form_id.'-otput").hide() }, 3000);    
                                              }',
                            ), array("class"=>"btn")
                        );
                        ?>
	</div>

<?php $this->endWidget(); ?>
