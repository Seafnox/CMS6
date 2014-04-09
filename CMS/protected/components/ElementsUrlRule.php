<?php

/**
 * Класс url правил для типов данных сайта. Используется маршрут fronted/elements.
 */

class ElementsUrlRule extends AppUrlRule
{
    public $connectionID = 'db';

    // @TODO переработать обработку url информационных блоков

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'fronted/elements' AND isset($params['section_url']) AND isset($params['element_code']) AND isset($params['iblock_code'])) // Для формирования url необходим url категории, символьный код эелемента и символьный код типа данных
        {

            $params['section_url'] = trim($params['section_url'], "/");

            // Формируем строку параметров

            $show_params = $params;

            unset($show_params["section_url"]);

            unset($show_params["element_code"]);

            unset($show_params["iblock_code"]);

            $p_str = $this->getParamsStr($show_params);

            $url = $params['section_url'] . "/data-" . $params['iblock_code'] . "/" . $params['element_code'] . "/" . $p_str;

            return $url;

        }
        return false; // не применяем данное правило
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {

        if (substr_count($pathInfo, '/data-') == 0) return false; // не обрабатываем данный запрос. этот запрос к категории

        $arr = explode("/", $pathInfo);

        $element_code = array_pop($arr);

        $iblock_code = str_replace("data-", "", array_pop($arr));

        $class_name = "Iblock" . ucfirst($iblock_code); // Класс модели типа данных

        $element = $class_name::model()->find("code = :code", array(":code" => $element_code));

        $iblock = Iblocks::model()->find("code = :code", array(":code" => $iblock_code));

        $controller = $iblock->fronted_controller;

        if (empty($controller)) return false; // не применяем данное правило

        // Определяем действие

        if (!empty($_GET["action"])) $action = $_GET["action"];
            else $action = !empty($iblock->fronted_action) ? $iblock->fronted_action : "indexdata";

        $section = Section::findSectionByUrl(implode("/", $arr)); // Объект текущей категории

        Yii::app()->params["request_object"] = $element; // Сохраняем в реестре найденный объект

        Yii::app()->params["section_object"] = $section; // Сохраняем в реестре объект категории

        // Возвращаем маршрут

        return $controller . $action;

    }
}

?>
