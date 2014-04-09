<?php

/**
 * Компонент поиска использующий Zend Lucene
 */
class SearchLucene extends CComponent
{

    protected $indexFiles = 'runtime.search';
    protected $stopWordsDir = 'application.data';
    protected $limit = 1000;
    protected $index;

    /**
     * Возвращает системный идентификатор записи, состоящий из имени класса модели и идентификатора записи
     * @param CActiveRecord $model
     * @return string
     */

    public static function getSid($model)
    {

        return get_class($model) . "-" . $model->id;
    }

    /**
     * Инициализация индекса
     * @param string $type открытие или создание индекса ( open или create )
     */
    public function __construct($type = 'open')
    {
//инициализация Zend Lucene  

        Yii::import('application.vendors.*'); // Подключаем поиск от Zend
        require_once('Zend/Search/Lucene.php');
        require_once('Zend/Search/Lucene/Analysis/TokenFilter/StopWords.php');

//изначально Zend Lucene не настроена на работу с UTF-8
//поэтому надо изменить используемый по умолчанию анализатор
//в данном случае используется анализатор для UTF-8 нечувствительный к регистру

        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();

//инициализируем фильтр стоп-слов

        $stopWordsFilter = new Zend_Search_Lucene_Analysis_TokenFilter_StopWords();
        $stopWordsFilter->loadFromFile(Yiibase::getPathOfAlias($this->stopWordsDir) . '/stop-words.dat');
        $analyzer->addFilter($stopWordsFilter);

//инициализируем морфологический фильтр

        $analyzer->addFilter(new SearchFilterMorph());

        Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);

//устанавливаем ограничение на количество записей в результате поиска
        Zend_Search_Lucene::setResultSetLimit($this->limit);

        $index_dir = Yii::getPathOfAlias('application.' . $this->indexFiles);


        $this->index = Zend_Search_Lucene::$type($index_dir);
    }

    /**
     * Возвращает объект индеса
     * @return type
     */
    public function getIndex()
    {

        return $this->index;
    }

    /**
     * Добаление записи в индекс
     * @param string $title
     * @param string $link
     * @param string $content
     */
    public function add($sid, $id, $title, $link, $content, $params = array())
    {

        $doc = new Zend_Search_Lucene_Document();

        $doc->addField(Zend_Search_Lucene_Field::Keyword('sid', $sid, 'UTF-8'));

        $doc->addField(Zend_Search_Lucene_Field::Keyword('id', $id, 'UTF-8'));

        $doc->addField(Zend_Search_Lucene_Field::Text('title', CHtml::encode($title), 'UTF-8'));

        $doc->addField(Zend_Search_Lucene_Field::Text('link', $link, 'UTF-8'));

        foreach ($params AS $k => $v) {

            $doc->addField(Zend_Search_Lucene_Field::Text($k, $v, 'UTF-8'));

        }

        $content = strip_tags($content);

        $doc->addField(Zend_Search_Lucene_Field::Text('content', $content, 'UTF-8'));

        $this->index->addDocument($doc);
    }

    /**
     * Удаляет запись из индекса
     * @param string $sid идентификатор записи возвращаемый методом SearchLucene::getSid($model)
     */
    public function delete($sid)
    {


        $hits = $this->index->find('sid:' . $sid);

        foreach ($hits as $hit) {

            $this->index->delete($hit->id);

        }


    }


    /**
     * Поиск
     * @param string $term
     * @return array
     */
    public function find($term)
    {

        if (empty($term)) return array();

        $cache_id = "search_" . md5($term);

        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');

        $query = Zend_Search_Lucene_Search_QueryParser::parse($term);

        $results = Yii::app()->cache->get($cache_id); // Попытка получения из кэша

        if (empty($results)) {

            $hits = $this->index->find($term);

            $results = array();

            foreach ($hits AS $hit) {

                $results[] = array(
                    "id" => $hit->id,
                    "sid" => $hit->sid,
                    "title" => $hit->title,
                    "link" => $hit->link,
                    "content" => $query->htmlFragmentHighlightMatches($hit->content)

                );

            }

            Yii::app()->cache->set($cache_id, $results, 600); // Пишем в кэш

        }

        return $results;

    }

    /**
     * Деструктор
     */
    public function __destruct()
    {

        $this->index->optimize();

        $this->index->commit();

    }


}

?>
