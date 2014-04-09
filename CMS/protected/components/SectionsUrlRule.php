<?php

/**
 * Класс url правил для категорий сайта. Используется маршрут fronted/sections.  
 */
class SectionsUrlRule extends AppUrlRule {

    public $connectionID = 'db';

    /**
     * Идентификатор главной страницы
     * @var штеупук 
     */
    public $main_page_id = 1;

    /**
     * Массив сформировынных url
     * @var array 
     */
    protected static $urls = array();

    public function createUrl($manager, $route, $params, $ampersand) {
        if ($route == 'fronted/sections' AND isset($params['id'])) { // Для формирования url необходим id категории
            if (isset(self::$urls[$params['id']])) { // Url уже формировался
                $sect_str = self::$urls[$params['id']];
            } else {
                $section = Section::model()->findByPk($params['id']);

                if (!$section)
                    throw new AppException('Категория с id ' . $params['id'] . ' не найдена');

                $arr = $section->getUrlArr();

                $sect_str = implode("/", $arr);

                self::$urls[$params['id']] = $sect_str;
            }

            // Формируем строку параметров

            $show_params = $params;

            unset($show_params["id"]);

            $p_str = $this->getParamsStr($show_params);

            $url = $sect_str . "/" . $p_str;

            return $url;
        }
        return false;  // не применяем данное правило
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {

        if (substr_count($pathInfo, '/data-') > 0)
            return false; // не обрабатываем данный запрос. этот запрос к элементу типа данных

        if (empty($pathInfo)) { // Главная страница
            $section = Section::model()->findByPk($this->main_page_id);
        } else {
            $section = Section::findSectionByUrl($pathInfo);
        }
        if (!$section)
            return false; // Не применяем данное правило

        $controller = $section->controller;

        if (empty($controller))
            return false; // не применяем данное правило



            
// Определяем действие

        if (!empty($_GET["action"]))
            $action = $_GET["action"];
        else
            $action = !empty($section->action) ? $section->action : "index";

        Yii::app()->params["request_object"] = $section; // Сохраняем в реестре найденный объект

        Yii::app()->params["section_object"] = $section; // Сохраняем в реестре объект категории
        // Возвращаем маршрут

        return $controller .  $action;
    }

}

?>
