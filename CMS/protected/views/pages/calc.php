<h1>Ипотечный калькулятор</h1>

<div class="form">
   
<?php

$form_id = 'calc-form';

$action = "/ipocalc";

        $form=$this->beginWidget('CActiveForm',array(
	'id'=>$form_id,
	'enableAjaxValidation'=>true,
        'action'=>$action
)); 

echo $form->errorSummary($model);

$cs = Yii::app()->clientScript;

$cs->registerScript('toogle_calc_price_label', '

$("#CalcForm_type").on("change", function(){

var n = $(this).val() - 1;

var pr_label = $("#CalcForm_price").parent().find("label");

pr_label.find("span").hide();

pr_label.find("span:eq("+n+")").show();

}).change();

', CClientScript::POS_END);

?>

<div id="<?=$form_id?>-otput" class="alert" style="display: none;"></div>    
    
<div class='row control-group'> 

<?php
     
    echo $form->labelEx($model, 'type');
       
    echo $form->dropDownList($model,'type', CalcForm::getTypesVal(), array('class'=>'span2')); 
            
    echo $form->error($model, 'type');

?>

</div>

    
<div class='row control-group'>

<?php
     
    echo $form->labelEx($model, 'price');
       
    echo $form->textField($model,'price',array('class'=>'span2')); 
            
    echo $form->error($model, 'price');

?>

</div>

<div class='row control-group'> 

<?php
     
    echo $form->labelEx($model, 'vznos');
       
    echo $form->dropDownList($model,'vznos', CalcForm::getVznosVals(), array('class'=>'span2')); 
            
    echo $form->error($model, 'vznos');

?>

</div> 
 
 
<div class='row control-group'> 

<?php
     
    echo $form->labelEx($model, 'srok');
       
    echo $form->dropDownList($model,'srok', CalcForm::getSrokVals(), array('class'=>'span2')); 
            
    echo $form->error($model, 'srok');

?>

</div> 

    
 
<div class="form-actions">
    <?php echo CHtml::ajaxSubmitButton('Рассчитать', $action, array(
                    
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'beforeSend' => 'function() {$("#'.$form_id.'-otput").show().removeClass("alert-error alert-success").text("Идет расчет...");}',
                                // Результат запроса записываем в элемент, найденный
                                // по CSS-селектору #output.
                                'success' => 'function(data) { 
                                           
                                                if(data.proc) {
                                                    var cls = "alert-success";
                                                    var type = $("#CalcForm_type").val();
                                                    var tpl = $("#calc_type_"+type).html();
                                                    var html = _.template(tpl, data);
                                                    $("#calc_info").html(html).show();
                                                }
                                                else {
                                                    var cls = "alert-error";
                                                    $("#calc_info").html("").hide();
                                                }

                                                $("#'.$form_id.'-otput").removeClass("alert-error alert-success").addClass(cls).text(data.mess); 
                                                
                                                

                                                //setTimeout(function(){ $("#'.$form_id.'-otput").hide() }, 5000);  


                                              }',
                            )
                        );
    ?>
</div>

<?php $this->endWidget(); ?>

<div id="calc_info" class="alert" style="display: none;">     

</div>    
 

</div>


<script id="calc_type_1" type="text/html">     
<p>Процентная ставка: <%= proc %> %</p>
<p>Ежемесячный платеж: <%= iprice %> руб.</p>
<p>Максимальная сумма кредита: <%= max_summ %> руб.</p>
</script>    


<script id="calc_type_2" type="text/html">     
<p>Процентная ставка: <%= proc %> %</p>
<p>Ежемесячный платеж: <%= iprice %> руб.</p>
<p>Необходимый ежемесячный доход: <%= max_summ %> руб.</p>
</script>


<?php if(!empty($ipoform_model)): ?>

<h2>Отправить заявку</h2>

<div class="form">
    
<?php

$form_id = 'iporeq-form';

$action = "/mailer/iporeq/";

        $form=$this->beginWidget('CActiveForm',array(
	'id'=>$form_id,
	'enableAjaxValidation'=>true,
        'action'=>$action
)); 

echo $form->errorSummary($model);

?>


<div id="<?=$form_id?>-otput" class="alert" style="display: none;"></div>    
    
<div class='row control-group'> 

<?php
     
    echo $form->labelEx($ipoform_model, 'cat_id');
       
    echo $form->textField($ipoform_model,'cat_id', array('class'=>'span2')); 
            
    echo $form->error($ipoform_model, 'cat_id');

?>

</div> 

<div class='row control-group'> 

<?php
     
    echo $form->labelEx($ipoform_model, 'cat_title');
       
    echo $form->textField($ipoform_model,'cat_title', array('class'=>'span2')); 
            
    echo $form->error($ipoform_model, 'cat_title');

?>

</div>  

<div class='row control-group'> 

<?php
     
    echo $form->labelEx($ipoform_model, 'name');
       
    echo $form->textField($ipoform_model,'name', array('class'=>'span2')); 
            
    echo $form->error($ipoform_model, 'name');

?>

</div>  

<div class='row control-group'> 

<?php
     
    echo $form->labelEx($ipoform_model, 'email');
       
    echo $form->textField($ipoform_model,'email', array('class'=>'span2')); 
            
    echo $form->error($ipoform_model, 'email');

?>

</div>  

<div class='row control-group'> 

<?php
     
    echo $form->labelEx($ipoform_model, 'phone');
       
    echo $form->textField($ipoform_model,'phone', array('class'=>'span2')); 
            
    echo $form->error($ipoform_model, 'phone');

?>

</div>  
    
<div class="form-actions">
    <?php echo CHtml::ajaxSubmitButton('Отправить', $action, array(
                    
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'beforeSend' => 'function() {$("#'.$form_id.'-otput").show().removeClass("alert-error alert-success").text("Идет отправка...");}',
                                // Результат запроса записываем в элемент, найденный
                                // по CSS-селектору #output.
                                'success' => 'function(data) { 
                                                var cls = (data.status==1)?"alert-success":"alert-error"; 
                                                $("#'.$form_id.'-otput").removeClass("alert-error alert-success").addClass(cls).text(data.mess); 
                                                if(data.status==1) $("#'.$form_id.'").trigger("reset");
                                                setTimeout(function(){ $("#'.$form_id.'-otput").hide() }, 3000);    
                                              }',
                            )
                        );
    ?>

</div>

<?php $this->endWidget(); ?>    
    
</div>

<?php endif; ?>