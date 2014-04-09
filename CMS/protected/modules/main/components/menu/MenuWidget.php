<?php

/**
 * Class MenuWidget Виджет для отображения меню
 */

class MenuWidget extends CWidget
{

    /**
     * @var array массив корневых моделей меню
     */

    protected static $menus;

    /**
     * @var string Символьный идентификатор меню
     */

    public $code;

    /**
     * @var int Уровень вложенности меню
     */

    public $level = 2;

    /**
     * @var string Путь к шаблону
     */

    public $tplPath;

    /**
     * @var boolean Подключать рекурсивно
     */

    public $recursive = false;

    /**
     * @var array html - атрибуты корневого тега ul меню
     */

    public $htmlOptions = array();

    /**
     * @var array Массив моделей элементов меню
     */

    protected $menuArr = array();


    public function init()
    {

        $this->level = $this->level + 1;

        if (empty($this->code))
            throw new AppException("Не задан символьный идентификатор включаемой области.");

        $root = $this->getRootMenu();

        if (is_object($root)) {

            $criteria = new CDbCriteria;

            $criteria->condition = 'root = :root AND level > :level_from AND level <= :level_to AND active = :active';

            $criteria->order = 'lft asc';

            $criteria->params = array(":root" => $root->id, ":level_from" => 1, ":level_to" => $this->level, ":active"=>1);

            $this->menuArr = Menu::model()->findAll($criteria);

        }
    }

    public function run()
    {

        if(empty($this->menuArr))
            return false;

        $params = array(
            "menuArr" => $this->menuArr,
            "htmlOptions" => $this->htmlOptions
        );

        if (!empty($this->tplPath))
            $this->render($this->tplPath, $params);
        else
            $this->render('menu', $params);

    }

    /**
     * Возвращает корневой объект меню
     * @return Menu|null
     * @throws AppException
     */

    protected function getRootMenu()
    {

        // Берем меню заданное по $code

        $default = Menu::model()->roots()->find("code = :code AND section_id = :section_id AND active = :active", array(":code" => $this->code, ":section_id" => 0, ":active" => 1));

        if (!$this->recursive) {

            return $default;

        } else { // Рекурсивный поиск меню

            $section = Yii::app()->params["section_object"]; // Объект категории

            if ($root = $this->hasMenu($this->code, $section->id))
                return $root;

            $descendants = $section->ancestors()->findAll();

            $descendants = array_reverse($descendants);

            foreach( $descendants AS $section ) {

                if ($root = $this->hasMenu($this->code, $section->id))
                    return $root;

            }

            return $default;

        }

    }

    /**
     * Возвращает массив корневых объектов меню
     * @return array
     */

    protected static function getMenus()
    {

        if (is_null(self::$menus)) {

            $menus = Menu::model()->roots()->findAll("active = :active", array(":active" => 1));

            self::$menus = array();

            foreach ($menus as $menu) {

                self::$menus[$menu->id] = $menu;
            }
        }

        return self::$menus;

    }

    /**
     * Проверяет существование меню для категории
     * @param string $code
     * @param integer $section_id
     * @return boolean|Menu
     */

    protected function hasMenu($code, $section_id)
    {

        $menus = self::getMenus();

        foreach ($menus AS $menu) {

            if ($menu->code == $code AND $menu->section_id == $section_id) {

                return $menu;
            }
        }


        return false;
    }

}