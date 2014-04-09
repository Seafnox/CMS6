<?php

/**
 * Виджет для отображения коллекции объектов на карте
 */

class MapCollectionWidget extends CWidget
{

    /**
     * Массив моделей объектов
     * @var array
     */
    public $models = array();

    /**
     * Имя атрибута название
     * @var string
     */

    public $title_attr = "title";

    /**
     * Имя атрибута координаты
     * @var string
     */

    public $coords_attr = "coords";

    /**
     * Имя атрибута адрес
     * @var string
     */

    public $address_attr = "address";

    /**
     * Идентификатор контейнера для карты
     * @var type
     */

    public $map_id = "Yamap";

    /**
     * Ширина карты
     * @var integer
     */

    public $map_width = 500;

    /**
     * Высота карты
     * @var integer
     */

    public $map_height = 500;

    /**
     * Масштаб карты
     * @var integer
     */

    public $map_zoom = 13;

    /**
     * Отображать список моделей
     * @var boolen
     */

    public $show_list = true;

    /**
     * Модели в формате json
     * @var string
     */

    protected $jmodels;


    public function init()
    {

        $arr = array();

        $coords_attr = $this->coords_attr;
        $title_attr = $this->title_attr;
        $address_attr = $this->address_attr;

        foreach ($this->models AS $model) {

            $arr[] = array(

                "title" => $model->$title_attr,
                "coords" => $model->$coords_attr,
                "address" => $model->$address_attr

            );

        }


        $this->jmodels = json_encode($arr);

    }


    public function run()
    {

        $this->render('collection');

    }


}

?>
