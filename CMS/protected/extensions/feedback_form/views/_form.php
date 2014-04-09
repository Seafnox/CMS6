<div class="form">
    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => $form_id,
        'enableAjaxValidation' => true,
        'action' => $action
    ));


    ?>

    <div id="<?= $form_id ?>-otput" class="alert" style="display: none;">

    </div>

    <p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <? echo $form->hiddenField($model, 'user_id'); ?>

    <?php echo "<div class='row-fluid control-group'>";

    echo $form->labelEx($model, 'username');

    echo $form->textField($model, 'username', array('class' => 'span12'));

    echo $form->error($model, 'username');

    echo "</div>";

    ?>

    <?php echo "<div class='row-fluid control-group'>";

    echo $form->labelEx($model, 'email');

    echo $form->textField($model, 'email', array('class' => 'span12'));

    echo $form->error($model, 'email');

    echo "</div>";

    ?>

    <?php echo "<div class='row-fluid control-group'>";

    echo $form->labelEx($model, 'phone');

    echo $form->textField($model, 'phone', array('class' => 'span12'));

    echo $form->error($model, 'phone');

    echo "</div>";

    ?>

    <?php echo "<div class='row-fluid control-group'>";

    echo $form->labelEx($model, 'text');

    echo $form->textArea($model, 'text', array('class' => 'span12'));

    echo $form->error($model, 'text');

    echo "</div>";

    ?>

    <?php

    echo $form->hiddenField($model, 'code', array('class' => 'verifyCode'));

    ?>

    <div class="form-actions">
        <?php echo CHtml::ajaxSubmitButton('Отправить', $action, array(

                'type' => 'POST',
                'dataType' => 'JSON',
                'beforeSend' => 'function() {

                    $("#' . $form_id . ' input, #' . $form_id . ' select, #' . $form_id . ' textarea").each(function(){
                        console.log(this);
                        $(this).trigger("focus");
                    });

                    $("#' . $form_id . '-otput").show().removeClass("alert-error alert-success").text("Идет отправка...");}',
                // Результат запроса записываем в элемент, найденный
                // по CSS-селектору #output.
                'success' => 'function(data) {
                                                var cls = (data.status==1)?"alert-success":"alert-error";
                                                $("#' . $form_id . '-otput").removeClass("alert-error alert-success").addClass(cls).text(data.mess);
                                                if(data.status==1) $("#' . $form_id . '").trigger("reset");
                                                setTimeout(function(){ $("#' . $form_id . '-otput").hide() }, 3000);
                                              }',

            ), array("class"=>"btn")
        );
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div>