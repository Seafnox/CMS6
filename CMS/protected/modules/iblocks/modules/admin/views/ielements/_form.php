<?php $form = $this->beginWidget('IActiveForm', array(
    'id' => 'iblock-element-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array("enctype" => "multipart/form-data")
)); ?>

<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>

<?php

$iblock = $model->getIblock();


$tabs = $iblock->getTabs();


?>

<?

$cs = Yii::app()->clientScript;

$cs->registerScript("props-tab-enable", "


    $('#propsTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });


", CClientScript::POS_READY);


?>

<ul class="nav nav-tabs" id="propsTab">
    <?
    $i = 0;
    foreach ($tabs AS $tabCode => $tabName): ?>
        <li class=" <?= ($i == 0) ? "active" : null ?>"><a href="#tab-<?= $tabCode ?>"><?= $tabName ?></a></li>
        <?
        $i++;
    endforeach;?>
</ul>
<div class="tab-content">
    <?
    $i = 0;
    foreach ($tabs AS $tabCode => $tabName): ?>
        <div class="tab-pane <?= ($i == 0) ? "active" : null ?>" id="tab-<?= $tabCode ?>">

            <?if($tabCode==Iblocks::default_tab_code):?>

                <div class='row control-group'>
                    <?= $form->checkBoxRow($model, "active"); ?>
                </div>

            <?endif;?>

            <?

            $props = $iblock->getPropsByTab($tabCode);


            foreach ($props AS $prop):

                $name = ($prop->relation == "MANY_MANY") ? $prop->relation_name : $prop->name;
                $method = $prop->field;
                ?>
                <div class='row control-group'>
                    <?= $form->$method($model, $prop) ?>
                </div>
            <?
            endforeach;

            ?>


        </div>
        <?
        $i++;
    endforeach; ?>

</div>


<?

$request = Yii::app()->request;

$ret = $request->getParam("returnUrl");

$returnUrl = !empty($ret) ? $ret : $request->getUrlReferrer();

echo CHtml::hiddenField('returnUrl', $returnUrl);

?>

<?php echo CHtml::hiddenField('apply', 0); ?>


<div class="form-actions fixed-form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
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
