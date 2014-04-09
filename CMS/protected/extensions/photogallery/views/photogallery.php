<?php

Yii::app()->clientScript->registerCssFile(
    CHtml::asset(dirname(__FILE__) . '/../assets/photogallery.css')
);

$body = null;

$i = 0;

$resize_method = $this->ri ? "ri" : "r";

foreach ($this->files AS $file) {

    $i++;

    if ($this->skip_first AND $i == 1) continue;

    $path = $this->model->getSavePath() . $file;

    if (is_file($path)) {

        $rel_path = $this->model->getRelPath() . $file;

        $rel = 'photogallery_'.get_class($this->model).'_'.$this->model->id.'_'.$this->attr;

        $body .= '<li><a rel="' . $rel . '" href="' . $rel_path . '"><img src="' . ImageResizer::$resize_method($path, $this->width, $this->height, $this->crop) . '" /></a></li>';


    }

}

echo CHtml::tag('ul', $this->htmlOptions, $body, true) . CHtml::tag('div', array("class" => "yii_photogallery_clear"), null, true);

?>
