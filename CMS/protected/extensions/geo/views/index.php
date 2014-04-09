<?php

$class = get_class($this->model);

$countryFieldId = $class."_".$this->countryAttr;

$regionFieldId = $class."_".$this->regionAttr;

$rajonFieldId = $class."_".$this->rajonAttr;

$npFieldId = $class."_".$this->npAttr;

$pref = "hidden"."_".get_class($this)."_";

// Страны
?>
<div class="<?=$this->class?>">
<?
echo CHtml::activeLabelEx($this->model, $this->countryAttr);

if(!$this->search)
    echo CHtml::activeHiddenField($this->model, $this->countryAttr, array("value"=>0, "id"=>$pref."_".$this->countryAttr));

echo CHtml::activeDropDownList($this->model, $this->countryAttr, CHtml::listData($this->countryModels, "id", "title"),
    array(
        "class"=>"span12",
        "prompt"=>"",
        "ajax"=> array(
            'type' => 'POST', //request type
            'url' => Yii::app()->createUrl($this->route, array('prompt'=>"Область/республика", "modelClass"=>"GeoRegion", "modelAttr"=>"country_id", "postModel"=>$class, "postKey"=>$this->countryAttr)), //url to call.
            'success' => 'function(data) {
                            var def = ' . (!empty($this->model->{$this->regionAttr})?$this->model->{$this->regionAttr}:0) . ';

                            var elem =     $("#'.$regionFieldId.'").html(data).val(def);

                            if(data.length==0)
                                elem.change().attr("disabled", "disabled");
                            else
                                elem.attr("disabled", null).change();
                    }',
        )

    )
);
?>
</div>
<div class="<?=$this->class?>">
<?
// Области / республики / края
echo CHtml::activeLabelEx($this->model, $this->regionAttr);
if(!$this->search)
    echo CHtml::activeHiddenField($this->model, $this->regionAttr, array("value"=>0, "id"=>$pref."_".$this->regionAttr));
echo CHtml::activeDropDownList($this->model, $this->regionAttr, array(),
    array(
         "class"=>"span12",
         "ajax"=> array(
                    'type' => 'POST', //request type
                    'url' => Yii::app()->createUrl($this->route, array('prompt'=>"", "modelClass"=>"GeoRajon", "modelAttr"=>"region_id", "postModel"=>$class, "postKey"=>$this->regionAttr)), //url to call.
                    'success' => 'function(data) {
                            var def = ' . (!empty($this->model->{$this->rajonAttr})?$this->model->{$this->rajonAttr}:0) . ';

                            var elem = $("#'.$rajonFieldId.'").html(data).val(def);

                            if(data.length==0)
                                elem.change().attr("disabled", "disabled");
                            else
                                elem.attr("disabled", null).change();
                    }',
                )

    )
);
?>
</div>
<div class="<?=$this->class?>">
<?
// Города / районы
echo CHtml::activeLabelEx($this->model, $this->rajonAttr);
if(!$this->search)
    echo CHtml::activeHiddenField($this->model, $this->rajonAttr, array("value"=>0, "id"=>$pref."_".$this->rajonAttr));
echo CHtml::activeDropDownList($this->model, $this->rajonAttr, array(),array(
    "class"=>"span12",
    "ajax"=> array(
        'type' => 'POST', //request type
        'url' => Yii::app()->createUrl($this->route, array('prompt'=>"", "modelClass"=>"GeoNp", "modelAttr"=>"rajon_id", "postModel"=>$class, "postKey"=>$this->rajonAttr)), //url to call.
        'success' => 'function(data) {
                            var def = ' . (!empty($this->model->{$this->npAttr})?$this->model->{$this->npAttr}:0) . ';

                            var elem = $("#'.$npFieldId.'").html(data).val(def);

                            if(data.length==0)
                               elem.change().attr("disabled", "disabled");
                            else
                               elem.attr("disabled", null).change();



                    }',
    )

));
?>
</div>
<div class="<?=$this->class?>">
    <?
// Населенные пункты / районы города
echo CHtml::activeLabelEx($this->model, $this->npAttr);
if(!$this->search)
    echo CHtml::activeHiddenField($this->model, $this->npAttr, array("value"=>0, "id"=>$pref."_".$this->npAttr));
echo CHtml::activeDropDownList($this->model, $this->npAttr, array(), array("class"=>"span12"));

Yii::app()->clientScript->registerScript("geo_".spl_object_hash($this), "
            $('#".$countryFieldId."').change();
        ", CClientScript::POS_READY);

?>
    </div>
