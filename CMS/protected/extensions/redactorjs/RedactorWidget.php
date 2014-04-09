<?php

/**
 * Виджет для динамического формирования формы добаления элементов
 */

class RedactorWidget extends CWidget
{


    public $model;
    public $name;
    public $htmlOptions;

    /**
     * Массив объектов свойств
     * @var array
     */

    public $properties;

    public function init()
    {


    }

    public function run()
    {

        $this->render('redactor', array('model' => $this->model, 'name' => $this->name, 'htmlOptions' => $this->htmlOptions));

    }
}

?>
