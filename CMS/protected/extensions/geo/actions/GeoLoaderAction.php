<?php
/**
 * Class GeoLoaderAction подгрузка зависимых списков выбора гео - привязки
 */
class GeoLoaderAction extends CAction {


    /**
     * Подгрузка зависимых списков для гео справочника
     * @param string $modelClass имя класса модели географического справочника
     * @param string $modelAttr имя атрибута класса модели справочника по которому идет фильтрация
     * @param string $postModel имя класса модели атрибуты которой передаются в POST
     * @param string $postKey ключ массива POST содержащий значение для фильтрации
     * @param string|null $prompt подсказка в первой строчке
     */

    public function run($modelClass, $modelAttr, $postModel, $postKey, $prompt = null) {

        if(empty($modelClass) OR empty($modelAttr) OR empty($postKey) OR empty($_POST[$postModel][$postKey]))
            Yii::app()->end();

        $areas = $modelClass::model()->findAll(
            array('condition' => "$modelAttr=:$modelAttr", 'params' => array(":$modelAttr" => (int) $_POST[$postModel][$postKey]), 'order' => 'title asc')
        );

        if(empty($areas))
            Yii::app()->end();

        $areas_list = CHtml::listdata($areas, 'id', 'title');

        if (!is_null($prompt)) {
            echo CHtml::tag('option', array('value' => null), $prompt, true);
        }
        foreach ($areas_list as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

    }


}