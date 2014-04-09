<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iproperty-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with {tag} are required.', array('{tag}'=>'<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo "<div class='row control-group'>".$form->hiddenField($model,'iblock_id',array('class'=>'span5'))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

    <?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'tab',  $model->iblock->getTabs(), array('class'=>'span5','maxlength'=>64))."</div>"; ?>


    <?php

        $resDisabled = (!$model->isNewRecord AND $model->relation == "MANY_MANY")?true:false;

    ?>


    <?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'relation',  Iproperty::$relationsList, array('class'=>'span5','maxlength'=>32, 'prompt'=>'', 'disabled'=>($model->isNewRecord)?false:true))."</div>"; ?>

    <div class="relation-group">

    <?php echo "<div class='row control-group'>".$form->textFieldRow($model,'relation_name',array('class'=>'span5','maxlength'=>64, 'disabled'=>$resDisabled))."</div>"; ?>

    <?php echo "<div class='row control-group'>".$form->textFieldRow($model,'relation_model',array('class'=>'span5','maxlength'=>64, 'disabled'=>$resDisabled))."</div>"; ?>

    </div>

    <?php echo "<div class='row control-group mtm-hide'>".$form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255))."</div>"; ?>

<?

        $cs = Yii::app()->clientScript;

        $cs->registerScript("change-relation", "

            $('#Iproperty_relation').on('change',function(){

                if($(this).val() == '') {
                    $('.relation-group').hide();
                }
                else {
                    $('.relation-group').show();
                }


                if($(this).val() == 'MANY_MANY') {
                    $('.mtm-hide').hide();
                }
                else {
                    $('.mtm-hide').show();
                }

            }).trigger('change');


        ", CClientScript::POS_END);


    ?>



	<?php echo "<div class='row control-group'>".$form->dropDownListRow($model,'field',  IActiveForm:: $formFieldTypesList, array('class'=>'span5','maxlength'=>64))."</div>"; ?>

	<?php echo "<div class='row control-group'>".$form->textAreaRow($model,'data_code',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))."</div>"; ?>


        <pre>
        // Пример
        CHtml::listdata(IblockNews::model()->findAll(), 'id', 'title')</pre>


	<?php echo "<div class='row control-group'>".$form->textAreaRow($model,'list_code',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))."</div>"; ?>


        <pre>
        // Пример
        array(
            'header' => Yii::t('app', 'Sections'),
            'name' => 'sections',
            'filter' => Section::getListData(1),
            'type' => 'raw',
            'value' => '$data->mtmGridVal("sections", "title")'
        )</pre>

    <?php echo "<div class='row control-group'>".$form->textAreaRow($model,'view_code',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))."</div>"; ?>


    <pre>
        // Пример
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => $model->title
        )</pre>

          
        <?php echo "<div class='row control-group mtm-hide'>".$form->dropDownListRow($model,'type', Iproperty::$fieldTypesList, array('prompt'=>'')
                )."</div>";
        ?>

	            <?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'show_in_list')."</div>"; ?>

                <?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'show_in_view')."</div>"; ?>

                <?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'show_filter')."</div>"; ?>

                <?php echo "<div class='row control-group mtm-hide'>".$form->checkBoxRow($model,'editable')."</div>"; ?>

                <?php echo "<div class='row control-group'>".$form->checkBoxRow($model,'required')."</div>"; ?>

<?php

$request = Yii::app()->request;

$ret = $request->getParam("returnUrl");

$returnUrl = !empty($ret) ? $ret : $request->getUrlReferrer();

echo CHtml::hiddenField('returnUrl', $returnUrl);

?>

<?php echo CHtml::hiddenField('apply', 0); ?>

	<div class="form-actions fixed-form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),
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
