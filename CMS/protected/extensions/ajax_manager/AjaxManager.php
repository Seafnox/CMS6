<?php

/**
 * Менеджер асинхронных запросов
 */
class AjaxManager extends CComponent
{

    /**
     * Режим отладки
     * @var boolen
     */

    public $debug = false;

    public function init()
    {

        // Добавляем псевдоним пути

        if (!Yii::getPathOfAlias('ajax_manager'))
            Yii::setPathOfAlias('ajax_manager', realpath(dirname(__FILE__)));

        // Публикуем в ресурсы

        $assetsPath = Yii::getPathOfAlias('ajax_manager.assets');

        if ($this->debug)
            $assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, true);
        else
            $assetsUrl = Yii::app()->assetManager->publish($assetsPath);

        // Подключаем скрипты

        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($assetsUrl . '/js/jquery.json-2.3.min.js');
        $cs->registerScriptFile($assetsUrl . '/js/jquery.ba-bbq.min.js');
        $cs->registerScriptFile($assetsUrl . '/js/param_manager.js');
        $cs->registerScriptFile($assetsUrl . '/js/ajax_manager.js');
        $cs->registerScriptFile($assetsUrl . '/js/ajax_loader.js');

    }

}

?>
