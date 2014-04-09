<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Templates')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create'),'url'=>array('create')),
	array('label'=>Yii::t('app', 'View'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app', 'Manage'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Update')." ".$model->code; ?></h1>

<button class="btn" id="add_ia"><?=Yii::t('app', 'Add IA')?></button>

<hr />
    
<?php echo CHtml::beginForm(); ?>

<div class="row">
<?php echo CHtml::label(Yii::t('app', 'Php code'), 'tpl'); ?>
<?php echo CHtml::textArea('tpl', $tpl, array('id'=>'tpl', 'rows'=>20, 'style'=>'width: 100%;')); ?>
</div>

<?php

$request = Yii::app()->request;

$ret = $request->getParam("returnUrl");

$returnUrl = !empty($ret) ? $ret : $request->getUrlReferrer();

echo CHtml::hiddenField('returnUrl', $returnUrl);

?>

<?php echo CHtml::hiddenField('apply', 0); ?>


<div class="form-actions">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>Yii::t('app','Save'),
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

<?php echo CHtml::endForm(); ?>


<?

// Добавление включаемой области

Yii::app()->clientScript->registerScript("add_ia_open", "
 
$('#add_ia').on('click', function() { $('#add_ia_dialog').dialog('open'); return false; } );
                               
");

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'add_ia_dialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Добавить включаемую область',
        'autoOpen'=>false,
        'width'=>450,
        'height'=>350,
        'buttons'=>array(
            Yii::t('app', 'Add')=>'js: function() {  $(this).dialog("close"); var wc = new widget_code_construct("ia_form", "IncludeAreaWidget"); insTxt( "tpl", wc.generate() );  }',
            Yii::t('app', 'Close') => 'js: function() { $(this).dialog("close"); }'
            ),
    ),
  
   ));


$this->renderPartial('_ia_form');
       

$this->endWidget('zii.widgets.jui.CJuiDialog');        
        
?>