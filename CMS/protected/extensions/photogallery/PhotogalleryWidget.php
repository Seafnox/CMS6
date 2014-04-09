<?php

/**
 * Виджет для вывода фотогалереи
 */

class PhotogalleryWidget extends CWidget
{

    public $model;
    public $attr;
    public $htmlOptions = array();
    public $width = 100;
    public $height = 0;
    public $crop = 0;
    public $ri = false; // Умный ресайз
    public $default_class = "yii_photogallery_list";

    /**
     * Пропускать первую фото
     * @var boolen
     */

    public $skip_first = false;

    protected $files;

    public function init()
    {

        $attr = $this->attr;

        $this->files = $this->model->getFileNames($attr);

        if (!isset($this->htmlOptions['class'])) {

            $this->htmlOptions['class'] = $this->default_class;

        }

    }

    public function run()
    {

        $this->render('photogallery');

    }


}


?>
