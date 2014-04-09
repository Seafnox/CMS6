<h1>Заявка на покупку / продажу недвижимости</h1>


<div class="form">

    <?php if (Yii::app()->user->hasFlash('success_mail')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success_mail'); ?>
        </div>
    <?php endif; ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'type-catalog-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array("enctype" => "multipart/form-data")
            ));

    $sewage = TypeSewage::model()->findAll();

    $sewage_list = CHtml::listdata($sewage, 'title', 'title');

    $ryaz = TypeRegion::model()->findAll(array('condition' => 'id = 1'));

    $regions = TypeRegion::model()->findAll(array('condition' => 'id != 1', 'order' => 'title asc'));

    $regions = array_merge($ryaz, $regions);

    $regions_list = CHtml::listdata($regions, 'id', 'title');

    $materials = TypeMaterial::model()->findAll();

    $materials_list = CHtml::listdata($materials, 'title', 'title');

    $otoplenie = TypeOtoplenie::model()->findAll();

    $otoplenie_list = CHtml::listdata($otoplenie, 'title', 'title');

    $su = TypeSanuzel::model()->findAll();

    $su_list = CHtml::listdata($su, 'title', 'title');

    /* $sections_list = Section::getListData(1);

      $model->sections = !empty($model->sections)?$model->sections:current(array_keys($sections_list)); // Усстанавливаем категорию по умолчанию, если не задана

     */

    $section_list = CHtml::listData(Section::model()->findAll('parent_id = 1'), 'id', 'title');
    ?>

    <p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>


<?php
echo "<div class='row control-group'>";


echo $form->labelEx($model, 'name');

echo $form->textField($model, 'name', array('class' => 'span2', 'maxlength' => 255));

echo $form->error($model, 'name');

echo "</div>";
?>

    <?php
    echo "<div class='row control-group'>";


    echo $form->labelEx($model, 'contacts');

    echo $form->textField($model, 'contacts', array('class' => 'span2', 'maxlength' => 255));

    echo $form->error($model, 'contacts');

    echo "</div>";
    ?>


    <fieldset>

        <legend>Я хочу</legend>

        <div class="clear"></div>

<?php
echo "<div class='row control-group fl_left checkbox_wrap'>";


echo $form->labelEx($model, 'arenda');

echo $form->checkBox($model, 'arenda');

echo $form->error($model, 'arenda');

echo "</div>";
?>


<?php
echo "<div class='row control-group fl_left checkbox_wrap'>";


echo $form->labelEx($model, 'pokupka');

echo $form->checkBox($model, 'pokupka');

echo $form->error($model, 'arenda');

echo "</div>";
?>


<?php
echo "<div class='row control-group fl_left checkbox_wrap'>";


echo $form->labelEx($model, 'prodazha');

echo $form->checkBox($model, 'prodazha');

echo $form->error($model, 'prodazha');

echo "</div>";
?>


<?php
echo "<div class='row control-group fl_left checkbox_wrap'>";


echo $form->labelEx($model, 'obmen');

echo $form->checkBox($model, 'obmen');

echo $form->error($model, 'obmen');

echo "</div>";
?>

    </fieldset>        



<?php
echo "<div class='row control-group fl_left'>";

// echo $form->labelEx($model, 'section'); 

echo "<div class='radio_wrap'>";

echo $form->radioButtonList($model, "section", $section_list, array("separator" => "&nbsp;"));

echo "</div>";

echo $form->error($model, 'section');

echo "</div>";

$cs = Yii::app()->clientScript;

$cs->registerScript('sub_section_loader', '
     

   $("#RealtyForm_section input").click(function(){
   
    var val = $(this).val();
    
    $.post("/pages/dynamicsections/prompt/1", {parent_id: val}, function(data){
       $("#RealtyForm_sub_section").html(data).val("' . $model->sub_section . '");
    });
   }); 

    
    $("#RealtyForm_section input:eq(0), #RealtyForm_section input:eq(1)").click(function(){

        $(".zhil").show();

    });


     $("#RealtyForm_section input:eq(2), #RealtyForm_section input:eq(3)").click(function(){

        $(".zhil").hide();

    });

    $("#RealtyForm_section input:checked").click();


', CClientScript::POS_END);
?>




    <div class="clear"></div>

<?php
/*echo "<div class='row control-group'>";


echo $form->labelEx($model, 'sub_section');

echo $form->dropDownList($model, 'sub_section', array(), array('class' => 'span2'));

echo $form->error($model, 'sub_section');

echo "</div>";*/
?>






<?php
// Подгрузка областей при смене региона

Yii::app()->clientScript->registerScript("areas_load", "
  
            $(document).ready(function(){
            $('#RealtyForm_region_id').change();
            //$('#RealtyForm_area_id').change();
            });

        ");

// Регионы

echo "<div class='row control-group'>";

echo $form->labelEx($model, 'region_id');

echo $form->dropDownList($model, 'region_id', $regions_list, array('class' => 'span2',
   /* 'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('/pages/dynamicareas'), //url to call.
        //Style: CController::createUrl('currentController/methodToCall')
        'success' => 'function(data) {
                            $("#RealtyForm_area_id").html(data).val(' . $model->area_id . ')
                           
                    }',
    //leave out the data key to pass all form values through
    )*/
        )
);

echo $form->error($model, 'region');

echo "</div>";
?>

    <?php
    // Области

   /* echo "<div class='row control-group'>";


    echo $form->labelEx($model, 'area_id');

    echo $form->dropDownList($model, 'area_id', array(), array('class' => 'span2'));

    echo $form->error($model, 'area_id');

    echo "</div>";*/
    ?> 

    <?php
    /*echo "<div class='row control-group'>";


    echo $form->labelEx($model, 'address');

    echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'span2'));

    echo $form->error($model, 'address');


    echo "</div>";*/
    ?>

    <?php
   /* echo "<div class='row control-group eq_fl eq_fl_small'>";

    echo $form->labelEx($model, 'year');

    echo $form->textField($model, 'year', array('class' => 'input-small', 'prepend' => 'год'));

    echo $form->error($model, 'year');

    echo "</div>";*/
    ?>


    <?php
   /* echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'floor_count');

    echo $form->textField($model, 'floor_count', array('class' => 'input-small', 'prepend' => 'кол'));

    echo $form->error($model, 'floor_count');

    echo "</div>";*/
    ?>

    <?php
    /*echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'material');

    echo $form->dropDownList($model, 'material', $materials_list, array('class' => 'input-medium', 'prompt' => ''));

    echo $form->error($model, 'material');

    echo "</div>";*/
    ?>



    <?php
   /* echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'square');

    echo $form->textField($model, 'square', array('class' => 'input-small', 'prepend' => 'кв/м'));


    echo $form->error($model, 'square');


    echo "</div>";*/
    ?>


      <?php
     /*   echo "<div class='row control-group eq_fl eq_fl_small'>";


        echo $form->labelEx($model, 'land_square');

        echo $form->textField($model, 'land_square', array('class' => 'input-small'));

        echo $form->error($model, 'land_square');

        echo "</div>";*/
        ?>

    <div class="zhil">
    <?php
    /*echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'zhil_square');

    echo $form->textField($model, 'zhil_square', array('class' => 'input-small', 'prepend' => 'кв/м'));

    echo $form->error($model, 'zhil_square');

    echo "</div>";*/
    ?>

    <?php
    /*echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'kitcheen_square');

    echo $form->textField($model, 'kitcheen_square', array('class' => 'input-small', 'prepend' => 'кв/м'));

    echo $form->error($model, 'kitcheen_square');

    echo "</div>";*/
    ?>


        <?php
        echo "<div class='row control-group eq_fl eq_fl_small'>";


        echo $form->labelEx($model, 'rooms');

        echo $form->textField($model, 'rooms', array('class' => 'input-small', 'prepend' => 'кол'));

        echo $form->error($model, 'rooms');

        echo "</div>";
        ?>




<?php
/*echo "<div class='row control-group eq_fl eq_fl_small'>";


echo $form->labelEx($model, 'floor');

echo $form->textField($model, 'floor', array('class' => 'input-small', 'prepend' => 'кол'));

echo $form->error($model, 'floor');

echo "</div>";*/
?>



    </div>  


    <div class="clear"></div>

      

    <div class="zhil">

<?php
/*echo "<div class='row control-group eq_fl eq_fl_small'>";


echo $form->labelEx($model, 'otoplenie');

echo $form->dropDownList($model, 'otoplenie', $otoplenie_list, array('class' => 'input-medium', 'prompt' => ''));

echo $form->error($model, 'otoplenie');

echo "</div>";*/
?>

    <?php
    /*echo "<div class='row control-group eq_fl eq_fl_small'>";


    echo $form->labelEx($model, 'su');

    echo $form->dropDownList($model, 'su', $su_list, array('class' => 'input-medium', 'prompt' => ''));

    echo $form->error($model, 'su');

    echo "</div>";*/
    ?>

        <?php
       /* echo "<div class='row control-group eq_fl eq_fl_small'>";


        echo $form->labelEx($model, 'sewage');

        echo $form->dropDownList($model, 'sewage', $sewage_list, array('class' => 'input-medium', 'prompt' => ''));

        echo $form->error($model, 'sewage');

        echo "</div>";*/
        ?>
    </div>





    <div class="clear"></div>



        <?php
      /*  echo "<div class='row control-group'>";


        echo $form->labelEx($model, 'price');

        echo $form->textField($model, 'price', array('class' => 'span2', 'prepend' => 'руб.'));

        echo $form->error($model, 'price');

        echo "</div>";*/
        ?>


<?php
echo "<div class='row control-group'>";


echo $form->labelEx($model, 'text');

echo $form->textArea($model, 'text', array('rows' => 6, 'cols' => 70, 'class' => 'span8'));

echo $form->error($model, 'text');

echo "</div>";
?>
<!--
    <fieldset>

        <legend><?php/* echo Yii::t('app', 'Communicacii'); ?></legend>
        <div class="clear"></div>
    <?php
   echo "<div class='row control-group fl_left checkbox_wrap'>";


    echo $form->labelEx($model, 'gas');

    echo $form->checkBox($model, 'gas');

    echo $form->error($model, 'gas');

    echo "</div>";
    ?>

    <?php
   echo "<div class='row control-group fl_left checkbox_wrap'>";


    echo $form->labelEx($model, 'water');

    echo $form->checkBox($model, 'water');

    echo $form->error($model, 'water');

    echo "</div>";
    ?>


        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'electricity');

        echo $form->checkBox($model, 'electricity');

        echo $form->error($model, 'electricity');

        echo "</div>";
        ?>

    </fieldset>

    <fieldset>

        <legend><?php echo Yii::t('app', 'Infrastructure'); ?></legend>
        <div class="clear"></div>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'shop');

        echo $form->checkBox($model, 'shop');

        echo $form->error($model, 'shop');

        echo "</div>";
        ?>
<?php
echo "<div class='row control-group fl_left checkbox_wrap'>";


echo $form->labelEx($model, 'school');

echo $form->checkBox($model, 'school');

echo $form->error($model, 'school');

echo "</div>";
?>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'kindergarten');

        echo $form->checkBox($model, 'kindergarten');

        echo $form->error($model, 'kindergarten');

        echo "</div>";
        ?>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'bus_stops');

        echo $form->checkBox($model, 'bus_stops');

        echo $form->error($model, 'bus_stops');

        echo "</div>";
        ?>
    </fieldset>

    <fieldset>

        <legend><?php echo Yii::t('app', 'Dops'); ?></legend>
        <div class="clear"></div>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'fireplace');

        echo $form->checkBox($model, 'fireplace');

        echo $form->error($model, 'fireplace');

        echo "</div>";
        ?>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'lift');

        echo $form->checkBox($model, 'lift');

        echo $form->error($model, 'lift');

        echo "</div>";
        ?>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'garage');

        echo $form->checkBox($model, 'garage');

        echo $form->error($model, 'garage');

        echo "</div>";
        ?>
        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'balcony');

        echo $form->checkBox($model, 'balcony');


        echo $form->error($model, 'balcony');

        echo "</div>";
        ?>

        <?php
        echo "<div class='row control-group fl_left checkbox_wrap'>";


        echo $form->labelEx($model, 'loggia');

        echo $form->checkBox($model, 'loggia');

        echo $form->error($model, 'loggia');

        echo "</div>";*/
        ?>
    </fieldset>

-->

    <div class="form-actions">
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'go',
            'buttonType' => 'submit',
            'caption' => 'Отправить'
        ));
        ?>
    </div>

        <?php $this->endWidget(); ?>

</div>
