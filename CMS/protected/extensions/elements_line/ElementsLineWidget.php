<?php

/**
 * Class ElementsLineWidget виджет для вывода списка элементов
 */

class ElementsLineWidget extends CWidget {

    /**
     * @var string имя класса выводимых моделей
     */

    public $class;

    /**
     * @var integer идентификатор категории
     */

    public $sectionId;

    /**
     * @var mixed дополнительный критерий запроса
     */

    public $criteria;

    /**
     * @var integer количество выводимых элементов
     */
    
    public $limit = 3;

    /**
     * @var string сортировка моделей
     */

    public $order = "t.id desc";

    /**
     * @var array html - атрибуты корневого тега ul
     */

    public $htmlOptions = array();

    /**
     * @var string путь к шаблон
     */

    public $tpl = 'index';

    /**
     * @var array массив моделей
     */
    
    protected $models = array();

    protected $sectionUrl = "/";

    public function init() {

            if(!empty($this->sectionId))
                $this->sectionUrl = Yii::app()->createUrl('fronted/sections', array("id"=>$this->sectionId));


            $criteria = new CDBCriteria();

            $criteria->order = $this->order;

            $criteria->limit = $this->limit;

            if(!is_null($this->criteria))
                $criteria->mergeWith($this->criteria);

            $class = $this->class;

            $this->models = $class::model()->findAll($criteria);
    
    }

    /**
     * Запуск рендеринга
     */

    public function run() {

        if (empty($this->models))
            return;

        $this->render($this->tpl, array("models"=>$this->models, "htmlOptions"=>$this->htmlOptions, "sectionUrl"=>$this->sectionUrl));
    }
    
    
    
}



?>
