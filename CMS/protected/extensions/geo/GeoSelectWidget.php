<?php

/**
 * Class GeoSelectWidget виджет выбора географической привязки
 */

class GeoSelectWidget extends CWidget {

    /**
     * @var CActiveRecord модель
     */

    public $model;

    /**
     * @var string атрибут для хранения идентификатора страны
     */

    public $countryAttr;

    /**
     * @var string атрибут для хранения идентификатора региона
     */

    public $regionAttr;


    /**
     * @var string атрибут для хранения идентификатора района/города
     */

    public $rajonAttr;

    /**
     * @var string атрибут для хранения идентификатора населенного пункта/района города
     */

    public $npAttr;

    /**
     * @var string маршрут для подгрузки зависимых списков
     */

    public $route;

    /**
     * @var array массив начальных значений в формате array("regionAttr"=>1, "rajonAttr"=>2, "npAttr"=>3)
     */

    /**
     * @var string класс контейнеров содержащих select
     */

    public $class = "span3";

    /**
     * @var bool используется при поиске
     */

    public $search = false;

    public $defaults = array();

    /**
     * @var массив моделей регионов
     */

    protected $countryModels = array();

    public function init() {

        $this->countryModels = GeoCountrys::model()->findAll();

        if($this->model->isNewRecord) {

            foreach($this->defaults AS $k => $v) {
                if(empty($this->model->$k))
                    $this->model->$k = $v;
            }

        }

    }


    public function run() {

        $this->render('index');

    }


}

?>