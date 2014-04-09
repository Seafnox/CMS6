<?php

class IblockNews extends IActiveRecord {


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations() {

        $parentRel = parent::relations();

        $rel = array(); // Массив со связями

        return array_merge($parentRel, $rel);

    }

    public function behaviors() {

        $parentBeh = parent::behaviors();

        $beh = array(); // Массив с поведениями

        return array_merge($parentBeh, $beh);

    }


    public function rules() {

        $parentRul = parent::rules();

        $rul = array(

            array('code', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'code', 'className' => 'IblockNews'),
            array('code', 'match', 'pattern' => '/^([a-z0-9_-])+$/'),
            array('code', 'match', 'pattern' => '/^(?!data-).*$/'),

        ); // Массив с правилами валидации

        return array_merge($parentRul, $rul);

    }


    public function tableName()
    {
        return 'iblock_news';
    }


    public function iblockId() {
        return 2;
    }


}

?>