<?php
/**
 * This is the model class for table "sections".
 *
 * The followings are the available columns in table 'sections':
 * @property integer $id
 * @property string $title
 * @property string $metatitle
 * @property string $keywords
 * @property string $description
 * @property string $code
 * @property string $image
 * @property string $text
 * @property integer $author_id
 * @property string $controller
 * @property string $action
 * @property integer $active
 */
class Section extends CActiveRecord
{

    public $parent_id = 0;

    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array(

            'UploadableFileBehavior' => array(
                'class' => 'ext.UploadableFileBehavior',
                'attributeName' => 'image',
            ),

            'nestedSetBehavior' => array(
                'class' => 'application.components.NestedSetBehavior',
                'hasManyRoots' => true,
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
                'rootAttribute' => 'root'
            ),

            'permission'=>array(
                'class'=>'application.modules.main.components.PermissionBehavior',
            ),

        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Section the static model class
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
        return 'sections';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, code, author_id', 'required', 'on' => 'insert, update'),
            array('author_id', 'numerical', 'integerOnly' => true),
            array('code', 'uniqueCode'),
            // array('code', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'code', 'className' => 'Section', 'criteria' => array('condition' => "parent_id = :parent_id", 'params' => array(':parent_id' => $this->parent_id))),
            array('code', 'match', 'pattern' => '/^([a-z0-9_-])+$/'),
            array('code', 'match', 'pattern' => '/^(?!data-).*$/'),
            array('title, code, image', 'length', 'max' => 255),
            array('controller, action', 'length', 'max' => 128),
            array('metatitle, keywords, description', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, code, image, text, author_id, controller, action,active', 'safe'),
        );
    }

    /**
     * Валидатор символьного кода code
     * @param string $attribute
     * @param array $params
     */
    public function uniqueCode($attribute, $params = array())
    {

        $id = !empty($this->id) ? $this->id : 0;


        $params['allowEmpty'] = false;
        $params['caseSensitive'] = false;
        $params['attributeName'] = $attribute;
        $params['className'] = get_class($this);

        if ($this->parent_id == 0) {

            $params['criteria'] = array(
                'condition' => 'level=:level AND id != :id',
                'params' => array(':level' => 1, ':id' => $id),
            );

        } else {

            $parentModel = $this->findByPk($this->parent_id);

            $params['criteria'] = array(
                'condition' => 'level=:level AND id != :id AND lft > :lft AND rgt < :rgt AND root = :root',
                'params' => array(':level' => $parentModel->level + 1, ':id' => $id, ':lft' => $parentModel->lft, ':rgt' => $parentModel->rgt, 'root' => $parentModel->root),
            );

        }

        $validator = CValidator::createValidator('unique', $this, $attribute, $params);
        $validator->validate($this, array($attribute));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'), // Связь с пользователями
           );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'metatitle' => Yii::t('app', 'Meta title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'code' => Yii::t('app', 'Code'),
            'image' => Yii::t('app', 'Image'),
            'text' => Yii::t('app', 'Text'),
            'author_id' => Yii::t('app', 'Author'),
            'controller' => Yii::t('app', 'Controller'),
            'action' => Yii::t('app', 'Action'),
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

        $criteria = $this->getDbCriteria();

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.path', $this->path, true);
        $criteria->compare('t.image', $this->image, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.author_id', $this->author_id);
        $criteria->compare('t.controller', $this->controller, true);
        $criteria->compare('t.action', $this->action, true);
        $criteria->compare('t.active', $this->active);

        $criteria->with = 'author';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array("pageSize" => 20)
        ));
    }


    /**
     * Поиск категории по url
     * @param string $url
     * @return boolean, Section
     */
    static public function findSectionByUrl($url)
    {


        $arr = explode("/", trim($url, "/"));

        $parent_id = 0;

        foreach ($arr As $code) {

            $section = self::model()->find("code = :code AND parent_id = :parent_id", array(":code" => $code, ":parent_id" => $parent_id));

            if (!$section)
                return false;

            $parent_id = $section->id;
        }

        return $section;
    }

    /**
     * Возвращает url - адрес категории
     * @return string
     */

    public function getUrl()
    {

        return "/" . implode("/", $this->getUrlArr()) . "/";

    }


    /**
     * Формирует массив секций url адреса категории
     * @return array
     */
    public function getUrlArr()
    {

        $models = $this->ancestors()->findAll();

        $arr = array();

        foreach ($models AS $model)
            $arr[] = $model->code;

        $arr[] = $this->code;

        return $arr;
    }

    /**
     * Возвращает имя контроллера привязанного к категории
     * @return null|string
     */

    public function getControllerName()
    {

        if (empty($this->controller))
            return null;

        return str_replace("controller", "", strtolower($this->controller));

    }

    /**
     * Возвращает имя действия привязанного к категории
     * @return null|string
     */

    public function getActionName()
    {

        if (empty($this->action))
            return null;

        return str_replace("action", "", strtolower($this->action));

    }

    /**
     * Формирует иерархическое дерево категорий для списочного поля. Возвращает массив ключи которого идентификаторы категорий, значения названия
     * @param integer $parent_id идентификатор родительской категории
     * @param array $ids_arr массив id которые не должны быть включены в список
     * @return array
     */

    static public function getListData($parent_id = 0, $ids_arr = array())
    {

        if (!empty($parent_id)) {

            $node = self::model()->findByPk($parent_id);

            if ($node)
                $models = $node->descendants()->findAll();

        } else {

            $criteria = new CDbCriteria;

            $criteria->order = 't.root, t.lft asc';

            $models = self::model()->findAll($criteria);

        }

        if (empty($models))
            return array();

        $sectionsList = array();

        $excluded = array(); // Массив исключенных моделей

        foreach ($models AS $model) {


            if (!empty($ids_arr)) {

                if (in_array($model->id, $ids_arr)) {
                    $excluded[] = $model;
                    continue;
                }

                foreach ($excluded AS $ex) {

                    if ($model->isDescendantOf($ex))
                        continue 2;


                }

            }

            $sectionsList[$model->id] = str_repeat("-", $model->level) . $model->title;

        }


        return $sectionsList;
    }

    /**
     * Возвращает массив для формирования хлебных крошек категорий
     * @param int $parent_id
     * @param string $route
     * @return array
     */
    public function getBredCrumbsArr($parent_id, $route)
    {

        if (empty($parent_id))
            return array();

        $model = self::model()->findByPk($parent_id);

        $descendants = $model->ancestors()->findAll();

        $arr = array();

        foreach ($descendants AS $parent) {

            $arr[$parent->title] = Yii::app()->getUrlManager()->createUrl($route, array("parent_id" => $parent->id));

        }

        $arr[$model->title] = Yii::app()->getUrlManager()->createUrl($route, array("parent_id" => $model->id));

        return $arr;
    }


    public function afterSave()
    {

        return parent::afterSave();
    }


}