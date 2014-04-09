<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>\n"; ?>

<p class="help-block"><?php echo "<?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}' => '<span class=\"required\">*</span>')); ?>";?></p>

<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach ($this->tableSchema->columns as $column) {
	if ($column->autoIncrement) {
		continue;
	}
	?>
	<?php echo "<div class=\"control-group row\"><?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?></div>\n"; ?>

<?php
}
?>

<?php

echo "<?php

        \$request = Yii::app()->request;

        \$ret = \$request->getParam(\"returnUrl\");

        \$returnUrl = !empty(\$ret)?\$ret:\$request->getUrlReferrer();

        echo CHtml::hiddenField('returnUrl', \$returnUrl);

        echo CHtml::hiddenField('apply', 0);

    ?>";

?>


<div class="form-actions fixed-form-actions">

	<?php

    echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => \$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
    )); ?>\n";



    echo "&nbsp;<?php
            \$this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'label' => Yii::t('app', 'Apply'),
                'htmlOptions' => array(
                    'onClick' => '\$(\"#apply\").val(1)'
                )
            ));
           ?>\n";



    echo "&nbsp;<?php
            \$this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'url' => \$returnUrl,
                'label' => Yii::t('app', 'Cancel'),
            ));
            ?>\n";

    ?>

</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
