<?php

/**
 * This is the model class for table "include_areas".
 *
 * The followings are the available columns in table 'include_areas':
 * @property integer $id
 * @property integer $section_id
 * @property string $title
 * @property string $code
 */
class IncludeArea extends CActiveRecord
{
    /**
     * PHP код включаемой области
     * @var string
     */

    public $tpl;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return IncludeArea the static model class
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
        return 'include_areas';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, code', 'required'),
            array('section_id', 'numerical', 'integerOnly' => true),
            array('title, code', 'length', 'max' => 128),
            array('code', 'match', 'pattern' => '/^([a-z0-9_])+$/'),
            array('code', 'uniqueCode',),
            //array('code', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'code', 'className' => 'IncludeArea'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tpl', 'safe'),
            array('id, section_id, title, code', 'safe', 'on' => 'search'),
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
        $params['attributeName'] = 'code';
        $params['className'] = 'IncludeArea';
        $params['criteria'] = array(
            'condition' => 'section_id=:section_id AND id != :id',
            'params' => array(':section_id' => $this->section_id, ':id' => $id),
        );
        $validator = CValidator::createValidator('unique', $this, $attribute, $params);
        $validator->validate($this, array($attribute));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(

            'section' => array(self::BELONGS_TO, 'Section', 'section_id'),

        );
    }

    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array(

            'permission'=>array(
                'class'=>'application.modules.main.components.PermissionBehavior',
            ),

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'section_id' => Yii::t('app', 'Section'),
            'title' => Yii::t('app', 'Title'),
            'code' => Yii::t('app', 'Code'),
            'tpl' => Yii::t('app', 'Tpl'),
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
        $criteria->compare('t.section_id', $this->section_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->with = "section";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterSave()
    {

        // Запись шаблона в файл

        $file = $this->getFileName();

        file_put_contents($file, $this->tpl);

        //chmod($file, 0777);

        return parent::afterSave();
    }

    public function afterFind()
    {


        // Чтение шаблона из файл

        $file = $this->getFileName();

        if (is_file($file)) $this->tpl = file_get_contents($file);

        return parent::afterFind();


    }

    public function beforeDelete()
    {

        $file = $this->getFileName();

        if (file_exists($file)) unlink($file);

        return parent::beforeDelete();


    }


    public function getFileName()
    {


        return YiiBase::getPathOfAlias('application.views.include_areas') . "/" . $this->code . "-" . $this->id . ".php";

    }

}