<?php

/**
 * Class PermissionBehavior поведение для получения прав доступа
 */

class PermissionBehavior extends CActiveRecordBehavior {

    protected static $_permissions = array();

    /**
     * Возвращаеи объект прав доступа
     * @return null|CActiveRecord
     */

    public function getPermission() {

        $class = get_class($this->owner);

        if(!isset(self::$_permissions[$class])) {
            self::$_permissions[$class] = Permission::model()->find("role = :role AND model = :model", array(":role"=>Yii::app()->user->getRole(), ":model"=>$class));
        }

        return self::$_permissions[$class];

    }


    /**
     * Проверяет есль ли в массиве модели, которые можно удалять
     * @param $models Массив моделей CActiveRecord
     * @return bool
     */

    public function hasDeleted($models) {

        foreach($models AS $model) {

            if(Yii::app()->user->checkAccess('deleteModel', array("model"=>$model)))
                return true;
        }

        return false;

    }

    /**
     * Проверяет есль ли в массиве модели, которые можно изменять
     * @param $models Массив моделей CActiveRecord
     * @return bool
     */

    public function hasUpdated($models) {

        foreach($models AS $model) {

            if(Yii::app()->user->checkAccess('updateModel', array("model"=>$model)))
                return true;
        }

        return false;

    }




}