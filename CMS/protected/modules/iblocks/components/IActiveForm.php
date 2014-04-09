<?php

Yii::import('ext.bootstrap.widgets.TbActiveForm');

class IActiveForm extends TbActiveForm {
    
    public static $formFieldTypesList = array(
        
        "iTextFieldRow" => "Текстовое поле",
        "iTextAreaRow" => "Текстовая область",
        "iPasswordFieldRow" => "Поле ввода пароля",
        "iDropDownListRow" => "Выпадающий список",
        "iRadioButtonListRow" => "Список radio button",
        "iDropDownMultiListRow" => "Выпадающий список множественного выбора",
        "iCheckBoxRow" => "Переключатель checkbox",
        "iFileRow" => "Файл",
        "iHtmlRow" => "Html редактор",
        "iFileManagerRow" => "Файловый менеджер",
        "iDateRow" => "Поле ввода даты"
        
    );

    public function getParamName($prop) {

        return ($prop->relation == "MANY_MANY")?$prop->relation_name:$prop->name;

    }

    public function getParamData($prop) {

        $data = array();

        if(!empty($prop->data_code)) {

            eval("\$data=".$prop->data_code.";");

        }

        return $data;

    }

    public function iTextFieldRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"span5"), $htmlOptions);

        return parent::textFieldRow($model, $this->getParamName($prop), $htmlOptions);

    }

    public function iPasswordFieldRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"span5"), $htmlOptions);

        return parent::passwordFieldRow($model, $this->getParamName($prop), $htmlOptions);

    }

    public function iDropDownListRow($model, $prop, $htmlOptions=array()) {

       $htmlOptions = array_merge(array("class"=>"span5", "prompt"=>""), $htmlOptions);

       return parent::dropDownListRow($model, $this->getParamName($prop), $this->getParamData($prop), $htmlOptions);

    }

    public function iRadioButtonListRow($model, $prop, $htmlOptions = array()) {

        return parent::radioButtonListRow($model, $this->getParamName($prop), $this->getParamData($prop), $htmlOptions);

    }

    public function iDropDownMultiListRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"span5", "multiple"=>true), $htmlOptions);

        $hiddenName = get_class($model)."[".$this->getParamName($prop)."]";

        $hiddenId = get_class($model)."_".$this->getParamName($prop)."_hidden";

        $html = CHtml::hiddenField($hiddenName, null, array("id"=>$hiddenId));

        $html .= parent::dropDownListRow($model, $this->getParamName($prop), $this->getParamData($prop), $htmlOptions);

        return $html;

    }

    public function iCheckBoxRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"checkbox"), $htmlOptions);

        return parent::checkBoxRow($model, $this->getParamName($prop), $htmlOptions);

    }

    public function iTextAreaRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"span5", "rows"=>10), $htmlOptions);

        return parent::textAreaRow($model, $this->getParamName($prop), $htmlOptions);

    }


    public function iFileRow($model, $prop, $htmlOptions=array()) {

        $name = $this->getParamName($prop);

        $html = "<div class='row control-group'>" . $this->label($model, $name);

        $html .= $this->widget('CMultiFileUpload', array(
            'htmlOptions' => $htmlOptions,
            'model' => $model,
            'attribute' => $name,
            'accept' => 'jpg|gif|png|jpeg|doc|docx|pdf|xls|xlsx|odt|txt|csv|swf|zip|rar|tar|gz',
            /* 'options'=>array(
              'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
              'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
              'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
              'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
              'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
              'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
              ), */
        ), true);

        $html .= $this->error($model, $name) ;

        $html .= $this->widget('RemoveFilesWidget', array(
            'model' => $model,
            'attr' =>  $name,
        ), true);


        $html .= "</div>";

        return $html;

    }

    public function iHtmlRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array(
            'rows' => 6,
            'cols' => 60,
        ), $htmlOptions);

        $name = $prop->name;

        $html = "<div class='row control-group'>" . $this->label($model, $name);

        /*$html .= $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$model,
            'attribute'=>$name,
        ), true);*/


        $html .= $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => $name,
            // Optional config
            'compressorRoute' => 'main/admin/tinyMce/compressor',
            'spellcheckerRoute' => 'main/admin/tinyMce/spellchecker',
            'fileManager' => array(
                'class' => 'ext.elfinder.TinyMceElFinder',
                'connectorRoute'=>'main/admin/elfinder/connector',
            ),
            'htmlOptions' => $htmlOptions,
        ), true);


        $html .= $this->error($model, $name) ;

        $html .= "</div>";

        return $html;

    }

    public function iFileManagerRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array("class"=>"span5"), $htmlOptions);

        $name = $prop->name;

        $html = "<div class='row control-group'>" . $this->label($model, $name);

        $html .= $this->widget('ext.elfinder.ServerFileInput', array(
                'model' => $model,
                'attribute' => $name,
                'connectorRoute' => 'main/admin/elfinder/connector',
                'htmlOptions' => $htmlOptions
            ), true
        );

        $html .= $this->error($model, $name) ;

        $html .= "</div>";

        return $html;

    }

    public function iDateRow($model, $prop, $htmlOptions=array()) {

        $htmlOptions = array_merge(array('class'=>'span5', 'style' => 'height:20px;'), $htmlOptions);

        $name = $prop->name;

        $html = "<div class='row control-group'>" . $this->labelEx($model, $name);

        $html .= $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => $name,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => $htmlOptions,
        ), true);


        $html .= "<br />".$this->error($model, $name) ;

        $html .= "</div>";


        return $html;

    }


} 


?>
