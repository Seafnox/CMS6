<?php
/**
 * Class GeoLoaderAction ��������� ��������� ������� ������ ��� - ��������
 */
class GeoLoaderAction extends CAction {


    /**
     * ��������� ��������� ������� ��� ��� �����������
     * @param string $modelClass ��� ������ ������ ��������������� �����������
     * @param string $modelAttr ��� �������� ������ ������ ����������� �� �������� ���� ����������
     * @param string $postModel ��� ������ ������ �������� ������� ���������� � POST
     * @param string $postKey ���� ������� POST ���������� �������� ��� ����������
     * @param string|null $prompt ��������� � ������ �������
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