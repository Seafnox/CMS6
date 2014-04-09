<?php

$cs = Yii::app()->clientScript;


$cs->registerScript("sect_tab_activate", "

    $('#sectTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })

", CClientScript::POS_LOAD);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'section-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array("enctype" => "multipart/form-data")
        ));

$users = User::model()->findAll();

$authors_list = CHtml::listdata($users, 'id', 'username', 'role');

if ($model->isNewRecord) {

    $sections_list = Section::getListData();
} else {

    $sections_list = Section::getListData(0, array($model->id));
}
?>


<ul class="nav nav-tabs" id="sectTab">
    <li class="active"><a href="#main"><?=Yii::t('app', 'Section')?></a></li>
    <li><a href="#meta"><?=Yii::t('app', 'Meta')?></a></li>
</ul>

<div class="tab-content">

<div class="tab-pane active" id="main">

<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class="required">*</span>')); ?></p>

<?php echo $form->errorSummary($model); ?>

<?php echo "<div class='row control-group'>" . CHtml::label(Yii::t('app', 'Parent'), 'parent_id') . CHtml::dropDownList('parent_id', $parent_id, $sections_list, array('class' => 'span5', 'prompt' => '')) . "</div>"; ?>

<?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)) . "</div>"; ?>

<?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 255)) . "</div>"; ?>

<?php echo $form->hiddenField($model, 'path', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php
echo "<div class='row control-group'>" . $form->labelEx($model, Yii::t('app', 'Image'));

// Виджет мулитивыбора файлов

$this->widget('CMultiFileUpload', array(
    'model' => $model,
    'attribute' => 'image',
    'accept' => 'jpg|gif|png',
        /* 'options'=>array(
          'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
          'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
          'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
          'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
          'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
          'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
          ), */
));


echo $form->error($model, 'image') . "</div>";

echo "<p class=\"example_text\">" . Yii::t('app', 'Max upload file size') . " " . Yii::app()->params['maxFileSize'] . " MB</p>";

// Виджет удаления прикрепленных файлов

$this->widget('RemoveFilesWidget', array(
    'model' => $model,
    'attr' => 'image',
));
?>


<?php

echo "<div class='row control-group'>";

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

echo "</div>";
?>

    <?php echo "<div class='row control-group'>" . $form->dropDownListRow($model, 'author_id', $authors_list, array('class' => 'span5')) . "</div>"; ?>

    <?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'controller', array('class' => 'span5', 'maxlength' => 128)) . "</div>"; ?>

    <?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'action', array('class' => 'span5', 'maxlength' => 128)) . "</div>"; ?>

    <?php echo "<div class='row control-group'>" . $form->checkBoxRow($model, 'active') . "</div>"; ?>

</div>

<div class="tab-pane" id="meta">

    <?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'metatitle', array('class' => 'span5', 'maxlength' => 255)) . "</div>"; ?>

    <?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'keywords', array('class' => 'span5', 'maxlength' => 255)) . "</div>"; ?>

    <?php echo "<div class='row control-group'>" . $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 255)) . "</div>"; ?>

</div>


</div>

<?php

$request = Yii::app()->request;

$ret = $request->getParam("returnUrl");

$returnUrl = !empty($ret)?$ret:$request->getUrlReferrer();

echo CHtml::hiddenField('returnUrl', $returnUrl);

?>


<?php echo CHtml::hiddenField('apply', 0); ?>

<div class="form-actions fixed-form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
    ));
    ?>
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
