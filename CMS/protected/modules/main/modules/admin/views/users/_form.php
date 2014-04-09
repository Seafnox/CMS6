<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array("enctype" => "multipart/form-data")
));
?>

<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>
<div class="row control-group">
    <?php echo $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 128)); ?>
</div>
<div class="row control-group">
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span5', 'maxlength' => 128)); ?>
</div>
<div class="row control-group">
    <?php echo $form->passwordFieldRow($model, 'confirm_password', array('class' => 'span5', 'maxlength' => 128)); ?>
</div>
<div class="row control-group">
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 128)); ?>
</div>


<?php if (Yii::app()->user->checkAccess('changeRole')) { ?>

    <div class="row control-group">

        <?php echo $form->dropDownListRow($model, 'role', $model->getRoles()/*array(
            User::ROLE_USER => User::ROLE_USER,
            User::ROLE_ADMIN => User::ROLE_ADMIN,
            User::ROLE_ROOT => User::ROLE_ROOT,
            User::ROLE_REALTOR => User::ROLE_REALTOR,
            User::ROLE_DIRECTOR => User::ROLE_DIRECTOR,
        )*/);
        ?>

        <?php echo $form->error($model, 'u_role'); ?>
    </div>

<?php } ?>

<div class="row control-group">
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 256)); ?>
</div>

<div class='row control-group'>

    <?php echo $form->labelEx($model, Yii::t('app', 'Image'));

    // Виджет мулитивыбора файлов

    $this->widget('CMultiFileUpload', array(
        'model' => $model,
        'attribute' => 'image',
        'accept' => 'jpg|gif|png',
        /*'options'=>array(
          'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
          'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
          'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
          'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
          'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
          'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
          ),*/

    ));


    echo $form->error($model, 'image');

    echo "<p class=\"example_text\">" . Yii::t('app', 'Max upload file size') . " " . Yii::app()->params['maxFileSize'] . " MB</p>";

    // Виджет управления прикрепленными файлами

    $this->widget('RemoveFilesWidget', array(
        'model' => $model,
        'attr' => 'image',
    ));


    ?>

</div>

<div class="row control-group">
    <?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'maxlength' => 16)); ?>
    <p class="muted">Пример: +7 4912 11-11-11</p>
</div>


<div class='row control-group'>

    <?php

    echo $form->labelEx($model, 'text');

    $this->widget('ext.tinymce.TinyMce', array(
        'model' => $model,
        'attribute' => 'text',
        // Optional config
        'compressorRoute' => 'main/admin/tinyMce/compressor',
        'spellcheckerRoute' => 'main/admin/tinyMce/spellchecker',
        'fileManager' => array(
            'class' => 'ext.elfinder.TinyMceElFinder',
            'connectorRoute'=>'main/admin/elfinder/connector',
        ),
        'htmlOptions' => array(
            'rows' => 6,
            'cols' => 60,
        ),
    ));

    echo $form->error($model, 'text') ;

    ?>

</div>

<?php

$request = Yii::app()->request;

$ret = $request->getParam("returnUrl");

$returnUrl = !empty($ret)?$ret:$request->getUrlReferrer();

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
            'onClick' => "$('#apply').val(1)"
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
