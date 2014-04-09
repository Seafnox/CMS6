<?php

/**
 * This is the model class for table "properties".
 *
 * The followings are the available columns in table 'properties':
 * @property integer $id
 * @property integer $iblock_id
 * @property string $title
 * @property string $name
 * @property string $field
 * @property string $data_code
 * @property string $list_code
 * @property string $view_code
 * @property integer $show_in_list
 * @property integer $show_in_view
 * @property integer $show_filter
 * @property integer $editable
 * @property string $type
 * @property integer $required
 * @property string $relation
 * @property string $relation_name
 * @property string $relation_model
 * @property string $tab
 *
 */
class Iproperty extends CActiveRecord
{

    /**
     * @var string предыдущее значение типа поля
     */

    protected $_type;


    /**
     * @var string предыдущее значение имени поля
     */

    protected $_name;


    /**
     * Массив типов полей
     * @var array
     */

    public static $fieldTypesList = array(
        'TINYINT' => 'TINYINT',
        'INT' => 'INT',
        'BIGINT' => 'BIGINT',
        'TINYTEXT' => 'TINYTEXT',
        'TEXT' => 'TEXT',
        'LONGTEXT' => 'LONGTEXT',
        'VARCHAR(1)' => 'VARCHAR(1)',
        'VARCHAR(16)' => 'VARCHAR(16)',
        'VARCHAR(32)' => 'VARCHAR(32)',
        'VARCHAR(64)' => 'VARCHAR(64)',
        'VARCHAR(128)' => 'VARCHAR(128)',
        'VARCHAR(255)' => 'VARCHAR(255)',
        'DOUBLE' => 'DOUBLE',
        'DATE' => 'DATE',
        'DATETIME' => 'DATETIME',
        'TIMESTAMP' => 'TIMESTAMP',
        'DECIMAL(12,2)' => 'DECIMAL(12,2)',
        'DECIMAL(6,2)' => 'DECIMAL(6,2)',
    );


    /**
     * Связи ассоциированные со свойствами
     * @var array
     */

    public static $relationsList = array(

        "BELONGS_TO" => "Принадлежность (BELONGS_TO)",
        "MANY_MANY" => "Многие ко многим (MANY_MANY)"
    );

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {
        return array(
            'sort' => array(
                'class' => 'SortBehavior',
            ),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Property the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'iproperty';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('iblock_id, title, field, tab', 'required'),
            array('name', 'nameValid'),
            array('relation_name', 'relationNameValid'),
            array('relation_model', 'relationModelValid'),
            array('type', 'typeValid'),
            array('name, relation_name', 'match', 'pattern' => '/^([a-z0-9_])+$/'),
            array('iblock_id, show_in_list, show_in_view, show_filter, editable, required', 'numerical', 'integerOnly' => true),
            array('title, name', 'length', 'max' => 255),
            array('field, relation_name, relation_model', 'length', 'max' => 64),
            array('type, relation, tab', 'length', 'max' => 32),
            array('data_code, list_code, view_code', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, iblock_id, title, name, field, type, sort, data_code, list_code, show_in_list, show_filter, show_sort, editable, relation, relation_name, relation_model, tab', 'safe', 'on' => 'search'),
        );
    }


    public function nameValid($attribute, $params = array())
    {

        if($this->relation == "MANY_MANY") {

            return;

        }

        $id = !empty($this->id) ? $this->id : 0;

        $params['allowEmpty'] = true;
        $params['caseSensitive'] = false;
        $params['attributeName'] = $attribute;
        $params['className'] = get_class($this);
        $params['criteria'] = array(
            'condition' => 'iblock_id=:iblock_id AND id != :id',
            'params' => array(':iblock_id' => $this->iblock_id, ':id' => $id),
        );

        $validator = CValidator::createValidator('unique', $this, $attribute, $params); // Проверка на уникальность
        $validator->validate($this, array($attribute));

        $validator = CValidator::createValidator('required', $this, $attribute); // Проверка на заполненность
        $validator->validate($this, array($attribute));


    }


    public function relationNameValid($attribute, $params = array())
    {

        if(empty($this->relation)) // Валидируем только в случае установки связи
            return;

        $id = !empty($this->id) ? $this->id : 0;

        $params['allowEmpty'] = true;
        $params['caseSensitive'] = false;
        $params['attributeName'] = $attribute;
        $params['className'] = get_class($this);
        $params['criteria'] = array(
            'condition' => 'iblock_id=:iblock_id AND id != :id',
            'params' => array(':iblock_id' => $this->iblock_id, ':id' => $id),
        );

        $validator = CValidator::createValidator('unique', $this, $attribute, $params); // Проверка на уникальность
        $validator->validate($this, array($attribute));

        $validator = CValidator::createValidator('required', $this, $attribute); // Проверка на заполненность
        $validator->validate($this, array($attribute));

    }


    public function relationModelValid($attribute, $params = array())
    {


        if(empty($this->relation)) // Валидируем только в случае установки связи
            return;


        if(!empty($this->$attribute) AND @!class_exists($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'Class {cls} not exists', array("{cls}"=>$this->$attribute)));
        }

        $validator = CValidator::createValidator('required', $this, $attribute); // Проверка на заполненность
        $validator->validate($this, array($attribute));

    }

    public function typeValid($attribute, $params = array())
    {


        if($this->relation == "MANY_MANY") {

            return;

        }


        $validator = CValidator::createValidator('required', $this, $attribute); // Проверка на заполненность
        $validator->validate($this, array($attribute));

    }

    public function isAttributeRequired($attribute) {

        $arr = array("name", "relation_name", "relation_model", "type");

        if(in_array($attribute, $arr))
            return true;


        return parent::isAttributeRequired($attribute);

    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'iblock' => array(self::BELONGS_TO, 'Iblocks', 'iblock_id'), // Связь с типами данных
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'iblock_id' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Field name'),
            'field' => Yii::t('app', 'Field'),
            'data_code' => Yii::t('app', 'Data code'),
            'list_code' => Yii::t('app', 'List code'),
            'view_code' => Yii::t('app', 'View code'),
            'show_in_list' => Yii::t('app', 'Show in list'),
            'show_in_view' => Yii::t('app', 'Show in view'),
            'show_filter' => Yii::t('app', 'Show in filter'),
            'editable' => Yii::t('app', 'Editable in grid'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'required' => Yii::t('app', 'Required'),
            'relation' => Yii::t('app', 'Relation'),
            'relation_name' => Yii::t('app', 'Relation name'),
            'relation_model' => Yii::t('app', 'Relation model'),
            'tab' => Yii::t('app', 'Tab'),

        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.iblock_id', $this->iblock_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.field', $this->field, true);
        $criteria->compare('t.data_code', $this->data_code, true);
        $criteria->compare('t.list_code', $this->list_code, true);
        $criteria->compare('t.view_code', $this->view_code, true);
        $criteria->compare('t.show_in_list', $this->show_in_list);
        $criteria->compare('t.show_in_view', $this->show_in_view);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.required', $this->required);
        $criteria->compare('t.relation', $this->relation);
        $criteria->compare('t.relation_name', $this->relation_name);
        $criteria->compare('t.relation_model', $this->relation_model);
        $criteria->compare('t.tab', $this->tab);

        $dataProvider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,

        ));

        $sort = $dataProvider->getSort();

        $sort->defaultOrder = array(
            'sort'=>CSort::SORT_DESC,
        );

        return $dataProvider;
    }


    /**
     * Поиск моделей
     * @return array массив моделей
     */

    public function searchModels()
    {
        $dataProvider = $this->search();

        $dataProvider->setPagination(false);

        return $dataProvider->getData();

    }


    /**
     * Определяет является ли свойство текстовым
     * @return bool
     */

    public function isText()
    {

        if(preg_match("/(TEXT|CHAR)+/i", $this->type)) {

            return true;

        }

        return false;

    }

    /**
     * Определяет является ли свойство полем ввода файла
     * @return bool
     */

    public function isFile() {


        if(preg_match("/(fileRow)+/i", $this->field)) {

            return true;

        }

        return false;


    }


    /**
     * Возвращает имя таблицы связи многие ко многим
     * @param string $modelsNameFrom имя исходной модели
     * @param string $modelNameTo имя связанной модели
     * @param string $relationName имя связи
     * @return string
     */

    public static function getMtmRelTableName($modelsNameFrom, $modelNameTo, $relationName) {

        return strtolower($modelsNameFrom)."_".strtolower($relationName)."_".strtolower($modelNameTo);

    }

    /**
     * Возвращает имя поля в таблице связи многин ко многим для модели
     * @param string $modelName имя модели
     * @return string
     */

    public static function getMtmRelFieldName($modelName) {

        return strtolower($modelName)."_id";

    }

    protected function beforeSave()
    {

        $connection = Yii::app()->db;

        $iblockCode = $this->getRelated('iblock')->code;

        $iblockTableName = Iblocks::getTableName($iblockCode);

        if ($this->isNewRecord) {

            if($this->relation != "MANY_MANY") { // Добавляем поле в таблицу

                $command = $connection->createCommand();

                $command->addColumn($iblockTableName, $this->name, $this->type);

            } else { // Добавляем таблицу связи многие ко многим

                $relationModelName = $this->relation_model;

                $iblockModelName = Iblocks::getModelName($iblockCode);

                $fieldFrom = self::getMtmRelFieldName($iblockModelName);

                $fieldTo = self::getMtmRelFieldName($relationModelName);

                $relationTable = $relationModelName::model()->tableName();

                $sql = "CREATE TABLE `".self::getMtmRelTableName($iblockModelName, $this->relation_model, $this->relation_name)."` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `".$fieldFrom."` int(11) NOT NULL,
                         `".$fieldTo."` int(11) NOT NULL,
                          PRIMARY KEY (`id`),
                          KEY `".$fieldFrom."` (`".$fieldFrom."`),
                          KEY `".$fieldTo."` (`".$fieldTo."`),
                          FOREIGN KEY (".$fieldFrom.") REFERENCES ".$iblockTableName."(id) ON UPDATE RESTRICT ON DELETE CASCADE,
                          FOREIGN KEY (".$fieldTo.") REFERENCES ".$relationTable."(id) ON UPDATE RESTRICT ON DELETE CASCADE
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

                $command=$connection->createCommand($sql);

                $command->execute();

            }

        } elseif ($this->relation != "MANY_MANY") { // Изменился тип поля при редактировании


            if($this->_name != $this->name) {

                $command = $connection->createCommand();

                $command->renameColumn($iblockTableName, $this->_name, $this->name);
            }


            if($this->_type != $this->type) {

                $command = $connection->createCommand();

                $command->alterColumn($iblockTableName, $this->name, $this->type);
            }

        }

        return parent::beforeSave();
    }


    protected function beforeDelete()
    {

        $connection = Yii::app()->db;

        $iblockCode = $this->getRelated('iblock')->code;

        $iblockTable = Iblocks::getTableName($iblockCode);

        if($this->relation != "MANY_MANY") { // Удаляем поле из таблицы

            $sql = "ALTER TABLE `$iblockTable` DROP COLUMN " . $this->name; // Удаление колонки из таблицы

            $command = $connection->createCommand($sql);

            $command->execute();

        } else { // Удаляем таблицу связи многие ко многим

            $relationModelName = $this->relation_model;

            $iblockModelName = Iblocks::getModelName($iblockCode);

            $sql = "DROP TABLE IF EXISTS `".self::getMtmRelTableName($iblockModelName, $relationModelName, $this->relation_name)."`";

            $command=$connection->createCommand($sql);

            $command->execute();


        }

        return parent::beforeDelete();
    }

    protected function afterFind() {

        $this->_type = $this->type;

        $this->_name = $this->name;

        return parent::afterFind();

    }


}