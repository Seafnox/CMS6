<?php

/**
 * Class ConfigAccess компонент доступа к пользовательскому свойству
 */

class ConfigAccess extends CComponent {

    public $modelClass;

    protected $config = array();


    public function init() {

        if(is_null($this->modelClass))
            return;


        $modelClass = $this->modelClass;

        $models = $modelClass::model()->findAll();

        foreach($models AS $model) {

            $this->config[$model->key] = $model->value;

        }


    }

    /**
     * Получение свойства по идентификатору
     * @param $key идентификатор свойства
     * @return mixed
     */

    public function get($key) {

        return isset($this->config[$key])?$this->config[$key]:null;

    }



}