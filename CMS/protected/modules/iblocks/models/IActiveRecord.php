<?php

/**
 * Class IActiveRecord. Active Record для информационных блоков
 */

abstract class IActiveRecord extends CActiveRecord {


    /**
     * Массив хранящий модели инфоблоков
     * @var array
     */

    public static $iblocks = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Property the static model class
     */

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Возвращает идентификатор информационного блока
     * @return integer
     */

    public abstract function iblockId();


    /**
     * Возвращает массив описывающий информауионный блок. Содержит модели свойств и связей.
     * @return array
     */

    public function getIblock() {

        $id = $this->iblockId();

        if(empty(self::$iblocks[$id])) {

             self::$iblocks[$id] = Iblocks::model()->findByPk($id);

        }


        return self::$iblocks[$id];

    }

    /**
     * Возвращает свойство по его имени.
     * @param string $name имя свойства
     * @return Iproperty|null
     */

    public function getProp($name) {

        $iblock = $this->getIblock();

        $props =  $iblock->properties;

        foreach($props AS $prop) {

            if($prop->name == $name OR $prop->relation_name == $name)
                return $prop;

        }

        return null;

    }


    /**
     * Реляционные связи
     * @return array
     */

    public function relations()
    {


        $rel = array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'), // Связь с владельцем
        );

        $iblock = $this->getIblock();

        // Формирование связей из свойств

        $props =  $iblock->properties;

        foreach($props AS $prop) {

            $relation = $prop->relation;

            if($relation == "BELONGS_TO") {

                $rel[$prop->relation_name] = array(self::BELONGS_TO, $prop->relation_model, $prop->name);

            } elseif($relation == "MANY_MANY") {

                $iblockModelName = Iblocks::getModelName($iblock->code);

                $relTable = Iproperty::getMtmRelTableName($iblockModelName, $prop->relation_model, $prop->relation_name);

                $fieldFrom = Iproperty::getMtmRelFieldName($iblockModelName);

                $fieldTo = Iproperty::getMtmRelFieldName($prop->relation_model);

                $rel[$prop->relation_name] = array(self::MANY_MANY, $prop->relation_model,"$relTable($fieldFrom, $fieldTo)");

            }

        }

        return $rel;

    }

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {

        $beh = array(

            'CAdvancedArBehavior' => array(
                'class' => 'application.extensions.CAdvancedArBehavior'),

            'permission'=>array(
                'class'=>'application.modules.main.components.PermissionBehavior',
            ),

        );


        $iblock = $this->getIblock();

        $props =  $iblock->properties;

        $i = 1;

        foreach($props AS $prop) {

            if($prop->isFile()) {

                $beh["UploadableFileBehavior_".$i] =  array(
                    'class' => 'application.extensions.UploadableFileBehavior',
                    'attributeName' => $prop->name,
                );

            }

            $i++;

        }

        return $beh;

    }


    /**
     * Правила валидации
     * @return array
     */

    public function rules()
    {

        $all = array('author_id', 'mtime', 'active');

        $required = array();

        $iblock = $this->getIblock();

        $props =  $iblock->properties;

        foreach($props AS $prop) {

            if($prop->relation == "MANY_MANY") {

                $all[] = $prop->relation_name;

                if($prop->required) {

                    $required[] = $prop->relation_name;

                }

            } else {

                $all[] = $prop->name;

                if($prop->required) {

                    $required[] = $prop->name;

                }

            }


        }

        return array(
            array(implode(',', $required), 'required'),
            array(implode(',', $all), 'safe'),
            array('id', 'safe', 'on'=>'search')
        );


    }

    /**
     * Наименование атрибутов
     * @return array
     */

    public function attributeLabels()
    {

        $names = array(

            "id" => Yii::t('app', 'Id'),
            "author_id" => Yii::t('app', 'Author'),
            "mtime" => Yii::t('app', 'Mtime'),
            "active" => Yii::t('app', 'Active'),

        );

        $iblock = $this->getIblock();

        $props =  $iblock->properties;

        foreach($props AS $prop) {

            if(!empty($prop->name))
                $names[$prop->name] = $prop->title;

            if(!empty($prop->relation_name))
                $names[$prop->relation_name] = $prop->title;

        }

        return $names;
    }


    /**
     * Удаление элементов по условию
     */

    public function deleteAllRecords() {


        $dataProvider = $this->search();

        $iterator = new CDataProviderIterator($dataProvider, 50);

        foreach($iterator as $model) {
            if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
                $model->delete();
        }

    }

    /**
     * Привязка элементов к категории по условию
     */

    public function linkSection($sectionId) {


        $dataProvider = $this->search();

        $iterator = new CDataProviderIterator($dataProvider, 50);

        foreach($iterator as $model) {

            if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                continue;

            $sections = $model->getRelated('sections');

            $newSections = array();

            foreach($sections AS $section) {

                $newSections[] = $section->id;

            }

            $newSections[] = $sectionId;

            $model->sections = $newSections;

            $model->save();

        }


    }


    /**
     * Перенос элементов в категорию по условию
     */

    public function replaceSection($sectionId) {


        $dataProvider = $this->search();

        $iterator = new CDataProviderIterator($dataProvider, 50);

        foreach($iterator as $model) {

            if(!Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                continue;

            $model->sections = array($sectionId);

            $model->save();

        }


    }

    /**
     * Поиск
     * @return CActiveDataProvider
     */

    public function search()
    {

        $criteria = new CDbCriteria;

        $iblock = $this->getIblock();

        $criteria->compare('t.id', $this->id);

        $criteria->compare('t.author_id', $this->author_id);

        $criteria->compare('t.mtime', $this->mtime);

        $criteria->compare('t.active', $this->active);

        $props = $iblock->properties;

        $with = array();

        foreach($props AS $prop) {

            if($prop->show_filter) { // По свойству разрешен поиск

               if($prop->relation == "MANY_MANY") {

                   $relationName = $prop->relation_name;

                   if (!empty($this->$relationName)) {

                       $criteria->compare("$relationName.id", $this->$relationName);

                       $with[$relationName] = array("together" => true);

                       $criteria->group = "t.id";

                   }


               } else {

                    $name = $prop->name;

                    $partial = $prop->isText();

                    $criteria->compare('t.'.$name, $this->$name, $partial);

               }

            }

        }

        $criteria->with = $with;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,

        ));
    }


    /**
     * Формирование строки имен связанных элементов через many many
     * @param string $relationName имя связи
     * @param string $attr отображаемый атрибут
     * @return mixed
     */

    public function mtmGridVal($relationName, $attr = "id") {


        if(!is_array($this->$relationName))
            return null;

        $arr = array();

        foreach($this->$relationName AS $item) {

            if($item->hasAttribute($attr))
                $arr[] = $item->$attr." (".$item->id.")";
            else
                $arr[] = $item->id;


        }

        return implode(", ", $arr);

    }


    /**
     * Перед сохранением
     * @return bool
     */

    protected function beforeSave() {

        $this->mtime = date("Y-m-d H:i:s"); // Устанавливаем дату изменения

        if( ! $this->author_id ) { // Если не задан автор
            $this->author_id = Yii::app()->user->id;
        }

        return parent::beforeSave();

    }


}