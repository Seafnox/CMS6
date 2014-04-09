<?php

/**
 * Class SphinxDataProvider провайдер данных поискового сервера Sphinx
 */

class SphinxDataProvider implements IDataProvider {

    /**
     * @var array массив индексов в которых производить поиск
     */

    public $indexes = array();

    /**
     * @var string строка выбираемых полей
     */

    public $select = "id";

    /**
     * @var string поисковая фраза
     */

    public $query;

    /**
     * @var array массив фильтров array("имя атрибута"=>"значение")
     */

    public $filters = array();

    /**
     * @var array массив сортировок array("имя поля"=>"значение")
     */

    public $order = array();

    /**
     * @var array массив опция array("имя опции"=>"значение")
     */

    public $option = array();

    /**
     * @var string группировка
     */

    public $group;

    /**
     * @var string имя компонента предоставляющего соединение с поисковым сервером
     */

    public $connection = "sphinx";

    /**
     * @var int минимальная длина поискового слова
     */

    public $minlen = 3;

    protected $_classname;

    protected $_pages;

    protected  $_sDb;

    protected $_count;

    protected $_result;

    protected $_data;

    protected $_keys;

    /**
     * Конструктор
     * @param $classname имя класса модели
     * @param $params параметры
     */

    public function __construct($classname, $params) {


        $this->_classname = $classname;

        foreach($params AS $k => $v)
            $this->$k = $v;

        $this->_sDb  =Yii::app()->{$this->connection};


        $this->_pages =  new CPagination();

    }


    /**
     * @return string the unique ID that identifies the data provider from other data providers.
     */
    public function getId() {

        return spl_object_hash($this);

    }
    /**
     * Returns the number of data items in the current page.
     * This is equivalent to <code>count($provider->getData())</code>.
     * When {@link pagination} is set false, this returns the same value as {@link totalItemCount}.
     * @param boolean $refresh whether the number of data items should be re-calculated.
     * @return integer the number of data items in the current page.
     */
    public function getItemCount($refresh=false) {

        return count($this->getResult($refresh));

    }
    /**
     * Returns the total number of data items.
     * When {@link pagination} is set false, this returns the same value as {@link itemCount}.
     * @param boolean $refresh whether the total number of data items should be re-calculated.
     * @return integer total number of possible data items.
     */
    public function getTotalItemCount($refresh=false) {

        if($this->_count !== null AND !$refresh)
            return $this->_count;

        $sql = $this->buildQuery($refresh);

        $this->_sDb->createCommand($sql)->query();

        $meta = $this->_sDb->createCommand("SHOW META")->queryAll();

        $this->_count = $meta[0]['Value'];

        return $this->_count;

    }
    /**
     * Returns the data items currently available.
     * @param boolean $refresh whether the data should be re-fetched from persistent storage.
     * @return array the list of data items currently available in this data provider.
     */
    public function getData($refresh=false) {

        if($this->_data !== null AND !$refresh)
            return $this->_data;

        $result = $this->getResult($refresh);

        $ids = array();

        foreach($result AS $res) {

            if(!isset($res['id']))
                throw new Exception("Отсутствует свойство");

            $ids[] = $res['id'];

        }

        $this->_keys = $ids;

        if(!empty($ids)) {

            $criteria = new CDbCriteria;

            $criteria->compare("id", $ids);

            $criteria->order ="FIELD(id,".implode(",", $ids).")";

            $classname = $this->_classname;

            if(!class_exists($classname))
                throw new Exception("Класс $classname не существует!");

            $this->_data = $classname::model()->findAll($criteria);

        } else {
            $this->_data = array();
        }

        return  $this->_data;

    }
    /**
     * Returns the key values associated with the data items.
     * @param boolean $refresh whether the keys should be re-calculated.
     * @return array the list of key values corresponding to {@link data}. Each data item in {@link data}
     * is uniquely identified by the corresponding key value in this array.
     */
    public function getKeys($refresh=false) {

        if($this->_keys !== null AND !$refresh)
            return $this->_keys;

        $this->getData($refresh);

        return $this->_keys;

    }
    /**
     * @return CSort the sorting object. If this is false, it means the sorting is disabled.
     */
    public function getSort() {

        // не используем сортировку

        return false;

    }


    /**
     * @return CPagination the pagination object. If this is false, it means the pagination is disabled.
     */
    public function getPagination() {

        return $this->_pages;

    }

    /**
     * @param bool $refresh перезагружать ли данные
     * @return array
     */

    public function getResult($refresh=false) {

        if($this->_result !== null AND !$refresh)
            return $this->_result;

        $count = $this->getTotalItemCount($refresh);

        $this->_pages->itemCount = $count;

        if($count > 0) {

            $sSql = $this->buildQuery();

            $result = $this->_sDb->createCommand($sSql)->queryAll();

            return $result;

        } else {
            return array();
        }

    }

    /**
     * Построение запроса для сфинкса
     * @param bool $count запрос на количество записей
     * @return string
     * @throws Exception
     */

    protected function buildQuery($count = false) {

        $fields = $count?1:$this->select;

        if(empty($this->indexes) OR !is_array($this->indexes))
            throw new Exception("Не выбраны поисковые индексы");

        $indexes = implode(", ", $this->indexes);

        $query = "SELECT $fields FROM $indexes";

        if($cond = $this->getCond())
            $query .= " WHERE ".$cond;

        if(!empty($this->group))
            $query .= " GROUP BY ".$this->group;

        if($order = $this->getOrder())
            $query .= " ORDER BY ".$order;

        if(!$count) {
            $query .= " LIMIT {$this->_pages->getOffset()}, {$this->_pages->getLimit()}";
        }

        if($option = $this->getOption())
            $query .= " OPTION ".$option;


        return $query;

    }


    /**
     * Преобразование поисковой фразы в поисковое выражение
     * @param string $term поисковая фраза
     * @return string
     */

    protected function processTerm($term) {

        $term = trim($term);

        $termArr = explode(" ", $term);

        foreach($termArr AS $k => $word) {

            if(strlen($word) < $this->minlen)
                unset($termArr[$k]);
        }

        $termStr = implode("|", $termArr);

        return $termStr;

    }

    /**
     * Возвращает условие where
     * @return string
     */

    protected function getCond() {

        $whereArr = array();

        if(!empty($this->query))
            $whereArr[] = "MATCH(" . $this->_sDb->quoteValue($this->processTerm($this->query)) . ")";

        foreach($this->filters AS $k => $v) {

            if(is_array($v))
                $whereArr[] = "$k IN (".implode(",", $v).")";
            else
                $whereArr[] = "$k = $v";

        }

        return implode(" AND ", $whereArr);

    }

    /**
     * Возвращает сортировку order
     * @return string
     */

    protected function getOrder() {

        $orderArr = array();

        foreach($this->order AS $k =>$v)
            $orderArr[] = "$k $v";

        return implode(", ", $orderArr);

    }

    /**
     * Возвращает настройки option
     * @return string
     */

    protected function getOption() {

        $optionArr = array();

        foreach($this->option AS $k =>$v)
            $optionArr[] = "$k = $v";

        return implode(", ", $optionArr);

    }







}


?>