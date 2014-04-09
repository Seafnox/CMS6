<?php
/*
 * Форма для добавления включаемой области
 */

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.admin.assets.js').'/wc_constructor.js'
    ),
    CClientScript::POS_END
);

Yii::app()->clientScript->registerScript("add_ia_form", "
    
$('#ia_form #areas_list').on('change', function(){ $(this).next().val( $(this).val() ) }).trigger('change');
                
                $('#cond_type').on('change', function() { 
                
                        var val = $(this).val(); 
                        var cond = $('#cond').parent();
                        var rec = $('#recursive').parent();
                        (val == 1 || val == 2)?cond.show():cond.hide(); 
                        (val==3)?rec.show():rec.hide();
                        

                }).trigger('change');   

");

$areas = IncludeArea::model()->findAll(array('order'=>'title asc'));

$areas_list = CHtml::listData($areas, 'code', 'title');

echo CHtml::beginForm('', 'post', array('id'=>'ia_form'));
?>
<div class="row">
<?php echo CHtml::label(Yii::t('app', 'Include Areas'), 'area'); ?>
<?php echo CHtml::dropDownList('', 0, $areas_list, array("class"=>"span5", "id"=>"areas_list"));  ?>
<?php echo CHtml::textField("code") ?>
</div>

<div class="row">
<?php echo CHtml::label(Yii::t('app', 'Cond Type'), 'area'); ?>
<?php echo CHtml::dropDownList('cond_type', 0, IncludeAreaWidget::$cond_types, array("class"=>"span5", "id"=>"cond_type"));  ?>
</div>
 

<div class="row">    
    
<?php echo CHtml::label(Yii::t('app', 'Cond'), 'cond'); ?>

<?php echo CHtml::textField('cond', null, array("class"=>"span5", "id"=>"cond"));?>
</div>

<div class="row checkbox_row">
<?php echo CHtml::checkBox('recursive', false, array("id"=>"recursive")); ?>
&nbsp;
<?php echo CHtml::label(Yii::t('app', 'Recursive'),'recursive'); ?>   
</div> 

<?php echo CHtml::endForm(); ?>


