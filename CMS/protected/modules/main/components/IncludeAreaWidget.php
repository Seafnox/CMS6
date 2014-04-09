<?php

/**
 * Виджет для отображения включаемых областей 
 */
class IncludeAreaWidget extends CWidget {
    /**
     * Без условия 
     */

    const COND_NO = 0;

    /**
     * Проверка по url 
     */
    const COND_URL = 1;

    /**
     * Проверка по php выражению
     */
    const COND_PHP = 2;

    /**
     * Проверка по привязанной категории 
     */
    const COND_SECT = 3;

    /**
     * Массив вариантов условий
     * @var array 
     */
    static public $cond_types = array(self::COND_NO => "Без условия", self::COND_URL => "URL адрес", self::COND_PHP => "Выражение PHP", self::COND_SECT => "Привязка к категориям");

    /**
     * Рекурсивное подключение областию при привязке к категориям
     * @var boolen 
     */
    public $recursive = false;

    /**
     * Условие
     * @var string 
     */
    public $cond;

    /**
     * Тип условия для подключения включаемой области
     * @var integer 
     */
    public $cond_type = self::COND_NO;

    /**
     * Символьный идентификатор включаемой области.
     * @var integer 
     */
    public $code;

    /**
     * Массив включаемых областей
     * @var array 
     */
    protected static $include_areas = null;

    /**
     * Объект включаемой области
     * @var IncludeArea 
     */
    protected $area;

    /**
     * Путь до папки содеожащей включаемые области
     * @var type 
     */
    public $include_areas_folder = "application.views.include_areas";

    /**
     * Инициализация виджета
     * @throws AppException 
     */
    
    public function init() {

        if (empty($this->code))
            throw new AppException("Не задан идентификатор включаемой области.");


        $this->area = $this->locateArea();

    }

    /**
     * Запуск рендеринга
     * @return boolean 
     */
    
    public function run() {

        if (!$this->area)
            return false; // Данный виджет не отображать   

        $this->render($this->include_areas_folder . "." . $this->area->code . "-" . $this->area->id);
    }

    /**
     * Возвращает список включаемых областей
     * @return array
     */
    protected function getAreas() {

        if (is_null(self::$include_areas)) {

            $areas = IncludeArea::model()->findAll();

            self::$include_areas = array();

            foreach ($areas as $area) {

                self::$include_areas[$area->id] = $area;
            }
        }

        return self::$include_areas;

    }

    /**
     * Поиск нужной вклучаемой области
     * @return IncludeArea|boolen
     */
    protected function locateArea() {



        switch ($this->cond_type) {

            case 1: // Совпадение по URL

                $request = Yii::app()->getRequest();

                $url = $request->getUrl();

                $cond_arr = explode(",", $this->cond);
                
                foreach($cond_arr AS $cond) {
                
                $cond = trim($cond);    
                    
                $pattern = "!^" . str_replace("*", ".*?", $cond) . "$!i";


                if (preg_match($pattern, $url))

                   return $this->getArea($this->code, 0);

                }
                
                 return false;
                
                break;

            case 2: // PHP выражение

                $test = eval($this->cond);

                if ($test) {
                    return $this->getArea($this->code, 0);
                } else {
                    return false;
                }

                break;

            case 3: // Проверка по привязке к категории

                $section = Yii::app()->params["section_object"]; // Объект категории

                if (!$this->recursive) {

                    return $this->getArea($this->code, $section->id);

                } else { // Рекурсивный поиск меню

                    if ($area = $this->getArea($this->code, $section->id))
                        return $area;

                    $descendants = $section->ancestors()->findAll();

                    $descendants = array_reverse($descendants);

                    foreach( $descendants AS $section ) {

                        if ($area = $this->getArea($this->code, $section->id))
                            return $area;

                    }

                    if ($area = $this->getArea($this->code, 0))
                        return $area;


                }

                return false;

                break;

            default: {
                return $this->area = $this->getArea($this->code, 0);
            }
        }

    }

    /**
     * Возвращает включаемую область для категории
     * @param string $code символьный идентификатор области
     * @param integer $section_id идентивикатор категории
     * @return IncludeArea|boolean
     */
    protected function getArea($code, $section_id) {

        $areas = $this->getAreas();

        foreach ($areas AS $area) {

            if ($area->code == $code AND $area->section_id == $section_id) {

                return $area;
            }
        }


        return false;
    }

}

?>
