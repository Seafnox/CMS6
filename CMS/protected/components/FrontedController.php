<?php

/**
 * Базовый контроллер сайта
 */
abstract class FrontedController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout;

    /**
     * Мета - тег title
     * @var string 
     */
    public $metatitle;

    /**
     * Мета - тег keywords
     * @var string 
     */
    public $keywords;

    /**
     * Мета - тег description
     * @var type 
     */
    public $description;

    /**
     * Инициализация 
     */
    public function init() {

        $cs = Yii::app()->getClientScript();
       
        $cs->registerCoreScript( 'jquery' ); // Подключаем jquery
       
        $cs->registerCoreScript('cookie'); // Плагин для работы с cookie
     
        $cs->registerScriptFile('/js/underscore-min.js');
        
        $this->loadLayout();

        $this->loadMeta();
    }

    
    /**
     * Определение шаблона 
     */
    protected function loadLayout() {

        $request = Yii::app()->getRequest();

        $url = $request->getPathInfo();

        $criteria = new CDbCriteria;

        $criteria->order = "sort desc";

        $templates = Template::model()->findAll($criteria);

        foreach ($templates AS $templ) {


            switch ($templ->cond_type) {

                case 1: // Совпадение по URL

                    $cond_arr = explode(",", $templ->cond);

                    foreach ($cond_arr AS $cond) {

                        $cond = trim($cond, " /");

                        $pattern = "!^" . str_replace("*", ".*?", $cond) . "$!i"; // Преобразуем шаблон в регулярное выражение

                        if (preg_match($pattern, $url)) // Совпадение url одному из шаблонов
                        {
                                $tpl = $templ->code;

                                break;
                        }
                    }

                    break;

                case 2: // PHP выражение

                    $test = eval($templ->cond);

                    if ($test)
                        $tpl = $templ->code;

                    break;


                default: // Нет условия
                    $tpl = $templ->code;
            }



            if (!empty($tpl))
                break;
        }

        if (empty($tpl))
            throw new AppException('Шаблон для адреса $url не найден');

        $this->layout = '//layouts/' . $tpl;
    }

    /**
     * Определение  мета -тегов 
     */
    protected function loadMeta() {

        $obj = Yii::app()->params["request_object"];

        $this->metatitle = !empty($obj->metatitle) ? $obj->metatitle : null;
        $this->metatitle = (empty($this->metatitle) AND !empty($obj->title)) ? $obj->title : $this->metatitle;
        $this->keywords = !empty($obj->keywords) ? $obj->keywords : null;
        $this->description = !empty($obj->description) ? $obj->description : null;
    }

    /**
     * Просмотр страницы. Данный метод вызывается по умолчанию при обращении к категории. 
     */
    public function actionIndex() {}

    /**
     * Просмотр страницы. Данный метод вызывается по умолчанию при обращении к типу данных. 
     */

    public function actionIndexData() {}
    
}