<?php $form=$this->beginWidget('IActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route, array("model"=>$this->model_class)),
	'method'=>'get',
)); ?>



<?php

$iblock = $model->getIblock();

$props = $iblock->properties;

$i = 0;

$j = 1;

foreach($props AS $prop):

    if(!$prop->show_filter)
        continue;

    $name = ($prop->relation == "MANY_MANY")?$prop->relation_name:$prop->name;
    $method = $prop->field;
    ?>

    <?if($i==0):?>
        <div class="row">
    <?endif;?>

    <div class='span4 control-group'>
        <?=$form->$method($model, $prop, array("class"=>"span12"))?>
    </div>

    <?
    $i++;
    if($i==3):?>
        </div>
    <?
    $i = 0;
    endif;?>


<?
$j++;
endforeach;?>

<?if($i != 0):?>
    </div>
<?endif;?>




	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
            'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
