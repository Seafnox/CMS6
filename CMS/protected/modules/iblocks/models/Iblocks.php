<?php

/**
 * This is the model class for table "types".
 *
 * The followings are the available columns in table 'types':
 * @property integer $id
 * @property integer $type_id
 * @property string $title
 * @property string $code
 * @property string $controller
 * @property string $relations
 * @property string $tabs
 * @property string $active
 */
class Iblocks extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Type the static model class
     */

    const default_tab_code = "element";

    const table_preffix = "iblock";

    const model_preffix = "Iblock";

    /**
     * Возвращает имя таблицы
     * @param string $code
     * @return string
     */

    static public function getTableName($code)
    {

        return self::table_preffix . "_" . $code;

    }

    /**
     * Возвращает имя связующей с категориями таблицы
     * @param type $code
     * @return type
     */

    /* static public function getRelSectTableName($code) {

        return $code."_sections";

    }*/


    /**
     * Возвращает имя модели
     * @param string $code
     * @return string
     */

    static public function getModelName($code)
    {


        return self::model_preffix . ucfirst($code);

    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Возвращает массив HAS_MANY связей указанных для отображения в админке
     * @return array
     */

    public function getViewRelations()
    {

        $model_class = self::getModelName($this->code);

        $model = new $model_class;

        $arr = array();

        if (!empty($this->relations)) {

            $tmpArr = (array)json_decode($this->relations);

            $relations = $model->relations();

            foreach ($tmpArr AS $k => $v) {

                if (!isset($relations[$k]) OR $relations[$k][0] != self::HAS_MANY)
                    continue;

                $arr[] = array(

                    "label" => $v,
                    "name" => $k,
                    "model_class" => $relations[$k][1],
                    "model_attr" => $relations[$k][2]

                );


            }


        }

        return $arr;

    }


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'iblocks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, code, type_id', 'required'),
            array('title, code', 'length', 'max' => 255),
            array('type_id', 'numerical', 'integerOnly' => true),
            array('code', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'code', 'className' => 'Iblocks'),
            array('code', 'match', 'pattern' => '/^([a-z0-9_])+$/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('backend_controller, fronted_controller, fronted_action, relations, tabs, active', 'safe'),
            array('id, type_id, title, code, backend_controller, fronted_controller, fronted_action, relations, tabs', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'properties' => array(self::HAS_MANY, 'Iproperty', 'iblock_id', 'order' => 'sort desc'), // Связь со свойствами
            'type' => array(self::BELONGS_TO, 'Itypes', 'type_id'), // Связь с типами

        );
    }

    public function behaviors()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type_id' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'code' => Yii::t('app', 'Code'),
            'backend_controller' => Yii::t('app', 'Controller backend'),
            'fronted_controller' => Yii::t('app', 'Controller fronted'),
            'fronted_action' => Yii::t('app', 'Action fronted'),
            'relations' => Yii::t('app', 'View has many relations'),
            'tabs' => Yii::t('app', 'Tabs'),
            'active' => Yii::t('app', 'Active'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('backend_controller', $this->backend_controller, true);
        $criteria->compare('fronted_controller', $this->fronted_controller, true);
        $criteria->compare('fronted_action', $this->fronted_action, true);
        $criteria->compare('relations', $this->relations, true);
        $criteria->compare('tabs', $this->tabs, true);
        $criteria->compare('active', $this->active);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Возвращает массив вкладок инфоблока
     * @return array
     */

    public function getTabs()
    {

        $tabs = array(

            self::default_tab_code => Yii::t('app', 'Element')

        );


        if (!empty($this->tabs)) {

            $userTabs = (array)json_decode($this->tabs);

            $tabs = array_merge($tabs, $userTabs);

        }


        return $tabs;


    }

    /**
     * Возвращает массив свойств для отображения на вкладке
     * @param $tab символьный код вкладки
     * @return array
     */

    public function getPropsByTab($tab)
    {

        $arr = array();

        $props = $this->properties;


        foreach ($props AS $prop) {

            if ($prop->tab == $tab)
                $arr[] = $prop;

        }

        return $arr;

    }

    protected function afterSave()
    {

        if ($this->isNewRecord) {


            $connection = Yii::app()->db;

            // Создаем таблицу под новый тип данных

            $sql = "CREATE TABLE `" . self::getTableName($this->code) . "` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `author_id` int(11) NOT NULL,
                         `mtime` DATETIME NOT NULL,
                         `active` tinyint(1) NOT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

            $command = $connection->createCommand($sql);

            $command->execute();


        }


        // Прописываем разрешения для существующих ролей


        $roles = Yii::app()->authManager->getPermRoles();


        $modelClass = self::getModelName($this->code);

        foreach($roles AS $role) {


            $count = Permission::model()->count("model = :model AND role = :role", array(":model"=>$modelClass, ":role"=>$role->getName()));

            if($count == 0) {

                $perm = new Permission();

                $perm->role = $role->getName();

                $perm->model = $modelClass;

                $perm->save();

            }

        }


        return parent::afterSave();
    }


    protected function beforeDelete()
    {


        $connection = Yii::app()->db;


        $props = $this->getRelated("properties");

        // Удаляем свойства

        foreach ($props AS $prop) {

            $prop->delete();


        }

        // Удаляем таблицу типа данных

        $sql = "DROP TABLE IF EXISTS `" . self::getTableName($this->code) . "`";

        $command = $connection->createCommand($sql);

        $command->execute();


        // Удаляем разрешения


        $perms = Permission::model()->findAll("model = :model", array(":model" => self::getModelName($this->code)));

        foreach ($perms AS $perm) {

            $perm->delete();

        }


        return parent::beforeDelete();
    }


    public static function getFilesArr($path)
    {

        $files = CFileHelper::findFiles($path);

        $data = array();

        foreach ($files AS $file) {

            $val = basename($file);

            $val = substr($val, 0, strrpos($val, "."));

            $data[$val] = $val;

        }

        return $data;

    }

    public static function getAdminControllers()
    {

        return self::getFilesArr(Yiibase::getPathOfAlias('application.modules.iblocks.modules.admin.controllers'));

    }


}