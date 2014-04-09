<?php
$this->breadcrumbs=array(
    Yii::t('app', 'Config')
);
?>

<h1><?=Yii::t('app', 'Config')?></h1>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'menu-form',
    'enableAjaxValidation' => false,
)); ?>

<?
$i = 0;
foreach ($models AS $model):?>


    <div class="row">

        <hr />

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model, "[$i]id"); ?>

        <div class="row-fluid">

            <div class="span4">

                <?php echo $form->{$model->field}($model, "[$i]title", array("class" => "span12")); ?>

            </div>

            <div class="span4">

                <?php echo $form->{$model->field}($model, "[$i]key", array("class" => "span12")); ?>

            </div>

            <div class="span4">
                <?
                $data = $model->getData();
                if (empty($data)):?>

                    <?php echo $form->{$model->field}($model, "[$i]value", array("class" => "span12")); ?>

                <? else: ?>

                    <?php echo $form->{$model->field}($model, "[$i]value", $data, array("class" => "span12")); ?>

                <?endif; ?>
            </div>

        </div>

    </div>

    <?
    $i++;
endforeach;?>

<div class="form-actions fixed-form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('app', 'Save'),
    )); ?>

</div>

<?php $this->endWidget(); ?>
